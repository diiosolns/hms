<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\NurseTriageAssessment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;
use App\Models\LabRequest;
use App\Models\LabRequestTest;
use App\Models\Prescription;
use App\Models\LabTest;
use App\Models\PharmacyItem;


class PatientController extends Controller
{
    /**
     * Display a listing of the patients, with search and filtering.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // Start with a base query on the Patient model
        $query = Patient::query()->where('branch_id', Auth::user()->branch_id);

        // Apply role-based filtering
        $user = Auth::user();
        if ($user->role === 'nurse') {
            $query->where('status', 'Nurse');
        } else if ($user->role === 'doctor') {
            $query->where('status', 'Doctor');
            $query->where('doctor_id', Auth::id());
        } else if ($user->role === 'lab_technician') {
            $query->where('status', 'Laboratory');
            $query->where('doctor_id', Auth::id());
        } else if ($user->role === 'pharmacist') {
            $query->where('status', 'Pharmacy');
            $query->where('doctor_id', Auth::id());
        }

        // Check for a search query from the request
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);

            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%")
                  ->orWhere('phone', 'like', "%{$searchTerm}%");
            });
        }

        // Apply filtering based on specific field & value
        if ($request->filled('filter_field') && $request->filled('filter_value')) {
            $query->where($request->filter_field, $request->filter_value);
        }

        // Order newest to oldest
        $patients = $query->latest('created_at')->paginate(10);

        return view('patients.index', [
            'patients' => $patients,
            'searchTerm' => $request->search,
        ]);
    }


    /**
     * Show the form for creating a new patient.
     *
     * @return View
     */
    public function create(): View
    {
        $user = Auth::user();

        // Get doctors for the same hospital and branch
        $doctors = User::where('role', 'doctor')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();

        // Get active services
        $services = Service::where('status', 'Active')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();

        return view('patients.create', compact( 'doctors', 'services'));
    }

    /**
     * Store a newly created patient in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $service = Service::findOrFail($request->service_id);
        
        // Validate the incoming request data
        $validatedData = $request->validate([
            'hospital_id' => 'nullable|integer|exists:hospitals,id',
            'branch_id' => 'nullable|integer|exists:branches,id',
            'doctor_id' => 'required|integer|exists:users,id',
            'patient_id' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
            'pay_method' => 'nullable|string',
            'service_id' => 'nullable|integer|exists:services,id',
        ]);

        // Step 1: Create the patient
        $patient = Patient::create($validatedData);

        // Step 2: Generate patient_id and assign branch
        $patient->patient_id = 'PNT' . str_pad($patient->id, 6, '0', STR_PAD_LEFT);
        $patient->branch_id = Auth::user()->branch_id;
        $patient->save();

        // Step 3: Create default appointment for this patient
        $service = Service::findOrFail($request->service_id);
        $appointment = Appointment::create([
            'hospital_id' => $request->hospital_id,
            'branch_id' => $request->branch_id,
            'patient_id' => $patient->id,
            'doctor_id' => Auth::user()->id, // assign logged-in user as doctor, adjust as needed
            'service_id' => $request->service_id,
            'appointment_date' => now()->toDateString(),
            'appointment_time' => now()->toTimeString(),
            'reason' => $service->name,
            'status' => 'Scheduled',
        ]);

        // Step 4: Create an invoice
        $service = Service::findOrFail($request->service_id);
        $invoice = Invoice::create([
            'patient_id'   => $patient->id,
            'user_id'      => Auth::user()->id,
            'invoice_number' => 'INV' . uniqid(), // temporary unique value
            'invoice_date' => now()->toDateString(),
            'total_amount' => $service->fee,
            'status'       => 'Pending',
        ]);

        $invoiceNumber = 'INV' . str_pad($invoice->id, 8, '0', STR_PAD_LEFT);
        $invoice->update(['invoice_number' => $invoiceNumber]);

        // step 5: Add Invoice items
        $invoiceitem = invoiceitem::create([
            'invoice_id' => $invoice->id,
            'description' => $service->name,
            'quantity' => 1,
            'unit_price' => $service->fee,
            'total' => $service->fee,
        ]);

        // Step 4: Create nurse triage assessment with NULL results
        if ($request->has('avoid_nurse') && $request->avoid_nurse === 'yes') {
            // Do not create nurse Assessment
        } else {
            //Update Patient status
            $patient->status = "Nurse";
            $patient->save();

            NurseTriageAssessment::create([
                'patient_id' => $patient->id,
                'appointment_id' => $appointment->id,
                'nurse_id' => Auth::user()->id,
                'body_temperature' => null,
                'blood_pressure_systolic' => null,
                'blood_pressure_diastolic' => null,
                'heart_rate' => null,
                'respiratory_rate' => null,
                'weight_kg' => null,
                'height_cm' => null,
                'chief_complaint' => null,
                'notes' => null,
            ]);
        }

        // Step 5: Redirect with success message
        //return redirect()->route('patients.index')->with('success', 'Patient record, appointment, and nurse assessment created successfully.');

        // Redirect to the patient show page
        return redirect()->route('patients.show', $patient->id)->with('success', 'Patient record created successfully.');
    }

    /**
     * Display the specified patient.
     *
     * @param Patient $patient
     * @return View
     */
    public function show($id)
    {
        $user = Auth::user();
        
        // Find patient by id or fail with 404
        $patient = Patient::with([
            'branch', 
            'appointments', 
            'nurseTriageAssessments', 
            'medicalRecords', 
            'LabRequests',
            'prescriptions',
            'doctor',
            'appointments',
            'invoices',
            'pendingInvoices',
            'labRequestTests'
        ])->findOrFail($id);

        //dd($patient);

        // Total of all invoices
        $totalInvoices = $patient->invoices->sum('total_amount');

        // Total of pending invoices
        $totalPendingInvoices = $patient->pendingInvoices->sum('total_amount');

        $doctors = User::with('pending_patients')
               ->where('role', 'Doctor')
               ->where('branch_id', Auth::user()->branch_id)
               ->paginate(20);

        // Get active services
        $services = Service::where('status', 'Active')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();

        // Get active availableTests
        $availableTests = LabTest::where('status', 'Active')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();

        // Get active pharmacyItems
        $pharmacyItems = PharmacyItem::where('status', 'Active')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();


        return view('patients.show', compact('patient', 'doctors', 'totalInvoices', 'totalPendingInvoices', 'services', 'availableTests', 'pharmacyItems'));
    }


