<?php
namespace App\Http\Controllers;

use App\Text;
use Illuminate\Http\Request;
use Meta;

class PageController extends Controller {
    public function contact()
    {
        Meta::title('Контакты');

        return view('pages.contact');
    }

    public function delivery()
    {
        Meta::title('Информация о доставке');

        return view('pages.delivery');
    }

    public function season_save()
    {
        Meta::title('Сезонное хранение');

        $text = Text::where('name', 'season_save')->first();

        return view('pages.season_save', compact('text'));
    }

    public function repair_wheels()
    {
        Meta::title('Правка дисков');

        $text = Text::where('name', 'repair_wheels')->first();

        return view('pages.repair_wheels', compact('text'));
    }
}