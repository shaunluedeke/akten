@extends('layouts.app')

@section('content-header')
    Personen
@endsection
@section('content')
    @if(count($persons) > 0)
        <div class="inter">
            <table id="Table" class="table table-striped" style="width: 100%;" data-toggle="table" data-pagination="true" data-search="true">
                <thead>
                <tr>
                    <th scope="col" data-sortable="true" data-field="Akte">ID</th>
                    <th scope="col" data-sortable="true" data-field="name">Name</th>
                    <th scope="col" data-sortable="true" data-field="date">Geburtstag</th>
                    <th scope="col" data-sortable="true" data-field="creator">Gesucht</th>
                    <th scope="col" data-field="frac">Erstellen</th>
                    <th scope="col" data-field="open">Öffnen</th>
                </tr>
                </thead>
                <tbody>
                <tr aria-sort="none">
                    <td colspan="6" style="text-align: center"><a class="btn btn-success"
                                                                  href="{{route('persons.create')}}">Neue Person</a></td>
                </tr>
                @forelse($persons as $person)
                    <tr>
                        <td>{{$person->id}}</td>
                        <td>{{$person->name}}</td>
                        <td>{{date("d.m.Y",strtotime($person->birthday))}}</td>
                        <td>{{$person->iswanted ? "Wird gesucht": "Nicht gesucht"}}</td>
                        <td><a class="btn btn-primary" href="{{route('akten.create', $person->id)}}">Akte Erstellen</a></td>
                        <td><a class="btn btn-primary" href="{{route('persons.show', $person->id)}}">Öffnen</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center">Keine Person vorhanden</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
                integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
                crossorigin="anonymous"></script>
        <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
    @else
        <h3 style="color: black">Es gibt keine Personen!</h3>
        <br><br><br><br><br><br>
        <a class="btn btn-success" href="{{route('persons.create')}}">Neue Person erstellen</a>
        <a class="btn btn-danger" href="{{route('home')}}">Zurück</a>
    @endif
@endsection
