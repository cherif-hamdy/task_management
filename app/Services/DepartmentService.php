<?php
namespace App\Services;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Exception;
use Illuminate\Http\Response;

class DepartmentService {

    public function list()
    {
        try {
            $departments = Department::query()
                ->withCount('employees')
                ->latest()->get();
            return response()->json([
                'success' => true,
                'data' => $departments
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            logger($e);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(DepartmentRequest $request)
    {
        try {
            $department = Department::create($request->toArray());
            return response()->json([
                'success' => true,
                'message' => "Department add successfully"
            ]);

        } catch (Exception $e) {
            logger($e);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        try {
            $department->update($request->toArray());
            return response()->json([
                'success' => true,
                'message' => 'Department updated successfully'
            ]);
        } catch (Exception $e) {
            logger($e);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function delete(Department $department)
    {
        try {
            if(count($department->employees) == 0)
            {
                $department->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Department deleted successfully'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete department has employees'
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