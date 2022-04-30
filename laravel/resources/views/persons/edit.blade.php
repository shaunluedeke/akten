@extends('layouts.app')

@section('content-header')
    <h1>Person | {{$person->id}} | Ändern</h1>
@endsection

@section('content')

    <form action="{{route('persons.update', compact("person"))}}" method="post">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name" value="{{$person->name}}" placeholder="Name" required>
        </div>
        <hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Geburtsdatum</label>
            <input type="date" class="form-control" name="birthday" value="{{$person->birthday}}"
                   placeholder="Geburtsdatum">
        </div>
        <hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Telefonnummer</label>
            <input type="number" class="form-control" name="number" value="{{$person->getData()->number}}"
                   placeholder="Telefonnummer">
        </div>
        <hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Adresse</label>
            <input type="text" class="form-control" name="address" value="{{$person->getData()->address}}"
                   placeholder="Adresse">
        </div>
        <hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Fraction</label>
            <input type="text" class="form-control" name="fraction" value="{{$person->getData()->fraction}}"
                   placeholder="Fraction">
        </div>
        <hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Licensen</label>
            <input type="text" class="form-control" name="license" value="{{$person->getData()->license}}" placeholder="Licensen">
        </div>
        <hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Notizen</label>
            <textarea class="form-control" name="notizen"
                      placeholder="Notizen">{{$person->getData()->notizen}}</textarea>
        </div>
        <hr>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="isalive"
                   value="1" {{$person->isalive ? 'checked' : ''}}>
            <label class="form-check-label" for="inlineCheckbox1">Alive</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="iswanted" onchange="showWanted()"
                   value="1" {{$person->iswanted ? 'checked' : ''}}>
            <label class="form-check-label" for="inlineCheckbox2">Wanted</label>
        </div>
        <hr>
        <div id="wantedbox" style="{{$person->iswanted ? 'display: block' : 'display: none'}}">
            <div class="form-group">
                <label for="exampleInputEmail1">Wieso wird er gesucht</label>
                <input type="text" class="form-control" name="wanted" value="{{$person->getData()->wanted ?? ""}}" placeholder="Wieso wird er gesucht">
            </div>
            <hr>
        </div>
        <br>
        <input type="submit" value="Ändern" class="btn btn-success">
    </form>

    <script>
        function showWanted() {
            if (document.getElementById("inlineCheckbox2").checked) {
                document.getElementById("wantedbox").style.display = "block";
            } else {
                document.getElementById("wantedbox").style.display = "none";
            }
        }
    </script>
@endsection
