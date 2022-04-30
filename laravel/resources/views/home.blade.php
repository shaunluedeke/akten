@extends('layouts.app')

@section('content-header')
    {{ __('Dashboard') }}
@endsection

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">Akten</h4>
                </div>
                <div class="card-body">
                    Sehe alle Akten an
                    <hr>
                    <a class="w-100 btn btn-lg btn-primary" href="{{route('akten.index')}}">Öffnen</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">Personen</h4>
                </div>
                <div class="card-body">
                        Sehe alle Personen an
                    <hr>
                    <a class="w-100 btn btn-lg btn-primary" href="{{route('persons.index')}}">Öffnen</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">{{Auth::user()->fraction()->first()->file()->readkey("bussgeld.geld","Bußgeld")}}</h4>
                </div>
                <div class="card-body">
                    Sehe alle {{Auth::user()->fraction()->first()->file()->readkey("bussgeld.geld","Bußgeld")}} an
                    <hr>
                    <a class="w-100 btn btn-lg btn-primary" href="{{route('bussgeld.index')}}">Öffnen</a>
                </div>
            </div>
        </div>
    </div>
@endsection
