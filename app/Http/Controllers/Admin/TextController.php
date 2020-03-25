<?php

namespace App\Http\Controllers\Admin;

use App\Text;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TextController extends Controller
{
    public function index()
    {
        $texts = Text::paginate(10);

        return view('admin.texts.index', compact('texts'));
    }

    public function show($id)
    {
        $text = Text::findOrFail($id);

        return view('admin.texts.edit', compact('text'));
    }

    public function save(Request $request)
    {
        $text = Text::find($request->input('id'));

        $text->text = $request->input('text');

        $text->save();

        return redirect()->back()->with('success', '');
    }
}
