<div>
  <p>Nome:
    @if ($link)
      <a href="/grupo/{{$grupo->id}}">{{$grupo->nome}}</a>
    @else
      {{$grupo->nome}}
    @endif
    <?= isset($grupo->deletado) ? '<i class=vermelho>(deletado)</i>' : '' ?>
  </p>
  <p>Itens:</p>
  <ul>
    @if (count($grupo->itens) > 0)
      @foreach ($grupo->itens as $key => $item)
        <li>
          <a href="/item/{{$item->id}}">{{$item->nome}}</a>
          @if (isset($grupo->qtdes[$key]))
            <i>({{$grupo->qtdes[$key]}})</i>
          @endif
        </li>
      @endforeach
    @else
      <li>Nenhum</li>
    @endif
  </ul>
  <p>Anotações: <br><pre>{{$grupo->anotacoes}}</pre></p>
</div>
