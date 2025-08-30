<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmacyItemsSeeder extends Seeder
{
    public function run()
    {
        $items = [
            // Analgesics / Pain Relief
            [
                'code' => 'PARA500',
                'name' => 'Paracetamol',
                'brand_name' => 'Panadol',
                'category' => 'Analgesic',
                'form' => 'Tablet',
                'strength' => '500mg',
                'unit' => 'Tablet',
                'price' => 50,
                'reorder_level' => 100,
            ],
            [
                'code' => 'IBUP200',
                'name' => 'Ibuprofen',
                'brand_name' => 'Brufen',
                'category' => 'NSAID',
                'form' => 'Tablet',
                'strength' => '200mg',
                'unit' => 'Tablet',
                'price' => 100,
                'reorder_level' => 50,
            ],

            // Antibiotics
            [
                'code' => 'AMOX500',
                'name' => 'Amoxicillin',
                'brand_name' => 'Amoxil',
                'category' => 'Antibiotic',
                'form' => 'Capsule',
                'strength' => '500mg',
                'unit' => 'Capsule',
                'price' => 150,
                'reorder_level' => 200,
            ],
            [
                'code' => 'CIPRO500',
                'name' => 'Ciprofloxacin',
                'brand_name' => 'Ciproxin',
                'category' => 'Antibiotic',
                'form' => 'Tablet',
                'strength' => '500mg',
                'unit' => 'Tablet',
                'price' => 200,
                'reorder_level' => 100,
            ],

            // Antimalarials
            [
                'code' => 'ALU20/120',
                'name' => 'Artemether + Lumefantrine',
                'brand_name' => 'Coartem',
                'category' => 'Antimalarial',
                'form' => 'Tablet',
                'strength' => '20/120mg',
                'unit' => 'Tablet',
                'price' => 300,
                'reorder_level' => 150,
            ],
            [
                'code' => 'QUIN250',
                'name' => 'Quinine',
                'brand_name' => 'Quinimax',
                'category' => 'Antimalarial',
                'form' => 'Injection',
                'strength' => '250mg/ml',
                'unit' => 'Vial',
                'price' => 500,
                'reorder_level' => 50,
            ],

            // Antihypertensives
            [
                'code' => 'ATENO50',
                'name' => 'Atenolol',
                'brand_name' => 'Tenormin',
                'category' => 'Antihypertensive',
                'form' => 'Tablet',
                'strength' => '50mg',
                'unit' => 'Tablet',
                'price' => 250,
                'reorder_level' => 100,
            ],
            [
                'code' => 'NIFE20',
                'name' => 'Nifedipine',
                'brand_name' => 'Adalat',
                'category' => 'Antihypertensive',
                'form' => 'Tablet',
                'strength' => '20mg',
                'unit' => 'Tablet',
                'price' => 200,
                'reorder_level' => 100,
            ],

            // Diabetes
            [
                'code' => 'MET500',
                'name' => 'Metformin',
                'brand_name' => 'Glucophage',
                'category' => 'Antidiabetic',
                'form' => 'Tablet',
                'strength' => '500mg',
                'unit' => 'Tablet',
                'price' => 150,
                'reorder_level' => 100,
            ],
            [
                'code' => 'INSUL100',
                'name' => 'Insulin (Regular)',
                'brand_name' => 'Actrapid',
                'category' => 'Antidiabetic',
                'form' => 'Injection',
                'strength' => '100IU/ml',
                'unit' => 'Vial',
                'price' => 1200,
                'reorder_level' => 20,
            ],

            // Cough / Cold
            [
                'code' => 'COUGH125',
                'name' => 'Cough Syrup',
                'brand_name' => 'Benylin',
                'category' => 'Cough/Cold',
                'form' => 'Syrup',
                'strength' => '125ml',
                'unit' => 'Bottle',
                'price' => 800,
                'reorder_level' => 50,
            ],

            // ORS / Fluids
            [
                'code' => 'ORS20',
                'name' => 'Oral Rehydration Salts',
                'brand_name' => 'ORS Pack',
                'category' => 'Rehydration',
                'form' => 'Sachet',
                'strength' => '20g',
                'unit' => 'Sachet',
                'price' => 100,
                'reorder_level' => 200,
            ],
            [
                'code' => 'NS500',
                'name' => 'Normal Saline',
                'brand_name' => 'NS 0.9%',
                'category' => 'IV Fluid',
                'form' => 'Injection',
                'strength' => '500ml',
                'unit' => 'Bottle',
                'price' => 600,
                'reorder_level' => 50,
            ],
        ];

        $hospitals = DB::table('hospitals')->get();

        foreach ($hospitals as $hospital) {
            $branches = DB::table('branches')->where('hospital_id', $hospital->id)->get();

            foreach ($branches as $branch) {
                foreach ($items as $item) {
                    DB::table('pharmacy_items')->updateOrInsert(
                        [
                            'code'        => $item['code'],
                            'hospital_id' => $hospital->id,
                            'branch_id'   => $branch->id,
                        ],
                        [
                            'name'         => $item['name'],
                            'brand_name'   => $item['brand_name'],
                            'category'     => $item['category'],
                            'form'         => $item['form'],
                            'strength'     => $item['strength'],
                            'unit'         => $item['unit'],
                            'price'        => $item['price'],
                            'reorder_level'=> $item['reorder_level'],
                            'status'       => true,
                            'hospital_id'  => $hospital->id,
                            'branch_id'    => $branch->id,
                            'updated_at'   => now(),
                            'created_at'   => now(),
                        ]
                    );
                }
            }
        }
    }
}
