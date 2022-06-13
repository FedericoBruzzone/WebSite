<?php
/* Funzioni relative alla gestione degli utenti */

function isUser($cid,$email,$pwd)
{
	$status= true;

   /* inserire controlli dell'input */
  $sql = "SELECT * FROM utente where email = '$email' and password = '$pwd'";

  $res = $cid->query($sql);

  if ($res==null){
			$status=false;
	}elseif($res->num_rows==0 || $res->num_rows>1){
			$status=false;
	}elseif($res->num_rows==1){
		$status=true;
	}
    return $status;
}

function isUserR($cid,$email)
{
	$status= true;

   /* inserire controlli dell'input */
  $sql = "SELECT * FROM utente where email = '$email'";

  $res = $cid->query($sql);

  if ($res==null){
			$status=false;
	}elseif($res->num_rows==0 || $res->num_rows>1){
			$status=false;
	}elseif($res->num_rows==1){
		$status=true;
	}
    return $status;
}

//--------------------REGISTRA UTENTE-----------------------------
function registraUtente($cid,$nome,$cognome,$email,$password,$data,$dipartimento){
	$errore=false;

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}


	if (!$errore)
	{

	  $sql = "INSERT INTO utente(email, password, nome, cognome, foto, datanascita, tipo, ruolo, dataruolo, anniservizio,dataautorizzazione,emaildirettore,nomedipartimento)
	          VALUES ('$email', '$password', '$nome', '$cognome', '-', '$data', 'Impiegato', 'Impiegato semplice', NULL, NULL, NULL, NULL, '$dipartimento')";
	  $res = $cid->query($sql);

	  if ($res==null)
		{
			$errore=false;
		}
	  else
	  {
			$errore=true;
	  }

	return $errore;
}
}
// Funzioni relative alla gestione delle riunioni
//--------------------TUTTE-----------------------------
function leggiRiunioni($cid)
{
	$riunioni = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}
  $sql= "SELECT * FROM riunione";

	$res = $cid->query($sql);

   	if ($res==null)
	{
	        $msg = "Si sono verificati i seguenti errori:<br/>"
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
	}
	else{// L'interrogazione è andata a buon fine e posso leggere le tuple risultato

		while ($row=$res->fetch_assoc())
			{
			 $riunioni[]=array("data" => $row["data"],
							  "orainizio" =>$row["orainizio"],
							  "nomesalariunione" =>$row["nomesalariunione"],
							  "durata" =>$row["durata"],
							  "tema"=>$row["tema"]);
			}
		    $risultato["contenuto"]=$riunioni;
	}
	return $risultato;
}

//----------------------CONTROLLO RIUNIONI-------------------------------
function controlloRiunioni($cid,$data,$orainizio,$nomesalariunione,$durata){

	$ok = true;
	$riunioni = array();

	$sql = "SELECT data,orainizio,nomesalariunione,durata FROM riunione";

	$res = $cid->query($sql);

	while ($row=$res->fetch_assoc())
		{
		 $riunioni[]=array("data" => $row["data"],
							"orainizio" =>$row["orainizio"],
							"nomesalariunione" =>$row["nomesalariunione"],
							"durata" =>$row["durata"]);
		}
		foreach ($riunioni as $riunioni){

			if ($nomesalariunione == $riunioni["nomesalariunione"]) {
				if($data == $riunioni["data"]){
					if($orainizio == $riunioni["orainizio"]){
							$ok = false;
						}elseif(strtotime($orainizio) < (strtotime($riunioni["orainizio"]) + ($riunioni["durata"]*60))){
							$ok = false;
						}
					}
			}

		}

		return $ok;

}


//--------------------SCRIVI-----------------------------
function scriviRiunione($cid,$riunioni,$data,$orainizio,$nomesalariunione,$durata,$tema)
{

	$utente = $_SESSION["utente"];

	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");
	$msg="";
	$errore=false;



	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

	if (controlloRiunioni($cid,$data,$orainizio,$nomesalariunione,$durata)) {

	if (!$errore)
	{

	  $sql = "INSERT INTO riunione(data, orainizio, nomesalariunione, durata, tema, emailutente)
	          VALUES ('$data', '$orainizio', '$nomesalariunione', '$durata', '$tema', '$utente')";
	  $res = $cid->query($sql);

	  if ($res==null)
		{
			$risultato["msg"]= "Problema nella memorizzazione del risultato sul database<br/>
								Esiste già una riunione con Data, Ora e Sala Riunione uguale a quelli inseriti</br>";
			$risultato["status"]="ko";
		}
	  else
	  {
	   $risultato["msg"] = "L'operazione di creazione si &egrave; conclusa con successo";
	   $risultato["status"]="ok";
	  }
	}
	else
	{
		$risultato["msg"] = "Si sono verificati i seguenti errori:<br/>"
     		. $msg;
	   $risultato["status"]="ko";
	}
	}else{

		$risultato["msg"]= "Problema nella memorizzazione del risultato sul database<br/>
							Esiste già una riunione In questdasgkfgaskghf</br>";
		$risultato["status"]="ko";

		}

	return $risultato;
}


