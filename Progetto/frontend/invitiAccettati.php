	<div style="text-align:center">
			<h1 class="indexRF">Inviti <strong class="cur">accettati</strong></h1>
	</div>
	<?php
		
		
	    $res=leggiInvitiAccettati($cid);


		if ($res["status"]=="ok")
		{
		  $invitiAccettati=$res["contenuto"];
		  stampaInvitiAccettati($invitiAccettati);
		}
		else
		{
			//echo $res["msg"];
			echo "<div class=\"alert alert-danger\"><strong>ERRORE!: " . $res["msg"] . "</strong></div>";

		}

	?>
