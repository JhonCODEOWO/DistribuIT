@extends('navigation/templates/template')
@section('title', 'Archivos')
@section('content')
    <div class="flex justify-between mb-2">
        <livewire:ui.title title="Visualizar archivos en el servidor"/>
        <button class="btn  btn-success">Subir archivos...</button>
    </div>

    <section class="grid grid-cols-4">
        @foreach ($images as $image)
            <picture>
                <img src="" alt="{{$image->url}}">
            </picture>
        @endforeach
    </section>
@endsection