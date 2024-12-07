@extends('layouts.layout')
@section('titulo', 'Categorias - Almoxarifado')
@section('conteudo')

@if (count($categorias) > 0)
  <p>{{count($categorias) . ' categoria' . (count($categorias) > 1 ? 's' : '')}}</p>
  @foreach ($categorias as $categoria)
    <livewire:ver-categoria :categoria="$categoria" :link="true" />
    <br>
  @endforeach
@else
  <p>Nenhuma categoria.</p>
@endif

@endsection