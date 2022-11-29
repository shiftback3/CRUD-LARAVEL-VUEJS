<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Employee::count() > 0) {
            DB::table('Employees')->delete();
        }
            $Employees = [

                [
                    'first_name' => 'Jacob',
                'last_name' => 'Miller',
                'email' => 'jaconm@example.com',
                'phone' => '1234567890',
                'salary' => '30000',
                'department' => 'finance'
                ],
                [
                    'first_name' => 'Harry',
                'last_name' => 'Denis',
                'email' => 'harryd@example.com',
                'phone' => '09987654321',
                'salary' => '20000',
                'department' => 'security'
                ],

               

                




            ];

            foreach ($Employees as $Employee) {
                Employee::create($Employee);
            }
     
    }
}