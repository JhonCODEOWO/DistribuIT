@extends('navigation/templates/template')
@section('title', 'Editar')
@section('content')
    <livewire:ui.title :title="'Editando a '.$user->name "/>
    <livewire:user.create :user="$user"/>
@endsection