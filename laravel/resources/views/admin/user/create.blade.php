@extends('layouts.app')

@section('content-header')
    <h2>Ränge | Hinzufügen</h2>
@endsection

@section('content')
    @error('email')
        <x-alert type="danger" message="Die Email ist schon vergeben"/>
    @enderror
    <form action="{{route('user.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{old('name')}}" required>
        </div><hr>
        <div class="form-group  is-invalid ">
            <label for="exampleInputEmail1">Email </label>
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email')}}" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Password  <ion-icon name="eye-off-outline" id="pw" onclick="showpw()"></ion-icon></label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="{{old('password') ?? $pw}}" required>
        </div><hr>
        @if(Auth::user()->fraction()->first()->id === 1)
            <div class="form-group">
                <label for="exampleFormControlSelect1">Fraktion</label>
                <select class="form-control" id="exampleFormControlSelect1" name="fraction_id">
                    @foreach(\App\Models\fractions::all() as $frac)
                        <option value="{{$frac->id}}">{{$frac->name}}</option>
                    @endforeach
                </select>
            </div>
            <hr>
        @else
            <input type="hidden" name="fraction_id" value="{{Auth::user()->fraction()->first()->id}}">
        @endif
        <div class="form-group">
            <label for="exampleFormControlSelect2">Rang</label>
            <select class="form-control" id="exampleFormControlSelect2" name="rang_id">
                @foreach(\App\Models\Rangs::all() as $rang)
                    <option value="{{$rang->id}}">{{$rang->name}}</option>
                @endforeach
            </select>
        </div>
        <hr>
        <br>
        <input type="submit" value="Speichern" class="btn btn-success">
    </form>
@endsection

<script>

    function showpw() {
        let x = document.getElementById("password");
        let y = document.getElementById("pw");
        if (x.type === "password") {
            x.type = "text";
            y.name = "eye-outline";
        } else {
            x.type = "password";
            y.name = "eye-off-outline";
        }
    }

</script>
