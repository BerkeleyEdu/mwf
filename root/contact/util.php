<?php

/*
** Function: validateEmail
** Input: STRING data, REFERENCE description
** Output: BOOLEAN
** Description: Returns TRUE if data looks like an email address.
** $description set with appropriate error message.
*/
function validateEmail($data, &$description)
{
	foreach(explode(",", $data) as $e)
	{
		if(!eregi('^' .
			'[a-z0-9]+([_.-][a-z0-9]+)*' .    //user
			'@' .
			'([a-z0-9]+([.-][a-z0-9]+)*)+' .   //domain
			'\.[a-z]{2,}' .                    //sld, tld
			'$', trim($e))
			)
		{
			$description = "Email addresses must consist of an account, an at sign (@), and a domain name with with a dot in it, e.g. name@company.com.";
			return(FALSE);
		}
	}	
	return(TRUE);
}

/*
** Function: validateInjectionSafe
** Input:	STRING data
** Output: BOOLEAN
** Description: Returns TRUE if data is free of various email injection attempts.
** $description set with appropriate error message.
*/
function validateInjectionSafe($data, &$description)
{
	if (!injectedCRLFSafe($data))
	{
		$description = "Field contains restricted carriage return or line break.";
		return(FALSE);
	}

	if (!angleBracketSafe($data))
	{
		$description = "Field contains restricted characters.";
		return(FALSE);
	}

	if (!injectedPhraseSafe($data))
	{
		$description = "Field contains restricted phrases.";
		return(FALSE);
	}

	return(TRUE);
}

function validateInjectionSafeAllowLineBreak($data, &$description)
{
	if (!angleBracketSafe($data))
	{
		$description = "Field contains restricted characters.";
		return(FALSE);
	}

	if (!injectedPhraseSafe($data))
	{
		$description = "Field contains restricted phrases.";
		return(FALSE);
	}

	return(TRUE);
}

/*
** Function: injectedCRLFSafe
** Input:	STRING data
** Output: BOOLEAN
** Description: Returns TRUE if data is free of carriage returns or line breaks.
*/
function injectedCRLFSafe($data)
{
	if (eregi("\r",$data) || eregi("\n",$data))
	{
		return(FALSE);
	}
	return(TRUE);
}

/*
** Function: angleBracketSafe
** Input:	STRING data
** Output: BOOLEAN
** Description: Returns TRUE if data is free of angle brackets.
*/
function angleBracketSafe($data)
{
	if (eregi("(%3C|<)",$data) || eregi("(%3E|>)",$data))
	{
		return(FALSE);
	}
	return(TRUE);
}

/*
** Function: injectedPhraseSafe
** Input:	STRING data
** Output: BOOLEAN
** Description: Returns TRUE if data is free of email injection phrases.
*/
function injectedPhraseSafe($data)
{
	$prohibited = array //contains phrases that should be filtered - case insensitive
	(
	"bcc:" //the biggies first
	,"to:"
	,"from:"
	,"cc:"
	,"reply-to"
	,"mime-version" //some other common ones
	,"multipart/mixed"
	,"multipart/alternative"
	,"multipart/related"
	,"boundary="
	,"charset"
	,"content-disposition"
	,"content-type"
	,"content-transfer-encoding"
	,"errors-to" // more arcane but still dangerous and shouldn't be there
	,"apparently-to"
	,"in-reply-to"
	,"message-id"
	,"x-mailer"
	,"x-sender"
	,"x-uidl"
	,".ru/" // to stop russian spam
	,".fora.pl" // spam
	,"korokozabr" // to stop russian spam
	,"free download" // to stop spam
	,"downloadable free" // to stop spam
	,"viagra" // to stop spam
	,"cialis" // to stop spam
	);

	for ($i=0; $i < count($prohibited); $i++)
	{
		$dangerous = $prohibited[$i];

		if(eregi($dangerous, strtolower($data)))
		{
		  return (FALSE);
		}
	}
	return(TRUE);
}

// Google captcha
function getCurlData($url)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
	$curlData = curl_exec($curl);
	curl_close($curl);
	return $curlData;
}

function validateCaptcha($data, &$description)
{
	// from http://www.9lessons.info/2014/12/google-new-recaptcha-using-php-are-you.html
	$recaptcha=$data;
	$google_url="https://www.google.com/recaptcha/api/siteverify";
	$secret = '6Lc3OwoTAAAAAAZJ1NIJF65MCrA4BxrU5loPG1HS';
	$ip=$_SERVER['REMOTE_ADDR'];
	$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
	$res=getCurlData($url);
	$res= json_decode($res, true);
	if($res['success'])
	{
		return(TRUE);
	}
	else
	{
		$description = "Please re-enter your reCAPTCHA.</p>";
		return(FALSE);
	}	
}


?>
