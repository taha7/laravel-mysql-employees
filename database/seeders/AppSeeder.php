<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = Department::factory()->count(5)->create();

        $employees = Employee::factory()->count(100)->create();

        $employees->each(function($employee) use ($departments) {
            $employee->departments()->attach($departments->random()->id);
        });

        $employees->random(5)->each(function ($employee) {
            Manager::factory()->create(['employee_id' => $employee->id]);
        });

        $managers = Manager::all();

        $managers->each(function($manager) {
            Department::find($manager->id)->managers()->attach($manager->id);
        });
    }
}
