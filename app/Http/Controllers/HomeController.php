<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presupuestos;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Cursos;
use App\Models\PresupuestosAlumnoCurso;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $comienzoDeSemana = Carbon::now()->startOfWeek();
        $presupuestos = Presupuestos::where('fecha_inicio', '>=', $comienzoDeSemana)->get();
        $relacion = PresupuestosAlumnoCurso::whereIn('presupuesto_id', $presupuestos->pluck('id'))->get();
        $alumnos = Alumno::whereIn('id', $relacion->pluck('alumno_id'))->get();
        $cursos = Cursos::whereIn('id', $relacion->pluck('curso_id'))->get();
        $empresas = Empresa::all();
        $listaAlumnos = [];

        foreach ($relacion as $rel) {
            $alumno = $alumnos->where('id', $rel->alumno_id)->first();
            $curso = $cursos->where('id', $rel->curso_id)->first();

            $empresaNombre = '';
            if (Alumno::where('id', $rel->alumno_id)->exists()) {
                if ($alumno->empresa_id > 0) {
                    $empresa = $empresas->firstWhere('id', $alumno->empresa_id);
                    $empresaNombre = $empresa ? $empresa->nombre : '';
                } else {
                    $empresaNombre = "Particular";
                }

                $listaAlumnos[] = [
                    'id' => $rel->presupuesto_id,
                    'nombre' => $alumno->nombre . " " . $alumno->apellidos,
                    'empresa' => $alumno->empresa_id,
                    'curso' => $curso->nombre,
                    'empresa_nombre' => $empresaNombre,
                    'fecha' => $presupuestos->firstWhere('id', $rel->presupuesto_id)->fecha_inicio,
                ];
            }
        }
        return view('home', compact('user', 'listaAlumnos', 'presupuestos'));
    }
}
