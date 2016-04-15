<?php
header('Content-Type: text/html; charset=ISO-8859-1');
require_once 'membro.php';
require_once 'sessao.php';
require_once 'crudMembro.php';
require_once '../login/autenticador.php';

$mant = ManterMembro::instanciar();

$aut = Autenticador::instanciar();

	if ($aut->esta_logado()) {
		$usuario = $aut->pegar_usuario();
		if ($usuario ['id_perfil']!=1) {
			$habilita="disabled";
		}else{
			$habilita="";
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
    <!-- ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Versão 3.3.6 -->
    <script src='../bootstrap/js/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Versão 1.4.1 -->
        	<title>Gestão Crista</title>
    </head>
    <body>
    
     <?php 
     	//Incluir o cabeçalho da página
     	include '../login/topo.php';
     	
     	$id_membro=base64_decode($_REQUEST['idmembro']);
     	
     	//Recupera as informações a serem alteradas 
		$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "select mem.*, igj.NM_IGREJA, igj.NM_CIDADE, reg.ds_regiao, crg.ds_cargo
				from membro mem left join igreja igj
				on igj.id_igreja=mem.id_igreja
				left join regiao reg 
				on reg.id_regiao=igj.id_regiao
				left join cargo crg 
				on crg.id_cargo=mem.id_cargo
				where mem.id_membro = '{$id_membro}'";
				$stm = $pdo->query($sql);
     	
     	
     	//var_dump($stm);
     	$dados = $stm->fetch(PDO::FETCH_ASSOC);
     		
     	$idmembro=$dados['id_membro'];
     	//$nr_rol=$dados['nr_rol'];
     	$nr_local=$dados['nr_local'];
     	$idigreja=$dados['id_igreja'];
     	$nmiIgreja=$dados['NM_IGREJA'];
     	$nmregiao=$dados['ds_regiao'];
     	$nmcidade=$dados['NM_CIDADE'];
     	$nmmembro=$dados['nm_membro'];
     	$idcargo=$dados['id_cargo'];
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
     	
     	//var_dump("cargo", $dscargo,"data", $dtMembrecia );
     	if ($cdsexo==1){
     		$sexo = "<option value='1' selected>Feminino</option>
					<option value='2' >Masculino</option>";
     	}else{
     		$sexo = "<option value='1'>Feminino</option>
					<option value='2' selected>Masculino</option>";
     	}
     	
     	switch ($cdestadocivil) {
     	
			case "1":{
	     		$estadocivil = "<option value=1 selected>Casado</option>
			   					<option value=2>Divorciado</option>
			   					<option value=3>Solteiro</option>
			   					<option value=4>União Estável</option>
			   					<option value=5>Viúvo</option>";
	     	}break;
	     	
	     	case "2":{
	     		$estadocivil = "<option value=1>Casado</option>
			   					<option value=2 selected>Divorciado</option>
			   					<option value=3>Solteiro</option>
			   					<option value=4>União Estável</option>
			   					<option value=5>Viúvo</option>";
	     	}break;
	     	
	     	case "3":{
	     		$estadocivil = "<option value=1>Casado</option>
			   					<option value=2>Divorciado</option>
			   					<option value=3 selected>Solteiro</option>
			   					<option value=4>União Estável</option>
			   					<option value=5>Viúvo</option>";
	     	}break;
	     	
	     	case "4":{
	     		$estadocivil = "<option value=1>Casado</option>
			   					<option value=2>Divorciado</option>
			   					<option value=3>Solteiro</option>
			   					<option value=4 selected>União Estável</option>
			   					<option value=5>Viúvo</option>";
	     	}break;
	     	
	     	case "5":{
	     		$estadocivil = "<option value=1>Casado</option>
			   					<option value=2>Divorciado</option>
			   					<option value=3>Solteiro</option>
			   					<option value=4>União Estável</option>
			   					<option value=5  selected>Viúvo</option>";
	     	}break;
     	
     	}	
     	
     	switch ($escolaridade) {
     	
     		case "1":{
     			$escolar="<option value=1 selected>Fundamental</option>
			   					<option value=2>Médio</option>
			   					<option value=3>Superior</option>";
     		}break;
     	
     		case "2":{
     			$escolar="<option value=1>Fundamental</option>
			   					<option value=2 selected>Médio</option>
			   					<option value=3>Superior</option>";
     		}break;
     	
     		case "3":{
     			$escolar="<option value=1>Fundamental</option>
			   					<option value=2>Médio</option>
			   					<option value=3 selected>Superior</option>";
     		}break;
     		
     	}
     	
     	//var_dump($dados['nr_rol']);
     	?>
 <!-- Monta o formulário -->
 <br>
<div class='container col-sm-offset-2'>

      <div class='starter-template'>
        <h2>Ficha do Membro</h2>
           	<form action='../Membro/controle.php' method='post' target='_self' name='cadMembro'>
        		<input type='text' class='form-control' style='display:none' id='idmembro' name='idmembro' value='<?php echo $idmembro; ?>'>
        		<div class='lead'>
        			<div class='col-sm-2'>
    					<label for='membro' class='control-label'>Nº de ROL:<b>*</b></label>
    				</div>
    				<div class='col-sm-1'>
      					<input type='text' class='form-control' id='nrrol' name='nrrol' value='<?php echo $idmembro; ?>' readonly='readonly'>
    				</div>
    				<div class='col-sm-2'>
    					<label for='membro' class='control-label'>Nº do local:</label>
    				</div>
    				<div class='col-sm-1'>
      					<input type='text' class='form-control' id='nrlocal' name='nrlocal' value='<?php echo $nr_local; ?>'>
    				</div>
    			</div>
    			<br>
    			<br>
    			<div class='lead'>
    				<div class='col-sm-2'>
    					<label for='igreja' class='control-label'>Igreja:<b>*</b></label>
    				</div>
 			   		<div class='col-sm-4'>
			   			<select class='form-control igreja' id='igreja' name='igreja' onchange='alimentarCampo();'>
			   				<?php 
								if ($nmiIgreja <> ""){
     								echo "<option value='".$idigreja."' title='".$nmcidade."' id='".$nmregiao."'>".$nmiIgreja."</option>";
     							}else{
     								echo "<option selected></option>";
     							}
				   				$pdor = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
			   					//Recupera as Regiões cadastradas
				   				$sqlr = 'select igj.ID_IGREJA, igj.NM_CIDADE, reg.ds_regiao, igj.nm_igreja 
				   				from igreja igj inner join regiao reg
								on igj.id_regiao=reg.id_regiao';
				   				$stmr = $pdor->query($sqlr);
				   				//var_dump("teste");
				   				//Monta a lista de regiões conforme recuperado do banco.
				   				while($lista = $stmr->fetch(PDO::FETCH_ASSOC)){
				   					if ($idigreja!=$lista['ID_IGREJA'])	{
				   						echo "<option value='".$lista['ID_IGREJA']."' title='".$lista['NM_CIDADE']."' id='".$lista['ds_regiao']."'>".$lista['nm_igreja']."</option>";
				   					}
				   				}
				   			?>
			   			</select>	   	
					</div>
 				</div>
 			<br/>
 			
 			<div class='lead'>
 				<div class='col-sm-2'>
 					<label for='igreja' class='control-label'>Região:</label>
    			</div>
    			<div class='col-sm-3'>
      				<input type='text' class='form-control' id='regiao' name='regiao' value='<?php echo $nmregiao; ?>' readonly='readonly'>
    			</div>
 				<div class='col-sm-2'>
 					<label for='igreja' class='control-label'>Cidade:</label>
    			</div>
    			<div class='col-sm-2'>
      				<input type='text' class='form-control' id='cidade' name='cidade' value='<?php echo $nmcidade; ?>' readonly='readonly'>
    			</div>
			</div>
 			<br/>
 			<div class='lead'>
    			<div class='col-sm-2'>
    				<label for='igreja' class='control-label'>Cargo:</label>
    			</div>
    			<div class='col-sm-3'>
      				<select class='form-control' id='cargo' name='cargo'>
      				<?php 
			   			if ($idcargo <> ""){
     								echo "<option value='".$idcargo."'>".$dscargo."</option>";
     							}else{
     								echo "<option selected></option>";
     							}
				   				$pdoc = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
			   					//Recupera as Regiões cadastradas
				   				$sqlc = 'select * from cargo';
				   				$stmc = $pdoc->query($sqlc);
				   				//var_dump("teste");
				   				//Monta a lista de regiões conforme recuperado do banco.
				   				while($listac = $stmc->fetch(PDO::FETCH_ASSOC)){
				   					if ($idcargo!=$listac['id_cargo'])	{
				   						echo "<option value='".$listac['id_cargo']."'>".$listac['ds_cargo']."</option>";
				   					}
				   				}	
				   	?>
				   	</select>
    			</div>
 				<div class='col-sm-2'>
	 				<label for='igreja' class='control-label'>Data de membrecia:</label>
	    		</div>
	    		<div class='col-sm-2'>
	      			<input type='text' class='form-control data' id='dtmembrecia' name='dtmembrecia' value='<?php echo $dtMembrecia; ?>'>
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
					<input type='text' class='form-control' id='membro' name='membro' value='<?php echo $nmmembro; ?>'>	   	
				</div>
			</div>
			<br/>	
				<div class='lead'>
			   		<div class='col-sm-2'>
			   			<label for='rg' class='control-label'>RG:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='rg' name='rg' value='<?php echo $nrRg; ?>'>	   	
					</div>
					<div class='col-sm-2'>
			   			<label for='cpf' class='control-label'>CPF:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control cpf' id='cpf' name='cpf' value='<?php echo $nrCpf; ?>'>	   	
					</div>
				</div>
			<br/>	
				<div class='lead'>
			   		<div class='col-sm-2'>
			   			<label for='escolaridade' class='control-label'>Escolaridade:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<select class='form-control' id='escolaridade' name='escolaridade'>
			   				<?php echo $escolar; ?>
			   			</select>	   	
					</div>
					<div class='col-sm-2'>
						<label for='dtnascimento' class='control-label'>Data de nascimento:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control data' id='dtnascimento' name='dtnascimento' value='<?php echo $dtNascimento; ?>' required>	   	
					</div>
				</div>
			<br/>
				<div class='lead'>
			   		<div class='col-sm-2'>
			   			<label for='sexo' class='control-label'>Sexo:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<select class='form-control' id='sexo' name='sexo'>
			   				<?php 
			   					echo $sexo;
     						?>
			   			</select>	   	
					</div>
					<div class='col-sm-offset-1 col-sm-2'>
						<label for='civil' class='control-label'>Estado civil:</label>
					</div>
			   		<div class='col-sm-2'>
			   			<select class='form-control' id='civil' name='civil'>
			   				<?php 
			   					echo $estadocivil;
			   				?>
			   			</select>
			   		</div>
				</div>
			<br/>	
				<div class='lead'>
			   		<div class='col-sm-2'>
			   			<label for='endereco' class='control-label'>Endereço:</label>
			   		</div>
			   		<div class='col-sm-5'>
			   			<input type='text' class='form-control' id='endereco' name='endereco' value='<?php echo $endereco; ?>'>	   	
					</div>
				</div>
			<br/>	
				<div class='lead'>
					<div class='col-sm-2'>
						<label for='email' class='control-label'>E-mail:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='email' name='email' value='<?php echo $dsemail; ?>'>	   	
					</div>
					<div class='col-sm-2'>
			   			<label for='telefone' class='control-label'>Telefone:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control telefone' id='telefone' name='telefone'  value='<?php echo $nrtelefone; ?>'>	   	
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
			   			<input type='text' class='form-control' id='pai' name='pai' value='<?php echo $nmpai; ?>'>	   	
					</div>
				</div>
			<br>
				<div class='lead'>
					<div class='col-sm-offset-2 col-sm-2'>
			   			<label for='mae' class='control-label'>Nome da mãe:</label>
			   		</div>
			   		<div class='col-sm-5'>
			   			<input type='text' class='form-control' id='mae' name='mae' value='<?php echo $nmmae; ?>' required>	   	
					</div>
				</div>
				<br>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='conjugue' class='control-label'>Nome do conjugue:</label>
			   		</div>
			   		<div class='col-sm-5'>
			   			<input type='text' class='form-control' id='conjugue' name='conjugue' value='<?php echo $nmConjugue; ?>'>	   	
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
			   			<input type='number' class='form-control' min=0 id='homens' name='homens'  value='<?php echo $nrfilhos; ?>'required>	   	
					</div>
					<div class='col-sm-offset-1 col-sm-2'>
						<label for='filhas' class='control-label'>Mulher:<b>*</b></label>
			   		</div>
			   		<div class='col-sm-1'>
			   			<input type='number' class='form-control' min=0 id='mulher' name='mulher'  value='<?php echo $nrfilhas; ?>'required>	   	
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
			   			<input type='text' class='form-control' id='conversao' name='conversao'  value='<?php echo $dtconversao; ?>'>	   	
					</div>
					<div class='col-sm-2'>
						<label for='lugarconv' class='control-label'>Lugar:</label>
					</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='lugarconv' name='lugarconv' value='<?php echo $lugarconversao; ?>'>	   	
					</div>
				</div>
				<br/>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='bataguas' class='control-label'>Bat. Aguas:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control' id='bataguas' name='bataguas' value='<?php echo $dtbatismoaguas; ?>'>	   	
					</div>
					<div class='col-sm-2'>
						<label for='lugarbat' class='control-label'>Lugar:</label>
					</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='lugarbat' name='lugarbat' value='<?php echo $lugarbataguas; ?>'>	   	
					</div>
				</div>
				<br/>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='ministro' class='control-label'>Ministro:</label>
			   		</div>
			   		<div class='col-sm-5'>
			   			<input type='text' class='form-control' id='ministro' name='ministro' value='<?php echo $ministro; ?>'>	   	
					</div>
				</div>
				<br/>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='bates' class='control-label'>Bat. E. S.:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control' id='bates' name='bates' value='<?php echo $dtbates; ?>'>	   	
					</div>
					<div class='col-sm-2'>
						<label for='lugares' class='control-label'>Lugar:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='lugares' name='lugares' value='<?php echo $lugares; ?>'>	   	
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
			   			<input type='text' class='form-control' id='nomemin' name='nomemin' value='<?php echo $nmantigomin; ?>'>	   	
					</div>
				</div>
 				<br/>
				<div class='lead'>
					<div class='col-sm-2'>
						<label for='cargoant' class='control-label'>Cargo:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='cargoant' name='cargoant' value='<?php echo $cargoantigomin; ?>'>	   	
					</div>
				</div>
				<br/>
				<div class='lead'>
			   		<div class='col-sm-2'>
			   			<label for='datamemant' class='control-label'>Data Membrecia:</label>
			   		</div>
			   		<div class='col-sm-2'>
			   			<input type='text' class='form-control data' id='datamemant' name='datamemant' value='<?php echo $dtantigomin; ?>'>	   	
					</div>
					<div class='col-sm-2'>
						<label for='lugarant' class='control-label'>Lugar:</label>
			   		</div>
			   		<div class='col-sm-3'>
			   			<input type='text' class='form-control' id='lugarant' name='lugarant' value='<?php echo $lugarantigomin; ?>'>	   	
					</div>
				</div>
				<br/>
				<div class='lead'>
					<div class='col-sm-2'>
			   			<label for='pastor' class='control-label'>Pastor:</label>
			   		</div>
			   		<div class='col-sm-5'>
			   			<input type='text' class='form-control' id='pastor' name='pastor' value='<?php echo $pastorantigomin; ?>'>	   	
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
				</div>
			<br/>
 			<br/>				
			<br/>
 			<br/>
 			<br/>
 			
 				<div class='lead'>
			   		<div class='col-sm-offset-3 col-sm-6'>
			   			<a href='../Membro/pesquisa.php'>
			   				<button type='button' class='col-sm-offset-1 btn btn-primary col-sm-2' name='cancel'>Cancelar</button>
			   			</a>
			   			<button type='button' class='btn btn-primary col-sm-offset-1 col-sm-2' <?php echo $habilita; ?> data-toggle='modal' data-target='.perf'>Perfil</button>
			   			<button type='button' class='btn btn-primary col-sm-offset-1 col-sm-2' <?php echo $habilita; ?> data-toggle='modal' data-target='.hist'>historico</button>
						<button type='submit' class='btn btn-primary col-sm-offset-1 col-sm-2' id='acao' name='acao' value='alterar'>Salvar</button>	   	
					</div>
				</div>
			<br/>
 			<br/>
 			
        	</form>
        <!-- </p> -->
      </div>

    </div><!-- /.container -->

    <!-- JavaScript e Bootstrap
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
		function alimentarCampo() {
		    var minhaLista = document.getElementById("igreja");
		    
		    document.getElementById("regiao").value = minhaLista.options[minhaLista.selectedIndex].id;
		    document.getElementById("cidade").value = minhaLista.options[minhaLista.selectedIndex].title;
		}
   </script>
   
   <div class='modal fade perf in' id='modal' tabindex='-1' role='dialog' aria-labelledby="myModalPerf">
  		<div class='modal-dialog' role='dialog'>
    		<div class='modal-content'>
      			<div class='modal-header'>
        			<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        			<h4 class='modal-title' id='myModalPerf'>Registro de Perfil</h4>
      			</div>
      			<form method='post' action='../Membro/controle.php' target='_self'>
      				<div class='modal-body'>
        				<input type='text' style='display:none' id='id_membro' name='id_membro' value='<?php echo $idmembro; ?>'>
        				<?php 
	        				$pdou = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
	        				$sqlu = "select usu.*, per.ds_perfil
						   			from usuario usu inner join perfil per
									on usu.id_perfil=per.id_perfil
									where usu.id_membro='{$idmembro}'";
	        				$stmu = $pdou->query($sqlu);
	        				
	        				//var_export($stmu->rowCount());
	        				if ($stmu->rowCount()<1){
	        					$vlrLogin="";
	        					$vlrSenha="";
	        					$vlrOpcao="<option selected></option>";
	        					$const=1;
	        				}else{
	        					$listau = $stmu->fetch(PDO::FETCH_ASSOC);
	        					$vlrLogin="value='".$listau['ds_login']."'";
	        					$vlrSenha="value='".$listau['ds_senha']."'";
	        					$perf=$listau['id_perfil'];
	        					$perfnome=$listau['ds_perfil'];
	        					$vlrOpcao="<option value='".$perf."'>".$perfnome."</option>";
	        					$const=0;
	        					
	        				}
	        			?>
	        			<br>
	        			<div class="row">	
	        				<div class="col-sm-2">
	    						<label for="usuario" class="control-label">Login:<b>*</b></label>
	    					</div>
		    				<div class="col-sm-4">
		      					<input type="text" class="form-control " id="loginmembro" name="loginmembro" <?php echo $vlrLogin;?>required>
		    				</div>
	    				</div>
	    				<br>
	    				<div class="row">
		    				<div class="col-sm-2">
		    					<label for="membro" class="control-label">Senha:<b>*</b></label>
		    				</div>
		    				<div class="col-sm-4">
		      					<input type="text" class="form-control" id="senhamembro" name="senhamembro" <?php echo $vlrSenha;?> required>
		    				</div>
						</div>
	    				<br>
						<div class="row">
							<div class="col-sm-2">
		    					<label for='igreja' class='control-label'>perfil:<b>*</b></label>
		    				</div>
		 			   		<div class='col-sm-4'>
					   			<select class='form-control igreja' id='perfilmembro' name='perfilmembro'>
					   				<?php
					   					echo $vlrOpcao;
					   					//Recupera os perfis cadastradas
					   					if ($const==1){
										$pdop = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
							   			$sqlp = "select pfl.*
							   			from perfil pfl";
							   			$stmp = $pdop->query($sqlp);
							   			
							   			//Monta a lista de perfis conforme recuperado do banco.
							   			while($listap = $stmp->fetch(PDO::FETCH_ASSOC)){
							   				echo "<option value='".$listap['id_perfil']."'>".$listap['ds_perfil']."</option>";
							   			}
					   					}else{
					   						$pdop = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
					   						$sqlp = "select pfl.*
							   				from perfil pfl where id_perfil<>'{$perf}'";
					   						$stmp = $pdop->query($sqlp);
					   						//Monta a lista de perfis conforme recuperado do banco.
					   						while($listap = $stmp->fetch(PDO::FETCH_ASSOC)){
					   							echo "<option value='".$listap['id_perfil']."'>".$listap['ds_perfil']."</option>";
					   						}
					   					}
						   			?>
					   			</select>	   	
							</div>
	 					</div>
	 				</div>
 				  		<br>
      				<div class='modal-footer'>
        				<button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
        				<button type='submit' class='btn btn-primary' name='acao' value='svperfil'>Salvar</button>
      					<button type='submit' class='btn btn-primary' name='acao' value='experfil'>Excluir</button>
      				</div>
      			</form>
    		</div>
    		<br>
    		<br>
    		<br>
  		</div>
	</div>
   
   <div class='modal fade hist in' id='modal' tabindex='-1' role='dialog' aria-labelledby="myModalHist">
  		<div class='modal-dialog' role='dialog'>
    		<div class='modal-content'>
      			<div class='modal-header'>
        			<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        			<h4 class='modal-title' id='myModalHist'>cadastro de histórico</h4>
      			</div>
      			<form method='post' action='../Membro/controle.php' target='_self'>
      				<div class='modal-body'>
        				<input type='text' style='display:none' id='id_membro' name='id_membro' value='<?php echo $idmembro; ?>'>
        				<div class="row">	
	        				<div class="col-sm-2">
	    						<label for="Hist" class="control-label">Data do Fato:<b>*</b></label>
	    					</div>
		    				<div class="col-sm-4">
		      					<input type="text" class="form-control data" id="dt_historico" name="dt_historico" required>
		    				</div>
	    				</div>
	    				<br>
	    				<div class="row">
		    				<div class="col-sm-2">
		    					<label for="membro" class="control-label">Senha:<b>*</b></label>
		    				</div>
		    				<div class="col-sm-5">
		      					<input type="text" class="form-control" id="ds_historico" name="ds_historico" required>
		    				</div>
						</div>
	    				<br>
					</div>
 				  		<br>
      				<div class='modal-footer'>
        				<button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
        				<button type='submit' class='btn btn-primary' name='acao' value='svhist'>Salvar</button>
      				</div>
      			</form>
    		</div>
    		<br>
    		<br>
    		<br>
  		</div>
	</div>
   
    </body>
</html>

