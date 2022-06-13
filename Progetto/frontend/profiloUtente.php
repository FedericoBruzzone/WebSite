<div style="text-align:center">
	<h1 class="indexRF">Profilo <strong class="cur">utente</strong></h1>
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

<?php

  $res=leggiProfiloUtente($cid);
	if ($res["status"]=="ok")
	{
	  $profiloUtente=$res["contenuto"];
	  stampaProfiloUtente($profiloUtente);
	}
	else
	{
		echo "<div class=\"alert alert-danger\"><strong>ERRORE!: " . $res["msg"] . "</strong></div>";
	}


?>
</div>
