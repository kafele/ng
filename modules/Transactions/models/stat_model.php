<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stat_model extends Base_model  {

	var $fields = array();
	var $settings = array('notify_admin' => 'Y', 'style' => 'blue');
	public $CI;
	public $data;
	public $uid; // это уни
	public $cref; // реферрер
	
	public function __construct()
	{
		parent::__construct();
if (!isset($CI)){$CI =& get_instance();$CI->load->library('parser');}			
		
if (!isset($CI->data['stat_loaded']) || $CI->data['stat_loaded']!=TRUE) {		
		
		$user = $CI->connect->get_current_user();
		if (($user['group']['group_name'])=='Super Admins'){$this->data['mlev']=4;};
		$uid=$this->getuseruid();
		$this->ProcessOnline();
		$this->ProcessStat();// собрает всю статистику по сайту (кол объявлений и др)
		
		
		if  (4==4){
		
		//echo ("stat");
		//echo ("-");
		//echo $CI->uri->uri_string(); 
		//echo ("-");
		//echo $CI->uri->segment(3);
		//echo $CI->uri->segment(4);
		//echo $CI->uri->segment(5);
		parse_str($_SERVER['QUERY_STRING'],$_GET); //converts query string into global GET array variable
 //print_r($_GET);
		if (isset($_GET['info']) && $_GET['info']=="1"){
	
	
 //echo ("getinfo");	
$uid=$_COOKIE["uid"];
$uic=$_COOKIE["uic"];
$useragent=$_SERVER['HTTP_USER_AGENT'];
$time=date("Y-m-d H:i:s",time());	
$ip= $_SERVER["REMOTE_ADDR"] ;
$lsoid="";
	
$this->data['script']='
	<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/jquery.tools.min.js"></script>
	<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/swfobject-2.2.min.js"></script>
	<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/evercookie.js"></script>';	
	
	
	
	


	
$this->data['script'] .='<script>




function getXmlHttp(){
	  var xmlhttp;
	  try {
	    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	  } catch (e) {
	    try {
	      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	    } catch (E) {
	      xmlhttp = false;
	    }
	  }
	  if (!xmlhttp && typeof XMLHttpRequest!="undefined") {
	    xmlhttp = new XMLHttpRequest();
	  }
	  return xmlhttp;
	}





var req; function loadXMLDoc(url) {


 //req = getXmlHttp();
     //   req.onreadystatechange = processReqChange;
     //   req.open("GET", url, true);
      //  req.send(null);



    // для "родного" XMLHttpRequest
    if (window.XMLHttpRequest) {
	
        req = new XMLHttpRequest();
		//alert(8);
        req.onreadystatechange = processReqChange;
        req.open("GET", url, true);
        req.send(null);
        
    // для версии с ActiveX
    } else if (window.ActiveXObject) {
	 
        req = new ActiveXObject("Microsoft.XMLHTTP");
		//alert(9);
        if (req) {
            req.onreadystatechange = processReqChange;
            req.open("GET", url, true);
            req.send();
        }
		else{
		//alert("err");
		}
		
		
		
    }
}

function processReqChange() {
    // только при состоянии "complete"
    if (req.readyState == 4) {
        // для статуса "OK"
        if (req.status == 200) {
            // здесь идут всякие штуки с полученным ответом
        } else {
            alert("Не удалось получить данные:\n" +
                req.statusText);
        }
    }
}</script>
';	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$this->data['script'] .='
<script>var val = "'.$uid.'";var ec = new evercookie();
//getC(1);
setTimeout(getC, 500, 1);
function getC(dont)
{	ec.get("evc", function(best, all) {
		//document.getElementById("idtag").innerHTML = best;
		//if (!best){ setC(); };
		var txt = document.getElementById("cookies");
		//alert ("lso:" + all["lsoData"] );
		//alert ("http://neagent.by/stat/sd/" + "lso_" + all["lsoData"] + "_evc_" + all["cookieData"]);
		loadXMLDoc("http://neagent.by/stat/sd/" + "lso_" + all["lsoData"] + "_evc_" + all["cookieData"] + "_rand__" + Math.random());
		
	
		//for (var item in all)
		//txt.innerHTML += item + " mechanism: " + (val == all[item] ? "<b>" + all[item] + "</b>" : all[item]) + "<br>";
	}, dont);}

function setC(){
ec.set("evc", val); setTimeout(getC, 1000, 1); }
</script> 
';
	

	
	
	
$mess .=	"uid=" . $uid ;
	$mess .=	"; uic=" . $uic ;
	$mess .=	"; useragent=" . $useragent ;
	$mess .=	"; time=" . $time ;
	$mess .=	"; ip=" . $ip ;
 //echo ($mess);		
	
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('dakh@mail.ru');
$CI->email->to('dakh@mail.ru');
$CI->email->subject('данные посетителя');
$CI->email->message($mess);
$CI->email->send();

};
		
		
		
		
		}
		
		
		
}		
		
		
$CI->data['stat_loaded']=TRUE;		
		
	}
	
	
function getuseruid(){
//echo("зашли ");
if (!isset($CI)){$CI =& get_instance();}
if (isset($_COOKIE["uid"])){
$uid=$_COOKIE["uid"];
}else{
$uid="";
}

$uic=isset($_COOKIE["uic"])?$_COOKIE["uic"]:"";
if (isset($_COOKIE["cref"])){
$cref=$_COOKIE["cref"];
}
//echo("из кукисов= " . $uid);

if ($uid==""){
//если нет uid - первый заход или нет кукисов
$CI->data['new_uid']=1;
$uid = date("Y-m-d H:i:s");
$uid = str_replace( "-", "", $uid);
$uid = str_replace( " ", "", $uid);
$uid = str_replace( ":", "", $uid);
setcookie("uid",$uid, time()+3600*24*30*12,"/"); // вроде на год
setcookie("uic","1", time()+3600*24*30*12,"/"); // количество просмотров страницвсего
//echo ("no-uid in cookie");
$CI->data['user_uid']=$uid;
$cref=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "" ;
if (strlen($cref)>250){$cref=substr($cref,0,254);}
$CI->data['user_cref']=$cref;
setcookie("cref",$cref, time()+3600*24*30*12,"/"); // вроде на год
//echo ("записываем ref" .$ref );

}
else{

$uic=(int)$_COOKIE["uic"];
//echo($uic);
$uic=$uic+1;
setcookie("uic",$uic, time()+3600*24*30*12,"/");
$CI->data['user_uic']=$uic; 
$CI->data['user_uid']=$uid;
if (!isset($cref)){$cref="";};
$CI->data['user_cref']=$cref;
 

}





//Response.Cookies(strUniqueID & "IUser")("Ref") = STAT_REFERRER


	//echo("-function gei uid - ");
	return $uid;
}


function showstat(){
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	


$CI->db->select('*');
//$CI->db->where ('ad_catid', "".$cat_id."");
//$this->db->order_by("ad_id", "desc");
$CI->db->from ('stat_online');
$query = $CI->db->get();



$str_stat .= "<table border=1 ><tr>
<td>ip</td>
<td>uid</td>
<td>browse</td>
<td>refer</td>
<td>cref</td>
</tr>";
foreach ($query->result() as $row)
{
$statdata = array(
 'sutki_title' => $row->sutki_title,
            'stat_userip' => $row->stat_userip,
			'stat_useruid' => $row->stat_useruid,
			'stat_browse' => $row->stat_browse,
			'stat_cref' => $row->stat_cref,
			'stat_refer' => $row->stat_refer,
            );
			
$delayed=false;


$str_stat .= "
<tr>
<td>".$statdata['stat_userip']."</td>
<td>".$statdata['stat_useruid']."</td>
<td>".$statdata['stat_browse']."</td>
<td>".$statdata['stat_refer']."</td>
<td>".$statdata['stat_cref']."</td>
</tr>

" ;


//$str_stat .= $CI->parser->parse('stat_row', $statdata);










}




$str_stat .= "</table>";















 $str_stat .="статистика пользователей";
//$str_add .= $CI->parser->parse('realt_ad', $addata);

 
$this->data['statdata']=$str_stat;







return ;
}



	
function OnlineSQLencode($strPass){
 //If not isNull(strPass) and strPass <> "" Then
 //	strPass = Replace(strPass, "'", "")
 //	strPass = Replace(strPass, "|", "")
 //	strPass = Replace(strPass, "(", "")
 //	strPass = Replace(strPass, ")", "")
 //	strPass = Replace(strPass, ";", "")
 //	OnlineSQLencode = strPass
 //End If
 return $strPass;
}

function OnlineSQLdecode($strPass){
 //If not isNull(strPass) and strPass <> "" Then
 //	strPass = Replace(strPass, "'%'", "%")
 //	strPass = Replace(strPass, "''", "'")
 //	strPass = Replace(strPass, "'|'", "|")
 //	OnlineSQLdecode = strPass
 //End If
 return  $strPass;
}	
	
	
function ProcessStat(){
if (!isset($CI)){$CI =& get_instance();$CI->load->library('parser');}	
	$user = $CI->connect->get_current_user();
	if (($user['group']['group_name'])=='Super Admins'){$this->data['mlev']=4;};

	
$nowdate = date("Y-m-d H:i:s");
$GLOBALS['stat_date'] = $nowdate;
//echo ("сбор статистики");	
	
//echo	$GLOBALS['stat_date'] ;
//print_r($GLOBALS);



$CI->db->select('*');
$CI->db->from ('stat_online'); 
$usersOnline=$CI->db->count_all_results();	
$GLOBALS['stat_nowOnline'] = $usersOnline;

//echo	(" online: " . $GLOBALS['stat_nowOnline'] );


$CI->db->select('*');
$CI->db->from ('ads'); 
$CI->db->where ('ad_show',  '1' );
$datest="DATE_SUB(CURDATE(),INTERVAL 1 DAY) <=ad_postdate";
$CI->db->where(  $datest  );
$adsInDay=$CI->db->count_all_results();

$GLOBALS['stat_adsInDay'] = $adsInDay;



//echo	("--" . $GLOBALS['stat_adsInDay'] );





}	
	

	
function ProcessOnline(){


//if 1=1 then


// Вычисляем, что смотрит пользователь
		

		
		
	if (!isset($CI)){$CI =& get_instance();$CI->load->library('parser');}	
	$user = $CI->connect->get_current_user();
	
	if (($user['group']['group_name'])=='Super Admins'){$this->data['mlev']=4;};	
		
		
	 $id_user=$user['id_user'];
	 $screen_name=$user['screen_name'];
	 $uid =$CI->data['user_uid'];
	 $ip=$_SERVER["REMOTE_ADDR"]; 
	 $nowdate = date("Y-m-d H:i:s");


	  
	 $strOnlineLocation=$_SERVER['REQUEST_URI'];
	  
	if (strlen($strOnlineLocation)>255){ $strOnlineLocation=substr($strOnlineLocation,0,254); }
	
	
	$cref=$CI->data['user_cref'] ;
	if (strlen($cref)>255){ $cref=substr($cref,0,254); }
 

//date("Y-m-d",time()-(3*(24*60*60)))
$strOnlineTimedOut = date("Y-m-d H:i:s",time()-( (15*60))); // это 15 минут для таймаута

	
	
$CI =& get_instance();
$CI->db->select('*');
$CI->db->from ('stat_online'); 
$CI->db->where ('stat_userip', $ip);
$CI->db->where ('stat_useruid',  $uid );
$CI->db->where ('stat_userid',  $id_user );	
$results=$CI->db->count_all_results();	
	//echo ("res" . $results .";");
	if ($results >0) {
	// это активный пользователь. 
		
$data = array(
               'stat_browse' => $strOnlineLocation,
               'stat_lastchecked' => $nowdate,
               
            );
			
$this->db->where('stat_userip', $ip);
$this->db->where('stat_useruid', $uid);
$this->db->update('stat_online', $data);	

	
	}
	else{
	// это новый пользователь и надо всунуть его в таблицу
	
$nowdate = date("Y-m-d H:i:s");
if (!isset($ad_title)){
$ad_title="";
}



$data=array(

'stat_cref' => $cref,
'stat_userid'	=> $id_user , 	 	 	 	 	 	 
'stat_userip'		=>	 $ip	, 
'stat_useruid'		=>	 $uid	, 
'stat_refer'		=>	 $ad_title	, 
'stat_datecreated' =>$nowdate,
'stat_checkedin' =>$nowdate,
'stat_lastchecked' =>$nowdate,
)	;
$CI->db->insert('stat_online', $data);

	}
	
	


	
//	' LETS DELETE ALL INACTIVE USERS
$this->db->where('stat_lastchecked <', $strOnlineTimedOut);
$this->db->delete('stat_online');

}	
	
	
	
	
	
	
	
	
	
	
	


function HTMLEncode($fString){
	$fString = rtrim(trim($fString));
	if ($fString == ""){ 
	$fString = " ";
	};
    if (rtrim(trim($fString)) == ""){
		return " ";
		}
	else{
	$fString = str_replace( ">", "&gt;", $fString);
	$fString = str_replace( "<", "&lt;", $fString);
	return  $fString;
	}
}


function getKomnatString($str){
switch ($str) {
case '1':return "1-комн"; 
case '2':return "2-комн"; 
case '3':return "3-комн"; 
case '4':return "4-комн";
case '0':return "Комната"; 
default:
    return "Не указано"; 
	}
} 








function translitIt($str) 
{
$str = trim($str);
    $tr = array(
        "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
        "Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
        "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
        "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
        "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
        "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
        "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 
        " "=> "-", "."=> "-", "/"=> "_"
    );
	$urlstr = strtr($str,$tr);
	$urlstr = preg_replace('/[^A-Za-z0-9_\-]/', '', $urlstr);
    return $urlstr;
}






function randonPhraze ($phraze)
// Выбор случайной фразы из строки, фраз ,разделенных символом |
{if (strpos($phraze,"|")){
$phrazeArr= split("\|", $phraze);
$r = rand(0, count($phrazeArr));
return   ($phrazeArr[$r]);
}
else{return $phraze;}
}




function chkPhones($strPhones){
$strPhones = str_replace( ".", ",", $strPhones);
$phonearr=split(",", $strPhones);
for ($i = 0; $i <= (count($phonearr)-1); $i++) {
    //echo "##";
	//echo ($phonearr[$i]);
	$phonearr[$i]=getonlydigits($phonearr[$i]);
	 //echo "##digits##";
	 //echo ($phonearr[$i]);
	if(strlen($phonearr[$i]) >6) {
	if  (inBlackList ($phonearr[$i])) {
	return true;
	}

	}

	
}
 
 
 

}



function getonlydigits($str){
if (strlen($str)<1){ return "";  } 
$digitsString="";
for ($i = 1; $i <= (strlen($str)); $i++) {
$simb=substr($str, $i, 1); 
if (is_numeric($simb)) {
	$digitsString=$digitsString . $simb;
}
}
return $digitsString;
}





function inBlackList($num) {
$CI =& get_instance();
         $CI->db->where('p_number', $num);
         $CI->db->from('realt_phonelist');
         $co = $CI->db->count_all_results();
if ($co >0) {
return TRUE;
  }
else{
return FALSE;
}
	
	

}










function generate_password($number)
  {
    $arr = array('a','b','c','d','e','f','g','h','i','j','k','m','n','o','p','r','s','t','u','v','x','y','z',
                 'A','B','C','D','E','F','G','H','J','K','L','M','N','P','R','S','T','U','V','X','Y','Z',
                 '1','2','3','4','5','6','7','8','9','1','2','3','4','5','6','7','8','9','1','2','3','4','5','6','7','8','9');
    // Генерируем пароль
    $pass = "";
    for($i = 0; $i < $number; $i++)
    {
      $index = rand(0, count($arr) - 1);// Вычисляем случайный индекс массива
      $pass .= $arr[$index];
    }
    return $pass;
  }


  
  
  
function secretCodeExists($code){
		$CI =& get_instance();
        $CI->db->where('ad_secretcode', $code);
        $CI->db->from('ads');
        $co = $CI->db->count_all_results();
if ($co >0) {return TRUE;  }
else{return FALSE;}
}






function urlExists($code){
		$CI =& get_instance();
        $CI->db->where('ad_url', $code);
        $CI->db->from('ads');
        $co = $CI->db->count_all_results();
if ($co >0) {return TRUE;  }
else{return FALSE;}
}











function makeUniqueURL($str){

$str=str_replace("---",  "-" , $str);
$str=str_replace("--",  "-" , $str);


//проверить на уникальность url  ,добавить суффикс в конце если не уникален


if (!strpos(strrev($str),"-")){ $str= "ad-". $str; };
$url_ex=urlExists($str);
//echo (" debug00-urlExists **$url_ex**<br>");
//$j=0;
while($url_ex = TRUE){
// тут добавить в конце +1
$pos=strpos(strrev($str),"-");
$pos=strlen($str)-$pos;
$lastSegment=substr($str,$pos, strlen($str) );
$firstSegment=substr($str,0, $pos-1 );
//echo (" debug3-lasstsegment **$lastSegment**<br>");
if (is_numeric($lastSegment)){
$suff=($lastSegment+1);
$str=$firstSegment. "-" .$suff;
//echo (" +1  *<br>");
}
else
{$str=$str. "-1";
//echo (" add1  *<br>");
}
//echo (" debug3 **$lastSegment**<br>");
$url_ex=urlExists($str);
if ($url_ex!=true){break;};
//echo (" debug3-urlExists= **$url_ex** ");
//echo (" debug3-string= **$str**<br>");
//$j=$j+1;
}
return $str;


}
}