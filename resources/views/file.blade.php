<!DOCTYPE html>
<html>
<head>
    <title>文件</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <style type="text/css">
        body {
            /*background-color: gray;*/
        }
        .container{
            max-width: 1200px;
            margin: auto;
            font-size: 24px;
        }

        .container{
            margin-top: 100px;
        }
    </style>

</head>
<body>
    <div class="container">
        <table class="table table-hover">
            <tr>
                <th>文件名</th>
                <th>后缀</th>
                <th>类型</th>
                <th>备注</th>
                <th>上传时间</th>
            </tr>

            @if(isset($files))

            @foreach($files as $file)

            <tr>
                <td>{{$file->file_name}}</td>
                <td>{{$file->extension_string}}</td>
                <td>{{$file->type_name}}</td>
                <td>{{$file->file_remark}}</td>
                <td>{{$file->file_upload_time}}</td>
            </tr>

            @endforeach

            @endif            
        </table>        
    </div>


    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>