@extends('admin.layouts.index')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Настройки</h4>
                    <p class="category"></p>
                </div>
                <hr/>
                <div class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="{{ route('brand-view-access') }}" class="btn btn-fill btn-info">Запрет на отображения брендов</a></li>
                                <li class="list-group-item"><a href="{{ route('brand-view-percent') }}" class="btn btn-fill btn-info">Установить процент для бренда</a></li>
                            </ul>
                        </div>
                    </div>
                    <form action="{{ route('toggle_retail_price') }}" method="post" style="display: flex; justify-content: start; align-items: baseline">
                        <div class="ui checkbox orders"><input class="checkbox-prod" value="1" name="value" type="checkbox" @if($retailPrice->value) checked @endif>
                            <label>
                                Отображать розничную цену
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success" style="margin-left: 1em">Сохранить</button>
                        @csrf
                    </form>
                    <form action="{{ route('toggle_opt_price') }}" method="post" style="display: flex; justify-content: start; align-items: baseline">
                        <div class="ui checkbox orders"><input class="checkbox-prod" value="1" name="value" type="checkbox" @if($optPrice->value) checked @endif>
                            <label>
                                Отображать оптовую цену
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success" style="margin-left: 1em">Сохранить</button>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop