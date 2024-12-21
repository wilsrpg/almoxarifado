<div>
  <p>ID:
    @if ($link)
      <a href="/movimentacao/{{$movimentacao->id}}">{{$movimentacao->id}}</a>
    @else
      {{$movimentacao->id}}
    @endif
    <?= isset($movimentacao->deletado) ? '<i>(deletado)</i>;' : '' ?>
  </p>
  <p>Data: {{$movimentacao->data ? date_format(date_create($movimentacao->data), 'd/m/Y') : ''}}</p>
  <p>Hora: {{$movimentacao->hora}}</p>
  <p>Tipo: {{$movimentacao->tipo}}</p>
  <p>Responsável por entregar: {{$movimentacao->quem_entregou}}</p>
  <p>Responsável por receber: {{$movimentacao->quem_recebeu}}</p>
  <p>Itens:</p>
  <ul>
    @if (count($movimentacao->itens) > 0)
      @foreach ($movimentacao->itens as $item)
        <li><a href="/item/{{$item->id}}">{{$item->nome}}</a></li>
      @endforeach
    @else
      <li>Nenhum</li>{{--impossível--}}
    @endif
  </ul>
  <p>Anotações: <br><pre>{{$movimentacao->anotacoes}}</pre></p>
</div>
