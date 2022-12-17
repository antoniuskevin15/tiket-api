<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Circle;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'photoURL' => 'https://www.summareconbekasi.com/public/images/gallery/article/14000/mtown-fc3.jpghttps://www.summareconbekasi.com/public/images/gallery/article/14000/mtown-fc3.jpg'
        ]);

        Circle::create([
            'name' => 'Kos Putra 1',
            'address' => 'Jalan ABC no. 1',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eget aliquam felis. Mauris varius posuere justo et tristique. Quisque risus felis, pulvinar vel augue in, suscipit dignissim metus. Cras euismod nunc nec sapien pretium viverra. Quisque rhoncus consectetur arcu quis dictum. Etiam libero tortor, imperdiet vel ullamcorper id, finibus eget purus. Sed eget diam non enim pellentesque ultrices sed et urna. Praesent a leo eget lacus egestas malesuada. Aenean vel consequat lorem. Nullam sed mauris non justo vehicula volutpat. Vestibulum ut porta ipsum.',
            'owner_id' => 3,
            'photoURL' => 'https://www.summareconbekasi.com/public/images/gallery/article/14000/mtown-fc3.jpghttps://www.summareconbekasi.com/public/images/gallery/article/14000/mtown-fc3.jpg'
        ]);

        User::create([
            'name' => 'Vallencius Gavriel',
            'telephone' => '081234567890',
            'email' => 'vallencius@gmail.com',
            'password' => Hash::make('testing12345'),
            'photoPath' => 'ini.png',
            'admin' => true,
            'circle_id' => 1
        ]);

        User::create([
            'name' => 'Bonifasius Ariesto Adrian Finantyo',
            'telephone' => '082114188134',
            'email' => 'adrianfinantyo@gmail.com',
            'password' => Hash::make('adrian12345'),
            'photoPath' => 'ini.png',
            'admin' => false,
            'circle_id' => 1
        ]);

        User::create([
            'name' => 'Antonius Kevin',
            'telephone' => '081223111444',
            'email' => 'tonski@gmail.com',
            'password' => Hash::make('testing12345'),
            'photoPath' => 'ini.png',
            'admin' => true,
            'circle_id' => 2
        ]);

        User::create([
            'name' => 'Vanness Iwata',
            'telephone' => '082114188664',
            'email' => 'wawa@gmail.com',
            'password' => Hash::make('testing12345'),
            'photoPath' => 'ini.png',
            'admin' => false,
            'circle_id' => 2
        ]);

        Package::create([
            'sender' => 'Pak Ali',
            'expedition' => 'Si Capit',
            'receiptNumber' => 'TGR08126666',
            'roomNumber' => '308',
            'photoPath' => 'ini.png',
            'user_id' => 2
        ]);

        Package::create([
            'sender' => 'Bu Mamat',
            'expedition' => 'JANE',
            'receiptNumber' => 'TGR08111126666',
            'roomNumber' => '202',
            'photoPath' => 'ini.png',
            'user_id' => 4
        ]);

        Package::create([
            'sender' => 'Pak Erte',
            'expedition' => 'JENTE',
            'receiptNumber' => 'TGR08331126666',
            'roomNumber' => '202',
            'photoPath' => 'ini.png',
            'user_id' => 4
        ]);
    }
}