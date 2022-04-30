@extends('layouts.app')

@section('content-header')
    <h2>Password ändern</h2>
@endsection

@section('content')

    @error('error') <div class="alert alert-danger">{{ $message }}</div> @enderror
    @error('old_password') <div class="alert alert-danger">{{ $message }}</div> @enderror
    @error('new_password') <div class="alert alert-danger">{{ $message }}</div> @enderror
    @error('new_password_confirmation') <div class="alert alert-danger">{{ $message }}</div> @enderror
    @error('success') <div class="alert alert-success">{{ $message }}</div> @enderror

    <form method="POST" action="{{ route('pwedit') }}">
        @csrf
        <div class="form-group">
            <label for="password">Altes Passwort</label>
            <input type="password" class="form-control" id="old_password" value="{{old('old_password')}}" name="old_password" placeholder="Altes Passwort" required>
        </div><hr>
        <div class="form-group">
            <label for="password">Neues Passwort</label>
            <input type="password" class="form-control" id="password" value="{{old('new_password')}}" name="new_password" placeholder="Neues Passwort" required>
        </div><hr>
        <div class="form-group">
            <label for="password_confirmation">Neues Passwort wiederholen</label>
            <input type="password" class="form-control" id="password_confirmation" value="{{old('new_password_confirmation')}}" name="new_password_confirmation" placeholder="Neues Passwort wiederholen" required>
        </div><hr>
        <button type="submit" class="btn btn-primary">Passwort ändern</button>
    </form>

@endsection
