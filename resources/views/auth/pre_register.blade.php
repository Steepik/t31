@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default col-md-10 col-md-offset-1">
            <div class="panel-heading">Регистрация</div>
        <div class="row">
            <div class="col-md-6 pre-register">
                <a href="/register">
                    <div class="pre-register-card my-2 mx-auto p-relative bg-white shadow-1 blue-hover">
                        <img src="{{ asset('img/opt.png') }}" alt="Man with backpack"
                         class="d-block w-full">

                        <div class="px-2 py-2">
                            <p class="mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px">
                                Зарегитсрироваться как
                            </p>

                            <h1 class="ff-serif font-weight-normal text-black card-heading mt-0 mb-1" style="line-height: 1.25;">
                                Розничный покупатель
                            </h1>

                            <p class="mb-1">
                                Summer is coming to a close just around the corner. But it's not too late to squeeze in another weekend trip &hellip;
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 pre-register">
                <a href="{{ url('/register?who=wholesaler') }}">
                    <div class="pre-register-card my-2 mx-auto p-relative bg-white shadow-1 blue-hover">
                        <img src="{{ asset('img/roz.jpg') }}" alt="Man with backpack"
                             class="d-block w-full">

                        <div class="px-2 py-2">
                            <p class="mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px">
                                Зарегитсрироваться как
                            </p>

                            <h1 class="ff-serif font-weight-normal text-black card-heading mt-0 mb-1" style="line-height: 1.25;">
                                Оптовый покупатель
                            </h1>

                            <p class="mb-1">
                                Summer is coming to a close just around the corner. But it's not too late to squeeze in another weekend trip &hellip;
                            </p>

                        </div>
                    </div>
                </a>
            </div>
        </div>
        </div>
    </div>
@endsection