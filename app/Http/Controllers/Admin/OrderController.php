<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\orders;
use App\Models\orders_item;
class OrderController extends Controller
{
     public function index()
    {
        $orders = orders::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = orders_item::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}
