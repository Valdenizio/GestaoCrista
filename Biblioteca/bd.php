<?php
/**
 *Instanciar conexão com o banco de dados
 */

class Banco{
	private static $banco=array();

	public static function criar($tipo){
		if (!array_key_exist($tipo, ConfigBd::$banco)){
			die('Configuração de banco de dados não encontrada!');
		}

		if (array_key_exist($tipo, self::$banco)){
			return self::$banco[$tipo];
		}

		if (ConfigBd::$banco[$tipo]['driver']=='mysqli'){
			self::$banco[$tipo]= new mysqli(
					ConfigBd::$banco[$tipo]['servidor'],
					ConfigBd::$banco[$tipo]['usuario'],
					ConfigBd::$banco[$tipo]['senha'],
					ConfigBd::$banco[$tipo]['banco']
					);
		}

		if (ConfigBd::$banco[$tipo]['charset'] != ''){
			self::$banco[$tipo]->set_charset(
					ConfigBd::$banco[$tipo]['charset']
					);
		}

		return self::$banco[$tipo];

	}

}

?>

