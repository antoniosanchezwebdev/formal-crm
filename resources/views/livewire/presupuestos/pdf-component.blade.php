<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>{{$numeroPresupuesto}} - {{$nombreCliente}}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            margin-left: 6%;
            margin-right: 6%;
        }

        .header {
            position: fixed;
            top: 0;
        }

        .textoHeader {
            font-size: 12px;
            margin: 2px 0;
        }

        .textoDato {
            font-size: 14px;
        }

        .textoDatoStrong {
            display: inline-block;
            width: 100px;
            margin-right: 20px;
        }

        .textoInfo {
            font-size: 12px;
        }

        .textoFirma {
            font-size: 13px;
            margin: 2px 0;
            margin-left: 40px;
        }

        .textoFooter {
            font-size: 13px;
            text-align: center;
            margin: 2px 0;

        }

        .textoCondiciones {
            font-size: 11px;
            margin: 2px 0;
        }

        .textoFinal {
            font-size: 8px;
        }

        .page_break {
            break-before: always;
            page-break-before: always;
        }

        .footer {
            position: fixed;
            left: -20;
            right: 15;
            bottom: 0;
        }


        .table thead {
            background: #f49209;
            color: white;
            text-align: center;
        }

        th p {
            margin-top: -15px;
            margin-bottom: -10px;
        }

        .table .number {
            text-align: center;
        }

        .total {
            text-align: right;
        }

        table,
        th,
        td,
        tr {
            border: 1px solid #f49a09;
        }
    </style>
</head>

