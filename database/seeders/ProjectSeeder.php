<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 10; $i++){
            $new_project = new Project();

            $new_project->name = $faker->sentence(3);
            $new_project->description = $faker->paragraph();
            $new_project->date = $faker->dateTime();
            $new_project->slug = Str::slug("$new_project->name", "-");

            $new_project->save();
        }
    }
}
