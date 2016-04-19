<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'membro.php';
require_once 'sessao.php';
require_once 'crudMembro.php';
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
    </style>
    
    <!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bootstrap/css/style.css" rel="stylesheet">
        	<title>Gestão Crista</title>
    </head>
    <body>
    
     <?php 
     	include '../login/topo.php';
     	//
     	if (isset($_REQUEST['res'])){
	     	$teste=$_GET['res'];
	     	
	     	if ($teste=="erro"){
	     		//var_export("teste1");
	     		echo "	<br/><div class='alert alert-danger'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
	  					<strong>O cadastro não foi efetuado!</strong> Favor tentar novamente.
						<alert>
					</div>";
	     	}
     	}
     	//include_once 'igreja.php';
     	$idmembro=$_REQUEST['id_membro'];
     	if (isset($_REQUEST['membro'])){
     		$paramPesquisa1=$_REQUEST['membro'];
     	}else{
     		$paramPesquisa1="";
     	}
     	if (isset($_REQUEST['membro'])){
     		$paramPesquisa2=$_REQUEST['igreja'];
     	}else{
     		$paramPesquisa2="";
     	}
     	
     	//Removendo criptografia
     	$id_membro=base64_decode($idmembro);
     	//echo "<br><br>"; var_dump($id_membro);
     	
     	$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "select mem.*, igj.NM_IGREJA, igj.NM_CIDADE, reg.ds_regiao, crg.ds_cargo
				from membro mem left join igreja igj
				on igj.id_igreja=mem.id_igreja
				left join regiao reg 
				on reg.id_regiao=igj.id_regiao
				left join cargo crg on crg.id_cargo=mem.id_cargo
				where mem.id_membro = {$id_membro}";
				$stm = $pdo->query($sql);
     	
     	//var_dump($stm);
     	
     	$dados = $stm->fetch(PDO::FETCH_ASSOC);
     		
     	$nr_rol=$dados['id_membro'];
     	$nr_local=$dados['nr_local'];
     	$nmiIgreja=$dados['NM_IGREJA'];
     	$nmregiao=$dados['ds_regiao'];
     	$nmcidade=$dados['NM_CIDADE'];
     	$nmmembro=$dados['nm_membro'];
     	$dscargo=$dados['ds_cargo'];
     	$dtMembrecia=$dados['dt_membrecia'];
     	$nrRg=$dados['nr_rg'];
     	$nrCpf=$dados['nr_cpf'];
     	$dtNascimento=$dados['dt_nascimento'];
     	$cdsexo=$dados['cd_sexo'];
     	$cdestadocivil=$dados['cd_estado_civil'];
     	$escolaridade=$dados['cd_escolaridade'];
     	$endereco=$dados['ds_endereco'];
     	$nrtelefone=$dados['nr_telefone'];
     	$dsemail=$dados['ds_email'];
     	$nmpai=$dados['nm_pai'];
     	$nmmae=$dados['nm_mae'];
     	$nmConjugue=$dados['nm_conjugue'];
     	$nrfilhas=$dados['nr_filhos_mulheres'];
     	$nrfilhos=$dados['nr_filhos_homens'];
     	$dtconversao=$dados['dt_conversao'];
     	$lugarconversao=$dados['ds_lugar_conversao'];
     	$dtbatismoaguas=$dados['dt_bat_aguas'];
     	$lugarbataguas=$dados['ds_lugar_aguas'];
     	$ministro=$dados['nm_ministro'];
     	$dtbates=$dados['dt_bat_es'];
     	$lugares=$dados['ds_lugar_es'];
     	$nmantigomin=$dados['nm_antigo_minist'];
     	$cargoantigomin=$dados['ds_cargo_antigo_min'];
     	$dtantigomin=$dados['dt_membrecia_antigo'];
     	$lugarantigomin=$dados['ds_lugar_antigo_minist'];
     	$pastorantigomin=$dados['nm_pastor'];
     	$historicoantigomin=$dados['ds_historico'];
     	
     	if ($cdsexo==1){
     		$sexo="Feminino";
     	}else{
     		$sexo="Masculino";
     	}
     	
     	switch ($cdestadocivil) {
     	
			case "1":{
	     		$estadocivil="Casado";
	     	}break;
	     	
	     	case "2":{
	     		$estadocivil="Divorciado";
	     	}break;
	     	
	     	case "3":{
	     		$estadocivil="Solteiro";
	     	}break;
	     	
	     	case "4":{
	     		$estadocivil="União Estável";
	     	}break;
	     	
	     	case "5":{
	     		$estadocivil="Viúvo";
	     	}break;
     		
	     	default:{
	     		$estadocivil="";
	     	}
     	}
     	
     	switch ($escolaridade) {
     	
     		case "1":{
     			$escolar="Fundamental";
     		}break;
     		 
     		case "2":{
     			$escolar="Médio";
     		}break;
     		 
     		case "3":{
     			$escolar="Superior";
     		}break;
     		
     		default:{
     			$escolar="";
     		}
     		
     	}
     	
     	
     	
