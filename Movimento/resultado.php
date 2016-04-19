<?php
header('Content-Type: text/html; charset=ISO-8859-1');

?>
<html>
	<head>
		<!-- <meta charset="UTF-8" /> -->
    	<meta name="viewport" content="width=device-width, initial-scale=1" />
    
    	<!-- Bootstrap -->
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="../bootstrap/css/style.css" rel="stylesheet">
		<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Versão 3.3.6 -->
    <script src='../bootstrap/js/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Versão 1.4.1 -->		
        <title>Gestão Crista</title>
	</head>
	<body>
	<br/>
	<?php include_once 'pesquisa.php';?>
		
		<div class="container col-sm-offset-2">
			<div class="lead">
				<div class="col-sm-10">
					<br>
					<table class="table table-striped table-bordered" >
						
						<?php 
	  						if (isset($_REQUEST['tpmov'])){ 
	  							$tpmovimento=$_REQUEST['tpmov'];
	  						}else{	
	  							if (isset($_REQUEST['p1'])){
	  								$igreja=$_REQUEST['p1'];
	  							}else{
	  								$tpmovimento=null;
	  							}
	  						}
	  						
	  						if (isset($_REQUEST['igreja'])){
	  							$igreja=$_REQUEST['igreja'];
	  						}else{
	  							$igreja=$_REQUEST['p1'];
	  						}
	  						
	  						if (isset($_REQUEST['dtmovinicio'])){
	  							$dti=$_REQUEST['dtmovinicio'];
	  						}else {
	  							$dti=$_REQUEST['p2'];
	  						}
	  						
	  						if (isset($_REQUEST['dtmovfim'])){
	  							$dtf=$_REQUEST['dtmovfim'];
	  						}else{
	  							$dtf=$_REQUEST['p3'];
	  						}
	  							  						
	  						$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
	  						
	  						$sqli = "select igj.nm_igreja, igj.id_igreja
	  						from igreja igj where igj.id_igreja='{$igreja}'";
	  						
	  						$stmi = $pdo->query($sqli);
	  						
	  						$sql = "select mov.id_movimento, mov.dt_movimento, mov.dt_reg_movimento,
    								mov.vl_movimento, tpm.ds_tipo_movimento, igj.nm_igreja
	  								from movimento mov left join tipo_movimento tpm 
    								on mov.id_tipo_movimento=tpm.id_tipo_movimento
    								inner join igreja igj on mov.id_igreja=igj.id_igreja
    								where mov.dt_movimento>='{$dti}' and mov.dt_movimento>='{$dtf}'";
	  						
	  						if ($tpmovimento!=null){
	  							$sql=$sql." and tpm.id_tipo_movimento ='{$tpmovimento}')";
	  							if ($igreja!=null){
	  								$sql=$sql." and mov.id_igreja ='{$igreja}'";
	  							}
	  						}else{
	  							if ($igreja!=null){
	  								$sql=$sql." and mov.id_igreja ='{$igreja}'";
	  							}
	  						}
	  							
	  						$sql=$sql." order by dt_movimento";
	  								
	  						$stm = $pdo->query($sql);
	  						
	  						
	  						//var_dump($stm);
	  						if ($stm->rowCount(PDO::FETCH_ASSOC)>=1) {
	  							 $info = $stmi->fetch(PDO::FETCH_ASSOC);
	  							echo "	<tr>
	  										<td colspan='4'><strong>Igreja: ".$info['nm_igreja']."</strong></td>
	  									</tr>
	  									<tr>
										<td class='col-sm-3'><strong>Data do Movimento</strong></td>
										<td class='col-sm-3'><strong>Data de Registro</strong></td>
	  									<td class='col-sm-3'><strong>Tipo Movimento</strong></td>
		  									
										<td class='col-sm-1'/>
										</tr>";
	  						
	  							  						
		  						while($infomv = $stm->fetch(PDO::FETCH_ASSOC)){
		   							
		  							//Criptografando parametros enviados via get
		  							
		   							echo "<tr>
											<td>".$infomv['dt_movimento']."</td>
											<td>".$infomv['dt_reg_movimento']."</td>
	  										<td>".$infomv['ds_tipo_movimento']."</td>
											<td class='text-center'>
											<center><form action='../Movimento/visualizar.php' method='get' target='_self'>
											<input type='text' style='display:none' id='id_mov' name='id_mov' value='".$infomv['id_movimento']."'>
		  									<input type='text' style='display:none' id='igreja' name='igreja' value='".$igreja."'>
	  										<input type='text' style='display:none' id='dtmovinicio' name='dtmovinicio' value='".$dti."'>
	  										<input type='text' style='display:none' id='dtmovfim' name='dtmovfim' value='".$dtf."'>
											<input type='text' style='display:none' id='tpmovimento' name='tpmovimento' value='".$tpmovimento."'>
											<button type='submit' class='btn btn-default col-sm-offset-1 btn-xs btn-acao' name='acao' value='visualizar'>Visualizar</button>
											</form></center></td>
											</tr>";
								}

	  						}else{
	  							echo "	<div class='alert alert-info'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
	  									Registro não encontrado.
										<alert>
										</div>";
	  						}
							?>						
					</table>
				</div>
			</div>
		</div>
	
	
	</body>
</html>
