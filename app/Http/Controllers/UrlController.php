<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UrlController extends Controller
{
    private const HTTP_SCHEMES = ['http' => 80, 'https' => 443];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $urls = DB::table('urls')->paginate(15);
        return view('urls.index', ['urls' => $urls]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
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
            return back();
        }
        $scheme = $arr['scheme'];
        if (!array_key_exists($scheme, self::HTTP_SCHEMES)) {
            flash('Не поддерживаемый протокол: ' . $url)->error();
            return back();
        }
        if (!array_key_exists('host', $arr)) {
            flash('Не правильный адрес: ' . $url)->error();
            return back();
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
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $urls = DB::table('urls')->where('id', $id)->get();
        if ($urls->count() > 0) {
            return view('urls.url', ['url' => $urls[0]]);
        } else {
            abort(404, 'Не известный ID.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
