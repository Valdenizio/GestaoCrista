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
    <!-- CSS Complementar -->
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
    
     <?php 
     	//Incluir o cabeçalho da página
     	include '../login/topo.php';
     	
     	$id_igreja=$_REQUEST['idigreja'];
     	
     	
     	//Recupera as informações a serem alteradas 
     	$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "select igj.*, reg.ds_regiao
				from igreja igj left join regiao reg
				on igj.id_regiao=reg.id_regiao
				where igj.id_igreja = '{$id_igreja}'";
				$stm = $pdo->query($sql);
     	
     	
     	//Carrega sa variáveis com os valores retornados
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
     	}else{
     		$nmRegiao="";
     	}
     	
     	//$id_igreja=base64_decode($id_igreja);	
     	
//Monta o formulário
?>
<br>
<div class='container col-sm-offset-2'>

       <div class='starter-template'>
         <h2>Alterar Igreja</h2>
 			<form action='../Igreja/controle.php' method='post' target='_self'>
      					<input type='text' class='form-control' id='idigreja' name='idigreja' value='<?php echo $id_igreja;?>' style='display:none'>
        		<div class='lead'>
    				<div class="col-sm-2">
    					<label for='igreja' class='control-label'>Nome da Igreja:</label>
    				</div>
     				<div class='col-sm-7'>
      					<input type='text' class='form-control' id='igreja' name='igreja' value='<?php echo $nmiIgreja;?>' readonly='readonly'>
    				</div>
  				</div>
  			<br/>
 			<br/>
				<div class='lead'>
 			   		<div class="col-sm-2">
 			   			<label for='dirigente' class='control-label'>Nome do Dirigente:<b>*</b></label>
 			   		</div>
			   		<div class='col-sm-7'>
			   			<input type='text' class='form-control' id='dirigente' name='dirigente' value='<?php echo $nmDirigente;?>' required>	   	
					</div>
 				</div>
			<br/>	
				<div class='lead'>
					<div class="col-sm-2">
			   			<label for='conjugue' class='control-label'>Nome do Conjugue:</label>
			   		</div>
			   		<div class='col-sm-7'>
			   			<input type='text' class='form-control' id='conjugue' name='conjugue' value='<?php echo $nmConjugue;?>'>	   	
					</div>
				</div>
			<br/>	
				<div class='lead'>
					<div class="col-sm-2">
			   			<label for='endereco' class='control-label'>Endereço:<b>*</b></label>
			   		</div>
			   		<div class='col-sm-7'>
			   			<input type='text' class='form-control' id='endereco' name='endereco' value='<?php echo $endIgreja;?>' required>	   	
					</div>
 				</div>
			<br/>	
				<div class='lead'>
					<div class="col-sm-2">
			   			<label for='cep' class='control-label'>CEP:<b>*</b></label>
 			   		</div>
 			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control cep' id='cep' name='cep' value='<?php echo $cdCEP;?>' required>	   	
					</div>
					<div class="col-sm-2">
 			   			<label for='regiao' class='control-label'>Regiao:<b>*</b></label>
 			   		</div>
 			   		<div class='col-sm-3'>
			   			<select class='form-control' id='regiao' name='regiao' required>
				   			<?php
				   				if ($nmRegiao <> ""){
				   					echo "<option value='".$dados['ID_REGIAO']."' selected>".$dados['ds_regiao']."</option>";
				   				}else{
				   					echo "<option selected></option>";
				   				}
				   					//Recupera as Regiões cadastradas
					   				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
					   				$sqlreg = 'select reg.*
					   				from regiao reg';
					   				$stmreg = $pdo->query($sqlreg);
					   				
					   				//Monta a lista de regiões conforme recuperado do banco.
					   				while($dado = $stmreg->fetch(PDO::FETCH_ASSOC)){
					   					if ($nmRegiao!=$dado['DS_REGIAO'])	{
					   						echo "<option value='".$dado['ID_REGIAO']."'>".$dado['DS_REGIAO']."</option>";
					   					}
					   					
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
			   			<input type='text' class='form-control' id='cidade' name='cidade' value='<?php echo $nmCidade;?>' required>	   	
					</div>
 			   		<div class="col-sm-2">
 			   			<label for='telefone' class='control-label'>Telefone:<b>*</b></label>
 			   		</div>
 			   		<div class='col-sm-3'>
			   			<input type='tel' class='form-control telefone' id='telefone' name='telefone' value='<?php echo $telefone;?>' required>	   	
					</div>
				</div>
			<br/>
				<div class='lead'>
					<div class="col-sm-2">
			   			<label for='inauguracao' class='control-label'>Data de Inauguração:<b>*</b></label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control data' id='inauguracao' name='inauguracao' value='<?php echo $dtInauguracao;?>' required>	   	
 					</div>
				</div>
			<br/>	
				<div class='lead'>
					<div class="col-sm-2">
			   			<label for='banco' class='control-label'>Banco:<b>*</b></label>
			   		</div>
			   		<div class='col-sm-7'>
			   			<input type='text' class='form-control' id='banco' name='banco' value='<?php echo $banco;?>' required>	   	
					</div>
				</div>
			<br/>	
				<div class='lead'>
					<div class="col-sm-2">
			   			<label for='agencia' class='control-label'>Agência:<b>*</b></label>
 			   		</div>
 			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control agencia' id='agencia' name='agencia' value='<?php echo $agencia;?>' required>	   	
					</div>
					<div class="col-sm-2">
			   			<label for='conta' class='control-label'>Conta:<b>*</b></label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='conta' name='conta' value='<?php echo $conta;?>' required>	   	
					</div>
				</div>
			<br/>
				<div class='lead'>
					<div class="col-sm-5">
			   			<label for='inform' class='control-label'>Informaçõe gerais sobre a igreja:</label>
			   		</div>
			   		<div class='col-sm-9'>
			   			<textarea rows='3' class='form-control' id='inform' name='inform'><?php echo $informacoes;?></textarea>	   	
 					</div>
				</div>
			<br/>
 			<br/>				
			<br/>
 			<br/>
 			<br/>
 			<br/>
				<div class='lead col-sm-offset-4'>
			   		<div class='col-sm-offset-3 col-sm-6'>
			   			<a href='../Igreja/visualizar.php?id_igreja=<?php echo base64_encode($id_igreja);?>'>
			   				<button type='button' class='btn btn-primary col-sm-offset-2 col-sm-3' name='cancel'>Cancelar</button>
 			   			</a>	
 			   			<button type='submit' class='btn btn-primary col-sm-offset-1 col-sm-3' id='acao' name='acao' value='alterar'>Salvar</button>	   	
 					</div>
				</div>
        	</form>
        </div>
    </div>


    <!-- JavaScript e Bootstrap
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Versão 3.3.6 -->
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
    </body>
</html>

