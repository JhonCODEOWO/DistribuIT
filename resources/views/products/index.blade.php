@extends('navigation/templates/template')
@section('title', 'Productos')
@section('content')
    <div class="flex justify-between mb-4">
        <livewire:ui.title title="Productos"/>
        <button class="btn btn-info">Crear nuevo</button>
    </div>
    <livewire:products.table-products />
@endsection