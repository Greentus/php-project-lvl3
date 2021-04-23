<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class UrlController extends Controller
{
    private const HTTP_SCHEMES = ['http' => 80, 'https' => 443];

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $urls = DB::table('urls')->orderBy('id')->paginate(15);
        foreach ($urls as $url) {
            $url->check = DB::table('url_checks')->where('url_id', $url->id)->orderByDesc('created_at')->limit(1)->get()->first();
        }
        return view('urls.index', ['urls' => $urls]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $url = $request->input('url')['name'];
        if (strpos($url, '://') === false) {
            $url = 'http://' . $url;
        }
        $arr = parse_url($url);
        if ($arr === false) {
            flash('Не правильный адрес: ' . $url)->error();
            return back()->withErrors(['address' => 'Не правильный адрес: ' . $url]);
        }
        $scheme = $arr['scheme'];
        if (!array_key_exists($scheme, self::HTTP_SCHEMES)) {
            flash('Не поддерживаемый протокол: ' . $url)->error();
            return back()->withErrors(['scheme' => 'Не поддерживаемый протокол: ' . $url]);
        }
        if (!array_key_exists('host', $arr)) {
            flash('Не правильный адрес: ' . $url)->error();
            return back()->withErrors(['host' => 'Не правильный адрес: ' . $url]);
        }
        $host = $arr['host'];
        if (array_key_exists('port', $arr)) {
            $port = $arr['port'];
        } else {
            $port = self::HTTP_SCHEMES[$scheme];
        }
        if ($port != self::HTTP_SCHEMES[$scheme]) {
            $url = $scheme . '://' . $host . ':' . $port;
        } else {
            $url = $scheme . '://' . $host;
        }
        if (DB::table('urls')->insertOrIgnore(['name' => $url, 'created_at' => now(), 'updated_at' => now()])) {
            flash('Сайт ' . $url . ' добавлен.')->success();
            return redirect(route('urls.index'));
        } else {
            flash('Не удалось добавить сайт: ' . $url)->error();
            return back()->withErrors(['address' => 'Не удалось добавить сайт: ' . $url]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function show($id)
    {
        $urls = DB::table('urls')->where('id', $id)->get();
        if ($urls->count() > 0) {
            $checks = DB::table('url_checks')->where('url_id', $urls->first()->id)->orderByDesc('created_at')->get();
            return view('urls.url', ['url' => $urls->first(), 'checks' => $checks]);
        } else {
            abort(404, 'Не известный ID.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function check($id)
    {
        $urls = DB::table('urls')->where('id', $id)->get();
        if ($urls->count() > 0) {
            try {
                $check = Http::get($urls->first()->name);
            } catch (Throwable $e) {
                flash('Ошибка при проверке сайта: ' . $e->getMessage())->error();
                return redirect(route('urls.show', ['url' => $urls->first()->id]));
            }
            if (DB::table('url_checks')->insert(['url_id' => $urls->first()->id, 'status_code' => $check->status(), 'created_at' => now(), 'updated_at' => now()])) {
                flash('Проверка прошла успешно.')->success();
                return redirect(route('urls.show', ['url' => $urls->first()->id]));
            } else {
                flash('Не удалось добавить проверку.')->error();
                return back()->withErrors(['address' => 'Не удалось добавить проверку.']);
            }
        } else {
            abort(404, 'Не известный ID.');
        }
    }
}
