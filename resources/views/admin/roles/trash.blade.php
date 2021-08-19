@extends('layouts.admin')

@section('title')
    <div class="d-flex">
        <h2>Trashed Roles</h2>
    </div>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Trashed Roles</li>
    </ol>
@endsection

@section('content')

    <x-alert />

    <div class="d-flex justify-content-between mb-2">
        <form action="{{ route('roles.restore') }}" method="post">
            @csrf
            @method('put')
            <button class="btn btn-sm btn-warning" type="submit">Restore All</button>
        </form>
        <form action="{{ route('roles.force-delete') }}" method="post">
            @csrf
            @method('delete')
            <button class="btn btn-sm btn-danger" type="submit">Empty Trash</button>
        </form>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th></th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Status</th>
                <th>Deleted At</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
            <tr>
                <td><img src="{{ asset('storage/' . $role->image_path) }}" width="60" alt=""></td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->category_name }}</td>
                <td>{{ $role->price }} $</td>
                <td>{{ $role->quantity }}</td>
                <td>{{ $role->status }}</td>
                <td>{{ $role->deleted_at }}</td>
                <td>
                    <form action="{{ route('roles.restore', $role->id) }}" method="post">
                        @csrf
                        @method('put')
                        <button class="btn btn-sm btn-warning" type="submit">Restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('roles.force-delete', $role->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger" type="submit">Delete Forever</button>
                    </form>
                </td>
            </tr>
            @endforeach


        </tbody>
    </table>

{{ $roles->links() }}

@endsection