<a href="/">Voltar</a>
@if ($errors->any())
{{print_r($errors->all(),true)}}
@else
<form action="registrar_emprestimo" method="post">
  <p>Data: <input type="date" name="data" value="<?php echo date('Y-m-d'); ?>"></p>
  <p>Hora: <input type="time" name="hora" value="<?php echo date('H:i'); ?>"></p>
  <p>Responsável por entregar: <input type="text" name="quem_entregou"></p>
  <p>Responsável por levar: <input type="text" name="quem_levou"></p>
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
      <select name="itens[]" multiple required>
        @foreach ($itens as $item)
          <option id="<?= $item['_id'] ?>" value="<?= $item['_id'] ?>" <?= $item['disponivel'] ? '' : 'disabled' ?>>
            <?= $item['nome'] ?>
          </option>
        @endforeach
      </select>
    @else
      Não há itens cadastrados.
    @endif
    <span style="vertical-align: top;">Grupos: </span>
    @if (count($grupos))
      <select id="grupos" multiple onchange="atualizarItens(event)">
        @foreach ($grupos as $grupo)
          <option value="<?= $grupo['_id'] ?>">
            <?= $grupo['nome'] ?>
          </option>
        @endforeach
      </select>
      @foreach ($grupos as $grupo)
        <input type=hidden id="<?= $grupo['_id'] ?>" value="<?= implode(',', $grupo['itens']) ?>">
      @endforeach
    @else
      Não há grupos cadastrados.
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

<script>
  function atualizarItens(e) {
    //console.log(e.target.children[0].selected);
    let arr = []; //pra converter HTMLCollection em Array, pra usar forEach
    for (let i = 0; i < e.target.children.length; i++) {
      arr.push(e.target.children[i]);
    }
    //console.log(arr);
    arr.forEach(op => {
      if (document.getElementById(op.value).value) {
        let ids_dos_itens = document.getElementById(op.value).value.split(',');
        //console.log(ids_dos_itens);
        if (ids_dos_itens.length)
          ids_dos_itens.forEach(id => {
            if (op.selected && !document.getElementById(id).disabled)
              document.getElementById(id).selected = op.selected;
          });
      }
    });
  }
</script>