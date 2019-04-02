@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 login-form">
           <div class="company-name">
               <h2 class="l-blue">Каретный</h2>
               <h2 class="l-blue">Двор</h2>
           </div>
            <h1 class="login-desc">Автоцентр</h1>
            <div class="panel panel-default">
                <div class="panel-heading">Авторизация</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        @if ($errors->has('email'))
                            <span class="help-block" style="color:#a94442; text-align: center;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="phone" type="text" placeholder="Номер телефона" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="password" type="password" placeholder="Пароль" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="ui silver button login-button" style="width: 100%">Войти</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="ui checkbox">
                                    <input type="checkbox" tabindex="0" name="remember" class="login-check-btn">
                                    <label>Запомнить меня</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <a href="/pre-register">
                        <button class="ui silver basic button" style="width: 100%">Регистрация</button>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <a href="{{ route('password.request') }}">
                        <button class="ui silver basic button" style="width: 100%">Забыли пароль?</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
