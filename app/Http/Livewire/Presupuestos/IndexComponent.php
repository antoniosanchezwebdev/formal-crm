<?php

namespace App\Http\Livewire\Presupuestos;

use App\Models\Alumno;
use App\Models\Cursos;
use App\Models\Empresa;
use App\Models\Monitor;
use App\Models\Presupuestos;
use App\Models\PresupuestosAlumnoCurso;
use Livewire\Component;
use Carbon\Carbon;

class IndexComponent extends Component
{
    // public $search;
    public $presupuestos;
    public $presupuestos_original;
    public $presupuestos_relaciones;
    public $alumnos;
    public $cursos;
    public $empresas;
    public $monitores;
    public $filtro_alumno;
    public $filtro_curso;
    public $filtro_estado;
    public $temp = [];
    public $as = 0;

    protected $listeners = ['recargar' => '$refresh'];
    public function mount()
    {
        $presupuestos_original = Presupuestos::all();
        foreach ($presupuestos_original as $presupuesto) {
            $presupuesto->show = 0;
        }
        $this->presupuestos = $presupuestos_original;
        $this->presupuestos_relaciones = PresupuestosAlumnoCurso::all();
        $this->alumnos = Alumno::all();
        $this->cursos = Cursos::all();
        $this->empresas = Empresa::all();
        $this->monitores = Monitor::all();
    }

    public function getNombreMonitor($id)
    {
        $monitor = $this->monitores->where("id", $id)->first();
        if (isset($monitor)) {
            $nombre = $monitor->nombre;
            $apellido = $monitor->apellidos;
            return "$nombre $apellido";
        }
        return "No asignado";
    }
    public function getAlumno($id)
    {
        $listaAlumnos = $this->presupuestos_relaciones->where("presupuesto_id", $id)->first();
        if (isset($listaAlumnos)) {
            $alumno = $this->alumnos->where('id', $listaAlumnos->alumno_id)->first();
            if(isset($alumno)){
                $nombre = $alumno->nombre;
                $apellido = $alumno->apellidos;
                return "$nombre $apellido";
            }
        }
        return "No asignado";
    }


