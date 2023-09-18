@extends('layouts.app')

@section('title', 'Alumnos')
@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.css">
@vite(['resources/sass/productos.scss'])
@endsection


@section('content')
<div class="container mx-auto">
    <div class="d-flex justify-content-left align-items-center">
        <h1 class="me-5">Alumnos</h1>

    </div>
    <h2>Todos los alumnos</h2>
    <br>
    <div class="row">
        <div class="col-3"><a href="{{ route('alumnos.create') }}" class="btn btn-warning">Añadir Alumno</a></div>
        <div class="col-3">
            <label for="empresa">Filtro de empresa:</label>
            <select id="empresa" class="form-control">
                <option value="">Todos los alumnos</option>
                <option value="Sin empresa">Alumnos particulares (sin empresa)</option>
                @foreach(array_unique($alumnos->pluck('empresa_id')->toArray()) as $empresa_select)
                @if($empresa_select != 0)
                <option value="{{rtrim($empresas->firstWhere('id', $empresa_select)->nombre)}}">{{$empresas->firstWhere('id', $empresa_select)->nombre}}</option>
                @endif
                @endforeach
            </select>
        </div>

    </div>

    @if (count($alumnos) > 0)
    <table class="table" id="tableProductos">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Empresa</th>
                <th scope="col">Email</th>
                <th scope="col">Móvil</th>
                <th scope="col">DNI</th>



                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <td>{{ $alumno->nombre }}</td>
                <td>{{ $alumno->apellidos }}</td>
                @if ($alumno->empresa_id == 0)
                <td>Sin empresa</td>
                @else
                @foreach ($empresas as $emp)
                @if ($emp->id == $alumno->empresa_id)
                <td>{{$emp->nombre}}</td>

                @endif
                @endforeach
                @endif
                <td>{{ $alumno->email }}</td>
                <td>{{ $alumno->movil }}</td>
                <td>{{ $alumno->dni }}</td>

                <td> <a href="alumnos-edit/{{ $alumno->id }}" class="btn btn-primary">Ver/Editar</a> </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif



</div>

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

        const empresa = document.querySelector('#empresa');

        // Custom range filtering function
        DataTable.ext.search.push(function(settings, data, dataIndex) {

            let empresaSelect = empresa.value;
            let datos = data[2]; // use data for the age column
            if (empresa.value == "") {
                return true;
            } else {
                if (empresaSelect == datos) {
                    console.log(empresaSelect);
                    console.log(datos);
                    return true;
                }
            }


            return false;
        });

        var table = $('#tableProductos').DataTable({
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
        // Changes to the inputs will trigger a redraw to update the table
        empresa.addEventListener('change', function() {
            table.draw();
        });
        addEventListener("resize", (event) => {
            location.reload();
        })
    });
</script>
@endsection
@endsection