<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        // Fetch all customers, optionally, you can add pagination
        $customers = Customer::all();
        return response()->json($customers);
    }

    /**
     * Show the form for creating a new customer.
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'state' => 'required|string|max:100',
            'number' => 'required|string|max:20',
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new customer
        $customer = Customer::create([
            'customer_name' => $request->customer_name,
            'state' => $request->state,
            'number' => $request->number,
        ]);

        return response()->json(['message' => 'Customer created successfully', 'customer' => $customer], 201);
    }

    /**
     * Display the specified customer.
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        // Check if customer exists
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($customer);
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        // Check if customer exists
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'customer_name' => 'sometimes|string|max:255',
            'state' => 'sometimes|string|max:100',
            'number' => 'sometimes|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update customer details
        $customer->update($request->all());

        return response()->json(['message' => 'Customer updated successfully', 'customer' => $customer]);
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        // Check if customer exists
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        // Delete customer
        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
