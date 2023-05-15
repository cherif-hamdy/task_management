<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = (new DepartmentService())->list();
        $departments = match($response->getStatusCode()) {
            Response::HTTP_OK => $response->getOriginalContent()['data'],
            Response::HTTP_INTERNAL_SERVER_ERROR => []
        };

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        $response = (new DepartmentService())->store($request);
        $responseData = $response->getData();
        if ($responseData->success == false) {
            return redirect()->back()->with('error', $responseData->message);
        }

        return redirect()->route('departments.index')->with('success', $responseData->message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        $response = (new DepartmentService())->update($request, $department);
        $responseData = $response->getData();
        if ($responseData->success == false) {
            return redirect()->route('departments.edit', $department->id)->with('error', $responseData->message);
        }
        
        return redirect()->route('departments.index')->with('success', $responseData->message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $response = (new DepartmentService())->delete($department);
        $responseData = $response->getData();
        if ($responseData->success == false) {
            $msgType = 'error';
        }else {
            $msgType = 'success';
        }

        return redirect()->route('departments.index')->with($msgType, $responseData->message);
    }
}
