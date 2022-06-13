<div style="text-align:center">
	<h1 class="indexRF">Visualizza e cancella <strong class="cur">autorizzati</strong></h1>
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



    $res=leggiAutorizzati($cid);


	if ($res["status"]=="ok")
	{
	  $autorizzati=$res["contenuto"];
	  stampaAutorizzati($autorizzati);
	}
	else
	{
		//echo $res["msg"];
		echo "<div class=\"alert alert-danger\"><strong>ERRORE!: " . $res["msg"] . "</strong></div>";

	}


?>