    public function assignDoctor(Request $request, User $doctor)
    {
        $patientId = $request->input('patient_id');

        $patient = Patient::findOrFail($patientId);

        $patient->update([
            'doctor_id' => $doctor->id,
            'status' => 'Doctor',
        ]);

        //dd($update );

        return redirect()->back()->with('success', 'Patient assigned to Dr. '.$doctor->first_name.' successfully.');
    }

    public function directLab($id)
    {
        $user = Auth::user();
        $labtech = User::where('role', 'lab_technician')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->first();

        $patient = Patient::findOrFail($id);

        // If no pharmacist found, assign doctor_id to logged in user
        $assignedUserId = $labtech ? $labtech->id : $user->id;

        $patient->update([
            'status' => 'Laboratory',
        ]);

        return redirect()->back()->with('success', 'Patient assigned to Laboratory successfully.');
    }

    public function directPharmacy($id)
    {
        $user = Auth::user();

        // Try to get pharmacist
        $pharmacist = User::where('role', 'pharmacist')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->first();

        $patient = Patient::findOrFail($id);

        // If no pharmacist found, assign doctor_id to logged in user
        $assignedUserId = $pharmacist ? $pharmacist->id : $user->id;

        $patient->update([
            'status' => 'Pharmacy',
        ]);

        return redirect()->back()->with('success', 'Patient assigned to Pharmacy successfully.');
    }


    public function directReception($id)
    {
        $user = Auth::user();

        // Try to get receptionist
        $receptionist = User::where('role', 'receptionist')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->first();

        $patient = Patient::findOrFail($id);

        // If no receptionist found, assign doctor_id to logged in user
        $assignedUserId = $receptionist ? $receptionist->id : $user->id;

        $patient->update([
            'status' => 'Reception',
        ]);

        return redirect()->route('doctor.patients')->with('success', 'Patient assigned to Pharmacy successfully.');
    }

