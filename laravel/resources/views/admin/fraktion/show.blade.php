@extends('layouts.app')

@section('content-header')
    <h2>Fraktion | {{ $fraktion->name }}</h2>
@endsection

@section('content')
    <table class="table table-responsive-lg table-bordered">
        <tbody>
        <tr>
            <th scope="row">Fraktions ID</th>
            <td>{{ $fraktion->id }}</td>
        </tr>
        <tr>
            <th scope="row">Fraktions Name</th>
            <td>{{ $fraktion->name }}</td>
        </tr>

        <tr>
            <th scope="row">File</th>

            <td>
                <table class="table table-responsive-lg table-bordered">
                    <tbody>
                    @forelse($fraktion->file()->read() as $key => $value)
                        <tr>
                            <th scope="row">{{ $key }}</th>
                            <td>
                                @if(is_array($value))
                                    <table class="table table-responsive-lg table-bordered">
                                        <tbody>
                                        @foreach($value as $k => $v)
                                            <tr>
                                                <th scope="row">{{ $k }}:</th>
                                                <td>{{ $v }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    {{ $value }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th scope="row" colspan="2">Keine Datei vorhanden</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </td>
        </tr>

        </tbody>
    </table>
    <hr>
    <form method="post" action="{{route('fraktion.destroy',$fraktion->id)}}"> @csrf @method('DELETE')

        <a class="btn btn-warning" href="{{route('fraktion.edit',$fraktion->id)}}">Fraktion ändern</a>
        <button type="submit" class="btn btn-danger">Fraktion löschen</button>
        <a class="btn btn-success" href="{{route('fraktion.index')}}">Zurück</a>
    </form>
@endsection
