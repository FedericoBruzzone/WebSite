<?php


$res=leggiNonAutorizzati($cid);

if ($res["status"]=="ko")
{
	echo "Non sono presenti utenti non autorizzati";
}

$na=$res["contenuto"];

?>

<form   name="inserimento" action="backend/autorizzaUtente-exe.php" method="GET">
<div class="container form">
  <div style="text-align:center">
	<h1 class="indexRF">Autorizza <strong class="cur">utente</strong></h1>
</div>
  <div class="row">
    <div class="form-group row margin-top">
      <div class="col">
        <label for="ex1">Email</label>
		<?php selezionaNonAutorizzati($na, "email", "ex1"); ?>
        <!--<input type="email" class="form-control" required="required" id="ex1" name = "email">-->
      </div>
      <div class="col">
        <label for="ex2">Data</label>
        <input type="date" value="<?php echo date('Y-m-d'); ?>" / class="form-control" id="ex2" name = "data"/>
      </div>

      </div>
  </div>

  <div class="row">
    <div class="col2 col-btn">
      <input type="submit" class="btn send-btn" value = "OK">
    </div>
  </div>
  </div>
</form>
