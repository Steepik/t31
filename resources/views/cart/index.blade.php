@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-body">
            <div class="ui three top attached steps">
                <div class="active step">
                    <i class="shopping basket icon"></i>
                    <div class="content">
                        <div class="title">Корзина</div>
                        <div class="description">Список товаров</div>
                    </div>
                </div>
            </div>
            <div class="ui attached segment table-responsive">
                @if(count($products) > 0)
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Товар</th>
                            <th nowrap>Цена (Розница)</th>
                            @wholesaler
                            <th nowrap>Цена (Оптом)</th>
                            @endwholesaler
                            <th>Остаток (ул. Красноармейская, 27)</th>
                            <th>Остаток (ул. Чичерина, 2Е)</th>
                            <th>Кол-во</th>
                            <th class="text-center">Итого</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody class="tbody-cart">
                        <?php $total_price = 0;?>
                        @foreach($products as $product)
                            <tr align="center">
                                <td>
                                    <div class="col-xs-4 col-md-4">
                                        <div class="image-season">
                                            @if($product[0]->tseason == 'Зимняя')
                                                <img src="https://torgshina.com/image/icons/winter.png" />
                                            @endif
                                            @if($product[0]->tseason == 'Летняя')
                                                <img src="https://torgshina.com/image/icons/sun.png" />
                                            @endif
                                            @if($product[0]->tseason == 'Всесезонная')
                                                <img src="https://torgshina.com/image/icons/winsun.png" alt="всесезонные шины"/><br/>
                                            @endif
                                            @if($product[0]->spike)
                                                <img src="https://torgshina.com/image/icons/ship.png" />
                                            @endif
                                        </div>
                                        <img src="{{ asset('images/' . $product[0]->image) }}.jpg" alt="{{ $product[0]->name }}" class="img-responsive"/>
                                    </div>
                                    <h4 class="cart-product-name">{{ $product[0]->name }}</h4>
                                </td>
                                <td>{{ $product[0]->price_roz }}p</td>
                                @wholesaler
                                <td>{{ $product[0]->price_opt }}p</td>
                                @endwholesaler
                                <td>
                                    @if($product[0]->quantity > 8)
                                        > 8
                                    @else
                                        {{ $product[0]->quantity }}
                                    @endif
                                </td>
                                <td>
                                    @if($product[0]->quantity_b > 8)
                                        > 8
                                    @else
                                        {{ $product[0]->quantity_b }}
                                    @endif
                                </td>
                                <td data-th="Quantity" class="product-count">
                                    <form action="{{ route('refresh') }}" method="post" class="cart_form_action">
                                        <input type="number" name="count" class="form-control text-center p-count" value="{{ $product['count'] }}">
                                        <input type="hidden" name="id" class="id" value="{{ $product['id']}}">
                                        <input type="hidden" name="product_id" class="pid" value="{{ $product[0]->tcae}}">
                                        <input type="hidden" name="ptype" value="{{ $product['ptype'] }}">
                                        <input type="hidden" name="action" value="" class="btn-action">
                                        {{ csrf_field() }}
                                    </form>
                                </td>
                                @wholesaler
                                    <td data-th="Subtotal" class="text-center">{{ ($product[0]->price_opt * $product['count']) }}p</td>
                                @else
                                    <td data-th="Subtotal" class="text-center">{{ ($product[0]->price_roz * $product['count']) }}p</td>
                                @endwholesaler
                                <td class="actions" data-th="">
                                    <div class="ui buttons">
                                        <button class="ui standart button refresh">Пересчитать</button>
                                        <div class="or" data-text="|"></div>
                                        <button class="ui negative button delete-prod">Удалить</button>
                                    </div>
                                </td>
                            </tr>
                            @wholesaler
                                <?php $total_price += ($product[0]->price_opt * $product['count']); ?>
                            @else
                                <?php $total_price += ($product[0]->price_roz * $product['count']); ?>
                            @endwholesaler
                        @endforeach
                        @if(Session::has('error-refresh'))
                            <div class="ui negative message">
                                <i class="close icon"></i>
                                <div class="header">
                                    Ошибка перерасчета
                                </div>
                                <p>Количество товара не должно превышать остаток и не быть меньше или равняться нулю
                                </p>
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="ui negative message">
                                <i class="close icon"></i>
                                <div class="header">
                                    Ошибка
                                </div>
                                <p>{{ Session::get('error') }}
                                </p>
                            </div>
                        @endif
                        </tbody>
                    </table>
                    <hr/>
                    <div class="col-md-12" style="border: 1px solid #e7e7e7; margin-bottom: 1em">
                        <div style="padding: 1em 1em 1em 0;width: 50%;">
                        <h4 style="margin-top: 1em;">Выберите пункт выдачи товара</h4>
                        <select class="form-control" name="street" id="select-street">
                            <option value="">Выберите улицу</option>
                            <option value="{{ \App\ImportExcelToDb::RED_ARMY_STREET }}">улица Красноармейская 27</option>
                            <option value="{{ \App\ImportExcelToDb::CHECHERINA_STREET }}">улица Чичерина 2E</option>
                        </select>
                        </div>
                    </div>
                    <table style="margin-top:1.3em; width:100%">
                        <tr>
                            <td>
                                <a href="/" class="ui basic secondary button"><i class="cart icon"></i>Продолжить покупки</a>
                                @guest
                                    <a href="#" id="quick_order" class="ui basic positive button"><i class="check icon"></i>Оформить заказ в один клик</a>
                                @else
                                    <a href="/make_order/0" id="make-order" class="ui basic primary button"><i class="payment icon"></i>Оформить заказ</a>
                                @endguest
                            </td>
                            <td class="text-right"><strong>Итого: {{ $total_price }}p</strong></td>
                        </tr>
                    </table>
                @else
                    <div class="ui icon message">
                        <i class="announcement icon"></i>
                        <div class="content">
                            <div class="header">
                                Ваша корзина пуста!
                            </div>
                            <p>Не теряйте времени</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @guest
        <div class="ui modal small" style="padding: 0; height: auto;bottom: auto;">
            <i class="close icon" style="top: 0.5px;right:0.5px;color: #000;"></i>
            <div class="header">
                Быстрое оформление товара
            </div>
            <div class="content">
                <form id="make-fast-order-form" class="ui form" method="get" action="/make_order/0?type=quick">
                    <div class="field">
                        <label>Имя</label>
                        <input type="text" class="input-name-fast-order" name="name" placeholder="Введите имя" required>
                    </div>
                    <div class="field">
                        <label>Номер телефона</label>
                        <input id="phone" class="input-phone-fast-order" type="text" name="phone" placeholder="Введите номер тел." required>
                    </div>
                    <div class="actions" style="text-align: right">
                        <div class="ui button silver cancel">Отмена</div>
                        <button type="submit" class="ui button silver make-order-single">Оформить</button>
                    </div>
                </form>
            </div>
        </div>
            @endguest
    </div>
@stop