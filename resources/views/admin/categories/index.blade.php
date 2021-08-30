@extends('layouts.admin')

@section('title')
    {{ $title }} <a href="{{ route('categories.create') }}">Create</a>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Categories</li>
    </ol>
@endsection

@section('content')

    @if($success)
        <div class="alert alert-success">
            {{ $success }}
        </div>
    @endif

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>$loop</th>
                <th>{{ __('ID')}}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Slug') }}</th>
                <th>{{ __('products count') }}</th>
                <th>{{ __('Status') }}</th>
                <th>Created At</th>
                <th>{{ __('Edit') }}</th>
                <th>{{ __('Delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $loop->first ? 'First' : ($loop->last ? 'Last' : $loop->iteration) }}</td>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->original_name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td><a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-dark">{{ __('Edit') }}</a></td>
                    <td>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger" type="submit">{{ __('Delete') }}</button>
                        </form>
                </td>
                </tr>
            @endforeach


        </tbody>
    </table>

@endsection