//--------------------CANCELLA-----------------------------
function cancellaRiunione($cid,$data,$orainizio,$nomesalariunione)
{

	$utente = $_SESSION["utente"];

	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");
	$msg="";
	$errore=false;


	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

	if (!$errore)
	{

	  $sql = "DELETE FROM riunione
	          WHERE data='$data' AND orainizio='$orainizio' AND nomesalariunione='$nomesalariunione'";
	  $res = $cid->query($sql);

	  if ($res==null)
		{
			$risultato["msg"]= "L'operazione di cancellazione non è avvenuta<br/>";
			$risultato["status"]="ko";
		}
	  else
	  {
	   $risultato["msg"] = "L'operazione di cancellazione si &egrave; conclusa con successo";
	   $risultato["status"]="ok";
	  }
	}
	else
	{
		$risultato["msg"] = "Si sono verificati i seguenti errori:<br/>"
     		. $msg;
	   $risultato["status"]="ko";
	}


	return $risultato;
}

//--------------------CREATE-----------------------------
function leggiRiunioniCreate($cid)
{
	$utente = $_SESSION["utente"];

	$riunioniCreate = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

    $sql= "SELECT * FROM riunione WHERE emailutente='$utente'";

	$res = $cid->query($sql);

   	if ($res==null)
	{
	        $msg = "Si sono verificati i seguenti errori:<br/>"
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
	}elseif($res->num_rows==0)
	{
			$msg = "Non hai creato nessuna riunione";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
    }
	else{// L'interrogazione è andata a buon fine e posso leggere le tuple risultato

		while ($row=$res->fetch_assoc())
			{
			 $riunioniCreate[]=array("data" => $row["data"],
							  "orainizio" =>$row["orainizio"],
							  "nomesalariunione" =>$row["nomesalariunione"],
							  "durata" =>$row["durata"],
							  "tema"=>$row["tema"]);
			}
		    $risultato["contenuto"]=$riunioniCreate;
	}
	return $risultato;
}

function stampaRiunioniCreate($riunioniCreate)
{
	echo "<div class=\"table-responsive\">";
	echo "<table class=\"table text-center\">";
	echo "<tr><th class=\"text-center\">Data</th><th class=\"text-center\">Ora Inizio</th><th class=\"text-center\">Sala Riunione</th>
	<th class=\"text-center\">Durata (Min)</th>
	<th class=\"text-center\">Tema</th>
	<th class=\"text-center\">Invitati</th>
	<th class=\"text-center\">Cancella</th>
	</tr>";

		foreach ($riunioniCreate AS $riunioniCreate)
		{
		echo "<tr><td>$riunioniCreate[data]</td>
		<td>$riunioniCreate[orainizio]</td>
		<td>$riunioniCreate[nomesalariunione]</td>
		<td>$riunioniCreate[durata]</td>
		<td>$riunioniCreate[tema]</td>
		<td><a href=\"index.php?op=visualizzaInvitati&data=$riunioniCreate[data]&orainizio=$riunioniCreate[orainizio]&nomesalariunione=$riunioniCreate[nomesalariunione]\"><i class=\"bi bi-activity\"></i></a></td>
		<td>
		<a href=\"backend/cancellaRiunione-exe.php?data=$riunioniCreate[data]&orainizio=$riunioniCreate[orainizio]&nomesalariunione=$riunioniCreate[nomesalariunione]\" onclick=\"return cancellaRiunione();\"><i class=\"bi bi-eraser\"></i></a></td></tr>";

		}


		echo "</table>";
		echo "</div>";
	}

//--------------------LEGGI INVITI ALLA RIUNIONE-----------------------------
function leggiInvitiAllaRiunione($cid,$data,$orainizio,$nomesalariunione)
{

	$utente = $_SESSION["utente"];

	$invitiAllaRiunione = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

    $sql= "SELECT i.emailutente, i.risposta, i.motivazione
			FROM riunione AS r JOIN invitato AS i
			WHERE r.data = '$data' AND
				  r.orainizio = '$orainizio' AND
				  r.nomesalariunione = '$nomesalariunione' AND
				  r.data = i.datariunione AND
				  r.orainizio = i.orainizio AND
				  r.nomesalariunione = i.nomesalariunione AND
				  r.emailutente = '$utente'";

	$res = $cid->query($sql);

   	if ($res==null)
	{
	        $msg = "Si sono verificati i seguenti errori:</br>"
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
	}elseif($res->num_rows==0)
	{
			$msg = "Non ci sono inviti</br>";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
			cancellaRiunione($cid,$data,$orainizio,$nomesalariunione);
    }
	else{// L'interrogazione è andata a buon fine e posso leggere le tuple risultato

		while ($row=$res->fetch_assoc())
			{
			 $invitiAllaRiunione[]=array(
							"emailutente" => $row["emailutente"],
							"risposta" => $row["risposta"],
							"motivazione" => $row["motivazione"]);
			}

		    $risultato["contenuto"]=$invitiAllaRiunione;
	}


	return $risultato;
}

//--------------------STAMPA INVITI ALLA RIUNIONE-----------------------------
function stampaInvitiAllaRiunione($invitiAllaRiunione)
{
	echo "<div class=\"table-responsive\">";
	echo "<table class=\"table text-center\">";
	echo "<tr><th class=\"text-center\">Email</th>
	<th class=\"text-center\">Risposta</th>
	<th class=\"text-center\">Motivazione</th>
	</tr>";

		foreach ($invitiAllaRiunione AS $invitiAllaRiunione)
		{
		echo "<tr><td>$invitiAllaRiunione[emailutente]</td>
		<td>$invitiAllaRiunione[risposta]</td>
		<td>$invitiAllaRiunione[motivazione]</td>
		</tr>";
		}
	echo "</table>";
	echo "</div>";
}


