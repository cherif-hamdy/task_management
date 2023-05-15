@extends('layouts.app')

@section('content')
    <div class="container">
        
        <div class="row justify-content-center mt-3">
            <div class="col-md-10">
                <a href="{{ route('departments.create') }}" class="btn btn-primary mb-2">Add Department</a>
                <form action="{{ route('departments.index')}}" method="GET">
                    <div class="d-flex mb-2">
                        <input type="text" name="search" class="form-control" style="width: 200px;margin-right: 2px;">
                        <button class="btn btn-sm btn-primary" type="submit">Search</button>
                    </div>
                </form>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Employees Count</th>
                            <th>Employees Salary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $department->name }}</td>
                                <td>{{$department->employees_count}}</td>
                                <td>{{$department->employees_sum_salary}}</td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-info">Edit</a>
                                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST">
                                            @csrf 
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection