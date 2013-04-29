<?php
require_once(dirname(dirname(__FILE__)).'/assets/lib/decorator.class.php');
require_once('ldap_directory.class.php');

class UCLA_Directory extends LDAP_Directory
{
	public function __construct()
	{
	//	parent::__construct('ldap.berkeley.edu');
		parent::__construct('nds.berkeley.edu');
	}
	
	public function __get($key)
	{
		return false;
	}
	
	public function search($string)
	{	
		// Clean up name.		
		$name = htmlspecialchars($string);
		$name = str_replace('(', '\(', $name);
		$name = str_replace(')', '\)', $name);
		$string = str_replace(',', '', $string);
		$words = explode(' ', $string);
		$departmental = "(!(berkeleyEduAffiliations=AFFILIATE-TYPE-DEPARTMENTAL))";	
		$test = "(!(berkeleyEduTestIDFlag=true))";							
		$expiredPeopleFilter = "(!(berkeleyEduExpDate=*))";

		if (strpos($name,'@'))
		{
			// Search for email
			$email = $name;
			$primaryfilter = "(&(mail=$email)$departmental$expiredPeopleFilter$test)";
		} 
		elseif (is_numeric(str_replace('-', '', $name)))
		{
			// Search for phone
			if (strlen($name) == 6)
			{
				$phone = '+1 510 64' . $name;
			}
			else
			{
				$phone = '+1 510 ' . $name;
			}
			$primaryfilter .= "(&(telephoneNumber=$phone)$departmental$expiredPeopleFilter$test)";
		}
		else
		{
			// Search for name
			//$primaryfilter = "(&(cn=$name)$departmental$expiredPeopleFilter$test)";
$primaryfilter = "(&(|(givenName=$name)(sn=$name))$departmental$expiredPeopleFilter$test)";
			
		}
		$array = parent::raw_search('ou=people,dc=berkeley,dc=edu', $primaryfilter);
		
		
		if(is_array($array) && count($array) > 1)
		{
			$this->primary_search = true;
			return array_slice($array, 1, count($array)-1);
		}
		
		$filters = '(|';
		$lastfilters = "(&$departmental$expiredPeopleFilter$test";	
		$lastfilters .= '(|';
		for($i = 0; $i < count($words); $i++)
		{
			$filters .= '(&';
			$filters .= "$departmental$expiredPeopleFilter$test";	
			$filters .= '(sn=' . $words[$i] . ')';
			$filters .= '(|';
			for($j = 0; $j < count($words); $j++)
			{
				if($j != $i)
				{
			   	$filters .= '(givenName=' . $words[$j] . ')';
				}
			}
			$filters .= ')';
			$filters .= ')';
		$lastfilters .= '(givenName='.$words[$i].')(sn='.$words[$i].')';
		}
		$filters .= ')';
		$lastfilters .= '))';

		$array = parent::raw_search('ou=people,dc=berkeley,dc=edu', $filters);
		if(is_array($array) && count($array) > 1)
		{
			$this->primary_search = true;
			return array_slice($array, 1, count($array)-1);
		}

		// TO DO:  $lastfilters has incorrect syntax, perhaps order is reversed now?
		$array = parent::raw_search('ou=people,dc=berkeley,dc=edu', $lastfilters);
		if(is_array($array) && count($array) > 1)
		{
			$this->primary_search = false;
			return array_slice($array, 1, count($array)-1);
		}
		
		$this->primary_search = false;
		return array();
	}
	
	public function user($string)
	{
		$filters = '(uid='.$string.')';
		
		$array = parent::raw_search('ou=people,dc=berkeley,dc=edu', $filters);
		if(is_array($array))
		{
			$array = array_slice($array, 1, count($array)-1);
			if(count($array) == 0)
				return array();
			return $array[0];
		}
		else
		{
			return array();
		}
	}
}

?>