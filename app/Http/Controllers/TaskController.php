<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Employee;
use App\Models\Task;
use App\Services\EmployeeService;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('manager')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = (new TaskService())->list();
        $tasks = match($response->getStatusCode()) {
            Response::HTTP_OK => $response->getOriginalContent()['data'],
            Response::HTTP_INTERNAL_SERVER_ERROR => []
        };

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = (new EmployeeService())->list()->getOriginalContent()['data'];
        return view('tasks.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $response = (new TaskService())->store($request);
        $responseData = $response->getData();
        if($responseData->success == false)
        {
            return redirect()->back()->with('error', $responseData->message);
        }

        return redirect()->route('tasks.index')->with('success', $responseData->message);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $response = (new TaskService())->updateStatus($request, $task);
        $responseData = $response->getData();
        if($responseData->success == false)
        {
            return redirect()->back()->with('error', $responseData->message);
        }

        return redirect()->route('tasks.index')->with('success', $responseData->message);
    }
}
