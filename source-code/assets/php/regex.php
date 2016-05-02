<?php 

	function checkletters($input)
	{
		if(preg_match("/^[a-zA-Z]+$/",$input))
			return true;
		else
			return false;
	}

	function checknumbers($input)
	{
		if(preg_match("/^[0-9]+$/",$input))
			return true;
		else
			return false;
	}
    
    function checknumbers_letters($input)
    {
        if(preg_match("/^[a-zA-Z0-9]+$/",$input))
            return true;
        else
            return false;    
    }
    
	function checkaddress($input)
	{
		if(preg_match("/^[a-zA-Z\s]+\s*[0-9]+$/", $input))
			return true;
		else
			return false;
	}

	function checksearch($input)
	{
		if(preg_match("/^[a-zA-Z0-9]*$/",$input))
			return true;
		else
			return false;
	}
?>