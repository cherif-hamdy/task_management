<?php

namespace Tests\Unit;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
use App\Services\EmployeeService;
use Tests\TestCase;
use App\Models\User;


class EmployeeTest extends TestCase
{
   public function test_it_can_list_employees()
   {
      $manager = Manager::factory()->create();
      $this->actingAs($manager->user);
      Employee::factory(3)->create(['manager_id' => $manager->id]);
      $response = (new EmployeeService())->list();
      $this->assertCount(3, $response->getOriginalContent()['data']);
   }

   public function test_it_can_create_employee()
   {
      $request = new EmployeeRequest([
         'first_name' => fake()->firstName(),
         'last_name' => fake()->lastName(),
         'email' => fake()->unique()->safeEmail(),
         'phone' => fake()->numerify('01#########'),
         'password' => bcrypt('Password#1'),
         'department_id' => Department::factory()->create()->id,
         'manager_id' => Manager::factory()->create()->id,
         'salary' => fake()->numberBetween(10000,20000),
      ]);
      (new EmployeeService())->store($request);
      $this->assertDatabaseHas(User::class, ['first_name' => $request->first_name, 'email' => $request->email]);
      $this->assertDatabaseHas(Employee::class, ['department_id' => $request->department_id, 'salary' => $request->salary]);
   }

   public function test_it_can_edit_employee()
   {
      $employee = Employee::factory()->create();
      $request = new EmployeeUpdateRequest(array_merge($employee->toArray(), ['first_name' => 'first', 'salary' => 20050]));
      (new EmployeeService())->update($request, $employee);

      $this->assertDatabaseHas(User::class, ['id' => $employee->user->id, 'first_name' => 'first']);
      $this->assertDatabaseHas(Employee::class, ['id' => $employee->id, 'salary' => 20050]);
   }

   public function test_it_can_delete_employee()
   {
        $employee = Employee::factory()->create();
        (new EmployeeService())->delete($employee);

        $this->assertDatabaseMissing(Employee::class, ['id' => $employee->id]);
        $this->assertDatabaseMissing(User::class, ['id' => $employee->user_id]);
   }
}
