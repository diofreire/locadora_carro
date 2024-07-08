<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Http\Requests\StorenoticiaRequest;
use App\Http\Requests\UpdatenoticiaRequest;
use App\Repository\NoticiaRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class NoticiaController extends Controller
{

    /**
     *
     * @param Noticia $noticia
     */
    public function __construct(Noticia $noticia)
    {
        $this->noticia = $noticia;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        // Criar um dado dentro db redis
        // Chave, valor, tempo em segundos para expirar dado
        //Cache::put('site', 'admin.com.br', 10);

        // Recuperar um dado do db redis
        //$site = Cache::get('site');
        //echo $site;

        $noticias = [];

        // Verifica se há cache
//        if(Cache::has('dez_primeiras_noticias')) {
//            $noticias = Cache::get('dez_primeiras_noticias');
//        } else {
//            $noticias = Noticia::orderByDesc('created_at')->limit(10)->get();
//            Cache::put('dez_primeiras_noticias', $noticias, 15);
//        }

        $noticias = Cache::remember('dez_primeiras_noticias', 15, function() {
            return Noticia::orderByDesc('created_at')->limit(10)->get();
        });

        return view('noticias', ['noticias' => $noticias]);
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
     * @param  \App\Http\Requests\StorenoticiaRequest  $request
     * @return Response
     */
    public function store(StorenoticiaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\noticia  $noticia
     * @return Response
     */
    public function show(noticia $noticia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\noticia  $noticia
     * @return Response
     */
    public function edit(noticia $noticia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatenoticiaRequest  $request
     * @param  \App\Models\noticia  $noticia
     * @return Response
     */
    public function update(UpdatenoticiaRequest $request, noticia $noticia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\noticia  $noticia
     * @return Response
     */
    public function destroy(noticia $noticia)
    {
        //
    }
}
