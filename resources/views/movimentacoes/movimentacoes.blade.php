@extends('layouts.layout')
@section('titulo', 'Movimentações - Almoxarifado')
@section('conteudo')

@if (count($movimentacoes) > 0)
  <p>{{count($movimentacoes) . ' movimentaç' . (count($movimentacoes) > 1 ? 'ões' : 'ão')}}</p>
  @foreach ($movimentacoes as $movimentacao)
    <livewire:ver-movimentacao :movimentacao="$movimentacao" :link="true" />
    <br>
  @endforeach
@else
  <p>Nenhuma movimentação.</p>
@endif

@endsection