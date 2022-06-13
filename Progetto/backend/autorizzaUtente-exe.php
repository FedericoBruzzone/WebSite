<?php
session_start();

include_once("../common/setup.php");
include_once("../common/funzioni.php");


$ris1 = scriviAutorizzato($cid,$_GET["email"],$_GET["data"]);

if ($ris1["status"]=='ok'){
		header("Location:../index.php?op=visualizzaAutorizzati&status=ok&msg=". urlencode($ris1["msg"] . $ris2["msg"]));
	}else{
		header("Location:../index.php?op=autorizzaUtente&status=ko&msg=". urlencode($ris1["msg"] . $ris2["msg"]));
	}
?>
