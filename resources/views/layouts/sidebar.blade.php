<style>

    

    .crmName {
        font-size: 130%;
    }
    #check {
        display: none;
    }
    .boton {
        font-size: 201%;
        position: absolute;
        top: 30;
        left: 280;
    }
    #sidebar {
        display: inline;
        position: fixed;
    }
    #cerrarSidebar{
        z-index: 100000;
        position: relative;
        width: 150px;
        height: 150px;
        display: inline;
        top: 20px;
        left: 90%;
        color: white;
        font-size: 27px;
        font-weight: bold;
    }

    /* Media Query para ordenadores con pantallas grandes */
    @media (min-width: 1414px) {
    #sidebar {
        width: 220px !important ;
    }
    #bars{
        display: none;
        left: 250px;
        top: 50px
    }
    }
 @media (max-width: 1413px) {
    #sidebar {
        width: 220px !important ;
    }
}
    /* Media Query para tablets y móviles */
    /* @media (max-width: 991px) {
    #sidebar {
        
        width: 150px;
    }
    } */
</style>

<div class="sidebarpadre">

<nav id="sidebar" class="sidebar-wrapper" style="width: 100%">

    <div class="sidebar-content">
        {{-- <a href="" id="cerrarSidebar">X</a> --}}
        @if (isset($empresa))
            <div class="sidebar-brand">
                <a href="#" class="crmName">CRM {{ $empresa->name }}</a>

                <div id="close-sidebar">
                </div>
                <div class="cerrar">
                </div>
            </div>
        @else
            <div class="sidebar-brand">
                <a href="#" class="crmName">CRM Formal S.L.</a>
                <div id="close-sidebar">
                </div>
            </div>
        @endif
        @if (isset($empresa))
            <img src="/assets/{{ $empresa->photo }}" alt="Logo" title="" class="img-fluid"
                style="max-width: 200px; padding: 0 1.2rem;"></a>
        @else
        <img src="{{ asset('images/logo_formal_fondo_negro.png') }}" class="img-fluid" alt="Logo">

        @endif

        <div class="sidebar-header">
            <div class="user-pic">
                <p style="color: white">User Image</p>
                {{-- <img class="img-fluid" src="{{ asset('images/logo_formal_fondo_negro.png') }}"
                    alt="User picture"> --}}

            </div>
            <div class="user-info">
                {{-- Si hay un usuario logeado, se pasa al sidebar --}}
                @if ($user)
                    <span class="user-name">{{ $user->name }}
                        <strong>{{ $user->surname }}</strong>
                    </span>
                    <span class="user-role">{{ $user->role }}</span>
                    <span class="user-status">
                        <i class="fa fa-circle"></i>
                        <span>Online</span>
                    </span>
                @endif

            </div>
        </div>

        <!-- sidebar-header  -->
        {{-- <div class="sidebar-search">
            <div>
                <div class="input-group">
                    <input type="text" class="form-control search-menu" placeholder="Search...">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- sidebar-search  -->
        <div class="sidebar-menu">
            <ul>
                <li class="header-menu">
                    <span>General</span>
                </li>
                <li class="">
                    <a href="/admin/alumnos">
                        <i class="fa-solid fa-user"></i>
                        <span>Alumnos</span>
                    </a>
                </li>
                <li class="">
                    <a href="/admin/empresas">
                        <i class="fas fa-building"></i>
                        <span>Empresas</span>
                    </a>
                </li>
                <li class="">
                    <a href="/admin/cursos">
                        <i class="fas fa-book"></i>
                        <span>Cursos</span>
                    </a>
                </li>
                <li class="">
                    <a href="/admin/monitores">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Monitores</span>
                    </a>
                </li>
                <li class="">
                    <a href="/admin/presupuestos">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>Presupuestos</span>
                    </a>
                </li>
                {{-- <li class="">
                    <a href="/admin/facturas">
                        <i class="fas fa-file-invoice"></i>
                        <span>Facturas</span>
                    </a>
                </li> --}}
                <li class="">
                    <a href="/admin/usuarios">
                        <i class="fa-solid fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li class="">
                    <a href="/../">
                        <i class="fa fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- <li class="">
                    <a href="/admin/factura">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Facturas</span>
                    </a>
                </li>
                <li class="">
                    <a href="/admin/clients">
                        <i class="fa-solid fa-user"></i>
                        <span>Clientes</span>
                    </a>
                </li>
                <li class="">
                    <a href="/admin/productos">
                        <i class="fa-solid fa-user"></i>
                        <span>Productos</span>
                    </a>
                </li>
                <li class="">
                    <a href="/admin/productos-categories">
                        <i class="fa-solid fa-user"></i>
                        <span>Productos Categorias</span>
                    </a>
                </li>
                <li class="">
                    <a href="/admin/iva">
                        <i class="fa-solid fa-user"></i>
                        <span>Tipos de Iva</span>
                    </a>
                </li>

                <li class="">
                    <a href="{{route('settings.index')}}">
                        <i class="fa fa-tachometer-alt"></i>
                        <span>Settings</span>
                    </a>
                </li>
                {{-- <li class="">
                    <a href="/admin/factura">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Facturas</span>
                    </a>
                </li>
                <li class="">
                    <a href="/admin/clients">
                        <i class="fa-solid fa-user"></i>
                        <span>Clientes</span>
                    </a>
                </li>
                <li class="">
                    <a href="/admin/productos">
                        <i class="fa-solid fa-user"></i>
                        <span>Productos</span>
                    </a>
                </li>
                <li class="">
                    <a href="/admin/productos-categories">
                        <i class="fa-solid fa-user"></i>
                        <span>Productos Categorias</span>
                    </a>
                </li>
                <li class="">
                    <a href="/admin/iva">
                        <i class="fa-solid fa-user"></i>
                        <span>Tipos de Iva</span>
                    </a>
                </li>

                <li class="">
                    <a href="{{route('settings.index')}}">
                        <i class="fa fa-tachometer-alt"></i>
                        <span>Settings</span>
                    </a>
                </li> --}}


            </ul>
        </div>
        <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
        <a href="#">
            <i class="fa fa-bell"></i>
            <span class="badge badge-pill badge-warning notification">3</span>
        </a>
        <a href="#">
            <i class="fa fa-envelope"></i>
            <span class="badge badge-pill badge-success notification">7</span>
        </a>
        <a href="#">
            <i class="fa fa-cog"></i>
            <span class="badge-sonar"></span>
        </a>
        <a href="#">
            <i class="fa fa-power-off"></i>
        </a>
    </div>
</nav>

<input type="checkbox" id="check">
<label for="check">
    <span class="fas fa-bars boton" id="bars" ></span>
</label>
<!-- sidebar-wrapper  -->
</div>
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    // Cambia el Sidebar
    $("#bars").on("click", function(e){
        $("#sidebar").animate({left: 0}, 200);
        setTimeout(function() {
            $("#bars").hide();
            }, 200);

    } )
    $("#cerrarSidebar").on("click", function(e){
        e.preventDefault()
        $("#sidebar").animate({left: "-100%"}, 200);
        $("#bars").show();

    } )

</script>
