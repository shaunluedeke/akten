@extends('layouts.app')

@section('content-header')<h1>Akten | Neu</h1>@endsection

@section('content')

    <form action="{{route('akten.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name" value="" placeholder="Name" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Geburtsdatum</label>
            <input type="text" class="form-control" name="birthsday" value="" placeholder="Geburtsdatum" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Telefonnummer</label>
            <input type="number" class="form-control" name="number" value="555" placeholder="Telefonnummer" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Wann ist es Passiert</label>
            <input type="date" class="form-control" name="date" placeholder="Wann ist es Passiert" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">{{Auth::user()->fraction()->first()->file()->readkey("akten.straftat","Straftat")}}</label>
            <textarea class="form-control" name="straftat" placeholder="{{Auth::user()->fraction()->first()->file()->readkey("akten.straftat","Straftat")}}"></textarea>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">{{Auth::user()->fraction()->first()->file()->readkey("akten.aufklaerung","Aufklärung")}}</label>
            <textarea class="form-control" name="aufklaerung" placeholder="{{Auth::user()->fraction()->first()->file()->readkey("akten.aufklaerung","Aufklärung")}}"></textarea>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">{{Auth::user()->fraction()->first()->file()->readkey("akten.urteil","Urteil")}}</label>
            <input type="text" class="form-control" name="urteil" placeholder="{{Auth::user()->fraction()->first()->file()->readkey("akten.urteil","Urteil")}}">
        </div>
        <hr>
        <br>
        <input type="submit" value="Speichern" class="btn btn-success">
    </form>

@endsection
