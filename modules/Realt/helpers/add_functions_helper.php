<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter File Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/file_helpers.html
 */

// ------------------------------------------------------------------------

/**
 * Read File
 *
 * Opens the file specfied in the path and returns it as a string.
 *
 * @access	public
 * @param	string	path to file
 * @return	string
 */	
 
 if ( ! function_exists('getAddFormPage'))
{

 function addFormPage(@$this){
//работа с отправкой объявления
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	
 
 
 if ($this->data['wap_view']==1){
 $this->data['searchform']="";
 }
 
 
 // print_r 
 
 
//Определить город
 
//


// определить, переданы ли данные? в зависимости от этого устанавливаем модэ 
$act=($_POST['act'] != '') ? $_POST['act'] : "default";
$str_add .= $this->init_str_add(); //  Для всх страниц. Запись evc  ,  alert если есть и т.п. 




//echo ("==========");
$segment_cat=$CI->uri->segment(3); $segment_subcat=$CI->uri->segment(4);
if ($segment_subcat!=""   &&  $segment_cat!="wap" ) {$act="edit";   $act=($_POST['act'] != '') ? $_POST['act'] : "edit"; // может и лишнее, но работает 
}







switch ($act) {
case 'post':
case 'doedit':
//СОХРАНЕНИЕ ОБЪЯВЛЕНИЯ



if ($this->data['usemap']==true){
// определяем координаты


$ad_city=(int)chkString($CI->input->post('ad_city'),"SQLString"); 
$ad_street = chkString($CI->input->post('street'),"SQLString");  
$ad_dom = chkString($CI->input->post('dom'),"SQLString"); 
$ad_korpus = chkString($CI->input->post('korpus'),"SQLString"); 
$ad_srok = (int)$CI->input->post('srok'); 
if ($ad_srok == 0) {$ad_srok=14;}


if ($ad_city == 0) {$ad_city=1;}

$gorod= getCityName($ad_city, $config['realt_cityes_id'],$config['realt_cityes_name']);
$value="Беларусь,+" . $gorod . ",+" . $ad_street ;

if ($ad_dom!="") {$value .=  ", дом " . $ad_dom;}
if ($ad_korpus!="") {$value .=  ", к " . $ad_korpus;}
$coordinates = getcoordinates($value);
if ($coordinates){$pos=split( " " , $coordinates);
$longitude=$pos[0];
$latitude=$pos[1];
}
}
//


$ad_for = chkString($CI->input->post('for'),"SQLString"); 


$ad_street = chkString($CI->input->post('street'),"SQLString");   
$ad_area = chkString($CI->input->post('ar'),"SQLString");if (!is_numeric($ad_area)){   $ad_area=0; } 
$ad_subarea = chkString($CI->input->post('subar'),"SQLString");if (!is_numeric($ad_subarea)){   $ad_subarea=0; } 
$ad_catid = chkString($CI->input->post('cat'),"SQLString");if (!is_numeric($ad_catid)){  $err_mess='<li>Не выбрана категория объявления</li>'; } 
$ad_message = chkString($CI->input->post('content'),"SQLString");
$ad_phones = chkString($CI->input->post('phones'),"SQLString");
$ad_contactname = chkString($CI->input->post('ad_name'),"SQLString");
$ad_email = chkString($CI->input->post('ad_email'),"SQLString");


if ($this->user['id_user']>0){
$ad_email = $this->user['email'];
}




$ad_hideemail = chkString($CI->input->post('hideemail'),"SQLString");

$ad_komm_type = chkString($CI->input->post('ad_kommtype'),"SQLString");

$ad_postdate = date("Y-m-d H:i:s");
$ad_enddate = dateAddDays($ad_postdate, $ad_srok);

 

/////////////////
/// ПРОВЕРКА ПОДЛИННЫЙ ЛИ ТЕЛЕФОН 


$vcats=config_item('realt_phone_verification_cats');
$vcatsArr = explode(",", $vcats);
 
 
$verificateThisCat=false; // ini
if(  (count($vcatsArr)==0)  ||  in_array($ad_catid,$vcatsArr)  ){ 
$verificateThisCat=true;
}   






if ($this->data['phone_verification'] ==1){
if (!$this->user['id_user']>0){
//print_r ($this->user);
//echo("--" .$user['id_user']);
$this->data['realt']="<h2>Вход не выполнен</h2><i>Требуется войти на сайт.</i>";
return; 
}


$phone = getonlydigits ($ad_phones); 
$thisPhoneAllowed=phoneAllowed($phone, $this->user['id_user']);
if ($verificateThisCat==true){
			if ($thisPhoneAllowed==false){
			$this->data['realt']="<h2>Телефон ". $ad_phones ." не проверен</h2><i>Требуется верификация номера телефона через СМС</i>";
			return; 
			}
	}
	
}


//$ad_phones
////////////////////

 
$table=getTableFromCatID($ad_catid);
$ad_city=(int)chkString($CI->input->post('ad_city'),"SQLString"); 


include $_SERVER['DOCUMENT_ROOT'].'/modules/Realt/config/realtcash.php';
$cityname=getCityName($ad_city, $config['realt_cityes_id'],$config['realt_cityes_name']);
$autotitle=generateAutoTitle($table, $ad_catid, $ad_message, $cityname, $ad_street, $ad_subarea);




$ad_title=$autotitle['title'];
$ad_url=$autotitle['url'];
$ad_showpolitic = chkString($CI->input->post('showto'),"SQLString");
$ad_komnat = chkString($CI->input->post('komnat'),"SQLString");
$ad_price = chkString($CI->input->post('price'),"SQLString");
$ad_show = 1;

if (!is_numeric($ad_komnat)){  $err_mess='<li>Не выбрано количество комнат</li>'; } 
if (!is_numeric($ad_price)){  $err_mess='<li>Не выбрана цена</li>'; } 

$ad_price2 = chkString($CI->input->post('ad_price2'),"SQLString"); 
$ad_price3 = chkString($CI->input->post('ad_price3'),"SQLString"); 
$ad_period2 = chkString($CI->input->post('ad_period2'),"SQLString");
$ad_period3 = chkString($CI->input->post('ad_period3'),"SQLString");
 
$ad_currency = chkString($CI->input->post('currency'),"SQLString");
 if (!is_numeric($ad_currency)){ 
 $ad_currency=2; // Редактировать. Пока валюта устанавливается в доллары
 } 
 
$realt_currency_rate=config_item('realt_currency_rate');
//print_r ( $realt_currency_rate);

$ad_default_price = defaultPrice($ad_currency, $ad_price, $realt_currency_rate); // формируем цену по умолчанию - для поиска $ad_currency= 1 рубли 2 доллары 3 евро


//формирует пароль для нового 
if ($act=="post"){ 
$ad_secretcode=generate_password(7);
if ($this->data['mlev']==4) {
//echo("<br>2-" . (microtime()-$CI -> data['timestart']));
} 
/// проверка на уникальность 
$sc_ex=secretCodeExists($code);
$j=0;
while($sc_ex != TRUE){
$ad_secretcode=generate_password(7);
$j=$j+1;
}
 
 
if ($this->data['mlev']==4) {
//echo("<br>3-" . (microtime()-$CI -> data['timestart']));
} 
 
 
 
 
 

 
  
/// отправка письма, если более 3 попыток генерации кода уникального 
if ($j>2) {
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('dakh@mail.ru');
$CI->email->to('dakh@mail.ru');
$CI->email->subject('secretcode - более трех попыток');
$CI->email->message('попытка=' . $j."; ad_secretcode=" . $ad_secretcode);
$CI->email->send();
}
}
 
 

// если реферрер не тот - скорее всего автоматическая рассылка 
$refer=strtolower($_SERVER['HTTP_REFERER']);
if (!strpos($refer, "neagent.by")||strpos($refer, "neagent.by")<1){
//$this->data['realt']="Вернитесь на <a href='http://neagent.by/ad-form'>страницу подачи объявления</a> и заполните форму. ";
$msg= "ad_message = $ad_message; ad_komnat=$ad_komnat;  ad_price = $ad_price;   ad_phones=$ad_phones  referrrer="	. $_SERVER['HTTP_REFERER']; 	 	 	 	 	 
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to('info@neagent.by');
$CI->email->subject('Спам? не с той страницы переход');
$CI->email->message($msg);
$CI->email->send();
//return;
}
 
 
 
 
 
 
 
  ///////
 //проверяем, не в черном списке ли email 
 

 

if   (strpos($ad_email, "@")>1&&$table=="ads"){
$ad_email = rtrim(trim( $ad_email));
if (inEmailBlackList($ad_email)){
$ad_uid=$CI->data['user_uid'];
$config['protocol'] = 'sendmail';$config['mailpath'] = '/usr/sbin/sendmail';$CI->load->library('email', $config);$CI->email->set_newline("\r\n");$CI->email->from('info@neagent.by');$CI->email->to('info@neagent.by');
$CI->email->subject('Email отклонен ' . $ad_email);$CI->email->message($ad_email . "; тел. " . $ad_phones . "; uid=" . $ad_uid);$CI->email->send();
//$ad_email="info@neagent.by";
$this->data['realt']="<h2>ВЫ АГЕНТ</h2><i>Система определила вас как агента. Объявление отклонено.</i>";
return; 
 }
 }
 ////////
 
 

 
//''''''''''''''''' ОПРЕДЕЛЯЕМ, АГЕНТСТВО ИЛИ НЕТ ПО НОМЕРУ ТЕЛЕФОНА 

if  (chkPhones($ad_phones)&&$table=="ads"){
$config['protocol'] = 'sendmail';$config['mailpath'] = '/usr/sbin/sendmail';$CI->load->library('email', $config);$CI->email->set_newline("\r\n");
$CI->email->from('dakh@mail.ru');$CI->email->to('dakh@mail.ru');
$CI->email->subject('блокировка по номеру тел');
$CI->email->message('агент пытался дать тел=' . $ad_phones .";"   . $str . "; uid=" . $CI->data['user_uid']);
$CI->email->send();

//echo ("---в черном списке!!!!!!!!!---");
$inLIST=true;$BLACKNUMBER=true;
switch(config_item('realt_black_action')) 
	    {
	    case 'deny':
		    $this->data['realt']="<h2>К сожалению, подача Вашего объявления запрещена.</h2><i>Этот номер телефона в черном списке. <br> Возможно этот телефон как-то связан с агентствами, или заблокирован за нарушения. <br></i>";
			return; 
			break;
        case 'selfuid':
		    $ad_fakefor = "UID=" . $uid . "; - SELFUID";
			break;
        case 'sessionblock':
			$this->data['realt']="<h2>Вы заблокированы</h2><i>Вы даете объявление на телефон, который похож не телефон агентства. Этот номер в черном списке. <br>Сочувствуем, но вы на некоторе время ограничены в пользовании сайтом. ";
			return;
			break;
		default:  // 'allow' 
			break;	
	    }
}
//////////////////////////
 
 
 
if  (chkCodes($ad_phones)){
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('dakh@mail.ru');
$CI->email->to('dakh@mail.ru');
$CI->email->subject('не прошел код');
$CI->email->message('  тел=' . $ad_phones .";"   . $str . "; uid=" . $CI->data['user_uid']);
$CI->email->send();



 $CI->data['scenery_moderate']=1;
 $CI->data['scenery_descriptions'] = $CI->data['scenery_descriptions'] . " +  код ошибочный " ;
 
 
 
//$this->data['realt']="<h2>К сожалению, подача Вашего объявления запрещена.</h2><i>Этот номер телефона в черном списке. <br> Возможно этот телефон как-то связан с агентствами, или заблокирован за нарушения. <br></i>";
//return; 
//break;
			
			
}
 

 
 
///////////////////////////
//Определяем, не написано ли слишком много цифр

 
if (config_item('realt_moderate_max_digits')!=''){
$digcount=strlen(getonlydigits($ad_message));
if  ($digcount>config_item('realt_moderate_max_digits')){
$CI->data['scenery_moderate']=1;
$CI->data['scenery_descriptions'] = $CI->data['scenery_descriptions'] . " + слишком  много цифр" ;
}
}
////////////////////////
 
 
 ///////////////////////////
//Определяем, не написано ли слишком много цифр в группе 

 
if (config_item('realt_moderate_max_digits')!=''){
$digcount=getmaxdigits($ad_message);
$digs=(int)$digcount[0];
if  ($digs>config_item('realt_moderate_max_digits_group')){
$CI->data['scenery_moderate']=1;
$CI->data['scenery_descriptions'] = $CI->data['scenery_descriptions'] . " + слишком  много цифр в группе:" . $digs . "  " . $digcount[1] ;
}
}
////////////////////////

 
 
 
 
 
 
 
 ///////////////////////////
//Определяем, не слишком ли короткое имя
if (config_item('realt_moderate_min_name_lenth')!=''){ 
$cncount=strlen($ad_contactname);
if  ($cncount<config_item('realt_moderate_min_name_lenth')){
 $CI->data['scenery_moderate']=1;
 $CI->data['scenery_descriptions'] = $CI->data['scenery_descriptions'] . " + слишком  короткое имя" ;
}
}
////////////////////////
 
 
 
 
 
 
 
 
 
 
 
 
 
 
////////////проверяем на спам-слова
if  (chkSpam($ad_message)) {$this->data['realt']="<h2>К сожалению, подача Вашего объявления запрещена.</h2><i>Ваше объявление определено системой, как нежелательное. <br> Скорее всего оно нарушает правила сайта или содержит рекламу.Возможно также, что этот телефон как-то связан с агентствами, или заблокирован за нарушения. <br></i>";	return; break;}


///обработка 
$ad_message=removeExtraExclamations($ad_message);

if ($table=="ads"){
$ad_message=addSpaceAfterComma($ad_message);
}
 


$ad_uid=$CI->data['user_uid'];
$ad_uic=(int)$_COOKIE["uic"];
$ad_cref=$CI->data['user_cref'];
$ad_ip=$_SERVER["REMOTE_ADDR"];
$ad_evc1=$_COOKIE["evc"];
$ad_evc=chkString($CI->input->post('evc'),"SQLString");
 

 
 
if ($act=="post"){  // это отправка нового объявления. Не редактирование 
 
//////////////////// сохранение картинок 
$filesArray =$CI->input->post('images');
$images="";$del="";
if ($filesArray){ // если картинки есть в форме
foreach ($filesArray as $i => $value) {
 $imageURL= $filesArray[$i]; 
  //echo(" imageURL" . $imageURL); ///del
 $imageURL=str_replace ("/tmp/t_", "/",  $imageURL);
 //echo(" imageURLrepl" . $imageURL);
if (strpos($filesArray[$i], '/tmp/t_') === FALSE)
		{
			echo "Ошибка p4";
			return ;
		} 
$filename= $filesArray[$i];
$parts		= explode('/tmp/t_', $filename);
$filename	= array_pop($parts); // чистое имя файла без t_
$fullfilename = config_item('realt_temp_upload_folder') . $filename;
$fullthumbname = config_item('realt_temp_upload_folder') . "t_" .$filename;
$oldfile1 = $fullfilename; // это файл полный 
$newfile1 = str_replace ("/tmp/", "/",  $fullfilename);  // это  новый путь файл полный
$oldfile2 = $fullthumbname; //  это файл превью 
$newfile2 = str_replace ("/tmp/", "/",  $fullthumbname);  // это новый путь для превью
if (!copy($oldfile1, $newfile1)) { echo "failed to copy file1...\n";}
if (!copy($oldfile2, $newfile2)) { echo "failed to copy file2...\n";} 
$images .= $del . $filename; 
$del = "; ";
}} // конец if 
/////////////////////////////////////

//return ; ///del

///// Это редактирование
///// Если сутки, то создать первую картинку
if ($filesArray){
$filename= $filesArray[0];
$parts		= explode('/tmp/t_', $filename);
$filename	= array_pop($parts); // чистое имя файла без t_
$f=config_item('realt_temp_upload_folder') .  $filename;
$newf=config_item('realt_temp_upload_folder') .  "main_".  $filename;
$mainpic="";



$mainpic=resizePic($f, $newf, 5);
$mainpic=$newf;
$oldfileMain = $mainpic ;
$newfileMain = str_replace ("/tmp/", "/",  $mainpic); 
if (!copy($oldfileMain, $newfileMain)) { echo "failed to copy filemain...\n";} 
$filename= $mainpic;
$parts		= explode('/tmp/', $filename);
$mainpic	= array_pop($parts); // чистое имя файла без t_
}}

 
  if ($act=="doedit"){ 
//////////////////// сохранение картинок 
$filesArray =$CI->input->post('images'); // это картинки которые мы должны сохранить
 //print_r ( $filesArray); //del
 //echo('<br>');
$images="";$del="";
if ($filesArray){ // если картинки есть в форме
	foreach ($filesArray as $i => $value) {
	$imageURL= $filesArray[$i]; 
	 //echo(" обрабатывается imageURL" . $imageURL);
	$imageURL=str_replace ("/tmp/t_", "/",  $imageURL);
	//echo(" imageURLrepl" . $imageURL);
	//print_r($filesArray);
	if (strpos($filesArray[$i], '/tmp/t_') === FALSE)
		{// ЕСЛИ не в темп _ЗНАЧИТ КАРТИНКА УЖЕ ОБРАБОТАНА БЫЛА 
	//echo(" картинка была обработана"  ); //del	
	$filename= $filesArray[$i];
	//$parts		= explode('/t_', $filename);
	//$filename	= array_pop($parts); // чистое имя файла без t_		
			//echo ("Ошибка p4");
		} 
else{	
//echo(" картинка не была обработана"  ); //del	
$filename= $filesArray[$i];
$parts		= explode('/tmp/t_', $filename);
$filename	= array_pop($parts); // чистое имя файла без t_
$fullfilename = config_item('realt_temp_upload_folder') . $filename;
$fullthumbname = config_item('realt_temp_upload_folder') . "t_" .$filename;
$oldfile1 = $fullfilename; // это файл полный 
$newfile1 = str_replace ("/tmp/", "/",  $fullfilename);  // это  новый путь файл полный
$oldfile2 = $fullthumbname; //  это файл превью 
$newfile2 = str_replace ("/tmp/", "/",  $fullthumbname);  // это новый путь для превью
if (!copy($oldfile1, $newfile1)) { echo "failed to copy file1...\n";}
if (!copy($oldfile2, $newfile2)) { echo "failed to copy file2...\n";} 
}
$images .= $del . $filename; 
$del = "; ";
}
} // конец if 


///////// ЭТО редактирование тоже
///// Если сутки, то создать первую картинку  
if ($filesArray){
$filename= $filesArray[0];
$mainpic="main_". $filename;
///////// ИСПРАВИТЬ ВЕДЬ МОЖЕТ ЭТО ДРУГАЯ КАРТИНКА А НЕ ПЕРВАЯ, ДЕЛАТЬ ПРЕВЬЮЩКУ, ЕСЛИ ФАЙЛА НЕ СУЩЕСТВУЕТ
if (strpos($filesArray[0], '/tmp/t_') === FALSE && 0==2){ // проверка, если 
}
else{
$parts		= explode('/tmp/t_', $filename);
$filename	= array_pop($parts); // чистое имя файла без t_
$f=config_item('realt_temp_upload_folder') .  $filename;
$newf=config_item('realt_temp_upload_folder') .  "main_".  $filename;
$mainpic="";


if (!file_exists ($f)){
//echo("нет такого файла!");
 $f= str_replace ("/tmp/", "/",  $f);

}



$mainpic=resizePic($f, $newf, 5);
$mainpic=$newf;
$oldfileMain = $mainpic ;
$newfileMain = str_replace ("/tmp/", "/",  $mainpic); 
if (!copy($oldfileMain, $newfileMain)) { echo "failed to copy filemain...\n";} 
$filename= $mainpic;
$parts		= explode('/tmp/', $filename);
$mainpic	= array_pop($parts); // чистое имя файла без t_
}
}
//////
}
 
 
 
//////////// Если платное объявление , то переадресуем на страницу с данными ип
if (($ad_catid==11||$ad_catid==12)&&$act=="post"){

////////////////////
//для суток-  сохраняем картинки и отправиляем пока на почут мне 
$filesArray =$CI->input->post('images');
$images2="";

if ($filesArray){
foreach ($filesArray as $i => $value) {
$images2 .=" ". $filesArray[$i];
}

$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('dakh@mail.ru');
$CI->email->to('dakh@mail.ru');
$CI->email->subject('Картинки для суток - редактирование ');
$CI->email->message($images2 . " uid=" .  $CI->data['user_uid']   . " объявл.=" . $ad_message);
$CI->email->send();
}



///////////////////////... Если платное, записываем в сутки пендинг  и генерируем еще одну страницу.
// проверка если email пустой, просим заполнить  пункт email 
if (strlen($ad_email)<2){
$this->data['realt']='Вы даёте объявление в рубрику "на сутки". Укажите, пожалуйста адрес электронной почты. На него будет выслана квитанция на оплату. 
<br> Если вы не хотите, чтобы email был виден в объявлении, под строкой поставьте галочку "скрыть email".
<br><a href="javascript:history.back()"> &lt;Вернуться</a>
';
return;
}



//////// проверяем пользователя
if   ($CI->input->post('id_user') ){
$user = $CI->connect->get_current_user();
$username =  $user['username'];
$id_user =  $user['id_user'];
$userGroupID=$user['id_group'];
$post_id_user = chkString($CI->input->post('id_user'),"SQLString");
if ($post_id_user!=$id_user) {
$this->data['realt']="Время ожидания истекло. Войдите еще раз.";
return;
}

}
else
{
}


///////   Это запись в пендинг 

$addata = array(
	ad_catid	=> $ad_catid , 	 	 	 	 	 	 
 	ad_title		=>	 $ad_title	, 	 	 	 	 	 
 	ad_message	    =>		$ad_message ,	 	 	 	 	 	 
 	ad_komnat	    =>	 	$ad_komnat ,	 	 	 	 
 	ad_price		=>	 	$ad_price 	, 	 	 	 	 
 	ad_postdate	=>		$ad_postdate ,
    ad_enddate			=>		$ad_enddate 	 ,	 	 	 	 	 
 	ad_email	=>		$ad_email ,	 	 	 	 	 	 
 	ad_contactname	=>		$ad_contactname ,	 	 	 	 	 	 
 	ad_phones	=>		$ad_phones 	, 	 	 	 	 	 
 	ad_show	=>		$ad_show 	, 	 	 	 	 	 
 	ad_ip      =>     $ad_ip,
	ad_uid      =>     $ad_uid,
	ad_cref      =>     $ad_cref,
	ad_hideemail      =>     $ad_hideemail,
	ad_street      =>     $ad_street,
	ad_dom      =>     $ad_dom,
	ad_korpus      =>     $ad_korpus,
	ad_area      =>     $ad_area,
	ad_subarea      =>     $ad_subarea,
	ad_city      =>     $ad_city,
	ad_url    =>  $ad_url,
            );
			
////////// я закоментировал строку ниже. типа картинки можно добавлять			
//if ($act=="post"){  // если doedit то это пропускается 
	// картинки сохраняем тока ессли это post 
	
$allowEditPictures=1;	//  разрешено ли редактировать картинки

if ($allowEditPictures==1){	
	$addata['ad_pictures']     =     $images;
	$addata['ad_mainpic']      =      $mainpic;
}
	
	
//}	
			
			
			
		
if ($id_user>1) {// это от вошедшего пользователя 
$addata['ad_client_id']= $id_user;
}		
			
			
			
			
$CI->db->insert('realt_sutki_pending', $addata);	
	//echo $this->db->_error_message();
	//echo $this->db->last_query();
/// всунули, теперь считать ID 

$pending_id = $CI->db->insert_id();
			

//echo ("pending_id= $pending_id");










 if ($this->data['mlev']==4) {
//echo ("<br>5-" . now());
} 
	
	

$addata = array(
ad_pending_id	=> $pending_id , 
ad_postdate  => $ad_postdate
 );
			
	//echo ($id_user);		
if 		($id_user>1 && getclientData($id_user) ){
$addata['client']=true;
$addata['id_user']=$id_user;
$addata['username']=$username;
$clientData=getclientData($id_user);
 
 //print_r ($clientData);
$addata['firmname']=$clientData['firmname'];
$addata['unp']=$clientData['unp'];
$addata['email']=$ad_email;
$addata['client_id']=$clientData['id'];

//print_r ($clientData);
//echo($clientData['firmname']);
//echo($clientData['unp']);

}
else{
$addata['client']=false;
//echo("нет данных клиента");

}


	

$str_add .= $CI->parser->parse('realt_ad_step2', $addata);
 if ($this->data['mlev']==4) {
//cho ("<br>7-" . now());
} 
$this->data['realt']=$str_add;



return;

 }

 
 
 
///////////////////////////////// конец переадресовки на сутки 

 if ($this->data['mlev']==4) {
 
 $this->data['debug'] .= chkflood($ad_catid, $ad_message, $ad_uid);
 
 
 
}






if (chkflood($ad_catid, $ad_message, $ad_uid)){
$str_add="Вы уже недавно опубликовали одно похожее объявление. Если хотите повторить еще раз, сделайте это через некоторое время.";
$this->data['realt']=$str_add;
return;
} 












 

if ($act=="post"){ 





$email_confirm =config_item('realt_email_confirm');





if ($this->data['phone_verification'] ==1){ // если  все  верифицируется по телефону




$email_confirm =0;
$ad_email = $this->user['email'];
// но если пользователь  старый, не подтвердил email то пусть подтвердит. 
if ($this->user['verified']!=1){
$email_confirm =1;

}



}


if ($thisPhoneChecked == true){
$ad_phones = $ad_phones . " <small style='color:#5baf3a; font-weight:normal;'>тел. подтвержден.</small>";
}










if ($this->data['mlev']==4) {

//$email_confirm =1;	

}	

	
	




// Сохранение объявления 
// ВСТАВКА В БАЗУ  ads   и сохранение картинок
$data=array(
ad_catid	=> $ad_catid , 	 	 	 	 	 	 
 	ad_title		=>	 $ad_title	, 	 	 	 	 	 
 	ad_message	    =>		$ad_message ,	 	 	 	 	 	 
 	ad_komnat	    =>	 	$ad_komnat ,	 	 	 	 
 	ad_price		=>	 	$ad_price 	, 
ad_currency		=>	 	$ad_currency 	, 
ad_default_price		=>	 	$ad_default_price 	, 
 	ad_postdate	=>		$ad_postdate ,
    ad_firstdate	=>		$ad_postdate ,	
 	ad_enddate			=>		$ad_enddate 	 ,	 	 	 	 	 
 	ad_email	=>		$ad_email ,	 	 	 	 	 	 
 	ad_contactname	=>		$ad_contactname ,	 	 	 	 	 	 
 	ad_phones	=>		$ad_phones 	, 	 	 	 	 	 
 	ad_show	=>		$ad_show 	, 	 	 	 	 	 
 	ad_ip      =>     $ad_ip,
	ad_uid      =>     $ad_uid,
	ad_uic      =>     $ad_uic,  
	ad_evc      =>     $ad_evc,
	ad_cref      =>     $ad_cref,
	ad_hideemail      =>     $ad_hideemail,
	ad_street      =>     $ad_street,
	ad_dom      =>     $ad_dom,
	ad_korpus      =>     $ad_korpus,
	ad_area      =>     $ad_area,
	ad_subarea      =>     $ad_subarea,
	ad_city      =>     $ad_city,
	ad_pictures      =>      $images,
	ad_secretcode    =>  $ad_secretcode,
	ad_url    =>  $ad_url,
	ad_showpolitic    => $ad_showpolitic,
	longitude => $longitude,
	latitude => $latitude,
	ad_komm_type => $ad_komm_type,
	
	ad_srok => $ad_srok
	
	
	
)	;


if ($this->data['mlev']==4) {
$data['ad_fakefor']=$ad_for;
$data['ad_show']=0;
}



if ($this->data['mlev']==4) {
//print_r($data);
}  
//print_r($data);







if ($email_confirm ==1){
$data['ad_show']=0;
$data['m_confirmed']=0;
$data['m_confirm_code']= generate_password(22);
$m_confirm_code=$data['m_confirm_code'];
};





/////////////////// Защта от спама   - проверить чтоб одинаковый текст не слали













if ($CI->data['scenery_moderate']==1){
$data['ad_show']=0;
$data['ad_pending']=1;

 











//echo ("!!!!!!!!!!!!на модерации!!!!!!!!!!!!!");
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('dakh@mail.ru');
$CI->email->to('dakh@mail.ru');
$CI->email->subject('Сценарий - moderate ' . $CI->data['scenery_descriptions']);
$CI->email->message('moderate=' . $spwords[$i].";  " . $str . "; uid=" . $CI->data['user_uid'] . " " . "http://neagent.by/board/uid/" . $CI->data['user_uid'] . " ссылка для допуска http://neagent.by/realt/ad_approve/" );
$CI->email->send();
}

	
$CI->db->insert('ads', $data);	




//echo ($CI->db->last_query());
//echo ( $CI->db->_error_message());
 
// ВСТАВКА В БАЗУ	
// epyftv ID последней записи
$last_id=$CI->db->insert_id();

 

if ($CI->data['scenery_moderate']==1){
$data2=array(ad_id => $last_id,	description 	=>	$CI->data['scenery_descriptions']);	
$CI->db->insert('realt_ad_description', $data2);
}






}
else{ // act==edit
 


$table = chkString($CI->input->post('ad_tab'),"SQLString");
$ad_id = chkString($CI->input->post('ad_id'),"SQLString");


/////////////////
//ПРОВЕРИТЬ, ЕСТЬ ЛИ ПРАВА У ПОЛЬЗОВАТЕЛЯ 
//



if ($this->data['mlev']!=4) {


$user = $CI->connect->get_current_user();
$current_user_id=$user['id_user'];
			$CI->db->limit(1);
			$CI->db->order_by("ad_id", "DESC");
			$CI->db->where('ad_id', $ad_id);
			$CI->db->from("sutki");
			$query = $CI->db->get();
			if ($query->num_rows() == 0  )
			{
				echo("Ошибка;"); return;
			}
			else
			{
			foreach ($query->result() as $row){
			//	НА САМОМ ДЕЛЕ ТУТ ОДНАСТРОКА, так что пройдет только одна проверка
			 $ad_client=$row->ad_client;
			}
			};
 
 
 if ($ad_client!=$current_user_id&&$this->data['mlev']!=4) {
 //echo ("- $ad_client - $current_user_id" ); 
$this->data['realt']='Недостаточно  прав.<br><a href="javascript:history.back()"> &lt;Вернуться</a>';return;
 }
 
 
 if ($table!="sutki"){
$this->data['realt']='Редактирование недоступно.<br><a href="javascript:history.back()"> &lt;Вернуться</a>';return;
 }
 
 
 }
 
 
 
 
 
 
 
 
 



 
 
 
 
 
 
 
 




//
//END ПРОВЕРИТЬ, ЕСТЬ ЛИ ПРАВА У ПОЛЬЗОВАТЕЛЯ 
////////////////////









// подготовка для update -
$data=array(
 	//ad_title		=>	 $ad_title	, 	 	 	 	 	 
 	ad_message	    =>		$ad_message ,	 	 	 	 	 	 
 	ad_komnat	    =>	 	$ad_komnat ,	 	 	 	 
 	ad_price		=>	 	$ad_price 	, 	 	 	 	 
 	ad_email	=>		$ad_email ,	 	 	 	 	 	 
 	ad_contactname	=>		$ad_contactname ,	 	 	 	 	 	 
 	ad_phones	=>		$ad_phones 	, 	 	 	 	 	 
 	//ad_show	=>		$ad_show 	, 	 	 	 	 	 
 	//ad_ip      =>     $ad_ip,
	ad_uid      =>     $ad_uid,
	ad_hideemail      =>     $ad_hideemail,
	ad_street      =>     $ad_street,
	ad_dom      =>     $ad_dom,
	ad_korpus      =>     $ad_korpus,
	ad_currency      =>     $ad_currency,
	ad_area      =>     $ad_area,
	ad_subarea      =>     $ad_subarea
)	;

 if (!is_numeric($ad_currency)){ 
 $ad_currency=2; // Редактировать. Пока валюта устанавливается в доллары
 }
//echo ($ad_currency);


$data['ad_pictures']     =     $images;
$data['ad_mainpic']      =      $mainpic;



if ($table=="sutki"){
$ad_sp_mest = chkString($CI->input->post('ad_spmest'),"SQLString");
$data['ad_sp_mest']=$ad_sp_mest;
//unset($data['ad_show']);

$ad_price2 = chkString($CI->input->post('ad_price2'),"SQLString");$data['ad_price2']=$ad_price2;
$ad_price3 = chkString($CI->input->post('ad_price3'),"SQLString");$data['ad_price3']=$ad_price3;
$ad_period2 = chkString($CI->input->post('ad_period2'),"SQLString");$data['ad_period2']=$ad_period2;
$ad_period3 = chkString($CI->input->post('ad_period3'),"SQLString");$data['ad_period3']=$ad_period3;
 





}

if ($this->data['mlev']==4) {
unset($data['ad_uid']);
}







if ($this->data['mlev']==4) {
echo("DATA!!!@");
print_r($data);

}  



if (($CI->data['scenery_moderate']==1)&&$table=="ads"){
$data['ad_show']=0;
$data['ad_pending']=1;
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('dakh@mail.ru');
$CI->email->to('dakh@mail.ru');
$CI->email->subject('Сценарий - moderate' . $CI->data['scenery_descriptions']);
$CI->email->message('moderate=' . $spwords[$i].";  " . $str . "; uid=" . $CI->data['user_uid'] . " " . "http://neagent.by/board/uid/" . $CI->data['user_uid'] . " ссылка для допуска http://neagent.by/realt/ad_approve/" );
$CI->email->send();
}







$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('dakh@mail.ru');
$CI->email->to('dakh@mail.ru');
$CI->email->subject('Отредактировано объявление' . $ad_id);
$CI->email->message('moderate=' . $spwords[$i].";  " . $str . "; uid=" . $CI->data['user_uid'] . " " . "http://neagent.by/board/uid/" . $CI->data['user_uid'] . " ссылка для допуска http://neagent.by/realt/ad_approve/" );
$CI->email->send();










$CI->db->where('ad_id', $ad_id);
//$CI->db->like('ad_secretcode', $secretcode);
$CI->db->update($table, $data);	

	 //echo $CI->db->_error_message();
	 //echo $CI->db->last_query();
}


















if ($act=="post"){ 
//отправляем письмо пользователю

if (strlen($ad_email)>3) {
$subject_letter = "Ваше объявление на Neagent.by";
switch ($ad_catid) {case '2':case '4':case '6':case '8':case '10':
$ad_fullurl="http://neagent.by/snimu/".$ad_url;break; 
case '1':case '3':case '5':case '7':case '11':
$ad_fullurl="http://neagent.by/sdayu/".$ad_url;break;
default:$ad_fullurl="http://neagent.by/sdayu/".$ad_url;
}

	$letterdata = array(
		'secret_code' => 	$ad_secretcode,
		'ad_moderate' => $data['scenery_moderate'],
		'ad_url' =>$ad_fullurl,
		'ad_id' =>$last_id,
				'autoup' => config_item('realt_autoupdate')

	);
		

if ($email_confirm ==1){
$subject_letter = "Пожалуйста, подтвердите ваш email на neagent.by ";
$letterdata['m_confirm_code']=$m_confirm_code;
$message = $this->load->view('emails/ad_confirm_email', $letterdata, true);



}
else{

							
$message = $this->load->view('emails/ad_added_email', $letterdata, true);

$messagestr2 = "Вы отправили объявление на Neagent.by. Код объявления: " .   $ad_secretcode   . " . 
Сохраните этот код, с ним Вы сможете отредактировать или удалить Ваше обьявление. 
Для удаления объявления щелкните на его заголовке, перейдете на его страницу, 
сразу под ним будут ссылки для редактирования и удаления." ;

if ($CI->data['scenery_moderate']==1&&$table=="ads"){$messagestr2 = $messagestr2 . " Ваше объявление появится на сайте после проверки модератором. " ;
}

$messagestr3="<br>Код объявления отправлен на ваш email.<br> " ;


}




$config['protocol'] = 'sendmail';$config['mailpath'] = '/usr/sbin/sendmail';$config['mailtype'] = 'html';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to($ad_email );
$CI->email->subject($subject_letter);
$CI->email->message($message);
$CI->email->send();



////////////////


//$CI->load->library('email', $config);
//$CI->email->set_newline("\r\n");
//$CI->email->from('info@neagent.by');
//$CI->email->to('dakh@mail.ru');
//$CI->email->subject($subject_letter);
//$CI->email->message($message);
//$CI->email->send();


/////////////////



}


} // if post










if ($act=="post"){ 


if ($email_confirm ==1){
	$this->data['realt']="<b>Ваше объявление ожидает активации.</b> <br>На ваш адрес <b>" . $ad_email . "</b> отправлено письмо с кодом подтверждения. Перейдите по ссылке, указанной в письме, чтобы активировать объявление.";   	 
}else{




	if (config_item('realt_post_delay')	>0){ $this->data['realt']="Ваше объявление опубликовано. Доступно к просмотру оно станет через ".  config_item('realt_post_delay') . " минут. " . "Код объявления : " .   $ad_secretcode     . $messagestr3;	 
	}else {
	$this->data['realt']="Ваше объявление опубликовано." . "Код объявления : " .   $ad_secretcode     . $messagestr3;
	if ($CI->data['scenery_moderate']==1){
	$this->data['realt']="Ваше объявление  появится на сайте после проверки модератором. Это может занять от получаса до трех часов. " . "Код объявления : " .   $ad_secretcode     . $messagestr3;
	}
	} 
	
}	
	
$logstr = "адрес объявления = " . $ad_fullurl;	
$logstr .= "email юзера = " . $ad_email;

saveLog('dobavlenie_objavlenij', 'Конец Пользователь разместил объявление.  ' . $logstr);






	

}	
else  // Если это редактирование
{

$this->data['realt']="Ваше объявление изменено. <br><a href='javascript:history.go(-2)'> &lt;Вернуться</a>";
if ($CI->data['scenery_moderate']==1&&$table=="ads"){
$this->data['realt']="Оно появится на сайте после проверки модератором. Это может занять от получаса  до трех часов. ";
}

}	
	




	

break;
case 'edit':
////////////////////////////форма редактирования объявления////////////////////////////////////////////////////////////////////////////////////////////////////

$page=$CI->uri->segment(2). $CI->uri->segment(4);

$adnumber=$CI->uri->segment(4);
//echo $adnumber;

//$adnumber = intval($adnumber)?intval($adnumber):-1;


if (!ctype_digit($adnumber)||strlen($adnumber)<4 ){$this->data['realt']='Ошибка..';break;}


switch (substr($adnumber,0,3)) {
case '100':
$table="ads";
break;
case '200':
$table="sutki";
break;
}

if ($table==""){$this->data['realt']='Ошибка.';break;}
$ad_id =substr($adnumber,3);




$CI->db->select('*');
			$CI->db->where ('ad_id', "".$ad_id ."");
			//$CI->db->where ('ad_show', "1");
			 $CI->db->limit(1);
			$CI->db->from ($table);


$query = $CI->db->get();
if ($query->num_rows() == 0 )
			{
				$this->data['realt']='Не найдено объявление.';break;
			}
			else
			{
			 
				foreach ($query->result() as $row){
		



switch ($table) {
case 'ads':
$addata = array(
            'edit' => true,
			'table' => $table,
			'ad_id' => $row->ad_id,
            'ad_title' => $row->ad_title,
            'ad_message' => $row->ad_message,
			'ad_price' => $row->ad_price,
			'ad_currency' => $row->ad_currency,
			'ad_phones' => $row->ad_phones,
			'ad_contactname' => $row->ad_contactname,
			'ad_postdate' => $row->ad_postdate,
			'ad_firstdate' => $row->ad_firstdate,
			'ad_email' => $row->ad_email,
			'ad_pictures' => $row->ad_pictures,
			'ad_area' => $row->ad_area,
			'ad_subarea' => $row->ad_subarea,
			'ad_street' => $row->ad_street,
			'ad_dom' => $row->ad_dom,
			'ad_korpus' => $row->ad_korpus,
			'ad_url' => $row->ad_url,
			'ad_komnat' => $row->ad_komnat,
			'ad_uid' => $row->ad_uid,
			'ad_ip' => $row->ad_ip,
			'ad_cref' => $row->ad_cref,
			'ad_show' => $row->ad_show,
			'ad_pending' => $row->ad_pending,
			'ad_secretcode' => $row->ad_secretcode,
			'ad_hideemail'=>$row->ad_hideemail,
			'ad_catid'=>$row->ad_catid,
			'ad_comments_count' => $row->ad_comments_count
            );
 
if (strlen($addata['ad_pictures'])>1) {
$ad_pictures= explode("; ", $addata['ad_pictures']);
$addata['ad_pictures']=$ad_pictures;
$addata['ad_thumbs']=$ad_pictures;
$addata['pic_folder']="http://neagent.by/modules/Realt/files/";
$addata['ad_mainpic']="http://neagent.by/modules/Realt/files/" . "t_".  $ad_pictures[0];
}
else
{ $addata['ad_pictures']=array();
$addata['ad_mainpic']="http://neagent.by/themes/neagent_style/assets/images/kvartira.gif";}
 
 
 
 
 
$sstr="";
for ($k = 0; $k < count($this->data['cityuriArr']); $k++) {
$sstr .=   "<OPTION value=" .$this->data['cityidArr'][$k] . " >". $this->data['citynameArr'][$k]. "</OPTION>";
}

$cstr="";
for ($k = 0; $k < count($this->data['realt_cats']); $k++) {
$cid=$this->data['realt_cats'][$k]['id'];
//echo ("Выбранный сat=" . $cid);
for ($h = 0; $h < count($this->data['realt_subcats']); $h++) {
if ($this->data['realt_subcats'][$h]['parent']==$cid){
$cstr .=   "<OPTION value=" .$this->data['realt_subcats'][$h]['id'] . " >".  $this->data['realt_cats'][$k]['name'] . " » " . $this->data['realt_subcats'][$h]['name']. "</OPTION>";
}
}
}



$addata['cityes']= $sstr;
$addata['cats']= $cstr;
 
 
 
 
 
$str_add .="<h1>Редактирование объявления</h1>";   
$str_add .= $CI->parser->parse($this->data['adform_view'], $addata);
$this->data['realt']=$str_add;
 
return; 
//echo  ($addata['ad_phones']);

break;

case 'sutki':
$addata = array(
            'edit' => true,
			'table' => $table,
			'ad_id' => $row->ad_id,
            'ad_title' => $row->ad_title,
            'ad_message' => $row->ad_message,
			'ad_price' => $row->ad_price,
			'ad_price2' => $row->ad_price2,
			'ad_price3' => $row->ad_price3,
			'ad_period2' => $row->ad_period2,
			'ad_period3' => $row->ad_period3,
			'ad_currency' => $row->currency,
			'ad_phones' => $row->ad_phones,
			'ad_contactname' => $row->ad_contactname,
			'ad_postdate' => $row->ad_postdate,
			'ad_firstdate' => $row->ad_firstdate,
			'ad_email' => $row->ad_email,
			'ad_pictures' => $row->ad_pictures,
			'ad_area' => $row->ad_area,
			'ad_subarea' => $row->ad_subarea,
			'ad_street' => $row->ad_street,
			'ad_dom' => $row->ad_dom,
			'ad_korpus' => $row->ad_korpus,
			'ad_url' => $row->ad_url,
			'ad_komnat' => $row->ad_komnat,
			'ad_uid' => $row->ad_uid,
			'ad_ip' => $row->ad_ip,
			'ad_cref' => $row->ad_cref,
			'ad_show' => $row->ad_show,
			'ad_pending' => $row->ad_pending,
			'ad_secretcode' => $row->ad_secretcode,
			'ad_comments_count' => $row->ad_comments_count,
			'ad_client' => $row->ad_client, 
			'ad_sp_mest' => $row->ad_sp_mest
            );
 
 
if ($addata['ad_client'] != $user['id_user']) {   //$addata['ad_client']   - это user id

$str_add .="---------------";
//$str_add .= "Вы должны войти под своим паролем в панель пользователя, чтобы редактировать объявление. Перейдите на страницу <a href='http://neagent.by/client'> http://neagent.by/client</a>";
//$this->data['realt']=$str_add;

//return; 
}
 
 
 
 
 
 
if (!is_numeric($ad_currency)){ 
 $ad_currency=2; // Редактировать. Пока валюта устанавливается в доллары
}
$addata['ad_currency']=$ad_currency;

 
if (strlen($addata['ad_pictures'])>1) {
$ad_pictures= explode("; ", $addata['ad_pictures']);
$addata['ad_pictures']=$ad_pictures;
$addata['ad_thumbs']=$ad_pictures;


//echo ($ad_pictures[0]);
$addata['pic_folder']="http://neagent.by/modules/Realt/files/";
$addata['ad_mainpic']="http://neagent.by/modules/Realt/files/" . "".  $ad_pictures[0];





}
else
{ $addata['ad_pictures']=array();




$addata['ad_mainpic']="http://neagent.by/themes/neagent_style/assets/images/kvartira.gif";




}
 
 
 
 
 
 
 
 $sstr="";

for ($k = 0; $k < count($this->data['cityuriArr']); $k++) {
$sstr .=   "<OPTION value=" .$this->data['cityidArr'][$k] . " >". $this->data['citynameArr'][$k]. "</OPTION>";
}

$cstr="";
for ($k = 0; $k < count($this->data['realt_cats']); $k++) {
$cid=$this->data['realt_cats'][$k]['id'];
//echo ("Выбранный сat=" . $cid);
for ($h = 0; $h < count($this->data['realt_subcats']); $h++) {
if ($this->data['realt_subcats'][$h]['parent']==$cid){
$cstr .=   "<OPTION value=" .$this->data['realt_subcats'][$h]['id'] . " >".  $this->data['realt_cats'][$k]['name'] . " » " . $this->data['realt_subcats'][$h]['name']. "</OPTION>";
}
}
}



$addata['cityes']= $sstr;
$addata['cats']= $cstr;
 
 
 
 
 
 
 
 
 $str_add .="<h1>Редактирование объявления</h1>"; 
$str_add .= $CI->parser->parse($this->data['adform_view'], $addata);
$this->data['realt']=$str_add;

return; 





break;
}









		
				
		
				
				
				
				
				}
			}






 


$query = $CI->db->get();
//echo 	($CI->db->last_query());
// Ниже показана переменная, сколько на странице объявлений.
//echo (config_item('realt_ads_per_page')."iii");

// $query;




 


$ad_street = chkString($CI->input->post('street'),"SQLString");




$this->data['realt']='Редактирование объявления недоступно.';
break;






case 'check': //act = "check"   - для  шага 2 это уже проверка данных и запись пользователя в базу для суток 


$pend_id = (int)$CI->input->post('pend_id');   if ($pend_id==0) {$errstr.="Произошла ошибка"; return;}
$ad_postdate = chkString($CI->input->post('ad_postdate'),"SQLString");
$firmname = chkString($CI->input->post('firmname'),"SQLString");  
$unp = chkString($CI->input->post('unp'),"SQLString");
$juraddress = chkString($CI->input->post('juraddress'),"SQLString");  
$postaddress = chkString($CI->input->post('postaddress'),"SQLString");
$sposob = chkString($CI->input->post('sposob'),"SQLString");
$account = chkString($CI->input->post('account'),"SQLString");
$bank = chkString($CI->input->post('bank'),"SQLString");
$kod = chkString($CI->input->post('kod'),"SQLString");
$srok = chkString($CI->input->post('srok'),"SQLString");
$phone = chkString($CI->input->post('phone'),"SQLString");
$email = chkString($CI->input->post('email'),"SQLString");
$postdate = date("Y-m-d H:i:s");



if ($this->data['mlev']==4) {
//echo(32434234234);
//print_r($user);
}

$email="";



// вставляем в базу 

$data=array(
	 	 	 	 	 	 
 	firmname		=>	 $firmname	, 	 	 	 	 	 
 	unp	    =>		$unp ,	 	 	 	 	 	 
 	juraddress	    =>	 	$juraddress ,	 	 	 	 
 	postaddress		=>	 	$postaddress 	, 	 	 	 	 
 	 
    account	=>		$account ,	
 	bank			=>		$bank 	 ,	 	 	 	 	 
 	kod	=>		$kod ,	 	 	 	 	 	 
 	  email	=>		$this->user['email'] 	, 	 	 	 	 	 
 	phone	=>		$phone 	, 	 	 	 	 	 
 	postdate      =>     $postdate,
	status      =>     1
)	;

if ($this->data['mlev']==4) {
//echo('dat45');
//print_r($this->user['email']);

}  

$CI->db->insert('fin_clients', $data);
	


///echo $CI->db->_error_message();
//echo $CI->db->last_query();





/// получить client_id
$client_id=$CI->db->insert_id();

 


 
 $client_id = (int)$client_id;
if ($client_id==0) {
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to('info@neagent.by');
$CI->email->subject('ошибка 28 - не удалось получить  client id');
$CI->email->message($pend_id);
$CI->email->send();
	}	
		

		
		




			
			
			
			
			
	

///////// берем данные о заказе , чтобы вывести на проверку

			$CI->db->limit(1);
			$CI->db->order_by("ad_id", "DESC");
			$CI->db->where('ad_postdate', $ad_postdate);
			$CI->db->from("realt_sutki_pending");
			$query = $CI->db->get();

			if ($query->num_rows() == 0 )
			{
				//$result =  false;
				$pending_id = -1;
			}
			else
			{
			
			foreach ($query->result() as $row){
			//	НА САМОМ ДЕЛЕ ТУТ ОДНАСТРОКА, так что пройдет только одна проверка
			$data = array(
			'ad_catid' => $row->ad_catid,
            'ad_title' => $row->ad_title,
            'ad_message' => $row->ad_message,
			'ad_price' => $row->ad_price,
			'ad_phones' => $row->ad_phones,
			'ad_contactname' => $row->ad_contactname,
			'ad_email' => $row->ad_email,
			'ad_pictures' => $row->ad_pictures
			);
			$pending_id =$row->ad_id;
			 	 
			}
				//$result = $query->row_array();
			};
		
			
			
			

			
			
       if ($data['ad_catid']== 11) {$data['ad_catid']="Квартиры на сутки";} ; 
       if ($data['ad_catid']== 12) {$data['ad_catid']="Дома, коттеджи на сутки";} ; 

$data['client_id']=$client_id;
    $data['pend_id']= $pending_id; 
	$data['firmname'] = $firmname; 	 	 	 	 	 
 	$data['unp'] =$unp;	 	 	 	 	 	 
 	$data['juraddress'] =	$juraddress;	 	 	 	 
 	$data['postaddress'] =	$postaddress; 	 	 	 	 
 	$data['sposob'] = $sposob;
    $data['account']=	$account;	
 	$data['bank']	=$bank;	 	 	 	 	 
 	$data['kod']=	$kod;	 	 	 	 	 	 
 	$data['srok'] = $srok;	 	 	 	 	 	 
 	$data['phone'] =	$phone; 	 	 	 	 	 
 	$data['postdate'] = $postdate;

        

//$str_add .= $CI->parser->parse('realt_ad', $addata);
$str_add .= $CI->parser->parse('realt_ad_step3', $data);
$this->data['realt']=$str_add;
return;	
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			













break;





case 'invoice': //act = "invoice"   -  создаёт счет 



//////// проверяем пользователя


if   ($CI->input->post('id_user') ){
$user = $CI->connect->get_current_user();
$username =  $user['username'];
$id_user =  $user['id_user'];
$userGroupID=$user['id_group'];
$post_id_user = chkString($CI->input->post('id_user'),"SQLString");
if ($post_id_user!=$id_user) {$this->data['realt']="Время ожидания истекло. Войдите еще раз.";return;}

}

if ($id_user>0){
///// Если зарегистрированный пользователь добавляет объявление, то его сразу допускаем в sutki


}





//echo "ttytty";
$pend_id = (int)$CI->input->post('pend_id');  if ($pend_id==0) {
$str_add="произошла ошибка 1. Если она будет повторяться, сообщите о ней администратору сайта. info@neagent.by";
$this->data['realt']=$str_add;
$errstr.="Произошла ошибка"; return;}
$client_id = (int)$CI->input->post('client_id');
//echo ("cid=" . $client_id . ";");


if ($client_id==0) {
$str_add="произошла ошибка 2. Если она будет повторяться, сообщите о ней администратору сайта. info@neagent.by ";



 $config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to('info@neagent.by');
$CI->email->subject('ошибка 2');
$CI->email->message($pend_id);
$CI->email->send();





$this->data['realt']=$str_add;
$errstr.="Произошла ошибка"; return;
}


$srok = chkString($CI->input->post('srok'),"SQLString");
if ($srok==0) {
$str_add="произошла ошибка 3. Если она будет повторяться, сообщите о ней администратору сайта.";
$this->data['realt']=$str_add;
$errstr.="Произошла ошибка"; return;}

//echo ("4");	
	        $CI->db->limit(1);
			$CI->db->order_by("ad_id", "DESC");
			$CI->db->where('ad_id', $pend_id);
			$CI->db->from("realt_sutki_pending");
			$query = $CI->db->get();
			if ($query->num_rows() == 0 )
			{
				//$result =  false;
				$pending_id = -1;
			}
			else
			{
			
			foreach ($query->result() as $row){
			//	НА САМОМ ДЕЛЕ ТУТ ОДНАСТРОКА, так что пройдет только одна проверка
			$data = array(
			'ad_catid' => $row->ad_catid,
            'ad_title' => $row->ad_title,
            'ad_message' => $row->ad_message,
			'ad_price' => $row->ad_price,
			'ad_phones' => $row->ad_phones,
			'ad_contactname' => $row->ad_contactname,
			'ad_email' => $row->ad_email,
			'ad_pictures' => $row->ad_pictures
			);
			}
				//$result = $query->row_array();
			};


			
			
	/////echo ("5");		
			
			$CI->db->limit(1);
			$CI->db->order_by("id", "DESC");
			$CI->db->where('id', $client_id);
			$CI->db->from("fin_clients");
			$query = $CI->db->get();
			if ($query->num_rows() == 0 )
			{
				//$result =  false;
				$pending_id = -1;
			}
			else
			{
			
			foreach ($query->result() as $row){
			//	НА САМОМ ДЕЛЕ ТУТ ОДНАСТРОКА, так что пройдет только одна проверка
			$clientdata = array(
			'id' => $row->id,
            'firmname' => $row->firmname,
            'unp' => $row->unp,
			'juraddress' => $row->juraddress,
			'postaddress' => $row->postaddress,
			'sposob' => $row->sposob,
			'account' => $row->account,
			'bank' => $row->bank,
			'kod' => $row->kod,
			'phone' => $row->phone,
			'account' => $row->account,
			'bank' => $row->bank,
			);
			}
				//$result = $query->row_array();
			};
			
	
//echo ($CI->db->last_query());	
 //echo ($clientdata['id']);
 //print_r ($clientdata);
 $message="" ; 
 
 if ($id_user>0){
 $message .= "Заказ от старого клиента \r\n" ; 
}
 
 $message .="pend_id=$pend_id \r\n";
 $message .="client_id = ".  $client_id   ."\r\n";
 $message .="firmname = ".  $clientdata['firmname']   ."\r\n";
  
  
  
  
 
 $message .="srok=$srok \r\n";
 
 
 
 
 
 
 ////////////////////// в таблицу заказы
 
$data=array(
 	client_id	=>	 $client_id	, 	 	 	 	 	 
 	sutki_ad_id	=>		$pend_id ,	 	 	 	 	 	 
 	user_id	    =>	 	$juraddress ,	 	 	 	 
 	status		=>	 	1, 	 	 	 	 
    srok		=>		$srok	
)	;

if ($this->data['mlev']==4) {
echo('data767');
print_r($data);


}  
$CI->db->insert('fin_zakazy', $data);	
 
 
 //////////////////////////////
 
 
 
 
 
 
 
 
 
 
 
 $clientmessage ="Вы заказали размещение объявления на neagent.by. \r\n
 В ближайшее время заказ будет обработан и счет будет отправлен вам на этот адрес.
  \r\n
После оплаты счета вышлите квитанцию об оплате на email info@neagent.by, (или сообщите об оплате по телефону 8 029 164-14-19)
и для вас будут сгенерированы коды доступа, 
с помощью которых вы сможете активировать объявление. \r\n
Так же вы сможете редактировать объявление и добавлять фотографии.";
 
 
 
 // письмо клиенту
 $config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to($data['ad_email']);
$CI->email->subject('Ваше объявление на Neagent.by');
$CI->email->message($clientmessage);
$CI->email->send();
 
 
 
 
 
 
 
 
 
 
 
 $config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to('dakh@mail.ru');
$CI->email->subject('Заказ на Neagent.by');
$CI->email->message($message);




$CI->email->send();


 
 
 
 
 
 
 
 
//$str_add .= $CI->parser->parse('realt_ad', $addata);
$str_add .= $CI->parser->parse('realt_ad_step4', $data);
$this->data['realt']=$str_add;
return;	
		










break;
default:



saveLog('dobavlenie_objavlenij', 'НАЧАЛО Пользователь зашел на страницу. Показываем форму');



//echo(98989); 
if ($CI->data['new_uid']==991&&$CI->data['user_uid']!=""){
// нет кукисов
$this->data['realt']="
<h1> Включите пожалуйста Cookies</h1><p>Обнаружено, что у вас отключены Cookies (куки). Пожалуйста, включите их, без них сайт работает в ограниченном режиме, 
и вы не можете пользоваться некоторыми сервисами.</p><p>Вы также можете дать объявление, написав нам на email: info@neagent.by </p><h2>Несколько слов о Cookie</h2><p>Cookie — это небольшая порция текстовой информации, которую сервер передает браузеру. Когда пользователь обращается к серверу (набирает его адрес в строке браузера), сервер может считывать информацию, содержащуюся в cookies, и на основании ее анализа совершать какие-либо действия. Например, в случае авторизованного доступа к чему-либо через веб, в cookies сохраняются логин и пароль в течение сессии, что позволяет пользователю не вводить их снова при запросах каждого документа, защищенного паролем.
</p><p>Как включить куки</p><p><h3>Internet Explorer 6 и выше:</h3>В меню браузера Сервис (Tools) выберите пункт Свойства обозревателя (Internet Options), откройте вкладку Конфиденциальность (Privacy) и нажмите на кнопку Дополнительно (Advanced). В окне Дополнительные настройки конфиденциальности (Advanced Privacy Settings) установите флажок Перекрыть автоматическую обработку файлов cookie (Override automatic cookie handling) и выберите оба пункта Принимать (Accept), нажмите кнопку OK в окне Дополнительные параметры конфиденциальности (Advanced Privacy Settings) и на кнопку OK в окне Свойства обозревателя (Internet Options). 
<h3>Mozilla Firefox 2.0:</h3>В меню Инструменты (Tools) выберите пункт Настройки (Options). Перейдите в раздел Конфиденциальность (Privacy) и в блоке Cookies установите флажок Принимать cookies с сайтов (Accept cookies from sites). Нажмите на кнопку Исключения (Exceptions) и убедитесь, что адрес сайта, с которого необходимо принимать cookies, не заблокирован.<h3>Mozilla Firefox 3.0 и выше:</h3>В меню Инструменты (Tools) выберите пункт Настройки (Options). Перейдите в раздел Приватность (Privacy) и выберите из выпадающего списка Firefox будет запоминать историю. Нажмите на кнопку ОК.<h3>Opera 9.x:</h3>В меню Инструменты (Tools) выберите пункт Настройки (Preferences) и перейдите на вкладку Дополнительно (Advanced). Выберите пункт меню Cookies и установите Принимать cookies (Accept cookies).
<h3>Opera 10.x:</h3>В меню выберите пункт Натройки (Settings), перейдите в раздел Общие настройки (Preferences), а затем на вкладку Расширенные (Advanced). Выберите пункт меню Cookies и установите Принимать cookies (Accept cookies).
<h3>Safari 3.x для Windows</h3>В меню Safari выберите пункт Настройки (Preferences). Перейдите на вкладку Безопасность (Security) и в блоке Принимать Cookies (Accept Cookies) выберите пункт Всегда (Always).
";
return;
}
// конец кукисы



$addata['tt']="jj";// это чтоб пустой параметр не передавать 
//$str_add .=$CI->parser->parse('realt_add_form', $addata);
//$str_add .= file_get_contents(MODPATH.'Realt/views/realt_add_form'.EXT); // берем просто готовую форму


$addata = array(
'ad_id' => "-",
'ad_postdate' => "000",
'ad_price' => "333",
'ad_mlev' => 0,
'mlev' => 0
	             );
				 
if ($CI->data['mlev']==4) {
//print_r($addata);
//echo('data7987');
}  				 
				 
$addata['mlev']= $this->data['mlev'];



$user = $CI->connect->get_current_user();
$username =  $user['username'];
$id_user =  $user['id_user'];
$userGroupID=$user['id_group'];

if ($id_user>1) {
$addata['id_user']= $id_user;
$addata['username']= $username;
$addata['userGroupID']= $userGroupID;
}
$addata['evc']= $_COOKIE["evc"];



//////////////



$sstr="";

for ($k = 0; $k < count($this->data['cityuriArr']); $k++) {
$sstr .=   "<OPTION value=" .$this->data['cityidArr'][$k] . " >". $this->data['citynameArr'][$k]. "</OPTION>";
}

$cstr="";
for ($k = 0; $k < count($this->data['realt_cats']); $k++) {
$cid=$this->data['realt_cats'][$k]['id'];
//echo ("Выбранный сat=" . $cid);
for ($h = 0; $h < count($this->data['realt_subcats']); $h++) {
if ($this->data['realt_subcats'][$h]['parent']==$cid){
$cstr .=   "<OPTION value=" .$this->data['realt_subcats'][$h]['id'] . " >".  $this->data['realt_cats'][$k]['name'] . " » " . $this->data['realt_subcats'][$h]['name']. "</OPTION>";
}
}
}

 

$addata['cityes']= $sstr;
$addata['cats']= $cstr;

//////////////////




//echo( "00-". $this->data['adform_view']);

$addata['phone_verification']= $this->data['phone_verification'];


if ($this->data['phone_verification']==1) {

// если пользователь зарегистрирован и email подтвержден, то 
//если нет  -предупреждение
//print_r($user);



if ($user['id_user']>0){
$addata['userid']= $user['id_user'];
$addata['useremail']= $user['email'];
$addata['verification_cats']= config_item('realt_phone_verification_cats');


 
$str_add .= $CI->parser->parse($this->data['adform_view'], $addata);

if ($CI->data['mlev']==4) {
//echo('data++3');
}

}
else{

if ($this->data['wap_view']!=1){
$str_add .=$CI->parser->parse('realt_register_form', $addata);
}
else{
$str_add .=$CI->parser->parse('wap_realt_register_form', $addata);
}






}





}else{

//echo($this->data['$adform_view']);

$str_add .= $CI->parser->parse($this->data['adform_view'], $addata);

}





$this->data['realt']=$str_add;

}













}	
	
	
	
	
	}