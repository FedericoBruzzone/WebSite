<?php


$res=leggiSalaRiunione($cid);

if ($res["status"]=="ko")
{
	echo "Non sono presenti sale riunioni";
}

$sr=$res["contenuto"];
?>


<div style="text-align:center">
	<h1 class="indexRF">Crea <strong class="cur">riunione</strong></h1>
</div>
<form   name="inserimento" action="backend/creaRiunione-exe.php" method="GET">
<div class="container form">

  <div class="row">
    <div class="form-group row margin-top">
      <div class="col">
        <label for="ex1">Data</label>
        <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="ex1" name = "data">

      </div>
      <div class="col">
        <label for="ex2">Ora</label>
        <input type="time" class="form-control" id="ex2" name = "orainizio">
      </div>
      <div class="col-xs-2">
        <label for="ex3">Sala Riunione</label>
					<?php selezionaSalaRiunione($sr, "nomesalariunione", "ex3"); ?>
      </div>
      <div class="col-xs-2">
        <label for="ex4">Durata (Min)</label>
        <input type="number" class="form-control" id="ex4"  name = "durata"  min="10" max="120" value="10" step="10">
      </div>
      <div class="col">
        <label for="ex5">Tema</label>
        <textarea type="text" class="form-control" id="ex5" required="required" name = "tema"></textarea>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col2 col-btn">
      <input type="submit" class="btn send-btn" value = "OK">
      <input type="reset" class="btn send-btn" value = "Cancella">
    </div>
  </div>
</div>
</form>
