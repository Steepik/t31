@component('mail::message')
# Здравствуйте!

@component('mail::panel')
### Информация о покупателе
    - ФИО: {{ $user->name ?? $guest['name'] }}
    - Телефон: {{ $user->phone ?? $guest['phone'] }}
@if(isset($user->city))
    - Город: {{ $user->city }}
@endif
### Информация о товаре
@component('mail::table')

@php $total_sum = 0 @endphp

| Наименование       | Кол-во         | Итого  |
| ------------------ |:-------------: | --------:|
@foreach($products as $product)
    @php
        $instance = \App\Cart::getInstanceProductType($product['type']);
        $p_info = $instance->where('tcae', $product['cae'])->first();
        $total_sum += $product['count'] * $p_info->price_roz;
    @endphp
| {{ $p_info->name }}| {{ $product['count'] }}| {{ $product['count'] * $p_info->price_roz }}p|
@endforeach
@endcomponent
   {!! html_entity_decode('<hr/><span style="float: right;">Общая сумма: ' . $total_sum . 'p </span>') !!}
@endcomponent


С уважением, {{ config('app.name') }}

@endcomponent
