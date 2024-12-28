<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Work;
use Inertia\Inertia;
use App\Models\Customer;
use App\Utils\FileHandler;
use Illuminate\Support\Facades\Auth;
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

        $userId = Auth::user()->id;

        // Fetch customers with pagination
        $customers = Customer::mostRecent()
            ->with(['works' => function ($query) use ($userId) {
                $query->where('user_id', $userId)->with('products');
            }])
            ->byUser($userId)
            ->simplePaginate(3);

        // Collect customer IDs for the current user
        $customerIds = $customers->pluck('id')->toArray();

        // Fetch works for the retrieved customers
        $works = Work::with('products')
            ->byCustomer($customerIds)
            ->byUser($userId)
            ->latest()
            ->paginate(3);

        // Pass data to Inertia view
        return Inertia::render('Customer/Index', [
            'customers' => $customers,
            'works' => $works,
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
