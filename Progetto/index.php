<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require "common/head.html";
require "common/setup.php";
require "common/funzioni.php";
?>

<body>

	<?php
	require "common/nav.php";
	?>

	<div class="fullscreen">

	<?php
		if (!(isset($_GET["op"]))){
	?>

	<div class="container">

	<?php
		if ((!isset($_SESSION["logged"])) && (!isset($_GET["status"])))
		{
			echo "<div style=\"text-align:center\" class=\"alert alert-warning\><h1>Benvenuto da R&F Corporation</h1></div>";
		}elseif (!isset($_GET["status"])){
	?>
	<!-- SCRIPT PER TOGLIERE MESSAGGIO QUANDO TORNI SULLA HOME-->
	<?php
			echo "<div style=\"text-align:center\" class=\"alert alert-success\"><h1 style=\"text-align:center\">Ciao ". $_SESSION["utente"] . " sei connesso!</h1></div>";
	?>

	<?php
		}

		if (isset($_GET["status"])){
			if($_GET["status"]=='ok')
					echo "<div style=\"text-align:center\" class=\"alert alert-success\"><strong>". urldecode($_GET["msg"]) . "</strong></div>";
				else
					echo "<div style=\"text-align:center\" class=\"alert alert-danger\"><strong>ERRORE!: " . urldecode($_GET["msg"]) . "</strong></div>";
		}
	?>

			<div class="row-indexRF">
					<h1 class="indexRF">Benvenuti<br><strong class="cur">sul nuovo sistema gestionale</strong></h1>
			</div>
			<div class="row-indexRF">
					<span class="indexRF">Puoi creare riunioni e guardare i tuoi inviti tramite questo portale</span>
			</div>



					 <!-- contact us -->

					 <div class="Contact text-center">
									 <div class="row">
											 <div class="col-md-12">
													 <div class="titlepage3">
															 <h2>Contact Us</h2>
													 </div>
											 </div>
									 </div>
									 <div class="row">
											 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
													 <form>
															 <div class="row">
																	 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
																			 <input class="form-control" placeholder="Your name" type="Your name" required="required">
																	 </div>
										 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
																			 <input class="form-control" placeholder="Your surname" type="Your name" required="required">
																	 </div>
																	 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

																			 <input class="form-control" placeholder="Phone" type="Phone" required="required">
																	 </div>
																	 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

																			 <input class="form-control" placeholder="Email" type="email" required="required">
																	 </div>

																	 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

																			 <textarea class="textarea" placeholder="Message" required="required">Message</textarea>
																	 </div>
															 </div>
									 <button class="send-btn" type="submit">Submit</button>
													 </form>
											 </div>


									 </div>
					 </div>
					 <?php
				 }
				 elseif (isset($_GET["op"]))
				 {
				 include "frontend/" . $_GET["op"] . ".php";
				 }
				 ?>

				</div>

		</div>

		<?php
			require "common/foot.html";
			?>


</body>

</html>
