@extends('navigation/templates/template')
@section('title', 'Archivos')
@section('content')
    <div class="flex justify-between mb-5">
        <livewire:ui.title title="Visualizar archivos en el servidor"/>
        <button class="btn  btn-success">Subir archivos...</button>
    </div>

    <section role="alert" class="alert alert-info alert-soft mb-10">
        <p>Las imágenes almacenadas en el servidor pueden ser reutilizadas para funcionalidades globales de tus registros, por ejemplo el carrito de imágenes de un producto.</p>
    </section>

    <section>
        <livewire:files.image-list :files="$images" route="storage/global/" :is_crud="true"/>
    </section>
@endsection