    public function render()
    {
        $llave = Carbon::now()->timestamp;
        // $query = PresupuestosAlumnoCurso::query(); // Inicia la consulta

        // // Se supone que la relación pivote tiene campos 'denominacion' y 'celebracion'.
        // // Ajusta esto según tu estructura.
        // if ($this->filtro_alumno) {
        //     $query->where('alumno_id', $this->filtro_alumno);
        // }

        // if ($this->filtro_curso) {
        //     $query->where('curso_id', $this->filtro_curso);
        // }

        // if($this->filtro_estado){
        //     $this->presupuestos = Presupuestos::whereIn('id', $query->pluck('presupuesto_id'))->where('estado', $this->filtro_estado)->get();
        // } else{
        //     $this->presupuestos = Presupuestos::whereIn('id', $query->pluck('presupuesto_id'))->get();

        // }


        return view('livewire.presupuestos.index-component', compact('llave'));
    }
    public function cursosFilter()
    {
        $this->comprobarFiltros();
        switch ($this->as) {
            case '1':
                foreach ($this->presupuestos as $keyss => $presupuetoFilter) {
                    if ($presupuetoFilter->estado == $this->filtro_estado) {
                        $presupuetoFilter->show = 0;
                    } else {
                        $presupuetoFilter->show = 1;
                    }
                }
                break;
            case '2':
                foreach ($this->presupuestos as $keyss => $presupuetoFilter) {
                    if (count($presupuetoFilter->alumnos) > 0) {
                        foreach ($presupuetoFilter->alumnos as $key => $row) {
                            // array_push($this->temp, $key);
                            if ($row->alumno_id == $this->filtro_alumno) {
                                $presupuetoFilter->show = 0;
                            } else {
                                $presupuetoFilter->show = 1;
                            }
                        }
                    } else {
                        $presupuetoFilter->show = 1;
                    }
                }
                break;
            case '3':
                foreach ($this->presupuestos as $keyss => $presupuetoFilter) {
                    if (count($presupuetoFilter->alumnos) > 0) {
                        foreach ($presupuetoFilter->alumnos as $key => $row) {
                            // array_push($this->temp, $key);
                            if ($row->curso_id == $this->filtro_curso) {
                                $presupuetoFilter->show = 0;
                            } else {
                                $presupuetoFilter->show = 1;
                            }
                        }
                    } else {
                        $presupuetoFilter->show = 1;
                    }
                }
                break;
            case '4':
                foreach ($this->presupuestos as $keyss => $presupuetoFilter) {
                    if (count($presupuetoFilter->alumnos) > 0) {
                        foreach ($presupuetoFilter->alumnos as $key => $row) {
                            // array_push($this->temp, $key);
                            if ($row->curso_id == $this->filtro_curso && $row->alumno_id == $this->filtro_alumno) {
                                $presupuetoFilter->show = 0;
                            } else {
                                $presupuetoFilter->show = 1;
                            }
                        }
                    } else {
                        $presupuetoFilter->show = 1;
                    }
                }
                break;
            case '5':
                foreach ($this->presupuestos as $keyss => $presupuetoFilter) {
                    if (count($presupuetoFilter->alumnos) > 0) {
                        foreach ($presupuetoFilter->alumnos as $key => $row) {
                            // array_push($this->temp, $key);
                            if ($row->curso_id == $this->filtro_curso && $presupuetoFilter->estado == $this->filtro_estado) {
                                $presupuetoFilter->show = 0;
                            } else {
                                $presupuetoFilter->show = 1;
                            }
                        }
                    } else {
                        $presupuetoFilter->show = 1;
                    }
                }
                break;
            case '6':
                foreach ($this->presupuestos as $keyss => $presupuetoFilter) {
                    if (count($presupuetoFilter->alumnos) > 0) {
                        foreach ($presupuetoFilter->alumnos as $key => $row) {
                            // array_push($this->temp, $key);
                            if ($row->alumno_id == $this->filtro_alumno && $presupuetoFilter->estado == $this->filtro_estado) {
                                $presupuetoFilter->show = 0;
                            } else {
                                $presupuetoFilter->show = 1;
                            }
                        }
                    } else {
                        $presupuetoFilter->show = 1;
                    }
                }
                break;
            case '7':
                foreach ($this->presupuestos as $keyss => $presupuetoFilter) {
                    if (count($presupuetoFilter->alumnos) > 0) {
                        foreach ($presupuetoFilter->alumnos as $key => $row) {
                            // array_push($this->temp, $key);
                            if ($row->curso_id == $this->filtro_curso && $row->alumno_id == $this->filtro_alumno && $presupuetoFilter->estado == $this->filtro_estado) {
                                $presupuetoFilter->show = 0;
                            } else {
                                $presupuetoFilter->show = 1;
                            }
                        }
                    } else {
                        $presupuetoFilter->show = 1;
                    }
                }
                break;
            case '8':
                foreach ($this->presupuestos as $keyss => $presupuetoFilter) {
                    $presupuetoFilter->show = 0;
                }
                break;
            default:
                foreach ($this->presupuestos as $keyss => $presupuetoFilter) {
                    $presupuetoFilter->show = 0;
                }
                break;
        }
    }

    public function comprobarFiltros()
    {
        if ($this->filtro_curso == null && $this->filtro_alumno == null && $this->filtro_estado != null) {
            $this->as = 1;
        }
        if ($this->filtro_curso == null && $this->filtro_alumno != null && $this->filtro_estado == null) {
            $this->as = 2;
        }
        if ($this->filtro_curso != null && $this->filtro_alumno == null && $this->filtro_estado == null) {
            $this->as = 3;
        }
        if ($this->filtro_curso != null && $this->filtro_alumno != null && $this->filtro_estado == null) {
            $this->as = 4;
        }
        if ($this->filtro_curso != null && $this->filtro_alumno == null && $this->filtro_estado != null) {
            $this->as = 5;
        }
        if ($this->filtro_curso == null && $this->filtro_alumno != null && $this->filtro_estado != null) {
            $this->as = 6;
        }
        if ($this->filtro_curso != null && $this->filtro_alumno != null && $this->filtro_estado != null) {
            $this->as = 7;
        }
        if ($this->filtro_curso == null && $this->filtro_alumno == null && $this->filtro_estado == null) {
            $this->as = 8;
        }
    }
}
