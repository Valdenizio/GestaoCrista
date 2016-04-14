<?php
ini_set('default_charset', 'utf-8');
require_once 'igreja.php';
require_once 'sessao.php';
require_once 'crudIgreja.php';
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
    <meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css" media="all">
    b{color:#B22222}
    label{font-size:15px}
    </style>
    <!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bootstrap/css/style.css" rel="stylesheet">
	
	   	<title>Gestão Crista</title>
    </head>
    <body>
    
    <?php include '../login/topo.php';
    
    if (isset($_REQUEST['res'])){
    
	    $teste=$_GET['res'];
	    if ($teste=="erro"){
	    	//var_export("teste1");
	    	echo "	<br>
					<div class='alert alert-warning'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
	  					<strong>O cadastro não foi efetuado!</strong> Favor tentar novamente.
						<alert>
					</div>";
	    }
    }
    ?>
	<br>
    <div class="container col-sm-offset-2">

      <div class="starter-template">
        <h2>Cadastro de Igreja</h2>
        <!-- <p> -->
        	<form action="../Igreja/controle.php" method="post" target="_self" name="cadIgreja">
        		<div class="lead">
    				<div class="col-sm-2">
    					<label for="igreja" class="control-label">Nome da Igreja:<b>*</b></label>
    				</div>
    				<div class="col-sm-7">
      					<input type="text" class="form-control" id="igreja" name="igreja" placeholder="Igreja" required>
    				</div>
 				</div>
 			<br/>
 			<br/>
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="dirigente" class="control-label">Nome do Dirigente:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-7">
			   			<input type="text" class="form-control" id="dirigente" name="dirigente" placeholder="Nome do dirigente" required>	   	
					</div>
				</div>
			<br/>	
				<div class="lead">
					<div class="col-sm-2">
			   			<label for="conjugue" class="control-label">Nome do Conjugue:</label>
			   		</div>
			   		<div class="col-sm-7">
			   			<input type="text" class="form-control" id="conjugue" name="conjugue" placeholder="Nome do conjugue">	   	
					</div>
				</div>
			<br/>	
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="endereco" class="control-label">Endereço:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-7">
			   			<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço da igreja" required>	   	
					</div>
				</div>
			<br/>	
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="cep" class="control-label">CEP:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-2">
			   			<input type="text" class="form-control cep" onSelect="MascaraCep(cep);" id="cep" name="cep" required  >	   	
					</div>
					<div class="col-sm-2">
						<label for='regiao' class='control-label'>Regiao:<b>*</b></label>
					</div>
 			   		<div class='col-sm-3'>
			   			<select class='form-control' id='regiao' name='regiao' required>
			   				<option selected ></option>
			   				<?php
			   					//Recupera as Regiões cadastradas
				   				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				   				$sql = "select reg.*
				   				from regiao reg";
				   				$stm = $pdo->query($sql);
				   				//Monta a lista de regiões conforme recuperado do banco.
				   				while($dados = $stm->fetch(PDO::FETCH_ASSOC)){
				   						
				   					echo "<option value='".$dados['ID_REGIAO']."'>".$dados['DS_REGIAO']."";
				   				}
				   			?>
			   			</select>	   	
					</div>
				</div>
			<br/>
				<div class='lead'>
			   		<div class="col-sm-2">
			   			<label for='cidade' class='control-label'>Cidade:<b>*</b></label>
 			   		</div>
 			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control' id='cidade' name='cidade' required>
			   		</div>
			   		<div class="col-sm-2">
			   			<label for="telefone" class="control-label">Telefone:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-3">
			   			<input type="tel" class="form-control telefone" id="telefone" name="telefone" required >	   	
					</div>
				</div>
			<br/>
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="inauguracao" class="control-label">Data de Inauguração:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-3">
			   			<input type="text" class="form-control data" id="inauguracao" name="inauguracao" required>	   	
					</div>
				</div>
			<br/>	
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="banco" class="control-label">Banco:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-7">
			   			<input type="text" class="form-control" id="banco" name="banco" placeholder="Nome do banco" required>	   	
					</div>
				</div>
			<br/>	
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="agencia" class="control-label">Agência:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-2">
			   			<input type="text" class="form-control agencia" id="agencia" name="agencia" required >	   	
					</div>
					<div class="col-sm-2">
			   			<label for="conta" class="control-label">Conta:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-3">
			   			<input type="text" class="form-control" id="conta" name="conta" required>	   	
					</div>
				</div>
			<br>
				<div class="lead">
					<div class="col-sm-5">
			   			<label for="inform" class="control-label">Informaçõe gerais sobre a igreja:</label>
			   		</div>
			   	</div>
			   	<div class="lead">
			   		<div class="col-sm-9">
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
 			
				<div class="lead col-sm-offset-4">
			   		<div class="col-sm-offset-3 col-sm-6">
			   			<a href="../Igreja/pesquisa.php">
			   				<button type="button" class="btn btn-primary col-sm-offset-2 col-sm-3" name="cancel">Cancelar</button>
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
	       	    if(phone.length > 14) {
	       	        element.mask("(99) 99999-999?9");
	       	    } else {
	       	        element.mask("(99) 9999-9999?9");  
	       	    }
	       	});
	       	$('#agencia').mask("9999?-9").ready(function(event) {
	       	    var target, agencia, element;
	       	    target = (event.currentTarget) ? event.currentTarget : event.srcElement;
	       	    agencia = target.value.replace(/\D/g, '');
	       	    element = $(target);
	       	    element.unmask();
	       	    
	       	});
		});

   </script>	
    

    </body>
    
</html>
