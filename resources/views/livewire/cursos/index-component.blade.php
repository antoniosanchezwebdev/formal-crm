@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.css">
@vite(['resources/sass/productos.scss'])
@endsection


@section('content')
<div class="container mx-auto">
    <div class="d-flex justify-content-left align-items-center">
        <h1 class="me-5">Cursos</h1>

    </div>
    <h2>Todos los cursos</h2>
    <br>
    <div class="row">
        <div class="col-3"><a href="{{ route('cursos.create') }}" class="btn btn-warning">Añadir Curso</a></div>
        <div class="col-3">
            <label for="denominacion">Filtro de denominación:</label>
            <select id="denominacion" class="form-control">
                <option value="">Todos los cursos</option>
                <option value="Sin Denominación">Cursos sin denominación</option>
                @foreach(array_unique($cursos->pluck('denominacion_id')->toArray()) as $denominacion_select)
                @if($denominacion_select != 0)
                <option value="{{rtrim($cursos_denominacion->firstWhere('id', $denominacion_select)->nombre)}}">{{$cursos_denominacion->firstWhere('id', $denominacion_select)->nombre}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <label for="celebracion">Filtro de celebración:</label>
            <select id="celebracion" class="form-control">
                <option value="">Todos los cursos</option>
                <option value="Sin Celebración">Cursos sin lugar de celebración</option>
                @foreach(array_unique($cursos->pluck('celebracion_id')->toArray()) as $celebracion_select)
                @if($celebracion_select != 0)
                <option value="{{rtrim($cursos_celebracion->firstWhere('id', $celebracion_select)->nombre)}}">{{$cursos_celebracion->firstWhere('id', $celebracion_select)->nombre}}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
    <br><br><br>

    @if (count($cursos) > 0)
    <table class="table" id="tableCursos">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Denominación</th>
                <th scope="col">Celebración</th>

                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
            <tr>
                <td>{{ $curso->nombre }}</th>
                    @if ($curso->denominacion_id == 0)
                <td>Sin Denominación</td>
                @else
                @foreach ($cursos_denominacion as $denominacion)
                @if ($denominacion->id == $curso->denominacion_id)
                <td>{{ $denominacion->nombre }}</td>
                @endif
                @endforeach
                @endif
                @if ($curso->celebracion_id == 0)
                <td>Sin Celebración</td>
                @else
                @foreach ($cursos_celebracion as $celebracion)
                @if ($celebracion->id == $curso->celebracion_id)
                <td>{{ $celebracion->nombre }}</td>
                @endif
                @endforeach
                @endif


                <td> <a href="cursos-edit/{{ $curso->id }}" class="btn btn-primary">Ver/Editar</a> </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif



</div>

</tbody>
</table>

@section('scripts')
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        console.log('entro');
        const denominacion = document.querySelector('#denominacion');
        const celebracion = document.querySelector('#celebracion');

        // Custom range filtering function
        DataTable.ext.search.push(function(settings, data, dataIndex) {

            let denominacionSelect = denominacion.value;
            let celebracionSelect = celebracion.value;
            let datosDenominacion = data[1]; // use data for the age column
            let datosCelebracion = data[2]; // use data for the age column

            if (
                (denominacionSelect === "" || denominacionSelect === datosDenominacion) &&
                (celebracionSelect === "" || celebracionSelect === datosCelebracion)
            ) {
                console.log(denominacionSelect);
                console.log(datosDenominacion);
                console.log(celebracionSelect);
                console.log(datosCelebracion);
                return true;
            }


            return false;
        });

        var table = $('#tableCursos').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            buttons: [{
                extend: 'collection',
                text: 'Exportar',
                buttons: [{
                        extend: 'pdf',
                        className: 'btn-export'
                    },
                    {
                        extend: 'excel',
                        className: 'btn-export'
                    }
                ],
                className: 'btn btn-info text-white'
            }],
            "language": {
                "lengthMenu": "Mostrando _MENU_ registros por página",
                "zeroRecords": "Nothing found - sorry",
                "info": "Mostrando página _PAGE_ of _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ total registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "zeroRecords": "No se encontraron registros coincidentes",
            }
        });

        denominacion.addEventListener('change', function() {
            table.draw();
        });

        celebracion.addEventListener('change', function() {
            table.draw();
        });

        addEventListener("resize", (event) => {
            location.reload();
        })
    });
</script>
@endsection
@endsection