?>
     <br>
   
     <div class='container col-sm-offset-2'>

      <div class='starter-template'>
        <h2>Ficha do Membro</h2>
        <!-- <p> -->
        	<form action='../Membro/alterar.php' method='post' target='_self' name='cadMembro'>
        		<input type='text' class='form-control' style='display:none' id='idmembro' name='idmembro' value='<?php echo $idmembro;?>'>
     			<div class='lead'>
        			<div class='col-sm-2'>
    					<label for='membro' class='control-label'>Nº de ROL:</label>
    				</div>
    				<div class='col-sm-1'>
      					<input type='text' class='form-control' id='nrrol' name='nrrol' value='<?php echo $nr_rol;?>' readonly='readonly'>
    				</div>
    				<div class='col-sm-2'>
    					<label for='membro' class='control-label'>Nº do local:</label>
    				</div>
    				<div class='col-sm-1'>
      					<input type='text' class='form-control' id='nrlocal' name='nrlocal' value='<?php echo $nr_local;?>' readonly='readonly'>
    				</div>
    			</div>
    			<br>
    			<br>
    			<div class='lead'>
    				<div class='col-sm-2'>
    					<label for='igreja' class='control-label'>Igreja:</label>
    				</div>
 			   		<div class='col-sm-4'>
			   			<input type='text' class='form-control' id='igreja' name='igreja' value='<?php echo $nmiIgreja;?>' readonly='readonly'>	   	
					</div>
 				</div>
 			<br/>
 			
 			<div class='lead'>
 				<div class='col-sm-2'>
 					<label for='igreja' class='control-label'>Região:</label>
    			</div>
    			<div class='col-sm-3'>
      				<input type='text' class='form-control' id='regiao' name='regiao' value='<?php echo $nmregiao;?>' readonly='readonly'>
    			</div>
 				<div class='col-sm-2'>
 					<label for='igreja' class='control-label'>Cidade:</label>
    			</div>
    			<div class='col-sm-2'>
      				<input type='text' class='form-control' id='cidade' name='cidade' value='<?php echo $nmcidade;?>' readonly='readonly'>
    			</div>
			</div>
 			<br/>
 			<div class='lead'>
    			<div class='col-sm-2'>
    				<label for='igreja' class='control-label'>Cargo:</label>
    			</div>
    			<div class='col-sm-3'>
      				<input type='text' class='form-control' id='cargo' name='cargo' value='<?php echo $dscargo;?>' readonly='readonly'>
    			</div>
 				<div class='col-sm-2'>
	 				<label for='membrecia' class='control-label'>Data de membrecia:</label>
	    		</div>
	    		<div class='col-sm-2'>
	      			<input type='text' class='form-control data' id='membrecia' name='membrecia' value='<?php echo $dtMembrecia;?>' readonly='readonly'>
	    		</div>
	    	</div>
 			<br/>
 			<div class='lead col-sm-offset-4 '>
 				<h3><strong>Dado Pessoais</strong></h3>
 			</div>
 			<br/>
 			<div class='lead'>
				<div class='col-sm-2'>
					<label for='membro' class='control-label'>Nome:</label>
				</div>
				<div class='col-sm-7'>
					<input type='text' class='form-control' id='membro' name='membro' value='<?php echo $nmmembro;?>' readonly='readonly'>	   	
				</div>
			</div>
			<br/>	
				<div class='lead'>
			   		<div class='col-sm-2'>
			   			<label for='rg' class='control-label'>RG:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='rg' name='rg' value='<?php echo $nrRg;?>' readonly='readonly'>	   	
					</div>
					<div class='col-sm-2'>
			   			<label for='cpf' class='control-label'>CPF:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control cpf' id='cpf' name='cpf' value='<?php echo $nrCpf;?>' readonly='readonly'>	   	
					</div>
				</div>
			<br/>	
				<div class='lead'>
			   		<div class='col-sm-2'>
			   			<label for='escolaridade' class='control-label'>Escolaridade:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='escolaridade' name='escolaridade' value='<?php echo $escolar;?>' readonly='readonly'>	   	
					</div>
					<div class='col-sm-2'>
						<label for='dtnascimento' class='control-label'>Data de nascimento:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control data' id='dtnascimento' name='dtnascimento' value='<?php echo $dtNascimento;?>' readonly='readonly'>	   	
					</div>
				</div>
			<br/>
				<div class='lead'>
			   		<div class='col-sm-2'>
			   			<label for='sexo' class='control-label'>Sexo:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control' id='sexo' name='sexo' value='<?php echo $sexo;?>' readonly='readonly'>	   	
					</div>
					<div class='col-sm-offset-1 col-sm-2'>
						<label for='civil' class='control-label'>Estado civil:</label>
					</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control' id='civil' name='civil' value='<?php echo $estadocivil;?>' readonly='readonly'>
			   		</div>
				</div>
			<br/>	
				<div class='lead'>
			   		<div class='col-sm-2'>
			   			<label for='endereco' class='control-label'>Endereço:</label>
			   		</div>
			   		<div class='col-sm-5'>
			   			<input type='text' class='form-control' id='endereco' name='endereco' value='<?php echo $endereco;?>' readonly='readonly'>	   	
					</div>
				</div>
			<br/>	
				<div class='lead'>
					<div class='col-sm-2'>
						<label for='email' class='control-label'>E-mail:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='email' class='form-control' id='email' name='email' value='<?php echo $dsemail;?>' readonly='readonly'>	   	
					</div>
					<div class='col-sm-2'>
			   			<label for='telefone' class='control-label'>Telefone:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control telefone' id='telefone' name='telefone' value='<?php echo $nrtelefone;?>' readonly='readonly'>	   	
					</div>
				</div>
				<br/>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='filiacao' class='control-label'>Filiação:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<label for='pai' class='control-label'>Nome do Pai:</label>
			   		</div>
			   		<div class='col-sm-5'>
			   			<input type='text' class='form-control' id='pai' name='pai' value='<?php echo $nmpai;?>' readonly='readonly'>	   	
					</div>
				</div>
			<br>
				<div class='lead'>
					<div class='col-sm-offset-2 col-sm-2'>
			   			<label for='mae' class='control-label'>Nome da mãe:</label>
			   		</div>
			   		<div class='col-sm-5'>
			   			<input type='text' class='form-control' id='mae' name='mae' value='<?php echo $nmmae;?>' readonly='readonly'>	   	
					</div>
				</div>
				<br>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='conjugue' class='control-label'>Nome do conjugue:</label>
			   		</div>
			   		<div class='col-sm-5'>
			   			<input type='text' class='form-control' id='conjugue' name='conjugue'  value='<?php echo $nmConjugue;?>' readonly='readonly'>	   	
					</div>
				</div>
			<br>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='filhos' class='control-label'>Nº de filhos:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<label for='filhos' class='control-label'>Homens:</label>
			   		</div>
			   		<div class='col-sm-1'>
			   			<input type='number' class='form-control' min=0 id='homens' name='homens'value='<?php echo $nrfilhos;?>' readonly='readonly'>	   	
					</div>
					<div class='col-sm-offset-1 col-sm-2'>
						<label for='filhas' class='control-label'>Mulher:</label>
			   		</div>
			   		<div class='col-sm-1'>
			   			<input type='number' class='form-control' min=0 id='mulher' name='mulher'value='<?php echo $nrfilhas;?>' readonly='readonly'>	   	
					</div>
				</div>
				<br/>
				<div class='lead col-sm-offset-4'>
 					<h3><strong>Dado Religiosos</strong></h3>
 				</div>
 				<br/>
				<div class='lead'>
			   		<div class='col-sm-2'>
			   			<label for='conversao' class='control-label'>Conversão:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control' id='conversao' name='conversao' value='<?php echo $dtconversao;?>' readonly='readonly'>	   	
					</div>
					<div class='col-sm-2'>
						<label for='lugarconv' class='control-label'>Lugar:</label>
					</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='lugarconv' name='lugarconv' value='<?php echo $lugarconversao;?>' readonly='readonly'>	   	
					</div>
				</div>
				<br/>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='bataguas' class='control-label'>Bat. Aguas:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control' id='bataguas' name='bataguas' value='<?php echo $dtbatismoaguas;?>' readonly='readonly'>	   	
					</div>
					<div class='col-sm-2'>
						<label for='lugarbat' class='control-label'>Lugar:</label>
					</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='lugarbat' name='lugarbat' value='<?php echo $lugarbataguas;?>' readonly='readonly'>	   	
					</div>
				</div>
				<br/>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='ministro' class='control-label'>Ministro:</label>
			   		</div>
			   		<div class='col-sm-5'>
			   			<input type='text' class='form-control' id='ministro' name='ministro' value='<?php echo $ministro;?>' readonly='readonly'>	   	
					</div>
				</div>
				<br/>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='bates' class='control-label'>Bat. E. S.:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control' id='bates' name='bates' value='<?php echo $dtbates;?>' readonly='readonly'>	   	
					</div>
					<div class='col-sm-2'>
						<label for='lugares' class='control-label'>Lugar:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='lugares' name='lugares' value='<?php echo $lugares;?>' readonly='readonly'>	   	
					</div>
				</div>
				<br/>
				<div class='lead  col-sm-offset-4'>
 					<h3><strong>Dado do Antigo Ministério</strong></h3>
 				</div>
 				<br/>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='nomemin' class='control-label'>Nome:</label>
			   		</div>
			   		<div class='col-sm-4'>
			   			<input type='text' class='form-control' id='nomemin' name='nomemin' value='<?php echo $nmantigomin;?>' readonly='readonly'>	   	
					</div>
				</div>
 				<br/>
				<div class='lead'>
					<div class='col-sm-2'>
						<label for='cargoant' class='control-label'>Cargo:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='cargoant' name='cargoant' value='<?php echo $cargoantigomin;?>' readonly='readonly'>	   	
					</div>
				</div>
				<br/>
				<div class='lead'>
			   		<div class='col-sm-2'>
			   			<label for='datamemant' class='control-label'>Data Membrecia:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control data' id='datamemant' name='datamemant' value='<?php echo $dtantigomin;?>' readonly='readonly'>	   	
					</div>
					<div class='col-sm-2'>
						<label for='lugarant' class='control-label'>Lugar:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='lugarant' name='lugarant' value='<?php echo $lugarantigomin;?>' readonly='readonly'>	   	
					</div>
				</div>
				<br/>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='pastor' class='control-label'>pastor:</label>
			   		</div>
			   		<div class='col-sm-5'>
			   			<input type='text' class='form-control' id='pastor' name='pastor' value='<?php echo $pastorantigomin;?>' readonly='readonly'>	   	
					</div>
				</div>
				<br/>
				<div class='lead col-sm-9'>
			   		<?php
						$pdoh = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
						     	$sqlh = "select * from historico_membro where id_membro = {$id_membro} order by dt_historico";
						     	$stmh = $pdoh->query($sqlh);
						     	
						     	//echo "<br><br>";var_dump($sqlh);
						     	
						     	if ($stmh->rowCount(PDO::FETCH_ASSOC)>0) {
						     		echo "	<div class='lead  col-sm-offset-4'>
						 						<h3><strong>Histórico do Membro</strong></h3>
						 					</div>
											<table class='table table-striped table-bordered'>
											<tr>
												<td class='col-sm-1 text-center'><strong>Data do fato</strong></td>
												<td class='col-sm-3 text-center'><strong>Descrição do Fato</strong></td>
												<td class='col-sm-1'/>
											</tr>";
						     			
						     	
						     		while($dadosHist = $stmh->fetch(PDO::FETCH_ASSOC)){
						     	
						     			//Criptografando parametros enviados via get
						     			$idhistorico=base64_encode($dadosHist['id_historico']);
						     			//$nmmembro=base64_encode($dadosHist[]);
						     			//$idigreja=base64_encode($igreja);
						     	
						     			echo "<tr>
											<td class='text-center'>".$dadosHist['dt_historico']."</td>
											<td>".$dadosHist['ds_historico']."</td>
											<td class='text-center'>
											<center><form action='../Membro/controle.php' method='post' target='_self'>
											<input type='text' style='display:none' id='idhist' name='idhist' value='".$dadosHist['id_historico']."'>
	  										<input type='text' style='display:none' id='id_membro' name='id_membro' value='".$dadosHist['id_membro']."'>
		  									<button type='submit' class='btn btn-default col-sm-offset-1 btn-xs btn-acao' name='acao' value='exhist'>Excluir</button>
											</form></center></td>
											</tr>"; 
				     		}
				     		echo "</table>";
				     	}
					?>
				</div>
			<br/>
 			<br/>				
			<br/>
 			<br/>
 			<br/>
 			
 				<div class='lead'>
			   		<div class='col-sm-offset-3 col-sm-6'>
			   			<a href='../Membro/resultado.php?mem=<?php echo $paramPesquisa1;?>&igj=<?php echo $paramPesquisa2;?>'>
			   				<button type='button' class='btn btn-primary col-sm-offset-1 col-sm-2' name='cancel'>Voltar</button>
 			   			</a>
			   			<button type='button' class='btn btn-primary col-sm-offset-1 col-sm-2' data-toggle='modal' data-target='#modal' >Excluir</button>
				   		<button type='submit' class='btn btn-primary col-sm-offset-1 col-sm-2' id='acao' name='acao' value='alterar'>Alterar</button>
						<button type='submit' class='btn btn-primary col-sm-offset-1 col-sm-2' formtarget='_blank' formaction='Imprime.php?id=<?php echo $idmembro;?>' >Imprimir</button>
	 				</div>
				</div>
			<br/>
 			<br/>
 			
        	</form>
        <!-- </p> -->
      </div>

    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Versão 3.3.6 -->
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Versão 1.4.1 -->
	<script type="text/javascript"> 
	
		$(document).ready(function(){
			$("input.cpf").mask("999.999.999-99");
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
        			<h4 class='modal-title' id='myModalLabel'>Confirmação.</h4>
      			</div>
      			<form method='post' action='../Membro/controle.php' target='_self'>
      				<div class='modal-body' id='resultado'>
        				<input type='text' style='display:none' id='id_membro' name='id_membro' value='<?php echo $idmembro; ?>'>
        				<label>Deseja realmente excluir o cadastro do membro <?php echo $nmmembro; ?>.  </label>
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
