<div>
  <p>Nome:
    @if ($link)
      <a href="/item/{{$id}}">{{$nome}}</a>
    @else
      {{$nome}}
    @endif
  </p>
  <p>Categoria: <a href="/categoria/{{$categoria['id']}}">{{$categoria['nome']}}</a></p>
  <p>Disponível: {{$disponivel ? 'Sim' : 'Não'}}</p>
  <p>Onde está: {{$onde_esta}}</p>
  <p>Anotações: <br><pre>{{$anotacoes}}</pre></p>
  <p>Histórico de movimentações:</p>
  <ul>
    @if (count($historico_de_movimentacoes))
      @foreach ($historico_de_movimentacoes as $id_da_movimentacao)
        <li><a href="/movimentacao/{{$id_da_movimentacao}}">{{$id_da_movimentacao}}</a></li>
      @endforeach
    @else
      <li>Nenhuma</li>
    @endif
  </ul>
</div>
