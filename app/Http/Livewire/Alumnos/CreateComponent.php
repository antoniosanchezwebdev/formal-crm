<?php

namespace App\Http\Livewire\Alumnos;

use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Localidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;

class CreateComponent extends Component
{

    use LivewireAlert;
    use WithFileUploads;

    //documentos
    public $files = [];

    public $filesPath = [];

    public $nombre;
    public $empresa_id = 0; // 0 por defecto por si no se selecciona ninguna
    public $apellidos;
    public $dni;
    public $fecha_nac;
    public $direccion;
    public $localidad;
    public $provincia;
    public $cod_postal;
    public $cod_winda;
    public $pais;
    public $telefono;
    public $movil;
    public $email;

    public $empresas;



    public function mount()
    {

        $this->empresas = Empresa::all(); // datos que se envian al select2

    }

    public function render()
    {
        return view('livewire.alumnos.create-component');
    }


    public function removeImg($index)
    {
        $path = $this->filesPath[$index];
        if (Storage::exists("public/$path")) {
            Storage::delete("public/$path");
            array_splice($this->filesPath, $index, 1);
        }
    }

    public function finishUpload($name, $tmpPath, $isMultiple)
    {

        $this->cleanupOldUploads();

        $files = collect($tmpPath)->map(function ($i) {

            return TemporaryUploadedFile::createFromLivewire($i);
        })->toArray();

        $this->emitSelf('upload:finished', $name, collect($files)->map->getFilename()->toArray());



        $files = array_merge($this->getPropertyValue($name), $files);

        // array_push($this->files, $files);

        $this->syncInput($name, $files);
    }

    public function removeElement($index)
    {
        array_splice($this->files, $index, 1);
    }

    public function save()
    {

        $validate = $this->validate(['files.*' => 'mimes:png,jpg,jpeg,pdf|max:2048']);

        foreach ($this->files as $file) {
            $name = time() . '_' . $file->getClientOriginalName();
            $path = $file->storePublicly("documents", "public",  $name);
            array_push($this->filesPath, $path);
        }
        if ($validate) {
            return true;
        } else {
            return false;
        }
    }

    public function updatedCod_postal($value)
    {
        $localidad = Localidad::where('codigoPostal', $value)->first();

        if ($localidad) {
            $this->localidad = $localidad->localidad;
            $this->provincia = $localidad->provincia;
        }
    }

    public function updatedLocalidad($value)
    {
        $localidad = Localidad::where('localidad', $value)->first();

        if ($localidad) {
            $this->cod_postal = $localidad->codigoPostal;
            $this->provincia = $localidad->provincia;
        }
    }

    public function addFiles($file)
    {
        // dd($files);
        array_push($this->files, $file);
    }
    // Al hacer submit en el formulario
    public function submit()
    {
        // $validateFiles = $this->save();
        // Validación de datos
        $validatedData = $this->validate(
            [
                'nombre' => '',
                'empresa_id' => '',
                'apellidos' => '',
                'dni' => '',
                'fecha_nac' => '',
                'direccion' => '',
                'localidad' => '',
                'provincia' => '',
                'cod_postal' => '',
                'cod_winda' => '',
                'pais' => '',
                'telefono' => '',
                'movil' => '',
                'email' => "",
                // 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',

            ],
            // Mensajes de error
            [
                // 'nombre.required' => 'El nombre es obligatorio.',
                // 'apellidos.required' => 'Los apellidos son obligatorios.',
                // 'dni.required' => 'El dni es obligatorio.',
                // 'fecha_nac.required' => 'La fecha de nacimiento es obligatoria.',
                // 'direccion.required' => 'La dirección es obligatoria.',
                // 'localidad.required' => 'La localidad es obligatoria.',
                // 'provincia.required' => 'La provincia es obligatoria.',
                // 'cod_postal.required' => 'El cod. postal es obligatorio.',
                // 'pais.required' => 'El cod. país es obligatorio.',
                // 'telefono.required' => 'El teléfono es obligatorio.',
                // 'movil.required' => 'El móvil es obligatorio.',
                // 'email.required' => 'El email es obligatorio.',
                // 'email.regex' => 'Introduce un email válido',
            ]
        );

        // if ($validateFiles) {

        $this->save();
        $filesPath = json_encode($this->filesPath);
        // Guardar datos validados
        $alumnosSave = Alumno::create(array_merge($validatedData, [
            'nombre' => $this->nombre,
            'empresa_id' => $this->empresa_id,
            'apellidos' => $this->apellidos,
            'dni' => $this->dni,
            'fecha_nac' => $this->fecha_nac,
            'direccion' => $this->direccion,
            'localidad' => $this->localidad,
            'provincia' => $this->provincia,
            'cod_postal' => $this->cod_postal,
            'cod_winda' => $this->cod_winda,
            'pais' => $this->pais,
            'telefono' => $this->telefono,
            'movil' => $this->movil,
            'email' => $this->email,
            "filesPath" => $filesPath
        ]));

        // Alertas de guardado exitoso
        if ($alumnosSave) {
            $this->alert('success', '¡Alumno registrado correctamente!', [
                'position' => 'center',
                // 'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                // 'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del alumno!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
        // }
    }

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('alumnos.index');
    }
}
