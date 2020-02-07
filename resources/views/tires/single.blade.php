@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Информация о шине</div>
                    <div class="panel-body">
                        <div id="single-right-block">
                            <div id="block-image">
                                <div class="image-season">
                                    @if($tire->tseason == 'Зимняя')
                                        <img src="https://torgshina.com/image/icons/winter.png" />
                                    @endif
                                    @if($tire->tseason == 'Летняя')
                                        <img src="https://torgshina.com/image/icons/sun.png" />
                                    @endif
                                    @if($tire->tseason == 'Всесезонная')
                                        <img src="https://torgshina.com/image/icons/winsun.png" alt="всесезонные шины"/><br/>
                                    @endif
                                    @if($tire->spike)
                                        <img src="https://torgshina.com/image/icons/ship.png" />
                                    @endif
                                </div>
                                <img id="single-image" src="/images/{{ $tire->image }}.jpg">
                            </div>
                            <ul>
                                <li>Наименование: {{ $tire->name }}</li>
                                @wholesaler
                                    <li>Цена: {{ $tire->price_opt }} р.</li>
                                @else
                                    <li>Цена: {{ $tire->price_roz }} р.</li>
                                @endwholesaler

                                <li>Кол-во: {{ $tire->quantity > 8 ? '> 8' : $tire->quantity }} шт.</li>
                                <li>Сезонность: {{ $tire->tseason }}</li>
                                <li>Шипы: {{ $tire->tspike == 1 ? 'Да' : 'Нет' }}</li>
                                <li>Бренд: {{ $tire->brand->name }}</li>
                                <li>Модель: {{ $tire->model }}</li>
                                <li>Код производителя: {{ $tire->tcae }}</li>
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
                                <input type="hidden" name="product_id" id="product_id" value="{{ $tire->tcae }}">
                                <input type="hidden" name="type" id="type" value="1">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop