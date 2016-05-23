<?php
define('MPDF_PATH', '../Biblioteca/PDF/');
include(MPDF_PATH.'mpdf.php');

header('Content-Type: text/html; charset=ISO-8859-1');

	//Parametros recebidos da tela de pesquisa
	$igreja=$_REQUEST['igreja'];
	$mes=$_REQUEST['mesRelat'];
	$ano=$_REQUEST['anoRelat'];
	
	//Idenitificação do mês conforme parametro de emissão do relatório
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
	
	//Inicializando variáveis que irão receber os valores do banco
	$somaDizimo=0;
	$somaOferta=0;
	$somaAjudaTransp=0;
	$somaMissoes=0;
	$somaEspecial=0;
	$somaAjudaMin=0;
	$somaDominical=0;
	$somaMFeminino=0;
	$somaFSenhores=0;
	$somaDInfantil=0;
	$somaAdolecente=0;
	$somaCsPastoral=0;
	$somaTelefone=0;
	$somaOutros=0;
	$somaEnergia=0;
	$somaPrevSocial=0;
	$saldoAntEnt=0;
	$saldoAntSai=0;
	
	$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
	
	//Recupera os valores gravados no banco referente ao mês atual	
	$sqlDiz = "select mov.*, igj.NM_IGREJA as nmigreja, igj.NM_DIRIGENTE as nmdir, 
				reg.ds_regiao as nmReg, igj.nm_cidade as nmcid from movimento mov 
				inner join igreja igj on mov.id_igreja=igj.id_igreja 
				inner join regiao reg on igj.id_regiao=reg.id_regiao
				where MONTH(dt_movimento)='{$mes}' 
				and YEAR(dt_movimento)='{$ano}' and mov.id_igreja='{$igreja}'";
		
	$stmd = $pdo->query($sqlDiz);
	while($movimentos = $stmd->fetch(PDO::FETCH_ASSOC)){
		switch ($movimentos['id_tipo_movimento']){
			case('1'):{//Dizimo
				$somaDizimo=$somaDizimo+$movimentos['vl_movimento'];
			}break;
			
			case('2'):{//Oferta
				$somaOferta=$somaOferta+$movimentos['vl_movimento'];
			}break;
			
			case('3'):{//Ajuda Transporte
				$somaAjudaTransp=$somaAjudaTransp+$movimentos['vl_movimento'];
			}break;
			
			case('4'):{//Missões/Evangelização
				$somaMissoes=$somaMissoes+$movimentos['vl_movimento'];
			}break;
			
			case('5'):{//Entradas Especiais
				$somaEspecial=$somaEspecial+$movimentos['vl_movimento'];
			}break;
			
			case('6'):{//Ajuda Ministerial
				$somaAjudaMin=$somaAjudaMin+$movimentos['vl_movimento'];
			}break;
			
			case('7'):{//Escola Dominical
				$somaDominical=$somaDominical+$movimentos['vl_movimento'];
			}break;
			
			case('8'):{//M. Feminino
				$somaMFeminino=$somaMFeminino+$movimentos['vl_movimento'];
			}break;
			
			case('9'):{//F. Senhores
				$somaFSenhores=$somaFSenhores+$movimentos['vl_movimento'];
			}break;
			
			case('10'):{//D. Infantil
				$somaDInfantil=$somaDInfantil+$movimentos['vl_movimento'];
			}break;
			
			case('11'):{//Adolecente
				$somaAdolecente=$somaAdolecente+$movimentos['vl_movimento'];
			}break;
			
			case('12'):{//Casa Pastoral
				$somaCsPastoral=$somaCsPastoral+$movimentos['vl_movimento'];
			}break;
			
			case('13'):{//Telefone
				$somaTelefone=$somaTelefone+$movimentos['vl_movimento'];
			}break;
			
			case('14'):{//CIA Água
				$somaOutros=somaOutros+$movimentos['vl_movimento'];
			}break;
			
			case('15'):{//Energia Elétrica
				$somaEnergia=$somaEnergia+$movimentos['vl_movimento'];
			}break;
			
			case('16'):{//Prev. Social
				$somaPrevSocial=$somaPrevSocial+$movimentos['vl_movimento'];
			}break;
			
			case('17'):{//Aluguel
				$somaOutros=$somaOutros+$movimentos['vl_movimento'];
			}break;
			
			case('18'):{//Outros
				$somaOutros=$somaOutros+$movimentos['vl_movimento'];
			}break;
			
		}
		//Identificação da Igreja
		if ($nomeIgreja!=$movimentos['nmigreja']){
			$nomeIgreja=$movimentos['nmigreja'];
			$nomeDirig=$movimentos['nmdir'];
			$nomeRegiao=$movimentos['nmReg'];
			$nomeCidade=$movimentos['nmcid'];
		}
	}

	//Tratando parametros para definir mês anterior
	if($mes>01){
		$mesAnt=$mes-1;
		$anoAnt=$ano;
	}else{
		$mesAnt=12;
		$anoAnt=$ano-1;
	}
	
	//Recupera os valores gravados no banco referente ao mês anterior	
	$sqlSa = "select mov.*,tpm.* from movimento mov 
				inner join tipo_movimento tpm on mov.id_tipo_movimento=tpm.id_tipo_movimento
				where MONTH(mov.dt_movimento)='{$mesAnt}'
				and YEAR(mov.dt_movimento)='{$anoAnt}' and mov.id_igreja='{$igreja}'";
	
	$stmSa = $pdo->query($sqlSa);
	while ($SaldoAnt = $stmSa->fetch(PDO::FETCH_ASSOC)){
		switch ($SaldoAnt['tp_movimento']){
			case('E'):{
				$saldoAntEnt=$saldoAntEnt+$SaldoAnt['vl_movimento'];
			}break;
				
			case('S'):{
				$saldoAntSai=$saldoAntSai+$SaldoAnt['vl_movimento'];
			}break;
		}
	}
	
	//Totalizadores
	$somaEntradas=$somaDizimo+$somaOferta+$somaMissoes+$somaEspecial+$somaAjuda;
	$somaMinisterio=($somaDizimo+$somaOferta+$somaMissoes+$somaEspecial)*0.15;
	$somaSaidas=$somaDg+$somaMinisterio+$prebPastoral;
	$somaMinisterio=($somaDizimo+$somaOferta+$somaMissoes+$somaEspecial)*0.15;
	$somaSaldoAnt=$saldoAntEnt-$saldoAntSai;
	$saldoAtual=(($somaSaldoAnt + $somaEntradas)-$somaSaidas);
	$minEscDomin=($somaDominical*0.15);
	$minMFem=($somaMFeminino*0.15);
	$minFSen=($somaFSenhores*0.15);
	$minDInf=($somaDInfantil*0.15);
	$minAdol=($somaAdolecente*0.15);
	$minMis=($somaMissoes*0.15);
	//----------------------------------------------------------------------------------------------//
	//  Falta identificar como serão registradas tais despesas ou se o entendimento foi distorcido  //
	//----------------------------------------------------------------------------------------------//
	$saidaEscDomin=($minEscDomin+$despDominical);
	$saidaMFem=($minMFem+$despMFeminino);
	$saidaFSen=($minFSen+$despFSenhores);
	$saidaDInf=($minDInf+$despDInfantil);
	$saidaAdol=($minAdol+$despAdolecente);
	$saidaMis=($minMis+$despMissoes);
	
	//Tabela com o resultado do relatório
	$tblIdentIgreja="	<table border=1  align=center><tr><th rowspan=3><img src='../Biblioteca/Imagens/timbre.png' /></th><th colspan=6>Identificação da Igreja</th></tr>
						<tr><th>Nome da Igreja: </th><td>".$nomeIgreja."</td><th>Região:</th><td>".$nomeRegiao."</td><th>Mês Referência: </th><td>".$mesRef."</td></tr>
						<tr><th>Pastor: </th><td>".$nomeDirig."</td><th>Cidade:</th><td>".$nomeCidade."</td><th>Ano Referência: </th><td>".$ano."</td></tr></table>";
	$tblMovFin="<br><Table border=1 align=center><tr><th colspan=7 align=center>Relatório Financeiro</th></tr>
				<tr><th colspan=3 align=center>Entradas do Mês</th><th colspan=2 align=center>Saídas do Mês</th><th colspan=2 align=center>Resumo de Caixa</th></tr>
				<tr><th align=center>Dizimo</th><td colspan=2 align=center>".number_format($somaDizimo,2)."</td><th rowspan=2 align=center>Ministério</th>
				<td rowspan=2 align=center>".number_format($somaMinisterio,2)."</td><th colspan=2 align=center>Saldo Anterior</th></tr>
				<tr><th align=center>Ofertas</th><td colspan=2 align=center>".number_format($somaOferta,2)."</td>
				<td rowspan=2 colspan=2 align=center>".number_format($somaSaldoAnt,2)."</td></tr>
				<tr><th align=center>Missões</th><td colspan=2 align=center>".number_format($somaMissoes,2)."</td>
				<th rowspan=2 align=center>Despesas Gerais</th><td rowspan=2 align=center>".number_format($somaDg,2)."</td></tr>
				<tr><th align=center>Entradas Especiais</th><td colspan=2 align=center>".number_format($somaEspecial,2)."</td>
				<th colspan=2 align=center>Saldo Atual</th></tr>
				<tr><th align=center>Ajuda Ministerial</th><td colspan=2 align=center>".number_format($somaAjuda,2)."</td>
				<th align=center>Prebenda Pastoral</th><td align=center>".number_format($prebPastoral,2)."</td>
				<td rowspan=2 colspan=2 align=center>".number_format($saldoAtual,2)."</td></tr>
				<tr><th align=center>Total de Entradas</th><td colspan=2 align=center>".number_format($somaEntradas,2)."</td>
				<th align=center>Total de Saídas</th><td align=center>".number_format($somaSaidas,2)."</td></tr>
				<tr><th colspan=3>Entradas</th><th>Repasse ao Ministério</th><th>Saídas</th><th>Total de Saídas</th><th>Saldo Atual</th></tr>
				<tr><th>Escola Dominical</th><td colspan=2 align=center>".number_format($somaDominical,2)."</td><td align=center>".number_format($minEscDomin,2)."</td>
				<td align=center>".number_format($despDominical,2)."</td><td align=center>".number_format($saidaDominical,2)."</td>
				<td align=center>".number_format($atualDominical,2)."</td></tr>
				<tr><th>M. Feminino</th><td colspan=2 align=center>".number_format($somaMFeminino,2)."</td><td align=center>".number_format($minMFem,2)."</td>
				<td align=center>".number_format($despMFeminino,2)."</td><td align=center>".number_format($saidaMFeminino,2)."</td>
				<td align=center>".number_format($atualMFeminino,2)."</td></tr>
				<tr><th>F. Senhores</th><td colspan=2 align=center>".number_format($somaFSenhores,2)."</td><td align=center>".number_format($minFSen,2)."</td>
				<td align=center>".number_format($despFSenhores,2)."</td><td align=center>".number_format($saidaFSenhores,2)."</td>
				<td align=center>".number_format($atualFSenhores,2)."</td></tr>
				<tr><th>D. Infantil</th><td colspan=2 align=center>".number_format($somaDInfantil,2)."</td><td align=center>".number_format($minDInf,2)."</td>
				<td align=center>".number_format($despDInfantil,2)."</td><td align=center>".number_format($saidaDInfantil,2)."</td>
				<td align=center>".number_format($atualDInfantil,2)."</td></tr>
				<tr><th>Adolecentes</th><td colspan=2 align=center>".number_format($somaAdolecente,2)."</td><td align=center>".number_format($minAdol,2)."</td>
				<td align=center>".number_format($despAdolecente,2)."</td><td align=center>".number_format($saidaAdolecente,2)."</td>
				<td align=center>".number_format($atualAdolecente,2)."</td></tr>
				<tr><th>Missões/Evang.</th><td colspan=2 align=center>".number_format($somaMissoes,2)."</td><td align=center>".number_format($minMis,2)."</td>
				<td align=center>".number_format($despMissoes,2)."</td><td align=center>".number_format($saidaMissoes,2)."</td>
				<td align=center>".number_format($atualMissoes,2)."</td></tr>
				</Table>";
	
	//Monta a imagem do relatório
	$mpdf=new mPDF();
	$mpdf->charset_in='iso-8859-1';
	$mpdf->WriteHTML($tblIdentIgreja);
	$mpdf->WriteHTML($nmiIgreja);
	$mpdf->WriteHTML($nmDirigente);
	$mpdf->WriteHTML($nmMes);
	$mpdf->WriteHTML($tblMovFin);
	//$mpdf->WriteHTML("teste: ".$sqlSa);
	$mpdf->SetFooter("<p align='center' color='#FE2E2E'><b>Revesti-vos de toda armadura de Deus, para poderes ficar firmes contra as ciladas do diabo</b></p><p align='center'>SEDE PROPRIA: QD 540 LOTE 03 PEDREGAL-NOVO GAMA</p><p align='center'>CNPJ: 15.586.863/0001-60</p>");
	$mpdf->Output();
	exit();
	
?>