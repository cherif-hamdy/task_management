<?php

namespace Tests\Unit;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Requests\TaskRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Task;
use App\Services\EmployeeService;
use Tests\TestCase;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskTest extends TestCase {

    public function test_it_can_list_tasks()
    {
        $employee = Employee::factory()->create();
        $this->actingAs($employee->user);
        Task::factory(3)->create(['employee_id' => $employee->id]);
        $response = (new TaskService())->list();

        $this->assertCount(3, $response->getOriginalContent()['data']);
    }

    public function test_it_can_create_task()
    {
        $manager = Manager::factory()->create();
        $this->actingAs($manager->user);
        $task = Task::factory()->make(['manager_id' => $manager->id]);
        $request = new TaskRequest($task->toArray());
        $response = (new TaskService())->store($request);

        $this->assertDatabaseHas(Task::class, ['employee_id' => $task->employee_id, 'manager_id' => $task->manager_id, 'title' => $task->title]);
    }

    public function test_it_can_update_task_status()
    {
        $employee = Employee::factory()->create();
        $this->actingAs($employee->user);
        $task = Task::factory()->create(['employee_id' => $employee->id, 'status' => 'to do']);
        $request = new Request(['status' => 'in progress']);

        $response = (new TaskService())->updateStatus($request, $task);

        $this->assertDatabaseHas(Task::class, ['id' => $task->id, 'status' => 'in progress']);

    }
}