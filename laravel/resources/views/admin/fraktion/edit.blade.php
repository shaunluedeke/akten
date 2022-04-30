@extends('layouts.app')

@section('content-header')
    <h2>Fraktion | {{ $fraktion->name }} | Edit</h2>
@endsection

@section('content')
    <table class="table table-responsive-lg table-bordered">
        <tbody>
        <form action="{{route('fraktion.update',compact('fraktion'))}}" method="post">
            @csrf @method('PATCH')
            <tr>
                <th scope="row">Fraktions Name</th>
                <td><input type="text" class="form-control" value="{{ $fraktion->name }}" name="name"></td>
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
                                                    <td><input type="text" class="form-control" value="{{ $v }}" name="{{"file-".$key."-".$k}}"></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <input type="text" class="form-control" value="{{ $value }}" name="{{$key}}">
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
            <tr>
                <td colspan="2">
                <input type="submit" value="Speichern" class="btn btn-success">
                </td>
            </tr>
        </form>
        </tbody>
    </table>
    <hr>
    <a class="btn btn-success" href="{{route('fraktion.show',compact('fraktion'))}}">Zurück</a>
@endsection
