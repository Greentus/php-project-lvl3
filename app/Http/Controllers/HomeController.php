<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display a home page.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index()
    {
        return view('index');
    }
}
