<?php

namespace App\Http\Livewire\Empresas;

use App\Models\Empresa;
use App\Models\Localidad;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditComponent extends Component
{
    use LivewireAlert;

    public $identificador;

    public $nombre;
    public $telefono;
    public $direccion;
    public $cif;
    public $email;
    public $cod_postal;
    public $cod_winda;
    public $localidad;
    public $pais;
    public $persona_contacto;
    public $persona_contacto_telefono;

    public function mount()
    {
        $empresas = Empresa::find($this->identificador);

        $this->nombre = $empresas->nombre;
        $this->telefono = $empresas->telefono;
        $this->direccion = $empresas->direccion;
        $this->cif = $empresas->cif;
        $this->email = $empresas->email;
        $this->cod_postal = $empresas->cod_postal;
        $this->localidad = $empresas->localidad;
        $this->pais = $empresas->pais;
        $this->persona_contacto = $empresas->persona_contacto;
        $this->persona_contacto_telefono = $empresas->persona_contacto_telefono;
    }

    public function render()
    {
        return view('livewire.empresas.edit-component');
    }

    public function cambiarCodPostal()
    {
        $localidad = Localidad::where('cod_postal', $this->cod_postal)->first();

        if ($localidad) {
            $this->localidad = $localidad->poblacion;
        }
    }

    public function cambiarLocalidad()
    {
        $localidad = Localidad::where('localidad', $this->localidad)->first();

        if ($localidad) {
            $this->cod_postal = $localidad->cod_postal;
        }
    }
    // Al hacer update en el formulario
    public function update()
    {
        // Validación de datos
        $this->validate([
            'nombre' => '',
            'telefono' => '',
            'direccion' => '',
            'cif' => '',
            'email' => '',
            'cod_postal' => '',
            'localidad' => '',
            'pais' => '',
            'persona_contacto' => '',
            'persona_contacto_telefono' => '',
        ],
            // Mensajes de error
            [
                // 'nombre.required' => 'El nombre es obligatorio.',
                // 'telefono.required' => 'El teléfono es obligatorio.',
                // 'direccion.required' => 'La dirección es obligatoria.',
                // 'cif.required' => 'El CIF es obligatorio.',
                // 'email.required' => 'El email es obligatorio.',
                // 'email.regex' => 'Introduce un email válido',
                // 'cod_postal.required' => 'El código postal es obligatorio.',
                // 'localidad.required' => 'La localidad es obligatoria.',
                // 'pais.required' => 'El país es obligatorio.',
            ]);

        // Encuentra el identificador
        $empresas = Empresa::find($this->identificador);

        // Guardar datos validados
        $empresasSave = $empresas->update([
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'cif' => $this->cif,
            'email' => $this->email,
            'cod_postal' => $this->cod_postal,
            'localidad' => $this->localidad,
            'pais' => $this->pais,
            'persona_contacto' => $this->persona_contacto,
            'persona_contacto_telefono' => $this->persona_contacto_telefono,

        ]);

        if ($empresasSave) {
            $this->alert('success', 'Empresa actualizada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información de la empresa!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }

        session()->flash('message', 'Empresa actualizada correctamente.');

        $this->emit('productUpdated');
    }

      // Eliminación
      public function destroy(){

        $this->alert('warning', '¿Seguro que desea borrar la empresa? No hay vuelta atrás', [
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
        return redirect()->route('empresas.index');

    }
    // Función para cuando se llama a la alerta
    public function confirmDelete()
    {
        $empresas = Empresa::find($this->identificador);
        $empresas->delete();
        return redirect()->route('empresas.index');

    }
}
