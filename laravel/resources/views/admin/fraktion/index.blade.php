@extends('layouts.app')

@section('content-header')
    Fraktionen
@endsection
@section('content')
    @if(count($fraktionen) > 0)
        <div class="inter">
            <table id="Table" class="table table-striped" style="width: 100%;" data-toggle="table" data-pagination="false" data-search="false">
                <thead>
                <tr>
                    <th scope="col" data-sortable="true" data-field="Akte">Fraktions ID</th>
                    <th scope="col" data-sortable="true" data-field="name">Name</th>
                    <th scope="col" data-sortable="true" data-field="date">Text File</th>
                    <th scope="col" data-field="open">Öffnen</th>
                </tr>
                </thead>
                <tbody>
                <tr aria-sort="none">
                    <td colspan="6" style="text-align: center"><a class="btn btn-success" href="{{route('fraktion.create')}}">Neue Fraktion</a></td>
                </tr>
                @forelse($fraktionen as $fraktion)
                    <tr>
                        <td>{{$fraktion->id}}</td>
                        <td>{{$fraktion->name}}</td>
                        <td>{{$fraktion->textfile}}</td>
                        <td><a href="{{route('fraktion.show',compact('fraktion'))}}" class="btn btn-success">Ankucken</a></td>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center">Keine Akten vorhanden</td>
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
        <h3 style="color: black">Es gibt keine Akten!</h3>
        <br><br><br><br><br><br>
        <a class="btn btn-success" href="{{route('fraktion.create')}}">Neue Fraktion erstellen</a>
        <a class="btn btn-danger" href="{{route('home')}}">Zurück</a>
    @endif
@endsection
