<?php

include_once("setup.php");
include_once("funzioni.php");

$ris = leggiTipoUtente($cid);
?>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark" >
  <div class="container">
    <a class="navbar-brand" href="index.php">HOME</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
	<?php
          if (isset($_SESSION["logged"])){
         ?>

		<div class="collapse navbar-collapse" style="display: inline-block">

        <ul class="navbar-nav me-auto ">

        <li class="nav-item dropdown " >
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Riunioni</a>
          <ul class="dropdown-menu">
          <?php
          if($ris != "Impiegato non autorizzato"){
          ?>
          <li><a class="dropdown-item" href="index.php?op=creaRiunione">Crea Riunione</a></li>
          <li><a class="dropdown-item" href="index.php?op=riunioniCreate">Riunioni Create</a></li>
          <?php
          }
          ?>
          <li><a class="dropdown-item " href="index.php?op=riunioniFuture">Riunione Future</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Inviti</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?op=invitiRicevuti">Inviti Ricevuti</a></li>
            <li><a class="dropdown-item" href="index.php?op=invitiAccettati">Inviti Accettati</a></li>
            <li><a class="dropdown-item" href="index.php?op=invitiRifiutati">Inviti Rifiutati</a></li>
          </ul>
        </li>

        <?php
          if($ris == "Direttore"){
          ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Autorizza</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?op=visualizzaAutorizzati">Visualizza/Cancella Autorizzati</a></li>
            <li><a class="dropdown-item" href="index.php?op=autorizzaUtente">Autorizza utente</a></li>
          </ul>
        </li>
        <?php
          }
          ?>


        <li>
          <a class="nav-link" style="color:#FFFACD"><?php echo $ris;?> </a>
        </li>




      <?php
            }
           ?>

      </ul>
      <?php
              if (isset($_SESSION["logged"])){
             ?>
      <li>
        <a href="index.php?op=profiloUtente" style="color:white">Profilo</a><br>
      </li>
      <?php
    }
             ?>


		<div style="font-size:90%">

        <?php
          if (isset($_SESSION["logged"])){
             ?>
            <li><a class="nav-link" href="backend/logout-exe.php"><i class="bi bi-box-arrow-in-left"></i>Logout</a></li>
            <?php
		      } else {
            ?>

            <li class="nav-item dropdown">
            <a class="nav-link " href="#" data-bs-toggle="dropdown">Login / Registrazione <i class="bi bi-person"></i></a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#login-modal">Login</a></li>
              <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#register-modal">Registrazione</a></li>
            </ul>
            </li>
            <?php
		      }
		        ?>
		 </div>
	</div>
</div>

</nav>



