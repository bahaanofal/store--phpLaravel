@extends('layouts.admin')

@section('title')
    <div class="d-flex">
        <h2>Products</h2>
        <div class="ms-auto">
            @can('create', App\Model\Product::class)
            <a class="btn btn-sm btn-outline-primary" href="{{ route('products.create') }}">Create</a>
            @endcan
            <a class="btn btn-sm btn-outline-dark" href="{{ route('products.trash') }}">Trash</a>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Products</li>
    </ol>
@endsection

@section('content')

    <x-alert />


    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th></th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td><img src="{{ $product->image_url }}" width="60" alt=""></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category_name }}</td>
                    <td>{{ $product->formatted_price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>
                        @can('update', $product)
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-dark">edit</a>
                        @endcan
                    </td>
                    <td>
                        @can('delete', $product)
                        <form action="{{ route('products.destroy', $product->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>

    {{ $products->links() }}

@endsection