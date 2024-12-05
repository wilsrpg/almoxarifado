<a href="/">Voltar</a>

@if (isset($item))
  <p>Nome: {{$item->nome}}</p>
  <p>Categoria: <a href="/categorias/{{$item->categoria}}">{{$item->categoria}}</a></p>
  <p>Disponível: {{$item->disponivel ? 'Sim' : 'Não'}}</p>
  <p>Onde está: {{$item->onde_esta}}</p>
  <p>Anotações: <br><pre>{{$item->anotacoes}}</pre></p>
  <a href="/itens/{{$item->nome}}/editar">Editar</a>
  <p>Histórico de movimentações:</p>
  <ul>
    @if (count($item->historico_de_movimentacoes))
      @foreach ($item->historico_de_movimentacoes as $id_da_movimentacao)
        <li><a href="/movimentacoes/{{$id_da_movimentacao}}">{{$id_da_movimentacao}}</a></li>
      @endforeach
    @else
      <li>Nenhuma</li>
    @endif
  </ul>

@elseif (!empty($itens))
  <p>{{count($itens) . (count($itens) > 1 ? ' itens:' : ' item:')}}</p>
  @foreach ($itens as $item)
    <p>Nome: <a href="/itens/{{$item->nome}}">{{$item->nome}}</a></p>
    <p>Categoria: <a href="/categorias/{{$item->categoria}}">{{$item->categoria}}</a></p>
    <p>Disponível: {{$item->disponivel ? 'Sim' : 'Não'}}</p>
    <p>Onde está: {{$item->onde_esta}}</p>
    <p>Anotações: {{$item->anotacoes}}</p>
    <p>Movimentações: {{count($item->historico_de_movimentacoes)}}</p>
    <br>
  @endforeach
@else
  <p>Nenhum item.</p>
@endif
