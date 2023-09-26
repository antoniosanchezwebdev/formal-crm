<?php

namespace App\Http\Livewire\Presupuestos;

use App\Models\Presupuestos;
use App\Models\Cursos;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Monitor;
use App\Models\PresupuestosAlumnoCurso;
use App\Models\RangosFecha;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Carbon\Carbon;

class CreateComponent extends Component
{

    use LivewireAlert;

    public $numero_presupuesto;
    public $empresa_id = 0;
    public $fecha_inicio;
    public $fecha_fin;
    public $alumno_id = 0; // 0 por defecto por si no se selecciona ninguna
    public $curso_id = 0; // 0 por defecto por si no se selecciona ninguno
    public $detalles;
    public $precio = 0;
    public $descuento = 0;
    public $precioConDescuento;
    public $estado;
    public $observaciones = "";
    public $tiene_rangos_fecha = false;

    // Se usan en el mount
    public $empresaSeleccionar;
    public $alumnosSinEmpresa;
    public $alumnosConEmpresa;
    public $alumnos = [];
    public $alumnosNuevos = [];
    public $posibles_fechas = [];
    public $cursos;
    public $cursos_multiples = [];
    public $alumnos_select = [];
    public $cursos_select = [];


    public $nameAlumno;
    public $nameCurso;
    public $inputs = [];

    public $tipoCliente = 1; // Se usa para generar factura de cliente o particular
    public $stateAlumno = 0; // Para mostrar los inputs del alumno o empresa
    public $stateCurso = 0; // Para mostrar los inputs del alumno o empresa

    public $alumnoSeleccionado;
    public $empresaDeAlumno;
    public $cursoSeleccionado;

    // Monitor
    public $monitores;
    public $monitor_id = 0;

    public $i = 0;

    public function mount()
    {
        $year = Carbon::now()->year;
        $this->numero_presupuesto = "FPR-LGL-";
        $this->fecha_fin = Carbon::now()->format('Y-m-d');
        $this->alumnosSinEmpresa = Alumno::all(); // datos que se envian al select2
        $this->empresaSeleccionar = Empresa::all();
        $this->monitores = Monitor::all();

        // dd($this->alumnosConEmpresa);
        $this->cursos = Cursos::all(); // datos que se envian al select2

    }

    public function removeInput($key)
    {
        unset($this->alumnos[$key]);
        $this->alumnos = array_values($this->alumnos);
    }

    public function render()
    {
        if (isset($this->fecha_inicio)) {
            $year = substr($this->fecha_inicio, 0, 4);

            $this->numero_presupuesto = Presupuestos::whereNotNull('fecha_inicio')->whereBetween('fecha_inicio', ['01/01/' . $year, $this->fecha_inicio])->count() + 1 . "/" . $year;
        }
        $this->alumnosConEmpresa = Alumno::where('empresa_id', $this->empresa_id)->get();
        // $this->tipoCliente == 0;
        return view('livewire.presupuestos.create-component');
    }

