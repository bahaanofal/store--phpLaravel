@extends('layouts.admin')

@section('title')
    <div class="d-flex">
        <h2>Roles</h2>
        <div class="ms-auto">
            @can('create', App\Model\Role::class)
            <a class="btn btn-sm btn-outline-primary" href="{{ route('roles.create') }}">Create</a>
            @endcan
        </div>
    </div>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Roles</li>
    </ol>
@endsection

@section('content')

    <x-alert />


    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->created_at }}</td>
                    <td>
                        @can('update', $role)
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-dark">edit</a>
                        @endcan
                    </td>
                    <td>
                        @if(Auth::user()->can('delete', $role))
                        <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>

    {{ $roles->links() }}

@endsection