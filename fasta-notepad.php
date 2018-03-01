<?php
include 'fasta-functions.php';
include 'userinput-functions.php';

$rawfastafile = "test-fasta.txt";
$rawfastatext = file_get_contents($rawfastafile);

//Convert text from FASTA file to sequence array
$fastaretrieved = texttofasta($rawfastatext);

//Retrieve comment
if (isset($fastaretrieved['Comment']) == true)
	$comment = $fastaretrieved['Comment'];

//Retrieve sequences array from FASTA, assign sequence types
$sequences = $fastaretrieved['Sequences'];
$sequences = checksequencetype($sequences);

$searchterms = array();
//$searchterms[0] = array("Field"=>"isDNA","Term"=>"Yes");
//$searchterms[1] = array("Field"=>"Sequence","Term"=>"GCUG");
//$searchterms[2] = array("Field"=>"Sequence","Term"=>"CROOKS");
//$searchterms[2] = array("Field"=>"Name","Term"=>"WRONG");

$outputinfo = array("isDNA","isRNA","isProtein");

//$sequences = searcharray($sequences,$searchterms);

$displayfasta = fastalines($sequences,$outputinfo);

$htmlfasta = fastaoutput($displayfasta);

$textfasta = fastaoutput($displayfasta,"text");
?>
<html>
<head>
</head>
<body>
<?php echo $htmlfasta; ?>

<textarea cols="40" rows="20"><?php echo $textfasta; ?></textarea>
</body>
</html>