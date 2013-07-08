<?
header('Content-Type: text/html; charset=big5'); 
ob_start("ob_gzhandler");
//-----------load main system files----------------
include "configure.php";
include "db.php";
//-----------load main system files----------------

//-----------functions---------------
function replaceVariables($str)
{
	$filterWords=array("he","she","her","is","are","it","has");
	$arrlength=count($filterWords);
	
	$cleanString = $str;
	
	for($x=0;$x<$arrlength;$x++)
	{
		$cleanString = str_replace($filterWords[$x],"",$cleanString);
	}

    return $cleanString;
}
//-----------functions---------------

include "modules/chat.php";

//-----------load main system files----------------
include "db_close.php";
//-----------load main system files----------------
ob_end_flush();
?>