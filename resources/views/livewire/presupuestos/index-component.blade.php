<div class="container mx-auto">
    <div class="d-flex justify-content-left align-items-center">
        <h1 class="me-5">Presupuestos</h1>

    </div>
    <h2>Todos los presupuestos</h2>
    <br>
    <div class="row">
        <div class="col-3"><a href="{{ route('presupuestos.create') }}" class="btn btn-warning">Añadir Presupuesto</a></div>
        <div class="col-3">
            <label for="cursos">Filtro de cursos:</label>
            <select id="cursos" class="form-control" wire:model="filtro_curso" wire:change="cursosFilter()">
                <option value="{{null}}">Cualquier curso</option>
                <option value="0">Sin cursos</option>
                @foreach($cursos as $curso)
                <option value="{{$curso->id}}">{{$curso->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <label for="alumnos">Filtro de alumnos:</label>
            <select id="alumnos" class="form-control" wire:model="filtro_alumno" wire:change="cursosFilter()">
                <option value="{{null}}">Cualquier alumno</option>
                <option value="0">Sin alumnos</option>
                @foreach($alumnos as $alumno)
                <option value="{{$alumno->id}}">{{$alumno->nombre}} {{$alumno->apellido}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <label for="estado">Filtro de estado:</label>
            <select id="estado" class="form-control" wire:model="filtro_estado" wire:change="cursosFilter()">
                <option value="{{null}}">Cualquier alumno</option>
                <option value="0">Sin alumnos</option>
                @foreach(array_unique($presupuestos->pluck('estado')->toArray()) as $estado)
                <option value="{{$estado}}">{{$estado}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <br><br><br>
    <div wire:key="{{$llave}}">

        <div x-data="{}" x-init="$nextTick(() => {
            var table = $('#tablePresupuestos{{$llave}}').DataTable({
                responsive: true,
                ordering: false,
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
                'language': {
                    'lengthMenu': 'Mostrando _MENU_ registros por página',
                    'zeroRecords': 'Nothing found - sorry',
                    'info': 'Mostrando página _PAGE_ of _PAGES_',
                    'infoEmpty': 'No hay registros disponibles',
                    'infoFiltered': '(filtrado de _MAX_ total registros)',
                    'search': 'Buscar:',
                    'paginate': {
                        'first': 'Primero',
                        'last': 'Ultimo',
                        'next': 'Siguiente',
                        'previous': 'Anterior'
                    },
                    'zeroRecords': 'No se encontraron registros coincidentes',
                }
            });
        })">
            <table class="table responsive" id="tablePresupuestos{{$llave}}">
                <thead>
                    <tr>
                        <th scope="col">Número</th>
                        <th scope="col">Fecha emisión</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($presupuestos) > 0)
                    {{-- Recorre los presupuestos --}}
                    @foreach ($presupuestos->sortByDesc('updated_at') as $presup)
                    @if($presup->show < 1)
                    <tr>
                        <td>{{ $presup->numero_presupuesto }}</th>
                        <td>{{ $presup->fecha_fin ?? "No establecida"}}</th>
                        @if ($presup->empresa_id > 0)
                        <td>{{$empresas->where('id', $presup->empresa_id)->first()->nombre}}</td>
                        @else
                        @if(count($presup->alumnos()->get()) > 0)
                        <td>{{$this->getAlumno($presup->id)}}
                        @else
                        <td> Sin alumnos </td>
                         @endif
                        @endif
                        <td>{{ $presup->estado }}</td>
                        <td> <a href="presupuestos-edit/{{ $presup->id }}" class="btn btn-primary">Ver/Editar</a> </td>
                    </tr>
                    @endif
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

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
        // const denominacion = document.querySelector('#denominacion');
        // const celebracion = document.querySelector('#celebracion');

        // // Custom range filtering function
        // DataTable.ext.search.push(function(settings, data, dataIndex) {

        //     let denominacionSelect = denominacion.value;
        //     let celebracionSelect = celebracion.value;
        //     let datosDenominacion = data[1]; // use data for the age column
        //     let datosCelebracion = data[2]; // use data for the age column

        //     if (
        //         (denominacionSelect === "" || denominacionSelect === datosDenominacion) &&
        //         (celebracionSelect === "" || celebracionSelect === datosCelebracion)
        //     ) {
        //         console.log(denominacionSelect);
        //         console.log(datosDenominacion);
        //         console.log(celebracionSelect);
        //         console.log(datosCelebracion);
        //         return true;
        //     }


        //     return false;
        // });

    });
</script>
@endsection
