<?php

namespace App\Http\Livewire\Presupuestos;

use App\Models\Presupuestos;
use App\Models\Cursos;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Monitor;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\PresupuestosAlumnoCurso;
use App\Models\RangosFecha;

class EditComponent extends Component
{
    use LivewireAlert;

    public $identificador;


    public $numero_presupuesto;
    public $empresa_id = 0;
    public $fecha_inicio;
    public $fecha_fin;
    public $alumno_id = 0; // 0 por defecto por si no se selecciona ninguna
    public $curso_id = 0; // 0 por defecto por si no se selecciona ninguna
    public $detalles;
    public $precio;
    public $precioConDescuento;
    public $estado;
    public $descuento;
    public $observaciones = "";
    public $tiene_rangos_fecha;

    // Se usan en el mount
    public $empresaSeleccionar;
    public $alumnosSinEmpresa;
    public $alumnosConEmpresa;
    public $alumnos = [];
    public $nuevo_alumno = [];
    public $nuevo_curso = [];

    public $cursos;

    public $nameAlumno = [];
    public $nameCurso;
    public $inputs = [];
    public $inputsAplicados = [];
    public $posibles_fechas = [];
    public $posibles_fechasEliminar = [];


    public $tipoCliente = 1; // Se usa para generar factura de cliente o particular
    public $stateAlumno = 0; // Para mostrar los inputs del alumno o empresa
    public $stateCurso = 0; // Para mostrar los inputs del alumno o empresa
    public $cursos_multiples = [];
    public $cursos_multiplesEliminar = [];

    public $alumnos_select = [];
    public $cursos_select = [];

    public $alumnoSeleccionado;
    public $empresaDeAlumno;
    public $cursoSeleccionado;

    public $i = 0;

    // Monitor
    public $monitores;
    public $monitor_id;

    //debug
    public $checkPreAlCurExist = false;
    public $checkHasId = false;
    public $lastInputAplicado;


    public function mount()
    {
        $presupuestos = Presupuestos::find($this->identificador);

        $this->alumnosSinEmpresa = Alumno::all(); // datos que se envian al select2
        $this->empresaSeleccionar = Empresa::all();
        $this->monitores = Monitor::all();

        // dd($this->alumnosConEmpresa);
        $this->cursos = Cursos::all(); // datos que se envian al select2

        $this->numero_presupuesto = $presupuestos->numero_presupuesto;
        $this->empresa_id = $presupuestos->empresa_id;
        $this->monitor_id = $presupuestos->monitor_id  ?? 0;
        $this->fecha_inicio = $presupuestos->fecha_inicio ?? "Sin definir";
        $this->fecha_fin = $presupuestos->fecha_fin ?? "Sin definir";
        // $this->alumno_id = $presupuestos->alumno_id;
        // $this->curso_id = $presupuestos->curso_id;
        $this->detalles = $presupuestos->detalles;
        // $this->total_sin_iva = $presupuestos->total_sin_iva;
        // $this->iva = $presupuestos->iva;
        $this->descuento = $presupuestos->descuento;
        // $this->precio = $presupuestos->precio;
        $this->estado = $presupuestos->estado;
        $this->observaciones = $presupuestos->observaciones;
        $this->descuento = $presupuestos->descuento ?? 0;

        if ($presupuestos->tiene_rangos_fecha == true) {
            $rangosFecha = RangosFecha::where('presupuesto_id', $this->identificador)->get();
            foreach ($rangosFecha as $presAlumnoCurso) {
                $this->posibles_fechas[] = ['fecha_1' => $presAlumnoCurso->fecha_1, 'fecha_2' => $presAlumnoCurso->fecha_2, 'id' => $presAlumnoCurso->id];
            }
        }

        $presupuestosAlumnosCursos = PresupuestosAlumnoCurso::where('presupuesto_id', $this->identificador)->get();

        $alumnos_existentes = [];

        foreach ($presupuestosAlumnosCursos as $presAlumnoCursoIndex => $presAlumnoCurso) {
            if (!isset($alumnos_existentes[$presAlumnoCurso->alumno_id])) {
                $alumnos_existentes[$presAlumnoCurso->alumno_id] = $presAlumnoCursoIndex;
                if ($presupuestosAlumnosCursos->where('presupuesto_id', $presAlumnoCurso->presupuesto_id)->where('alumno_id', $presAlumnoCurso->alumno_id)->count() >= 2) {
                    $dni = Alumno::find($presAlumnoCurso->alumno_id)->dni != null ? Alumno::find($presAlumnoCurso->alumno_id)->dni : '';
                    $this->alumnos[] = ['alumno' => $presAlumnoCurso->alumno_id, 'dni' => $dni, 'curso' => $presAlumnoCurso->curso_id, 'cursoMultiple' => true, 'precio' => $presAlumnoCurso->precio, 'horas' => $presAlumnoCurso->horas, 'existente' => 1, 'id' => $presAlumnoCurso->id];
                } else {
                    $dni = Alumno::find($presAlumnoCurso->alumno_id)->dni != null ? Alumno::find($presAlumnoCurso->alumno_id)->dni : '';
                    $this->alumnos[] = ['alumno' => $presAlumnoCurso->alumno_id, 'dni' => $dni, 'curso' => $presAlumnoCurso->curso_id, 'cursoMultiple' => false, 'precio' => $presAlumnoCurso->precio, 'horas' => $presAlumnoCurso->horas, 'existente' => 1, 'id' => $presAlumnoCurso->id];
                }
            } else {
                $this->cursos_multiples[$alumnos_existentes[$presAlumnoCurso->alumno_id]][] = ['curso' => $presAlumnoCurso->curso_id, 'precio' => $presAlumnoCurso->precio, 'horas' => $presAlumnoCurso->horas, 'existente' => 1, 'id' => $presAlumnoCurso->id];
            }
        }

        if ($this->empresa_id > 0) {
            $this->tipoCliente = 2;
        }

        $this->updateTotalPrice();
    }


