<?php
$id = $_GET['id'];

?>

<body>
<form   name="inserimento" action="backend/rispondiInvito-exe.php" method="GET" onsubmit="return conferma(this);">
<div class="container form">

	<h1 class="indexRF">Rispondi <strong class="cur">all'invito</strong></h1>


  <input type="hidden" id="id" name = "id" value="<?php echo $id; ?>" >

  <div class="row">
    <div class="form-group row">
      <div class="col">
        <label for="Accetta">Accetta</label>
        <input type="radio" id="Accetto" name = "risposta" value="Accetto" onclick="nascondi(); check();"><br>
        <label for="Rifiuta">Rifiuta</label>
        <input type="radio" id="Rifiuto" name = "risposta" value="Rifiuto" onclick="mostra(); check();">
      </div>


	<div style = "display: none" id = "motivazioneDiv" class="col-xs-3">
	<label for="ex2">Motivazione</label>
	<input type="text" class="form-control" id="motivazione" name = "motivazione">
	</div>
    </div>
  </div>

  <div class="row">
    <div class="col2 col-btn">
      <input type="submit" class="btn send-btn" value = "OK"  >
      <input type="reset" class="btn send-btn" value = "Cancella">
    </div>
  </div>
  </div>
</form>
</body>
