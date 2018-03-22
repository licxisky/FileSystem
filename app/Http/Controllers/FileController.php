<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use DB;

class FileController extends Controller
{
    protected $file_model;

    public function __construct()
    {
        $this->file_model = new \App\FileModel();
    }

    public function file($name = "", $page = 1, $size = 10)
    {
        if($name == "" || $name != session()->get('user_name'))
            return redirect('/');

        if($page < 1) $page = 1;
        if($size < 1) $size = 10;
        elseif($size > 100) $size = 100;


        $info = $this->file_model->get_user_files($page, $size);

        $data = [
            'type' => 'file',
            'key'  => $name,
            'files' => $info['files'],
            'count' => $info['count'],
            'page'  => $page,
            'size'  => $size
        ];

        return view('file', $data);
    }

    public function upload(Request $request)
    {
        // $directory_id =  $request->get('directory');
        $remark = $request->get('remark');

        if($request->hasFile('file'))
        {
            $files = $request->file('file');

            foreach ($files as $file) {
                if($file->isValid())
                {
                    $filename = $file->getClientOriginalName();//$request->get('filename');

                    $realPath = $file->getRealPath();
                    $file_hash = hash_file('md5', $realPath);

                    $file_exist = $this->file_model->is_exist_file_by_hash($file_hash);
                    if($file_exist != "")
                    {
                        session()->flash('message', "文件【 $file_exist 】已存在");
                        return redirect()->back();
                    }

                    $extension = $file->getClientOriginalExtension();
                    $extension_id = $this->file_model->get_extension_id($extension);

                    $time = time();

                    Storage::disk('public')->put("[".date('Y-m-d-H-i-s', $time)."]".iconv("utf-8", "gbk//ignore", $filename), file_get_contents($realPath));

                    $data = [
                        'file_user_id' => session()->get('user_id'),
                        'file_name' => $filename,
                        'file_hash' => $file_hash,
                        'file_size' => filesize(storage_path('app\\public\\').'['.date('Y-m-d-H-i-s', $time).']'.iconv("utf-8", "gbk//ignore", $filename)),
                        'file_extension_id' => $extension_id,
                        'file_remark' => $remark,
                        'file_upload_time' => date('Y-m-d H:i:s', $time)
                    ];

                    $this->file_model->insertFile($data);
                }

            }
            return redirect('file/'.session()->get('user_name'));
        }

    }

    public function download($key = null, $value = null)
    {
        $all_key = ['id', 'hash'];
        if(!in_array($key, $all_key))
            return redirect()->back();

        $key = "file_".$key;

        $info = $this->file_model->get_file_info($key, $value);

        // return response()->download($info['path'], $info['name']);
        $hfile = fopen($info['path'], "rb") or die("Can not find file: ".$info['name']);
         Header("Content-type: application/octet-stream");
         Header("Content-Transfer-Encoding: binary");
         Header("Accept-Ranges: bytes");
         Header("Content-Length: ".filesize($info['path']));
         Header("Content-Disposition: attachment; filename=\"".$info['name']."\"");
         while (!feof($hfile)) {
            echo fread($hfile, 32768);
         }
         fclose($hfile);
    }

    public function extension($extension, $page = 1, $size = 10)
    {

        $info = $this->file_model->get_user_files_by_key('extension_string', $extension, $page, $size);

        $data = [
            'type' => 'extension',
            'key'  => $extension,
            'files' => $info['files'],
            'count' => $info['count'],
            'page'  => $page,
            'size'  => $size
        ];

        return view('file', $data);
    }

    public function type($type, $page = 1, $size = 10)
    {
        $info = $this->file_model->get_user_files_by_key('type_name', $type, $page, $size);

        $data = [
            'type' => 'type',
            'key'  => $type,
            'files' => $info['files'],
            'count' => $info['count'],
            'page'  => $page,
            'size'  => $size
        ];

        return view('file', $data);
    }

    public function remark($remark, $page = 1, $size = 10)
    {
        $info = $this->file_model->get_user_files_by_key('file_remark', $remark, $page, $size);

        $data = [
            'type' => 'remark',
            'key'  => $remark,
            'files' => $info['files'],
            'count' => $info['count'],
            'page'  => $page,
            'size'  => $size
        ];

        return view('file', $data);
    }

    public function date($date, $page = 1, $size = 10)
    {
        $info = $this->file_model->get_user_files_by_date('file_upload_time', $date, $page, $size);

        $data = [
            'type' => 'time',
            'key'  => $date,
            'files' => $info['files'],
            'count' => $info['count'],
            'page'  => $page,
            'size'  => $size
        ];

        return view('file', $data);
    }

    public function search($key = '', $page = 1, $size = 10)
    {
        if($key == '') return redirect('file/'.session('user_name'));

        $info = $this->file_model->get_user_files_by_search($key, $page, $size);

        $data = [
            'type' => 'search',
            'key'  => $key,
            'files' => $info['files'],
            'count' => $info['count'],
            'page'  => $page,
            'size'  => $size
        ];

        return view('file', $data);
    }

    public function edit(Request $request)
    {
        $update = $request->all();

        $this->file_model->update_file($update);

        return back();
    }

    public function size()
    {
        $files = DB::table('file')->get();

        foreach ($files as $file)
        {
            $file_path = storage_path('app\\public\\').'['.date('Y-m-d-H-i-s', strtotime($file->file_upload_time)).']'.iconv("utf-8", "gbk//ignore", $file->file_name);
            $file_size = filesize($file_path);

            DB::table('file')
                ->where('id', $file->id)
                ->update(['file_size' => $file_size]);
        }
    }

    public function share($id)
    {
        $share = $this->file_model->share_file($id);
        return back();
    }

    public function cancel($id)
    {
        $share = $this->file_model->cancel_file($id);
        return back();
    }

    public function shared($page, $size)
    {
        
    }


}
