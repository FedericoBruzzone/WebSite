function conferma() {
  if(!confirm("Sei sicuro di voler confermare la scelta?")) {
    return false;
  }else{
	this.form.submit();
  }
}

function mostra() {
	document.getElementById("motivazioneDiv").style.display="block";
}

function nascondi() {
	document.getElementById("motivazioneDiv").style.display="none";
}

function cancellaRiunione()
{
	var cancella = confirm("Sei sicuro di voler procedere con la cancellazione della riunione?");
	if (cancella) {
		return true;
	} else{
		return false;
	}

}

function cancellaInvito()
{
	var cancella = confirm("Sei sicuro di voler procedere con la cancellazione dell'invito?");
	if (cancella) {
		return true;
	} else{
		return false;
	}

}


function cancellaAutorizzato()
{
	var cancella = confirm("Sei sicuro di voler procedere con la cancellazione dell'autorizzazione?");
	if (cancella) {
		return true;
	} else{
		return false;
	}

}

function check(){
	//var check;
	if (document.getElementById("Accetto").checked){
		//check = document.getElementById("Accetto");
		document.getElementById("motivazione").required = "";
	}else if (document.getElementById("Rifiuto").checked){
		//check = document.getElementById("Rifiuto");
		document.getElementById("motivazione").required = "required";
	}
}

function checkTutti(){
  var i = 0;
   var modulo = document.getElementsByClassName("email");
   for (i=0; i<modulo.length; i++)
   {
       if(modulo[i].type == "checkbox")
       {
           modulo[i].checked = true;
       }
   }
}

function checkCapi(){
  var persone;
  fetch(  './common/funzioni.php?ruolo=capi' , {
    method: 'POST',
    header: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    persone = data;

    persone.forEach(persona  => {
      var modulo = document.getElementById(persona.email);
      if(modulo!=null){
        modulo.checked = true;
      }
    });

    console.log('Dati Ricevuti: ', data);
  })
  .catch((error) => {
    console.error('Errore: ', error);
  });

}

function checkSemplici(){
  var persone;
  fetch(  './common/funzioni.php?ruolo=semplici' , {
    method: 'POST',
    header: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    persone = data;

    persone.forEach(persona  => {
      var modulo = document.getElementById(persona.email);
      if(modulo!=null){
        modulo.checked = true;
      }
    });

    console.log('Dati Ricevuti: ', data);
  })
  .catch((error) => {
    console.error('Errore: ', error);
  });
}

function checkFunzionari(){
  var persone;
  fetch(  './common/funzioni.php?ruolo=funzionari' , {
    method: 'POST',
    header: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    persone = data;

    persone.forEach(persona  => {
      var modulo = document.getElementById(persona.email);
      if(modulo!=null){
        modulo.checked = true;
      }
    });

    console.log('Dati Ricevuti: ', data);
  })
  .catch((error) => {
    console.error('Errore: ', error);
  });
}
