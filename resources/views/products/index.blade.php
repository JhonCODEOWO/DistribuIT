@extends('navigation/templates/template')
@section('title', 'Productos')
@section('content')
    <div class="flex justify-between mb-4">
        <livewire:ui.title title="Productos"/>
        <a class="btn btn-info" href="{{route('products.create')}}">Crear nuevo</a>
    </div>
    <livewire:products.table-products />
@endsection