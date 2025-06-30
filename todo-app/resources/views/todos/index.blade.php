@extends('layouts.app')
@section('content')
@include('todos.subview.create')


    <div class="container">
        <h1 class="text-center py-3">Laravel Crud Project</h1>
        <div class="row">
            <div class="col-xl-12 text-center">
                <a href="javascript:void(0)" id="createTodoBtn" class="btn btn-primary">Create Todo</a>
            </div>
        </div>

        <div class="table-responsive pt-5">
            <table class="table table-striped" id="data-table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Completed</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($todos as $todo)
                    <tr>
                        <td>{{$todo->id}}</td>
                        <td>{{$todo->title}}</td>
                        <td>{{$todo->description}}</td>
                        <td>
                            <input type="checkbox" class="toggle-completed" data-id="{{$todo->id}} {{$todo->is_completed ? 'checked' :''}}">
                        </td>
                        <td>
                            <a class="btn btn-info view-btn" href="javascript:void(0)" data-id="{{$todo->id}}">View</a>
                            <a class="btn btn-success edit-btn" href="javascript:void(0)" data-id="{{$todo->id}}">Edit</a>
                            <a class="btn btn-danger delete-btn" href="javascript:void(0)" data-id="{{$todo->id}}">Delete</a>
                        </td>
                    </tr>
                @empty
                    <tr colspan="5">
                        <p class="text-danger">No Todos found</p>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>


@endsection
