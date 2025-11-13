<?php

namespace Database\Seeders;

use App\Models\LabResult;
use App\Models\User;
use App\Models\DoctorNote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have at least one doctor and one lab staff
        $doctor = User::firstOrCreate(
            ['email' => 'dr.ahmad@telehealth.com'],
            [
                'name' => 'Dr. Ahmad Fauzi',
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'status' => 'active',
            ]
        );

        $lab = User::firstOrCreate(
            ['email' => 'lab.siti@telehealth.com'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password'),
                'role' => 'lab',
                'status' => 'active',
            ]
        );

        // Example patients
        $patients = [
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@telehealth.com'],
            ['name' => 'Ani Wijaya', 'email' => 'ani.wijaya@telehealth.com'],
            ['name' => 'Citra Dewi', 'email' => 'citra.dewi@telehealth.com'],
        ];

        $patientUsers = [];
        foreach ($patients as $p) {
            $patientUsers[] = User::firstOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['name'],
                    'password' => Hash::make('password'),
                    'role' => 'patient',
                    'status' => 'active',
                ]
            );
        }

        // Create sample lab results (cases)
        $cases = [
            [
                'patient' => $patientUsers[0],
                'test_type' => 'Darah Lengkap',
                'result_value' => "Hemoglobin: 14.5 g/dL\nLeukosit: 7,500/µL\nTrombosit: 250,000/µL",
                'status' => 'completed',
            ],
            [
                'patient' => $patientUsers[1],
                'test_type' => 'Gula Darah',
                'result_value' => "Gula Darah Puasa: 98 mg/dL\n2 Jam PP: 118 mg/dL",
                'status' => 'pending',
            ],
            [
                'patient' => $patientUsers[2],
                'test_type' => 'Kolesterol Total',
                'result_value' => "Kolesterol Total: 185 mg/dL",
                'status' => 'reviewed',
            ],
        ];

        foreach ($cases as $c) {
            $labResult = LabResult::create([
                'patient_id' => $c['patient']->id,
                'doctor_id' => $doctor->id,
                'lab_staff_id' => $lab->id,
                'test_type' => $c['test_type'],
                'result_value' => $c['result_value'],
                'status' => $c['status'],
                'result_file' => null,
            ]);

            if ($c['status'] !== 'pending') {
                DoctorNote::create([
                    'lab_result_id' => $labResult->id,
                    'doctor_id' => $doctor->id,
                    'note' => $c['status'] === 'completed'
                        ? 'Hasil normal, tidak ada tindakan khusus.'
                        : 'Hasil telah direview, pertimbangkan kontrol rutin.',
                ]);
            }
        }
    }
}

