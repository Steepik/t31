<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(request()->route()->getName() == 'home') style="height: auto;" @endif>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Meta -->
    <meta name="keywords" content="оптовые цены, розничные цены, шины опт белгород, диски опт белгород">
    <meta name="description" content="Продажа шин и дисков по оптовым и розничным ценам - автоцентр Каретный Двор в Белгороде. В интернет-магазине «Каретный Двор» Белгород Вы всегда можете купить летние, зимние автомобильные шины и литые, штампованные диски.">

    <meta name="yandex-verification" content="e878c5978eb4cfce" />
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css?ver=') . config('app.version') }}" rel="stylesheet">
    <link href="{{ asset('css/semantic.min.css') }}" rel="stylesheet">

    @yield('css')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick-theme.css') }}">

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(53121700, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/53121700" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</head>
<body class="home-background" @if(request()->route()->getName() == 'home') style="height: auto;" @endif>
    <div id="app">
        <div id="oveflow-bg"><div id="main-bg-wrapper"></div></div>
        <nav class="navbar navbar-default navbar-static-top" @if(request()->route()->getName() == 'home') style="margin-bottom:0;" @endif>
            <div class="container">
                <div class="navbar-header">
                    <a href="{{ route('home') }}"><button class="pull-left collapse-btn navbar-toggle"><i class="home icon colored"></i></button></a>
                    @auth
                    <a href="{{ route('order-list') }}" class="pull-left collapse-btn"><button class="navbar-toggle">Заказы</button></a>
                    @endauth
                    <a href="{{ route('tires') }}" class="pull-left collapse-btn"><button class="navbar-toggle">Шины</button></a>
                    <a href="{{ route('wheels') }}" class="pull-left collapse-btn"><button class="navbar-toggle">Диски</button></a>
                    <a href="{{ route('cart') }}">
                        <button class="navbar-toggle">
                            <i class="shopping cart icon colored"></i>
                            <span class="cart-products-count">
                                @if(Session::has('cart_products'))
                                    {{ Session::get('cart_products') }} шт.
                                @else
                                    0 шт.
                                @endif
                            </span>
                        </button></a>
                    <a href="{{ route('profile') }}"><button class="navbar-toggle"><i class="user icon colored"></i></button></a>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('/img/logo.jpg')  }}" style="max-width: 195px;" alt="Каретный Двор"/>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>
                    <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-left">
                            @auth
                                <li><a href="{{ route('order-list') }}"><button class="ui silver-in basic button">Заказы</button></a></li>
                            @endauth
                            <li><a href="{{ route('tires') }}"><button class="ui silver-in basic button">Шины</button></a></li>
                            <li><a href="{{ route('wheels') }}"><button class="ui silver-in basic button">Диски</button></a></li>
                            <li><a href="{{ route('contact') }}"><button class="ui silver-in basic button">Контакты</button></a></li>
                            @guest
                                <li><a href="/login"><button class="ui silver-in basic button">Войти</button></a></li>
                                <li><a href="/pre-register"><button class="ui silver-in basic button">Регистрация</button></a></li>
                            @endguest
                        </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                            <li class="dropdown cart">
                                <a href="{{ route('cart') }}">
                                <div class="ui labeled button cart-info" tabindex="0">
                                    <span class="cart-products-count">
                                        @if(Session::has('cart_products'))
                                            {{ Session::get('cart_products') }} шт.
                                        @else
                                            0 шт.
                                        @endif
                                    </span>
                                    <div class="ui silver button">
                                        <i class="cart icon"></i> Корзина
                                    </div>
                                    <span class="ui basic silver left pointing label cart-total-price">
                                        <span id="cart_total_price">
                                        @if(Session::has('total_price'))
                                            {{ Session::get('total_price') }}
                                        @else
                                            0
                                        @endif
                                        </span>
                                        p
                                    </span>
                                </div>
                                </a>
                            </li>
                           {{-- <li class="dropdown profile-btn">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    <button class="ui blue button">{{ Auth::user()->name }} </button><span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        @admin
                                        <a href="/control">Панель управления</a>
                                        @endadmin
                                        <a href="/excel-download">Выгрузки</a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Выйти
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>--}}
                        @auth
                        <div class="ui floating icon dropdown button profile-btn" style="margin-top:1em; margin-left: 1em;">
                            <i class="user icon"></i>
                            <span>{{ Auth::user()->first_name }}</span>
                            <div class="menu">
                                @admin
                                <a href="{{ route('control') }}" class="item"> <i class="cogs icon"></i> Панель управления</a>
                                @endadmin
                                <a href="{{ route('profile') }}" class="item"> <i class="user circle icon"></i> Личный кабинет</a>
                                <a href="{{ route('logout') }}" class="item"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"> <i class="sign out alternate icon"></i> Выход</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

       @if(request()->route()->getName() == 'home')
        <div class="lazy slider">
            <div>
                <img data-lazy="{{ asset('/img/slider/1.jpeg') }}">
            </div>
            <div>
                <img data-lazy="{{ asset('/img/slider/2.jpeg') }}">
            </div>
        </div>
        @endif

        @yield('content')
    </div>
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <span class="closes">&times;</span>
        <img src="" class="modal-content" id="img01">
        <div id="caption"></div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js?ver=') . config('app.version') }}"></script>
    <script src="{{ asset('js/semantic.min.js') }}"></script>
    <script src="https://unpkg.com/imask"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/i18n/datepicker.ru-RU.min.js"></script>

    <script src="{{ asset('/slick/slick.min.js') }}" type="text/javascript" charset="utf-8"></script>

    <script src="{{ asset('js/common.js?ver=') . config('app.version') }}"></script>
</body>
</html>