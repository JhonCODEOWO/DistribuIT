@extends('navigation/templates/template')
@section('content')
    @livewire('ui.title', ['title' => 'Bienvenido '.strtolower(auth()->user()->name)])
@endsection