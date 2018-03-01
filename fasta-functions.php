<?php
//Parses a set of text with multiple fasta files into blocks that are fasta sequences
function parsefasta($text)
	{
	//Explode text into array
	$text = explode("\n",$text);
	
	//Get name and sequence
	$name = array_shift($text);
	$sequence = implode($text);
	
	//Output format
	$output = array("Name"=>$name,"Sequence"=>$sequence);
	Return $output;
	}

//Parses a fasta block from parsemultifasta into sequence and name
function texttofasta($text)
	{
	//Standardise new lines for text input
	$text = standardisenewlines($text);
	
	//Explode FASTA by > indicating beginning of new sequence
	$text = explode(">",$text);
	
	//Shift FASTA comment from text array and create sequences array to store results of FASTA parsing
	$comment = array_shift($text);
	$sequences = array();
	
	//Process each FASTA format sequence and push to array
	foreach ($text as &$sequence)
		{
		$sequence = parsefasta($sequence);
		array_push($sequences,$sequence);
		}
	
	//Output processed fasta array
	$output = array("Sequences"=>$sequences);
	
	//Format comment as HTML if any is present and add to array
	if ($comment != '')
		{
		$comment = standardisenewlines($comment);
		$comment = str_replace("\n","<br>",$comment);
		$comment = "<p>" . $comment . "</p>";
		
		$output['Comment'] = $comment;
		}

	Return $output;
	}

//Check type of sequence
function checksequencetype($sequences,$checkfor = "PDR")
	{
	//Standard is PDR, remove all illegal characters from check flags
	$checkfor = legalcharactersonly($checkfor,"PDR");
	
	if ($checkfor == "")
		$checkfor = "PDR";
	
	//Array of input codes and what they mean
	$codes = array();
	$codes['P'] = "isProtein";
	$codes['D'] = "isDNA";
	$codes['R'] = "isRNA";
	
	//Replace codes with words that are used for array elements
	$checkfor = str_split($checkfor);
	foreach ($checkfor as $position=>$checking)
		{
		if (isset($codes[$checking]) == true)
			$checkfor[$position] = $codes[$checking];
		}
		
	//Output sequences array
	$outputsequences = array();
	
	//Legal characters for each type of lookup
	$legalchars = array("isProtein"=>"ACDEFGHIKLMNPQRSTVWY*","isDNA"=>"ACGTRYSWKMBDHVN.-","isRNA"=>"ACGU");
	
	foreach ($sequences as &$sequence)
		{
		//Output array to populate
		$output = array();
		
		//Conduct each check specified
		foreach ($checkfor as $type)
			{
			$legallist = $legalchars[$type];
			//Check for legality
			$check = checklegal($sequence['Sequence'],$legallist);
				
				if ($check == true)
					$output[$type] = "Yes";
				else
					$output[$type] = "No";
			}
		
		//Push array to line
		$output = array_merge($sequence,$output);
		array_push($outputsequences,$output);
		}

	Return $outputsequences;
	}

//Take a sequences array and process it into lines for FASTA 
function fastalines($sequences,$information = array())
	{
	$output = array();
	
	foreach ($sequences as $sequence)
		{
		//Get the name from the sequence
		$name = $sequence['Name'];
		$name = ">" . $name;
		
		//Identify pieces of information to display, format and attach to sequence name
		foreach ($information as $display)
			{
			$info = $sequence[$display];
			$name = $name . " | " . $display . ": " . $info;
			//$name = htmlentities($name);
			}
		
		//Add formatted name to output line
		array_push($output,$name);
		
		//Split string into lines of 60 bases/residues, add to output array
		$entitiessequence = htmlentities($sequence['Sequence']);
		$splitsequence = str_split($entitiessequence,60);
		$output = array_merge($output,$splitsequence);
		}
	
	Return $output;
	}

//Take FASTA lines and produce output type
function fastaoutput($lines,$output = "html")
	{
	if ($output == "html")
		{
		$lines = implode('<br>',$lines);
		$lines = '<p class="sequence">' . $lines . '</p>';
		}
	elseif ($output == "text")
		{
		$lines = implode("\r\n",$lines);
		}
	
	Return $lines;
	}
	
//Search FASTA using AND constraint. Uses a search based on containing the search term, so not exact
function searcharray($array,$searchterms)
	{
	$output = array();
	
	foreach ($array as $element)
		{
		//Include flag is set to true by default, is unset if any non matches are found
		$include = true;
		
		foreach	($searchterms as $search)
			{
			//Retrieve each field and search term
			$field = $search['Field'];
			$term = $search['Term'];
			
			if (isset($element[$field]) == true)
				{
				//Permanently set include to false for this element
				if (stripos($element[$field],$term) === false)
					$include = false;
				}
			}
		
		//Add to output array if all search terms have succeeded
		if ($include == true)
			array_push($output,$element);
		}
	
	Return $output;
	}
?>