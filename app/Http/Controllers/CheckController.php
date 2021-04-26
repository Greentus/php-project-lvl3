<?php

namespace App\Http\Controllers;

use DiDom\Document;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class CheckController extends Controller
{
    /**
     * Perform SEO check for the specified resource.
     *
     * @param int $id
     * @return Application|RedirectResponse|Response|Redirector
     * @throws \DiDom\Exceptions\InvalidSelectorException
     */
    public function store(int $id)
    {
        $urls = DB::table('urls')->where('id', $id)->get();
        if ($urls->count() > 0) {
            try {
                $check = Http::get($urls->first()->name);
            } catch (Throwable $e) {
                flash('Ошибка при проверке сайта: ' . $e->getMessage())->error();
                return back()->withErrors(['Ошибка при проверке сайта: ' . $e->getMessage()]);
            }
            $dom = new Document($check->body());
            $h1 = optional($dom->first('//h1', \DiDom\Query::TYPE_XPATH))->text();
            $keys = optional($dom->first('meta[name=keywords]'))->content;
            $descr = optional($dom->first('meta[name=description]'))->content;
            $db = DB::table('url_checks')->insert([
                'url_id' => $urls->first()->id,
                'status_code' => $check->status(),
                'h1' => $h1,
                'keywords' => $keys,
                'description' => $descr,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            if ($db) {
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
