<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabTestSeeder extends Seeder
{
    public function run(): void
    {
        $labTests = [
            // 🩸 Hematology
            ['code' => 'CBC001', 'name' => 'Complete Blood Count (CBC)', 'category' => 'Hematology', 'sample_type' => 'Blood', 'unit' => '', 'normal_range' => '', 'price' => 20000],
            ['code' => 'HB001',  'name' => 'Hemoglobin (Hb)', 'category' => 'Hematology', 'sample_type' => 'Blood', 'unit' => 'g/dL', 'normal_range' => '12–16 g/dL (F), 13–18 g/dL (M)', 'price' => 10000],
            ['code' => 'WBC001', 'name' => 'White Blood Cell Count (WBC)', 'category' => 'Hematology', 'sample_type' => 'Blood', 'unit' => '×10^9/L', 'normal_range' => '4.5–11 ×10^9/L', 'price' => 10000],
            ['code' => 'PLT001', 'name' => 'Platelet Count', 'category' => 'Hematology', 'sample_type' => 'Blood', 'unit' => '×10^9/L', 'normal_range' => '150–450 ×10^9/L', 'price' => 10000],
            ['code' => 'ESR001', 'name' => 'Erythrocyte Sedimentation Rate (ESR)', 'category' => 'Hematology', 'sample_type' => 'Blood', 'unit' => 'mm/hr', 'normal_range' => '< 20 mm/hr', 'price' => 8000],

            // 🧪 Biochemistry
            ['code' => 'GLU001', 'name' => 'Fasting Blood Sugar (FBS)', 'category' => 'Biochemistry', 'sample_type' => 'Blood', 'unit' => 'mmol/L', 'normal_range' => '3.9–5.5 mmol/L', 'price' => 7000],
            ['code' => 'GLU002', 'name' => 'Random Blood Sugar (RBS)', 'category' => 'Biochemistry', 'sample_type' => 'Blood', 'unit' => 'mmol/L', 'normal_range' => '< 7.8 mmol/L', 'price' => 7000],
            ['code' => 'URE001', 'name' => 'Blood Urea', 'category' => 'Biochemistry', 'sample_type' => 'Blood', 'unit' => 'mmol/L', 'normal_range' => '2.5–6.7 mmol/L', 'price' => 9000],
            ['code' => 'CRE001', 'name' => 'Serum Creatinine', 'category' => 'Biochemistry', 'sample_type' => 'Blood', 'unit' => 'µmol/L', 'normal_range' => '60–110 µmol/L (F), 70–120 µmol/L (M)', 'price' => 9000],
            ['code' => 'LFT001', 'name' => 'Liver Function Tests (LFT)', 'category' => 'Biochemistry', 'sample_type' => 'Blood', 'unit' => '', 'normal_range' => '', 'price' => 25000],
            ['code' => 'LIP001', 'name' => 'Lipid Profile', 'category' => 'Biochemistry', 'sample_type' => 'Blood', 'unit' => '', 'normal_range' => '', 'price' => 25000],
            ['code' => 'ELECT001', 'name' => 'Electrolytes (Na, K, Cl)', 'category' => 'Biochemistry', 'sample_type' => 'Blood', 'unit' => 'mmol/L', 'normal_range' => '', 'price' => 20000],

            // 🦠 Microbiology
            ['code' => 'UC001', 'name' => 'Urine Culture', 'category' => 'Microbiology', 'sample_type' => 'Urine', 'unit' => '', 'normal_range' => 'No growth', 'price' => 15000],
            ['code' => 'BC001', 'name' => 'Blood Culture', 'category' => 'Microbiology', 'sample_type' => 'Blood', 'unit' => '', 'normal_range' => 'No growth', 'price' => 20000],
            ['code' => 'SC001', 'name' => 'Sputum Culture', 'category' => 'Microbiology', 'sample_type' => 'Sputum', 'unit' => '', 'normal_range' => 'No growth', 'price' => 15000],
            ['code' => 'SWC001', 'name' => 'Wound Swab Culture', 'category' => 'Microbiology', 'sample_type' => 'Swab', 'unit' => '', 'normal_range' => 'No growth', 'price' => 15000],
            ['code' => 'STL001', 'name' => 'Stool Microscopy', 'category' => 'Microbiology', 'sample_type' => 'Stool', 'unit' => '', 'normal_range' => 'No parasites/ova', 'price' => 12000],

            // 🧬 Immunology / Serology
            ['code' => 'HIV001', 'name' => 'HIV Test', 'category' => 'Immunology', 'sample_type' => 'Blood', 'unit' => '', 'normal_range' => 'Negative', 'price' => 10000],
            ['code' => 'HBV001', 'name' => 'Hepatitis B Surface Antigen (HBsAg)', 'category' => 'Immunology', 'sample_type' => 'Blood', 'unit' => '', 'normal_range' => 'Negative', 'price' => 12000],
            ['code' => 'VDRL001', 'name' => 'VDRL (Syphilis)', 'category' => 'Immunology', 'sample_type' => 'Blood', 'unit' => '', 'normal_range' => 'Non-reactive', 'price' => 10000],
            ['code' => 'CRP001', 'name' => 'C-Reactive Protein (CRP)', 'category' => 'Immunology', 'sample_type' => 'Blood', 'unit' => 'mg/L', 'normal_range' => '< 10 mg/L', 'price' => 12000],
            ['code' => 'RF001',  'name' => 'Rheumatoid Factor (RF)', 'category' => 'Immunology', 'sample_type' => 'Blood', 'unit' => 'IU/mL', 'normal_range' => '< 20 IU/mL', 'price' => 12000],

            // 🧬 Molecular / Advanced
            ['code' => 'PCR001', 'name' => 'PCR – COVID-19', 'category' => 'Molecular', 'sample_type' => 'Swab', 'unit' => '', 'normal_range' => 'Not detected', 'price' => 50000],
            ['code' => 'PCR002', 'name' => 'PCR – Tuberculosis (GeneXpert)', 'category' => 'Molecular', 'sample_type' => 'Sputum', 'unit' => '', 'normal_range' => 'Not detected', 'price' => 60000],
            ['code' => 'DNA001', 'name' => 'DNA Test', 'category' => 'Molecular', 'sample_type' => 'Blood/Swab', 'unit' => '', 'normal_range' => '', 'price' => 80000],
        ];

        // 1️⃣ Insert master lab tests
        foreach ($labTests as $test) {
            // 2️⃣ Loop through all hospitals and branches
            $hospitals = DB::table('hospitals')->get();
            foreach ($hospitals as $hospital) {
                $branches = DB::table('branches')->where('hospital_id', $hospital->id)->get();
                foreach ($branches as $branch) {
                    DB::table('lab_tests')->insert([
                        'hospital_id' => $hospital->id,
                        'branch_id' => $branch->id,
                        'code' => $test['code'],
                        'name' => $test['name'],
                        'category' => $test['category'],
                        'description' => $test['name'],
                        'sample_type' => $test['sample_type'],
                        'method' => null,
                        'normal_range' => $test['normal_range'],
                        'unit' => $test['unit'],
                        'price' => $test['price'],
                        'status' => 'Active',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}

