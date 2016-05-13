<?php
define('MPDF_PATH', '../Biblioteca/PDF/');
include(MPDF_PATH.'mpdf.php');

header('Content-Type: text/html; charset=ISO-8859-1');


	$igreja=$_REQUEST['igreja'];
	
	$mes=$_REQUEST['mesRelat'];
	
	$ano=$_REQUEST['anoRelat'];
	
	switch ($mes){
	case 01:{
		$mesRef='Janeiro';
	}break;
	case 02:{
		$mesRef='Fevereiro';
	}break;
	case 03:{
		$mesRef='Março';
	}break;
	case 04:{
		$mesRef='Abril';
	}break;
	case 05:{
		$mesRef='Maio';
	}break;
	case 06:{
		$mesRef='Junho';
	}break;
	case 07:{
		$mesRef='Julho';
	}break;
	case 08:{
		$mesRef='Agosto';
	}break;
	case 09:{
		$mesRef='Setembro';
	}break;
	case 10:{
		$mesRef='Outubro';
	}break;
	case 11:{
		$mesRef='Novembro';
	}break;
	case 12:{
		$mesRef='Dezembro';
	}break;
	}	
	$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
		
	$sqlDiz = "select round(sum(mov.vl_movimento),2) as valor, igj.NM_IGREJA as nmigreja, igj.NM_DIRIGENTE as nmdir from movimento mov 
				inner join igreja igj on mov.id_igreja=igj.id_igreja where MONTH(dt_movimento)='{$mes}' 
				and YEAR(dt_movimento)='{$ano}' and id_tipo_movimento=1 and mov.id_igreja='{$igreja}'";
		
	$stmd = $pdo->query($sqlDiz);
	$dizimo = $stmd->fetch(PDO::FETCH_ASSOC);

	$somaDizimo=$dizimo['valor'];
	
	$nomeIgreja=$dizimo['nmigreja'];
	$nomeDirig=$dizimo['nmdir'];
	
	$sqlOf = "select round(sum(mov.vl_movimento),2) as valor from movimento mov where MONTH(dt_movimento)='{$mes}' 
				and YEAR(dt_movimento)='{$ano}' and id_tipo_movimento=2 and mov.id_igreja='{$igreja}'";
	
	$stmo = $pdo->query($sqlOf);
	$Oferta = $stmo->fetch(PDO::FETCH_ASSOC);
	
	$somaOferta=$Oferta['valor'];
		
	$sqlMs = "select round(sum(mov.vl_movimento),2) as valor from movimento mov where MONTH(dt_movimento)='{$mes}'
	and YEAR(dt_movimento)='{$ano}' and id_tipo_movimento=4 and mov.id_igreja='{$igreja}'";
	
	$stmm = $pdo->query($sqlMs);
	$Missoes = $stmm->fetch(PDO::FETCH_ASSOC);
	
		$somaMissoes=$Missoes['valor'];
	
	$sqlEp = "select round(sum(mov.vl_movimento),2) as valor from movimento mov where MONTH(dt_movimento)='{$mes}'
	and YEAR(dt_movimento)='{$ano}' and id_tipo_movimento=5 and mov.id_igreja='{$igreja}'";
	
	$stme = $pdo->query($sqlEp);
	$Especial = $stme->fetch(PDO::FETCH_ASSOC);
	
	$somaEspecial=$Especial['valor'];
		
	$sqlAm = "select round(sum(mov.vl_movimento),2) as valor from movimento mov where MONTH(dt_movimento)='{$mes}'
	and YEAR(dt_movimento)='{$ano}' and id_tipo_movimento=6 and mov.id_igreja='{$igreja}'";
	
	$stma = $pdo->query($sqlAm);
	$Ajuda = $stma->fetch(PDO::FETCH_ASSOC);
	
	$somaAjuda=$Ajuda['valor'];
	
	$sqlDg = "select round(sum(mov.vl_movimento),2) as valor from movimento mov where MONTH(dt_movimento)='{$mes}'
	and YEAR(dt_movimento)='{$ano}' and id_tipo_movimento=7 and mov.id_igreja='{$igreja}'";
	
	$stmDg = $pdo->query($sqlDg);
	$despGerais = $stmDg->fetch(PDO::FETCH_ASSOC);
	
	$somaDg=$despGerais['valor'];
	
	$somaEntradas=$somaDizimo+$somaOferta+$somaMissoes+$somaEspecial+$somaAjuda;
	
	$somaMinisterio=(($somaDizimo+$somaOferta+$somaMissoes+$somaEspecial)*15)/100;
	
	$somaSaidas=$somaDg+$somaMinisterio+$prebPastoral;
	
	$saldoAtual=(($SaldoAnt + $somaEntradas)-$somaSaidas);
	
	$somaMinisterio=(($somaDizimo+$somaOferta+$somaMissoes+$somaEspecial)*15)/100;
	
	if($mes>01){
		$mesAnt=$mes-1;
		$anoAnt=$ano;
	}else{
		$mesAnt=12;
		$anoAnt=$ano-1;
	}
		//var_dump($mes,$mesAnt);
	
	$sqlSa = "select round(sum(mov.vl_movimento),2) as valor from movimento mov 
				inner join tipo_movimento tpm on mov.id_tipo_movimento=tpm.id_tipo_movimento
				where MONTH(mov.dt_movimento)='{$mesAnt}'
				and YEAR(mov.dt_movimento)='{$anoAnt}' and tpm.tp_movimento='E' and mov.id_igreja='{$igreja}'";
	
	$stmSa = $pdo->query($sqlSa);
	$SaldoAnt = $stmSa->fetch(PDO::FETCH_ASSOC);
	//Falta descontar as saídas
	$somaSaldoAnt=$SaldoAnt['valor'];
	
	
	$nmiIgreja="<br><strong>Nome da Igreja: </strong>".$nomeIgreja;
	$nmDirigente="<br><strong>Nome do Dirigente: </strong>".$nomeDirig;
	$nmMes="<br><strong>Mês: </strong>".$mesRef;
	$txtDizimo="<br><Table border=1 align=center><tr><th colspan=6 align=center>Relatório Financeiro</th></tr>
				<tr><th colspan=3 align=center>Entradas do Mês</th><th colspan=2 align=center>Saídas do Mês</th><th align=center>Resumo de Caixa</th></tr>
				<tr><th align=center>Dizimo</th><td colspan=2 align=center>".number_format($somaDizimo,2)."</td>
				<th rowspan=2 align=center>Ministério</th><td rowspan=2 align=center>".number_format($somaMinisterio,2)."</td>
				<th align=center>Saldo Anterior</th></tr>
				<tr><th align=center>Ofertas</th><td colspan=2 align=center>".number_format($somaOferta,2)."</td>
				<td rowspan=2 align=center>".number_format($somaSaldoAnt,2)."</td></tr>
				<tr><th align=center>Missões</th><td colspan=2 align=center>".number_format($somaMissoes,2)."</td>
				<th rowspan=2 align=center>Despesas Gerais</th><td rowspan=2 align=center>".number_format($somaDg,2)."</td></tr>
				<tr><th align=center>Entradas Especiais</th><td colspan=2 align=center>".number_format($somaEspecial,2)."</td>
				<th align=center>Saldo Atual</th></tr>
				<tr><th align=center>Ajuda Ministerial</th><td colspan=2 align=center>".number_format($somaAjuda,2)."</td>
				<th align=center>Prebenda Pastoral</th><td align=center>".number_format($prebPastoral,2)."</td>
				<td rowspan=2 align=center>".number_format($saldoAtual,2)."</td></tr>
				<tr><th align=center>Total de Entradas</th><td colspan=2 align=center>".number_format($somaEntradas,2)."</td>
				<th align=center>Total de Saídas</th><td align=center>".number_format($somaSaidas,2)."</td></tr>
				</Table>";
	
	$mpdf=new mPDF();
	$mpdf->charset_in='iso-8859-1';
	$mpdf->WriteHTML("<img src='../Biblioteca/Imagens/timbre.png' />");
	$mpdf->WriteHTML('<h2 align=center>INFORMAÇÕES GERAIS</h2>');
	$mpdf->WriteHTML($nmiIgreja);
	$mpdf->WriteHTML($nmDirigente);
	$mpdf->WriteHTML($nmMes);
	$mpdf->WriteHTML($txtDizimo);
	$mpdf->SetFooter("<p align='center' color='#FE2E2E'><b>Revesti-vos de toda armadura de Deus, para poderes ficar firmes contra as ciladas do diabo</b></p><p align='center'>SEDE PROPRIA: QD 540 LOTE 03 PEDREGAL-NOVO GAMA</p><p align='center'>CNPJ: 15.586.863/0001-60</p>");
	$mpdf->Output();
	exit();
	
?>


