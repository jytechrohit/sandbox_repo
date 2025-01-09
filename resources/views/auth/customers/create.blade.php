@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Customer</h1>
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            @include('customers.form')
            <button type="submit" class="btn btn-primary">Create Customer</button>
        </form>
    </div>
@endsection
