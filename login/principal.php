<?php
ini_set('default_charset', 'utf-8');
require_once 'usuario.php';
require_once 'sessao.php';
require_once 'autenticador.php';

$aut = Autenticador::instanciar();

//$usuario = null;
if ($aut->esta_logado()) {
	$usuario = $aut->pegar_usuario();//var_export($usuario);
}
else {
	$aut->expulsar();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css" media="all">
	    .fundo {
	    opacity: 0.4;
	    filter: alpha(opacity=40); /* For IE8 and earlier */
	    }
    </style>
    <!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bootstrap/css/style.css" rel="stylesheet">
        	<title>Gestão Crista</title>
    </head>
    <body>
    <?php include 'topo.php';?>
    	
        <div class="container col-sm-offset-3">

      <div class="starter-template">
        <br/>
        <br/>
        <div class="fundo">
        	<img alt="Monisterio Gerreiros da Fe" src="../Biblioteca/Imagens/logo.png" height="600px">
        </div>
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Versão 3.3.6 -->
	<script src='../bootstrap/js/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Versão 1.4.1 -->
    </body>
</html>
