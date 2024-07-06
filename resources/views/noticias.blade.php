@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Principais Notícias</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Notícia</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($noticias as $key => $t)
                                <tr>
                                    <td>{{ $t['id'] }}</td>
                                    <td>{{ $t['titulo'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
