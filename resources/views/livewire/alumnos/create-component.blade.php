@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
    {{-- Drag and drop css --}}
    {{-- <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" /> --}}
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
            width: 150px;
            height: 100px;
            margin: 0 0 0 25px;
            padding: 0;
        }

        .pdf>img {
            position: absolute;
            left: 25%;
            top: 25%;

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
            width: 150px;
            height: 100px;
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
    <h1>Alumnos</h1>
    <h2>Crear alumno</h2>
    <br>

    <form wire:submit.prevent="submit">
        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">

        <div class="mb-3 row d-flex align-items-center">
            <label for="nombre" class="col-sm-2 col-form-label">Nombre </label>
            <div class="col-sm-10">
                <input type="text" wire:model="nombre" class="form-control" name="nombre" id="nombre"
                    placeholder="Carlos">
                @error('nombre')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3 row d-flex align-items-center">
            <label for="empresa" class="col-sm-2 col-form-label">Empresa</label>
            <div class="col-sm-10" wire:ignore.self>
                <select id="empresa" class="form-control js-example-responsive" wire:model="empresa_id">
                    <option value="">-- Cliente por cuenta propia --</option>
                    @foreach ($empresas as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->nombre }} </option>
                    @endforeach
                </select>
                @error('empresa')
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

    {{-- no requerido --}}
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

        {{-- no requerido --}}
        <div class="mb-3 row d-flex align-items-center">
            <label for="fecha_nac" class="col-sm-2 col-form-label">Fecha Nac.</label>
            <div class="col-sm-10">
                <input type="text" wire:model.defer="fecha_nac" class="form-control" placeholder="18/02/2002"
                    id="datepicker">
                @error('fecha_nac')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- no requerido --}}
        <div class="mb-3 row d-flex align-items-center">
            <label for="direccion" class="col-sm-2 col-form-label">Dirección </label>
            <div class="col-sm-10">
                <input type="text" wire:model="direccion" class="form-control" name="direccion" id="direccion"
                    placeholder="Calle Baldomero nº 12">
                @error('direccion')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- no requerido --}}
        <div class="mb-3 row d-flex align-items-center">
            <label for="localidad" class="col-sm-2 col-form-label">Localidad </label>
            <div class="col-sm-10">
                <input type="text" wire:model.defer="localidad" class="form-control" name="localidad" id="localidad" wire:change='cambiarLocalidad'
                    placeholder="Algeciras">
                @error('localidad')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- no requerido --}}
        <div class="mb-3 row d-flex align-items-center">
            <label for="provincia" class="col-sm-2 col-form-label">Provincia </label>
            <div class="col-sm-10">
                <input type="text" wire:model="provincia" class="form-control" name="provincia" id="provincia"
                    placeholder="Cádiz">
                @error('provincia')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- no requerido --}}
        <div class="mb-3 row d-flex align-items-center">
            <label for="cod_postal" class="col-sm-2 col-form-label">Cod. Postal </label>
            <div class="col-sm-10">
                <input type="text" wire:model.defer="cod_postal" class="form-control" name="cod_postal" id="cod_postal" wire:change='cambiarCodPostal'
                    placeholder="11749">
                @error('cod_posta')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- no requerido --}}
        <div class="mb-3 row d-flex align-items-center">
            <label for="cod_winda" class="col-sm-2 col-form-label">Cod. Winda </label>
            <div class="col-sm-10">
                <input type="text" wire:model="cod_winda" class="form-control" name="cod_winda" id="cod_winda">
                @error('cod_winda')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- no requerido --}}
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

        {{-- no requerido --}}
        <div class="mb-3 row d-flex align-items-center">
            <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
            <div class="col-sm-10">
                <input type="text" wire:model="telefono" class="form-control" name="telefono" id="telefono"
                    placeholder="956812502">
                @error('telefono')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- no requerido --}}
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

         {{-- no requerido --}}
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

        {{-- <style>
            #file-dropzone {
                height: 200px;
            }
        </style> --}}
        {{--
        <div class="mb-3 row d-flex align-items-center">
            <div class="input-group"> --}}
        {{-- <label for="email" class="col-sm-2 col-form-label">Documentos</label>
        <input type="file" id="file-dropzone"  --}}
        {{-- wire:model=""  --}}
        {{-- multiple="true" name="clientFile"
            class="form-control"
            accept="application/pdf, image/png, image/jpeg, .doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"> --}}

        {{-- <div wire:loading wire:target="files" class="my-2">Cargando...</div>
        <button class="btn btn-outline-secondary" type="button" wire:click="save">Subir documentos</button> --}}
        {{--  @error('files.*')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div> --}}

        <style>
            #file-dropzone {
                display: flex;
                height: 200px;
                border: 1px dashed #000;
                align-items: center;
                justify-content: center;
            }

            #file-dropzone h3 {
                text-align: center;

            }
        </style>

        <div x-data="fileUpload()">
            <div class="flex flex-col items-center justify-center h-screen bg-slate-200"
                x-on:drop="isDroppingFile = false" x-on:drop.prevent="handleFileDrop($event)"
                x-on:dragover.prevent="isDroppingFile = true" x-on:dragleave.prevent="isDroppingFile = false">

                <div class="absolute top-0 bottom-0 left-0 right-0 z-30 flex items-center justify-center bg-blue-500 opacity-90"
                    x-show="isDropping">

                    <span class="text-3xl text-white">Release file to upload!</span>

                </div>

                <div class="" for="file-upload" id="file-dropzone">


                    <h3 class="text-3xl">Arrastra para subir</h3>

                    {{-- <em class="italic text-slate-400">(Or drag files to the page)</em> --}}

                    <div class="bg-gray-200 h-[2px] w-1/2 mt-3">

                        <div class="bg-blue-500 h-[2px]" style="transition: width 1s" :style="`width: ${progress}%;`"
                            x-show="isUploading">

                        </div>

                    </div>

                </div>
            </div>
            <input type="file" id="file-upload" wire:model="files" multiple @change="handleFileSelect"
                class="hidden" />
        </div>


        {{-- @if (count($files))

            <ul class="mt-5 list-disc">

                @foreach ($files as $key => $file)
                    <li>{{ $file->getClientOriginalName() }}
                        <button class="text-red-500"
                            wire:click.prevent="removeElement({{ $key }})">X</button>
                    </li>
                @endforeach

            </ul>

        @endif --}}

        <br>
        <br>


        @if (count($files) > 0)
            <h3>Documentos</h3>
            <div class="mb-3 column d-flex align-items-center">

                @foreach ($files as $index => $path)
                    @if (substr($path->getClientOriginalName(), strlen($path->getClientOriginalName()) - 3, 3) === 'pdf')
                        <div class="image">
                            <a href="{{ $path->temporaryUrl() }}" target="_blank">
                                <figure class="pdf"
                                {{-- wire:click="removeImg({{ $index }})" --}}
                                ><img
                                        src="{{ asset('assets/pdf_icon.png') }}" class="rounded" height="50"
                                        width="50" />
                                </figure>
                            </a>
                            <span>Ver</span>
                            <button type="button" class="btn btn-outline-danger"
                                wire:click="removeElement({{ $index }})"> Eliminar</button>
                        </div>
                    @else
                        <div class="image">
                            <a href="{{ $path->temporaryUrl() }}" target="_blank">
                            <figure {{-- wire:click="removeElement({{ $index }})" --}}><img alt="{{ $path->getClientOriginalName() }}"
                                    src="{{ $path->temporaryUrl() }}" class="rounded" height="100"
                                    width="150" />
                            </figure>
                            </a>
                            <span>Ver</span>
                            <button type="button" class="btn btn-outline-danger"
                                wire:click="removeElement({{ $index }})"> Eliminar</button>
                        </div>
                    @endIf
                @endforeach
            </div>
            <br>
            <br>
            <br>
        @endIf


        <div class="mb-3 row d-flex align-items-center">
            <button type="submit" class="btn btn-outline-info">Guardar</button>
        </div>


    </form>