<!-- Modal Login -->
<div class="modal" id="login-modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Accedi al tuo account</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

      <!--  <form method="POST" action="backend/login-exe.php"> -->

          <div style="margin-top:20px;margin-bot:20px">
            <input type="email" name="user" placeholder="Email" required="required" id="email">
          </div>
          <div style="margin-top:20px;margin-bot:20px">
            <input type="password" name="pass" placeholder="Password" required="required" id="psw"><br>
          </div>
          <div style="margin-top:10px;margin-bot:10px">
            Ricordami : <input type="checkbox" name="ricordami" id="remember"><br>
          </div>
          <div style="margin-top:10px;margin-bot:20px">
            <input type="submit" name="login" class="login loginmodal-submit" value="Login" id="submit"><br>
          </div>
          <div style="margin-top:30px;margin-bot:20px">
            <li class="formMessage" id="form-messages"></li>
          </div>
			<!-- 	</form> -->
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" style="margin: 0 auto" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<!-- Modal Register style="width:1000px;height:1000px"-->
<div class="modal" id="register-modal">
  <div class="modal-dialog">
    <div  class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color:#212529">
        <h4 class="modal-title">Registrati</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

      <!--  <form method="POST" action="backend/login-exe.php"> -->
      <div style="margin-top:20px;margin-bot:20px">
        <input type="text" name="nomeR" placeholder="Nome" required="required" id="nomeR"><br>
      </div>
      <div style="margin-top:20px;margin-bot:20px">
        <input type="text" name="cognomeR" placeholder="Cognome" required="required" id="cognomeR"><br>
      </div>
          <div style="margin-top:20px;margin-bot:20px">
            <input type="email" name="userR" placeholder="Email" required="required" id="emailR"><br>
          </div>
          <div style="margin-top:20px;margin-bot:20px">
            <input type="password" name="passwordR" placeholder="Password" required="required" id="passwordR"><br>
          </div>
          <div style="margin-top:20px;margin-bot:20px">
            <input type="date" name="dataR" placeholder="Data" required="required" id="dataR"><br>
          </div>
          <div style="margin-top:20px;margin-bot:20px">
            <input type="text" name="dipartimentoR" placeholder="Dipartimento" required="required" id="dipartimentoR"><br>
          </div>
          <div style="margin-top:10px;margin-bot:20px">
            <input type="submit" name="submitR" class="login loginmodal-submit" value="Registrati" id="submitR"><br>
          </div>
          <div style="margin-top:30px;margin-bot:20px">
            <li class="formMessage" id="form-messagesR"></li>
          </div>
			<!-- 	</form> -->
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" style="margin: 0 auto" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<script>

  const form = {
    email: document.getElementById('email'),
    psw: document.getElementById('psw'),
    submit: document.getElementById('submit'),
    remember: document.getElementById('remember'),
    messages: document.getElementById('form-messages')
  };

  const formR = {
    nome: document.getElementById('nomeR'),
    cognome: document.getElementById('cognomeR'),
    email: document.getElementById('emailR'),
    psw: document.getElementById('passwordR'),
    data: document.getElementById('dataR'),
    dipartimento: document.getElementById('dipartimentoR'),
    submit: document.getElementById('submitR'),
    messages: document.getElementById('form-messagesR')
  };

  form.submit.addEventListener('click', () => {

      const request = new XMLHttpRequest();

      request.onload = () => {
        let responseObject = null;

        try {
          responseObject = JSON.parse(request.responseText);
        } catch (e) {
          console.error("Could not parse JSON");
        }

        if(responseObject) {
          handleResponse(responseObject);
        }

          console.log(responseObject);


      };

      const requestData = `email=${form.email.value}&psw=${form.psw.value}&remember=${form.remember.checked}`;

      request.open('post','./backend/login-exe.php');
      request.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');
      request.send(requestData);

  });


    function handleResponse(responseObject){
      if (responseObject.ok){
        location.href = 'index.php';
      }else {
        while (form.messages.firstChild){
          form.messages.removeChild(form.messages.firstChild);
        }

        responseObject.messages.forEach((message) => {
          const li = document.createElement('li');
          li.textContent = message;
          form.messages.appendChild(li);
        });
        form.messages.style.display = "block";
      }

    }


    formR.submit.addEventListener('click', () => {

        const request = new XMLHttpRequest();

        request.onload = () => {
          let responseObject = null;

          try {
            responseObject = JSON.parse(request.responseText);
          } catch (e) {
            console.error("Could not parse JSON");
          }

          if(responseObject) {
            handleResponseR(responseObject);
          }

            console.log(responseObject);


        };

        const requestDataR = `nome=${formR.nome.value}&cognome=${formR.cognome.value}&email=${formR.email.value}&psw=${formR.psw.value}&data=${formR.data.value}}&dipartimento=${formR.dipartimento.value}`;

        request.open('post','./backend/registrazione-exe.php');
        request.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');
        request.send(requestDataR);

        console.log(requestDataR);
    });




    function handleResponseR(responseObject){
      if (responseObject.ok){
        location.href = 'index.php';
      }else {
        while (formR.messages.firstChild){
          formR.messages.removeChild(formR.messages.firstChild);
        }

        responseObject.messages.forEach((message) => {
          const li = document.createElement('li');
          li.textContent = message;
          formR.messages.appendChild(li);
        });
        formR.messages.style.display = "block";
      }

    }


</script>
