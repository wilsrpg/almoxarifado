<div>
  <p>Nome:
    @if ($link)
      <a href="/grupo/{{$id}}">{{$nome}}</a>
    @else
      {{$nome}}
    @endif
  </p>
  <p>Itens:</p>
  <ul>
    @if (count($itens) > 0)
      @foreach ($itens as $item)
        <li><a href="/item/{{$item->id}}">{{$item->nome}}</a></li>
      @endforeach
    @else
      <li>Nenhum</li>
    @endif
  </ul>
  <p>Anotações: <br><pre>{{$anotacoes}}</pre></p>
</div>
