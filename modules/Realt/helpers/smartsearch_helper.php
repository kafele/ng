<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
  
   
 
 
  if ( ! function_exists('makeParams'))
{
function makeParams($str){
$strini=$str;
//echo("enter");
//echo($str);
$str = ss_sinonims($str); // заменяет на стандартные синонимы
//echo("res= " . $str);
 
 

$sarr =ss_setparams($str); // тут  определенные параметры.
// затем проверить нет ли в строке улиц или названий городов

//echo("rest= " . $sarr[1]);

//$str =ss_names($str);












}
}
 
 
 
 
 
 
 
if ( ! function_exists('ss_sinonims'))
{
function ss_sinonims($str){
include 'smartsearch_config.php';
///$smartsearch['synonims']

$strArr=split(" ", $str );
//print_r($strArr);
$strArrNew=Array();
for ($i = 0; $i < count($strArr)+1; $i++) {

//echo("-" . count($strArr));

		if (strlen($strArr[$i])>4 ){
			for ($k = 0; $k < count($smartsearch['synonims']); $k++) {
						if ($strArr[$i]  == $smartsearch['synonims'][$k][0]){
						$strArr[$i] = $smartsearch['synonims'][$k][1];
						}

			}		

		}
array_push($strArrNew, $strArr[$i]);		
		
}
$ret= implode(" ", $strArrNew);
return ($ret); 
}
}




if ( ! function_exists('check_condition'))
{
function check_condition($param, $value, $ssParamArr){
// узнать есть ил условие и соответствует ли оно 
//echo("condition");
//echo("-" . $param . " " . $value . "-");

//echo($ssParamArr['$param']);

//$key = array_search($value, $ssParamArr);
$p = $ssParamArr[$param];
//echo("  p=" . $p);

//echo(" key=  " . $key );
if ($p == $value) {
//echo(" СОБЛЮДЕНО   ");

return true;


}


return false;

 
 

}}


 





if ( ! function_exists('ss_setparams'))
{
function ss_setparams($str){
include 'smartsearch_config.php';
 $keys = $smartsearch['keys'];
 $rest="";
$strArr=split(" ", $str );
//print_r($strArr);
$strArrNew=Array();
$ss_params=Array();


//////////////////////////
// проверяем регуляркой если есть цена то выставляем цену
 
//$pricemax==preg_replace("до ?[0-9]+ ?($|долл(аров)?)",'(\0)',$str);
//$pricemax==preg_replace("до ?[0-9]+ ?($|долл(аров)?)",'888',$str);
//$pricemax==preg_replace("/\d+",'888',$str);
//echo("pricemax =" .  $pricemax);

//$pricemin==preg_replace("от ?[0-9]+ ?($|долл(аров)?)",'(\0)',$str);
//echo("pricemin =" .  $pricemin);


////////////////////////



$ss_params['object']  = "kvartira";
for ($i = 0; $i < count($strArr); $i++) {
		if (strlen($strArr[$i])>2 ){
		
			for ($k = 0; $k < count($keys); $k++) {
			//print_r ($keys[$k]);
			//echo (  "<br><br> " ); 
			//echo (  " //парам= ". $keys[$k][0] ); 
						if ($strArr[$i]  == $keys[$k][0]){
						/// совпадение найдено
						 //array([0]"квартира",  [1]"object",      [2]"",     [3]"",    [4]"kvartira" ,     [5]"100"  ,  [6]"1" ),
						
						
						
						
						// проверяем, соблюдена ли зависимость
						
							if (check_condition ($keys[$k][2]  , $keys[$k][3] , $ss_params )){
							// тут надо будет проверить, нужно ли переписывать параметр или
							$ss_params[$keys[$k][1]] = $keys[$k][4];

							
							
						$flag=true;	
							
							
							
							}
						
						
						 
						}
						else {
						//совпадение не найдено - неизвестное попадает в строку остатка 
						
						
						
						}
						
						
						
						
						
			}		
//array_push($strArrNew, $strArr[$i]);
if ($flag!=true){
						$rest .= $strArr[$i] . " " ;
						}
						$flag=false;


		}
 
		
		
		
}
echo (" параметры установлены:");
 print_r ($ss_params);
 
 $array = array(
    0    => $ss_params,
    1  => $rest
);


return ($array); 
}
}









