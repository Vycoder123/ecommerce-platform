<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;

class AdminController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalOrders = Order::count(); 
        return view('admin.index', compact('totalProducts', 'totalUsers', 'totalOrders'));
    }
}
