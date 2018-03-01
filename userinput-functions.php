<?php
//Finds user inputs from $_POST and $_GET if available and sets to empty if not found to prevent variable not set errors
function userinputs($inputs)
	{	
	//Find all user inputs specified
	foreach ($inputs as $inputname=>$parameters)
		{
		//Get default if it is defined
		if (isset($parameters['Default']) == true)
			$default = $parameters['Default'];
		else
			$default = '';
		
		//Find from POST form, then URL, then default
		if (isset($_SESSION[$inputname]) == true)
			$inputs[$inputname]['uservalue'] = $_POST[$inputname];
		elseif (isset($_POST[$inputname]) == true)
			$inputs[$inputname]['uservalue'] = $_POST[$inputname];
		elseif (isset($_GET[$inputname]) == true)
			$inputs[$inputname]['uservalue'] = $_GET[$inputname];
		else
			$inputs[$inputname]['uservalue'] = $default;
		
		}
	
	Return $inputs;
	}
	
/*---FunctionBreak---*/

function legalcharactersonly($string,$legals)
	{
	//Split legals into array if it is not an array
	if (is_array($legals) == false)
		$legals = str_split($legals);
	
	if ($string != '')
		{
		//Convert string to array
		$string = str_split($string);

		$output = "";
		
		//Loop through each character
		$key = 0;
		$count = count($string);
		while ($key < $count)
			{
			//Add character to output if in legals array
			if (in_array($string[$key],$legals))
				$output = $output . $string[$key];
			$key++;
			}
		
		Return $output;
		}
	else
		Return $string;
	}
/*---DocumentationBreak---*/
/*$string is the string to be checked by the function

$legals is a one dimensional array containing all of the legal characters that may be included in the output string

The output is a string derived from the input string but with all characters that do not appear in the legal characters array removed.*/
/*---FunctionBreak---*/

function checklegal($teststring,$legals)
	{
	//Return an output string that is only legal characters
	$outputstring = legalcharactersonly($teststring,$legals);
	
	if ($teststring == $outputstring)
		Return true;
	else
		Return false;
	}

/*---FunctionBreak---*/
function texttoarraytable($text,$keys,$separator)
	{
	//Explode text into rows array
	$newlines = array("\r\n","\n\r","\r\r","\n\n");
	$text = str_replace($newlines,"\n",$text);
	$text = explode("\n",$text);
	
	if ($keys == "Top")
		{
		$keys = explode($separator,$text[0]);
		$rowkey = 1;
		}
	else
		$rowkey = 0;
	
	//End point for loop
	$rowcount = count($text);
	$output = array();
	
	while ($rowkey < $rowcount)
		{
		//Make temporary line
		$templine = explode($separator,$text[$rowkey]);
		
		if (is_array($keys) == true)
			{
			//Column and count
			$colskey = 0;
			$outputline = array();
			$colscount = count($templine);
			
			while ($colskey < $colscount)
				{
				//Element and key for line
				$colkey = $keys[$colskey];
				$colelement = $templine[$colskey];
				
				//Add element to array with that key
				$outputline[$colkey] = $colelement;
				$colskey++;
				}
			
			array_push($output,$outputline);
			}
		else
			array_push($output,$templine);
		$rowkey++;
		}
	
	Return $output;
	}
/*---DocumentationBreak---*/
/*$text is the input text, which may be from a file or from a text area field on a form

$headers are either:
- An array of headers which are assigned to columns
- "Top" to specify that the top row is the header
- "None" headers are numbered

$separators are what separates the cells within a row, these are typically tabs, commas or spaces*/
/*---FunctionBreak---*/

function standardisenewlines($text)
	{
	//
	$text = str_replace("\r","\n",$text);
	$replaced = 1;
	
	//Replace all double new lines and replace with singles until no more new lines are found
	while ($replaced > 0)
		{
		$text = str_replace("\n\n","\n",$text,$replaced);
		}
	
	//Remove new line tags from start and end if found
	if (substr($text,0,2) == "\n")
		$text = substr($text,2);
	if (substr($text,-2) == "\n")
		$text = substr($text,0,-2);
	
	Return $text;
	}
?>