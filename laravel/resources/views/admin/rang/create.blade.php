@extends('layouts.app')

@section('content-header')
    <h2>User | Registrieren</h2>
@endsection

@section('content')
    <form action="{{route('rang.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Permissions</label>
            <input type="number" class="form-control" min="0" name="permissions" placeholder="Permissions" required>
        </div><hr>
        <br>
        <input type="submit" value="Speichern" class="btn btn-success">
    </form>
@endsection
