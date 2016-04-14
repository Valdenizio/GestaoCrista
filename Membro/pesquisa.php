<?php
header('Content-Type: text/html; charset=ISO-8859-1');
require_once 'membro.php';
require_once 'sessao.php';
include_once 'crudMembro.php';
require_once '../login/autenticador.php';

$mant = ManterMembro::instanciar();

$aut = Autenticador::instanciar();

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
    <meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- CSS Complementar -->
    <style type="text/css" media="all">
    b{color:#B22222}
    label{font-size:15px}
    .form-control{height:30px;}
    </style>
    
    <!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bootstrap/css/style.css" rel="stylesheet">
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Versão 3.3.6 -->
	<script src='../bootstrap/js/jquery.js'></script><!-- Versão 1.11.1 -->
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Versão 1.4.1 -->
        	<title>Gestão Crista</title>
    </head>
    <body>
    
     <?php 	include '../login/topo.php';
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
<br/>
    <div class="container col-sm-offset-2">
      <div class="starter-template">
        <h2>Pesquisar Membro</h2>
        <!-- <p> -->
        	<form action="../Membro/resultado.php" method="get" target="_self">
        		<div class="lead">
        			<div class="col-sm-2">
    					<label for="membro" class="control-label">Nome do membro:</label>
    				</div>
    				<div class="col-sm-7">
      					<input type="text" class="form-control" id="membro" name="membro" placeholder="Digite o nome do membro">
    				</div>
 				</div>
 			<br/>
	   	 	<br/>
	   	 		<div class="lead">
	   	 			<div class="col-sm-2">
	   	 				<label for="membro" class="control-label">Igreja:</label>
	   	 			</div>
    				<div class="col-sm-3">
				   		<select class='form-control' id='igreja' name='igreja'>
				   				<option selected ></option>
				   				<?php
				   					//Recupera as Regiões cadastradas
					   				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
					   				$sql = "select igj.*
					   				from igreja igj";
					   				$stm = $pdo->query($sql);
					   				//Monta a lista de regiões conforme recuperado do banco.
					   				while($dados = $stm->fetch(PDO::FETCH_ASSOC)){
					   						
					   					echo "<option value='".$dados['ID_IGREJA']."'>".$dados['NM_IGREJA']."";
					   				}
					   			?>
				   			</select>
				   		</div>
				</div>
				<br/>
				<br/>
				<div class="lead">
			   		<div class="col-sm-offset-7 col-sm-3">
			   			<button type="submit" class="btn btn-lg btn-default" formaction="../Membro/cadastro.php" name="resultado" value="null">Cadastrar</button>
			   		
			   			<button type="submit" class="btn btn-lg col-sm-offset-1 btn-primary" id="acao">Pesquisar</button>	   	
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