    /**
     * Show the form for editing the specified patient.
     *
     * @param Patient $patient
     * @return View
     */
    public function edit($id): View
    {
        $user = Auth::user();

        $patient = Patient::findOrFail($id);

        // Get doctors for the same hospital and branch
        $doctors = User::where('role', 'doctor')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();

        // Get active services
        $services = Service::where('status', 'Active')
            ->where('hospital_id', $user->hospital_id)
            ->where('branch_id', $user->branch_id)
            ->get();

        return view('patients.edit', compact( 'patient', 'doctors', 'services'));
    }


    /**
     * Update the specified patient in storage.
     *
     * @param Request $request
     * @param Patient $patient
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validate all editable fields
        $validatedData = $request->validate([
            'first_name'              => 'required|string|max:50',
            'last_name'               => 'required|string|max:50',
            'date_of_birth'           => 'nullable|date',
            'gender'                  => 'nullable|in:Male,Female,Other',
            'phone'                   => 'nullable|string|max:15',
            'email'                   => 'nullable|email|max:100',
            'address'                 => 'nullable|string|max:255',
            'emergency_contact_name'  => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:15',
            'pay_method'              => 'nullable|in:Cash,Insurance',
            'status'                  => 'nullable|in:Reception,Nurse,Doctor,Laboratory,Pharmacy,Closed,Discharged,Cancelled',
        ]);

        // Find patient
        $patient = Patient::findOrFail($id);

        // Update with validated data
        $patient->update($validatedData);


        // Step 4: Create an invoice
        $service = Service::findOrFail($request->service_id);
        // Create or update invoice
        $invoice = Invoice::updateOrCreate(
            [
                'patient_id' => $patient->id,
                'status'     => 'Pending',
            ],
            [
                'user_id'        => Auth::id(),
                'invoice_number' => 'INV' . uniqid(),
                'invoice_date'   => now()->toDateString(),
                'total_amount'   => $service->fee,
            ]
        );

        $invoiceNumber = 'INV' . str_pad($invoice->id, 8, '0', STR_PAD_LEFT);
        $invoice->update(['invoice_number' => $invoiceNumber]);

        // Create or update the item (example: using service_id to match)
        $invoice->items()->updateOrCreate(
            ['description' => $service->name], // condition
            [
                'quantity'   => 1,
                'unit_price' => $service->fee,
                'total'      => $service->fee,
            ]
        );

        // Step 4: Create nurse triage assessment with NULL results
       if ($request->has('avoid_nurse') && $request->avoid_nurse === 'yes') {
            // delete if avoid_nurse is yes
            NurseTriageAssessment::where('patient_id', $patient->id)
                ->where('status', 'Pending')
                ->delete();
        } else {
            //Update Patient status
            $patient->status = "Nurse";
            $patient->update();
            // update or create
            NurseTriageAssessment::updateOrCreate(
                [
                    'patient_id' => $patient->id,
                    'status' => 'Pending', 
                ],
                [
                    'nurse_id' => Auth::user()->id,
                    'body_temperature' => null,
                    'blood_pressure_systolic' => null,
                    'blood_pressure_diastolic' => null,
                    'heart_rate' => null,
                    'respiratory_rate' => null,
                    'weight_kg' => null,
                    'height_cm' => null,
                    'chief_complaint' => null,
                    'notes' => null,
                ]
            );
        }

        // Redirect back
        return redirect()->route('patients.index')
                         ->with('success', 'Patient record updated successfully.');
    }


    /**
     * Remove the specified patient from storage.
     *
     * @param Patient $patient
     * @return RedirectResponse
     */
    public function destroy(Patient $patient): RedirectResponse
    {
        // Delete the patient record
        $patient->delete();

        // Redirect with a success message
        return redirect()->route('patients.index')
                         ->with('success', 'Patient record deleted successfully.');
    }


   public function search(Request $request)
    {
        $query = $request->input('q');

        $patients = Patient::when($query, function ($q) use ($query) {
            $q->where('first_name', 'like', "%{$query}%")
              ->orWhere('last_name', 'like', "%{$query}%")
              ->orWhere('phone', 'like', "%{$query}%");
        })->get();

        return view('patients.search', compact('patients', 'query'));
    }



}
