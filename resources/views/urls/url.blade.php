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
        <div class="row mt-3 justify-content-center">
            <div class="col-12 text-center">
                <h1>Проверки</h1>
            </div>
            <form action="{{ route('checks.store',['url'=>$url->id]) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary ml-3">Запустить проверку</button>
            </form>
        </div>
        <div class="row mt-3 justify-content-center">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th class="text-center">ID</th>
                    <th scope="col" class="text-center">Код ответа</th>
                    <th scope="col" class="text-center">h1</th>
                    <th scope="col" class="text-center">keywords</th>
                    <th scope="col" class="text-center">description</th>
                    <th scope="col" class="text-center">Дата создания</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($checks as $check)
                    <tr>
                        <th scope="row" class="text-right">{{ $check->id }}</th>
                        <td>{{ $check->status_code }}</td>
                        <td>{{ $check->h1 }}</td>
                        <td>{{ $check->keywords }}</td>
                        <td>{{ $check->description }}</td>
                        <td>{{ $check->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection