@extends('navigation/templates/template')
@section('title', 'Editar')
@section('content')
    @livewire('ui.title', ['title' => 'Editando '.$product->name])
    <livewire:products.create :product="$product"/>
@endsection