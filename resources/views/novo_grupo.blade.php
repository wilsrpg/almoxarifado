<a href="/">Voltar</a>

<form action="cadastrar_grupo" method="post">
  <p>Nome do grupo: <input type="text" name="nome" required></p>
  <span style="vertical-align: top;">Anotações: </span>
  <textarea name="anotacoes"></textarea>
  <p>
    <span style="vertical-align: top;">Itens: </span>
    @if (count($itens))
      <select type="select" name="itens[]" multiple>
        @foreach ($itens as $item)
          <option value="<?= $item['_id'] ?>"><?= $item['nome'] ?></option>
        @endforeach
      </select>
    @else
      Não há itens cadastrados.
    @endif
  </p>
  {{--<p>Disponível: <input type="checkbox" name="disponivel" checked></p>--}}
  @csrf
  <input type="submit" value="Cadastrar">
</form>