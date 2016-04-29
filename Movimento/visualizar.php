<?php
header('Content-Type: text/html; charset=utf-8');
//require_once 'membro.php';
require_once 'sessao.php';
require_once 'crudMovimento.php';
require_once '../login/autenticador.php';

$mant = ManterMovimento::instanciar();

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
	     		
	     		echo "	<br/><div class='alert alert-danger'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
	  					<strong>O cadastro não foi efetuado!</strong> Favor tentar novamente.
						<alert>
					</div>";
	     	}
     	}
     	
     	$idmovimento=$_REQUEST['id_mov'];
     	if (isset($_REQUEST['igreja'])){
     		$paramPesquisa1="p1=".$_REQUEST['igreja'];
     	}else{
     		$paramPesquisa1="p1=";
     	}
     	if (isset($_REQUEST['dtmovinicio'])){
     		$paramPesquisa2="p2=".$_REQUEST['dtmovinicio'];
     	}else{
     		$paramPesquisa2="p2=";
     	}
     	if (isset($_REQUEST['dtmovfim'])){
     		$paramPesquisa3="p3=".$_REQUEST['dtmovfim'];
     	}else{
     		$paramPesquisa3="p3=";
     	}
     	if (isset($_REQUEST['tpmovimento'])){
     		$paramPesquisa4="p4=".$_REQUEST['tpmovimento'];
     	}else{
     		$paramPesquisa4="p4=";
     	}
     	$par="?".$paramPesquisa1."&".$paramPesquisa2."&".$paramPesquisa3."&".$paramPesquisa4;
   
     	$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
	  	$sql = "select mov.id_movimento, mov.dt_movimento, mov.dt_reg_movimento,
    			mov.vl_movimento, tpm.ds_tipo_movimento, igj.nm_igreja, mov.id_igreja, mov.id_tipo_movimento
	  			from movimento mov left join tipo_movimento tpm 
    			on mov.id_tipo_movimento=tpm.id_tipo_movimento
    			inner join igreja igj on mov.id_igreja=igj.id_igreja
    			where mov.id_movimento = '{$idmovimento}'";
     	
     	$stm = $pdo->query($sql);
     	
     	$dados = $stm->fetch(PDO::FETCH_ASSOC);
     		
     	$idmovimento=$dados['id_movimento'];
     	$dtmovimento=$dados['dt_movimento'];
     	$dtregmovimento=$dados['dt_reg_movimento'];
     	$nmIgreja=$dados['nm_igreja'];
     	$dstipomov=$dados['ds_tipo_movimento'];
     	$idigreja=$dados['id_igreja'];
     	$idtpmov=$dados['id_tipo_movimento'];
     	$vlrmov=$dados['vl_movimento'];
     	
     	//echo "<br><br>"; var_dump($nmIgreja);
     	
?>
     <br>
   
     <div class='container col-sm-offset-3'>

      <div class='starter-template'>
        <h2>Visualizar Movimento</h2>
           	<form  name="cadMovimento" onsubmit="verifData()" action="../Movimento/alterar.php" method="post" target="_self">
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
      					<div class='col-sm-4'>
      						<input type='text' class='form-control' id='nmigreja' name='nmigreja'  value='<?php echo $nmIgreja;?>' readonly='readonly'>
						</div>
      			</div>
    			<br>
    			<div class="lead">
    				<div class="col-sm-2">
    					<label for='tpMovimento' class='control-label'>Tipo de Movimento:<b>*</b></label>
    				</div>
 			   		<div class='col-sm-4'>
      					<input type='text' class='form-control' id='tpmov' name='tpmov'  value='<?php echo $dstipomov;?>' readonly='readonly'>
					</div>
				</div>
 				<br>
 				<div class="lead">
        			<div class="col-sm-2">
    					<label for="movimento" class="control-label">Valor:</label>
    				</div>
    				<div class="col-sm-2">
      					<input type="text" class="form-control" id="valor" name="valor" value='<?php echo $vlrmov;?>' readonly='readonly'>
      				</div>
    			</div>
 			<br/>
 			<br/>
 			<div class='lead'>
			   		<div class='col-sm-offset-5 col-sm-7'>
			   			<a href='../Movimento/resultado.php<?php echo $par;?>'>
			   				<button type='button' class='btn btn-primary  col-sm-2' name='cancel'>Voltar</button>
 			   			</a>
			   			<button type='submit' class='btn btn-primary col-sm-offset-1 col-sm-2' id='acca' name='acao' value='alterar'>Alterar</button>	   	
					</div>
				</div>
 			
 			
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
			$("input.data").mask("99/99/9999");
			$('#valor').maskMoney();
	    });

   </script>
   </body>
</html>
