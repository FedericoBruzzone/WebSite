<div style="text-align:center">
	<h1 class="indexRF">Inviti <strong class="cur">ricevuti</strong></h1>
</div>

<?php

    $res=leggiInvitiRicevuti($cid);


	if ($res["status"]=="ok")
	{
	  $invitiRicevuti=$res["contenuto"];
	  stampaInvitiRicevuti($invitiRicevuti);
	}
	else
	{
		//echo $res["msg"];
		echo "<div class=\"alert alert-danger\"><strong>ERRORE!: " . $res["msg"] . "</strong></div>";

	}


?>
