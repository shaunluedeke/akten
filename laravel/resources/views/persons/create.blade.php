@extends('layouts.app')

@section('content-header')<h1>Person | Neu</h1>@endsection

@section('content')

    <form action="{{route('persons.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name" value="" placeholder="Name" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Geburtsdatum</label>
            <input type="date" class="form-control" name="birthday" value="" placeholder="Geburtsdatum">
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Telefonnummer</label>
            <input type="number" class="form-control" name="number" value="555" placeholder="Telefonnummer">
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Adresse</label>
            <input type="text" class="form-control" name="address" placeholder="Adresse">
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Fraction</label>
            <input type="text" class="form-control" name="fraction" placeholder="Fraction">
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Licensen</label>
            <input type="text" class="form-control" name="license" placeholder="Licensen">
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Notizen</label>
            <textarea class="form-control" name="notizen" placeholder="Notizen"></textarea>
        </div>
        <hr>
        <br>
        <input type="submit" value="Speichern" class="btn btn-success">
    </form>

@endsection
