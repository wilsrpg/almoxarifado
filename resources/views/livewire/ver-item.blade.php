<div>
  <p>Nome:
    @if ($link)
      <a href="/item/{{$item->id}}">{{$item->nome}}</a>
    @else
      {{$item->nome}}
    @endif
    <?= isset($item->deletado) ? '<i>(deletado)</i>;' : '' ?>
  </p>
  <p>Categoria: <a href="/categoria/{{$item->categoria['id']}}">{{$item->categoria['nome']}}</a></p>
  <p>Disponível: {{$item->disponivel ? 'Sim' : 'Não'}}</p>
  <p>Onde está: {{$item->onde_esta}}</p>
  <p>Anotações: <br><pre>{{$item->anotacoes}}</pre></p>
  <p>Histórico de movimentações:</p>
  <ul>
    @if (count($item->historico_de_movimentacoes))
      @foreach ($item->historico_de_movimentacoes as $id_da_movimentacao)
        <li><a href="/movimentacao/{{$id_da_movimentacao}}">{{$id_da_movimentacao}}</a></li>
      @endforeach
    @else
      <li>Nenhuma</li>
    @endif
  </ul>
</div>
