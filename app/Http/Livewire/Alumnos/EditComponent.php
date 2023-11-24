<?php

namespace App\Http\Livewire\Alumnos;

use App\Models\Alumno;
use App\Models\Localidad;
use App\Models\Empresa;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;


class EditComponent extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $identificador;

    //documentos
    public $files = [];
    public $currentFiles = [];
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

    protected $listeners = [
        'updateFiles',
    ];

    public function mount()
    {
        $alumnos = Alumno::find($this->identificador);

        $this->empresas = Empresa::all(); // datos que se envian al select2


        $this->nombre = $alumnos->nombre;
        $this->empresa_id = $alumnos->empresa_id;
        $this->apellidos = $alumnos->apellidos;
        $this->dni = $alumnos->dni;
        $this->fecha_nac = $alumnos->fecha_nac;
        $this->direccion = $alumnos->direccion;
        $this->localidad = $alumnos->localidad;
        $this->provincia = $alumnos->provincia;
        $this->cod_postal = $alumnos->cod_postal;
        $this->cod_winda = $alumnos->cod_winda;
        $this->pais = $alumnos->pais;
        $this->telefono = $alumnos->telefono;
        $this->movil = $alumnos->movil;
        $this->email = $alumnos->email;
        $this->filesPath = json_decode($alumnos->filesPath) ?? [];
    }

    public function render()
    {
        return view('livewire.alumnos.edit-component');
    }

    public function cambiarCodPostal()
    {
        $localidad = Localidad::where('cod_postal', $this->cod_postal)->first();

        if ($localidad) {
            $this->localidad = $localidad->poblacion;
            $this->provincia = $localidad->provincia;
        }
    }

    public function cambiarLocalidad()
    {
        $localidad = Localidad::where('localidad', $this->localidad)->first();

        if ($localidad) {
            $this->cod_postal = $localidad->cod_postal;
            $this->provincia = $localidad->provincia;
        }
    }
    public function removeImg($index)
    {
        $path = $this->filesPath[$index];
        if (Storage::exists("public/$path")) {
            Storage::delete("public/$path");
            array_splice($this->filesPath, $index, 1);
            Alumno::find($this->identificador)->update([
                "filesPath" => $this->filesPath,
            ]);
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

        $this->syncInput($name, $files);
    }

    // public function updateFiles(){
    //     array_push($this->files, $this->newFiles);
    // }

    public function save()
    {

        $validate = $this->validate(['files.*' => 'mimes:png,jpg,jpeg,pdf|max:2048']);

        foreach ($this->files as $file) {
            $name = time() . '_' . $file->getClientOriginalName();
            $path = $file->storePublicly("documents/$this->identificador", "public",  $name);
            array_push($this->filesPath, $path);
        }
        // if ($validate) {

        //     return true;
        // } else {

        //     return false;
        // }
    }
    // Al hacer update en el formulario
    public function update()
    {
        // Validación de datos
        $this->validate(
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
            $this->save();
            $filesPath = json_encode($this->filesPath);
            // Encuentra el alumno identificado
            $alumnos = Alumno::find($this->identificador);

            // Guardar datos validados
            $alumnosSave = $alumnos->update([
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
                'filesPath' => $filesPath,

            ]);

            if ($alumnosSave) {
                $this->alert('success', '¡Alumno actualizado correctamente!', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                    'showConfirmButton' => true,
                    'onConfirmed' => 'confirmed',
                    'confirmButtonText' => 'ok',
                    'timerProgressBar' => true,
                ]);
            } else {
                $this->alert('error', '¡No se ha podido guardar la información del producto!', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                ]);
            }

            session()->flash('message', 'Alumno actualizado correctamente.');

            $this->emit('productUpdated');

    }


    // Elimina el producto
    public function destroy()
    {
        // $product = Productos::find($this->identificador);
        // $product->delete();

        $this->alert('warning', '¿Seguro que desea borrar el alumno? No hay vuelta atrás', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmDelete',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);
    }

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
            'confirmDelete'
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('alumnos.index');
    }
    // Función para cuando se llama a la alerta
    public function confirmDelete()
    {
        $alumnos = Alumno::find($this->identificador);
        $alumnos->delete();
        return redirect()->route('alumnos.index');
    }
}
