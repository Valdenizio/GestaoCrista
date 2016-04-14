<?php
ini_set('default_charset', 'utf-8');
require_once 'igreja.php';
require_once 'sessao.php';
include_once 'crudIgreja.php';
require_once '../login/autenticador.php';

$mant = ManterIgreja::instanciar();

$aut = Autenticador::instanciar();

if ($aut->esta_logado()) {
	$usuario = $aut->pegar_usuario();
	if ($usuario ['id_perfil']!=1) {
		$aut->expulsar();
	}
}
else {
	$aut->expulsar();
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css" media="all">
    label{font-size:15px}
    </style>
    <!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bootstrap/css/style.css" rel="stylesheet">
        	<title>Gestão Crista</title>
    </head>
    <body>
    
     <?php 	include '../login/topo.php';
    	echo "<br>";
    	//var_export("antes do IF");
    	if (isset($_REQUEST['resultado'])){
    		$teste=$_REQUEST['resultado'];
    		if ($teste=="1"){
    		//var_export("teste1");
    			echo "	<br/><div class='alert alert-success'>
  							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
							<strong>Registro salvo com sucesso!</strong>
							<alert>
						</div>";
    		}
    		if ($teste=="2"){
    			//var_export("teste1");
    			echo "	<br/><div class='alert alert-success'>
  							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
							<strong>Registro excluído com sucesso!</strong>
							<alert>
						</div>";
    		}
    		if ($teste=="3"){
    			//var_export("teste1");
    			echo "	<br/><div class='alert alert-success'>
  							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
							<strong>Registro alterado com sucesso!</strong>
							<alert>
						</div>";
    		}
    	}
    ?>

    <div class="container col-sm-offset-2">

      <div class="starter-template">
        <h2>Pesquisar Igreja</h2>
        <!-- <p> -->
        	<form action="../Igreja/resultado.php" method="get" target="_self">
        		<div class="lead">
    				<div class="col-sm-2">
    					<label for="igreja" class="control-label">Nome da Igreja:</label>
    				</div>
    				<div class="col-sm-7">
      					<input type="text" class="form-control" id="igrejas" name="igreja" placeholder="Digite o nome da Igreja">
    				</div>
 				</div>
 			<br/>
	   	 	<br/>
	   	 	<br/>
 				<div class="lead">
			   		<div class="col-sm-offset-7 col-sm-3">
			   			<button type="submit" class="btn btn-lg btn-default" formaction="../igreja/cadastro.php" name="resultado" value="null">Cadastrar</button>
			   		
			   			<button type="submit" class="btn btn-lg col-sm-offset-1 btn-primary" id="acao" name="acao" value="pesquisar">Pesquisar</button>	   	
					</div>
				</div>
        	</form>
        	<br/>
        	<br/>
        	<br/>
        </div>	

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script>
   
    </body>
</html>

