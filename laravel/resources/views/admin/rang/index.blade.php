@extends('layouts.app')

@section('content-header')
    Ränge
@endsection
@section('content')
    @if(count($rangs) > 0)
        <div class="inter">
            <table id="Table" class="table table-striped" style="width: 100%;" data-toggle="table" data-pagination="false" data-search="false">
                <thead>
                <tr>
                    <th scope="col" data-sortable="true" data-field="Akte">ID</th>
                    <th scope="col" data-sortable="true" data-field="name">Name</th>
                    <th scope="col" data-sortable="true" data-field="date">Permission</th>
                    <th scope="col" data-field="open">Ändern</th>
                    <th scope="col" data-field="delete">Löschen</th>
                </tr>
                </thead>
                <tbody>
                <tr aria-sort="none">
                    <td colspan="6" style="text-align: center"><a class="btn btn-success" href="{{route('rang.create')}}">Neuen Rang erstellen</a></td>
                </tr>
                @forelse($rangs as $rang)
                    <tr>
                        <td>{{$rang->id}}</td>
                        <td>{{$rang->name}}</td>
                        <td>{{$rang->permissions}}</td>
                        <td><a href="{{route('rang.edit',compact('rang'))}}" class="btn btn-warning">Ändern</a></td>
                        <td><form method="post" action="{{route('rang.destroy',compact('rang'))}}">@csrf @method('DELETE') <input type="submit" class="btn btn-danger" value="Löschen"></form></td>
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
        <a class="btn btn-success" href="{{route('fraktion.create')}}">Neuen Rang erstellen</a>
        <a class="btn btn-danger" href="{{route('home')}}">Zurück</a>
    @endif
@endsection
