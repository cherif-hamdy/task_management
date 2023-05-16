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
                                        <x-confirm-modal route='departments.destroy' :id="$department->id"></x-confirm-modal>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
    </div>
@endsection


