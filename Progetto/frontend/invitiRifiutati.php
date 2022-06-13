<div style="text-align:center">
	<h1 class="indexRF">Inviti <strong class="cur">rifiutati</strong></h1>
</div>
<?php

    $res=leggiInvitiRifiutati($cid);


	if ($res["status"]=="ok")
	{
	  $invitiRifiutati=$res["contenuto"];
	  stampaInvitiRifiutati($invitiRifiutati);
	}
	else
	{
		//echo $res["msg"];
		echo "<div class=\"alert alert-danger\"><strong>ERRORE!: " . $res["msg"] . "</strong></div>";

	}


?>
