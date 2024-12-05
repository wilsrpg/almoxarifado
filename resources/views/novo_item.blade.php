<a href="/">Ir para página inicial</a>

<form action="cadastrar_item" method="post">
  <p>Nome: <input type="text" name="nome" required></p>
  <span style="vertical-align: top;">Anotações: </span>
  <textarea name="anotacoes"></textarea>
  <p>
    <span style="vertical-align: top;">Categoria: </span>
    @if (count($categorias))
      <select name="categoria">
        <option value=""></option>
        @foreach ($categorias as $categoria)
          <option value="<?= $categoria->nome ?>"><?= $categoria->nome ?></option>
        @endforeach
      </select>
    @else
      Não há categorias cadastradas.
    @endif
  </p>
  <p>Disponível: <input type="checkbox" name="disponivel" checked></p>
  @csrf
  <input type="submit" value="Cadastrar">
</form>