@extends('layouts.app')

<style>
#calendario
{
	width: 800px;
	height: 400px;
}
</style>

@section('content')

<div id="calendario" class="container">
    <div id="calendar"></div>
</div>

<script>
    $(document).ready(function()
     {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar(
        {
            locale: 'es',
            header:
            {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: false,
            events: [
            @foreach($eventos as $evento)
            {
                title: "{!! $evento->Nombre !!}",
                start: "{!! $evento->FechaDesde !!}",
                end: "{!! $evento->FechaHasta !!}",
                @if($evento->CD_EventoEstado == 1) // CONFIRMADO
                	backgroundColor: "Green",
                @elseif($evento->CD_EventoEstado == 2) // PENDIENTE
                	backgroundColor: "Grey",
                @elseif($evento->CD_EventoEstado == 3) // CANCELADO
                	backgroundColor: "Black",
									textColor: "White",
                @elseif($evento->CD_EventoEstado == 4) // ANULADO
                	backgroundColor: "Grey",
                @elseif($evento->CD_EventoEstado == 5) // PERDIDO
                	backgroundColor: "Red",
                @else($evento->CD_EventoEstado == 6) // ALTA PROBABILIDAD
                	backgroundColor: "Violet",
                @endif
								@if($evento->FechaConfirmada == 0)
									backgroundColor: "Yellow",
									textColor: "Red",
								@endif
                url: "{!! url("abm_acciones/mostrarevento/".$evento->CD_Evento) !!}",
                allDay: true
            },
            @endforeach
            ]
        });
    });
    </script>
@endsection
