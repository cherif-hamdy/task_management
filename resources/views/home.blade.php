@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <ul class="list-group bg-info">
                @if (auth()->user()->role == 'manager')
                    <li class="list-group-item">
                        <a href="{{ route('employees.index') }}">Employees</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('departments.index') }}">Departments</a>
                    </li>
                @endif
                <li class="list-group-item">
                    <a href="{{ route('tasks.index') }}">Tasks</a>
                </li>
            </ul>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
