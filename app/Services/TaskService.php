<?php
namespace App\Services;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Http\Request;

class TaskService {
    public function list()
    {
        try {
            $user = auth()->user();
            if($user->role == 'manager')
            {
                $tasks = Task::where('manager_id', $user->manager->id)->with('employee')->latest()->get();
            }else {
                $tasks = Task::where('employee_id', $user->employee->id)->with('manager')->latest()->get();
            }
            return response()->json([
                'success' => true,
                'data' => $tasks
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            logger($e);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function store(TaskRequest $request)
    {
        try {
            Task::create(array_merge($request->all(), ['manager_id' => auth()->user()->manager->id]));
            return response()->json([
                'success' => true,
                'message' => 'task created successfully'
            ]);
        } catch (Exception $e) {
            logger($e);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function updateStatus(Request $request, Task $task)
    {
        try {
            if($task->employee_id == auth()->user()->employee->id)
            {
                $task->update([
                    'status' => $request->status
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'task updated successfully'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized'
            ]);
        } catch (Exception $e) {
            logger($e);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }
}