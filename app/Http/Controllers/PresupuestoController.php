<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Cursos;
use App\Models\CursosCelebracion;
use App\Models\CursosDenominacion;
use App\Models\Empresa;
use App\Models\Monitor;
use App\Models\Presupuestos;
use App\Models\PresupuestosAlumnoCurso;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use DateTime;


class PresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = '';
        // $user = Auth::user();

        return view('presupuesto.index', compact('response'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('presupuesto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('presupuesto.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function firma()
    {
        return public_path('assets\FirmaLucas.png');
    }



    public function pdf($id, $iva)
    {

        $presupuestosAlumnoCurso = PresupuestosAlumnoCurso::where('presupuesto_id', $id)->get();

        setlocale(LC_TIME, 'Spanish');
        $presupuestoRecibido = Presupuestos::where('id', $id)->first();
        $rango_fechas = [];
        foreach($presupuestoRecibido->rangosFecha()->get() as $rangoIndex => $rango){
            if ($rango->fecha_1 == null) {
                $fecha_1 = "Sin fecha de inicio";
                $fecha_1Formateada = $fecha_1;
                $rango_fechas[$rangoIndex]['fecha_1'] = $fecha_1Formateada;
            } else {
                $fecha_1 = \Carbon\Carbon::createFromFormat('Y-m-d', $rango->fecha_1);
                $fecha_1Formateada = $fecha_1->formatLocalized('%e de %B de %Y');
                $rango_fechas[$rangoIndex]['fecha_1'] = $fecha_1Formateada;
            }
            if ($rango->fecha_2 == null) {
                $fecha_2 = "Sin fecha de fin";
                $fecha_2Formateada = $fecha_2;
                $rango_fechas[$rangoIndex]['fecha_2'] = $fecha_2Formateada;
            } else {
                $fecha_2 = \Carbon\Carbon::createFromFormat('Y-m-d', $rango->fecha_2);
                $fecha_2Formateada = $fecha_2->formatLocalized('%e de %B de %Y');
                $rango_fechas[$rangoIndex]['fecha_2'] = $fecha_2Formateada;
            }
        }
        // dd( $presupuestoRecibido->fecha_fin);


        // dd( $presupuestoRecibido->fecha_fin);
        if ($presupuestoRecibido->fecha_fin === "Sin definir" || $presupuestoRecibido->fecha_fin == null) {
            $fechaEmision = "Sin fecha de emisión";
            $fechaEmisionFormateada = $fechaEmision;
        } else {
            $fechaEmision = \Carbon\Carbon::createFromFormat('Y-m-d', $presupuestoRecibido->fecha_fin);
            $fechaEmisionFormateada = $fechaEmision->formatLocalized('%e de %B de %Y');
        }
        $numeroPresupuesto = $presupuestoRecibido->numero_presupuesto;

        $cursos = [];
        $cursosNombre = [];
        $cursosCelebracion = [];
        $alumnoCurso = [];
        $alumnosNombre = [];
        $cursosPrecioTotal = [];
        $descripcionCurso = [];
        $denominaciones = [];
        $alumnos = [];

        $monitor = Monitor::where("id", $presupuestoRecibido->monitor_id)->first();
        $monitorNombre = $monitor->nombre ?? "Sin nombre";
        $monitorApellido = $monitor->apellidos ?? "Sin apellidos";
        $nombreMonitorCompleto = "$monitorNombre $monitorApellido";

        $numeroAlumnos = 0;
        $numerosTabla = 1;
        $totalPrecioCurso = [];
        $totalCursos = 0;

        // dd(count($presupuestosAlumnoCurso));
        // Nombre del cliente, si es empresa le da el nombre de la empresa y si es cliente le da el nombre del primer cliente asociado al presupuesto
        if ($presupuestoRecibido->empresa_id > 0 && $presupuestoRecibido->empresa_id != null) {
            $empresa = Empresa::where('id', $presupuestoRecibido->empresa_id)->first();
            if($empresa->nombre == null){
                $nombreCliente = "Cliente sin nombre definido";
            }else{
                $nombreCliente = $empresa->nombre;
            }
            if($empresa->email == null){
                $emailCliente = "Cliente sin email definido";
            }else{
                $emailCliente = $empresa->email;
            }
            if($empresa->cif == null){
                $cifCliente = "Cliente sin CIF definido";
            }else{
                $cifCliente = $empresa->cif;
            }
            if($empresa->telefono == null){
            }else{
                $telefonoCliente = $empresa->telefono;
            }
            if($empresa->direccion == null || $empresa->cod_postal == null || $empresa->localidad == null){
                $telefonoCliente = "Cliente sin dirección definida";
            }else{
                $direccionCliente = $empresa->direccion . ", " . $empresa->cod_postal . ", " . $empresa->localidad;
            }
            $emailCliente = $empresa->email;
            $cifCliente = $empresa->nombre;
            $telefonoCliente = $empresa->nombre;
        } else if ($presupuestoRecibido->empresa_id == 0 || $presupuestoRecibido->empresa_id == null) {
            if (count($presupuestosAlumnoCurso) > 0) {
                $alumno = Alumno::where('id', $presupuestosAlumnoCurso[0]->alumno_id)->first();
                if($alumno == null){
                    $nombreCliente = "Cliente sin nombre definido";
                $fechaNacCliente = 'n/a';
                $cifCliente = 'n/a';
                $telefonoCliente = 'n/a';
                $direccionCliente = 'n/a';
                $emailCliente = 'n/a';
                } else{
                    $nombreCliente = $alumno->nombre . " " . $alumno->apellidos;

                    if($alumno->email == null){
                        $emailCliente = "Cliente sin email definido";
                    }else{
                        $emailCliente = $alumno->email;
                    }
                    if($alumno->cif == null){
                        $cifCliente = "Cliente sin CIF definido";
                    }else{
                        $cifCliente = $alumno->cif;
                    }
                    if($alumno->telefono == null){
                        $telefonoCliente = "Cliente sin telefono definido";
                    }else{
                        $telefonoCliente = $alumno->telefono;
                    }
                    if($alumno->direccion == null || $alumno->cod_postal == null || $alumno->localidad == null){
                        $direccionCliente = "Cliente sin dirección definida";
                    }else{
                        $direccionCliente = $alumno->direccion . ", " . $alumno->cod_postal . ", " . $alumno->localidad;
                    }
                }

            } else {
                $nombreCliente = "Cliente sin nombre definido";
                $fechaNacCliente = 'n/a';
                $cifCliente = 'n/a';
                $telefonoCliente = 'n/a';
                $direccionCliente = 'n/a';
                $emailCliente = 'n/a';
            }
        } else {
            $nombreCliente = "";
            // $nombreCliente = $nombreCliente->nombre;
        }

        // Del presupuesto recibido, se sacan los datos y se añaden a los arrays que serán impresos.
        foreach ($presupuestosAlumnoCurso as $presup) {
            $curso = Cursos::where('id', $presup->curso_id)->first();
            $cursoCelebracion = CursosCelebracion::where('id', $curso->celebracion_id)->first();


            $alumnosDeCurso = Alumno::where('id', $presup->alumno_id)->first();
            if (isset($alumnosDeCurso)) {
                array_push($alumnosNombre, $alumnosDeCurso->nombre);
            } else {
                array_push($alumnosNombre, " ");
            }

            array_push($cursos, $curso);
            array_push($cursosNombre, $curso->nombre);
            if(isset($cursoCelebracion->nombre)){
                array_push($cursosCelebracion, $cursoCelebracion->nombre);
            }
            $numeroAlumnos++;
        }

        // Borra los cursos repetidos
        // $cursos = array_unique($cursos);
        $cursosCelebracion = array_unique($cursosCelebracion);
        $cursos = array_unique($cursos);


        foreach ($cursos as $curso) {

            $denominacion = CursosDenominacion::where("id", $curso->denominacion_id)->first();
            $denominacion = is_null($denominacion) ? " " : $denominacion->nombre;
            $denominaciones[$curso->id] = $denominacion;
            $descripcion = "$curso->nombre";
            $alumnoCurso[$curso->id] = PresupuestosAlumnoCurso::whereRaw("presupuesto_id = $id and curso_id = $curso->id")->pluck("alumno_id")->toArray();
            $currentAlumnos = $alumnoCurso[$curso->id];
            foreach ($alumnoCurso as $key => $alumno) {
                // dd($alumnoCurso);
                if ($alumno == 0) {
                    $alumnos[$curso->id][$key] = 0;
                } else {
                    $alumnos[$curso->id][$key] = Alumno::where("id", $alumno)->first();
                }
            }

            $totalPrecioCurso[$curso->id] = count($alumnos[$curso->id]) * $curso->precio;
            $xd = $alumnoCurso[$curso->id];
            $descripcionCurso[$curso->id] = $descripcion;
        }



        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        // Se llama a la vista Liveware y se le pasa los productos. En la vista se epecifican los estilos del PDF
        $pdf->loadView('livewire.presupuestos.pdf-component', compact(
            'cursos',
            'cursosNombre',
            'numeroAlumnos',
            'fechaEmisionFormateada',
            'cursosCelebracion',
            'nombreCliente',
            'cifCliente',
            'direccionCliente',
            'emailCliente',
            'telefonoCliente',
            'nombreMonitorCompleto',
            'presupuestosAlumnoCurso',
            'numerosTabla',
            'alumnosNombre',
            'descripcionCurso',
            'denominaciones',
            'alumnos',
            'totalPrecioCurso',
            'iva',
            'rango_fechas'
        ));
        $pdf->render();
        $font = $pdf->getFontMetrics()->get_font("helvetica");
        $pdf->getCanvas()->page_text(65, 52, "FORMAL", $font, 10, array(0, 0, 0));
        $pdf->getCanvas()->page_text(65, 65, "$numeroPresupuesto", $font, 10, array(0, 0, 0));
        $pdf->getCanvas()->page_text(65, 78, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        return $pdf->stream();
    }

    public function certificado($id, $alumno_id, $curso_id)
    {

        // Datos a enviar al certificado
        $presupuesto = Presupuestos::where('id', $id)->first();
        // $factura = Facturas::where('id', $id)->first();
        // $presupuesto = Presupuestos::where('id', $factura->id_presupuesto)->first();
        $alumno = Alumno::where('id', $alumno_id)->first();
        $curso = Cursos::where('id', $curso_id)->first();
        $cursoCelebracion = CursosCelebracion::where('id', $curso->celebracion_id)->first();
        $id_monitor = $presupuesto->monitor_id;
        $monitor = Monitor::where('id', $id_monitor)->first();
        $firmaMonitor = $monitor->firma ?? " ";
        if (isset($monitor)) {
            $nombreMonitor = "$monitor->nombre $monitor->apellidos";
        } else {
            $nombreMonitor = " ";
        }


        // Fecha del final del curso
        $date = Carbon::createFromFormat('d/m/Y', $presupuesto->fecha_fin);
        $diaMes = $date->day;
        $nombreMes = ucfirst($date->monthName);
        $numeroMes = $date->month;
        $anioMes = $date->year;
        $cursoFechaCelebracion = $diaMes . " de " . $nombreMes . " de " . $anioMes;

        $cursoFechaCelebracionConBarras = $diaMes . "/" . $numeroMes . "/" . $anioMes;


        // Se llama a la vista Liveware y se le pasa los productos. En la vista se epecifican los estilos del PDF
        // $pdf = PDF::loadView('livewire.presupuestos.certificado-component', compact('cursoFechaCelebracionConBarras'));


        $pdf = PDF::loadView(
            'livewire.facturas.certificado-component',
            compact(
                'cursoCelebracion',
                'cursoFechaCelebracion',
                'cursoFechaCelebracionConBarras',
                'alumno',
                'curso',
                'firmaMonitor',
                'nombreMonitor'
            )
        );

        // Establece la orientación horizontal del papel
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream();
    }
}
