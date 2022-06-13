<div style="text-align:center">
	<h1 class="indexRF">Riunioni <strong class="cur">future</strong></h1>
</div>
<?php



    $res=leggiRiunioniFuture($cid);


	if ($res["status"]=="ok")
	{
	  $riunioniFuture=$res["contenuto"];
	  stampaRiunioniFuture($riunioniFuture);
	}
	else
	{
		//echo $res["msg"];
		echo "<div class=\"alert alert-danger\"><strong>ERRORE!: " . $res["msg"] . "</strong></div>";

	}


?>
