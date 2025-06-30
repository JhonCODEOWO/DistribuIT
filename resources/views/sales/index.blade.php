@extends('navigation/templates/template')
@section('title', 'Pedidos')
@section('content')
    <section class="flex justify-between">
        <livewire:ui.title title="Pedidos"/>
        <a href="{{route('sales.create')}}" class="btn btn-warning">Crear pedido</a>
    </section>
    <livewire:sales.sale-list />
@endsection