//--------------------FUTURE-----------------------------
function leggiRiunioniFuture($cid)
{

	$utente = $_SESSION["utente"];

	$riunioniFuture = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

    $sql= "SELECT DISTINCT r.data,r.orainizio,r.nomesalariunione,r.durata,r.tema,r.emailutente,d.indirizzo
			FROM riunione AS r JOIN salariunione AS sr JOIN dipartimento AS d
			WHERE r.nomesalariunione = sr.nome AND sr.nomedipartimento = d.nome AND r.emailutente = '$utente' OR (r.data,r.orainizio,r.nomesalariunione,d.indirizzo) IN
					(
					SELECT r.data,r.orainizio,r.nomesalariunione,d.indirizzo
					FROM riunione AS r JOIN invitato AS i JOIN salariunione AS sr JOIN dipartimento AS d
					WHERE r.nomesalariunione = sr.nome AND sr.nomedipartimento = d.nome AND i.datariunione = r.data
						AND i.orainizio = r.orainizio AND i.nomesalariunione = r.nomesalariunione AND i.emailutente='$utente' AND i.risposta='Accetto'
					)";

	$res = $cid->query($sql);

   	if ($res==null)
	{
	        $msg = "Si sono verificati i seguenti errori:</br>"
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
	}elseif($res->num_rows==0)
	{
			$msg = "Non ci sono riunioni in programmazione</br>";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
    }
	else{// L'interrogazione è andata a buon fine e posso leggere le tuple risultato

		while ($row=$res->fetch_assoc())
			{
			 $riunioniFuture[]=array("data" => $row["data"],
							  "orainizio" =>$row["orainizio"],
							  "nomesalariunione" =>$row["nomesalariunione"],
							  "durata" =>$row["durata"],
							  "tema"=>$row["tema"],
							  "emailutente"=>$row["emailutente"],
							  "indirizzo"=>$row["indirizzo"]);
			}
		    $risultato["contenuto"]=$riunioniFuture;
	}
	return $risultato;
}

function stampaRiunioniFuture($riunioniFuture)
{
	echo "<div class=\"table-responsive\">";
	echo "<table class=\"table text-center\">";
	echo "<tr><th class=\"text-center\">Data</th><th class=\"text-center\">Ora Inizio</th><th class=\"text-center\">Sala Riunione</th>
	<th class=\"text-center\">Durata</th>
	<th class=\"text-center\">Tema</th>
	<th class=\"text-center\">Creata da</th>
	<th class=\"text-center\">Indirizzo Diparimento</th>
	</tr>";

		foreach ($riunioniFuture AS $riunioniFuture)
		{
		echo "<tr><td>$riunioniFuture[data]</td>
		<td>$riunioniFuture[orainizio]</td>
		<td>$riunioniFuture[nomesalariunione]</td>
		<td>$riunioniFuture[durata]</td>
		<td>$riunioniFuture[tema]</td>
		<td>$riunioniFuture[emailutente]</td>
		<td>$riunioniFuture[indirizzo]</td>
		</tr>";
		}
	echo "</table>";
	echo "</div>";
}


//Funzioni relative alla gestione delle sale riunioni
//--------------------LEGGI SALA-----------------------------
function leggiSalaRiunione($cid)
{
	$salaRiunione = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}
	$sql= "SELECT nome FROM salariunione;";
	$res=$cid->query($sql);
	if ($res==null)
	{
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella esecuzione della interrogazione " . $cid->error;
		return $risultato;
	}

	while($row=$res->fetch_row())
	{
			$salaRiunione[$row[0]]=$row[0];
	}
	$risultato["contenuto"]=$salaRiunione;
	return $risultato;
}

//--------------------SELEZIONA SALA-----------------------------
function selezionaSalaRiunione($salaRiunione, $nomeSalaRiunione, $id)
{
	echo "<select type=\"text\" class='form-control' name='$nomeSalaRiunione' id='$id'>";

	foreach ($salaRiunione AS $salaRiunione)
	{
		echo "<option value='$salaRiunione'>$salaRiunione</option>";
	}
	echo "</select>";
}


//Funzioni relative alla gestione degli inviti
//--------------------LEGGI INVITI-----------------------------
function leggiInviti($cid)
{

	$utente = $_SESSION["utente"];

	$inviti = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

    $sql= "SELECT *
			FROM invitato";

	$res = $cid->query($sql);

   	if ($res==null)
	{
	        $msg = "Si sono verificati i seguenti errori:</br>"
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
	}elseif($res->num_rows==0)
	{
			$msg = "Non ci sono inviti</br>";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
    }
	else{// L'interrogazione è andata a buon fine e posso leggere le tuple risultato

		while ($row=$res->fetch_assoc())
			{
			 $inviti[]=array("id" => $row["id"],
							"emailutente" => $row["emailutente"],
							"risposta" => $row["risposta"],
							"motivazione" => $row["motivazione"],
							"datainvito" => $row["datainvito"],
							"datariunione" => $row["datariunione"],
							"orainizio" =>$row["orainizio"],
							"nomesalariunione" =>$row["nomesalariunione"]);
			}

		    $risultato["contenuto"]=$inviti;
	}


	return $risultato;
}

//--------------------SCRIVI INVITO-----------------------------
function scriviInvito($cid,$inviti,$id,$risposta,$motivazione)
{

	$utente = $_SESSION["utente"];

	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");
	$msg="";
	$errore=false;

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

	if (!$errore)
	{
	if($risposta != "" && $risposta != ""){

	  if ($risposta == "Accetto"){
		  $sql = "UPDATE invitato
			SET risposta = '$risposta'
			WHERE id = '$id' ";
	  }else{
	  $sql = "UPDATE invitato
			SET risposta = '$risposta', motivazione = '$motivazione'
			WHERE id = '$id' ";
	  }
	  $res = $cid->query($sql);
	}
	  if ($res==null)
		{
			$risultato["msg"]= "L'operazione di mento non si &egrave; conclusa con successo<br/></br>";
			$risultato["status"]="ko";
		}
	  else
	  {
	   $risultato["msg"] = "Completata la memorizzazione del risultato sul database";
	   $risultato["status"]="ok";
	  }
	}
	else
	{
		$risultato["msg"] = "Si sono verificati i seguenti errori:<br/>"
     		. $msg;
	   $risultato["status"]="ko";
	}


	return $risultato;
}

//--------------------INVITI RICEVUTI-----------------------------
function leggiInvitiRicevuti($cid)
{

	$utente = $_SESSION["utente"];

	$invitiRicevuti = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

    $sql= "SELECT i.id,i.datainvito,r.data,r.orainizio,r.nomesalariunione,d.indirizzo
			FROM riunione AS r JOIN salariunione AS sr JOIN dipartimento AS d JOIN invitato AS i
			WHERE r.nomesalariunione = sr.nome AND sr.nomedipartimento = d.nome AND i.datariunione = r.data AND i.orainizio = r.orainizio
			AND i.nomesalariunione = r.nomesalariunione AND i.emailutente='$utente' AND i.risposta IS NULL ";

	$res = $cid->query($sql);

   	if ($res==null)
	{
	        $msg = "Si sono verificati i seguenti errori:</br>"
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
	}elseif($res->num_rows==0)
	{
			$msg = "Non hai ricevuto degli inviti</br>";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
    }
	else{// L'interrogazione è andata a buon fine e posso leggere le tuple risultato

		while ($row=$res->fetch_assoc())
			{
			 $invitiRicevuti[]=array("id" => $row["id"],
								"datainvito" => $row["datainvito"],
							  "datariunione" => $row["data"],
							  "orainizio" =>$row["orainizio"],
							  "nomesalariunione" =>$row["nomesalariunione"],
							  "indirizzo"=>$row["indirizzo"]);
			}

		    $risultato["contenuto"]=$invitiRicevuti;
	}


	return $risultato;
}

//--------------------STAMPA INVITI RICEVUTI-----------------------------
function stampaInvitiRicevuti($invitiRicevuti)
{
	echo "<div class=\"table-responsive\">";
	echo "<table class=\"table text-center\">";
	echo "<tr><th class=\"text-center\">Data invito</th><th class=\"text-center\">Data riunione</th><th class=\"text-center\">Ora Inizio</th><th class=\"text-center\">Sala Riunione</th>
	<th class=\"text-center\">Indirizzo Diparimento</th>
	<th class=\"text-center\">Rispondi</th>
	</tr>";

		foreach ($invitiRicevuti AS $invitiRicevuti)
		{
		echo "<tr><td>$invitiRicevuti[datainvito]</td>
		<td>$invitiRicevuti[datariunione]</td>
		<td>$invitiRicevuti[orainizio]</td>
		<td>$invitiRicevuti[nomesalariunione]</td>
		<td>$invitiRicevuti[indirizzo]</td>
		<td><a href=\"index.php?op=rispondiInvito&id=$invitiRicevuti[id]\"><i class=\"bi bi-pen\"></i></a></td>
		</tr>";
		}
	echo "</table>";
	echo "</div>";
}

//--------------------INVITI ACCETTATI-----------------------------
function leggiInvitiAccettati($cid)
{

	$utente = $_SESSION["utente"];

	$invitiAccettati = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

    $sql= "SELECT i.datainvito,r.data,r.orainizio,r.nomesalariunione,d.indirizzo
			FROM riunione AS r JOIN salariunione AS sr JOIN dipartimento AS d JOIN invitato AS i
			WHERE r.nomesalariunione = sr.nome AND sr.nomedipartimento = d.nome AND i.datariunione = r.data AND i.orainizio = r.orainizio
			AND i.nomesalariunione = r.nomesalariunione AND i.emailutente='$utente' AND i.risposta = 'Accetto' ";

	$res = $cid->query($sql);

   	if ($res==null)
	{
	        $msg = "Si sono verificati i seguenti errori:</br>"
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
	}elseif($res->num_rows==0)
	{
			$msg = "Non hai accettato nessun invito</br>";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
    }
	else{// L'interrogazione è andata a buon fine e posso leggere le tuple risultato

		while ($row=$res->fetch_assoc())
			{
			 $invitiAccettati[]=array("datainvito" => $row["datainvito"],
							  "datariunione" => $row["data"],
							  "orainizio" =>$row["orainizio"],
							  "nomesalariunione" =>$row["nomesalariunione"],
							  "indirizzo" => $row["indirizzo"]);
			}
		    $risultato["contenuto"]=$invitiAccettati;
	}
	return $risultato;
}

//--------------------STAMPA INVITI ACCETTATI-----------------------------
function stampaInvitiAccettati($invitiAccettati)
{
	echo "<div class=\"table-responsive\">";
	echo "<table class=\"table text-center\">";
	echo "<tr><th class=\"text-center\">Data invito</th><th class=\"text-center\">Data riunione</th><th class=\"text-center\">Ora Inizio</th><th class=\"text-center\">Sala Riunione</th>
	<th class=\"text-center\">Indirizzo Diparimento</th><th class=\"text-center\">Disdici</th>
	</tr>";

		foreach ($invitiAccettati AS $invitiAccettati)
		{
		echo "<tr><td>$invitiAccettati[datainvito]</td>
		<td>$invitiAccettati[datariunione]</td>
		<td>$invitiAccettati[orainizio]</td>
		<td>$invitiAccettati[nomesalariunione]</td>
		<td>$invitiAccettati[indirizzo]</td>
		<td><a href=\"backend/rimuoviInvito-exe.php?data=$invitiAccettati[datariunione]&orainizio=$invitiAccettati[orainizio]&nomesalariunione=$invitiAccettati[nomesalariunione]\" onclick=\"return cancellaInvito();\"><i class=\"bi bi-eraser\"></i></a></td></tr>";
		}
	echo "</table>";
	echo "</div>";

}

//----------------------RIMUOVI INVITO-----------------------------
function rimuoviInvito($cid,$utente,$data,$orainizio,$nomesalariunione){

	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");
	$msg="";
	$errore=false;


	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

	if (!$errore)
	{

		$sql = "DELETE FROM invitato
						WHERE datariunione='$data' AND orainizio='$orainizio' AND nomesalariunione='$nomesalariunione' AND emailutente='$utente'";
		$res = $cid->query($sql);

		if ($res==null)
		{
			$risultato["msg"]= "L'operazione di cancellazione non è avvenuta<br/>";
			$risultato["status"]="ko";
		}
		else
		{
		 $risultato["msg"] = "L'operazione di cancellazione si &egrave; conclusa con successo";
		 $risultato["status"]="ok";
		}
	}
	else
	{
		$risultato["msg"] = "Si sono verificati i seguenti errori:<br/>"
				. $msg;
		 $risultato["status"]="ko";
	}


	return $risultato;

}



//--------------------INVITI RIFIUTATI-----------------------------
function leggiInvitiRifiutati($cid)
{

	$utente = $_SESSION["utente"];

	$invitiRifiutati = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

    $sql= "SELECT i.datainvito,i.motivazione,r.data,r.orainizio,r.nomesalariunione,d.indirizzo
			FROM riunione AS r JOIN salariunione AS sr JOIN dipartimento AS d JOIN invitato AS i
			WHERE r.nomesalariunione = sr.nome AND sr.nomedipartimento = d.nome AND i.datariunione = r.data AND i.orainizio = r.orainizio
			AND i.nomesalariunione = r.nomesalariunione AND i.emailutente='$utente' AND i.risposta = 'Rifiuto' ";

	$res = $cid->query($sql);

   	if ($res==null)
	{
	        $msg = "Si sono verificati i seguenti errori:</br>"
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
	}elseif($res->num_rows==0)
	{
			$msg = "Non hai rifiutato nessun invito</br>";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
    }
	else{// L'interrogazione è andata a buon fine e posso leggere le tuple risultato

		while ($row=$res->fetch_assoc())
			{
			 $invitiRifiutati[]=array("datainvito" => $row["datainvito"],
								"motivazione" => $row["motivazione"],
							  "datariunione" => $row["data"],
							  "orainizio" =>$row["orainizio"],
							  "nomesalariunione" =>$row["nomesalariunione"],
							  "indirizzo" => $row["indirizzo"]);
			}
		    $risultato["contenuto"]=$invitiRifiutati;
	}
	return $risultato;
}

//--------------------STAMPA INVITI RIFIUTATI-----------------------------
function stampaInvitiRifiutati($invitiRifiutati)
{
	echo "<div class=\"table-responsive\">";
	echo "<table class=\"table text-center\">";
	echo "<tr><th class=\"text-center\">Data invito</th><th class=\"text-center\">Motivazione</th><th class=\"text-center\">Data riunione</th><th class=\"text-center\">Ora Inizio</th><th class=\"text-center\">Sala Riunione</th>
	<th class=\"text-center\">Indirizzo Diparimento</th>
	</tr>";

		foreach ($invitiRifiutati AS $invitiRifiutati)
		{
		echo "<tr><td>$invitiRifiutati[datainvito]</td>
		<td>$invitiRifiutati[motivazione]</td>
		<td>$invitiRifiutati[datariunione]</td>
		<td>$invitiRifiutati[orainizio]</td>
		<td>$invitiRifiutati[nomesalariunione]</td>
		<td>$invitiRifiutati[indirizzo]</td>

		</tr>";
		}
	echo "</table>";
	echo "</div>";

}

// Funzioni relative alla gestione degli utenti
//--------------------LEGGI PROFILO UTENTE-----------------------------
function leggiProfiloUtente($cid)
{
	$utente = $_SESSION["utente"];

	$profiloUtente = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

    $sql= "SELECT nome, cognome, email, password, datanascita, tipo, ruolo, nomedipartimento
					FROM utente
					WHERE email = '$utente'";

	$res = $cid->query($sql);

   	if ($res==null)
	{
	        $msg = "Si sono verificati i seguenti errori:</br>"
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
	}elseif($res->num_rows==0)
	{
			$msg = "Non ci sono utenti</br>";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
    }
	else{

		while ($row=$res->fetch_assoc())
			{

				$profiloUtente[]=array("nome" => $row["nome"],
																	"cognome" => $row["cognome"],
																	"email" => $row["email"],
																	"password" => $row["password"],
																	"datanascita" => $row["datanascita"],
																	"tipo" => $row["tipo"],
																	"ruolo" => $row["ruolo"],
																	"nomedipartimento" => $row["nomedipartimento"]);
			}
		  $risultato["contenuto"]=$profiloUtente;
	}
	return $risultato;

}

//--------------------STAMPA PROFILO UTENTE-----------------------------
function stampaProfiloUtente($profiloUtente)
{
		echo "<div class=\"container\" style=\"text-align:center\">";
		foreach ($profiloUtente as $profiloUtente) {

			echo "<div style=\"background-color:#d6d6d6\">Nome: $profiloUtente[nome] </a></div>";
			echo "<div style=\"background-color:#e6e6e6\">Cognome: $profiloUtente[cognome]</div>";
			echo "<div style=\"background-color:#d6d6d6\">Email: $profiloUtente[email]</div>";
			echo "<div style=\"background-color:#d6d6d6\">Password: $profiloUtente[password]</div>";
			echo "<div style=\"background-color:#e6e6e6\">Data di nascita: $profiloUtente[datanascita]</div>";
			echo "<div style=\"background-color:#d6d6d6\">Dipartimento in cui lavori: $profiloUtente[nomedipartimento]</div>";
			echo "<div style=\"background-color:#e6e6e6\">Tipo di dipendente: $profiloUtente[tipo]</div>";
			if ($profiloUtente["tipo"] != 'Direttore'){
				echo "<div style=\"background-color:#d6d6d6\">Ruolo da dipendente: $profiloUtente[ruolo]</div>";
			}
			echo "<h1 style=\"text-color:blue\"><a href=\"index.php?op=modificaProfilo&nome=$profiloUtente[nome]&cognome=$profiloUtente[cognome]&email=$profiloUtente[email]&password=$profiloUtente[password]\">Modifica profilo</a><h1>";
		}
	echo "</div>";
}
//--------------------AGGIORNA PROFILO UTENTE-----------------------------
function aggiornaUtente($cid, $nome, $cognome, $email, $password){
	$utente = $_SESSION["utente"];
  $passwordOld = $_SESSION["password"];


	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");
	$msg="";
	$errore=false;


	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

	if (!$errore)
	{
		if ($passwordOld == $password){
			$risultato["msg"]= "La password inserita è uguale a quella precedente<br/>";
			$risultato["status"]="ko";
		}else{

	  $sql = "UPDATE utente
			  		SET nome = '$nome', cognome='$cognome', email='$email', password='$password'
	          WHERE email='$utente'";

	  $res = $cid->query($sql);


	  if ($res==null)
		{
			$risultato["msg"]= "Esiste già un utente con questa email<br/>";
			$risultato["status"]="ko";
		}
	  else
	  {
		 $_SESSION["utente"]=$email;
		 $_SESSION["password"]=$password;
	   $risultato["msg"] = "L'operazione di modifica si &egrave; conclusa con successo";
	   $risultato["status"]="ok";
	  }

	}
}
	else
	{
		$risultato["msg"] = "Si sono verificati i seguenti errori:<br/>"
     		. $msg;
	   $risultato["status"]="ko";
	}


	return $risultato;
}

//--------------------LEGGI IL TIPO DELL'UTENTE-----------------------------
function leggiTipoUtente($cid)
{
	if (isset($_SESSION["logged"])){
		$tipo= array("tipo"=>"", "dataautorizzazione"=>"");
		$utente = $_SESSION["utente"];
		$risultato = "";
		$sql = "SELECT tipo, dataautorizzazione
				FROM utente
				WHERE email = '$utente'";

		$res = $cid->query($sql);


		$tipo=$res->fetch_assoc();



		if ($tipo["tipo"] == 'Direttore'){
			$risultato="Direttore";
		}
		if ($tipo["dataautorizzazione"] == NULL && $tipo["tipo"] == "Impiegato"){
			$risultato="Impiegato non autorizzato";
		}
		if ($tipo["dataautorizzazione"] != NULL && $tipo["tipo"] == "Impiegato"){
			$risultato="Impiegato autorizzato";
		}
		return $risultato;
	}

}

//--------------------LEGGI UTENTI DA INVITARE-----------------------------
function leggiUtentiDaInvitare($cid)
{

	$utente = $_SESSION["utente"];

	$utentiDaInvitare = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

    $sql= "SELECT u.email
	FROM utente AS u
	WHERE u.email != '$utente'";

	$res = $cid->query($sql);

   	if ($res==null)
	{
	        $msg = "Si sono verificati i seguenti errori:</br>"
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
	}elseif($res->num_rows==0)
	{
			$msg = "Non ci sono utenti</br>";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
    }
	else{// L'interrogazione è andata a buon fine e posso leggere le tuple risultato

		while ($row=$res->fetch_assoc())
			{
				$utentiDaInvitare[]=array("email" => $row["email"]);
			}
		    $risultato["contenuto"]=$utentiDaInvitare;
	}
	return $risultato;
}



//--------------------STAMPA UTENTI DA INVITARE-----------------------------
function stampaUtentiDaInvitare($utentiDaInvitare){
	echo "<div class=\"scrollRF\">";
	echo "<div class=\"table-responsive\">";
	echo "<table class=\"table text-center\">";
	echo "<tr><th class=\"text-center\">Email</th><th class=\"text-center\">Seleziona</th></tr>";

		foreach ($utentiDaInvitare AS $utentiDaInvitare)
		{
		echo "<tr><td>$utentiDaInvitare[email]</td>
		<td><input type=\"checkbox\" class = \"email\" name=\"email[]\" id=\"$utentiDaInvitare[email]\" value=\"$utentiDaInvitare[email]\"></i></a></td>
		</tr>";

		}
	echo "</table>";
	echo "</div>";
	echo "</div>";

}

//--------------------INVITA UTENTI-----------------------------
function invitaUtenti($cid,$email,$datainvito,$data,$orainizio,$nomesalariunione){

	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");
	$msg="";
	$errore=false;
	$nInvitati = 0;
	$capienza = 0;

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

	for ($i = 0; $i<count($email); $i++){
		$nInvitati++;
	}

	$capienza = capienza($cid,$nomesalariunione);

	if ($nInvitati > $capienza){
			$risultato["status"] = "ko";
			$risultato["msg"] = "Hai superato la capienza di invitati per questa sala";
	}
	elseif (!$errore)
		{
		  foreach ($email AS $email){
				$sql = "INSERT INTO `invitato`(`emailutente`, `risposta`, `motivazione`, `datainvito`, `datariunione`, `orainizio`, `nomesalariunione`)
				VALUES ('$email',NULL,NULL,'$datainvito','$data','$orainizio','$nomesalariunione')";
				$res = $cid->query($sql);
		  }
		  if ($res==null)
			{
				$risultato["msg"]= "Non hai selezionato nessun invitato<br/>";
				$risultato["status"]="ko";
			}
		  else
		  {
		   $risultato["msg"] = "L'operazione di invito si &egrave; conclusa con successo";
		   $risultato["status"]="ok";
		  }
		}
		else
		{
			$risultato["msg"] = "Si sono verificati i seguenti errori:<br/>"
				. $msg;
		   $risultato["status"]="ko";
		   cancellaRiunione($cid,$data,$orainizio,$nomesalariunione);
		}



	return $risultato;
}

//--------------------CAPIENZA-----------------------------
function capienza($cid, $salaRiunione){


	$sql = "SELECT capienza FROM salariunione AS sr WHERE sr.nome='$salaRiunione'";

	$res = $cid->query($sql);

	$risultato = $res->fetch_assoc();

	$risultato = $risultato["capienza"];

	return $risultato;
}


//Funzioni relative alla gestione delle autorizzazioni
//--------------------LEGGI AUTORIZZATI-----------------------------
function leggiAutorizzati($cid)
{

	$utente = $_SESSION["utente"];

	$autorizzati = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

    $sql= "SELECT u.email, u.emaildirettore
	FROM utente AS u
	WHERE u.dataautorizzazione IS NOT NULL AND u.emaildirettore IS NOT NULL AND tipo != 'Direttore'";

	$res = $cid->query($sql);

   	if ($res==null)
	{
	        $msg = "Si sono verificati i seguenti errori:</br>"
     		. $res->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
	}elseif($res->num_rows==0)
	{
			$msg = "Non ci sono utenti autorizzati</br>";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;
    }
	else{// L'interrogazione è andata a buon fine e posso leggere le tuple risultato

		while ($row=$res->fetch_assoc())
			{
			 $autorizzati[]=array("email" => $row["email"],
								"emaildirettore" => $row["emaildirettore"]);
			}
		    $risultato["contenuto"]=$autorizzati;
	}
	return $risultato;
}


//--------------------STAMPA AUTORIZZATI-----------------------------
function stampaAutorizzati($autorizzati)
{
	echo "<div class=\"table-responsive\">";
	echo "<table class=\"table text-center\">";
	echo "<tr><th class=\"text-center\">Email autorizzato</th><th class=\"text-center\">Email autorizzatore (Direttore)</th><th class=\"text-center\">Cancella autorizzazione</th>
	</tr>";

		foreach ($autorizzati AS $autorizzati)
		{
		echo "<tr><td>$autorizzati[email]</td>
		<td>$autorizzati[emaildirettore]</td>
		<td><a href=\"backend/cancellaAutorizzato-exe.php?email=$autorizzati[email]&emaildirettore=$autorizzati[emaildirettore]\" onclick=\"return cancellaAutorizzato();\"><i class=\"bi bi-eraser\"></i></a></td>
		</tr>";
		}
	echo "</table>";
	echo "</div>";
}


//--------------------CANCELLA AUTORIZZATO-----------------------------
function cancellaAutorizzato($cid,$email,$emaildirettore)
{

	$utente = $_SESSION["utente"];

	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");
	$msg="";
	$errore=false;


	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

	if (!$errore)
	{

	  $sql = "UPDATE utente
			  SET dataautorizzazione = NULL, emaildirettore = NULL
	          WHERE email='$email' AND emaildirettore='$emaildirettore'";
	  $res = $cid->query($sql);

	  if ($res==null)
		{
			$risultato["msg"]= "L'operazione di cancellazione non è avvenuta<br/>";
			$risultato["status"]="ko";
		}
	  else
	  {
	   $risultato["msg"] = "L'operazione di cancellazione si &egrave; conclusa con successo";
	   $risultato["status"]="ok";
	  }
	}
	else
	{
		$risultato["msg"] = "Si sono verificati i seguenti errori:<br/>"
     		. $msg;
	   $risultato["status"]="ko";
	}


	return $risultato;
}


//--------------------LEGGI NON AUTORIZZATI-----------------------------
function leggiNonAutorizzati($cid)
{
	$nonAutorizzati = array();
	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");

	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

	$sql= "SELECT email
	FROM utente
	WHERE dataautorizzazione IS NULL AND emaildirettore IS NULL AND tipo != 'Direttore';";

	$res=$cid->query($sql);
	if ($res==null)
	{
		$risultato["status"]="ko";
		$risultato["msg"]="Errore nella esecuzione della interrogazione " . $cid->error;
		return $risultato;
	}

	while($row=$res->fetch_row())
	{
			$nonAutorizzati[$row[0]]=$row[0];
	}
	$risultato["contenuto"]=$nonAutorizzati;
	return $risultato;
}


//--------------------SELEZIONA NON AUTORIZZATO-----------------------------
function selezionaNonAutorizzati($nonAutorizzati, $email, $id)
{
	echo "<select type=\"text\" class='form-control' name='$email' id='$id'>";

	foreach ($nonAutorizzati AS $nonAutorizzati)
	{
		echo "<option value='$nonAutorizzati'>$nonAutorizzati</option>";
	}
	echo "</select>";
}


//--------------------SCRIVI AUTORIZZATO-----------------------------
function scriviAutorizzato($cid,$email,$data)
{

	$utente = $_SESSION["utente"];

	$risultato = array("status"=>"ok","msg"=>"", "contenuto"=>"");
	$msg="";
	$errore=false;


	if ($cid->connect_errno) {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

	if (!$errore)
	{

	  $sql = "UPDATE utente
			  		SET dataautorizzazione = '$data', emaildirettore = '$utente'
	          WHERE email='$email'";

	  $res = $cid->query($sql);

	  if ($res==null)
		{
			$risultato["msg"]= "Problema nella memorizzazione del risultato sul database<br/>
								L'utente è già autorizzato</br>";
			$risultato["status"]="ko";
		}
	  else
	  {
	   $risultato["msg"] = "L'operazione di autorizzazione si &egrave; conclusa con successo";
	   $risultato["status"]="ok";
	  }
	}
	else
	{
		$risultato["msg"] = "Si sono verificati i seguenti errori:<br/>"
     		. $msg;
	   $risultato["status"]="ko";
	}


	return $risultato;
}

//--------------------JSON-----------------------------
function trovaCapiSettore(){
	require("setup.php");

	$sql= "SELECT email
				 FROM utente
				 WHERE ruolo = 'Capo settore'";

	if ($result = $cid->query($sql)) {
		if ($result->num_rows > 0) {
			$data = [];
			while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
					$tmp;
					$tmp['email'] = $row['email'];
					array_push($data, $tmp);
			}
			echo json_encode($data);
			$data = [];
		}
	}
}


function trovaImpiegatiSemplici(){
	require("setup.php");

	$sql= "SELECT email
				 FROM utente
				 WHERE ruolo = 'Impiegato semplice'";

	if ($result = $cid->query($sql)) {
		if ($result->num_rows > 0) {
			$data = [];
			while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
					$tmp;
					$tmp['email'] = $row['email'];
					array_push($data, $tmp);
			}
			echo json_encode($data);
			$data = [];
		}
	}
}


function trovaFunzionari(){
	require("setup.php");

	$sql= "SELECT email
				 FROM utente
				 WHERE ruolo = 'Funzionario'";

	if ($result = $cid->query($sql)) {
		if ($result->num_rows > 0) {
			$data = [];
			while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
					$tmp;
					$tmp['email'] = $row['email'];
					array_push($data, $tmp);
			}
			echo json_encode($data);
			$data = [];
		}
	}
}

function checkLogin(){


	    $username = isset($_POST['username']) ? $_POST['username'] : '';
	    $password = isset($_POST['password']) ? $_POST['password'] : '';

	    $ok = true;
	    $messages = array();

	    if ( !isset($username) || empty($username) ) {
	        $ok = false;
	        $messages[] = 'Username cannot be empty!';
	    }

	    if ( !isset($password) || empty($password) ) {
	        $ok = false;
	        $messages[] = 'Password cannot be empty!';
	    }

	    if ($ok) {
	        if ($username === 'dcode' && $password === 'dcode') {
	            $ok = true;
	            $messages[] = 'Successful login!';
	        } else {
	            $ok = false;
	            $messages[] = 'Incorrect username/password combination!';
	        }
	    }

	    echo json_encode(
	        array(
	            'ok' => $ok,
	            'messages' => $messages
	        )
	    );

}

$test = isset($_GET['ruolo'])? $_GET['ruolo'] : '';

if($test == 'capi'){
	trovaCapiSettore();
}else if($test == 'semplici'){
	trovaImpiegatiSemplici();
}else if($test == 'funzionari'){
	trovaFunzionari();
}




?>
