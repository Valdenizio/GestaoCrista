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
    
     <?php 
     	include '../login/topo.php';
     	
     	$idigreja=$_REQUEST['idigreja'];
     	if (isset($_REQUEST['igreja'])){
     		$paramPesquisa=$_REQUEST['igreja'];
     	}else{
     		$paramPesquisa="";
     	}
     		
     	//Removendo criptografia
     	$id_igreja=base64_decode($idigreja);
     	
     	//Monta pesquisa de igreja
     	$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "select igj.*, reg.ds_regiao
				from igreja igj left join regiao reg
				on igj.id_regiao=reg.id_regiao
				where igj.id_igreja = '{$id_igreja}'";
				
				$stm = $pdo->query($sql);
     	
     	
     	//$igrejabj = new Igreja();
     	$dados = $stm->fetch(PDO::FETCH_ASSOC);
     		
     	$nmiIgreja=$dados['NM_IGREJA'];
     	$nmDirigente=$dados['NM_DIRIGENTE'];
     	$nmConjugue=$dados['NM_CONJUGUE'];
     	$endIgreja=$dados['DS_ENDERECO'];
     	$cdCEP=$dados['CD_CEP'];
     	$cdRegiao=$dados['ID_REGIAO'];
     	$nmCidade=$dados['NM_CIDADE'];
     	$telefone=$dados['NR_TELEFONE'];
     	$dtInauguracao=$dados['DT_INAUGURACAO'];
     	$banco=$dados['NM_BANCO'];
     	$agencia=$dados['NR_AGENCIA'];
     	$conta=$dados['NR_CONTA'];
     	$informacoes=$dados['DS_INFOMACOES'];
     	if (isset($dados['ds_regiao'])){
     		$nmRegiao=$dados['ds_regiao'];
     		//var_dump($nmRegiao);
     	}else{
     		$nmRegiao="";
     		//var_dump("não tem regiao");
     	}
     	
     	

echo  "<br>
		<div class='container col-sm-offset-2'>
       <div class='starter-template'>
         <h2>Dados da Igreja</h2>
 			<form action='../Igreja/alterar.php' method='post' target='_self'>
      					<input type='text' class='form-control' style='display:none' id='idigreja' name='idigreja' value='". $id_igreja."'>
        		<div class='lead'>
     				<div class='col-sm-2'>
    					<label for='igreja' class='control-label'>Nome da Igreja:</label>
     				</div>
     				<div class='col-sm-7'>
      					<input type='text' class='form-control' id='igrejas' name='igreja' value='".$nmiIgreja."'  readonly='readonly'>
    				</div>
  				</div>
  			<br/>
 			<br/>
				<div class='lead'>
 			   		<div class='col-sm-2'>
     					<label for='dirigente' class='control-label'>Nome do Dirigente:</label>
			   		</div>
     				<div class='col-sm-7'>
			   			<input type='text' class='form-control' id='dirigente' name='dirigente' value='".$nmDirigente."' readonly='readonly'>	   	
					</div>
 				</div>
			<br/>	
				<div class='lead'>
         			<div class='col-sm-2'>
			   			<label for='conjugue' class='control-label'>Nome do Conjugue:</label>
			   		</div>
         			<div class='col-sm-7'>
			   			<input type='text' class='form-control' id='conjugue' name='conjugue' value='".$nmConjugue."' readonly='readonly'>	   	
					</div>
				</div>
			<br/>	
				<div class='lead'>
     				<div class='col-sm-2'>
			   			<label for='endereco' class='control-label'>Endereço:</label>
			   		</div>
     				<div class='col-sm-7'>
			   			<input type='text' class='form-control' id='endereco' name='endereco' value='".$endIgreja."' readonly='readonly'>	   	
					</div>
 				</div>
			<br/>	
				<div class='lead'>
     				<div class='col-sm-2'>
			   			<label for='cep' class='control-label'>CEP:</label>
     				</div>
 			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control cep' id='cep' name='cep' value='".$cdCEP."' readonly='readonly'>	   	
					</div>
			   		<div class='col-sm-2'>
 			   			<label for='regiao' class='control-label'>Regiao:</label>
			   		</div>
 			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='regiao' name='regiao' value='".$nmRegiao."' readonly='readonly'>	   	
					</div>
				</div>
			<br/>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='cidade' class='control-label'>Cidade:</label>
 			   		</div>
					<div class='col-sm-2'>
			   			<input type='text' class='form-control' id='cidade' name='cidade' value='".$nmCidade."' readonly='readonly'>	   	
					</div>
					<div class='col-sm-2'>
 			   			<label for='telefone' class='control-label'>Telefone:</label>
					</div>
 			   		<div class='col-sm-3'>
			   			<input type='tel' class='form-control telefone' id='telefone' name='telefone' value='".$telefone."' readonly='readonly'>	   	
					</div>
				</div>
			<br/>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='inauguracao' class='control-label'>Data de Inauguração:</label>
					</div>
			   		<div class='col-sm-3'>
			   			<input type='date' class='form-control data' id='inauguracao' name='inauguracao' value='".$dtInauguracao."' readonly='readonly'>	   	
 					</div>
				</div>
			<br/>	
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='banco' class='control-label'>Banco:</label>
					</div>
			   		<div class='col-sm-7'>
			   			<input type='text' class='form-control' id='banco' name='banco' value='".$banco."' readonly='readonly'>	   	
					</div>
				</div>
			<br/>	
				<div class='lead'>
 			   		<div class='col-sm-2'>
			   			<label for='agencia' class='control-label'>Agência:</label>
 			   		</div>
 			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control agencia' id='agencia' name='agencia' value='".$agencia."' readonly='readonly'>	   	
					</div>
			   		<div class='col-sm-2'>
			   			<label for='conta' class='control-label'>Conta:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='conta' name='conta' value='".$conta."' readonly='readonly'>	   	
					</div>
				</div>
			<br/>
				<div class='lead'>
					<div class='col-sm-5'>
			   			<label for='inform' class='control-label'>Informaçõe gerais sobre a igreja:</label>
			   		</div>
					<div class='col-sm-9'>
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
			   		<div class='col-sm-offset-3 col-sm-6'>
			   			<a href='../Igreja/resultado.php?igreja=".$paramPesquisa."'>
			   				<button type='button' class='btn btn-primary col-sm-offset-1 col-sm-2' name='cancel'>Voltar</button>
 			   			</a>
			   			<button type='button' class='btn btn-primary col-sm-offset-1 col-sm-2' data-toggle='modal' data-target='#modal' >Excluir</button>
				   		<button type='submit' class='btn btn-primary col-sm-offset-1 col-sm-2' id='acao' name='acao' value='alterar'>Alterar</button>
				   		<button type='submit' class='btn btn-primary col-sm-offset-1 col-sm-2' formtarget='_blank' formaction='Imprime.php?id=".$id_igreja."' >Imprimir</button>
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
	       	$('#agencia').mask("9999?-9").ready(function(event) {
	       	    var target, agencia, element;
	       	    target = (event.currentTarget) ? event.currentTarget : event.srcElement;
	       	    agencia = target.value.replace(/\D/g, '');
	       	    element = $(target);
	       	    element.unmask();
	       	    
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
