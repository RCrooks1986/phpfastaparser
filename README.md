# phpfastaparser
A set of PHP functions for processing files and text in FASTA format

This function library is for importing FASTA format files into PHP scripts

It is able to process Protein, DNA and RNA sequences, including ambiguous nucleotides and gaps, and includes validation checks in these

Functions do the following:

fasta-functions.php:

parsefasta($text) - Converts a block in a FASTA file to an array containing the name of the sequence ['Name'] and the sequence ['Sequence']

texttofasta($text) - Converts a block of text into an array of sequences, where each element of the array contains information about the sequence. Default information is ['Name'] and ['Sequence'], but these can be added to by other scripts.

checksequencetype($sequences,$checks) - Checks an array of sequences created by texttofasta() as to whether it is consistent with Protein (P), DNA (D) or RNA (R) as specified in $checks. Results (Yes or No) are added to the array on each sequence line

fastalines($sequences,$information) - Converts an array of sequences into formatted lines that can be output as text or HTML. $information is an array of information that can be appended to the name line of the output

fastaoutput($lines,$output) - Outputs a set of FASTA lines created by the fastalines function as either HTML (default) or plain text (for adding to files, HTML forms etc)

searcharray($array,$searchterms) - Searches an array for terms matching those in the searchterms array, which is a 2 dimensional array containing on each line ['Field'] and ['Term'], which describe the search field and the term respectively.

(More generic functions) userinput-functions.php:

userinputs($inputs) - This function takes an array of user input names and retrieves them from $_SESSION, $_POST and $_GET if available, and if not returns a default value. $inputs array has keys that are the names of each user input, and can optionally have default values set. This array is returned with the addition of user inputs.

legalcharactersonly($string,$legals) - This checks the string and removes any illegal characters from it.

checklegal($string,$legals) - This checks that the string is legal and returns true or false.

texttoarraytable($text,$keys,$separator) - This turns a text input into an 2 dimensional array using the $separator and assigning element keys as specified by the $keys array

standardisenewlines($text) - This standardises all new lines to be "\n" in a text input. It removes double line breaks, and carriage returns

The fasta-notepad.php and test-fasta.txt files are used for testing the script.

Richard O. Crooks
