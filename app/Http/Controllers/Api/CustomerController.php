<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{

    //  path="/api/customers",
    public function index()
    {
        return response()->json(Customer::all());
    }


    //  path="/api/customers",
    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        return response()->json($customer, 201);
    }

    //   path="/api/customers/{id}",

    public function show(Customer $customer)
    {
        return response()->json($customer);
    }


    // path="/api/customers/{id}",
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return response()->json($customer);
    }


    // path="/api/customers/{id}",

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}
