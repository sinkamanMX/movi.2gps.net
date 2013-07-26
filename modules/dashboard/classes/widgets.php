<?php
/**  
 * Clase que contiene las funciones de los widgets
 * @package dahsboard
 * @author	Enrique R. Pena Gonzalez
 * @since	2013-07-22
 */
 
 /**
 * Clase widget
 */
 class widgets{
	/**
	*  Id del Usuario
	*  @var int
	*/
	public $idUsuario;
	
	/**
	*  Id del Cliente
	*  @var int
	*/
	public $idCliente;

	/**
	*  Array de  widgets
	*  @var int
	*/
	public $arrayWidgets=Array();
	
	/**
	*  Array de DashBoards
	*  @var int
	*/
	public $arrayDashBoards=Array();	

	/**
	*  Array de categorias de widgets
	*  @var int
	*/
	public $arrayCategorias=Array();
	
	/**
	*  Array de campos de widgets
	*  @var int
	*/
	public $arrayCampos=Array();
	
	/**
	*  Array de tiempo de widgets
	*  @var int
	*/
	public $arrayTiempos=Array();

	/**
	*  Array de Graficas de widgets
	*  @var int
	*/
	public $arrayGraficas=Array();
	
	/**
	*  Array de la configuracion del widget
	*  @var int
	*/
	public $arrayConfiguracion=Array();			
  
	/**
	* Inicializa la clase.
	* @access public
	* @return void
	*/
	public function __construct() {
		$this->idCliente = 0;
		$this->idUsuario = 0;
	}
	
	/**
	* Set Id del usuario
	* @access public
	* @return void
	*/
	public function setIdUsuario($idUsuario=0){
		$this->idUsuario = $idUsuario;
	}
	
	/**
	* Set Id del Cliente
	* @access public
	* @return void
	*/	
	public function setIdCliente($idCliente=0){
		$this->idCliente = $idCliente;
	}	
	
	/**
	* Obtiene un listado con los dashboards creados
	* @access public
	* @return void
	*/		
	public function getDashBoards(){
		global $db,$dbf;
		$sql   = "SELECT * FROM WGT_DASHBOARD WHERE ID_USUARIO = ".$this->idUsuario;
		$query = $db->sqlQuery($sql);
		while($row = $db->sqlFetchAssoc($query)){
			$row['widgets'] = $this->getWidgetsDashboards($row['ID_DASHBOARD']);
			$this->arrayDashBoards[] = $row;
		}		
	}
	
	/**
	* Obtiene un listado con los widgets del Cliente
	* @access public
	* @return void
	*/		
	public function getWidgetsDashboards($idDashboards=0){
		global $db,$dbf;
		$arrayWidgets = Array();
		$sql   = "SELECT * FROM WGT_WIDGETS_USUARIOS WHERE ID_DASHBOARD = ".$idDashboards;
		$query = $db->sqlQuery($sql);		
		while($row = $db->sqlFetchAssoc($query)){
			$arrayWidgets[] = $row;
		}
		return $arrayWidgets;
	}	
	
	/**
	* Obtiene un listado con las categorias disponibles
	* @access public
	* @return void
	*/		
	public function getWidgetsCategorias(){
		global $db,$dbf;
		$respuesta='';
		$sql   = "SELECT WGT_CATEGORIAS.ID_CATEGORIA AS ID, WGT_CATEGORIAS.DESCRIPCION AS DES
				FROM WGT_WIDGETS_CLIENTES
				INNER JOIN WGT_WIDGETS 	   ON  WGT_WIDGETS_CLIENTES.ID_WIDGET = WGT_WIDGETS.ID_WIDGET
				INNER JOIN WGT_CATEGORIAS  ON  WGT_WIDGETS.ID_CATEGORIA       = WGT_CATEGORIAS.ID_CATEGORIA
				WHERE WGT_WIDGETS_CLIENTES.ID_CLIENTE =".$this->idCliente;
		$query = $db->sqlQuery($sql);
		while($row = $db->sqlFetchAssoc($query)){
			$respuesta.='<option value="'.$row['ID'].'">'.$row['DES'].'</option>';
		}
		return $respuesta;
	}
	
	/**
	* Obtiene un listado con los widgets disponibles para el Cliente
	* @access public
	* @return void
	*/		
	public function getWidgetsAvailable(){
		global $db,$dbf;
		$sql   = "SELECT * 
				FROM WGT_WIDGETS
				INNER JOIN WGT_WIDGETS_CLIENTES 
					ON WGT_WIDGETS.ID_WIDGET = WGT_WIDGETS_CLIENTES.ID_WIDGET
				WHERE WGT_WIDGETS_CLIENTES.ID_CLIENTE = ".$this->idCliente;
		$query = $db->sqlQuery($sql);
		while($row = $db->sqlFetchAssoc($query)){
			$this->arrayWidgets[] = $row;
		}
	}		
}
