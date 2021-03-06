@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 login-form register">
            <div class="panel panel-default">
                <div class="panel-heading">Регистрация @if ($wholesaler) оптового @else розничного @endif покупателя</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">ФИО</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name') || Session::has('wrong_fio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') ?? Session::get('wrong_fio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Пароль</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Пароль еще раз</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <fieldset>
                            @if ($wholesaler)
                            <div class="form-group{{ $errors->has('legal_name') ? ' has-error' : '' }}">
                                <label for="legal_name" class="col-md-4 control-label">Юридическое название</label>

                                <div class="col-md-6">
                                    <input id="legal_name" type="text" class="form-control" name="legal_name" value="{{ old('legal_name') }}" required>

                                    @if ($errors->has('legal_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('legal_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('inn') ? ' has-error' : '' }}">
                                <label for="inn" class="col-md-4 control-label">ИНН</label>

                                <div class="col-md-6">
                                    <input id="inn" type="number" class="form-control" onkeypress="return isNumberKey(event)" name="inn" value="{{ old('inn') }}" required>

                                    @if ($errors->has('inn'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('inn') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                            @unless ($wholesaler)
                                    <div class="form-group{{ $errors->has('birth') ? ' has-error' : '' }}">
                                        <label for="birth" class="col-md-4 control-label">Дата рождения</label>

                                        <div class="col-md-6">
                                            <input name="birth" value="{{ old('birth') }}" class="form-control" id="dateBirth" data-toggle="datepicker" required>

                                            @if ($errors->has('birth'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('birth') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                            @endif
                            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                <label for="city" class="col-md-4 control-label">Город</label>

                                <div class="col-md-6">
                                    <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}" required>

                                    @if ($errors->has('city'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if ($wholesaler)
                            <div class="form-group">
                                <label for="city" class="col-md-4 control-label">Улица</label>

                                <div class="col-md-6">
                                    <input id="street" type="text" class="form-control" name="street" value="{{ old('street') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="city" class="col-md-4 control-label">Дом, квартира, корпус</label>

                                <div class="col-md-6">
                                    <input id="house" type="text" class="form-control" name="house" value="{{ old('house') }}" required>
                                </div>
                            </div>
                            @endif
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone" class="col-md-4 control-label">Телефон</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-silver">
                                    Зарегистрироваться
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="wholesaler" value="{{  $wholesaler ? 1 : 0 }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection