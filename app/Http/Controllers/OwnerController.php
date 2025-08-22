<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Branch;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OwnerController extends Controller
{
    /**
     * Display the owner's dashboard.
     *
     * @return \Illuminate\View\View
     */
     public function dashboard()
    {
        // Get the authenticated owner.
        $owner = Auth::user();

        // Ensure the user is an owner before proceeding.
        if ($owner->role !== 'owner') {
            // Redirect or return an error if the user is not an owner.
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        // Get the hospitals belonging to the owner using the ownedHospitals relationship.
        $hospitals = $owner->hospitals;

        // Get the IDs of the hospitals for the queries.
        $hospitalIds = $hospitals->pluck('id');

        // Count total hospitals.
        $totalHospitals = $hospitals->count();

        // Get all branches associated with the owner's hospitals.
        // We use a "whereIn" query on the `hospital_id` to get the branches efficiently.
        $branches = Branch::whereIn('hospital_id', $hospitalIds)->get();

        // Get the IDs of the branches for the other queries.
        $branchIds = $branches->pluck('id');

        // Count total branches.
        $totalBranches = $branches->count();

        // Get the total number of employees, excluding the 'owner' role, within these branches.
        $totalEmployees = User::whereIn('branch_id', $branchIds)
            ->where('role', '!=', 'owner')
            ->count();

        // Get the total number of patients associated with the owner's hospitals.
        $totalPatients = Patient::whereIn('branch_id', $hospitalIds)->count();

        // Pass data to the dashboard view.
        return view('owner.dashboard', compact('totalHospitals', 'totalBranches', 'totalEmployees', 'totalPatients'));
    }

    //------------------------------------------------------------------------------------------------------------------
    // HOSPITAL MANAGEMENT
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Show the form for creating a new hospital.
     *
     * @return \Illuminate\View\View
     */
    public function createHospital()
    {
        return view('owner.hospitals.create');
    }

    /**
     * Store a newly created hospital in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeHospital(Request $request)
    {
        // Validate the incoming request data, including contact_number.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:20',
        ]);

        // Get the authenticated user's ID
        $ownerId = Auth::id();

        // Create a new hospital and associate it with the authenticated owner's ID
        // using the validated data.
        Hospital::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'contact_number' => $validated['contact_number'],
            'owner_id' => $ownerId,
        ]);

        return redirect()->route('owner.hospitals.manage')->with('success', 'Hospital created successfully!');
    }

    /**
     * Display a listing of the hospitals for the owner.
     *
     * @return \Illuminate\View\View
     */
    public function manageHospitals()
    {
        // Fetch all hospitals belonging to the authenticated owner.
        $hospitals = Auth::user()->hospitals;

        //dd(Auth::user());

        return view('owner.hospitals.manage', compact('hospitals'));
    }

    /**
     * Show the form for editing the specified hospital.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function editHospital(Hospital $hospital)
    {
        // Ensure the authenticated user is the owner of this hospital.
        if (Auth::id() !== $hospital->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('owner.hospitals.edit', compact('hospital'));
    }

    /**
     * Update the specified hospital in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateHospital(Request $request, Hospital $hospital)
    {
        // Ensure the authenticated user is the owner of this hospital.
        if (Auth::id() !== $hospital->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the incoming request data.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:20',
        ]);

        $hospital->update($validated);

        return redirect()->route('owner.hospitals.manage')->with('success', 'Hospital updated successfully!');
    }

    /**
     * Remove the specified hospital from the database.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyHospital(Hospital $hospital)
    {
        // Ensure the authenticated user is the owner of this hospital.
        if (Auth::id() !== $hospital->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $hospital->delete();

        return redirect()->route('owner.hospitals.manage')->with('success', 'Hospital deleted successfully!');
    }

    //------------------------------------------------------------------------------------------------------------------
    // BRANCH MANAGEMENT
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Show the form for creating a new branch.
     *
     * @return \Illuminate\View\View
     */
    public function createBranch()
    {
        // Get the hospitals for the dropdown in the branch creation form.
        $hospitals = Auth::user()->hospitals;

        return view('owner.branches.create', compact('hospitals'));
    }

    /**
     * Store a newly created branch in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBranch(Request $request)
    {
        // Validate the incoming request data.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);

        // Ensure the selected hospital belongs to the authenticated user.
        $hospital = Auth::user()->hospitals()->find($validated['hospital_id']);
        if (!$hospital) {
            return back()->withErrors(['hospital_id' => 'The selected hospital does not belong to you.']);
        }

        $hospital->branches()->create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'contact_number' => $validated['contact_number'],
        ]);

        return redirect()->route('owner.hospitals.manage')->with('success', 'Branch created successfully!');
    }

    /**
     * Display a listing of the branches for the owner.
     *
     * @return \Illuminate\View\View
     */
    public function manageBranches()
    {
        // Get the owner's hospitals' IDs.
        $hospitalIds = Auth::user()->hospitals->pluck('id');

        // Get all branches that belong to those hospitals.
        $branches = Branch::whereIn('hospital_id', $hospitalIds)->with('hospital')->get();

        return view('owner.branches.manage', compact('branches'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function editBranch(Branch $branch)
    {
        // Ensure the authenticated user is the owner of the branch's hospital.
        if (Auth::id() !== $branch->hospital->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $hospitals = Auth::user()->hospitals;

        return view('owner.branches.edit', compact('branch', 'hospitals'));
    }

    /**
     * Update the specified branch in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBranch(Request $request, Branch $branch)
    {
        // Ensure the authenticated user is the owner of the branch's hospital.
        if (Auth::id() !== $branch->hospital->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the incoming request data.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);

        // Ensure the new hospital also belongs to the owner.
        $newHospital = Auth::user()->hospitals()->find($validated['hospital_id']);
        if (!$newHospital) {
            return back()->withErrors(['hospital_id' => 'The new hospital does not belong to you.']);
        }

        $branch->update($validated);

        return redirect()->route('owner.branches.manage')->with('success', 'Branch updated successfully!');
    }

    /**
     * Remove the specified branch from the database.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyBranch(Branch $branch)
    {
        // Ensure the authenticated user is the owner of the branch's hospital.
        if (Auth::id() !== $branch->hospital->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $branch->delete();

        return redirect()->route('owner.branches.manage')->with('success', 'Branch deleted successfully!');
    }


    //------------------------------------------------------------------------------------------------------------------
    // EMPLOYEE MANAGEMENT
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\View\View
     */
    public function createEmployee()
    {
        // Get the hospitals and their branches for the dropdowns.
        $hospitals = Auth::user()->hospitals()->with('branches')->get();

        // Define the available roles for employees.
        $roles = ['doctor', 'nurse', 'receptionist', 'admin'];

        return view('owner.employees.create', compact('hospitals', 'roles'));
    }

    /**
     * Store a newly created employee in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeEmployee(Request $request)
    {
        // Validate the incoming request data.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', 'string', Rule::in(['doctor', 'nurse', 'receptionist', 'admin'])],
            'hospital_id' => 'required|exists:hospitals,id',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        // Ensure the selected hospital belongs to the authenticated owner.
        $hospital = Auth::user()->hospitals()->find($validated['hospital_id']);
        if (!$hospital) {
            return back()->withErrors(['hospital_id' => 'The selected hospital does not belong to you.']);
        }

        // Create a new User record for the employee.
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'hospital_id' => $validated['hospital_id'],
            'branch_id' => $validated['branch_id'] ?? null,
        ]);

        return redirect()->route('owner.employees.manage')->with('success', 'Employee created successfully!');
    }

    /**
     * Display a listing of the employees for the owner.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function manageEmployees(Request $request)
    {
        // Get the IDs of all hospitals owned by the authenticated user.
        $hospitalIds = Auth::user()->hospitals->pluck('id');

        // Start building the query to fetch employees within the owner's hospitals.
        $query = User::whereIn('hospital_id', $hospitalIds);

        // Check for a search query and apply it.
        $search = $request->query('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Check for a role filter and apply it.
        $roleFilter = $request->query('role');
        if ($roleFilter && $roleFilter !== 'all') {
            $query->where('role', $roleFilter);
        }

        // Fetch all employees belonging to those hospitals or branches.
        $employees = $query->with('hospital', 'branch')->get();

        // Pass the employees and current filter values to the view.
        return view('owner.employees.manage', compact('employees', 'search', 'roleFilter'));
    }

    /**
     * Show the form for editing the specified employee.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function editEmployee(User $user)
    {
        // Authorization check: Ensure the owner can edit this employee.
        // The employee must belong to one of the owner's hospitals or branches.
        $hospitalIds = Auth::user()->hospitals->pluck('id');
        if (!in_array($user->hospital_id, $hospitalIds)) {
             abort(403, 'Unauthorized action.');
        }

        $hospitals = Auth::user()->hospitals()->with('branches')->get();
        $roles = ['doctor', 'nurse', 'receptionist', 'admin'];

        return view('owner.employees.edit', compact('user', 'hospitals', 'roles'));
    }

    /**
     * Update the specified employee in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEmployee(Request $request, User $user)
    {
        // Authorization check: Ensure the owner can edit this employee.
        $hospitalIds = Auth::user()->hospitals->pluck('id');
        if (!in_array($user->hospital_id, $hospitalIds)) {
             abort(403, 'Unauthorized action.');
        }

        // Validate the incoming request data.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', Rule::in(['doctor', 'nurse', 'receptionist', 'admin'])],
            'hospital_id' => 'required|exists:hospitals,id',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        // Ensure the selected hospital/branch belongs to the authenticated user.
        $newHospital = Auth::user()->hospitals()->find($validated['hospital_id']);
        if (!$newHospital) {
            return back()->withErrors(['hospital_id' => 'The selected hospital does not belong to you.']);
        }

        $user->update($validated);

        return redirect()->route('owner.employees.manage')->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified employee from the database.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyEmployee(User $user)
    {
        // Authorization check: Ensure the owner can delete this employee.
        $hospitalIds = Auth::user()->hospitals->pluck('id');
        if (!in_array($user->hospital_id, $hospitalIds)) {
             abort(403, 'Unauthorized action.');
        }

        $user->delete();

        return redirect()->route('owner.employees.manage')->with('success', 'Employee deleted successfully!');
    }
}
