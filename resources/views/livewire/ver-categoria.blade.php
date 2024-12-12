<div>
  <p>Nome:
    @if ($link)
      <a href="/categoria/{{$categoria->id}}">{{$categoria->nome}}</a>
    @else
      {{$categoria->nome}}
    @endif
    <?= isset($categoria->deletado) ? '<i>(deletado)</i>;' : '' ?>
  </p>
  <p>Anotações: <br><pre>{{$categoria->anotacoes}}</pre></p>
</div>
