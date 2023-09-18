<?php

namespace App\Http\Livewire\Monitores;

use App\Models\Monitor;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateComponent extends Component
{

    use LivewireAlert;
    use WithFileUploads;

    public $nombre;
    public $apellidos;
    public $dni;
    public $pais;
    public $movil;
    public $email;
    public $file;
    public $firma;


    public $firmaSubida = false;

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.monitores.create-component');
    }

    public function removeImg()
    {
        if (Storage::exists("public/$this->firma")) {
            Storage::delete("public/$this->firma");
            $this->firmaSubida = false;
            $this->firma = "";
        }
    }

    //Subida de la firma
    public function save()
    {

        $validate = $this->validate(['file' => 'mimes:png,jpg,jpeg,pdf|max:2048']);


        $name = time() . '_' . $this->file->getClientOriginalName();
        if(!empty($this->firma)){
            $this->removeImg();
        }

        $this->firma = $this->file->storePubliclyAs("documents/firmas", $name, "public");


        if ($validate) {
            $this->firmaSubida = true;
        } else {
            $this->firmaSubida = false;
        }
    }

    // Al hacer submit en el formulario
    public function submit()
    {
        // Validación de datos
        $validatedData = $this->validate(
            [
                'nombre' => '',
                'apellidos' => '',
                'dni' => '',
                'pais' => '',
                'movil' => '',
                'email' => '',
                // 'firma' => '',

            ],
            // Mensajes de error
            [
                // 'nombre.required' => 'El nombre es obligatorio.',
                // 'apellidos.required' => 'Los apellidos son obligatorios.',
                // 'dni.required' => 'El DNI es obligatorio .',
                // 'pais.required' => 'El país es obligatorio .',
                // 'email.required' => 'El país es obligatorio .',
            ]
        );

       
        $validatedData['firma'] = $this->firma;

        // Guardar datos validados
        $monitoresSave = Monitor::create($validatedData);

        // Alertas de guardado exitoso
        if ($monitoresSave) {
            $this->alert('success', 'Monitor registrado correctamente!', [
                'position' => 'center',
                // 'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                // 'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del monitor!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
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
        return redirect()->route('monitores.index');
    }
}
