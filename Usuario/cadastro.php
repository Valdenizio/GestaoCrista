<?php
ini_set('default_charset', 'utf-8');
require_once 'usuario.php';
require_once 'sessao.php';
require_once 'crudUsuario.php';
require_once '../login/autenticador.php';

$mant = ManterUsuario::instanciar();

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

# Iniciando a variavel que vai indentificar se temos que exibir o modal ou não
$exibirModal = false;
# Verificando se não existe o cookie
if(!isset($_COOKIE["usuarioVisualizouModal"]))
{
	# Caso não exista entra aqui.

	# Vamos criar o cookie com duração de 1 semana</pre>
	$diasparaexpirar = 1;
	setcookie('usuarioVisualizouModal', 'SIM', (time() + ($diasparaexpirar * 60)));

	# Seto nossa variavel de controle com o valor TRUE ( Verdadeiro)
	$exibirModal = true;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css" media="all">
    b{color:#B22222}
    </style>
    <!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bootstrap/css/style.css" rel="stylesheet">
	
	   	<title>Gestão Crista</title>
    </head>
    <body>
    
    <?php include '../login/topo.php';
    
    $teste=$_GET['resultado'];
    if ($teste=="erro"){
    	//var_export("teste1");
    	echo "	<div class='alert alert-success'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
  					<strong>O cadastro não foi efetuado!</strong> Favor tentar novamente.
					<alert>
				</div>";
    }
    
    ?>

    <div class="container">

      <div class="starter-template">
        <h1>Cadastro de Usuario</h1>
        <!-- Criar lógica para gerar o login -->
        	<form action="../Igreja/controle.php" method="post" target="_self" name="cadIgreja">
        		<div class="lead">
    				<label for="igreja" class="col-sm-3 control-label">Nome do Usuario:<b>*</b></label>
    				<div class="col-sm-7">
      					<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Login do Usuario" required>
    				</div>
 				</div>
 			<br/>
 			<br/>
				<div class="lead">
			   		<label for="dirigente" class="col-sm-3 control-label">Nome do Dirigente:<b>*</b></label>
			   		<div class="col-sm-7">
			   			<input type="text" class="form-control" id="dirigente" name="dirigente" placeholder="Nome do dirigente" required>	   	
					</div>
				</div>
			<br/>	
				<div class="lead">
			   		<label for="conjugue" class="col-sm-3 control-label">Nome do Conjugue:</label>
			   		<div class="col-sm-7">
			   			<input type="text" class="form-control" id="conjugue" name="conjugue" placeholder="Nome do conjugue">	   	
					</div>
				</div>
			<br/>	
				<div class="lead">
			   		<label for="endereco" class="col-sm-3 control-label">Endereço:<b>*</b></label>
			   		<div class="col-sm-7">
			   			<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço da igreja" required>	   	
					</div>
				</div>
			<br/>	
				<div class="lead">
			   		<label for="cep" class="col-sm-3 control-label">CEP:<b>*</b></label>
			   		<div class="col-sm-2">
			   			<input type="text" class="form-control cep" onSelect="MascaraCep(cep);" id="cep" name="cep" required  >	   	
					</div>
				<!-- </div>
				<div class="lead"> -->
			   		<label for="telefone" class="col-sm-2 control-label">Telefone:<b>*</b></label>
			   		<div class="col-sm-3">
			   			<input type="tel" class="form-control telefone" id="telefone" name="telefone" required >	   	
					</div>
				</div>
			<br/>
				<div class="lead">
			   		<label for="inauguracao" class="col-sm-3 control-label">Data de Inauguração:<b>*</b></label>
			   		<div class="col-sm-3">
			   			<input type="date" class="form-control data" id="inauguracao" name="inauguracao" required>	   	
					</div>
				</div>
			<br/>	
				<div class="lead">
			   		<label for="banco" class="col-sm-3 control-label">Banco:<b>*</b></label>
			   		<div class="col-sm-7">
			   			<input type="text" class="form-control" id="banco" name="banco" placeholder="Nome do banco" required>	   	
					</div>
				</div>
			<br/>	
				<div class="lead">
			   		<label for="agencia" class="col-sm-3 control-label">Agência:<b>*</b></label>
			   		<div class="col-sm-2">
			   			<input type="text" class="form-control" id="agencia" name="agencia" required>	   	
					</div>
				
			   		<label for="conta" class="col-sm-2 control-label">Conta:<b>*</b></label>
			   		<div class="col-sm-3">
			   			<input type="text" class="form-control" id="conta" name="conta" required>	   	
					</div>
				</div>
			<br>
				<div class="lead">
			   		<label for="inform" class="col-sm-5 control-label">Informaçõe gerais sobre a igreja:</label>
			   		<div class="col-sm-10">
			   			<textarea rows="3" class="form-control" id="inform" name="inform" placeholder="Informações gerais sobre a igreja">
			   			</textarea>	   	
					</div>
				</div>
			<br/>
 			<br/>				
			<br/>
 			<br/>
 			<br/>
 			<br/>
 			
				<div class="lead">
			   		<div class="col-sm-offset-8 col-sm-4">
			   			<a href="../Igreja/pesquisa.php">
			   				<button type="button" class="btn btn-primary col-sm-3" name="cancel">Cancelar</button>
			   			</a>
			   			<button type="submit" class="btn btn-primary col-sm-offset-1 col-sm-3" id="acao" name="acao" value="salvar">Salvar</button>	   	
					</div>
				</div>
        	</form>
        <!-- </p> -->
      </div>

    </div><!-- /.container -->
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script>
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script>
	<script src='../bootstrap/js/jquery.min.js'></script>
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script>
	<script type="text/javascript"> 
	
		$(document).ready(function(){
			$("input.data").mask("99/99/9999");
	       	$("input.cep").mask("99.999-999");
	       	$('#telefone').mask("(99) 9999-9999?9").ready(function(event) {
	       	    var target, phone, element;
	       	    target = (event.currentTarget) ? event.currentTarget : event.srcElement;
	       	    phone = target.value.replace(/\D/g, '');
	       	    element = $(target);
	       	    element.unmask();
	       	    if(phone.length > 10) {
	       	        element.mask("(99) 99999-999?9");
	       	    } else {
	       	        element.mask("(99) 9999-9999?9");  
	       	    }
	       	});
		});

   </script>	
    

    </body>
    
</html>
