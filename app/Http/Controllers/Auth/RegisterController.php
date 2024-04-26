<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(Request $request) {
        $user = $request->only([
            'name',
            'email',
            'password'
        ]);

        $user = User::create($user);

        return $user;
    }

}
