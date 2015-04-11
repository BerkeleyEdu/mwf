<?php

class LDAP_Directory
{
	private $_server = false;
	private $_conn = false;
	private $_conn_status = false;

	public function __construct($server)
	{
		$this->_open($server);
	}
	
	public function __destruct()
	{
		if($this->_conn)
		{
			$this->_close($this->_conn);
		}
	}
	
	public function is_connected()
	{
		return $this->_conn_status;
	}
	
	public function raw_search($basedn, $filters, $attrs = array(), $attrsonly = 0)
	{
		$res = @ldap_search($this->_conn, $basedn, $filters, $attrs, $attrsonly);
		
		if(!$res)
		{
			return false;
		}
		
		return ldap_get_entries($this->_conn, $res);
	}
	
	private function _open($server)
	{
		$this->_server = $server;
		$this->_conn = @ldap_connect($server);
		$this->_conn_status = ldap_bind($this->_conn)
			or header('Location: /directory/unavailable.php');	
		return $this->_conn_status;
	}
	
	private function _close($conn)
	{
		@ldap_unbind($conn);
		return true;
	}
}

?>