</div>





</div>


@section('scripts')
    {{-- Drag and drop js --}}
    {{-- <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script> --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // const inputElement = document.querySelector("input[type='file']");



        function fileUpload() {

            return {

                isDropping: false,

                isUploading: false,

                progress: 0,
                handleFileSelect(event) {

                    if (event.target.files.length) {

                        this.uploadFiles(event.target.files)

                    }

                },
                handleFileDrop(event) {

                    if (event.dataTransfer.files.length > 0) {

                        this.uploadFiles(event.dataTransfer.files)

                    }

                },
                uploadFiles(files) {

                    const $this = this

                    this.isUploading = true

                    @this.uploadMultiple('files', files,

                        function(success) { //upload was a success and was finished

                            $this.isUploading = false

                            $this.progress = 0



                        },

                        function(error) { //an error occured

                            console.log('error', error)

                        },

                        function(event) { //upload progress was made

                            $this.progress = event.detail.progress

                        }

                    )

                },
                removeUpload(filename) {

                    @this.removeUpload('files', filename)

                },
            }

        }

        // const pond = FilePond.create(inputElement);

        // 'addfile' instead of 'FilePond:addfile'
        // pond.on('addfile', (error, file) => {
        //     if (error) {
        //         console.log('Oh no');
        //         return;
        //     }
        //         console.log('File added', file);
        //         console.log('Files ', pond.getFiles());
        //         @this.set('files', pond.getFiles());
        //         console.log('File added livewire', file);

        // });

        // var token = document.querySelector('meta[name="csrf-token"]').content;

        // FilePond.setOptions({
        //     server: {
        //         url:"/admin/alumnos-doc"
        //         // +$('meta[name="id"]').attr('content')
        //         ,
        //         headers:{
        //             "X-CRSF-TOKEN": token
        //         }
        //     }
        // })



        // document.addEventListener("livewire:load", function() {
        //     let dropzone = document.getElementById("file-dropzone");

        //     dropzone.addEventListener("dragenter", function(e) {
        //         e.preventDefault();
        //         console.log('dragenter')
        //         dropzone.classList.add("dragover");
        //     });

        //     dropzone.addEventListener("dragleave", function(e) {
        //         e.preventDefault();
        //         console.log('dragleave')
        //         dropzone.classList.remove("dragover");
        //     });

        //     dropzone.addEventListener("dragover", function(e) {
        //         console.log('dragover')
        //         e.preventDefault();
        //     });

        //     dropzone.addEventListener("drop", function(e) {
        //         // e.preventDefault();
        //         console.log('drop');
        //         dropzone.classList.remove("dragover");

        //         let files = e.dataTransfer.files;
        //         console.log(files);

        //         // @this.call('addFiles', files);
        //         // @this.call("save");
        //     });
        // });


        function crearImg(file) {
            const img = document.createElement("img");
            img.style.width = "200px";
            img.src = URL.createObjectURL(file);
            contenedorImg.appendChild(img);
        }

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

        // Dropzone.options.uploadForm = {
        //     paramName: "files[]", // El nombre que se usará para la subida
        //     uploadMultiple: false,
        //     parallelUploads: 5,
        //     clickable: '#upload-button',
        //     dictDefaultMessage: 'Or drop files here to upload',
        //     init: function() {
        //         var _this = this; // closure
        //         this.on('success', function(file, response) {
        //             if (response == 'OK') {
        //                 refreshFoldersAndItems('OK');
        //             } else {
        //                 this.defaultOptions.error(file, response.join('\n'));
        //             }
        //         });
        //     },
        //     acceptedFiles: "image/jpeg,image/pjpeg,image/png,image/gif,image/svg+xml,application/pdf,text/plain,application/zip,application/x-rar-compressed",
        //     maxFilesize: (50000 / 1000)
        // }
    </script>
@endsection
