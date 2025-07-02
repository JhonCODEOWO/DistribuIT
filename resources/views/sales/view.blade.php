@extends('navigation/templates/template')
@section('title', 'Ver')
@section('content')
    <livewire:ui.title :title="$sale->user->name"/>
    <livewire:sales.view :sale="$sale"/>
@endsection