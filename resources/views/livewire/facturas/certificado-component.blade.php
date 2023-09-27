<!DOCTYPE html>
<html lang="en">

<style>
    html {
        margin: 0px;
    }

    .imagen-fondo {
        display: block;
        width: 100%;
    }

    .sidebar {
        width: 20px;
        height: 100%;
        background-color: #FA3804;
        position: fixed;
        /* posición fija para que la barra lateral se mantenga visible mientras se desplaza la página */
        float: right;
    }

    .textoAcreditar {
        text-align: center;
        font-size: 180%;
        color: grey;
    }

    .textoNombre {
        text-align: center;
    }

    .textoDNI {
        text-align: center;
        font-size: 150%;

    }

    .textoCurso {
        text-align: center;
        color: #FA3804;
        font-size: 200%;

    }

    .textoDescripcion {
        text-align: center;
        font-size: 130%;
        margin-left: 5%;
        margin-right: 5%;

    }

    /* .firmas{
        display: flex;
    } */

    .monitor {
        align-content: center;
        width: 45% position: absolute;
        bottom: 10%;
        right: 20%;
    }

    .monitor p {
        display: block;
        text-align: center;
        font-size: 13px;
        position: absolute;
        bottom: 6%;
        right: 15%;
    }

    .firma-monitor {
        position: absolute;
        bottom: 12%;
        right: 20%;
        width: 300px height: 200px
    }

    .imagen-firma {
        display: block;
        width: 45%;
    }

    .textoFooter {
        position: absolute;
        bottom: 2%;
        left: 5%;
        text-align: center;
        vertical-align: text-bottom;
        font-size: 80%;
    }

    body {
        font-family: "NeoTechStd", sans-serif;
    }

    /* Página 2 */

    .pagina2 {
        margin-left: 5%;
        margin-right: 20px;
    }

    .pagina2 strong {
        color: #fa2104;
        font-weight: bold;
    }

    .pagina2 h2 {
        margin-top: 40px;
        color: black !important;
        margin-bottom: -10px;
    }

    .pagina2 h3 {
        color: #FA3804 !important;
        font-size: 20px;

    }

    .pagina2 h4 {
        color: #FA3804 !important;
        margin-bottom: -15px;
        font-size: 20px;
    }

    .pagina2 p {
        margin-bottom: -15px
    }

    .sideimage {
        float: right;
        height: 100%;
    }

    .sideimage img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>




<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado</title>
</head>

<body>
    <div class="sidebar">
        <!-- Contenido de la barra lateral -->
    </div>
    <div class="contenedor-imagen">
        <img src="{{ public_path('/assets/backgroundTotal.PNG') }}" class="imagen-fondo">

        <p class="textoAcreditar">Acreditan en <strong> {{ $cursoCelebracion }} a {{ $cursoFechaCelebracion }}
            </strong> que</p>

        <h1 class="textoNombre">D. {{ $alumno->nombre }} {{ $alumno->apellidos }}</h1>

        <p class="textoDNI">Con DNI {{ $alumno->dni }} ha superado con éxito el curso, </p>

        <h1 class="textoCurso"> {{ $curso->nombre }}</h1>

        <p class="textoDescripcion">Impartido por el Centro de Formación e Investigación de Riesgos de Trabajos en
            Altura,
            con una carga lectiva total de <strong> {{ $curso->duracion }} horas </strong> celebrado el día
            {{ $cursoFechaCelebracionConBarras }}.
            El temario corresponde a las materias Prácticas y Teóricas descritas en el reverso. </p>

        <div class="firmas">
            <div>
                <img src="{{ public_path('/assets/firmas.PNG') }}" class="imagen-firma">
            </div>
            <div class="monitor">
                @if (file_exists(storage_path("app/public/$firmaMonitor")))
                    <img src="{{ storage_path("app/public/$firmaMonitor") }}" class="firma-monitor" width="150px"
                        height="100px">
                @endif
                <p>D. {{ $nombreMonitor }} <br>
                    Monitor Nacional de Trabajos Verticales ANETVA
                </p>
            </div>
        </div>
        <br>
        <p class="textoFooter">Formal S.L. www.formal.es | Camino de la Ermita, 10. Polígono Industrial Gibraltar
            11300
            La Línea de la Concepción, Cádiz, España T. +34 956 763 055 | F. +34 956 690 254 </p>
    </div>
    @if (!empty($curso->descripcion))
        <div class="pagina2">

            <div class="sideimage">
                <img src="{{ public_path('/assets/backgroundLateral.PNG') }}" class="imagen-fondo">
            </div>

            <div>{!! html_entity_decode($curso->descripcion) !!}</div>

        </div>
    @endif

</body>

</html>
