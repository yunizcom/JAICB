<?
if($protect_key!="yuniz_lansy"){exit("Invalid Operation! Please contact system administrator.");} // include this on all modules page 1st line for script protection.
//----------module own page setting--------------
$input = $_GET['in'];
$inputOrg = $input;
$reply = "Sorry I don't understand";
//----------module own page setting--------------
function lenSort($a,$b){
    return strlen($b)-strlen($a);
}
//----------process input text-------------------
$input = strtolower($input);
$inputSplit = explode(" ",$input);

$teachMode = "0";
if($inputSplit[0] == "teach"){
	$teachMode = "1";
}
//----------process input text-------------------


if($input != ""){
	if($teachMode == "1"){
		$inputSplit = explode("learn",$input);
		$input = replaceVariables(str_replace("teach","",$inputSplit[0]));
		$output = $inputSplit[1];
		if($input != "" && $output != ""){
			$results= mysql_query("SELECT answer from t_brain where keywords = '".$input."' AND answer = '".$output."'");
			if(mysql_Numrows($results)==0){
				mysql_query("INSERT INTO `t_brain` (
													`keywords` ,
													`answer` ,
													`tdate`
												)
												VALUES (
													'".$input."',
													'".$output."',
													'".time()."'
												)");
			}	
			$reply = "Thank for the teaching I will remember";
		}else{
			$reply = "Teaching systax error, please teach again";
		}
	}else{
		$input = replaceVariables($input);
		$inputSplit = explode(" ",$input);
		usort($inputSplit,'lenSort');

		$results= mysql_query("SELECT answer from t_brain where keywords LIKE '%".$input."%' ORDER BY RAND() LIMIT 1");
		if(mysql_Numrows($results)>0){
			while ($row = mysql_fetch_array($results)) {
				$reply = $row['answer'];
			}
		}else{
			$loopCounter = count($inputSplit);
			for($x=0;$x<$loopCounter;$x++)
			{
				$results= mysql_query("SELECT answer from t_brain where keywords LIKE '%".$inputSplit[$x]."%' ORDER BY RAND() LIMIT 1"); 
				if(mysql_Numrows($results)>0){
					while ($row = mysql_fetch_array($results)) {
						$reply = $row['answer'];
					}
					$x+=$loopCounter + 1;
				}
			}
		}
	}
}
?>
{
    "reply": "<?=$reply?>"
}