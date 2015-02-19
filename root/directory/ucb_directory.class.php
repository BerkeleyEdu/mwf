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
		$comma = false;
		if (strpos($name,',') !== false)  {
			$comma = true;
		}
		$name = str_replace('(', '\(', $name);
		$name = str_replace(')', '\)', $name);
		$string = str_replace(',', '', $string);
		$words = explode(' ', $string);
		//$departmental = "(!(berkeleyEduAffiliations=AFFILIATE-TYPE-DEPARTMENTAL))";	
		$departmental = "";
		//$confidential = "(!(berkeleyEduConfidentialFlag=true))";
		$test = "(!(berkeleyEduTestIDFlag=true))";							
		$expiredPeopleFilter = "(!(berkeleyEduExpDate=*))";
		
		if ($comma) {
			if (count($words) == 3) //combine first and middle
			{
				$words[1] = $words[1] .' ' . $words[2];
			}
		} else {
			if (count($words) == 3) //combine first and middle, move last
			{
				$words[0] = $words[0] .' ' . $words[1];
				$words[1] = $words[2];
			}
		}
		

		if (strpos($name,'@'))
		{
			// Search for email
			$email = $name;
			$primaryfilter = "(&(mail=$email)$expiredPeopleFilter$test)";
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
			$primaryfilter .= "(&(telephoneNumber=$phone)$expiredPeopleFilter$test)";
		}
		else
		{
			// Search for name
			//$primaryfilter = "(&(cn=$name)$expiredPeopleFilter$test)";
			//$primaryfilter = "(&(|(givenName=$name)(sn=$name))$expiredPeopleFilter$test)";
			// Search for name, simple
			if (count($words) > 1) {
				if ($comma)  {
					// swap names
					$primaryfilter = "(&(givenName=$words[1] *)(sn=$words[0])$expiredPeopleFilter$test)";	
				} else {
					$primaryfilter = "(&(givenName=$words[0] *)(sn=$words[1])$expiredPeopleFilter$test)";
				}
			} else {
				$primaryfilter = "(&(|(givenName=$name)(sn=$name))$expiredPeopleFilter$test)";
			}
			
		}
		$array = parent::raw_search('ou=people,dc=berkeley,dc=edu', $primaryfilter);
		
		//print "<pre>";
		//print_r($primaryfilter);
		//print "</pre>";
		
		//print "first search results: <pre>";
		//print_r($array);
		//print "</pre>";
		
		
		if(is_array($array) && count($array) > 1)
		{
			$this->primary_search = true;
			return array_slice($array, 1, count($array)-1);
		}
		
		$filters = '(|';
		$lastfilters = "(&$expiredPeopleFilter$test";	
		$lastfilters .= '(|';
		for($i = 0; $i < count($words); $i++)
		{
			$filters .= '(&';
			$filters .= "$expiredPeopleFilter$test";	
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