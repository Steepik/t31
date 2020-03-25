@extends('admin.layouts.index')

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Редактирование текста</h4>
                </div>
                <hr/>
                <div class="content">
                    <form action="{{ route('text_save') }}" method="post">
                        <textarea class="form-control" id="editor" rows="10" name="text">
                            {{ $text->text }}
                        </textarea>
                        <br/>
                        <input type="hidden" name="id" value="{{ $text->id }}">
                        <button type="submit" class="btn btn-success center-block">Сохранить</button>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'editor' );
    </script>
@section('page_script')
    @if(Session::has('success'))
        <script type="text/javascript">
            var msg = "Сохранено";
            var icon = 'ti-save';
            var type = 'success';
            chart.showNotification(msg, icon, type, 'top', 'right');
        </script>
    @endif
@stop
@stop