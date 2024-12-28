<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use App\Utils\FileHandler;
use App\Http\Requests\CustomerRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the customers.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Fetch customers with pagination
        $customers = Customer::mostRecent()
            ->simplePaginate(3);

        // Pass data to Inertia view
        return Inertia::render('Customer/Index', [
            'customers' => $customers
        ]);
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CustomerRequest $request)
    {
        $validated = $request->validated();
        $validated['logo'] = FileHandler::handleImageUpload($request, 'logo', 'customers/corporateHeader.webp');
        $validated['header_image'] = FileHandler::handleImageUpload($request, 'header_image', 'customers/corporateHeader.webp');

        $customer = $request->user()->customers()->create($validated);

        $customer->header_image = $validated['header_image'];
        $customer->logo = $validated['logo'];
        $customer->save();

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Update the specified customer in the database.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        dd($request->all());
        $this->authorize('update', $customer);

        $validated = $request->validated();
        $validated['logo'] = FileHandler::handleImageUpload($request, 'logo', 'customers/corporateHeader.webp');
        $validated['header_image'] = FileHandler::handleImageUpload($request, 'header_image', 'customers/corporateHeader.webp');

        $customer->header_image = $validated['header_image'];
        $customer->logo = $validated['logo'];
        $customer->update($validated);

        return redirect()->route('customer.index')->with('success', 'customer updated successfully.');
    }

    /**
     * Remove the specified customer from the database.
     */
    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        FileHandler::deleteFile($customer->logo, 'customers/corporateHeader.webp');
        FileHandler::deleteFile($customer->header_image, 'customers/corporateHeader.webp');
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'customer deleted successfully.');
    }

}
