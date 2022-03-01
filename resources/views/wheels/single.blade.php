@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Информация о диске</div>
                    <div class="panel-body">
                        <div id="single-right-block">
                            <img id="single-image" src="/images/{{ $wheel->image }}.jpg">
                            <ul>
                                <li>Наименование: {{ $wheel->name }}</li>
{{--                                @wholesaler--}}
{{--                                    <li>Цена: {{ $wheel->price_opt }} р.</li>--}}
{{--                                @else--}}
{{--                                    <li>Цена: {{ $wheel->price_roz }} р.</li>--}}
{{--                                @endwholesaler--}}
                                <li>Кол-во: {{ $wheel->quantity > 8 ? '> 8' : $wheel->quantity }} шт.</li>
                                <li>Тип: {{ $wheel->type }}</li>
                                <li>Бренд: {{ $wheel->brand->name }}</li>
                                <li>Модель: {{ $wheel->model }}</li>
                                <li>Код производителя: {{ $wheel->tcae }}</li>
                            </ul>
                        </div>
                        <hr/>
                        <div id="buy-block" class="col-md-12" style="text-align: center">
                            <form onsubmit="return false;" method="post" action="{{ route('addtocart') }}" class="form-add-to-cart">
                                <div class="ui action input">
                                    <input type="number" min="1" name="count" class="count-field" id="count" placeholder="Количество">
                                    <button class="ui silver right labeled icon button add-to-cart">
                                        <i class="add to cart icon"></i>
                                        Купить
                                    </button>
                                </div>
                                <input type="hidden" name="product_id" id="product_id" value="{{ $wheel->tcae }}">
                                <input type="hidden" name="type" id="type" value="4">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop