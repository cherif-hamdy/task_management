<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Services\EmployeeService;
use Tests\TestCase;
use App\Models\User;


class EmployeeTest extends TestCase
{
   public function test_it_can_delete_employee()
   {
        $employee = Employee::factory()->create();
        (new EmployeeService())->delete($employee);

        $this->assertDatabaseMissing(Employee::class, ['id' => $employee->id]);
        $this->assertDatabaseMissing(User::class, ['id' => $employee->user_id]);
   }
}
