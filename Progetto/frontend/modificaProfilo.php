<div style="text-align:center">
	<h1 class="indexRF">Modifica <strong class="cur">profilo</strong></h1>
</div>


<?php
if (isset($_GET["status"])){
			if($_GET["status"]=='ok'){
					echo "<div style=\"text-align:center\" class=\"alert alert-success\"><strong>" . urldecode($_GET["msg"]) . "</strong></div>";
			}else{
					echo "<div style=\"text-align:center\" class=\"alert alert-danger\"><strong>ERRORE!: " . urldecode($_GET["msg"]) . "</strong></div>";
			}
		}
	$passwordOld = $_SESSION["password"]
?>


<form   name="inserimento" action="backend/modificaProfilo-exe.php" method="GET">
<div class="container form">

  <div class="row">
    <div class="form-group row margin-top">
      <div class="col">
        <label for="ex1">Nome</label>
        <input type="text" value="<?php echo $_GET["nome"]?>" class="form-control" id="ex1" name = "nome" required="required">
      </div>
      <div class="col">
        <label for="ex2">Cognome</label>
        <input type="text" value="<?php echo $_GET["cognome"]?>" class="form-control" id="ex2" name = "cognome" required="required">
      </div>
      <div class="col-xs-2">
        <label for="ex3">Email</label>
        <input type="email" value="<?php echo $_GET["email"]?>" class="form-control" id="ex3" name = "email" required="required">
      </div>
      <div class="col">
        <label for="ex4">Password</label>
        <input type="password" value="<?php echo $_GET["password"]?>" class="form-control" id="ex4" name = "password" required="required">

      </div>
			<div class="col">
        <label for="ex4"> ⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀</label>
				<input type="button" class="btn"onclick="showPwd()" value="Mostra/nascondi password">
      </div>


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

<script>
function showPwd() {
        var input = document.getElementById('ex4');
        if (input.type === "password") {
          input.type = "text";
        } else {
          input.type = "password";
        }
}
</script>
