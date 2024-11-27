<a href="/">Voltar</a>

@if (isset($movimentacao))
  <p>Data: {{$movimentacao->data}}</p>
  <p>Responsável: {{$movimentacao->responsavel}}</p>
  <p>Tipo: {{$movimentacao->tipo}}</p>
  <p>Itens:</p>
  @if (count($movimentacao->itens) > 0)
    <ul>
      @foreach ($movimentacao->itens as $item)
        <li><?= $item->nome ?></li>
      @endforeach
    </ul>
  @else
    <p>Nenhum</p>{{--impossível--}}
  @endif
  <p>Anotações: {{$movimentacao->anotacoes}}</p>
@elseif (isset($movimentacoes) && count($movimentacoes) > 0)
  <p>{{count($movimentacoes) . (count($movimentacoes) > 1 ? ' movimentacões:' : ' movimentação:')}}</p>
  @foreach ($movimentacoes as $movimentacao)
    <p>Data: {{$movimentacao->data}}</p>
    <p>Hora: {{$movimentacao->hora}}</p>
    <p>Responsável: {{$movimentacao->responsavel}}</p>
    <p>Tipo: {{$movimentacao->tipo}}</p>
    <p>Itens:</p>
    @if (count($movimentacao->itens) > 0)
      <ul>
        @foreach ($movimentacao->itens as $item)
          <li><?= $item->nome ?></li>
        @endforeach
      </ul>
    @else
      <p>Nenhum</p>{{--impossível--}}
    @endif
    <p>Anotações: {{$movimentacao->anotacoes}}</p>
    <br>
  @endforeach
@else
  <p>Nenhuma movimentação.</p>
@endif
