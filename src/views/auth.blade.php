@extends('env-editor::layout')
@section('content')
    <div class="container">
        <form action="/{{ config('env-editor.route_prefix') }}" method="get">
            User <input class="form-control" type="text" name="user">
            Password <input class="form-control" type="password" name="password">
            <button class="btn btn-success" type="submit">Enter</button>
        </form>
    </div>
@endsection