<?php
header('Content-Type: text/html; charset=ISO-8859-1');
//require_once 'membro.php';
require_once 'sessao.php';
require_once 'crudMovimento.php';
require_once '../login/autenticador.php';

$mant = ManterMovimento::instanciar();

$aut = Autenticador::instanciar();

	if ($aut->esta_logado()) {
		$usuario = $aut->pegar_usuario();
	if ($usuario ['id_perfil']!=1) {
		$pdoiv = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
		$sqliv = "select igj.*
		from igreja igj where id_igreja='{$usuario ['id_igreja']}'";
		$stmiv = $pdoiv->query($sqliv);
		$dadosiv = $stmiv->fetch(PDO::FETCH_ASSOC);
		$igjVinculada="<input type='text' class='form-control' style='display:none' id='igreja' name='igreja' value='".$dadosiv['ID_IGREJA']."'>
						<input type='text' class='form-control' id='nmigreja' name='nmigreja' value='".$dadosiv['NM_IGREJA']."' readonly='readonly'>";
	}else{
		$pdoiv = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
		$sqliv = "select igj.*
				from igreja igj";
		$stmiv = $pdoiv->query($sqliv);
		
		$igjVinculada="<select class='form-control' id='igreja' name='igreja' required>
				   				<option selected ></option>";
				   				
				   			
		while($dadosiv = $stmiv->fetch(PDO::FETCH_ASSOC)){
		
			$igjVinculada.="<option value='".$dadosiv['ID_IGREJA']."'>".$dadosiv['NM_IGREJA']."";
		}
		$igjVinculada.="</select>";
	}
		$prfUsuario=$usuario['id_perfil'];
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
     	
     	$id_movimento=$_REQUEST['id_mov'];
     	
     	//Recupera as informações a serem alteradas 
     	//echo "<br><br>"; var_dump($id_movimento);
		$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "select mov.*, tpmov.ds_tipo_movimento, igj.NM_IGREJA
				from movimento mov inner join tipo_movimento tpmov
				on mov.id_tipo_movimento=tpmov.id_tipo_movimento
				left join igreja igj 
				on mov.id_igreja=igj.id_igreja
				where mov.id_movimento = '{$id_movimento}'";
				$stm = $pdo->query($sql);
     	
     	
     	//var_dump($stm);
     	$dados = $stm->fetch(PDO::FETCH_ASSOC);
     		
     	$idmovimento=$dados['id_movimento'];
     	$dtmovimento=$dados['dt_movimento'];
     	$dtregmovimento=$dados['dt_reg_movimento'];
     	$nmiIgreja=$dados['NM_IGREJA'];
     	$dstipomov=$dados['ds_tipo_movimento'];
     	$idigreja=$dados['id_igreja'];
     	$idtpmov=$dados['id_tipo_movimento'];
     	$vlrmov=$dados['vl_movimento'];
     	
     	?>
 <!-- Monta o formulário -->
 <br>
<div class='container col-sm-offset-3'>

      <div class='starter-template'>
        <h2>Alterar Movimento</h2>
           	<form  name="cadMovimento" action='../Movimento/controle.php'>
        		<div class="lead">
        			<div class="col-sm-2">
        				<input type="text" class="form-control" id="id_mov" name="id_mov" style='display:none' value='<?php echo $idmovimento;?>'>
    					<label for="membro" class="control-label">Data atual:</label>
    				</div>
    				<div class="col-sm-2">
      					<input type="text" class="form-control data" id="dtatual" name="dtatual"  value='<?php echo $dtregmovimento;?>' readonly='readonly'>
      				</div>
    				<div class="col-sm-2">
    					<label for="membro" class="control-label">Data do Movimento:<b>*</b></label>
    				</div>
    				<div class="col-sm-2">
      					<input type="text" class="form-control data" id="dtmovimento" name="dtmovimento" value='<?php echo $dtmovimento;?>' readonly='readonly'>
      				</div>
      			</div>
      			<br>
      			<br>
      			<div class="lead">
      				<div class='col-sm-2'>
    					<label for='igreja' class='control-label'>Igreja:</label>
    				</div>
      					<div class="col-sm-4">
      					<?php 	
					   		echo $igjVinculada;
					   	?>
					</div>
      				
    			</div>
    			<br>
    			<div class="lead">
    				<div class="col-sm-2">
    					<label for='tpMovimento' class='control-label'>Tipo de Movimento:<b>*</b></label>
    				</div>
 			   		<div class='col-sm-4'>
			   			<select class='form-control' id='tpmovimento' name='tpmovimento'>
			   				<option value='<?php echo $idtpmov;?>' selected ><?php echo $dstipomov;?></option>
			   				<?php
			   					//Recupera as Regiões cadastradas
				   				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				   				$sql = "select * from tipo_movimento";
				   				$stm = $pdo->query($sql);
				   				//Monta a lista de regiões conforme recuperado do banco.
				   				while($dados = $stm->fetch(PDO::FETCH_ASSOC)){
				   					echo "<option value='".$dados['id_tipo_movimento']."'>".$dados['ds_tipo_movimento']."</option>";
				   				}
				   			?>
			   			</select>	   	
					</div>
 				</div>
 				<br>
 				<div class="lead">
        			<div class="col-sm-2">
    					<label for="movimento" class="control-label">Valor:</label>
    				</div>
    				<div class="col-sm-2">
      					<input type="text" class="form-control" id="valor" name="valor" value='<?php echo $vlrmov;?>' >
      				</div>
    			</div>
 			<br/>
 			<br/>
 			<div class='lead'>
			   		<div class='col-sm-offset-5 col-sm-7'>
			   			<button type="submit" class='btn btn-primary  col-sm-2' formaction="../Movimento/visualizar.php">Cancelar</button>
			   			<button type='submit' class='btn btn-primary col-sm-offset-1 col-sm-2' id='ac' name='ac' value='alt'>Salvar</button>	   	
					</div>
				</div>
 			
 			
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
			$("input.data").mask("99/99/9999");
	    });
		
   </script>
   
   
   
    </body>
</html>

