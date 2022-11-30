<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Circle;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Circle::create([
            'name' => 'Apartemen EMTown',
            'address' => 'Tower A No. 26',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eget aliquam felis. Mauris varius posuere justo et tristique. Quisque risus felis, pulvinar vel augue in, suscipit dignissim metus. Cras euismod nunc nec sapien pretium viverra. Quisque rhoncus consectetur arcu quis dictum. Etiam libero tortor, imperdiet vel ullamcorper id, finibus eget purus. Sed eget diam non enim pellentesque ultrices sed et urna. Praesent a leo eget lacus egestas malesuada. Aenean vel consequat lorem. Nullam sed mauris non justo vehicula volutpat. Vestibulum ut porta ipsum.',
            'owner_id' => 1,
        ]);

        Circle::create([
            'name' => 'Kos Putra 1',
            'address' => 'Jalan ABC no. 1',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eget aliquam felis. Mauris varius posuere justo et tristique. Quisque risus felis, pulvinar vel augue in, suscipit dignissim metus. Cras euismod nunc nec sapien pretium viverra. Quisque rhoncus consectetur arcu quis dictum. Etiam libero tortor, imperdiet vel ullamcorper id, finibus eget purus. Sed eget diam non enim pellentesque ultrices sed et urna. Praesent a leo eget lacus egestas malesuada. Aenean vel consequat lorem. Nullam sed mauris non justo vehicula volutpat. Vestibulum ut porta ipsum.',
            'owner_id' => 3,
        ]);

        User::create([
            'name' => 'Vallencius Gavriel',
            'telephone' => '081234567890',
            'email' => 'vallencius@gmail.com',
            'password' => bcrypt('testing12345'),
            'admin' => true,
            'circle_id' => 1
        ]);

        User::create([
            'name' => 'Bonifasius Ariesto Adrian Finantyo',
            'telephone' => '082114188134',
            'email' => 'bonbon@gmail.com',
            'password' => bcrypt('testing12345'),
            'admin' => false,
            'circle_id' => 1
        ]);

        User::create([
            'name' => 'Antonius Kevin',
            'telephone' => '081223111444',
            'email' => 'tonski@gmail.com',
            'password' => bcrypt('testing12345'),
            'admin' => true,
            'circle_id' => 2
        ]);

        User::create([
            'name' => 'Vanness Iwata',
            'telephone' => '082114188664',
            'email' => 'wawa@gmail.com',
            'password' => bcrypt('testing12345'),
            'admin' => false,
            'circle_id' => 2
        ]);

        Package::create([
            'sender' => 'Pak Ali',
            'expedition' => 'Si Capit',
            'resi' => 'TGR08126666',
            'nomorKamar' => '308',
            'photoURL' => 'iniURL/ini.png',
            'user_id' => 2
        ]);

        Package::create([
            'sender' => 'Bu Mamat',
            'expedition' => 'JANE',
            'resi' => 'TGR08111126666',
            'nomorKamar' => '202',
            'photoURL' => 'iniURL/ini.png',
            'user_id' => 4
        ]);

        Package::create([
            'sender' => 'Pak Erte',
            'expedition' => 'JENTE',
            'resi' => 'TGR08331126666',
            'nomorKamar' => '202',
            'photoURL' => 'iniURL/ini.png',
            'user_id' => 4
        ]);
    }
}