<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Models\Manager;
use App\Services\DepartmentService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = (new EmployeeService())->list();
        $employees = match($response->getStatusCode()) {
            Response::HTTP_OK => $response->getOriginalContent()['data'],
            Response::HTTP_INTERNAL_SERVER_ERROR => []
        };
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = (new DepartmentService())->list()->getOriginalContent()['data'];
        $managers = Manager::all();
        return view('employees.create', compact('departments', 'managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $response = (new EmployeeService())->store($request);
        $responseData = $response->getData();
        if ($responseData->success == false) {
            return redirect()->back()->with('error', $responseData->message);
        }

        return redirect()->route('employees.index')->with('success', $responseData->message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments = (new DepartmentService())->list()->getOriginalContent()['data'];
        $managers = Manager::all();
        return view('employees.edit', compact('employee', 'departments', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $response = (new EmployeeService())->update($request, $employee);
        $responseData = $response->getData();
        if($responseData->success == false)
        {
            return redirect()->back()->with('error', $responseData->message);
        }

        return redirect()->route('employees.index')->with('success', $responseData->message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $response = (new EmployeeService())->delete($employee);
        $responseData = $response->getData();
        if ($responseData->success == false) {
            return redirect()->back()->with('error', $responseData->message);
        }

        return redirect()->route('employees.index')->with('success', $responseData->message);
    }
}
