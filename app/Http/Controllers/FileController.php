<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class FileController extends Controller
{
    protected $file_model;

    public function __construct()
    {
        $this->file_model = new \App\FileModel();
    }

    public function file($name = "")
    {
        if($name == "" || $name != session()->get('user_name'))
            return redirect('/');

        $files = $this->file_model->get_user_files();

        $data = [
            'files' => $files
        ];
        
        return view('file', $data);
    }

    public function upload(Request $request)
    {
        // $directory_id =  $request->get('directory');
        $remark = $request->get('remark');
        // dd($request->all());
        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            if($file->isValid())
            {
                $filename = $request->get('filename');

                $realPath = $file->getRealPath();
                $file_hash = hash_file('md5', $realPath);

                //$file_exist = $this->file_model->is_exist_file_by_hash($file_hash);

                $extension = $file->getClientOriginalExtension();
                $extension_id = $this->file_model->get_extension_id($extension);

                Storage::put("[".date('Y-m-d-H-i-s')."]".$filename, file_get_contents($realPath));

                $data = [
                    'file_user_id' => session()->get('user_id'),
                    'file_name' => $filename,
                    'file_hash' => $file_hash,
                    'file_extension_id' => $extension_id,
                    'file_remark' => $remark,
                    'file_upload_time' => date('Y-m-d H:i:s')
                ];

                $this->file_model->insertFile($data);
            }
            return redirect('file/'.session()->get('user_name'));
        }
    }
}
