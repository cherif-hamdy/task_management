@extends('layouts.app')

@section('content')
    <div class="container">
        
        <div class="row justify-content-center mt-3">
            <div class="col-md-10">

                @if (auth()->user()->role == 'manager')
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-2">Add Task</a>
                @endif

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Managet Name</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $task->employee->user->fullName }}</td>
                                <td>{{ $task->manager->user->fullName }}</td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->status }}</td>
                                <td>
                                    @if ($task->status != 'done' && auth()->user()->role == 'employee')
                                        <form action="{{ route('tasks.update_status', $task->id)}}" method="POST">
                                            @csrf 
                                            <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                                                <option value="" disabled selected>Select Status</option>
                                                <option value="in progress">In Progress</option>
                                                <option value="done">done</option>
                                            </select>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection