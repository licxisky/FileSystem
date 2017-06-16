<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class FileModel extends Model
{
    public function get_extension_id($extension)
    {
        $get = DB::table('extension')
            ->where('extension_string', $extension)
            ->select('id')
            ->first();

        if($get)
            return $get->id;

        $insert = [
            'extension_string' => $extension,
            'extension_desc' => $extension,
            'extension_type_id' => 1
        ];

        return DB::table('extension')
            ->insertGetId($insert);
    }

    public function is_exist_file_by_hash($file_hash)
    {
        $get = DB::table('file')
            ->where('file_hash', $file_hash)
            ->where('file_user_id', session()->get('user_id'))
            ->select('file_name')
            ->first();

        if(!$get)
            return "";

        return $get->file_name;
    }

    public function insertFile($insert)
    {
        return DB::table('file')
            ->insert($insert);
    }

    public function get_user_files()
    {

        return DB::table('file')
            ->where('file_user_id', session()->get('user_id'))
            ->join('extension', 'extension.id', '=', 'file_extension_id')
            ->join('type', 'type.id', '=', 'extension_type_id')
            ->select('file.*', 'type_name', 'extension_string')
            ->get();
    }
}
