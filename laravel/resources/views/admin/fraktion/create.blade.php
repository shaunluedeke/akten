@extends('layouts.app')

@section('content-header')
    <h2>Fraktion | Hinzufügen</h2>
@endsection

@section('content')
    <form action="{{route('fraktion.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name" value="" placeholder="Name" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">File Name</label>
            <input type="text" class="form-control" name="textfile" value="" placeholder="File Name" required>
        </div><hr>
        <br>
        <input type="submit" value="Speichern" class="btn btn-success">
    </form>
@endsection
