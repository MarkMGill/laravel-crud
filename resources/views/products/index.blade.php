@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Laravel 8 CRUD Example </h2>
            </div>
            <div class="float-right">
                <a class="btn btn-success"  data-toggle="modal" data-target="#addModal"> <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p></p>
        </div>
    @endif

    
    <section id="products" data-url="{{ url('/products/data') }}">
    <table class="table table-bordered table-responsive-lg">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Date Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="productsTable">
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a data-id="{{ $product->id }}" href="" class="btnUpdate">
                            <i class="fas fa-edit  fa-lg"></i>
                        </a>
                        <a data-id="{{ $product->id }}" href="" class="btnDelete">
                            <i class="fas fa-trash fa-lg text-danger">
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $products->links() !!}
    </section>
    

    

@endsection