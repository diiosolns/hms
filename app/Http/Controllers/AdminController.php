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

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        /*$patients = Patient::where('status', 'Nurse')
            ->where('branch_id', Auth::user()->branch_id)
            ->paginate(10);*/

        $patients = Patient::where('branch_id', Auth::user()->branch_id)
            ->whereHas('nurseTriageAssessments', function ($query) {
                $query->where('status', 'Pending');
            })->paginate(10);

        return view('admin.dashboard', compact('patients'));
    }


    //------------------------------------------------------------------------------------------------------------------
    // USER MANAGEMENT
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
        $roles = ['doctor', 'nurse', 'receptionist', 'admin', 'pharmacist', 'lab_technician'];

        return view('admin.employees.create', compact('hospitals', 'roles'));
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'role' => ['required', 'string', Rule::in(['doctor', 'nurse', 'receptionist', 'admin', 'pharmacist','lab_technician'])],
            'room' => 'nullable|string|min:1',
            'hospital_id' => 'required|exists:hospitals,id',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        // Create a new User record for the employee.
        $create = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $request->password, // Mutator will handle hashing
            'role' => $validated['role'],
            'room' => $validated['room'],
            'hospital_id' => $validated['hospital_id'],
            'branch_id' => $validated['branch_id'] ?? null,
        ]);

        return redirect()->route('admin.employees.manage')->with('success', 'Employee created successfully!');
        }

        /**
         * Display a listing of the employees for the admin.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\View\View
         */
        public function manageEmployees(Request $request)
        {

            $loggedUser = auth()->user();

            $employees = User::with('hospital', 'branch')
                ->where('hospital_id', $loggedUser->hospital_id)
                ->where('branch_id', $loggedUser->branch_id)
                ->paginate(10); // Adjust pagination as needed

            // Pass the employees and any current filters to the view.
            return view('admin.employees.manage', compact('employees'));
        }

        /**
         * Show the form for editing the specified employee.
         *
         * @param  \App\Models\User  $user
         * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
         */
        public function editEmployee(User $user)
        {
            // Authorization check: Ensure the admin can edit this employee.
            // The employee must belong to one of the admin's hospitals or branches.
            $hospitalIds = Auth::user()->hospitals->pluck('id');
            if (!in_array($user->hospital_id, $hospitalIds)) {
                 abort(403, 'Unauthorized action.');
            }

            $hospitals = Auth::user()->hospitals()->with('branches')->get();
            $roles = ['doctor', 'nurse', 'receptionist', 'admin'];

            return view('admin.employees.edit', compact('user', 'hospitals', 'roles'));
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
            // Authorization check: Ensure the admin can edit this employee.
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

            return redirect()->route('admin.employees.manage')->with('success', 'Employee updated successfully!');
        }

        /**
         * Remove the specified employee from the database.
         *
         * @param  \App\Models\User  $user
         * @return \Illuminate\Http\RedirectResponse
         */
        public function destroyEmployee(User $user)
        {
            // Authorization check: Ensure the admin can delete this employee.
            $hospitalIds = Auth::user()->hospitals->pluck('id')->toArray();
            if (!in_array($user->hospital_id, $hospitalIds)) {
                 abort(403, 'Unauthorized action.');
            }

            $user->delete();

            return redirect()->route('admin.employees.manage')->with('success', 'Employee deleted successfully!');
        }





}
