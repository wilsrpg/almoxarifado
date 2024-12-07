@extends('layouts.layout')
@section('titulo', 'Grupo: '.$grupo->nome.' - Almoxarifado')
@section('conteudo')

<livewire:ver-grupo :grupo="$grupo" />
<a href="/grupo/{{$grupo->id}}/editar">Editar</a>

@endsection