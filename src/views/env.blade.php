@extends('env-editor::layout')
@section('styles')
    <style>
        .tr1 {
            width: 40%;
        }

        .tr2 {
            width: 40%;
        }

        .tr3 {
            width: 20%;
        }

        table {
            table-layout: fixed;
            word-break: break-all;
            word-wrap: break-word;
        }

        .btn-group{
            margin: 10px 0 10px 0;
        }

        .modal-text-input {
            width: 90%;
            margin-top: 10px;
            margin-left: 10px;
        }

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="btn-group" role="group" aria-label="...">
            <button class="btn btn-info note-btn" onclick="openNote()">打开注释</button>
            <button class="btn btn-success" onclick="addConfig()">新增配置</button>
            {{--<button class="btn btn-info" onclick="openNote()">打开注释</button>--}}
        </div>
        <form class="" method="post" action={{ '/'.config('env-editor.route_prefix') }}>
            <input type="hidden" name="user" value="{{ $user }}">
            <input type="hidden" name="password" value="{{ $password }}">
            <table class="table table-striped table-hover row">
                <thead class="w-100">
                <tr class="row">
                    <td class="tr1">配置名称</td>
                    <td class="tr2">配置值</td>
                    <td class="tr3">操作</td>
                </tr>
                </thead>
                <tbody>
                @foreach($configs as $config)
                    @if($config['type'] == 'note')
                        <tr class="{{ $config['type'] }} row warning" hidden>
                            <td class="tr1">{{ $config['value'] }}</td>
                            <td class="tr2">
                                <input class="form-control" type="hidden" name="{{ $config['key'] }}"
                                       value="{{ $config['value'] }}">
                            </td>
                            <td class="tr3"></td>
                        </tr>
                    @else
                        <tr class="{{ $config['type'] }} row">
                            <td class="tr1">{{ $config['key'] }}</td>
                            <td class="tr2">
                                <input class="form-control" type="text" name="{{ $config['key'] }}"
                                       value="{{ $config['value'] }}">
                            </td>
                            <td class="tr3">
                                <button class="btn btn-success" type="submit" onclick="">修改</button>
                                <button class="btn btn-danger" type="button" onclick="deleteConfig(this)">删除</button>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <button class="btn-right btn btn-success" type="submit">提交</button>
        </form>
    </div>
    <!-- 模态框（Modal） -->
    <div class="modal fade" id="addConfig" tabindex="-1" role="dialog" aria-labelledby="addConfigLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="addConfigLabel">新增配置</h4>
                </div>
                <form class="form-group" action="{{ '/'.config('env-editor.route_prefix') .'/append'}}"
                      method="post">
                    <input type="hidden" name="user" value="{{ $user }}">
                    <input type="hidden" name="password" value="{{ $password }}">
                    <input type="text" class="modal-text-input form-control" placeholder="配置名称" name="key">
                    <input type="text" class="modal-text-input form-control" placeholder="配置值" name="value">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">确认</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
    <script>
        function openNote() {
            var _note = $('.note');
            if (_note.attr('hidden') == 'hidden') {
                _note.attr('hidden', false);
                $('.note-btn').text('关闭注释');
            } else {
                _note.attr('hidden', true);
                $('.note-btn').text('打开注释');
            }
        }

        function addConfig() {
            $('#addConfig').modal('show');
        }

        function deleteConfig(_this) {
            _this.parentNode.parentNode.remove();
        }
    </script>
@endsection