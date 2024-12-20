@extends('layouts.layout')
@section('titulo', 'Movimentações - Almoxarifado')
@section('conteudo')

<form action="/movimentacoes" {{--onsubmit="teste(event)"--}} onformdata="remover_campos_em_branco(event)">
  <div style="margin: 16px 0">Data: <input type="date" name="data" value="{{$filtro->data}}">
    <livewire:data-ate :dataAte="$filtro->dataAte ?? ''" />
  </div>
  <p>Hora: <input type="time" name="hora" value="{{$filtro->hora}}">
  ~ <input type="time" name="horaAte" value="{{$filtro->horaAte ?? ''}}"></p>
  <p>Responsável por entregar: <input name="quem_entregou" value="{{$filtro->quem_entregou}}"></p>
  <p>Responsável por receber: <input name="quem_recebeu" value="{{$filtro->quem_recebeu}}"></p>
  <livewire:tipo-da-movimentacao :tipo_da_movimentacao="$filtro->tipo" :opcional="true"/>
  <div style="display: flex">
    <?php
      $itens_do_conjunto = [];
      foreach ($filtro->itens as $it)
        $itens_do_conjunto[] = $itens->find($it);
      //echo '<pre>';print_r($filtro->itens);die();
    ?>
    <livewire:conjunto-de-itens
      :itens_do_conjunto="$itens_do_conjunto"
      :nome="'itens-da-movimentacao'"
      :name="'itens[]'"
      :tipo_da_movimentacao="$filtro->tipo ?? null"
    />
    <livewire:lista-de-itens
      :lista_de_itens="$itens"
      :destino="'itens-da-movimentacao'"
      :tipo_da_movimentacao="$filtro->tipo ?? null"
    />
    <livewire:lista-de-grupos
      :lista_de_grupos="$grupos"
      :lista_de_itens="$itens"
      :destino="'itens-da-movimentacao'"
      :tipo_da_movimentacao="$filtro->tipo ?? null"
    />
  </div>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$filtro->anotacoes}}</textarea>
  </p>
  <input type="submit" value="Filtrar">
  <input type="button" value="Limpar" onclick="limpar_campos()">
  </form>

@if (count($movimentacoes) > 0)
  <p>{{count($movimentacoes) . ' movimentaç' . (count($movimentacoes) > 1 ? 'ões' : 'ão')}}</p>
  @foreach ($movimentacoes as $movimentacao)
    <livewire:ver-movimentacao :movimentacao="$movimentacao" :link="true" />
    <br>
  @endforeach
@else
  <p>Nenhuma movimentação.</p>
@endif

<script>
  function remover_campos_em_branco(e) {
    if (document.getElementsByName('data')[0].value == '') e.formData.delete('data');
    if (document.getElementsByName('dataAte').length)
      if (document.getElementsByName('dataAte')[0].value == '') e.formData.delete('dataAte');
    if (document.getElementsByName('hora')[0].value == '') e.formData.delete('hora');
    if (document.getElementsByName('horaAte')[0].value == '') e.formData.delete('horaAte');
    if (document.getElementsByName('quem_entregou')[0].value == '') e.formData.delete('quem_entregou');
    if (document.getElementsByName('quem_recebeu')[0].value == '') e.formData.delete('quem_recebeu');
    if (document.getElementsByName('tipo')[0].value == '') e.formData.delete('tipo');
    if (document.getElementsByName('anotacoes')[0].value == '') e.formData.delete('anotacoes');
    //let i = '';
    //for (const value of e.formData.keys()) {
    //  i+=value+',';
    //}
    //if (!i)
    //e.formData.set('anotacoes', e.target.action);
    //console.log(e.formData);
    //console.log(Array.from(e.formData.entries()));
  }
  function teste(e) {
    e.preventDefault();
    if (Array.from(e.formData.entries()).length > 0) {
      e.target.submit();
    } else {
      window.location = e.target.action;
    }
  }

  function limpar_campos() {
    document.getElementsByName('data')[0].value = '';
    if (document.getElementsByName('dataAte').length)
      document.getElementsByName('dataAte')[0].value = '';
    document.getElementsByName('hora')[0].value = '';
    document.getElementsByName('horaAte')[0].value = '';
    document.getElementsByName('quem_entregou')[0].value = '';
    document.getElementsByName('quem_recebeu')[0].value = '';
    document.getElementsByName('tipo')[0].value = '';
    document.getElementsByName('anotacoes')[0].value = '';
  }
</script>

@endsection
