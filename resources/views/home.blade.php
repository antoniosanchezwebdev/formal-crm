@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
    <style>
        .btn-block {
            width: 300px;
            height: 180px;
        }

        .btn-color-1 {
            background-color: #F94144;
            border-color: #F94144;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .btn-color-1 span {
            margin-top: auto;
            margin-bottom: auto;
        }


        .btn-color-2 {
            background-color: #F3722C;
            border-color: #F3722C;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .btn-color-3 {
            background-color: #F9C74F;
            border-color: #F9C74F;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .btn-color-4 {
            background-color: #90BE6D;
            border-color: #90BE6D;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .btn-color-5 {
            background-color: #43AA8B;
            border-color: #43AA8B;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .btn-color-6 {
            background-color: #577590;
            border-color: #577590;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .btn-primary:hover {
            background-color: #FFF;
            color: #000;
        }
    </style>

    <br><br><br>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: "es",
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' // user can switch between the two
                    },
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        day: 'Día',
                        list: 'Lista',
                    },
                    events: [
                        @foreach ($listaAlumnos as $alumnoIndex => $alumno)
                        @if($alumno['empresa'] == 0)
                            {
                                title: '{{ $alumno['nombre'] }}',
                                description: 'El alumno <b>{{$alumno['nombre']}}</b> cursará <b>{{$alumno['curso']}}</b> el día <b>{{$alumno['fecha']}}</b>',
                                start: '{{ $alumno['fecha'] }}',
                                end: '{{ $alumno['fecha'] }}',
                                id: '{{ $alumno['id'] }} - {{ $alumnoIndex }}',
                            },
                            @else
                            {
                                title: '{{ $alumno['nombre'] }}',
                                description: 'El alumno <b>{{$alumno['nombre']}}</b>, que pertenece a la empresa <b>{{$alumno['empresa_nombre']}}</b> cursará <b>{{$alumno['curso']}}</b> el día <b>{{$alumno['fecha']}}</b>',
                                start: '{{ $alumno['fecha'] }}',
                                end: '{{ $alumno['fecha'] }}',
                                id: '{{ $alumno['id'] }} - {{ $alumnoIndex }}',
                            },
                            @endif
                @endforeach ],
                eventDidMount: function(info) {
                var tooltip = new bootstrap.Tooltip(info.el, {
                    title: '<h5>' + info.event.title + '</h5>' + info.event.extendedProps
                        .description,
                    placement: 'top',
                    trigger: 'hover',
                    html: true
                });
            },
        });
        calendar.render();
        });
    </script>
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <h2>{{ __('Dashboard') }}</h2>
                </div>
                <div class="card-body">
                    <h4>Calendario</h4>
                    <div id='calendar' style="height: 90vh !important;"></div>
                </div>
            </div>
        </div>
    </div>



@endsection
