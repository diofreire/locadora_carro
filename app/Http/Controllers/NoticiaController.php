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
        return view('noticias', ['noticias' => Noticia::OrderByDesc('created_at')->limit(10)->get()]);
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
