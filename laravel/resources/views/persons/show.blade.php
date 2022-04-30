<style>

    .wanted{
        animation-name: wantedani;
        animation-duration: 1500ms;
        animation-iteration-count: infinite;
        box-shadow: 0 0 50px 4px #0ff;
    }
    @keyframes wantedani {
        0%{
            box-shadow: 0 0 50px 4px #0ff,0 0 20px 2px #0ff;
        }
        50%{
            box-shadow: 0 0 50px 4px #ff2f2f,0 0 20px 2px #ff2f2f;
        }
        100%{
            box-shadow: 0 0 50px 4px #0ff,0 0 20px 2px #0ff;
        }
    }
    .dead{
        animation-name: deadani;
        animation-duration: 1500ms;
        animation-iteration-count: infinite;
        box-shadow: 0 0 50px 4px #ff2f2f;
    }
    @keyframes deadani {
        0%{
            box-shadow: 0 0 50px 4px #8a8a8a,0 0 20px 2px #8a8a8a;
        }
        50%{
            box-shadow: 0 0 50px 4px #555555,0 0 20px 2px #555555;
        }
        100%{
            box-shadow: 0 0 50px 4px #8a8a8a,0 0 20px 2px #8a8a8a;
        }
    }
</style>

@extends('layouts.app')

@section('content-body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="card {{!$person->isalive ? 'dead' : ($person->iswanted ? 'wanted' : '')}}">
                    <div class="card-header"><h1>{{$person->name}}</h1></div>

                    <div class="card-body">
                        <table class="table table-responsive-lg table-bordered ">
                            <tbody>
                            <tr>
                                <th scope="row">ID</th>
                                <td>{{$person->id}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Name</th>
                                <td>{{$person->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Einreise Datum</th>
                                <td>{{date("d.m.Y", strtotime($person->birthday))}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Telefon Nummer</th>
                                <td>{{$person->getData()->number}}</td>
                            </tr>

                            <tr>
                                <th scope="row">Adresse</th>
                                <td>{{$person->getData()->address}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Fraction</th>
                                <td>{{$person->getData()->fraction}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Licensen</th>
                                <td>{{$person->getData()->license}}</td>
                            </tr>

                            <tr>
                                <th scope="row">Notiz</th>
                                <td>{{$person->getData()->notizen}}</td>
                            </tr>
                            @if($person->iswanted)
                                <tr>
                                    <th scope="row">Wanted</th>
                                    <td>{{$person->getData()->wanted ?? ""}}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <hr>
                        <a class="btn btn-warning" href="{{route('persons.edit',$person->id)}}">Ändern</a>
                        <hr>
                        <form action="{{route('persons.destroy',compact('person'))}}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Löschen" class="btn btn-danger">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
