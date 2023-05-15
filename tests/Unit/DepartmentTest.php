<?php

namespace Tests\Unit;

use App\Models\Department;
use Tests\TestCase;
use App\Services\DepartmentService;
use App\Http\Requests\DepartmentRequest;
use App\Models\Employee;

class DepartmentTest extends TestCase
{
    public function test_it_can_list_departments()
    {
        Department::factory(3)->create();
        $response = (new DepartmentService())->list();

        $this->assertCount(3, $response);
    }

    public function test_it_can_store_department()
    {
        $department = Department::factory()->make();
        $req = new DepartmentRequest($department->toArray());
        $response = (new DepartmentService())->store($req);

        $this->assertDatabaseHas(Department::class, ['name' => $department->name]);
    }

    public function test_it_can_update_department()
    {
        $department = Department::factory()->create();
        $req = new DepartmentRequest(array_merge($department->toArray(), ['name' => 'updated']));

        $response = (new DepartmentService())->update($req, $department);

        $this->assertDatabaseHas(Department::class, ['id' => $department->id, 'name' => 'updated']);
    }

    public function test_it_can_delete_department()
    {
        $department = Department::factory()->create();

        $response = (new DepartmentService())->delete($department);

        $this->assertDatabaseMissing(Department::class, ['id' => $department->id]);
    }

    public function test_it_cannot_delete_department_if_it_has_employees()
    {
        $department = Department::factory()->hasEmployees(3)->create();
        (new DepartmentService())->delete($department);

        $this->assertDatabaseHas(Department::class, ['id' => $department->id]);
        $this->assertDatabaseCount(Department::class, 1);
    }
}