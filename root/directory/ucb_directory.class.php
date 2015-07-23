<?php
require_once(dirname(dirname(__FILE__)).'/assets/lib/decorator.class.php');
require_once('ldap_directory.class.php');

class UCLA_Directory extends LDAP_Directory
{
	public function __construct()
	{
	 	parent::__construct('ldap.berkeley.edu');
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
		if (strpos($name,',') != false)  {
			$comma = true;
		}
		$name = str_replace('(', '\(', $name);
		$name = str_replace(')', '\)', $name);
		$string = str_replace(', ', ' ', $string); // comma followed by space
		$string = str_replace(',', ' ', $string);  // comma no space
		$words = explode(' ', $string);
		//$departmental = "(!(berkeleyEduAffiliations=AFFILIATE-TYPE-DEPARTMENTAL))";	
		$departmental = "";
		$confidential = "(!(berkeleyEduConfidentialFlag=true))";
		$test = "(!(berkeleyEduTestIDFlag=true))";							
		$expiredPeopleFilter = "(!(berkeleyEduExpDate=*))";
		$affliliations = "(|
							(berkeleyeduaffiliations=EMPLOYEE-TYPE-*)
							(berkeleyeduaffiliations=STUDENT-TYPE-*)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-CONSULTANT)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-LBLOP STAFF)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-VISITING SCHOLAR)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-VOLUNTEER)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-HHMI RESEARCHER)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-VISITING STU RESEARCHER)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-LBL/DOE POSTDOC)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-TEMP AGENCY)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-COMMITTEE MEMBER)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-STAFF OF UC/OP/AFFILIATED ORGS)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-INDEPENDENT CONTRACTOR)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-TEMPORARY AGENCY STAFF)
							(berkeleyeduaffiliations=AFFILIATE-TYPE-CONCURR ENROLL))";
		
		if ($comma) {
			if (count($words) == 3) //combine first and middle
			{
				$words[1] = $words[1] .' ' . $words[2];
			}
			if (count($words) == 4) //combine 3-word last name, move first  e.g, Sarah de la Vega
			{
				$words[0] = $words[0] .' ' . $words[1] .' ' . $words[2];
				$words[1] = $words[3];
			}
		} else {
			if (count($words) == 3) { //combine first and middle, middle and last, move last
				$words[0] = $words[0] .' ' . $words[1];
				$words[3] = $words[1] .' ' . $words[2];
				$words[1] = $words[2];
			}
			if (count($words) == 2) { //combine 
					$words[2] = $words[0] .' ' . $words[1];
			}
			if (count($words) == 4) { //combine 3-word last name  e.g, Sarah de la Vega
					$words[1] = $words[1] .' ' . $words[2] .' ' . $words[3];
			}
		}	

		if (strpos($name,'@'))
		{
			// Search for email
			$email = $name;
			$primaryfilter = "(&(mail=$email)$expiredPeopleFilter$test$confidential$affliliations)";
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
			$primaryfilter .= "(&(telephoneNumber=$phone)$expiredPeopleFilter$test$confidential$affliliations)";
		}
		else
		{
			// Search for name
			//$primaryfilter = "(&(cn=$name)$expiredPeopleFilter$test$confidential$affliliations)";
			//$primaryfilter = "(&(|(givenName=$name)(sn=$name))$expiredPeopleFilter$test$confidential$affliliations)";
			// Search for name, simple
			if (count($words) > 1) {
				if ($comma)  {
					// swap names
					$primaryfilter = "(&(givenName=$words[1] *)(sn=$words[0])$expiredPeopleFilter$test$confidential$affliliations)";	
				} else {
					$primaryfilter = "(&(givenName=$words[0] *)(sn=$words[1])$expiredPeopleFilter$test$confidential$affliliations)";
				}
			} else {
				$primaryfilter = "(&(|(givenName=$name)(sn=$name))$expiredPeopleFilter$test$confidential$affliliations)";
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
		$lastfilters = "(&$expiredPeopleFilter$test$confidential$affliliations";	
		$lastfilters .= '(|';
		for($i = 0; $i < count($words); $i++)
		{
			$filters .= '(&';
			$filters .= "$expiredPeopleFilter$test$confidential$affliliations";	
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

		// Get fresh array to try merged names  (finds 'de la Vega')
		$words = explode(' ', $string); 
		$mergedfilters = "(&$expiredPeopleFilter$test$confidential$affliliations";	
		$mergedfilters .= '(|';
		$givenName = '';
		$sn = '';
		for($i = 0; $i < count($words); $i++)
		{
			$givenName .= $words[$i]. ' ';
			$sn .= $words[$i]. ' ';
		}
		$mergedfilters .= '(givenName='.$givenName.')(sn='.$sn.')))';
		$array = parent::raw_search('ou=people,dc=berkeley,dc=edu', $mergedfilters);
		if(is_array($array) && count($array) > 1)
		{
			$this->primary_search = true;
			return array_slice($array, 1, count($array)-1);
		}
		
		// Last filter  (finds 'Andrea Green Rush')
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