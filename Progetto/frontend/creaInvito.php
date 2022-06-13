<?php
  $data = $_GET["data"];
  $orainizio = $_GET["orainizio"];
  $nomesalariunione = $_GET["nomesalariunione"];
?>


<form name="inserimentoInvito" action="backend/creaInvito-exe.php" method="GET" onsubmit="return conferma(this);">

  <div style="text-align:center">
	   <h1 class="indexRF">Crea <strong class="cur">invito</strong></h1>
  </div>

  <div class="indexRF">
    <div class="container">
      <p style="font-size:30px">Capienza Stanza: <?php echo capienza($cid,$nomesalariunione); ?></p>
    </div>
  </div>


  <div class="container" style="text-align:center">
    <input type="button" class="btn btn-light" id="tutti" value="Tutti" onclick="checkTutti()">
    <input type="button" class="btn btn-light" id="capiSettore" value="Capi settore" onclick="checkCapi()">
    <input type="button" class="btn btn-light" id="impiegati" value="Impiegati semplici" onclick="checkSemplici()">
    <input type="button" class="btn btn-light" id="funzionari" value="Funzionari" onclick="checkFunzionari()">
  </div>

  <div class="container">
      <?php
      if (isset($_GET["status"])){
      			if($_GET["status"]=='ok'){
      					echo "<div style=\"text-align:center\" class=\"alert alert-success\"><strong>" . urldecode($_GET["msg"]) . "</strong></div>";
      			}else{
      					echo "<div style=\"text-align:center\" class=\"alert alert-danger\"><strong>ERRORE!: " . urldecode($_GET["msg"]) . "</strong></div>";
      			}
      		}
      ?>
    </div>
  <?php
  $res=leggiUtentiDaInvitare($cid);

  if ($res["status"]=="ok")
  {
  	 $utentiDaInvitare=$res["contenuto"];
  	 stampaUtentiDaInvitare($utentiDaInvitare);
  }
  else
  {
  	 echo "<div class=\"alert alert-danger\"><strong>ERRORE!: " . $res["msg"] . "</strong></div>";
  }
  ?>

	<div class="container form">
      <div class="col-xs-3">
        <label for="data">     </label>

    		<input type="hidden" id="datainvito" name = "datainvito" value="<?php echo date('Y-m-d'); ?>" >
    		<input type="hidden" id="data" name = "data" value="<?php echo $data; ?>" >
    		<input type="hidden" id="orainizio" name = "orainizio" value="<?php echo $orainizio; ?>" >
    		<input type="hidden" id="nomesalariunione" name = "nomesalariunione" value="<?php echo $nomesalariunione; ?>" >

      </div>

      <div class="row">
        <div class="col2 col-btn">
          <input type="submit" class="btn send-btn" value = "OK">
          <input type="reset" class="btn send-btn" value = "Cancella">
        </div>
      </div>
  </div>

</form>
