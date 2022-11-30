<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Circle;
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
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eget aliquam felis. Mauris varius posuere justo et tristique. Quisque risus felis, pulvinar vel augue in, suscipit dignissim metus. Cras euismod nunc nec sapien pretium viverra. Quisque rhoncus consectetur arcu quis dictum. Etiam libero tortor, imperdiet vel ullamcorper id, finibus eget purus. Sed eget diam non enim pellentesque ultrices sed et urna. Praesent a leo eget lacus egestas malesuada. Aenean vel consequat lorem. Nullam sed mauris non justo vehicula volutpat. Vestibulum ut porta ipsum.'
        ]);

        Circle::create([
            'name' => 'Kos Putra 1',
            'address' => 'Jalan ABC no. 1',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eget aliquam felis. Mauris varius posuere justo et tristique. Quisque risus felis, pulvinar vel augue in, suscipit dignissim metus. Cras euismod nunc nec sapien pretium viverra. Quisque rhoncus consectetur arcu quis dictum. Etiam libero tortor, imperdiet vel ullamcorper id, finibus eget purus. Sed eget diam non enim pellentesque ultrices sed et urna. Praesent a leo eget lacus egestas malesuada. Aenean vel consequat lorem. Nullam sed mauris non justo vehicula volutpat. Vestibulum ut porta ipsum.'
        ]);

        User::create([
            'name' => 'Vallencius Gavriel',
            'telephone' => '081234567890',
            'email' => 'vallencius@gmail.com',
            'password' => bcrypt('testing12345'),
            'admin' => true,
        ]);

        User::create([
            'name' => 'Bonifasius Ariesto Adrian Finantyo',
            'telephone' => '082114188134',
            'email' => 'bonbon@gmail.com',
            'password' => bcrypt('testing12345'),
            'admin' => false,
        ]);
    }
}