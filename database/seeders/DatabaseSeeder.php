<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'nama' => 'ADMIN',
            'username' => 'admin',
            // 'kelas' => 'X RPL 3',
            // 'tgl_lahir' => '2000-01-01',
            // 'alamat' => 'kraksaan',
            // 'jenis_kelamin' => 'laki-laki',
            // 'email' => 'admin@gmail.com',
            'image' => 'default.png',
            'role' => 'admin',
            'password' => bcrypt('admin'),
        ]);
        // User::create([
        //     'nama' => 'ADMIN',
        //     'nis' => '111',
        //     'kelas' => 'X RPL 3',
        //     'tgl_lahir' => '2000-01-01',
        //     'alamat' => 'kraksaan',
        //     'jenis_kelamin' => 'laki-laki',
        //     'email' => 'admpn@gmail.com',
        //     'image' => 'par.jpg',
        //     'role' => 'admin',
        //     'password' => bcrypt('111'),
        // ]);

        Kelas::create([
            'nama_kelas' => 'X RPL 1'
        ]);
        Kelas::create([
            'nama_kelas' => 'X RPL 2'
        ]);
        Kelas::create([
            'nama_kelas' => 'X RPL 3'
        ]);

        Mapel::create([
            'nama_mapel' => 'Bahasa Indonesia',
            'kode_mapel' => 'bhs01'
        ]);
    }
}
