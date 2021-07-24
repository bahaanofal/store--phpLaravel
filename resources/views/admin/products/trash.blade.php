@extends('layouts.admin')

@section('title')
    <div class="d-flex">
        <h2>Trashed Products</h2>
    </div>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
        <li class="breadcrumb-item active">Trashed Products</li>
    </ol>
@endsection

@section('content')

    <x-alert />

    <div class="d-flex justify-content-between mb-2">
        <form action="{{ route('products.restore') }}" method="post">
            @csrf
            @method('put')
            <button class="btn btn-sm btn-warning" type="submit">Restore All</button>
        </form>
        <form action="{{ route('products.force-delete') }}" method="post">
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
            @foreach ($products as $product)
            <tr>
                <td><img src="{{ asset('storage/' . $product->image_path) }}" width="60" alt=""></td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category_name }}</td>
                <td>{{ $product->price }} $</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->status }}</td>
                <td>{{ $product->deleted_at }}</td>
                <td>
                    <form action="{{ route('products.restore', $product->id) }}" method="post">
                        @csrf
                        @method('put')
                        <button class="btn btn-sm btn-warning" type="submit">Restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('products.force-delete', $product->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger" type="submit">Delete Forever</button>
                    </form>
                </td>
            </tr>
            @endforeach


        </tbody>
    </table>

{{ $products->links() }}

@endsection