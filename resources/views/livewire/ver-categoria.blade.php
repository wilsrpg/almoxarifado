<div>
  <p>Nome:
    @if ($link)
      <a href="/categoria/{{$id}}">{{$nome}}</a>
    @else
      {{$nome}}
    @endif
  </p>
  <p>Anotações: <br><pre>{{$anotacoes}}</pre></p>
</div>
