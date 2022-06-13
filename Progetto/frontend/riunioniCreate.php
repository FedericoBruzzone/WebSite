
<div style="text-align:center">
	<h1 class="indexRF">Riunioni <strong class="cur">Create</strong></h1>
</div>

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

    $res=leggiRiunioniCreate($cid);


	if ($res["status"]=="ok")
	{
	  $riunioniCreate=$res["contenuto"];
	  stampaRiunioniCreate($riunioniCreate);
	}
	else
	{
		//echo $res["msg"];
		echo "<div class=\"alert alert-danger\"><strong>ERRORE!: " . $res["msg"] . "</strong></div>";

	}


?>
