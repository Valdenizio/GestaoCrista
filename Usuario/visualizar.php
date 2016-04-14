<?php
ini_set('default_charset', 'utf-8');
require_once 'usuario.php';
require_once 'sessao.php';
require_once 'crudUsuario.php';
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
        <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bootstrap/css/style.css" rel="stylesheet">
        	<title>Gestão Crista</title>
    </head>
    <body>
    
     <?php 
     	include '../login/topo.php';
     	//include_once 'igreja.php';
     	$idigreja=$_REQUEST['id_igreja'];
     	$paramPesquisa=$_REQUEST['igreja'];
     	//Removendo criptografia
     	$id_igreja=base64_decode($idigreja);
     	
     	
     	$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=utf8','root','');
				$sql = "select *
				from igreja
				where igreja.id_igreja like '%{$id_igreja}%'";
				$stm = $pdo->query($sql);
     	
     	
     	//$igrejabj = new Igreja();
     	$dados = $stm->fetch(PDO::FETCH_ASSOC);
     		
     	//$idigreja=$dados['ID_IGREJA'];
     	$nmiIgreja=$dados['NM_IGREJA'];
     	$nmDirigente=$dados['NM_DIRIGENTE'];
     	$nmConjugue=$dados['NM_CONJUGUE'];
     	$endIgreja=$dados['DS_ENDERECO'];
     	$cdCEP=$dados['CD_CEP'];
     	$telefone=$dados['NR_TELEFONE'];
     	$dtInauguracao=$dados['DT_INAUGURACAO'];
     	$banco=$dados['NM_BANCO'];
     	$agencia=$dados['NR_AGENCIA'];
     	$conta=$dados['NR_CONTA'];
     	$informacoes=$dados['DS_INFOMACOES'];
     	     	//var_dump($nmiIgreja);    	
     

echo  "<div class='container'>
       <div class='starter-template'>
         <h1>Dados da Igreja</h1>
 			<form action='../Igreja/alterar.php' method='post' target='_self'>
      					<input type='text' class='form-control' style='display:none' id='idigreja' name='idigreja' value='". $id_igreja."'>
        		<div class='lead'>
    				<label for='igreja' class='col-sm-3 control-label'>Nome da Igreja:</label>
     				<div class='col-sm-7'>
      					<input type='text' class='form-control' id='igrejas' name='igreja' value='".$nmiIgreja."'  readonly='readonly'>
    				</div>
  				</div>
  			<br/>
 			<br/>
				<div class='lead'>
 			   		<label for='dirigente' class='col-sm-3 control-label'>Nome do Dirigente:</label>
			   		<div class='col-sm-7'>
			   			<input type='text' class='form-control' id='dirigente' name='dirigente' value='".$nmDirigente."' readonly='readonly'>	   	
					</div>
 				</div>
			<br/>	
				<div class='lead'>
			   		<label for='conjugue' class='col-sm-3 control-label'>Nome do Conjugue:</label>
			   		<div class='col-sm-7'>
			   			<input type='text' class='form-control' id='conjugue' name='conjugue' value='".$nmConjugue."' readonly='readonly'>	   	
					</div>
				</div>
			<br/>	
				<div class='lead'>
			   		<label for='endereco' class='col-sm-3 control-label'>Endereço:</label>
			   		<div class='col-sm-7'>
			   			<input type='text' class='form-control' id='endereco' name='endereco' value='".$endIgreja."' readonly='readonly'>	   	
					</div>
 				</div>
			<br/>	
				<div class='lead'>
			   		<label for='cep' class='col-sm-3 control-label'>CEP:</label>
 			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control cep' id='cep' name='cep' value='".$cdCEP."' readonly='readonly'>	   	
					</div>
 			   		<label for='telefone' class='col-sm-2 control-label'>Telefone:</label>
 			   		<div class='col-sm-3'>
			   			<input type='tel' class='form-control telefone' id='telefone' name='telefone' value='".$telefone."' readonly='readonly'>	   	
					</div>
				</div>
			<br/>
				<div class='lead'>
			   		<label for='inauguracao' class='col-sm-3 control-label'>Data de Inauguração:</label>
			   		<div class='col-sm-3'>
			   			<input type='date' class='form-control data' id='inauguracao' name='inauguracao' value='".$dtInauguracao."' readonly='readonly'>	   	
 					</div>
				</div>
			<br/>	
				<div class='lead'>
			   		<label for='banco' class='col-sm-3 control-label'>Banco:</label>
			   		<div class='col-sm-7'>
			   			<input type='text' class='form-control' id='banco' name='banco' value='".$banco."' readonly='readonly'>	   	
					</div>
				</div>
			<br/>	
				<div class='lead'>
			   		<label for='agencia' class='col-sm-3 control-label'>Agência:</label>
 			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control' id='agencia' name='agencia' value='".$agencia."' readonly='readonly'>	   	
					</div>
					<label for='conta' class='col-sm-2 control-label'>Conta:</label>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='conta' name='conta' value='".$conta."' readonly='readonly'>	   	
					</div>
				</div>
			<br/>
				<div class='lead'>
			   		<label for='inform' class='col-sm-5 control-label'>Informaçõe gerais sobre a igreja:</label>
			   		<div class='col-sm-10'>
			   			<textarea rows='3' class='form-control' id='inform' name='inform' readonly='readonly'>".$informacoes."</textarea>	   	
 					</div>
				</div>
			<br/>
 			<br/>				
			<br/>
 			<br/>
 			<br/>
 			<br/>
				<div class='lead'>
			   		<div class='col-sm-offset-7 col-sm-4'>
			   				<a href='../Igreja/resultado.php?igreja=".$paramPesquisa."'>
			   					<button type='button' class='btn btn-primary col-sm-3' name='cancel'>Voltar</button>
 			   				</a>
			   				<button type='button' class='btn btn-primary col-sm-offset-1 col-sm-3' data-toggle='modal' data-target='#modal' >Excluir</button>
				   			<button type='submit' class='btn btn-primary col-sm-offset-1 col-sm-3' id='acao' name='acao' value='alterar'>Alterar</button>	   	
	 					</div>
					</div>
	        	</form>        
	      </div>
	    </div>
	";
?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Versão 3.3.6 -->
	<script src='../bootstrap/js/jquery.js'></script><!-- Versão 1.11.1 -->
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Versão 1.4.1 -->
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
    <div class='modal fade' id='modal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
  		<div class='modal-dialog' role='document'>
    		<div class='modal-content'>
      			<div class='modal-header'>
        			<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        			<h4 class='modal-title' id='myModalLabel'>Confirmação</h4>
      			</div>
      			<form method='post' action='../Igreja/controle.php' target='_self'>
      				<div class='modal-body' id='resultado'>
        				<input type='text' style='display:none' id='id_igreja' name='id_igreja' value='<?php echo $id_igreja; ?>'>
        				<label>Deseja realmente excluir o cadastro da igreja "<?php echo $nmiIgreja; ?>"?  </label>
						<br>
				  	</div>
      				<div class='modal-footer'>
        				<button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
        				<button type='submit' class='btn btn-primary' name='acao' value='excluir'>Confirmar</button>
      	
      				</div>
      			</form>
    		</div>
  		</div>
	</div>
    
    </body>
</html>
