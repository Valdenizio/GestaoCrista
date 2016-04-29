<?php
header('Content-Type: text/html; charset=ISO-8859-1');
//require_once 'movimento.php';
require_once 'sessao.php';
include_once 'crudMovimento.php';
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
    <div class="container col-sm-offset-3">
      <div class="starter-template">
        <h2>Pesquisar Movimento</h2>
        <!-- <p> -->
        	<form action="../Movimento/resultado.php" method="get" target="_self">
        		<div class="lead">
	   	 			<div class="col-sm-2">
	   	 				<label for="membro" class="control-label">Igreja:</label>
	   	 			</div>
    				<div class="col-sm-4">
				   		<?php 	
					   		echo $igjVinculada;
					   	?>
				   	</div>
				</div>
				<br/>
				<br/>
        		<div class="lead">
    				<div class="col-sm-2">
    					<label for='tpMovimento' class='control-label'>Tipo de Movimento:<b>*</b></label>
    				</div>
 			   		<div class='col-sm-4'>
			   			<select class='form-control' id='tpmovimento' name='tpmovimento'>
			   				<option selected ></option>
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
    					<label for="membro" class="control-label">Período:</label>
    				</div>
    			</div>
    			<br/>
    			<div class="lead">
        			<div class="col-sm-2">
    					<label for="movimento" class="control-label">Inicio:</label>
    				</div>
    				<div class="col-sm-2">
      					<input type="text" class="form-control data" id="dtmovinicio" name="dtmovinicio" required>
      					
    				</div>
    				<div class="col-sm-2">
    					<label for="movimento" class="control-label">Fim:</label>
    				</div>
    				<div class="col-sm-2">
      					<input type="text" class="form-control data" id="dtmovfim" name="dtmovfim" required>
      					
    				</div>
 				</div>
 				<br/>
				<br/>
				<div class="lead">
			   		<div class="col-sm-offset-5 col-sm-3">
			   			<a href="../Movimento/cadastro.php">
			   				<button type="button" class="btn btn-lg btn-default" formaction="../Movimento/cadastro.php" name="resultado" value="null">Cadastrar</button>
			   			</a>
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
    <script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Versão 1.4.1 -->
    <script type="text/javascript">
    $(document).ready(function(){
			$("input.data").mask("99/99/9999");
	       		
		});
    </script>   
    </body>
</html>

