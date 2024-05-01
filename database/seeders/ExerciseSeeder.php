<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('exercises')->insert([
            [
                'exercise_name' => 'Loncat Bintang',
                'time' => '20 detik',
                'instructions' => 'Mulai dari posisi berdiri dengan kaki rapat, lalu lompat dengan kaki terbuka dan telapak tangan bersentuhan di atas kepala. Kembali ke posisi awal dan lakukan babak berikutnya. Latihan ini memberikan olahraga seluruh tubuh dan menggerakkan semua kelompok otot besar Anda.',
                'set_type_id' => '2',
                'body_mass_standard_id' => '2',
                'created_at' => date("Y-m-d H:i:s", time()),
                'updated_at' => date("Y-m-d H:i:s", time()),
            ],
            [
                'exercise_name' => 'Crunch Perut',
                'time' => 'x16',
                'instructions' => 'Berbaring di punggung Anda dengan lutut ditekuk dan telapak tangan di bawah kepala. Kemudian angkat bahu Anda dari lantai. Pertahankan selama beberapa detik dan perlahan-lahan kembali ke posisi awal. Latihan ini terutama bekerja di otot rektus abdominis dan otot oblik.',
                'set_type_id' => '1',
                'body_mass_standard_id' => '2',
                'created_at' => date("Y-m-d H:i:s", time()),
                'updated_at' => date("Y-m-d H:i:s", time()),
            ],
        ]);
    }
}
