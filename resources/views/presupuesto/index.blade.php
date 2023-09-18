@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.css">
<script src="//unpkg.com/alpinejs" defer></script>

@vite(['resources/sass/productos.scss'])
@endsection


@section('content')
<div>
    @livewire('presupuestos.index-component')
</div>
@endsection
