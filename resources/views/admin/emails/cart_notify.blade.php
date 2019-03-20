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
| Наименование       | Кол-во         | Итого  |
| ------------------ |:-------------: | --------:|
@foreach($products as $product)
    @php
        $instance = \App\Cart::getInstanceProductType($product['type']);
        $p_info = $instance->where('tcae', $product['cae'])->first();
    @endphp
| {{ $p_info->name }}| {{ $product['count'] }}| {{ $product['count'] * $p_info->price_roz }}|
@endforeach
@endcomponent
@endcomponent


С уважением, {{ config('app.name') }}

@endcomponent
