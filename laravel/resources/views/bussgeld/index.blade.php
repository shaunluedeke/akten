@extends('layouts.app')

@section('content-header')
<h2>Bußgelder</h2>
@endsection

@section('content')

    @if(count($bussgelder ?? array()) > 0)
        <div class="inter">
            <table id="Table" class="table table-striped" style="width: 100%;" data-toggle="table" data-pagination="true" data-search="true">
                <thead>
                <tr>
                    <th scope="col" data-sortable="true" data-field="Akte">Paragraf</th>
                    <th scope="col" data-sortable="true" data-field="name">Name</th>
                    <th scope="col" data-sortable="true" data-field="date">{{Auth::user()->fraction()->first()->file()->readkey("bussgeld.geld","Bußgeld")}}</th>
                    @if($fracid === 1)
                        <th scope="col" data-sortable="true" data-field="frac">Fraction</th>
                    @endif
                    <th scope="col" data-field="open">Löschen</th>
                </tr>
                </thead>
                <tbody>
                <tr aria-sort="none">
                    <td colspan="6" style="text-align: center"><a class="btn btn-success" href="{{route('bussgeld.create')}}">Neues Bußgeld</a></td>
                </tr>
                @forelse($bussgelder ?? array() as $bussgeld)
                    <tr>
                        <td>{{$bussgeld->paragraf}}</td>
                        <td>{{$bussgeld->name}}</td>
                        <td>{{$bussgeld->geld}}$</td>
                        @if($fracid === 1)
                            <td>{{$bussgeld->fraction()->first()->name}}</td>
                        @endif
                        <td>
                            @if(Auth::user()->rang()->first()->hasPermission(1))
                            <form action="{{route('bussgeld.destroy',compact('bussgeld'))}}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger">Löschen</button>
                            </form>
                            @else
                                <button class="btn btn-danger" disabled>Löschen</button>
                            @endif
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
        <h3 style="color: black">Es gibt keine Bußgelder!</h3>
        <br><br><br><br><br><br>
        <a class="btn btn-success" href="{{route('bussgeld.create')}}">Neues Bußgeld erstellen</a>
        <a class="btn btn-danger" href="{{route('home')}}">Zurück</a>
    @endif

@endsection
