<?php
/**
 *Conf BD
 */

class ConfigBd{
	Public static $banco = array(
			'padrao' => array(
					'servidor'=>'localhost',
					'usuario'=>'root',
					'driver'=> 'mysqli',
					'senha'=> 'root',
					'charset'=> 'utf-8'
			),
			'outrobanco'=>array(
					'servidor'=>'localhost',
					'usuario'=>'root',
					'driver'=> 'postgre',
					'senha'=> '',
					'porta'=> '5432',
					'banco'=> 'dbmvc',
					'charset'=> 'utf-8'
			)
	);
}


?>