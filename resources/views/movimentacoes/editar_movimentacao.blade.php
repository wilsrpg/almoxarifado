@extends('layouts.layout')
@section('titulo', 'Editando movimentação: '.$movimentacao->nome.' - Almoxarifado')
@section('conteudo')

<form action="/movimentacao/{{$movimentacao->id}}/atualizar" method="post">
  @csrf
  @method('PUT')
  <p>ID: {{$movimentacao->id}}</p>
  <p>Data: <input type="date" name="data" value="{{$movimentacao->data}}"></p>
  <p>Hora: <input type="time" name="hora" value="{{$movimentacao->hora}}"></p>
  <p>Responsável por entregar: <input name="quem_entregou" value="{{$movimentacao->quem_entregou}}"></p>
  <p>Responsável por receber: <input name="quem_recebeu" value="{{$movimentacao->quem_recebeu}}"></p>
  <p>Tipo:
    <select name="tipo" onchange="mudarTipo(event)" required>
      <option value="Empréstimo" {{$movimentacao->tipo == 'Empréstimo' ? 'selected' : ''}}>Empréstimo</option>
      <option value="Devolução" {{$movimentacao->tipo == 'Devolução' ? 'selected' : ''}}>Devolução</option>
      <option value="Transferência" {{$movimentacao->tipo == 'Transferência' ? 'selected' : ''}}>Transferência</option>
    </select>
  </p>
  <p>
    <span style="vertical-align: top;">Itens: </span>
    @if (count($itens))
      <select id="itens" name="itens[]" multiple required>
        @foreach ($itens as $item)
          <option id="{{$item['_id']}}" value="{{$item['_id']}}"
            {{--class="{{$item['disponivel'] ? 'disp' : 'ndis'}}
              {{array_search($item['_id'], $movimentacao['itens']) !== false ? 'mov' : ''}}"--}}
            class="<?php
              echo $item['disponivel'] ? 'disp' : 'ndis';
              if (array_search($item['_id'], $movimentacao['itens']) !== false)
                echo ' mov';
            ?>"
            <?php
              if (array_search($item['_id'], $movimentacao['itens']) !== false)
                echo 'selected';
              elseif ($item['disponivel'] && $movimentacao->tipo != 'Empréstimo')
                echo 'disabled';
              elseif (!$item['disponivel'] && $movimentacao->tipo == 'Empréstimo')
                echo 'disabled';
            ?>
            {{--{{array_search($item['_id'], $movimentacao['itens']) !== false ? 'selected' : 
            $item['disponivel'] && $movimentacao->tipo != 'Empréstimo' ? 'disabled' : 
            !$item['disponivel'] && $movimentacao->tipo == 'Empréstimo' ? 'disabled' : ''}}--}}
          >
            {{array_search($item['_id'], $movimentacao['itens']) !== false ? '*' : ''}}
            {{$item['nome']}}
          </option>
        @endforeach
      </select>
    @else
      Não há itens cadastrados.
    @endif
    <span style="vertical-align: top;">Grupos: </span>
    @if (count($grupos))
      <select id="grupos" multiple onchange="atualizarItens(event)">
        @foreach ($grupos as $grupo)
          <option value="{{$grupo['id']}}">
            {{$grupo['nome']}}
          </option>
        @endforeach
      </select>
      @foreach ($grupos as $grupo)
        <input type="hidden" id="{{$grupo['_id']}}" value="{{implode(',', $grupo['itens'])}}">
      @endforeach
    @else
      Não há grupos cadastrados.
    @endif
    <span style="vertical-align: top;">Movimentações: </span>
    @if (count($movimentacoes))
      <select id="movimentacoes" multiple onchange="atualizarItens(event)">
        @foreach ($movimentacoes as $mov)
          <option value="{{$mov['_id']}}">
            {{date_format(date_create($mov['data']), 'd/m/Y') . ' ' . $mov['hora']}}
          </option>
        @endforeach
      </select>
      @foreach ($movimentacoes as $mov)
        <input type="hidden" id="{{$mov['_id']}}" value="{{implode(',', $mov['itens'])}}">
      @endforeach
    @else
      Não há movimentações registradas.
    @endif
  </p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$movimentacao->anotacoes}}</textarea>
  </p>
  <input type="submit" value="Salvar">
</form>

<script>
  function mudarTipo(e) {
    document.getElementById('itens').disabled = e.target.value == '';
    document.getElementById('grupos').disabled = e.target.value == '';
    document.getElementById('movimentacoes').disabled = e.target.value == '';
    if (e.target.value != '') {
      itens = document.getElementById('itens').children;
      if (e.target.value == 'Empréstimo')
        for (let i = 0; i < itens.length; i++)
          itens[i].disabled = itens[i].className.search('disp') < 0 && itens[i].className.search('mov') < 0;
      else
        for (let i = 0; i < itens.length; i++)
          itens[i].disabled = itens[i].className.search('ndis') < 0 && itens[i].className.search('mov') < 0;
    }
  }

  function atualizarItens(e) {
    //console.log(e.target.children[0].selected);
    let arr = []; //pra converter HTMLCollection em Array, pra usar forEach
    for (let i = 0; i < e.target.children.length; i++) {
      arr.push(e.target.children[i]);
    }
    //console.log(arr);
    arr.forEach(op => {
      if (document.getElementById(op.value).value) {
        let ids_dos_itens = document.getElementById(op.value).value.split(',');
        //console.log(ids_dos_itens);
        if (ids_dos_itens.length)
          ids_dos_itens.forEach(id => {
            if (op.selected && !document.getElementById(id).disabled)
              document.getElementById(id).selected = op.selected;
          });
      }
    });
  }
</script>

@endsection