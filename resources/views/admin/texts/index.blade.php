@extends('admin.layouts.index')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Cписок оптовиков</h4>
                    <p class="category">Список всех оптовиков</p>
                </div>
                <hr/>
                @if(!$texts->isEmpty())
                    <div class="content table-responsive table-full-width">
                        <table class="table table-responsive">
                            <thead>
                            <th>Текст</th>
                            <th>Действия</th>
                            </thead>
                            <tbody>
                            @foreach($texts as $text)
                                <tr>
                                    <td>{{ html_entity_decode(strip_tags(\Illuminate\Support\Str::limit($text->text, 300))) }}</td>
                                    <td>
                                        <div class="col-xs-12">
                                            <a href="{{ route('text_edit', $text->id) }}" class="btn btn-sm btn-success btn-icon">Редактировать</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="content">
                        <div class="text-warning">Нет оптовиков</div>
                    </div>
                @endif
            </div>
            {{ $texts->render() }}
        </div>
    </div>
@stop