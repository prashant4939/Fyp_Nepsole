<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }
}
