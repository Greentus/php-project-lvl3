@extends('template')
@section('content')
    <div class="container">
        <div class="row mt-3">
            <div class="col-12 text-center">
                <h1 class="display-3">Анализатор страниц</h1>
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col col-sm-12 col-lg-10 col-xl-8">
                <form action="{{ route('urls.store') }}" method="post">
                    @csrf
                    <div class="input-group justify-content-center align-items-center">
                        <label class="form-label col-form-label-lg" for="url">Проверить сайт:</label>
                        <input type="text" class="form-control form-control-lg ml-3" id="url" name="url[name]" placeholder="https://www.hexlet.io" required>
                        <button type="submit" class="btn btn-lg btn-primary text-uppercase ml-3">Проверить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection