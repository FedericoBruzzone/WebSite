<?php
session_start();

include_once("../common/setup.php");
include_once("../common/funzioni.php");



	$ris1 = cancellaRiunione($cid,$_GET["data"],$_GET["orainizio"],$_GET["nomesalariunione"]);


	if ($ris1["status"]=='ok'){
		header("Location:../index.php?op=riunioniCreate&status=ok&msg=". urlencode($ris1["msg"]));
	}else{
		header("Location:../index.php?op=riunioniCreate&status=ko&msg=". urlencode($ris1["msg"]));
	}

?>
