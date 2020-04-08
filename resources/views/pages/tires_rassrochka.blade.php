@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Купить шины в рассрочку</div>

                    <div class="panel-body">
                        {!! $text->text ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

        </div>
    </div>
@endsection