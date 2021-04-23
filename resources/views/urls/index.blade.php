@extends('template')
@section('content')
    <div class="container">
        <div class="row mt-3">
            <div class="col-12 text-center">
                <h1>Список сайтов</h1>
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col" class="text-center">Сайт</th>
                    <th scope="col" class="text-center">Последняя проверка</th>
                    <th scope="col" class="text-center">Код ответа</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($urls as $url)
                    <tr>
                        <th scope="row" class="text-right">{{ $url->id }}</th>
                        <td><a href="{{ route('urls.show',['url'=>$url->id]) }}">{{ $url->name }}</a></td>
                        <td class="text-center">{{ is_null($url->check) ? '' : $url->check->created_at }}</td>
                        <td class="text-center">{{ is_null($url->check) ? '' : $url->check->status_code }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $urls->links() }}
        </div>
    </div>
@endsection