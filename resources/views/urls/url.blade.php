@extends('template')
@section('content')
    <div class="container">
        <div class="row mt-3">
            <div class="col-12 text-center">
                <h1>Cайт: {{ $url->name }}</h1>
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <table class="table table-hover table-bordered">
                <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $url->id }}</td>
                </tr>
                <tr>
                    <th>Сайт</th>
                    <td>{{ $url->name }}</td>
                </tr>
                <tr>
                    <th>Дата создания</th>
                    <td>{{ $url->created_at }}</td>
                </tr>
                <tr>
                    <th>Дата обновления</th>
                    <td>{{ $url->updated_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection