<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserModel extends Model
{
    public function login($data)
    {
        $get = DB::table('user')
                ->where('user_name', $data['name'])
                ->select('id', 'user_name', 'user_password')
                ->first();

        if(!$get)
            return false;

        if(!password_verify($data['password'], $get->user_password))
            return false;

        session()->put('user_id', $get->id);
        session()->put('user_name', $get->user_name);
        session()->put('user_is_login', true);

        return true;
    }

    public function register($data)
    {
        $insert = [
            'user_name' => $data['name'],
            'user_password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'user_email' => $data['email'],
            'user_create_time' => date('Y-m-d H:i:s')
        ];

        return DB::table('user')->insertGetId($insert);
    }
}
