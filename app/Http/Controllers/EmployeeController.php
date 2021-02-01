<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function thirdMaxSalary()
    {
        /****************************************************************************************** */
        // Second max salary

        // SELECT MAX(salary) max_salary from employees WHERE salary not in(SELECT MAX(salary) from employees)

        // return [DB::select("SELECT MAX(salary) AS 2nd_max_salary
        //                     FROM employees
        //                     WHERE salary not in(
        //                         SELECT MAX(salary) from employees
        //                     )")];

        // return [Employee::whereNotIn('salary', Employee::select(DB::raw("MAX(salary)")))->max('salary')];
        // return [Employee::whereNotIn('salary', function ($query) {
        //     $query->select(DB::raw("MAX(salary)"))->from('employees');
        // })->select(DB::raw("MAX(salary)"), 'first_name')->toSql()];
        /************************************************************************************** */

        /************************************************************************************ */
        // 3rd max salary
        // SELECT max_three.salary, max_three.first_name from ((SELECT id,salary, first_name from employees order by salary DESC limit 3) as max_three) order by max_three.salary ASC limit 1
        // DB::select("SELECT max_three.salary, max_three.first_name
        //             FROM (
        //                 (SELECT id,salary, first_name from employees order by salary DESC limit 3) as max_three
        //             )
        //             ORDER BY max_three.salary ASC
        //             limit 1");

        // // using query builder
        // $subQuery = DB::table('employees')->select(['salary', 'first_name'])->orderBy('salary', 'desc')->take(3);
        // return DB::table( DB::raw("({$subQuery->toSql()}) as max_three") )
        //     ->mergeBindings($subQuery)
        //     ->select('salary', 'first_name')->get();

        // // using eloquent
        // $subQuery = Employee::select(['salary', 'first_name'])->orderBy('salary', 'desc')->take(3)->getQuery();
        // return DB::table( DB::raw("({$subQuery->toSql()}) as max_three") )
        //     ->mergeBindings($subQuery)
        //     ->select('salary', 'first_name')
        //     ->orderBy('salary')
        //     ->take(1)
        //     ->get();

        // return Employee::query()
        //     ->select('max_three.*')
        //     ->fromSub(function ($q) {
        //         $q->select('first_name', 'salary')
        //             ->from('employees')
        //             ->orderBy('salary', 'desc')
        //             ->take(3);
        //     }, 'max_three')
        //     ->orderBy('salary')
        //     ->take(1)->get();
        /************************************************************************************** */


        /************************************************************************************** */
        // 3rd max salary
        // SELECT salary from employees ORDER BY salary DESC LIMIT 1 OFFSET 2
        // return DB::select("SELECT salary, first_name from employees ORDER BY salary DESC LIMIT 1 OFFSET 3");
        return Employee::select(['salary', 'first_name'])->orderBy('salary', 'DESC')->skip(2)->take(1)->get();
        /************************************************************************************** */
    }

    public function maxSalInTheirDep()
    {
        // SELECT first_name, salary from employees where salary in (
        // SELECT MAX(salary) from employees
        // join employee_departments
        // on employees.id = employee_departments.employee_id
        // group BY employee_departments.department_id
        //)

        return Employee::select(['first_name', 'salary'])
            ->whereIn(
                'salary',
                Employee::select(DB::raw("MAX(salary)"))
                    ->join('employee_departments', 'employees.id', 'employee_departments.employee_id')
                    ->groupBy('employee_departments.department_id')
            )->get();
    }

    public function hiredBeforeManager()
    {

    }

    public function takeSalaryGreaterThanManagers()
    {

    }
}