    // Recorre los alumnos y añade la información al array inputsAplicados (En el update se usa el precio para calcular el precio total)
    public function render()
    {

        return view('livewire.presupuestos.edit-component');
    }
    public function addFecha()
    {
        $this->posibles_fechas[] = ['fecha_1' => '', 'fecha_2' => ''];
    }
    public function addPrecioMultiple($index1, $index2)
    {

        if (isset($this->cursos_multiples[$index1][$index2])) {
            if ($this->cursos_multiples[$index1][$index2]['curso'] > 0 && is_numeric($this->cursos_multiples[$index1][$index2]['curso'])) {
                $cursoSeleccionadoAdd = Cursos::where('id', $this->cursos_multiples[$index1][$index2]['curso'])->first();
                $this->cursos_multiples[$index1][$index2]['precio'] = (int) $cursoSeleccionadoAdd->precio;
                $this->updateTotalPrice();
            } else {
            }
        }
    }
    public function updateAlumno($key)
    {
        $presupuestoAlumno = $this->inputsAplicados[$key];
        $alumno = $this->nameAlumno[$key];

        $presupuestoAlumno["alumno_id"] = $alumno;

        $this->inputsAplicados[$key] = $presupuestoAlumno;
    }

    public function removeElement($index)
    {
        array_splice($this->files, $index, 1);
    }

    public function updateTotalPrice()
    {
        $precio = 0;
        if (count($this->alumnos) > 0) {
            foreach ($this->alumnos as $input) {
                if (isset($input["precio"])) {
                    $precio += $input["precio"];
                }
            }
        }

        $this->precio = $precio;
        $this->addDiscount();
    }

    public function addDiscount()
    {
        $descuento = $this->precio * ($this->descuento / 100);
        $precio = $this->precio;

        $this->precioConDescuento = $precio - $descuento;
    }

