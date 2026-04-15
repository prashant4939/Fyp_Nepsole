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

    public function toggle($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);

        $customer->is_active = !$customer->is_active;
        $customer->save();

        $message = $customer->is_active ? 'Customer enabled successfully.' : 'Customer disabled successfully.';

        return back()->with('success', $message);
    }

    public function destroy($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        $customer->delete();

        return back()->with('success', 'Customer deleted successfully.');
    }
}
