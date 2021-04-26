<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class HomeController extends Controller
{
    /**
     * Display a home page.
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function index()
    {
        return view('index');
    }
}
