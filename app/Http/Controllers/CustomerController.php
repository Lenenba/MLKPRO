<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;

class CustomerController extends Controller
{
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
}
