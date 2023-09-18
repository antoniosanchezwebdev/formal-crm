@extends('layouts.app')

@section('title', 'Monitores')
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.css">
    @vite(['resources/sass/productos.scss'])
@endsection


@section('content')
    <div class="container mx-auto">
        <div class="d-flex justify-content-left align-items-center">
            <h1 class="me-5">Monitores</h1>

        </div>
        <h2>Todos los monitores</h2>
        <br>
        <a href="{{ route('monitores.create') }}" class="btn btn-warning">Añadir Monitor</a>
        <br><br><br>

        @if (count($monitores) > 0)
            <table class="table" id="tableMonitores">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Móvil</th>



                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monitores as $monitor)
                        <tr>
                            <td>{{ $monitor->nombre }}</td>
                            <td>{{ $monitor->apellidos }}</td>
                            <td>{{ $monitor->dni }}</td>
                            <td>{{ $monitor->movil }}</td>

                            <td> <a href="monitores-edit/{{ $monitor->id }}" class="btn btn-primary">Ver/Editar</a> </td>
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
            $('#tableMonitores').DataTable({
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

            addEventListener("resize", (event) => {
                location.reload();
            })
        });
    </script>
@endsection
@endsection
