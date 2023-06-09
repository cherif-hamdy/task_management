@extends('layouts.app')

@section('content')
    <div class="container">
        
        <div class="row justify-content-center mt-3">
            <div class="col-md-10">
                <a href="{{ route('employees.create') }}" class="btn btn-primary mb-2">Add Employee</a>
                <form action="{{ route('employees.index') }}" method="GET"> 
                    <div class="d-flex mb-2">
                        <input type="text" name="search" class="form-control" style="width: 200px;margin-right: 2px;">
                        <button class="btn btn-sm btn-primary" type="submit">Search</button>
                    </div>
                </form>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Salary</th>
                            <th>Image</th>
                            <th>Manager</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $employee->user->first_name }}</td>
                                <td>{{$employee->user->last_name}}</td>
                                <td>{{$employee->salary}}</td>
                                <td>
                                    @if ($employee->image)
                                    <img src="{{ asset('images/'.$employee->image) }}" alt="" width="60" height="60">  
                                    @endif
                                </td>
                                <td>{{$employee->manager->user->fullName}}</td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-info">Edit</a>
                                        <x-confirm-modal route="employees.destroy" :id="$employee->id"></x-confirm-modal>
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