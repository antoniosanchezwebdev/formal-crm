<?php

namespace App\Http\Livewire\Facturas;

use App\Models\Alumno;
use App\Models\Cursos;
use App\Models\Empresa;
use App\Models\Presupuestos;
use App\Models\Facturas;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateComponent extends Component
{

    use LivewireAlert;

    public $numero_factura;
    public $id_presupuesto = 0; // 0 por defecto por si no se selecciona ninguno
    public $fecha_emision;
    public $fecha_vencimiento;
    public $descripcion;
    public $estado = "Pendiente";
    public $metodo_pago = "No Pagado";


    public $presupuestos;

    public $estadoPresupuesto = 0;
    public $presupuestoSeleccionado;
    public $alumnoDePresupuestoSeleccionado;
    public $cursoDePresupuestoSeleccionado;

    public function mount(){
        $this->presupuestos = Presupuestos::all();
    }

    public function render()
    {
        return view('livewire.facturas.create-component');
    }


    // Al hacer submit en el formulario
    public function submit()
    {

        // Validación de datos
        $validatedData = $this->validate([
            'numero_factura' => 'required',
            'id_presupuesto' => 'required|numeric|min:1',
            'fecha_emision' => 'required',
            'fecha_vencimiento' => '',
            'descripcion' => '',
            'estado' => 'required',
            'metodo_pago' => '',

        ],
            // Mensajes de error
            [
                'numero_factura.required' => 'Indique un nº de factura.',
                'fecha_emision.required' => 'Ingrese una fecha de emisión',
                'id_presupuesto.min' => 'Seleccione un presupuesto',
            ]);

        // Guardar datos validados
        $facturasSave = Facturas::create($validatedData);

        // Alertas de guardado exitoso
        if ($facturasSave) {
            $this->alert('success', 'Factura registrada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información de la factura!', [
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
            'listarPresupuesto',
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('facturas.index');

    }

    public function hydrate() {
        $this->emit('select2');
    }

    public function listarPresupuesto($id){
            $this->id_presupuesto = $id;
        if($this->id_presupuesto != null){
            $this->estadoPresupuesto = 1;
            $this->presupuestoSeleccionado = Presupuestos::where('id', $this->id_presupuesto)->first();
            $this->alumnoDePresupuestoSeleccionado = Alumno::where('id', $this->presupuestoSeleccionado->alumno_id)->first();
            $this->cursoDePresupuestoSeleccionado = Cursos::where('id', $this->presupuestoSeleccionado->curso_id)->first();
        } else{
            $this->estadoPresupuesto = 0;

        }
    }
}
