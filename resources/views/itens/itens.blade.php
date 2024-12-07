@extends('layouts.layout')
@section('titulo', 'Itens - Almoxarifado')
@section('conteudo')

@if (count($itens) > 0)
  <p>{{count($itens) . ' ite' . (count($itens) > 1 ? 'ns' : 'm')}}</p>
  @foreach ($itens as $item)
    <livewire:ver-item :item="$item" :link="true" />
    <br>
  @endforeach
@else
  <p>Nenhum item.</p>
@endif

@endsection