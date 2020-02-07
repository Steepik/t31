<?php
namespace App\Http\Controllers;

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
}