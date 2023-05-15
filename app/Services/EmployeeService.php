<?php
namespace App\Services;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EmployeeService {

    public function list()
    {
        try {
            $employees = Employee::with(['user','manager','department'])->latest()->get();
            return response()->json([
                'success' => true,
                'data' => $employees
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            logger($e);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(EmployeeRequest $request)
    {
        DB::beginTransaction();
        try {
            $imageName = null;
            $user = User::create(array_merge($request->all(), ['role' => 'employee']));
            if ($request->hasFile('image')) {
                $imageName = $request->file('image')->getClientOriginalName();
                $request->image->move(public_path('images'), $imageName);
            }
            Employee::create(array_merge($request->all(), ['user_id' => $user->id, 'image' => $imageName]));
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Employee created successfully'
            ]);

        } catch (Exception $e) {
            logger($e);
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        DB::beginTransaction();
        try {
            $employee->user->update($request->all());
            if ($request->hasFile('image')) {
                $imageName = $request->file('image')->getClientOriginalName();
                $request->image->move(public_path('images'), $imageName);
                $employee->update(array_merge($request->all(), ['image' => $imageName]));
            }
            else{
                $employee->update($request->all());
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Employee updated successfully'
            ]);
        } catch (Exception $e) {
            logger($e);
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function delete(Employee $employee)
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $employee->user_id)->first();
            $employee->delete();
            $user->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Employee deleted successfully'
            ]);
        } catch (Exception $e) {
            logger($e);
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }
}