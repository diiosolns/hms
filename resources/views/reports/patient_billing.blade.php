<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Billing Report</title>
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
        <h4>Consultation</h4>
        <table class="bill-summary-table">
            <thead>
                <th>Item Name</th>
                <th>Qnty</th>
                <th>Billed</th>
                <th>Paid</th>
                <th>Exempt.</th>
                <th>Promise</th>
                <th>Payable</th>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><strong>Consultation subtotal</strong></td>
                    <td><strong></strong></td>
                    <td><strong></strong></td>
                    <td><strong></strong></td>
                    <td><strong></strong></td>
                    <td><strong></strong></td>
                    <td><strong></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h4>Laboratory</h4>
    </div>

    <div class="card">
        <h4>Admission</h4>
    </div>

    <div class="card">
        <h4>Pharmacy</h4>
    </div>

    <div class="card">
        <h4>Invoice Details</h4>
        <table class="bill-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice No</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount (TZS)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patient->invoices as $index => $invoice)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $invoice->invoice_number ?? 'N/A' }}</td>
                        <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                        <td>{{ $invoice->description ?? 'Hospital Services' }}</td>
                        <td>{{ number_format($invoice->total_amount, 2) }}</td>
                        <td>{{ ucfirst($invoice->status ?? 'Pending') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">No invoices found for this patient.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <table class="bill-summary-table">
            <thead>
                <tr>
                    <th colspan="2" >Summary</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Billed amount</td>
                    <td style="text-align:right;" ><strong>{{ number_format($patient->invoices->sum('total_amount'), 2) }}</strong></td>
                </tr>
                <tr>
                    <td>Paid amount</td>
                    <td style="text-align:right;" ><strong>{{ number_format(($patient->invoices->sum('total_amount')-$patient->pendingInvoices->sum('total_amount')), 2) }}</strong></td>
                </tr>
                <tr>
                    <td>Returned amount</td>
                    <td style="text-align:right;" ><strong>0.00</strong></td>
                </tr>

                <tr>
                    <td>Exempted amount</td>
                    <td style="text-align:right;" ><strong>0.00</strong></td>
                </tr>
                <tr>
                    <td>Promissed to pay</td>
                    <td style="text-align:right;" ><strong>0.00</strong></td>
                </tr>
                <tr>
                    <td>Payerble amount</td>
                    <td style="text-align:right;" ><strong>{{ number_format($patient->pendingInvoices->sum('total_amount') ?? 0, 2) }}</strong></td>
                </tr>
                <tr>
                    <td>Wallet balance</td>
                    <td style="text-align:right;" ><strong>0.00</strong></td>
                </tr>
                <tr>
                    <td>Refund amount</td>
                    <td style="text-align:right;" ><strong>0.00</strong></td>
                </tr>
            </tbody>
        </table>
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
