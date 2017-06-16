<!DOCTYPE html>
<html>
<head>
    <title>用户登陆</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <style type="text/css">
        body{
            background-color: gray;
        }
        .upload{
            margin: auto;
            margin-top: 100px;
            max-width: 350px;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
        }
        .upload-title{
            margin: 30px 0px;
            text-align: center;
        }
        .btn-black{
            color: white;
            background-color: black;
        }
        .input-add{
            cursor: pointer;
            font-size: 16px;
        }
        .input-add:hover{
            background-color: #fff;
        }
/*        input#file_name_replace:focus {
            border-color: #ccc;
            box-shadow: none;
        }*/
    </style>
</head>

<body>
    <div class="upload">
        <form action="{{url('upload')}}" method="post" enctype="multipart/form-data">
            <div class="upload-title">
                <h2>文件上传</h2>
            </div><!-- 
            <div class="input-group form-group">
                <select class="form-control">
                    <option value="0">默认文件夹</option>
                </select>
                <span class="input-group-btn" id="new-dire">
                    <button class="btn btn-default">新建文件夹</button>
                </span>
            </div> -->
            <input type="file" name="file" id="input_file" class="hidden">
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <div class="input-group form-group">
                <input type="text" name="filename" class="form-control" id="file_name_replace">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button" id="btn_file">选择文件</button>
                </span>
            </div>
             <div class="form-group">
                <textarea name="remark" class="form-control" placeholder="请输入文件备注"></textarea>
            </div>
             <div class="form-group">
                <input type="submit" name="submit" class="form-control btn-black">
            </div>

        </form>
        
    </div>

    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type="text/javascript">

        $('#btn_file').click(function() {
          $('#input_file').click();
        });

        $('#input_file').change(function(e) {
          $('#file_name_replace').val($('#input_file').val().substring(12));
        });
  
    </script>
</body>

</html>