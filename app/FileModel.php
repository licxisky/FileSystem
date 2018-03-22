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

    public function get_user_files(&$page, &$size)
    {
        $count = DB::table('file')
            ->where('file_user_id', session()->get('user_id'))
            ->whereNull('file_delete_time')
            ->count();

        if($size < 0) $size = 10;
        elseif($size > 100) $size = 100;

        if(ceil($count / $size) < $page) $page = ceil($count / $size);

        $files = DB::table('file')
            ->where('file_user_id', session()->get('user_id'))
            ->whereNull('file_delete_time')
            ->join('extension', 'extension.id', '=', 'file_extension_id')
            ->join('type', 'type.id', '=', 'extension_type_id')
            ->select('file.*', 'type_name', 'extension_string')
            ->orderBy('file_upload_time', 'desc')
            ->offset(($page - 1) * $size)
            ->limit($size)
            ->get();

        return [
            'files' => $files,
            'count' => ceil($count / $size)
        ];
    }

    public function get_user_files_by_key($key, $value, &$page, &$size)
    {

        $count = DB::table('file')
            ->where('file_user_id', session()->get('user_id'))
            ->join('extension', 'extension.id', '=', 'file_extension_id')
            ->join('type', 'type.id', '=', 'extension_type_id')
            ->where($key, $value)
            ->count();

        $files = DB::table('file')
            ->where('file_user_id', session()->get('user_id'))
            ->join('extension', 'extension.id', '=', 'file_extension_id')
            ->join('type', 'type.id', '=', 'extension_type_id')
            ->where($key, $value)
            ->select('file.*', 'type_name', 'extension_string')
            ->orderBy('file_upload_time', 'desc')
            ->offset(($page - 1) * $size)
            ->limit($size)
            ->get();

        return [
            'files' => $files,
            'count' => ceil($count / $size)
        ];

    }

    public function get_user_files_by_date($key, $value, &$page, &$size)
    {

        $count = DB::table('file')
            ->where('file_user_id', session()->get('user_id'))
            ->where($key,">", $value." 00:00:00")
            ->where($key,"<", $value." 23:59:59")
            ->count();

        $files = DB::table('file')
            ->where('file_user_id', session()->get('user_id'))
            ->join('extension', 'extension.id', '=', 'file_extension_id')
            ->join('type', 'type.id', '=', 'extension_type_id')
            ->where($key,">", $value." 00:00:00")
            ->where($key,"<", $value." 23:59:59")
            ->select('file.*', 'type_name', 'extension_string')
            ->orderBy('file_upload_time', 'desc')
            ->offset(($page - 1) * $size)
            ->limit($size)
            ->get();

        return [
            'files' => $files,
            'count' => ceil($count / $size)
        ];
    }

    public function get_user_files_by_search($key, &$page, &$size)
    {

        $files = DB::table('file')
            ->where('file_user_id', session()->get('user_id'))
            ->join('extension', 'extension.id', '=', 'file_extension_id')
            ->join('type', 'type.id', '=', 'extension_type_id')
            ->where('file_name', 'like', '%'.$key.'%')
            ->orWhere('file_remark', 'like', '%'.$key.'%')
            ->orWhere('extension_string', 'like', '%'.$key.'%')
            ->orWhere('type_name', 'like', '%'.$key.'%')
            ->orWhere('file_upload_time', 'like binary', '%'.$key.'%')
            ->select('file.*', 'type_name', 'extension_string')
            ->orderBy('file_upload_time', 'desc')
            ->offset(($page - 1) * $size)
            ->limit($size)
            ->get();

        $count = DB::table('file')
            ->where('file_user_id', session()->get('user_id'))
            ->join('extension', 'extension.id', '=', 'file_extension_id')
            ->join('type', 'type.id', '=', 'extension_type_id')
            ->where('file_name', 'like', '%'.$key.'%')
            ->orWhere('file_remark', 'like', '%'.$key.'%')
            ->orWhere('extension_string', 'like', '%'.$key.'%')
            ->orWhere('type_name', 'like', '%'.$key.'%')
            ->orWhere('file_upload_time', 'like binary', '%'.$key.'%')
            ->count();

        return [
            'files' => $files,
            'count' => ceil($count / $size)
        ];
    }

    public function get_file_info($key, $value)
    {
        $get = DB::table('file')
            ->where($key, $value)
            ->where('file_user_id', session()->get('user_id'))
            ->select('file_name', 'file_upload_time')
            ->first();

        return [
            'path' => storage_path('app\\public\\').'['.date('Y-m-d-H-i-s', strtotime($get->file_upload_time)).']'.iconv("utf-8", "gbk//ignore", $get->file_name),
            'name' => $get->file_name
        ];
    }

    public function update_file($data)
    {
        $get = DB::table('file')
            ->where('file.id', $data['id'])
            ->join('extension', 'extension.id', '=', 'file_extension_id')
            ->select('file_name', 'file_upload_time', 'extension_string')
            ->first();

        if(!$get) return false;

        if(($data['file_name'].'.'.$get->extension_string) != $get->file_name)
        {
            rename(
                storage_path('app\\public\\').'['.date('Y-m-d-H-i-s', strtotime($get->file_upload_time)).']'.iconv("utf-8", "gbk//ignore", $get->file_name), 
                storage_path('app\\public\\').'['.date('Y-m-d-H-i-s', strtotime($get->file_upload_time)).']'.iconv("utf-8", "gbk//ignore", $data["file_name"].'.'.$get->extension_string));
        }

        $update = [
            'file_name' => $data['file_name'].'.'.$get->extension_string,
            'file_remark' => $data['file_remark'],
            'file_update_time' => date('Y-m-d H:i:s')
        ];

        return DB::table('file')
            ->where('id', $data['id'])
            ->update($update);
    }

    public function share_file($id)
    {
        do
        {
            $share_hash = substr(md5(md5(time())), 0, 6);
            $find = DB::table('file')
                ->where('file_share_hash', $share_hash)
                ->count();

        } while($find > 0);

        return DB::table('file')
            ->where('file_user_id', session('user_id'))
            ->where('id', $id)
            ->update(['file_share_hash'=>$share_hash]);
    }

    public function cancel_file($id)
    {
        return DB::table('file')
            ->where('file_user_id', session('user_id'))
            ->where('id', $id)
            ->update(['file_share_hash' => null]);
    }
}