<body>
    <div class="header" style="float: left; margin-bottom: 20px;">
        <p class="textoHeader"> </p>
    </div>
    <img src="{{ public_path('/assets/logo_formal.png') }}" alt="" title="" class="img-fluid" style="max-width: 200px; float: right; padding-top: -15%;">

    <div class="barraNaranja" style="clear: both; background-color: #FA3804; margin-bottom: -1%; height: 3px;"> </div>

    <br>

    <p class="textoDato"> <strong class="textoDatoStrong">Asunto:</strong> Formación {{ implode(' + ', array_unique($cursosNombre)) }}
    </p>
    <p class="textoDato"> <strong class="textoDatoStrong">Cliente:</strong> {{ $nombreCliente }} - {{ $cifCliente }} - {{ $direccionCliente }}</p>
    <p class="textoDato" style="margin-top: -20px !important;"> <strong class="textoDatoStrong" style="margin-top: -20px !important;">&nbsp;</strong> {{ $telefonoCliente }} - {{ $emailCliente }}</p>
    <p class="textoDato"> <strong class="textoDatoStrong">Fecha:</strong> {{ $fechaEmisionFormateada }}</p>
    <p class="textoDato"> <strong class="textoDatoStrong">Ref. FORMAL</strong></p>
    <p class="textoDato"> <strong class="textoDatoStrong">Ref. CLIENTE</strong></p>
    <p class="textoDato"> <strong class="textoDatoStrong">Autor:</strong> LGL , FORMAL , LA LINEA VERTICAL</p>

    <br>

    <p class="textoInfo"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Tras su amable petición de oferta presentamos a continuación nuestra mejor oferta para realización de
        los cursos de formación.</p>

    <p class="textoInfo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Los
        datos del proyecto, según los datos facilitados por ustedes y en base a los cuales se realiza el
        presente presupuesto, son los siguientes: </p>

    <p class="textoInfo">- Tipo de curso: Formación {{ implode(' + ', array_unique($cursosNombre)) }} </p>
    <p class="textoInfo">- Monitor: {{ $nombreMonitorCompleto }} </p>
    <p class="textoInfo">- Número de asistentes: {{ $numeroAlumnos }} <strong> ALUMNOS</strong> </p>
    <p class="textoInfo">- Carga horaria : SEGÚN CURSO </p>
    <p class="textoInfo">- Fechas posibles: @foreach($rango_fechas as $rango) Desde el {{ $rango['fecha_1'] }} a {{ $rango['fecha_2'] }}, @endforeach</p>
    <p class="textoInfo">- Ubicación: En las instalaciones de {{ implode(', ', $cursosCelebracion) }} </p>
    <p class="textoInfo">- Para cualquier modificación no duden en ponerse en contacto con nosotros. </p>
    <p class="textoInfo">- Condiciones de pago: las propias del cliente.</p>

    <br>

    <p class="textoInfo" style="margin-left: 40px;">Atentamente:</p>

    <img src="{{ public_path('/assets/FirmaLucas.png') }}" alt="" title="" class="img-fluid" style="max-width: 300px; margin-left: 40px;">

    <p class="textoFirma">Lucas Gonzalez Lazzaro</p>
    <p class="textoFirma">Formación</p>
    <p class="textoFirma">lucas@formal.es</p>

    <br><br>

    <div class="footer">
        <p class="textoFooter">FORMAL Camino de la Ermita nº 10 La Línea de la Concepción 11300 Cádiz , España</p>
        <p class="textoFooter">Tlf: 956763055 / Fax: 956690254 <a href="www.lalineavertical.com" style="color: #FA3804;">www.lalineavertical.com</a></p>
    </div>



    <img src="{{ public_path('/assets/logo_formal.png') }}" alt="" title="" class="img-fluid" style="max-width: 200px; float: right; padding-top: -15%;">

    <div class="barraNaranja" style="clear: both; background-color: #FA3804; margin-bottom: -1%; height: 3px;"> </div>

    <br>

    <h4>Parte I : Experiencia y Referencias</h4>
    <br>

    <p class="textoInfo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El
        Centro de Formación e Investigación de Riesgos de Trabajos en Altura FORMAL comenzó sus trabajos
        en el año 2005 , habiendo desarrollado hasta la fecha multitud de proyectos de formación para clientes
        industriales en todo el ámbito nacional, pudiendo destacar los siguientes trabajos y acuerdos </p>


    <div class="textoExperiencia">
        <p class="textoInfo">-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Somos Centro de Formación Homologado para trabajos en
            altura por la Asociación Nacional de
            Empresas de Trabajos en Altura ANETVA </p>

        <p class="textoInfo">-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Formación al personal de Contra Incendios del grupo
            CEPSA desde 2010 en rescate y seguridad en altura.
        </p>

        <p class="textoInfo">-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ciclos de formación a técnicos de primera
            intervención en BP Castellón desde el año 2008.</p>

        <p class="textoInfo">-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ciclos de formación a técnicos de primera
            intervención en Refinería REPSOL Puertollano y Repsol
            Química Puertollano desde el año 2009. </p>

        <p class="textoInfo">-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Realización de cientos de cursos de técnicas de
            trabajo vertical en los ciclos reconocidos a nivel nacional
            OF - BASIC, OF - II y OF - III. Varios cientos de alumnos han sido formados por nosotros en los últimos
            años.</p>
        <p class="textoInfo">-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Realización de cientos de cursos de técnicas de
            trabajo vertical en los ciclos reconocidos a nivel nacional
            OF - BASIC, OF - II y OF - III. Varios cientos de alumnos han sido formados por nosotros en los últimos
            años.</p>
        <p class="textoInfo">-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Formación continua al Grupo de rescate 24h para EXXON
            - MOBIL y AKERKVAERNER durante el periodo
            marzo 2006 - septiembre 2008.</p>
        <p class="textoInfo">-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Elaboración de procedimientos de rescate y evacuación
            para Grupo de rescate y apoyo a la parada en
            multitud de clientes industriales en los últimos diez años, como REPSOL en Refinerías Cartagena y
            Puertollano, CEPSA refinerías La Rábida y San Roque , Endesa Ciclos Combinados... </p>
    </div>

    <p class="textoInfo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El
        personal docente de FORMAL está compuesto por monitores formadores de trabajos verticales,
        técnicos en emergencias y profesores universitarios con Máster en Prevención de Riesgos Laborales, todos ellos
        con experiencia de más de diez años en labores docentes </p>

    <br><br><br><br><br><br><br><br><br><br>

    <div class="page_break">

        <img src="{{ public_path('/assets/logo_formal.png') }}" alt="" title="" class="img-fluid" style="max-width: 200px; float: right; padding-top: -15%;">

        <div class="barraNaranja" style="clear: both; background-color: #FA3804; margin-bottom: -1%; height: 3px;">
        </div>

        <br><br>

        <h4>Parte II : Oferta económica</h4>
        <br>

        <p class="textoInfo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Los
            precios unitarios que presentamos son los siguientes:</p>

        <br>

        <table class="table" style="font-size: 12px;">
            <thead>
                <tr>
                    <th scope="col">
                        <p>ITEM</p>
                    </th>
                    <th scope="col">
                        <p>DESCRIPCIÓN</p>
                    </th>
                    <th scope="col">
                        <p>PRECIO €/ALUMNO</p>
                    </th>
                    <th scope="col">
                        <p>HORAS</p>
                    </th>
                    <th scope="col">
                        <p>UNIDAD</p>
                    </th>
                    <th scope="col">
                        <p>TOTAL €</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cursos as $curso)
                <tr width="100%">
                    <td width="20%">{{ $curso['denominacion_curso'] }}</td>
                    <td width="40%">
                        <b>Curso:</b> {{ $curso['nombre_curso'] }}<br>
                        <b>Alumnos:</b>
                        <ul>
                            @foreach($curso['alumnos'] as $alumno)
                            <li>{{$alumno['nombre']}} ({{$alumno['dni']}})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="number" width="10%">{{ number_format($curso['precio_curso'], 2, ",") }}</td>
                    <td class="number" width="10%">{{ $curso['horas_curso'] }}</td>
                    <td class="number" width="5%">{{ count($curso['alumnos']) }}</td>
                    <td class="number" width="10%">{{ number_format($curso['precio_curso'] * count($curso['alumnos']), 2, ",") }}</td>

                </tr>
                @endforeach

                @if ($iva === "true")
                <tr>
                    <td class="total" colspan="5">TOTAL (Impuestos incluidos)</td>
                    <td>
                        {{ number_format(($PrecioTotal * 1.21) , 2, ",") }}
                    </td>
                </tr>
                @else
                <tr>
                    <td class="total" colspan="5">TOTAL (Impuestos no incluidos)</td>
                    <td>
                        {{ number_format(($PrecioTotal) , 2, ",") }}
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
        <br><br>
        @if ($iva === "true")
        <p class="textoInfo" style="margin-left: 23%">1) Precios válidos para el año en curso</p>
        <p class="textoInfo" style="margin-left: 23%">2) En caso de superar el número de alumnos, deberá avisarse al
            centro para coordinar un segundo
            monitor y modificar el precio</p>
        @else
        <p class="textoInfo" style="margin-left: 23%">1) Los precios NO incluyen el IVA </p>
        <p class="textoInfo" style="margin-left: 23%">2) Precios válidos para el año en curso</p>
        <p class="textoInfo" style="margin-left: 23%">3) En caso de superar el número de alumnos, deberá avisarse al
            centro para coordinar un segundo
            monitor y modificar el precio</p>
        @endif


        <br><br><br><br><br><br><br><br><br><br><br>

    </div>
    <div class="page_break">

        <img src="{{ public_path('/assets/logo_formal.png') }}" alt="" title="" class="img-fluid" style="max-width: 200px; float: right; padding-top: -15%;">

        <div class="barraNaranja" style="clear: both; background-color: #FA3804; margin-bottom: -1%; height: 3px;">
        </div>

        <br><br>
        <h4>Parte III : Condiciones Particulares</h4>

        <p class="textoInfo">A continuación, les resumimos las condiciones particulares de la presente oferta:</p>


        <div class="divCondiciones">
            <p class="textoCondiciones">1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nuestra empresa es miembro de ANETVA
                (Asociación
                Nacional de Empresas de Trabajos Verticales),
                cumpliendo escrupulosamente con los requerimientos a nivel de seguridad, auditorias y código
                deontológico que dicha asociación nacional exige. </p>

            <p class="textoCondiciones">2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;El Centro de formación está homologado
                por
                ANETVA.
            </p>

            <p class="textoCondiciones">3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estamos registrados en el sistema de
                proveedores
                REPRO a través de La Línea Vertical
                ( http://w ww.achilles.com/Spain), con número de proveedor 302311, donde pueden acceder a toda
                la información legal de nuestro grupo. </p>

            <p class="textoCondiciones">4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nuestros trabajadores poseen
                conocimientos en
                rescate y auto socorro acreditada, para solventar
                c ualquier situación de emergencia que pudiera presentarse durante la realización de los cursos. </p>

            <p class="textoCondiciones">5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;El Departamento de formación cuenta con
                monitores nacionales de trabajo en altura homologados
                por ANETVA, con amplia experiencia en cursos de rescate y evacuació n y seguridad en altura , y
                técnicos superiores en PRL
            </p>

            <p class="textoCondiciones">6.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Horario de Cursos: Horario 8.00 – 16.00
                de L
                - V. Si necesitan otro turno les rogamos nos lo
                especifiquen lo antes posible.
            </p>

            <p class="textoCondiciones">7.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Inclemencias meteorológicas: Si los
                cursos se
                realizan en exteriores y por caus as meteorológicas
                deben ser pospuestos (permaneciendo allí nuestro personal), se facturará al cliente el 50% del coste
                día de los monitores desplazados hasta sus instalaciones.
            </p>

            <p class="textoCondiciones">8.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ANULACIÓN DE CURSOS: En caso de anulación
                de
                pedido previo , 72hs antes, al comienzo por causas
                no achacables a FORMAL (incluyendo meteorológicas) se facturarán al cliente los costes de billetes,
                alquileres de vehículos y reservas de estancia abonadas, así como todos los gastos de aduanas y
                desplazamiento de los equipos de formac ión si procede. En caso de anulación 48hs antes o durante
                la ejecución de estos por causas no achacables a FORMAL (incluyendo meteorológicas), se
                facturará el 100% del presupuesto.
            </p>

            <p class="textoCondiciones">9.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Condiciones de pago: Transferencia
                bancaria
                antes del envío de diplomas.

            <p class="textoCondiciones">10.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;La realización de los cursos necesita
                personal en buen estado físico, siendo responsabilidad del
                cliente que los alumnos hayan superado reconocimientos médicos con protocolos de altura.

            <p class="textoCondiciones">11.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Los alumnos deberán llevar ropa de
                trabajo y
                sus epi ́s de trabajo habitual

            <p class="textoCondiciones">12.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Los precios no incluyen IVA.

            <p class="textoCondiciones">13.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si desean realizar prácticas con algún
                EPI
                específico, será suministrado por el cliente o FORMAL lo
                facturará como un extra.

            <p class="textoCondiciones">14.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;La fecha concreta de prestación de
                servicios
                será decidida de mutuo acuerdo entre ambas partes.

            <p class="textoCondiciones">15.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;El cliente será responsable de la
                dotación
                de aulas y espacios de trabajo adecuados para la
                realización de la parte teórica y práctica, cuando ésta se realice en sus instalaciones. Si necesitan
                consultar las características mínimas a cumplir, por favor con tacte con nosotros.

            <p class="textoCondiciones">16.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para comenzar los trabajos es
                imprescindible
                remitir un correo-e o fax especificando la referencia y
                aceptando las condiciones del mismo.

            <p class="textoCondiciones">17.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;En ningún caso FORMAL será responsable
                cualquiera que sea la causa, de pérdidas de negocio,
                ingresos, beneficios, datos, producción o cualquier otro daño indirecto. La responsabilidad de
                FORMAL estará siempre limitada al 15% del precio del producto o servicio contratado.
            </p>

            <br>
            <p class="textoFinal">
                De conformidad con lo establecido en la Ley Orgánica 15/99, de Protección de Datos de Carácter Personal,
                le
                informamos que lo s datos que aparecen en esta comunicación, así como los
                que nuestra empresa mantiene de Vd. y de su empresa, formarán parte de un f ichero responsabilidad de LA
                LÍNEA VERTICAL S.L. para ser tratados exclusivamente con la finalidad de
                mantener contacto y realizar las gestiones necesarias para la prestación del servicio que tiene
                contratado
                con nosotros. Podr á ejercitar sus derechos de a cceso, rectificación, cancelación y
                oposición en la dirección Camino de la Ermita 10 11300 La Línea de la Concepción, Cádiz. Si Vd. recibe
                nuestro boletín o comunicaciones con fines comerciales, promocionales y publicitarios
                y desea dejar de recibirlos, ro gamos nos lo comunique.
            </p>



        </div>
    </div>

</body>

</html>
