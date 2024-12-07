@extends('layouts.layout')
@section('titulo', 'Grupos - Almoxarifado')
@section('conteudo')

@if (count($grupos) > 0)
  <p>{{count($grupos) . ' grupo' . (count($grupos) > 1 ? 's' : '')}}</p>
  @foreach ($grupos as $grupo)
    <livewire:ver-grupo :grupo="$grupo" :link="true" />
    <br>
  @endforeach
@else
  <p>Nenhum grupo.</p>
@endif

@endsection