    // Al hacer submit en el formulario
    public function submit()
    {
        // Validación de datos


        // Por cada alumno con su curso y precio, crea un nuevo campo en PresupuestoAlumnoCurso con los datos , luego suma el precio de todo y le
        // da el precio al presupuesto
        if ($this->tipoCliente == 1) {
            $this->empresa_id = 0;
        } else {
            if (!is_numeric($this->empresa_id)) {
                $empresa_nueva = Empresa::create(['nombre' => $this->empresa_id]);
                $this->empresa_id = $empresa_nueva->id;
            }
        }

        $presupuesosSave = Presupuestos::create(array(
            'numero_presupuesto' => $this->numero_presupuesto,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'monitor_id' => $this->monitor_id,
            'empresa_id' => $this->empresa_id,
            // 'nameAlumno.0' => $this->nameAlumno[0] ?? "",
            // 'nameAlumno.*' => $this->nameAlumno ?? [],
            // 'nameCurso.0' => $this->nameCurso[0] ?? "",
            // 'nameCurso.*' => $this->nameCurso ?? [],
            'detalles' => $this->detalles ?? "",
            'estado' => $this->estado ?? "Pendiente",
            'observaciones' => $this->observaciones ?? "",
            'tiene_rangos_fecha' => $this->tiene_rangos_fecha,

        ));
        $totalPrecio = 0;

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
                        $nuevo_alumno = Alumno::create(['nombre' => $nombre, 'apellidos' => $apellido]);
                        $alumnos_subidos[$alumno['alumno']] = $nuevo_alumno->id;
                        $this->alumnos[$alumnoIndex]['alumno'] = $nuevo_alumno->id;
                    } else {
                        $secciones = explode(' ', $alumno['alumno']);
                        $apellido = array_pop($secciones);
                        $nombre = implode(' ', $secciones);
                        $nuevo_alumno = Alumno::create(['nombre' => $nombre, 'apellidos' => $apellido]);
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
            if (isset($alumno['cursoMultiple']) && $alumno['cursoMultiple'] == true) {
                $dataConcepto = [
                    'presupuesto_id' => $presupuesosSave->id,
                    'alumno_id' => $alumno['alumno'],
                    'curso_id' => $alumno['curso'],
                    'precio' => $alumno['precio'],
                    'horas' => $alumno['horas'],
                ];
                $conceptos = PresupuestosAlumnoCurso::create($dataConcepto);

                foreach ($this->cursos_multiples[$alumnoIndex] as $curso) {
                    $dataConcepto = [
                        'presupuesto_id' => $presupuesosSave->id,
                        'alumno_id' => $alumno['alumno'],
                        'curso_id' => $curso['curso'],
                        'precio' => $curso['precio'],
                        'horas' => $curso['horas'],
                    ];
                    $conceptos = PresupuestosAlumnoCurso::create($dataConcepto);
                }
            } else {
                $dataConcepto = [
                    'presupuesto_id' => $presupuesosSave->id,
                    'alumno_id' => $alumno['alumno'],
                    'curso_id' => $alumno['curso'],
                    'precio' => $alumno['precio'],
                    'horas' => $alumno['horas'],
                ];
                $conceptos = PresupuestosAlumnoCurso::create($dataConcepto);
            }
        }

        $presupuesosSave->precio = $this->precio;
        $presupuesosSave->descuento = $this->descuento;
        $presupuesosSave->save();
        $alumnos_subidos = [];
        foreach ($this->posibles_fechas as $rangoIndex => $rango) {
            if ($rango['fecha_1'] != '' && $rango['fecha_2'] != '') {
                $this->tiene_rangos_fecha = true;
                RangosFecha::create(['presupuesto_id' => $presupuesosSave->id, 'fecha_1' => $rango['fecha_1'], 'fecha_2' => $rango['fecha_2']]);
            }
        }
        if ($this->tiene_rangos_fecha == true) {
            $presupuesosSave->tiene_rangos_fecha = $this->tiene_rangos_fecha;
            $presupuesosSave->save();
        }

        // Alertas de guardado exitoso
        if ($presupuesosSave) {
            $this->alert('success', '¡Presupuesto registrado correctamente!', [
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
    }

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
            'calcularPrecio',
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('presupuestos.index');
    }

    public function add()
    {
        $this->alumnos[] = ['alumno' => "", 'segundo_apellido' => true, 'curso' => "", 'cursoMultiple' => false, 'precio' => 0, 'horas' => 0];
    }
    public function addCurso($key)
    {
        $this->cursos_multiples[$key][] = ['curso' => "", 'precio' => 0, 'horas' => 0];
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
    public function addFecha()
    {
        $this->posibles_fechas[] = ['fecha_1' => '', 'fecha_2' => ''];
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
    public function updateTotalPrice()
    {
        $precio = 0;
        if (count($this->alumnos) > 0) {
            foreach ($this->alumnos as $alumnoIndex => $alumno) {
                if ($alumno['cursoMultiple'] == true) {
                    $precio += (int) $alumno["precio"];
                    foreach ($this->cursos_multiples[$alumnoIndex] as $curso) {
                        $precio += (int) $curso["precio"];
                    }
                }else{
                    $precio += $alumno["precio"];
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
}
