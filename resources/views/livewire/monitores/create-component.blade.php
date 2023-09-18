@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
    <style>
        .column:last-child {
            padding-bottom: 60px;
        }

        .column::after {
            content: '';
            clear: both;
            display: block;
        }

        .column div {
            position: relative;
            float: left;
            width: 300px;
            height: 200px;
            margin: 0 0 0 25px;
            padding: 0;
        }

        .column div:first-child {
            margin-left: 0;
        }

        .column div span {
            position: absolute;
            bottom: -20px;
            left: 0;
            z-index: -1;
            display: block;
            width: 300px;
            margin: 0;
            padding: 0;
            color: #444;
            font-size: 18px;
            text-decoration: none;
            text-align: center;
            -webkit-transition: .3s ease-in-out;
            transition: .3s ease-in-out;
            opacity: 0;
        }

        figure {
            width: 300px;
            height: 200px;
            margin: 0;
            padding: 0;
            background: #fff;
            overflow: hidden;
        }

        figure:hover+span {
            bottom: -36px;
            opacity: 1;
        }

        .image figure img {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-transition: .3s ease-in-out;
            transition: .3s ease-in-out;
        }

        .image figure:hover img {
            -webkit-transform: scale(1.3);
            transform: scale(1.3);
        }
    </style>
@endsection



<div class="container mx-auto">
    <h1>Monitores</h1>
    <h2>Crear monitor</h2>
    <br>

    <form wire:submit.prevent="submit">
        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">

        <div class="mb-3 row d-flex align-items-center">
            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-10">
                <input type="text" wire:model="nombre" class="form-control" name="nombre" id="nombre"
                    placeholder="Carlos">
                @error('nombre')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3 row d-flex align-items-center">
            <label for="apellidos" class="col-sm-2 col-form-label">Apellidos </label>
            <div class="col-sm-10">
                <input type="text" wire:model="apellidos" class="form-control" name="apellidos" id="apellidos"
                    placeholder="Pérez">
                @error('apellidos')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>


        <div class="mb-3 row d-flex align-items-center">
            <label for="dni" class="col-sm-2 col-form-label">DNI </label>
            <div class="col-sm-10">
                <input type="text" wire:model="dni" class="form-control" name="dni" id="dni"
                    placeholder="7515763200P">
                @error('dni')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3 row d-flex align-items-center">
            <label for="pais" class="col-sm-2 col-form-label">País </label>
            <div class="col-sm-10">
                <input type="text" wire:model="pais" class="form-control" name="pais" id="pais"
                    placeholder="España">
                @error('pais')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3 row d-flex align-items-center">
            <label for="movil" class="col-sm-2 col-form-label">Móvil</label>
            <div class="col-sm-10">
                <input type="text" wire:model="movil" class="form-control" name="movil" id="movil"
                    placeholder="654138955">
                @error('movil')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3 row d-flex align-items-center">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" wire:model="email" class="form-control" name="email" id="email"
                    placeholder="ejemplo@gmail.com">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3 row d-flex align-items-center">
            <div class="input-group">
                <label for="firma" class="col-sm-2 col-form-label">Firma</label>
                <input type="file" wire:model="file" class="form-control" name="file" id="file"
                    placeholder="">

                <button class="btn btn-outline-secondary" wire:click="save" type="button" id="button-addon1">Guardar
                    firma</button>
            </div>
        </div>

        @if ($firmaSubida)
            <h3>Firma subida</h3>
            <div class="mb-3 column d-flex align-items-center">

                <div class="image">
                    <figure wire:click="removeImg"><img src="{{ asset("storage/$firma") }}" class="rounded"
                            height="200" width="300" />
                    </figure>
                    <span>Eliminar</span>
                </div>

            </div>
        @endIf

        <div class="mb-3 row d-flex align-items-center">
            <button type="submit" class="btn btn-outline-info">Guardar</button>
        </div>


    </form>
</div>





</div>

</tbody>
</table>
@section('scripts')
    <script>
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'
            ],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        document.addEventListener('livewire:load', function() {


        })
        $(document).ready(function() {
            console.log('select2')
            $("#datepicker").datepicker();

            $("#datepicker").on('change', function(e) {
                @this.set('fecha_nac', $('#datepicker').val());
            });

        });
    </script>
@endsection
