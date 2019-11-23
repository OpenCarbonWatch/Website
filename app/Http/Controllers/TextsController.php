<?php

namespace App\Http\Controllers;

class TextsController extends Controller
{
    public function showAbout()
    {
        return view('text', ['text' => 'about']);
    }

    public function showContext()
    {
        return view('text', ['text' => 'context']);
    }

    public function showWhatWeDo()
    {
        return view('text', ['text' => 'what-we-do']);
    }

    public function showHowToHelp()
    {
        return view('text', ['text' => 'how-to-help']);
    }
}
