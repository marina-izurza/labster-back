@extends('layouts.app')

@section('content')
    <h1>Mensajes Pendientes1</h1>

    @if(count($messages) > 0)
        <ul>
            @foreach($messages as $message)
                <li>
                    <strong>ID:</strong> {{ $message['id'] }} <br>
                    <strong>Mensaje:</strong> {{ $message['message'] }} <br>
                    <strong>Estado:</strong> {{ $message['status'] }} <br>
                    <form action="{{ route('complete.message') }}" method="POST">
                        @csrf
                        <input type="hidden" name="messageId" value="{{ $message['id'] }}">
                        <button type="submit" class="btn btn-success">Marcar como completado</button>
                    </form>
                </li>
                <hr>
            @endforeach
        </ul>
    @else
        <p>No hay mensajes pendientes.</p>
    @endif
@endsection
