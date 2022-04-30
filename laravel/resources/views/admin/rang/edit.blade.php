@extends('layouts.app')

@section('content-header')
    <h2>Ränge | {{ $rang->name }} | Edit</h2>
@endsection

@section('content')
    <form action="{{route('rang.update',compact('rang'))}}" method="post">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $rang->name }}" placeholder="Name" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Permissions</label>
            <input type="number" class="form-control" min="0" name="permissions" value="{{ $rang->permissions }}" placeholder="Permissions" required>
        </div><hr>
        <br>
        <input type="submit" value="Speichern" class="btn btn-success">
    </form>
@endsection
