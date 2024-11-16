<a href="/">Voltar</a>
@if ($errors->any())
{{print_r($errors->all(),true)}}
@else
<form action="registrar_devolucao" method="post">
  <p>Data: <input type="date" name="data"></p>
  <p>Hora: <input type="time" name="hora"></p>
  <p>Responsável: <input type="text" name="responsavel"></p>
  {{--<p>Tipo:
    <select name="tipo">
      <option value="" default></option>
      <option value="Empréstimo">Empréstimo</option>
      <option value="Devolução">Devolução</option>
      <option value="Aquisição">Aquisição</option>
      <option value="Exclusão">Exclusão</option>
    </select>
  </p>--}}
  <p>
    <span style="vertical-align: top;">Itens: </span>
    @if (count($itens))
      <select type="select" name="itens[]" multiple required>
        @foreach ($itens as $item)
          <option value="<?= $item['_id']?>" <?= $item['disponivel'] ? 'disabled' : '' ?>>
            <?= $item['nome']?>
          </option>
        @endforeach
      </select>
    @else
      Não há itens cadastrados.
    @endif
  </p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes"></textarea>
  </p>
  @csrf
  <input type="submit" value="Registrar">
</form>
@endif