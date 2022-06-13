<?php
session_start();

include_once("../common/setup.php");
include_once("../common/funzioni.php");

	$ris1= leggiInviti($cid);
	
	if ($ris1["status"]=='ok')
		$ris2 = scriviInvito($cid,$ris1["contenuto"],$_GET["id"],$_GET["risposta"],$_GET["motivazione"]);
		
	if ($ris1["status"]=='ok' && $ris2["status"]=='ok' && $_GET["risposta"]=="Accetto"){
		header("Location:../index.php?op=invitiAccettati&status=ok&msg=". urlencode($ris1["msg"] . $ris2["msg"]));
	}elseif ($ris1["status"]=='ok' && $ris2["status"]=='ok' && $_GET["risposta"]=="Rifiuto"){
		header("Location:../index.php?op=invitiRifiutati&status=ok&msg=". urlencode($ris1["msg"] . $ris2["msg"]));
	}else{
		header("Location:../index.php?status=ko&msg=". urlencode($ris1["msg"] . $ris2["msg"]));
	}

	

?>
