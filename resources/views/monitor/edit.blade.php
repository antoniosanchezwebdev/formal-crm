@extends('layouts.app')

@section('content')

@section('title', 'Monitores')


<div>
    @livewire('monitores.edit-component', ['identificador'=>$id])
</div>

@endsection

