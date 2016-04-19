<?php
header('Content-Type: text/html; charset=ISO-8859-1', true);
require_once 'autenticador.php';

$aut = Autenticador::instanciar();

//$usuario = null;
if ($aut->esta_logado()) {
	$usuario = $aut->pegar_usuario();
}
else {
	$aut->expulsar();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta chaset="utf-8"/>
    <style type="text/css" media="all">
	    .icone {
	    height:70px;
	    }
	    .navbar-nav > li > a {
 			padding-top: 25px;
  			padding-bottom: 25px;
  		}
    </style>
    
    <!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap.css.map" rel="stylesheet">
	<link href="../bootstrap/css/style.css" rel="stylesheet">
	   
        	<title>Gestão Crista</title>
    </head>
    <body>
    
   	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   	<script src='../bootstrap/js/bootstrap.min.js'></script><!-- Versão 3.3.6 -->
	<script src='../bootstrap/js/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Versão 1.4.1 -->
    
	    <nav class="navbar navbar-inverse navbar-fixed-top icone">
	      <div class="container">
	        <div class="navbar-header">
	        	<!-- <div class="icone"> -->
	          		<a class="navbar-brand" href="../login/principal.php"><img src="../Biblioteca/Imagens/link.png" height="40px"></a>
	          	<!-- </div> -->
	        </div>
	        <div id="navbar" class="navbar-collapse collapse">
	          <div class="icone">
	          <ul class="nav navbar-nav">
	            <?php 
	            	if ($usuario['id_perfil']==1) {
	            		echo "	<li><a href='../Igreja/pesquisa.php?resultado='><strong>Igreja</Strong></a></li>
								
						";
	            	}
	            ?>
	            <li><a href='../Membro/pesquisa.php'><strong>Membro</strong></a></li>
	            <li><a href='../Movimento/pesquisa.php'><strong>Movimento</strong></a></li>
	          </ul>
	         	<div class="collapse navbar-collapse collapse navbar-right">
	          		<ul class="nav navbar-nav">
	          			<li>
	          				<a href="../index.php">Sair</a>
	          			</li>
	          		</ul>
	        	</div>
	        	</div>
	        </div>
	      </div>
	    </nav>
    </body>
</html>
