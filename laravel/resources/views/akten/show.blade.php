@extends('layouts.app')

@section('content-header')
    <h1>
        Akte | {{ $akten->id }}
    </h1>
@endsection

@section('content')

    <table class="table table-responsive-lg table-bordered">
        <tbody>
        <tr>
            <th scope="row">ID</th>
            <td>{{ $akten->id }}</td>
        </tr>
        <tr>
            <th scope="row">Name</th>
            <td>{{ $akten->name }}</td>
        </tr>

        <tr>
            <th scope="row">Geburtsdatum</th>
            <td>{{ $akten->getData()->gb }}</td>
        </tr>

        <tr>
            <th scope="row">Durchwahl</th>
            <td>{{ $akten->getData()->number }}</td>
        </tr>

        <tr>
            <th scope="row">Datum</th>
            <td>{{date("d.m.Y",strtotime($akten->getData()->date))}}</td>
        </tr>

        <tr>
            <th scope="row">{{$akten->fraction()->first()->file()->readkey("akten.straftat","Straftat")}}</th>
            <td>{{ $akten->getData()->straftat }}</td>
        </tr>

        <tr>
            <th scope="row">{{$akten->fraction()->first()->file()->readkey("akten.aufklaerung","Aufklärung")}}</th>
            <td>{{ $akten->getData()->aufklaerung }}</td>
        </tr>

        <tr>
            <th scope="row">{{$akten->fraction()->first()->file()->readkey("akten.urteil","Urteil")}}</th>
            <td>{{ $akten->getData()->urteil }}</td>
        </tr>

        </tbody>
    </table>
    <hr>
    <h3>Diese Akte wurde von {{$akten->user()->first()->name}} erstellt</h3>

    <hr>
    <br>
    <a class="btn btn-success" href="{{route('akten.edit',$akten->id)}}">Akte ändern</a>
    <hr>
    <form method="post" action="{{route('akten.destroy',$akten->id)}}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-warning">Akte löschen</button>
    </form>
@endsection
