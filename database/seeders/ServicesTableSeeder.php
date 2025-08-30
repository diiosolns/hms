<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        $servicesCatalog = [
            // Consultations
            ['code' => 'CON_GEN', 'name' => 'General Doctor Consultation', 'category' => 'Consultation', 'fee' => 20000, 'status' => 'Active'],
            ['code' => 'CON_SPEC', 'name' => 'Specialist Consultation', 'category' => 'Consultation', 'fee' => 50000, 'status' => 'Active'],
            ['code' => 'CON_FUP', 'name' => 'Follow-up Visit', 'category' => 'Consultation', 'fee' => 15000, 'status' => 'Active'],

            // Laboratory
            ['code' => 'LAB_CBC', 'name' => 'Complete Blood Count (CBC)', 'category' => 'Laboratory', 'fee' => 15000, 'status' => 'Active'],
            ['code' => 'LAB_MAL', 'name' => 'Malaria Test', 'category' => 'Laboratory', 'fee' => 5000, 'status' => 'Active'],
            ['code' => 'LAB_HIV', 'name' => 'HIV Test', 'category' => 'Laboratory', 'fee' => 10000, 'status' => 'Active'],
            ['code' => 'LAB_URA', 'name' => 'Urinalysis', 'category' => 'Laboratory', 'fee' => 8000, 'status' => 'Active'],
            ['code' => 'LAB_BSU', 'name' => 'Blood Sugar', 'category' => 'Laboratory', 'fee' => 6000, 'status' => 'Active'],
            ['code' => 'LAB_LFT', 'name' => 'Liver Function Test', 'category' => 'Laboratory', 'fee' => 20000, 'status' => 'Active'],

            // Radiology
            ['code' => 'RAD_XRAY', 'name' => 'X-Ray', 'category' => 'Radiology', 'fee' => 25000, 'status' => 'Active'],
            ['code' => 'RAD_US', 'name' => 'Ultrasound', 'category' => 'Radiology', 'fee' => 30000, 'status' => 'Active'],
            ['code' => 'RAD_CT', 'name' => 'CT Scan', 'category' => 'Radiology', 'fee' => 120000, 'status' => 'Active'],
            ['code' => 'RAD_MRI', 'name' => 'MRI Scan', 'category' => 'Radiology', 'fee' => 250000, 'status' => 'Active'],

            // Pharmacy
            ['code' => 'PHAR_DISP', 'name' => 'Drug Dispensing Fee', 'category' => 'Pharmacy', 'fee' => 5000, 'status' => 'Active'],
            ['code' => 'PHAR_INJ', 'name' => 'Injection Fee', 'category' => 'Pharmacy', 'fee' => 8000, 'status' => 'Active'],

            // Nursing / Procedures
            ['code' => 'NUR_DRS', 'name' => 'Dressing', 'category' => 'Nursing', 'fee' => 10000, 'status' => 'Active'],
            ['code' => 'NUR_IV', 'name' => 'IV Fluid Administration', 'category' => 'Nursing', 'fee' => 7000, 'status' => 'Active'],
            ['code' => 'NUR_IMM', 'name' => 'Immunization', 'category' => 'Nursing', 'fee' => 12000, 'status' => 'Active'],
            ['code' => 'NUR_BTR', 'name' => 'Blood Transfusion', 'category' => 'Nursing', 'fee' => 40000, 'status' => 'Active'],

            // Admission
            ['code' => 'ADM_GEN', 'name' => 'General Ward Bed (per day)', 'category' => 'Admission', 'fee' => 30000, 'status' => 'Active'],
            ['code' => 'ADM_PRI', 'name' => 'Private Ward Bed (per day)', 'category' => 'Admission', 'fee' => 80000, 'status' => 'Active'],
            ['code' => 'ADM_ICU', 'name' => 'ICU Bed (per day)', 'category' => 'Admission', 'fee' => 150000, 'status' => 'Active'],

            // Others
            ['code' => 'OTH_AMB', 'name' => 'Ambulance Service', 'category' => 'Other', 'fee' => 50000, 'status' => 'Active'],
            ['code' => 'OTH_MEDREP', 'name' => 'Medical Report / Certificate', 'category' => 'Other', 'fee' => 20000, 'status' => 'Active'],
        ];

        $hospitals = DB::table('hospitals')->get();

        foreach ($hospitals as $hospital) {
            $branches = DB::table('branches')->where('hospital_id', $hospital->id)->get();

            foreach ($branches as $branch) {
                foreach ($servicesCatalog as $service) {
                    DB::table('services')->updateOrInsert(
                        [
                            'code'        => $service['code'],
                            'hospital_id' => $hospital->id,
                            'branch_id'   => $branch->id,
                        ],
                        [
                            'name'        => $service['name'],
                            'category'    => $service['category'],
                            'fee'         => $service['fee'],
                            'hospital_id' => $hospital->id,
                            'branch_id'   => $branch->id,
                            'created_at'  => now(),
                            'updated_at'  => now(),
                        ]
                    );
                }
            }
        }
    }
}
