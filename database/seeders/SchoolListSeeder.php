<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolList;

class SchoolListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = [
            'SMK DATO\' UNDANG MUSA AL-HAJ',
            'SMK DATO\' UNDANG SYED ALI AL-JUFRI',
            'SMK BAHAU',
            'SMK (FELDA) PASOH 2',
            'SMK SERI PERPATIH PUSAT BANDAR PALONG 4,5 & 6',
            'SMK (FELDA) PALONG DUA',
            'SMK (FELDA) LUI BARAT',
            'SMK (FELDA) PALONG 7',
            'SMK (FELDA) BANDAR BARU SERTING',
            'SMK SERTING HILIR',
            'SMK PALONG SEBELAS (FELDA)',
            'SMK SERI JEMPOL',
            'SMK BAHAU 2',
            'SMK UNDANG JELEBU',
            'SMK PERTANG',
            'SMK CHI WEN (CF)',
            'SMK TERIANG HILIR',
            'SMK DATUK MANSOR',
            'SMK BATU KIKIR',
            'SM RENDAH AGAMA KUALA KLAWANG',
            'SM AGAMA DATO\' HAJI TAN AHMAD',
            'SEKOLAH MENENGAH AGAMA HAJI MUHAMAD'
        ];

        foreach ($schools as $school) {
            SchoolList::create([
                'name' => $school
            ]);
        }
    }
}