    // Al hacer update en el formulario
    public function update()
    {
        // Validación de datos


        // Encuentra el identificador
        $presupuestos = Presupuestos::find($this->identificador);

        // Recorre los inputs ya escritos y le da el valor a precio
        $totalPrecio = 0;
        foreach ($this->alumnos as $alumno) {
            $totalPrecio += $alumno['precio'];
        }
        // dd($totalPrecio);

        if ($this->tipoCliente == 1) {
            $this->empresa_id = 0;
        } else {
            if (!is_numeric($this->empresa_id)) {
                $empresa_nueva = Empresa::create(['nombre' => $this->empresa_id]);
                $this->empresa_id = $empresa_nueva->id;
            }
        }

        foreach ($this->posibles_fechas as $rangoIndex => $rango) {
            if ($rango['fecha_1'] != '' && $rango['fecha_2'] != '') {
                if (isset($rango['id'])) {
                    $rango = RangosFecha::firstWhere('id', $rango['id'])->update(['presupuesto_id' => $presupuestos->id, 'fecha_1' => $rango['fecha_1'], 'fecha_2' => $rango['fecha_2']]);
                    $this->tiene_rangos_fecha = true;
                } else {
                    $this->tiene_rangos_fecha = true;
                    RangosFecha::create(['presupuesto_id' => $presupuestos->id, 'fecha_1' => $rango['fecha_1'], 'fecha_2' => $rango['fecha_2']]);
                }
            }
        }
        if ($this->tiene_rangos_fecha == true) {
            $presupuestos->tiene_rangos_fecha = $this->tiene_rangos_fecha;
            $presupuestos->save();
        }


        // Guardar datos validados
        $presupuestosSave = $presupuestos->update([
            'numero_presupuesto' => $this->numero_presupuesto,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'empresa_id' => $this->empresa_id,
            'monitor_id' => $this->monitor_id,
            // 'alumno_id' => $this->alumno_id,
            // 'curso_id' => $this->curso_id,
            'detalles' => $this->detalles,
            'precio' => $totalPrecio,
            'descuento' => $this->descuento,
            'estado' => $this->estado,
            'observaciones' => $this->observaciones,

        ]);



        $alumnos_subidos = [];
        $cursos_subidos = [];

        foreach ($this->alumnos as $alumnoIndex => $alumno) {
            if (!is_numeric($alumno['alumno'])) {
                if (isset($alumnos_subidos[$alumno['alumno']])) {
                    $this->alumnos[$alumnoIndex]['alumno'] = $alumnos_subidos[$alumno['alumno']];
                } else {
                    if (isset($alumno['segundo_apellido']) && $alumno['segundo_apellido'] == true) {
                        $secciones = explode(' ', $alumno['alumno']);
                        $apellido2 = array_pop($secciones);
                        $apellido1 = array_pop($secciones);
                        $nombre = implode(' ', $secciones);
                        $apellido = $apellido1 . ' ' . $apellido2;
                        $nuevo_alumno = Alumno::create(['nombre' => $nombre, 'apellidos' => $apellido, 'dni' => $alumno['dni']]);
                        $alumnos_subidos[$alumno['alumno']] = $nuevo_alumno->id;
                        $this->alumnos[$alumnoIndex]['alumno'] = $nuevo_alumno->id;
                    } else {
                        $secciones = explode(' ', $alumno['alumno']);
                        $apellido = array_pop($secciones);
                        $nombre = implode(' ', $secciones);
                        $nuevo_alumno = Alumno::create(['nombre' => $nombre, 'apellidos' => $apellido, 'dni' => $alumno['dni']]);
                        $alumnos_subidos[$alumno['alumno']] = $nuevo_alumno->id;
                        $this->alumnos[$alumnoIndex]['alumno'] = $nuevo_alumno->id;
                    }
                }
            }
            if (isset($alumno['cursoMultiple']) && $alumno['cursoMultiple'] == true) {
                if (!is_numeric($alumno['curso'])) {
                    if (isset($cursos_subidos[$alumno['curso']])) {
                        $this->alumnos[$alumnoIndex]['curso'] = $cursos_subidos[$alumno['curso']];
                    } else {
                        $nuevo_curso = Cursos::create(['nombre' => $alumno['curso'], 'precio' => $alumno['precio'], 'duracion' => $alumno['horas']]);
                        $cursos_subidos[$alumno['curso']] = $nuevo_curso->id;
                        $this->alumnos[$alumnoIndex]['curso'] = $nuevo_curso->id;
                    }
                }
                foreach ($this->cursos_multiples[$alumnoIndex] as $cursoIndex => $curso) {
                    if (!is_numeric($curso['curso'])) {
                        if (isset($cursos_subidos[$curso['curso']])) {
                            $this->cursos_multiples[$alumnoIndex][$cursoIndex]['curso'] = $cursos_subidos[$curso['curso']];
                        } else {
                            $nuevo_curso = Cursos::create(['nombre' => $curso['curso'], 'precio' => $curso['precio'], 'duracion' => $curso['horas']]);
                            $cursos_subidos[$curso['curso']] = $nuevo_curso->id;
                            $this->cursos_multiples[$alumnoIndex][$cursoIndex]['curso'] = $nuevo_curso->id;
                        }
                    }
                }
            } else {
                if (!is_numeric($alumno['curso'])) {
                    if (isset($cursos_subidos[$alumno['curso']])) {
                        $this->alumnos[$alumnoIndex]['curso'] = $cursos_subidos[$alumno['curso']];
                    } else {
                        $nuevo_curso = Cursos::create(['nombre' => $alumno['curso'], 'precio' => $alumno['precio'], 'duracion' => $alumno['horas']]);
                        $cursos_subidos[$alumno['curso']] = $nuevo_curso->id;
                        $this->alumnos[$alumnoIndex]['curso'] = $nuevo_curso->id;
                    }
                }
            }
        }
        foreach ($this->alumnos as $alumnoIndex => $alumno) {
            if ($alumno['existente'] == 1) {
                if (isset($alumno['cursoMultiple']) && $alumno['cursoMultiple'] == true) {
                    $dataConcepto = [
                        'presupuesto_id' => $presupuestos->id,
                        'alumno_id' => $alumno['alumno'],
                        'curso_id' => $alumno['curso'],
                        'precio' => $alumno['precio'],
                        'horas' => $alumno['horas'],
                    ];
                    $conceptos = PresupuestosAlumnoCurso::firstWhere('id', $alumno['id'])->update($dataConcepto);

                    foreach ($this->cursos_multiples[$alumnoIndex] as $curso) {
                        if ($curso['existente'] == 1) {
                            $dataConcepto = [
                                'presupuesto_id' => $presupuestos->id,
                                'alumno_id' => $alumno['alumno'],
                                'curso_id' => $curso['curso'],
                                'precio' => $curso['precio'],
                                'horas' => $curso['horas'],
                            ];
                            $conceptos = PresupuestosAlumnoCurso::firstWhere('id', $curso['id'])->update($dataConcepto);
                        } else {
                            $dataConcepto = [
                                'presupuesto_id' => $presupuestos->id,
                                'alumno_id' => $alumno['alumno'],
                                'curso_id' => $curso['curso'],
                                'precio' => $curso['precio'],
                                'horas' => $curso['horas'],
                            ];
                            $conceptos = PresupuestosAlumnoCurso::create($dataConcepto);
                        }
                    }
                } else {
                    $dataConcepto = [
                        'presupuesto_id' => $presupuestos->id,
                        'alumno_id' => $alumno['alumno'],
                        'curso_id' => $alumno['curso'],
                        'precio' => $alumno['precio'],
                        'horas' => $alumno['horas'],
                    ];
                    $conceptos = PresupuestosAlumnoCurso::firstWhere('id', $alumno['id'])->update($dataConcepto);
                }
            } else {
                if (isset($alumno['cursoMultiple']) && $alumno['cursoMultiple'] == true) {
                    $dataConcepto = [
                        'presupuesto_id' => $presupuestos->id,
                        'alumno_id' => $alumno['alumno'],
                        'curso_id' => $alumno['curso'],
                        'precio' => $alumno['precio'],
                        'horas' => $alumno['horas'],
                    ];
                    $conceptos = PresupuestosAlumnoCurso::create($dataConcepto);

                    foreach ($this->cursos_multiples[$alumnoIndex] as $curso) {
                        $dataConcepto = [
                            'presupuesto_id' => $presupuestos->id,
                            'alumno_id' => $alumno['alumno'],
                            'curso_id' => $curso['curso'],
                            'precio' => $curso['precio'],
                            'horas' => $curso['horas'],
                        ];
                        $conceptos = PresupuestosAlumnoCurso::create($dataConcepto);
                    }
                } else {
                    $dataConcepto = [
                        'presupuesto_id' => $presupuestos->id,
                        'alumno_id' => $alumno['alumno'],
                        'curso_id' => $alumno['curso'],
                        'precio' => $alumno['precio'],
                        'horas' => $alumno['horas'],
                    ];
                    $conceptos = PresupuestosAlumnoCurso::create($dataConcepto);
                }
            }
        }

        $presupuestos->precio = $totalPrecio;

        $presupuestos->save();

        if ($presupuestosSave) {
            $this->alert('success', '¡Presupuesto actualizado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del presupuesto!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }

        session()->flash('message', 'Presupuesto actualizado correctamente.');

        $this->emit('productUpdated');
    }


    // Eliminación
    public function destroy()
    {

        $this->alert('warning', '¿Seguro que desea borrar el presupuesto? No hay vuelta atrás', [
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
            'deleteElementSwal',
            'deleteElement',
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('presupuestos.index');
    }
    // Función para cuando se llama a la alerta
    public function confirmDelete()
    {
        $presupuesto = Presupuestos::find($this->identificador);
        $presupuesto->delete();
        return redirect()->route('presupuestos.index');
    }
    public function verCertificado($id)
    {
        if (is_numeric($this->alumnos[$id]['alumno']) && is_numeric($this->alumnos[$id]['curso'])) {
            return redirect()->route('certificado.pdf', ['id' => $this->identificador, 'alumno_id' => $this->alumnos[$id]['alumno'], 'curso_id' => $this->alumnos[$id]['curso']]);
        }
    }

    public function verCertificadoMultiple($id, $id2)
    {
        if (is_numeric($this->alumnos[$id]['alumno']) && is_numeric($this->cursos_multiples[$id][$id2]['curso'])) {
            return redirect()->route('certificado.pdf', ['id' => $this->identificador, 'alumno_id' => $this->alumnos[$id]['alumno'], 'curso_id' => $this->cursos_multiples[$id][$id2]['curso']]);
        }
    }
    public function add()
    {
        $this->alumnos[] = ['alumno' => "", 'dni' => '', 'segundo_apellido' => true, 'curso' => "", 'cursoMultiple' => false, 'precio' => 0, 'horas' => 0, 'existente' => 0];
    }
    public function getDNI($id)
    {
        if (is_numeric($this->alumnos[$id]['alumno']) && $this->alumnos[$id]['alumno'] > 0) {
            $alumno = Alumno::find($this->alumnos[$id]['alumno']);
            $this->alumnos[$id]['dni'] = $alumno->dni;
        }
    }
    public function addCurso($key)
    {
        $this->cursos_multiples[$key][] = ['curso' => "", 'precio' => 0, 'horas' => 0, 'existente' => 0];
    }

    public function addPrecio($i)
    {

        if (isset($this->alumnos[$i]["curso"])) {
            if ($this->alumnos[$i]['curso'] > 0 && is_numeric($this->alumnos[$i]['curso'])) {
                $cursoSeleccionadoAdd = Cursos::where('id', $this->alumnos[$i]["curso"])->first();
                $this->alumnos[$i]['precio'] = (int) $cursoSeleccionadoAdd->precio;
                $this->updateTotalPrice();
            } else {
            }
        }
    }

    public function deleteElement($key)
    {
        unset($this->alumnos[$key]);
        $this->alumnos = array_values($this->alumnos);
    }

    public function addAlumnoSelect($texto)
    {
        if (!is_numeric($texto)) {
            $this->alumnos_select[] = $texto;
        }
    }
    public function addCursoSelect($texto)
    {
        if (!is_numeric($texto)) {
            $this->cursos_select[] = $texto;
        }
    }
}
