@extends('layouts.app')

@section('content-header')
    <h2>User | {{ $user->name }} | Edit</h2>
@endsection

@section('content')
    <form action="{{route('user.update',compact('user'))}}" method="post">
        @csrf
        @method('PATCH')
        @error('email')
            <x-alert type="danger" message="Die Email ist schon vergeben"/>
        @enderror
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') ?? $user->name }}" placeholder="Name" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') ?? $user->email }}" placeholder="Email" required>
        </div><hr>
        @if(Auth::user()->fraction_id === 1)
            <div class="form-group">
                <label for="exampleInputEmail1">Fraktion</label>
                <select class="form-control" name="fraction_id">
                    @foreach(\App\Models\fractions::all() as $fraction)
                        <option value="{{ $fraction->id }}" @if((old('fraction_id') ?? $user->fraction_id) === $fraction->id) selected @endif>{{ $fraction->name }}</option>
                    @endforeach
                </select>
            </div><hr>
        @else
            <input type="hidden" name="fraction_id" value="{{ $user->fraction_id }}">
        @endif

        <div class="form-group">
            <label for="exampleInputEmail1">Rang</label>
            <select class="form-control" name="rang_id">
                @foreach(\App\Models\Rangs::all() as $rang)
                    <option value="{{ $rang->id }}" @if((old('rang_id') ?? $user->rang_id) === $rang->id) selected @endif>{{ $rang->name }}</option>
                @endforeach
            </select>
        </div><hr>
        <br>
        <input type="submit" value="Speichern" class="btn btn-success">
    </form>
@endsection
