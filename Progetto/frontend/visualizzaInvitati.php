<div style="text-align:center">
			<h1 class="indexRF">Risposte <strong class="cur">ai tuoi inviti</strong></h1>
	</div>
	<?php
	
	    $res=leggiInvitiAllaRiunione($cid,$_GET["data"],$_GET["orainizio"],$_GET["nomesalariunione"]);


		if ($res["status"]=="ok")
		{
		  $invitiAllaRiunione=$res["contenuto"];
		  stampaInvitiAllaRiunione($invitiAllaRiunione);
		}
		else
		{
			//echo $res["msg"];
			echo "<div class=\"alert alert-danger\"><strong>ERRORE!: " . $res["msg"] . "</strong></div>";

		}

	?>
