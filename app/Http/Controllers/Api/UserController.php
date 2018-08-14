<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

    public function login(Request $request)
    {
        $user = User::selectRaw('users.*, customers.name AS customer')
            ->join('customers', 'customers.id', '=', 'users.customer_id', 'LEFT')
            ->where('users.active', 1)
            ->where('users.email', 'LIKE', $request->email)->first();

        if ($user && password_verify($request->password, $user->password)) {
            return $user;
        }

        return null;
    }
}
