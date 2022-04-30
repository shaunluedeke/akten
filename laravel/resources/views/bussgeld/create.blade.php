@extends('layouts.app')

@section('content-header')<h1>Bußgeld | Neu</h1>@endsection

@section('content')

    <form action="{{route('bussgeld.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Paragraf</label>
            <input type="text" class="form-control" name="paragraf" value="§" placeholder="Paragraf" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name" value="" placeholder="Name" required>
        </div><hr>
        <div class="form-group">
            <label for="exampleInputEmail1">{{Auth::user()->fraction()->first()->file()->readkey("bussgeld.geld","Bußgeld")}}</label>
            <input type="number" class="form-control" name="geld" value="0" min="0" placeholder="{{Auth::user()->fraction()->first()->file()->readkey("bussgeld.geld","Bußgeld")}}" required>
        </div><hr>
        @if(Auth::user()->fraction()->first()->id === 1)
            <div class="form-group">
                <label for="exampleInputEmail1">Fraktion</label>
                <select class="form-control" name="fraktion_id">
                    @foreach(\App\Models\fractions::all() as $fraktion)
                        <option value="{{$fraktion->id}}">{{$fraktion->name}}</option>
                    @endforeach
                </select>
            </div><hr>
        @else
            <input type="hidden" name="fraktion_id" value="{{Auth::user()->fraction()->first()->id}}">
        @endif
        <br>
        <input type="submit" value="Speichern" class="btn btn-success">
    </form>

@endsection
