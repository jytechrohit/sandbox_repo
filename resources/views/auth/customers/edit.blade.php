@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Customer</h1>
        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')
            @include('customers.form')
            <button type="submit" class="btn btn-primary">Update Customer</button>
        </form>
    </div>
@endsection
