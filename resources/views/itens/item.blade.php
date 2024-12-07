@extends('layouts.layout')
@section('titulo', 'Item: '.$item->nome.' - Almoxarifado')
@section('conteudo')

<livewire:ver-item :item="$item" />
<a href="/item/{{$item->id}}/editar">Editar</a>

@endsection