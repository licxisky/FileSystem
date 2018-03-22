<!DOCTYPE html>
<html>
<head>
    <title>文件</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- <link href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet"> -->

    <style type="text/css">
        body {
            /*background-color: gray;*/
        }
        .container{
            max-width: 1200px;
            margin: auto;
            font-size: 18px;
        }

        .container{
            margin-top: 100px;
            margin-bottom: 100px;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="form-group">
            <a href="{{url('upload')}}" class="btn btn-primary">上传文件</a>
            <form action="{{url('search')}}" class="pull-right form-inline">
                <div class="form-group">
                    <input class="form-control" type="text" name="search" placeholder="搜索..." id="search-text" value="@if($type=='search'){{$key}}@endif">
                    <button type="button" class="btn btn-default" id="search-btn">搜索</button>
                </div>
            </form>
        </div>
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>
                    <th>文件名</th>
                    <th>后缀</th>
                    <th>类型</th>
                    <th>备注</th>
                    <th>大小</th>
                    <th>上传时间</th>
                    <th>操作</th>
                </tr>
            </thead>

            <tbody>
                @if(isset($files))
                @foreach($files as $file)
                <tr id="tr{{$file->id}}">
                    <td><a target="_black" href="{{url('download/hash/'.$file->file_hash)}}">{{$file->file_name}}</a></td>
                    <td><a href="{{url('extension/'.$file->extension_string)}}">{{$file->extension_string}}</a></td>
                    <td><a href="{{url('type/'.$file->type_name)}}">{{$file->type_name}}</a></td>
                    <td><a href="{{url('remark/'.$file->file_remark)}}">{{$file->file_remark}}</a></td>
                    <td>{{ceil($file->file_size / 1024)}} KB</td>
                    <td><a href="{{url('time/'.date('Y-m-d', strtotime($file->file_upload_time)))}}">{{date('m-d H:i', strtotime($file->file_upload_time))}}</a></td>
                    <td>
                        <button value="{{$file->id}}" class="btn btn-info btn-xs btn-edit">编辑</button>
                        <a href="#" class="btn btn-danger btn-xs">删除</a>
                        @if($file->file_share_hash == null)
                        <a href="{{url('share')}}/{{$file->id}}" class="btn btn-success btn-xs">分享</a>
                        @else
                        <a href="{{url('cancel')}}/{{$file->id}}" class="btn btn-default btn-xs">取消分享</a>
                        @endif
                    </td>
                </tr>

                @endforeach
                @endif
            </tbody>
        </table>
        <div class="pull-left"><span>共 {{$count}} 页文件，每页 {{$size}} 条数据</span></div>
        <div class="btn-group pull-right">
            <!-- <a href='{{url("$type/$key")}}' class="btn btn-default">首页</a> -->
            <a @if($page-1>0) href='{{url("$type/$key/".($page-1)."/$size")}}' @else disabled="" @endif  class="btn btn-default">上一页</a>
            <?php $j = 0; ?>
            @if($count - $page <= 3)
            <?php $i=-6 + $count - $page; ?>
            @else
            <?php $i=-3; ?>
            @endif
            @for(; $i <= 7; $i++)
                @if($i+$page > 0 && $i+$page <= $count && $j < 7)
                <a href='{{url("$type/$key/".($i+$page)."/$size")}}'  class="btn btn-default @if($i == 0) active @endif">{{$i+$page}}</a>
                <?php $j++; ?>
                @endif
            @endfor
            <a @if($page+1<=$count) href='{{url("$type/$key/".($page+1)."/$size")}}' @else disabled="" @endif class="btn btn-default">下一页</a>
            <!-- <a href='{{url("$type/$key/$count/$size")}}' class="btn btn-default">尾页</a> -->
        </div>
    </div>

    <button id="edit" class="hidden" data-toggle="modal" data-target="#myModal"></button>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <form class="form" action="{{url('edit')}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">文件信息编辑</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="file_name" class="form-control" id="file_name" placeholder="文件名">
                        </div>
                        <div class="form-group">
                            <textarea name="file_remark" placeholder="文件备注" class="form-control" id="file_remark" rows="5"></textarea>
                        </div>
                        <input type="hidden" name="id" id="file_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </div><!-- /.modal-content -->
            </form>

        </div><!-- /.modal -->
    </div>

    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- <script src="http://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/bootstrap/3/dataTables.bootstrap.js"></script> -->

    <script type="text/javascript">
        // $('#datatable').DataTable({
        //     "language": {
        //         "url": "http://cdn.datatables.net/plug-ins/1.10.15/i18n/Chinese.json"
        //     },
        //     "order": [[ 4, "desc" ]]
        // });
        $('#search-btn').click(function() {
            var key = $('#search-text').val();
            if(key == '') return false;
            window.location.href="{{url('search')}}/"+encodeURI(key);
        });

        $('.btn-edit').click(function() {
            var name = $('#tr'+$(this).val()+' td:eq(0) a').text();
            var ext = $('#tr'+$(this).val()+' td:eq(1) a').text();
            name = name.substring(0, name.length - ext.length - 1);
            var remark = $('#tr'+$(this).val()+' td:eq(3) a').text()
            $('#file_name').val(name);
            $('#file_remark').val(remark);
            $('#file_id').val($(this).val());
            $('#edit').click();
        })
    </script>
</body>
</html>