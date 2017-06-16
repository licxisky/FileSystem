<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $user_model;

    public function __construct()
    {
        $this->user_model = new \App\UserModel();
    }

    public function login(Request $request)
    {
        $login = $this->user_model->login($request->all());

        if($login)
            return redirect("file/".session()->get('user_name'));
        else
            return redirect("");
    }

    public function register(Request $request)
    {
        $register = $this->user_model->register($request->all());

        return redirect("");
    }
}
