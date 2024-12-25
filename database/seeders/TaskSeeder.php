<?php

namespace Database\Seeders;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()
            ->for(User::factory(), 'creator')
            ->for(User::factory(), 'executer')
            ->for(TaskStatus::factory(), 'status')
            ->has(Label::factory(), 'labels')
            ->create();

    }

//        DB::table('tasks')->insert([
//            'name' => 'документация',
//            'description' => 'Задача которая касается документации',
//            'created_at' => "$now",
//            'updated_at' => "$now",
//
//        ]);
//
//        DB::table('tasks')->insert([
//            'name' => 'дубликат',
//            'description' => 'Повтор другой задачи',
//            'created_at' => "$now",
//            'updated_at' => "$now",
//
//        ]);

//        DB::table('labels')->insert([
//            'name' => 'доработка',
//            'description' => 'Новая фича, которую нужно запилить',
//            'created_at' => "$now",
//            'updated_at' => "$now",
//
//        ]);
//    }
}
