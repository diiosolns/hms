<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Treatment Report</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?v1.1.1') }}">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
            color: #333;
        }
        h1, h2, h3 {
            text-align: center;
            margin-bottom: 5px;
        }
        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .info-table, .bill-table, .signature-table, .bill-summary-table {
            width: 100%;
            border: 0.5px solid #ccc;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 6px 8px;
        }
        .bill-table th, .bill-table td {
            border: 0.5px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .bill-table th {
            background-color: #f0f0f0;
        }

        .signature-table {
            border: 1px solid #ccc; 
            border-collapse: collapse;
        }

        .signature-table th, .signature-table td {
            text-align: center;
        }

        .signature-table th {
            padding: 8px;
            background-color: #f0f0f0;
        }


        .bill-summary {
            border: 1px solid #ccc; 
        }

        .bill-summary-table {
            border: 1px solid #ccc; 
            border-collapse: collapse;
        }

        .bill-summary-table th, .bill-summary-table td {
            text-align: left;
        }

        .bill-summary-table th {
            padding: 8px;
            background-color: #f0f0f0;
        }

        .bill-summary-table td {
            padding: 8px;
        }

        .bill-summary-table tr {
            border-bottom: 0.5px solid #ccc; 
        }

        .summary {
            text-align: right;
            margin-top: 20px;
        }
        .card {
            margin-top: 20px;
            text-align: left !important;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 40px;
            border-top: 1px solid #aaa;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $patient->branch->name ?? 'Hospital Name' }}</h1>
        <h3>Patient Billing Report</h3>
        <p style="text-align:center;">{{ $patient->branch->address ?? '' }}</p>
        <p style="text-align:center;">Generated on {{ now()->format('d M Y') }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>File No:</strong> {{ $patient->patient_id }}</td>
            <td><strong>Patient Name:</strong> {{ $patient->first_name ?? 'N/A' }} {{ $patient->last_name ?? '' }}</td>
        </tr>
        <tr>
            <td><strong>Doctor:</strong> {{ $patient->doctor->first_name ?? 'N/A' }} {{ $patient->doctor->last_name ?? 'N/A' }}</td>
            <td><strong>Branch:</strong> {{ $patient->branch->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Phone #:</strong> {{ $patient->phone ?? 'N/A' }} </td>
            <td><strong>Age & Sex:</strong> {{ $patient->gender ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Contact Person:</strong> {{ $patient->emergency_contact_name ?? 'N/A' }} </td>
            <td><strong>Contact Phone #:</strong> {{ $patient->emergency_contact_phone ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Sponsor:</strong> {{ $patient->pay_method }}</td>
            <td><strong>Visit Date:</strong> {{ $patient->created_at->format('d/m/Y') }}</td>
        </tr>
    </table>

    <div class="card">
        <h4>Nurse Vitals</h4>
        <table class="bill-summary-table">
            <thead>
                <tr>
                    <th>Assessent item</th>
                    <th style="text-align:right;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Body Temperature</td>
                    <td style="text-align:right;" ><strong>{{ optional($patient->nurseTriageAssessments->last())->body_temperature ?? 'NIL' }}</strong></td>
                </tr>
                <tr>
                    <td>Blood Pressure</td>
                    <td style="text-align:right;" ><strong>{{ optional($patient->nurseTriageAssessments->last())->blood_pressure_systolic ?? 'NIL' }} / {{ optional($patient->nurseTriageAssessments->last())->blood_pressure_diastolic ?? 'NIL' }}</strong></td>
                </tr>
                <tr>
                    <td>Heart Rate</td>
                    <td style="text-align:right;" ><strong>{{ optional($patient->nurseTriageAssessments->last())->heart_rate ?? 'NIL' }}</strong></td>
                </tr>

                <tr>
                    <td>Respiratory Rate</td>
                    <td style="text-align:right;" ><strong>{{ optional($patient->nurseTriageAssessments->last())->respiratory_rate ?? 'NIL' }}</strong></td>
                </tr>
                <tr>
                    <td>Weight (Kg)</td>
                    <td style="text-align:right;" ><strong>{{ optional($patient->nurseTriageAssessments->last())->weight_kg ?? 'NIL' }}</strong></td>
                </tr>
                <tr>
                    <td>Height (Cm)</td>
                    <td style="text-align:right;" ><strong>{{ optional($patient->nurseTriageAssessments->last())->height_cm ?? 'NIL' }}</strong></td>
                </tr>
                <tr>
                    <td>Chief complaint</td>
                    <td style="text-align:right;" ><strong>{{ optional($patient->nurseTriageAssessments->last())->chief_complaint ?? 'NIL' }}</strong></td>
                </tr>
                <tr>
                    <td>Nurse Remarks</td>
                    <td style="text-align:right;" ><strong>{{ optional($patient->nurseTriageAssessments->last())->notes ?? 'NIL' }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h4>Medical Records</h4>
        <table class="bill-summary-table">
            <thead>
                <tr>
                    <th>Item name</th>
                    <th>Doctor remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Chief Complaint</td>
                    <td>{{ $patient->medicalRecords[0]->chief_complaint ?? 'NILL' }}</td>
                </tr>
                <tr>
                    <td>Diagnosis</td>
                    <td>{{ $patient->medicalRecords[0]->diagnosis ?? 'NILL' }}</td>
                </tr>
                <tr>
                    <td>Treatment Plan</td>
                    <td>{{ $patient->medicalRecords[0]->treatment_plan ?? 'NILL' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h4>Laboratory Tests</h4>
    </div>

    <div class="card">
        <h4>Prescriptions</h4>
    </div>

    

    <div class="card">
        <table class="signature-table">
            <thead>
                <tr>
                    <th>Prepared by:</th>
                    <th>Authorized by:</th>
                    <th>Approved by:</th>
                    <th>Printed by:</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="4" style="height: 40px; border: none;"></td></tr>
                <tr>
                    <td>......................</td>
                    <td>......................</td>
                    <td>......................</td>
                    <td>......................</td>
                </tr>
                <tr>
                    <td>{{ Auth::user()->last_name ?? 'System' }} {{ Auth::user()->last_name ?? '' }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ Auth::user()->last_name ?? 'System' }} {{ Auth::user()->last_name ?? '' }}</td>
                </tr>
                <tr>
                    <td>{{ date('Y-m-d') }}</td>
                    <td>{{ date('Y-m-d') }}</td>
                    <td>{{ date('Y-m-d') }}</td>
                    <td>{{ date('Y-m-d') }}</td>
                </tr>
                <tr><td colspan="4"></td></tr>
            </tbody>
        </table>
    </div>



    <div class="footer">
        <p>Confidential: This report is generated by the Hospital Management System.</p>
        <p>© {{ date('Y') }} {{ $patient->branch->name ?? 'Your Hospital Name' }}. All rights reserved.</p>
    </div>

</body>
</html>
