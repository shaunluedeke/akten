@extends('layouts.app')

@section('content-header')
    <h1>Akten | {{$akten->id}} | Edit</h1>
@endsection


@section('content')
    <form action="{{route('akten.update',compact('akten'))}}" method="post">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $akten->name }}" placeholder="Name" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Geburtsdatum</label>
            <input type="text" class="form-control" name="birthsday" value="{{ $akten->getData()->gb }}" placeholder="Geburtsdatum" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Telefonnummer</label>
            <input type="number" class="form-control" name="number" value="{{ $akten->getData()->number }}" placeholder="Telefonnummer" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Wann ist es Passiert</label>
            <input type="date" class="form-control" name="date" value="{{ $akten->getData()->date }}" placeholder="Wann ist es Passiert" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">{{$akten->fraction()->first()->file()->readkey("akten.straftat","Straftat")}}</label>
            <textarea class="form-control" name="straftat" placeholder="{{$akten->fraction()->first()->file()->readkey("akten.straftat","Straftat")}}">{{ $akten->getData()->straftat }}</textarea>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">{{$akten->fraction()->first()->file()->readkey("akten.aufklaerung","Aufklärung")}}</label>
            <textarea class="form-control" name="aufklaerung" placeholder="{{$akten->fraction()->first()->file()->readkey("akten.aufklaerung","Aufklärung")}}">{{ $akten->getData()->aufklaerung }}</textarea>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">{{$akten->fraction()->first()->file()->readkey("akten.urteil","Urteil")}}</label>
            <input type="text" class="form-control" name="urteil" value="{{ $akten->getData()->urteil }}" placeholder="{{$akten->fraction()->first()->file()->readkey("akten.urteil","Urteil")}}">
        </div>
        <hr>
        <br>
        <input type="submit" value="Speichern" class="btn btn-success">
    </form>
@endsection
