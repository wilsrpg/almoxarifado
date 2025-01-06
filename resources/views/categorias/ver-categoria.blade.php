<div>
  <p>Nome:
    @if (!empty($link))
      <a href="/categoria/{{$categoria->id}}">{{$categoria->nome}}</a>
    @else
      {{$categoria->nome}}
    @endif
    <?= isset($categoria->deletado) ? '<i class=vermelho>(deletado)</i>' : '' ?>
  </p>
  <p>Anotações: <br><pre>{{$categoria->anotacoes}}</pre></p>
</div>
