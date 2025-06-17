@extends('navigation/templates/template')
@section('title', 'Usuarios')
@section('content')
    <div class="flex justify-between px-4 my-3">
        <livewire:ui.title title="Usuarios">
        <a class="btn btn-success" href="{{route('user.create')}}">Crear nuevo usuario...</a>
    </div>

  <section class="px-5 mt-10">
    <livewire:user.userstable />
  </section>
@endsection
