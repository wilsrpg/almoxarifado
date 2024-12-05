<a href="/">Ir para página inicial</a>
@if ($errors->any())
{{print_r($errors->all(),true)}}
@else
<form action="registrar_movimentacao" method="post">
  <p>Data: <input type="date" name="data" value="<?php echo date('Y-m-d'); ?>"></p>
  <p>Hora: <input type="time" name="hora" value="<?php echo date('H:i'); ?>"></p>
  <p>Responsável por entregar: <input type="text" name="quem_entregou"></p>
  <p>Responsável por receber: <input type="text" name="quem_recebeu"></p>
  <p>Tipo:
    <select name="tipo" onchange="mudarTipo(event)" required>
      <option default></option>
      <option value="Empréstimo">Empréstimo</option>
      <option value="Devolução">Devolução</option>
      <option value="Transferência">Transferência</option>
    </select>
  </p>
  <p>
    <span style="vertical-align: top;">Itens: </span>
    @if (count($itens))
      <select id="itens" name="itens[]" multiple required disabled>
        @foreach ($itens as $item)
          <option id="<?= $item['_id'] ?>" value="<?= $item['_id'] ?>" class="<?= $item['disponivel'] ? 'disp' : 'ndisp' ?>">
            <?= $item['nome'] ?>
          </option>
        @endforeach
      </select>
    @else
      Não há itens cadastrados.
    @endif
    <span style="vertical-align: top;">Grupos: </span>
    @if (count($grupos))
      <select id="grupos" multiple onchange="atualizarItens(event)" disabled>
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
    <span style="vertical-align: top;">Movimentações: </span>
    @if (count($movimentacoes))
      <select id="movimentacoes" multiple onchange="atualizarItens(event)" disabled>
        @foreach ($movimentacoes as $movimentacao)
          <option value="<?= $movimentacao['_id'] ?>">
            <?= date_format(date_create($movimentacao['data']), 'd/m/Y') . ' ' . $movimentacao['hora'] ?>
          </option>
        @endforeach
      </select>
      @foreach ($movimentacoes as $movimentacao)
        <input type=hidden id="<?= $movimentacao['_id'] ?>" value="<?= implode(',', $movimentacao['itens']) ?>">
      @endforeach
    @else
      Não há movimentações registradas.
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
  function mudarTipo(e) {
    itens = document.getElementById('itens');
    //grupos = document.getElementById('grupos');
    //movimentacoes = document.getElementById('movimentacoes');
    itens.disabled = e.target.value == '';
    document.getElementById('grupos').disabled = e.target.value == '';
    document.getElementById('movimentacoes').disabled = e.target.value == '';
    /*if (e.target.value == '') {
      //itens.disabled = true;
      //grupos.disabled = true;
      //movimentacoes.disabled = true;
    } else {
      //itens.disabled = false;
      //grupos.disabled = false;
      //movimentacoes.disabled = false;
      if (e.target.value == 'Empréstimo') {
        //grupos.disabled = false;
        //movimentacoes.disabled = true;
        for (let i = 0; i < itens.children.length; i++)
          itens.children[i].disabled = itens.children[i].className == 'ndisp';
      } else {
        //grupos.disabled = true;
        //movimentacoes.disabled = false;
        for (let i = 0; i < itens.children.length; i++)
          itens.children[i].disabled = itens.children[i].className == 'disp';
      }
    }*/
    if (e.target.value != '') {
      if (e.target.value == 'Empréstimo')
        for (let i = 0; i < itens.children.length; i++)
          itens.children[i].disabled = itens.children[i].className == 'ndisp';
      else
        for (let i = 0; i < itens.children.length; i++)
          itens.children[i].disabled = itens.children[i].className == 'disp';
    }
  }

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
