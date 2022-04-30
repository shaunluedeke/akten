@extends('layouts.app')

@section('content-header')
    Ränge
@endsection
@section('content')
    @if(count($users) > 0)
        <div class="inter">
            <table id="Table" class="table table-striped" style="width: 100%;" data-toggle="table"
                   data-pagination="true" data-search="false">
                <thead>
                <tr>
                    <th scope="col" data-sortable="true" data-field="Akte">ID</th>
                    <th scope="col" data-sortable="true" data-field="name">Name</th>
                    <th scope="col" data-sortable="true" data-field="date">Email</th>
                    <th scope="col" data-sortable="true" data-field="rang">Rang</th>
                    <th scope="col" data-sortable="true" data-field="frac">Fraktion</th>
                    <th scope="col" data-field="delete">Ändern</th>
                    <th scope="col" data-field="d">Löschen</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->rang()->first()->name ?? ""}}</td>
                        <td>{{$user->fraction()->first()->name ?? ""}}</td>
                        <td><a href="{{route('user.edit',compact('user'))}}" class="btn btn-warning">Ändern</a></td>
                        <td><form method="post" action="{{route('user.destroy',compact('user'))}}">@csrf @method('DELETE') <input type="submit" class="btn btn-danger" value="Löschen"></form></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center">Keine Akten vorhanden</td>
                    </tr>
                @endforelse
                <tr aria-sort="none">
                    <td colspan="7" style="text-align: center"><a class="btn btn-success"
                                                                  href="{{route('user.create')}}">User Regestieren</a></td>
                </tr>
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
        <a class="btn btn-success" href="{{route('user.create')}}">User Regestieren</a>
        <a class="btn btn-danger" href="{{route('home')}}">Zurück</a>
    @endif
@endsection
