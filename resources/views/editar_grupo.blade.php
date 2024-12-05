<a href="/">Ir para página inicial</a>

<form action="/grupo/{{$grupo->id}}/atualizar" method="post">
  <p>Nome do grupo: <input type="text" name="nome" value="{{$grupo->nome}}" required></p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$grupo->anotacoes}}</textarea>
  </p>
  <p>
    <span style="vertical-align: top;">Itens: </span>
    @if (count($itens))
      <select name="itens[]" multiple>
        @foreach ($itens as $item)
          <option value="<?= $item['_id'] ?>" {{array_search($item['_id'], $grupo['itens']) !== false ? 'selected' : ''}}>
            <?= $item['nome'] ?>
          </option>
        @endforeach
      </select>
    @else
      Não há itens cadastrados.
    @endif
  </p>
  @csrf
  <input type="submit" value="Salvar">
</form>