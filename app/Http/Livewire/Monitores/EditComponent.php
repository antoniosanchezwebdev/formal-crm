<?php

namespace App\Http\Livewire\Monitores;

use App\Models\Monitor;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditComponent extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $identificador;

    public $nombre;
    public $apellidos;
    public $dni;
    public $pais;
    public $movil;
    public $email;
    public $file;
    public $firma;

    public function mount()
    {
        $monitores = Monitor::find($this->identificador);

        $this->nombre = $monitores->nombre;
        $this->apellidos = $monitores->apellidos;
        $this->dni = $monitores->dni;
        $this->pais = $monitores->pais;
        $this->movil = $monitores->movil;
        $this->email = $monitores->email;
        $this->firma = $monitores->firma;
    }

    public function render()
    {
        return view('livewire.monitores.edit-component');
    }

    public function removeImg()
    {

        if (Storage::exists("public/$this->firma")) {
            Storage::delete("public/$this->firma");
            $this->firma = "";
        }
    }

    public function save()
    {

        $validate = $this->validate(['file' => 'mimes:png,jpg,jpeg,pdf|max:2048']);


        if ($validate) {
            $name = time() . '_' . $this->file->getClientOriginalName();
            if (!empty($this->firma)) {
                $this->removeImg();
            }

            $this->firma = $this->file->storePubliclyAs("documents/firmas", $name, "public");
        }else{

        }



        // if ($validate) {
        //     $this->firmaSubida = true;
        // } else {
        //     $this->firmaSubida = false;
        // }
    }
    // Al hacer update en el formulario
    public function update()
    {
        // Validación de datos
        $this->validate(
            [
                'nombre' => '',
                'apellidos' => '',
                'dni' => '',
                'pais' => '',
                'movil' => '',
                'email' => '',
                'firma' => '',
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

        // Encuentra el monitor identificado
        $monitor = Monitor::find($this->identificador);

        // Si la firma se ha cambiado a un archivo file, se cambia el valor de rutaFirma al nuevo, si ya tiene un valor establecido será un string por lo que se queda igual
        if ($this->firma && !is_string($this->firma) && !empty($this->firma)) {
            $rutaFirma = $this->firma->path();
        } else {
            $rutaFirma = $this->firma;
        }

        // Actualizar datos validados
        $monitor->update([
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'dni' => $this->dni,
            'pais' => $this->pais,
            'movil' => $this->movil,
            'movil' => $this->movil,
            'email' => $this->email,
            'firma' => $rutaFirma,
        ]);
        if ($monitor) {
            $this->alert('success', 'Monitor actualizado correctamente!', [
                'position' => 'center',
                // 'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                // 'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del producto!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }

        session()->flash('message', 'Monitor actualizado correctamente.');

        $this->emit('productUpdated');
    }

    // Elimina el producto
    public function destroy()
    {
        // $product = Productos::find($this->identificador);
        // $product->delete();

        $this->alert('warning', '¿Seguro que desea borrar el monitor? No hay vuelta atrás', [
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
            'confirmDelete',
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('monitores.index');
    }
    // Función para cuando se llama a la alerta
    public function confirmDelete()
    {
        $monitores = Monitor::find($this->identificador);
        $monitores->delete();
        return redirect()->route('monitores.index');
    }
}
