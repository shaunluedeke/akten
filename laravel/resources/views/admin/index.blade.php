@extends('layouts.app')

@section('content-header')
<h2>Admin Dashboard</h2>
@endsection

@section('content')
    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">Fraktionen</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">{{count(App\Models\fractions::get())}}</h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Fraktions anzahl</li>
                        <li>Neuen Anlegen</li>
                        <li>Ändern</li>
                        <li>Löschen</li>
                    </ul>
                    <hr>
                    <a class="w-100 btn btn-lg btn-primary" href="{{route('fraktion.index')}}">Öffnen</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">Ränge</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">{{count(App\Models\Rangs::get())}}</h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Rang anzahl</li>
                        <li>Neuen Anlegen</li>
                        <li>Ändern</li>
                        <li>Löschen</li>
                    </ul><hr>
                    <a class="w-100 btn btn-lg btn-primary" href="{{route('rang.index')}}">Öffnen</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">User</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">{{count(App\Models\User::get())}}</h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>User Anzahl</li>
                        <li>Neuen Anlegen</li>
                        <li>Ändern</li>
                        <li>Löschen</li>
                    </ul><hr>
                    <a class="w-100 btn btn-lg btn-primary" href="{{route('user.index')}}">Öffnen</a>
                </div>
            </div>
        </div>
    </div>
@endsection
