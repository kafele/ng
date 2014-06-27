<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Ionize, creative CMS
 *
 * @package        Ionize
 * @author        Ionize Dev Team
 * @license        http://ionizecms.com/doc-license
 * @link        http://ionizecms.com
 * @since        Version 0.93
 */

// ------------------------------------------------------------------------

/**
 * FancyUpload Module Controller
 *
 * @package        Ionize
 * @subpackage    Modules
 * @category    Upload module
 * @author        Ionize Dev Team
 *
 */


class Realt extends Base_Controller
{
    var $mimes = array();


    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('realt');
    }


    function index()
    {
        //$sql = "SELECT * FROM ads ORDER BY ad_id DESC";
        //$query = $this->db->query($sql);
        //$answers = Array();
        // Используем метод result_array() который возвращает строку результата в виде массива

        $data['mytitle'] = "MYTITLE";

        $this->db->select('ad_id, ad_title, ad_message as allads');
        $this->db->from('ads');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $addata['ad_title'] = $row->ad_title;
            $addata['ad_message'] = $row->ad_message;
            $addata['ad_id'] = $row->ad_id;
            $this->load->view('realt_ad', $addata);


        }

        echo ($this->tag_definitions);


        $this->load->view('realt_ads', $data);

        //echo('ReAlt');

    }


    // ------------------------------------------------------------------------


    public function  logError()
    {
// Сохраняет ошибку яваскрипт в лог
//header("Content-Type: application/json"); 
        header("Accept-Charset: utf-8");
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = "";
        $text = $CI->input->post('text');
        $mess = $CI->input->post('mess');

        saveLog('dobavlenie_objavlenij', 'JS  ' . $mess . $text);


// если тел цифр скока надо, если он не зарегистрирован ни на кого, то привязать его к email 


        $json = '{
     "status": "error",
     "description":{
     "lang": "ru",
     "text": " "
     }
}';
///  записать в лог попытку
        echo ($json);
        return; // ошибка 


    }


    public function  testphone()
    {
//header("Content-Type: application/json"); 
        header("Accept-Charset: utf-8");
        
            $CI =& get_instance();
            $CI->load->library('parser');
         
        $user = "";
        $phone = "375297096944";
        $user = 111111;
        $phone = getonlydigits($phone);


        saveLog('verify_phone.txt', "Начало - тел. " . $phone);


// если тел цифр скока надо, если он не зарегистрирован ни на кого, то привязать его к email 

        if (preg_match("^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$^", $phone)) { // проверка - исправить 
            $rez = "true number";

            saveLog('verify_phone.txt', "тел прошел проверку " . $phone);
        } else {
            $rez = "false number";
            saveLog('verify_phone.txt', "тел не прошел проверку " . $phone);

            $json = '{
     "status": "error",
     "description":{
       "lang": "ru",
       "text": "Тел. должен быть в международном формате , например 375 29 111-11-11"
     }
}';
///  записать в лог попытку
            echo ($json);
            return; // ошибка 

        }


        $uid = $_COOKIE["uid"];
        $ip = $_SERVER["REMOTE_ADDR"];
        $userid = $user;


        if (phoneChecked($phone, $user) == true) {
            saveLog('verify_phone.txt', "тел уже подтвержден " . $phone);
            $json = '{
     "status": "ok-cheked",
     "description":{
       "lang": "ru",
       "text": "Этот телефон уже подтвержден вами ранее. Спасибо!"
     }
}';
///  записать в лог попытку
            echo ($json);
            return; // ошибка 

        }


        $sp = false;

        if ($sp) {

            saveLog('verify_phone.txt', "обнаружен спам " . $phone);
            $json = '{
     "status": "error",
     "description":{
       "lang": "ru",
       "text": "' . $sp . '"
     }
}';
///  записать в лог попытку
            echo ($json);
            return; // ошибка 
        }


        $code = generate_code(4);
        saveLog('verify_phone.txt', "сгенерирован код " . $code);

        $now = date("Y-m-d H:i:s", time());
//echo $now;

        $data = array(
            phone => $phone, uid => $uid,
            ip => $ip, user_id => $userid,
            date => $now, code => $code
        );


        $CI->db->insert('realt_phone_verification', $data);
        saveLog('verify_phone.txt', "вставлено в базу ");
        //echo $CI->db->_error_message();
        //echo $CI->db->last_query();
//и выслать смс
// если с этого кукиса еще  подтвердили сегодня
// если с этого ip еще не было  последние 2 часа


        $data = array(
            'http_username' => 'neagent',
            'http_password' => 'sms12431243',
            'Phone_list' => $phone,
            'Message' => 'Neagent.by KOD: ' . $code,
        );
        $req = "http://websms.ru/http_in5.asp";
        //$ret=  http_request(array('url'=>$req, 'method'=>'POST', 'data'=>$data)) ;
        //saveLog('verify_phone.txt', "сервер вернул = " .  $ret );


        $data2 = array(
            'user' => 'Minich',
            'password' => 'ERTs2444',
            'recipient' => '375297096944',
            'message' => 'test message',
            'sender' => 'neagent.by'
//'sender' => 'SMS-assist',

        );

        $dataem = array();


        //$sms_url='https://sys.sms-assistent.ru/api/v1/send_sms/plain?user=Minich&password=8Zc7A8zt&recipient='.$phone .'&message=' . 'Neagent.by KOD: ' . $code. '&sender=neagent.by';

        $zapros = 'user=Minich&password=ERTs2444&recipient=' . $phone . '&message=' . 'Neagent.by KOD: ' . $code . '&sender=neagent.by';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://userarea.sms-assistent.by/api/v1/send_sms/plain");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $zapros);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//- эт чтобы ответ в переменную приходил.
        $result = curl_exec($ch);
        saveLog('verify_phone.txt', "сервер sms-assistent.ru вернул = " . $result);


// if  ((int)$result<0){
        $CI =& get_instance();
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh2008@mail.ru');
        $CI->email->to('dakh@mail.ru');
        $CI->email->subject("СМС сервер вернул:" . $result . ";");
        $CI->email->message("Телефон пропущен без подтверждения. Нужно срочно пополнить счет");
        $CI->email->send();
// }


        if ($result == '-1') {
/////// Если кончились средства
            saveLog('verify_phone.txt', "КОНЧИЛИСЬ СРЕДСТВА! ТЕЛЕФОН ПРОПУЩЕН БЕЗ ПОДТВЕРЖД.  " . $phone);
            $json = '{
     "status": "ok-cheked",
     "description":{
      "lang": "ru",
       "text": "Этот телефон не требует подтверждения. Спасибо!"
     }
}';
///  записать в лог попытку
            echo ($json);
            return; // ошибка 
        }


// $req2="https://sys.sms-assistent.ru/api/v1/send_sms/plain";
// $ret2=  http_request(array('url'=>$sms_url, 'method'=>'GET', 'data'=>$data2)) ;


        //saveLog('verify_phone.txt', "вернули текст код отправлен "  );


        $json = '{
 "status": "ok",
 "description": {
    "lang": "ru",
    "text": "Код отправлен на ваш номер. id сообщения:' . $result . '"  
 }
}';


        echo ($json);
        return;

//echo("Код отправлен на номер " . $phone . " ))"  . $rez . "ret" . $phone . " " .$userid );


    }


	
	 public function  bling(  )
    {
	
 $url="http://bling.by/offers.yrl";
 $USD_KURS=9500;
  
  
  
if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }	
	
$xmlStr = file_get_contents($url);
$xml = new SimpleXMLElement($xmlStr);

$count=0;
foreach($xml->offer as $k=>$val){
$count= $count+1;
if ($count ==7 ){
exit;
}

 //foreach($xml->foo[0]->attributes() as $a => $b) {
 //   echo $a,'="',$b,"\"\n";
//}
$internal_id= $val->attributes()->{'internal-id'} ;


/* твои действия */
$type= $val -> type; // выведет http://
$property_type = $val -> {"property-type"}; // выведет http://
$category =  $val -> category  ."" ;
$url= $val -> url . "";
$date= $val-> {"last-update-date"}  ."";

//print_r($date  );
$locality_name= $val ->location -> {"locality-name"}  ."";
$address= $val ->location-> address  ."";
$phone= $val -> {"sales-agent"} ->{"phone"}   ; 


//$phone=$phone->phone;
//print_r($category  );
//print_r($property_type  . "" );
$price =   $val ->price->value;
$currency =   $val ->price->currency;
$description =   $val ->description;


$description =  str_replace("'","", $description);
$description =  str_replace('"',"", $description);











$rooms =   $val ->rooms;
$floor =   $val ->floor;
$floors_total =   $val ->{"floors-total"};

echo("+" . $phone);
echo("+" . $property_type);
echo("+" . $category);
echo("!" . $locality_name);
echo("!" . $date);

if ($type !='аренда' || $property_type!="жилая"||$category!='квартира'|| $locality_name!='Минск' ){
continue;
}
// все попадает в категорию сдаю.





if ( $this->offerExists($phone, $type, $category, $locality_name, $address, "bling.by" )){
continue;
}


 



if ($currency="USD"){
$default_price  = $price * $USD_KURS;
}



$enddate=date("Y-m-d H:i:s",time()+( 6*24*60*60)); // 15 дней

$data = array(
ad_message =>"" . $description . "", 
ad_title => $rooms . '-комнатная квартира, без посредников в Минске ',
ad_catid => '1',
ad_komnat => $rooms,
ad_price => $price,
ad_price_min => $price,
ad_price_max => $price,
ad_default_price  => $default_price,
ad_default_price_min => $default_price,
ad_default_price_max => $default_price,
ad_postdate => date("Y-m-d H:i:s") ,
ad_firstdate => date("Y-m-d H:i:s") ,
ad_enddate => $enddate ,
ad_email => "" ,
ad_phones => "" ,
ad_show => "" ,
ad_show => "1" ,
ad_uid => "bling.by" ,
ad_street => $address ,
ad_city => "1" ,
ad_url => 'partner_b' . $internal_id,
partner_link =>$url,
);

$CI->db->insert('--ads', $data);
echo 	($CI->db->last_query());
echo 	($CI->db->_error_message());

}

	}
	
	
	
	
	 public function  mmail(  )
    {


	
	if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
		
require("parseBSB.php");	
	
$host        = 'imap.mail.ru';
$port        =  993;
$login       = 'uchetonline@mail.ru';
$pass        = 'lufaulufauuM';
$param       = '/imap/ssl/novalidate-cert';
$folder      = 'INBOX';
if($mbox = imap_open("{"."{$host}:{$port}{$param}"."}$folder",$login,$pass)){
//    echo "Connectedn";
} else { exit ("Can't connect: " . imap_last_error() ."n");  echo "FAIL!n";  };
 
 $n = imap_num_msg($mbox);
 $messages_to_process = $n;
// echo "$n messages to read\n";
 $inbox=$mbox;
 /* grab emails */
	$emails = imap_search($inbox,'ALL', SE_UID);
 if($emails === false)
	{
		die('Could not perform imap search: '. imap_last_error());
	}
	// if argument is supplied, continue from requested point
	 // if($tocontinue != 0)
	 // {
	//	$tocontinue = array_search($tocontinue, $emails);
	 //	$messages_to_process = $num_mgs - $tocontinue;
	 // }
	$tocontinue=0;
	
	/* for every email... */
    //for($curid = $tocontinue; $curid < sizeof($emails); $curid++)
	for($curid = $tocontinue; $curid < sizeof($emails); $curid++)
    {
        // dirty code. does garbage cleaning every 15 iterations, otherwise script consumes HUGE amounts of memory
        if(version_compare(PHP_VERSION, '5.3.0', '>=') && $curid % 15 == 0)
        {
            imap_gc($inbox, IMAP_GC_ELT);
        }
 
        $email_number = $emails[$curid];
 
        // check every 90 iterations if imap is still alive, may be slow
        if($curid % 90 == 0 && !imap_ping ($inbox))
        {
            die("Imap is dead");
        }
 
 
 
        $rheaders = imap_fetchheader($inbox, $email_number, FT_UID);
        $pheaders = imap_rfc822_parse_headers($rheaders);
 
        // FIXME: wtf?!
        if(empty($pheaders->sender) && empty($pheaders->to))
        {
            echo "rh: "; print_r($rheaders); echo "\n";
            echo "ph: "; print_r($pheaders); echo "\n";
            echo "ib: "; print_r($inbox); echo "\n";
            printf("FAILURE: %d!\n", $email_number);
            continue;
        }
 
 //       printf("UID being processed: %s\n", $email_number);
 
        /* getting email subject, some dirty code, may be slow */
        $ft_subj = decodeHeader(imap_utf8($pheaders->subject));
        //$ft_subj = imap_utf8($pheaders->subject);
 
   //     print 'subj: ' . $ft_subj . "\n";
 
        /* getting email date */
        $ft_date = $pheaders->date;
   //     print 'date: ' . $ft_date . "\n";
 
        /* getting sender and recipients */
        if (!is_array($pheaders->sender) || count($pheaders->sender) < 1)
        {
 //           print_r($pheaders);
 //           printf("\n");
            die("Something is wrong with SENDER address\n");
        }
 
        $ft_sender = $pheaders->sender[0]->mailbox . "@" . $pheaders->sender[0]->host;
    //    print ' sender: ' . $ft_sender . "\n";
 
        // collect message recepients data (to, cc, bcc)
        $receivers = array();
        if (!is_array($pheaders->to) || count($pheaders->to) < 1)
        {
    //        print_r($pheaders);
    //        printf("\n");
            // die("Something is totally wrong with TO addresses\n"); // may happen when there's only CC address
        }
        if(is_array($pheaders->to))
        {
            $receivers = $pheaders->to;
        }
 
        if (isset($pheaders->cc) && is_array($pheaders->cc) && count($pheaders->cc) > 0)
        {
            $receivers = array_merge($receivers, $pheaders->cc);
        }
        if (isset($pheaders->bcc) && is_array($pheaders->bcc) && count($pheaders->bcc) > 0)
        {
            $receivers = array_merge($receivers, $pheaders->bcc);
        }
 
        foreach ($receivers as $id => $val)
        {
            // echo " to: " . $val->mailbox . "@" . $val->host . "\n";
            $receivers[$id] = $val->mailbox . "@" . $val->host;
        }
 
        /* make comma-separated list of recipients */
        $ft_receivers = implode(', ', $receivers);
   //     print "to: " . $ft_receivers . "\n";
 
        /* email body */
        $ft_data = $rheaders . imap_body($inbox,$email_number, FT_UID | FT_PEEK | FT_INTERNAL);
//$ft_data = base64_decode ( $ft_data);
 // $ft_data = decodeHeader(imap_utf8($ft_data));
 
$ft_body =  imap_body($inbox,$email_number, FT_UID | FT_PEEK | FT_INTERNAL);;
$ft_body = base64_decode ( $ft_body);

$emaildata=new parseBSB($ft_body); 
 
 print_r ($emaildata->items);
 
//  require("parseMail.php"); 
    // could be a bit more safety here: 
    // get the contents of the uploaded email file     
//    $mailtext=file_get_contents($_FILES['postfile']['tmp_name']); 
// $mailtext=$ft_data; 
    // parse that file 
 //   $email=new parseMail($mailtext); 

 
 
 
    // show the results (or do anything useful...) 
   // print_r($email);
 
 
 
 $ft_date_converted = date("Y-m-d g:i:s a", strtotime($ft_date));
 
 
 // echo("<textarea> $ft_body</textarea>");

 
        // /* inserting all collected values to database */
        // $query = "INSERT into `mailarch_def` (`from`, `to`, `subj`, `date`, `data`) VALUES (?,?,?,?,?)";
        // $stmt = mysqli_prepare($dblink, $query);
        // mysqli_stmt_bind_param($stmt, "sssss",
                               // $ft_sender,
                               // $ft_receivers,
                               // $ft_subj,
                               // $ft_date_converted,
                               // $ft_data
                               // );
 
 
        // /* execute prepared statement */
        // mysqli_stmt_execute($stmt);
 
        /* check result. in this case error is triggered mostly by unique keys in db. it is ok */
        //$aff_rows = mysqli_stmt_affected_rows($stmt);
       // ($aff_rows > 0) ? printf("%d Row inserted\n", $aff_rows) : printf("Duplicate or error.\n". mysqli_error($dblink)."\n");
 
      //  printf("%d Messages to process\n", $messages_to_process);
 
        /* close statement and connection */
      //  mysqli_stmt_close($stmt);
 
        /* WARNING! to remove processed messages uncomment the following line */
        //imap_delete($inbox, $email_number, FT_UID);
 
        /* this was a test, it should stay commented */
        //imap_setflag_full($inbox, $email_number, '\Deleted', FT_UID);
    }
 
	/* close connections */
	imap_close($inbox);
	// mysqli_close($dblink);
 
	exit('Done!');
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 


 
 
 
 
 
 
  //$mbox = imap_open("{pop.mail.ru/pop3:110}", "dakh@mail.ru", "lufaulufau");
  //$n = imap_num_msg($mbox);
 
//  $mbox = imap_open ("{imap.mail.ru:143}", "dakh@mail.ru", "lufaulufau")
//   or die("can't connect: " . imap_last_error());
 

 print_r( $mbox);
 
		
	}
	
	
	
	
	 public function  offerExists($phone, $type, $category, $locality_name, $address , $partner_uid  )
    {

	   echo("+++ ");
	
	if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
		
		
		
$error=0;	
		 switch ($type . "/" . $category) {
            case "аренда/квартира": // рубли 
                $catStr = "1";
                break;
			case "аренда/комната": // рубли 
                $catStr = "3";
                break;
			case "продажа/квартира": // рубли 
                $catStr = "13";
                break;
			default:
$error=1;			
		}		
				
		

		
		switch ($locality_name) {
            case "Минск": // рубли 
                $sityStr = 1;
                break;
			default: // рубли 
 
$error=1;	
		
		}
		
		
		
		$phoneStr= substr($phone, strlen($phone)-4, 4);
		$phoneStr=  str_replace('-', '',$phoneStr);
		echo ($phone . ">>" . $phoneStr . " " );
		if  (is_numeric($phoneStr) && strlen($phoneStr)==3){
		echo (" все ок с телефоном  ");
		}
		else{
		
		
		 return true; // ошибка поэтому типа существует , чтоб не записывалось 
		
		}
		
		
		
		
	if ($error==1){
	return true; // ошибка поэтому типа существует , чтоб не записывалось 
	}	
		
		
		
		
		
		if (strlen($address)>3 ){
		
		echo ("=======" . $address );
		
		$addressStr=   str_replace(',', ' ',$address);
		if (strpos($addressStr, " ") > 0) {
		$addressArr = explode(' ', $addressStr);
		$addressStr = $addressArr[0];
		}
		$CI->db->like('ad_street', $addressStr, 'after'); 
		
		
		
        // Produces: WHERE title LIKE 'match%'
		}
		
		
		
		
		$phoneStr2= substr($phoneStr, 0, 1) . " "  . substr($phoneStr, 1, 2) ;
		$phoneStr3= substr($phoneStr, 0, 1) . "-"  . substr($phoneStr, 1, 2) ;
		
		
		
		
		$where = "(ad_phones LIKE '%".$phoneStr."' OR ad_phones LIKE '%".$phoneStr2."' OR ad_phones LIKE '%".$phoneStr3."' )";
       $CI->db->where($where);
	   
	   
	  
	    
		   $timeout=date("Y-m-d H:i:s",time()-( 15*24*60*60)); // 15 дней 
 
           $CI->db->where('ad_postdate >', $timeout);
		
		
	   
	   
	$CI->db->where('ad_catid', $catStr);
	$CI->db->where('ad_komnat', $catStr);
	//$CI->db->where('ad_catid', $ad_id);
	$CI->db->where('ad_city', 1);   
	//
    $CI->db->from("ads");
	
	
       $query = $CI->db->get();
	    echo($CI->db->last_query());
       $co=  $query->num_rows();

	   
	   
      if ($co != 0) {
		 
              return true;
             
		}	
		else{
		return false;
		}

		
		
	}
	
	
	
	
 public function  validatephonenumber($phone)
    {
	// echo(55);
	//echo($phone);
	saveLog('validate_phone.txt', "++++ " );
	saveLog('verify_phone.txt', "validatePhoneNumber. " . $phone);
	// должен быть 375294850044
	
	if (strlen($phone) != 12){
	//echo('err!12');
	 saveLog('validate_phone.txt', "not 12: " . $phone);
	
    return false;
    }	
	
	$begin= substr ($phone,0, 6 );
	
	$os = array( 375447, 375445, 375444, 375299,375296,375293,375291,375336,375333,375298,375297,375295,	375292 , 375259, 375257, 375256, 375255,375339 );
saveLog('validate_phone.txt', " begin: " . $begin );	
if (in_array($begin, $os)) {
//echo('ok');
 saveLog('validate_phone.txt', "OK: " . $phone );
 return true;
}else{
//echo('err');
 saveLog('validate_phone.txt', "bad: " . $phone);
return false;
}
	

	return true;
	}
	
	
	
	public function to_rubric($rub,$id){
	if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
	
	
	$rub = (int)$rub;
	$id = (int)$id;
	if  ($id>0){
	
	
	
	
$table="ads";
$cat=$rub;



       $CI->db->where('ad_id', $id);
       $CI->db->from("ads");
       $query = $CI->db->get();
       $co= $query->num_rows();

        if ($co > 0) {
		
		foreach ($query->result() as $row) {
         $str = $row->ad_message;
         $city = $row->ad_city;
		}
}








	$title =  AutoTitle($table, $cat, $str, $city);
	

	
	
	
	
	
	$CI->db->where('ad_id', $id);
    $CI->db->set("ad_catid", $rub);
	$CI->db->set("ad_title", $title);
    $CI->db->update("ads");
echo('перемещено в рубрику ' . $rub . "<br> Заголовок: " . $title);
	}		
			
	}
	
	
    public function  verify_phone()
    {
//header("Content-Type: application/json"); 
        header("Accept-Charset: utf-8");
         
            $CI =& get_instance();
            $CI->load->library('parser');
         
        $user = "";
        $phone = $CI->input->post('phone');
        $user = $CI->input->post('user');
        $phone = getonlydigits($phone);


        saveLog('verify_phone.txt', "Начало - тел. " . $phone);


// если тел цифр скока надо, если он не зарегистрирован ни на кого, то привязать его к email 

 if (substr ($phone,0, 5 )=='37517'){
 $json = '{
     "status": "ok-cheked",
     "description":{
       "lang": "ru",
       "text": "Это городской телефон, он не требует подтверждения. Спасибо!"
     }
}';
  
            echo ($json);
            return; // ошибка

}
	
	

        if ($this->validatephonenumber($phone)) { // проверка  
            $rez = "true number";

            saveLog('verify_phone.txt', "тел прошел проверку " . $phone);
        } else {
            $rez = "false number";
            saveLog('verify_phone.txt', "тел не прошел проверку " . $phone);

            $json = '{
     "status": "error",
     "description":{
       "lang": "ru",
       "text": "Тел. должен быть в международном формате , например 375 29 111-11-11"
     }
}';
///  записать в лог попытку
            echo ($json);
            return; // ошибка 

        }


        $uid = $_COOKIE["uid"];
        $ip = $_SERVER["REMOTE_ADDR"];
        $userid = $user;


        if (phoneChecked($phone, $user) == true) {
            saveLog('verify_phone.txt', "тел уже подтвержден " . $phone);
            $json = '{
     "status": "ok-cheked",
     "description":{
       "lang": "ru",
       "text": "Этот телефон уже подтвержден вами ранее. Спасибо!"
     }
}';
///  записать в лог попытку
            echo ($json);
            return; // ошибка 

        }


        $sp = phonespam($phone, $uid, $ip, $userid);

        if ($sp) {

            saveLog('verify_phone.txt', "обнаружен спам " . $phone);
            $json = '{
     "status": "error",
     "description":{
       "lang": "ru",
       "text": "' . $sp . '"
     }
}';
///  записать в лог попытку
            echo ($json);
            return; // ошибка 
        }


		
		
		
	//// Если в черном списке телефон 	
$phone80 = str_replace("375", "80", $phone);
	    $bl = inBlackList($phone80);

		 saveLog('verify_phone.txt', "проверка в черном списке  " . $phone80);
		 saveLog('verify_phone.txt', "проверка в черном списке = " . $bl);
		 //return;
        if ($bl) {

            saveLog('verify_phone.txt', "обнаружен в черном списке " . $phone80);
            $json = '{
     "status": "error",
     "description":{
       "lang": "ru",
       "text": "Ждите смс с кодом подтверждения."
     }
}';
///  записать в лог попытку
            echo ($json);
            return; // ошибка 
        }	
		
		
		
		
		
		
		
		
		
		
		
        $code = generate_code(4);
        saveLog('verify_phone.txt', "сгенерирован код " . $code);

        $now = date("Y-m-d H:i:s", time());
//echo $now;

        $data = array(
            phone => $phone, uid => $uid,
            ip => $ip, user_id => $userid,
            date => $now, code => $code
        );


        $CI->db->insert('realt_phone_verification', $data);
        saveLog('verify_phone.txt', "вставлено в базу ");
        //echo $CI->db->_error_message();
        //echo $CI->db->last_query();
//и выслать смс
// если с этого кукиса еще  подтвердили сегодня
// если с этого ip еще не было  последние 2 часа


        $data = array(
            'http_username' => 'neagent',
            'http_password' => 'sms12431243',
            'Phone_list' => $phone,
            'Message' => 'Neagent.by KOD: ' . $code,
        );
        $req = "http://websms.ru/http_in5.asp";
        //$ret=  http_request(array('url'=>$req, 'method'=>'POST', 'data'=>$data)) ;
        //saveLog('verify_phone.txt', "сервер вернул = " .  $ret );


        $data2 = array(
            'user' => 'Minich',
            'password' => 'ERTs2444',
            'recipient' => '375297096944',
            'message' => 'test message',
            'sender' => 'neagent.by'
//'sender' => 'SMS-assist',

        );

        $dataem = array();


// $sms_url='https://sys.sms-assistent.ru/api/v1/send_sms/plain?user=Minich&password=8Zc7A8zt&recipient='.$phone .'&message=' . 'Neagent.by KOD: ' . $code. '&sender=neagent.by';


        $zapros = 'user=Minich&password=ERTs2444&recipient=' . $phone . '&message=' . 'Neagent.by KOD: ' . $code . '&sender=neagent.by';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://userarea.sms-assistent.by/api/v1/send_sms/plain");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $zapros);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//- эт чтобы ответ в переменную приходил.
        $result = curl_exec($ch);
        saveLog('verify_phone.txt', "сервер sms-assistent.ru вернул = " . $result);


        if ((int)$result < 0) {
            $CI =& get_instance();
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $CI->load->library('email', $config);
            $CI->email->set_newline("\r\n");
            $CI->email->from('dakh2008@mail.ru');
            $CI->email->to('dakh@mail.ru');
            $CI->email->subject("СМС сервер вернул ошибку:" . $result . ";");
            $CI->email->message("Телефон пропущен без проверки. Срочно оплатить за смс сервис");
            $CI->email->send();
        }


        if ($result == -1) {
/////// Если кончились средства
            saveLog('verify_phone.txt', "КОНЧИЛИСЬ СРЕДСТВА! ТЕЛЕФОН ПРОПУЩЕН БЕЗ ПОДТВЕРЖД.  " . $phone);

            $CI->db->where('phone', $phone);
            $CI->db->where('user_id', $user);
            $CI->db->set("kod_entered", 2);
            $CI->db->update("realt_phone_verification");
            saveLog('verify_phone.txt', "тел разрешен без ввода кода " . $code . "  " . $phone);


            $json = '{
     "status": "ok-cheked",
     "description":{
     "lang": "ru",
     "text": "Этот телефон не требует подтверждения. Спасибо!"
     }
}';
///  записать в лог попытку
            echo ($json);
            return; // ошибка 
        }


        //$req2="https://sys.sms-assistent.ru/api/v1/send_sms/plain";
        //$ret2=  http_request(array('url'=>$sms_url, 'method'=>'GET', 'data'=>$data2)) ;
        //saveLog('verify_phone.txt', "сервер sms-assistent.ru вернул = " .  $ret2 ); 


        //saveLog('verify_phone.txt', "вернули текст код отправлен "  );


        $json = '{
 "status": "ok",
 "description": {
    "lang": "ru",
    "text": "Код отправлен на ваш номер"
 }
}';


        echo ($json);
        return;

//echo("Код отправлен на номер " . $phone . " ))"  . $rez . "ret" . $phone . " " .$userid );


    }

function chkSpam($str)
{
    $str = " " . $str;
    $spwords = split("\|", trim(config_item('realt_spamwords')));

    for ($i = 0; $i < (count($spwords)); $i++) {
        if (strlen($spwords[$i]) > 2) {
            if (strpos(strtolower($str), strtolower($spwords[$i]))) {


                $ip = $_SERVER["REMOTE_ADDR"];
                $refer = strtolower($_SERVER['HTTP_REFERER']);
                $CI =& get_instance();
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $CI->load->library('email', $config);
                $CI->email->set_newline("\r\n");
                $CI->email->from('dakh2008@mail.ru');
                $CI->email->to('dakh2008@mail.ru');
                $CI->email->subject('spam detected');
                $CI->email->message('спам=' . $spwords[$i] . "; текст=" . $str . "; uid=" . $CI->data['user_uid'] . "; ip=" . $ip . "refer=$refer; new_uid=" . $CI->data['new_uid'] . "; uic=" . $CI->data['user_uic']);
                $CI->email->send();


                return true;
            }
        }
    }

    return false;
}



    public function  do_verify_phone()
    {
         
            $CI =& get_instance();
            $CI->load->library('parser');
         

        $phone = $CI->input->post('phone');
        $phone = getonlydigits($phone);


        $code = $CI->input->post('code');
        $user = $CI->input->post('user');
        $uid = $_COOKIE["uid"];
        $ip = $_SERVER["REMOTE_ADDR"];
        $userid = $user;

        saveLog('verify_phone.txt', "начало проверки кода " . $phone);

        $CI->db->select('*');
        $CI->db->where('phone', $phone);
        $CI->db->where('user_id', $user);
        $CI->db->from('realt_phone_verification');
        $query = $CI->db->get();
        //echo $CI->db->_error_message();
        //echo $CI->db->last_query();


        if ($query->num_rows() == 0) {

            saveLog('verify_phone.txt', "неверный код введен " . $code . "  " . $phone);

            $json = '{
     "status": "error",
     "description":{
       "lang": "ru",
       "text": "Ошибка , код неверный"
     }
}';
            echo ($json);
            return;

        } else {

            foreach ($query->result() as $row) {


                if (strtolower($row->code) == strtolower($code)) {

                    $CI->db->where('phone', $phone);
                    $CI->db->where('user_id', $user);
                    $CI->db->set("kod_entered", 1);
                    $CI->db->update("realt_phone_verification");

                    saveLog('verify_phone.txt', "тел подтвержден " . $code . "  " . $phone);

                    $json = '{
     "status": "ok",
     "description":{
       "lang": "ru",
       "text": "Телефон успешно подтвержден"
     }
}';
                    echo ($json);
                    return;


                }


            }
        }


        $json = '{
     "status": "error",
     "description":{
       "lang": "ru",
       "text": "Ошибка! код неверный"
     }
}';
        echo ($json);
        return;


    }


    public function letterToUp()
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
//$sql="SELECT * FROM ads WHERE ad_show=1   and  ad_catid=2  ORDER BY ad_postdate desc  limit 150";
        $sql = "SELECT * FROM (ads) WHERE `ad_city` = 1 AND `ad_catid` = '2' ORDER BY ad_up_date desc, ad_postdate desc LIMIT 39, 90";
        $query = $CI->db->query($sql);

        if ($query->num_rows() == 0) {
            echo 'Не найдено объявлений';
        } else {
            $adtodelete = $query->num_rows();
            $i = 39;
            foreach ($query->result() as $row) {
                $i = $i + 1;
                $data = array();
                $data['ad_id'] = $row->ad_id;
                $data['ad_email'] = $row->ad_email;
                $data['ad_contactname'] = $row->ad_contactname;
                $data['ad_url'] = "http://neagent.by/snimu/" . $row->ad_url;
                $data['ad_message'] = $row->ad_message;
                $data['ad_firstdate'] = $row->ad_firstdate;
                $data['ad_position'] = $i;
                $data['ad_page'] = (int)($i / 13);
                if (!$this->adLetterUpsent($data['ad_id'])) {
                    $letter = $CI->parser->parse('emails/letter_to_up', $data);
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $config['mailtype'] = 'html';
                    $CI->load->library('email', $config);
                    $CI->email->set_newline("\r\n");
                    $CI->email->from('info@neagent.by');
                    $CI->email->to($data['ad_email']);
//$CI->email->bcc("dakh@mail.ru");
                    $CI->email->subject('Neagent.by - Сделайте ваше объявление заметным!');
                    $CI->email->message($letter);
                    $CI->email->send();


                    $ins = array(
                        ad_id => $data['ad_id']
                    );

                    $CI->db->insert('letters_sent', $ins);


                }


            }

        }


    }


    function adLetterUpsent($id)
    {
        if (!$CI) {
            $CI =& get_instance();
        }
        $CI->db->where("ad_id", $id);
        $CI->db->from("letters_sent");
        $query = $CI->db->get();

        if ($query->num_rows() == 0) {

            return false;
        } else {
            return true;

        }


    }


    public function deleteOldAds()
    {
        if (!$CI) {
            $CI =& get_instance();
        }
        $sql = "SELECT * FROM ads WHERE ad_show=1   and  ad_up_date = '0000-00-00 00:00:00' and ad_enddate < NOW()  ORDER BY ad_postdate desc  limit 50";
// тут не затрагиваются поднятые объявления 
        $query = $CI->db->query($sql);
// echo ($CI->db->last_query());

        if ($query->num_rows() == 0) {
            echo 'Не найдено объявлений';
        } else {
            $adtodelete = $query->num_rows();
            foreach ($query->result() as $row) {
                $ad_id = $row->ad_id;
                $ad_srok = $row->ad_srok;
                $ad_postdate = $row->ad_postdate;
                $ad_email = $row->ad_email;

                $data = array('ad_show' => '0',
                    'ad_delete_reazon' => '1',
                );


                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $CI->load->library('email', $config);
                $CI->email->set_newline("\r\n");
                $CI->email->from('info@neagent.by');
                $CI->email->to($ad_email);


                $CI->email->subject('Neagent.by - срок публикации вашего объявления закончился.');
                $CI->email->message('Ваше объявление ' . $ad_id . ' удалено в связи с окончанием срока публикации. Если необходимо, дайте объявление еще раз.');
                $CI->email->send();
                echo $CI->email->print_debugger();


                $CI->db->where('ad_id', $ad_id);
                $CI->db->update('ads', $data);
                echo $CI->db->last_query();


            }
        }


        if (!$CI) {
            $CI =& get_instance();
        }
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh@mail.ru');
        $CI->email->to('dakh@mail.ru');
        $CI->email->subject('Удалены старые объявы');
        $CI->email->message('удалено ' . $adtodelete . "объявлений");
        $CI->email->send();


    }

	
	
	
	
	
	
	
	
	
	
	
	
	public function cancelSutkiUp()
    {
        if (!$CI) {
            $CI =& get_instance();
        }
		
		$sql = "UPDATE `sutki` SET `ad_up_date` = '0000-00-00 00:00:00'  where  `ad_up_date` > '0000-00-00 00:00:00' and `ad_up_date` < NOW()  - INTERVAL 6 DAY limit 100";
		$CI->db->query($usql);

 echo $CI->db->_error_message();
 echo $CI->db->last_query();
		
		
		
    }
	
	
	
	
	
	
	
	
	
	
	
	
	

    function filesUsedList()
    {
        if (!$CI) {
            $CI =& get_instance();
        }

//если есть в пендинг, то попросить удалить 
        $CI->db->select('*');
        $CI->db->from('realt_sutki_pending');
        $query = $CI->db->get();
        if ($query->num_rows() != 0) {
            echo("есть необработанные заказы! Скрипт прерван");
            exit;
        }

        $CI->db->select('*');
        $CI->db->where('ad_pending', 1);
        $CI->db->from('ads');
        $query = $CI->db->get();
        if ($query->num_rows() != 0) {
            echo("есть объявления на модерации! Скрипт прерван");
            exit;
        }


        $picsArr = array();

        $CI->db->select('*');
        $names = array('');
        $CI->db->where('ad_show', "1");
        $CI->db->where_not_in('ad_pictures', $names);
//$CI->db->where ('ad_pictures', "".$cat_id."");
//$CI->db->order_by("ad_id", "desc");
        $CI->db->from('ads');
        $query = $CI->db->get();

        if ($query->num_rows() == 0) {
            echo("не найдено! Скрипт прерван");
            echo     ($CI->db->last_query());
            exit;
        }

        foreach ($query->result() as $row) {
            $pic = $row->ad_pictures;
            $ad_pictures = explode("; ", $pic);
            for ($i = 0; $i < count($ad_pictures); $i++) {
                array_push($picsArr, $ad_pictures[$i]);
                array_push($picsArr, "t_" . $ad_pictures[$i]);
            }
        }

        $CI->db->select('*');
        $names = array('');
        $CI->db->where_not_in('ad_pictures', $names);
        $CI->db->where('ad_show', "1");
//$CI->db->where ('ad_pictures', "".$cat_id."");
//$CI->db->order_by("ad_id", "desc");
        $CI->db->from('sutki');
        $query = $CI->db->get();
        foreach ($query->result() as $row) {
            $pic = $row->ad_pictures;
            $ad_pictures = explode("; ", $pic);
            $mainpic = $row->ad_mainpic;
//$mainpic=str_replace ("http://neagent.by/themes/neagent_style/assets/images/", "",  $mainpic); 
            for ($i = 0; $i < count($ad_pictures); $i++) {
                array_push($picsArr, $ad_pictures[$i]);
                array_push($picsArr, "t_" . $ad_pictures[$i]);
            }
// и добавляем главную картинку
            array_push($picsArr, $mainpic);

        }


        return $picsArr;

//print_r ($picsArr);


    }


    public function deleteOldPictures()
    {

        if (!$CI) {
            $CI =& get_instance();
        }


//если есть в пендинг, то попросить удалить 
        $CI->db->select('*');
        $CI->db->from('realt_sutki_pending');
        $query = $CI->db->get();
        if ($query->num_rows() != 0) {
            echo("есть необработанные заказы! Скрипт прерван");
            exit;
        }

        $CI->db->select('*');
        $CI->db->where('ad_pending', 1);
        $CI->db->from('ads');
        $query = $CI->db->get();
        if ($query->num_rows() != 0) {
            echo("есть объявления на модерации! Скрипт прерван");
            exit;
        }


        $usedfilesArr = $this->filesUsedList();


        $dir = $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/files';

//$dir = "./";   //задаём имя директории
        if (is_dir($dir)) { //проверяем наличие директории
            $files = scandir($dir); //сканируем (получаем массив файлов)
            array_shift($files); // удаляем из массива '.'
            array_shift($files); // удаляем из массива '..'
            $max = sizeof($files);
            $max = 1000;
            //  for($i=0; $i<sizeof($files); $i++)
            for ($i = 0; $i < $max; $i++) {


                $filename = $files[$i];


                if (!in_array($filename, $usedfilesArr)) {
                    echo "; Удалено " . $filename;

                    copy($dir . "/" . $filename, $dir . "/del/" . $filename);
                    unlink($dir . "/" . $filename);


                } else {

                    echo "; оставить" . $filename;
                }


                // echo '-файл: <a href="'.$dir.$files[$i].'" title="открыть/скачать файл или страницу">'.$files[$i].'</a>;<br>';  //выводим все файлы


            }

        } else echo $dir . ' -такой директории нет;<br>';
		
		
		
		
		///////// ОБРАБАТЫВАЕМ ДИРЕКТОРИЮ TEMP
		
		$dir = $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/files/tmp';

//$dir = "./";   //задаём имя директории
        if (is_dir($dir)) { //проверяем наличие директории
            $files = scandir($dir); //сканируем (получаем массив файлов)
            array_shift($files); // удаляем из массива '.'
            array_shift($files); // удаляем из массива '..'
            $max = sizeof($files);
            $max = 400;
            //  for($i=0; $i<sizeof($files); $i++)
            for ($i = 0; $i < $max; $i++) {

                $filename = $files[$i];
 echo "; Удалено " . $filename;
                    unlink($dir . "/" . $filename);




            }

        } else echo $dir . ' -такой директории нет;<br>';
		
		
		
		$dir = $_SERVER['DOCUMENT_ROOT'] . '/modules/Catalog/temp';
		$this->deleteTempFiles($dir);
		
		


    }
	
	
	
	
	
	
	
	
	
	
	 public function deleteTempFiles($dir)
    { //////// например $dir = $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/files';
echo ("<br>Удаляем файлы catalog </br>");
        if (!$CI) {
            $CI =& get_instance();
        }
 

		///////// ОБРАБАТЫВАЕМ ДИРЕКТОРИЮ TEMP
		//$dir = $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/files/tmp';
//$dir = "./";   //задаём имя директории
        if (is_dir($dir)) { //проверяем наличие директории
            $files = scandir($dir); //сканируем (получаем массив файлов)
            array_shift($files); // удаляем из массива '.'
            array_shift($files); // удаляем из массива '..'
            $max = sizeof($files);
            $max = 400;
            //  for($i=0; $i<sizeof($files); $i++)
            for ($i = 0; $i < $max; $i++) {

                $filename = $files[$i];
 echo "; Удалено " . $filename;
                    unlink($dir . "/" . $filename);


            }

        } else echo $dir . ' -такой директории нет;<br>';
		
    }
	
	
	
	
	
	
	
	
	


    public function cron()
    {


        refresh_vip_cash();

        refresh_realt_cash();
        $this->deleteOldAds();
        $this->cancelSutkiUp();

        if (!$CI) {
            $CI =& get_instance();
        }
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh@mail.ru');
        $CI->email->to('dakh@mail.ru');
        $CI->email->subject('cron');
        $CI->email->message('cron' . $ad_id);
//$CI->email->send();

    }


    public function getpointsXML()
    {
        header('Content-type: application/xml; charset=utf-8');
        if (!$CI) {$CI =& get_instance();}
		
        parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		
		
 return;
		
       
   
   

		if ($_GET["ads"]){
		$adsstr=$_GET["ads"];
		$table = ($_GET["table"])?$_GET["table"]:"ads";
		 
		$ads=explode(",", $adsstr);
		
		 
        $CI->db->select('*');
        $CI->db->from($table);
        $CI->db->where_in("ad_id", $ads);
        $query = $CI->db->get();
		
		
		
		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('info@neagent.by');
        $CI->email->to('sergej-minich@yandex.by');
        $CI->email->subject('----LAST-----');
		
	$lq= $CI->db->last_query() ;
		
        $CI->email->message( $lq . $adsstr);
   //$CI->email->send();
		
		
		
		
		}
		else{
		
        $params = array(
            'name' => $_GET["name"],
            'sity' => $_GET["sity"],
            'rooms' => $_GET["rooms"],
            'prType' => $_GET["prType"],
            'formType' => $_GET["formType"],
            'priceMin' => $_GET["priceMin"],
            'priceMax' => $_GET["priceMax"],
            'withcontent' => $_GET["withcontent"],
            'postdate' => $_GET["postdate"],
            'cat' => $_GET["cat"]
        );
        	

        $str = "sity= " . $_POST["sity"];
//$params['sity'] = 9;

        $query = searchQuery($params);
}
		 //$sqq = serialize($query);
		 //$handle = fopen($this->config->item('module_path') . 'Realt/config/quer222.txt', "a+");
		 //fwrite($handle, $sqq ."\r\n");
		//if (!write_file($this->config->item('module_path') . 'Realt/config/quer.txt', $sqq)) {
        //}
		
		

		
        //echo ("NUM=" . $query->num_rows());
        //header('Content-type: application/xml; charset=utf-8');	
        //header('Content-type: text/xml; charset=utf-8');
        //header("Content-Type: text/xml");
        //header('Content-Type: application/rss+xml');
        //header('Content-Type: application/xhtml+xml');

//header('Content-Type: text/xml');
//header("Cache-Control: no-cache, must-revalidate");
//header("Pragma: no-cache");
//header("Content-Type: application/json"); 
//header("Accept-Charset: utf-8");
//header('Content-Type: text/xml; charset=utf-8', TRUE);


        //< ?xml version="1.0" encoding="UTF8" standalone="yes" ? >

        $str = '<?xml version="1.0" encoding="utf-8"?>
<pointsGroup>
<title>Текущие предложения</title>
<description>Текущие предложения на neagent.by</description>
<northEastLng>82.88440320301</northEastLng>
<northEastLat>54.941776872378</northEastLat>
<southWestLng>82.999409484887</southWestLng>
<southWestLat>55.049152648577</southWestLat>
';
        if ($query->num_rows() == 0) {
            $str .= '</pointsGroup>
</xml>';
        }

        $oo = 0;
        foreach ($query->result() as $row) {
            $oo = $oo + 1;

            $ad_id = $row->ad_id;
            $ad_komnat = $row->ad_komnat;
			 
			$ad_dom = str_replace('"', "", $row->ad_dom);
            $ad_street = str_replace('"', "", $row->ad_street);
            $ad_price = $row->ad_price;
            $ad_url = $row->ad_url;
            $longitude = (float)$row->longitude;
            $latitude = (float)$row->latitude;

            if ($_GET["cat"] == 11) {
                $urlsuff = "nasutki/";
            } else {
                $urlsuff = "sdayu/";
            }
            ;


            if ($longitude > 0) {

                $str .= '<point offers="1" street="' . $ad_street . '" number="' . $ad_dom . '" latitude="' . $latitude . '" longitude="' . $longitude . '">
<offer id_ad="' . $ad_id . '" rooms="' . $ad_komnat . '" price="' . $ad_price . '" url="' . $urlsuff . $ad_url . '">' . $oo . '</offer>
</point>
';
            }


        }


        $str .= '</pointsGroup>';


		
		
        echo $str;
		
		//if (!write_file($this->config->item('module_path') . 'Realt/config/all.txt', $str)) {};
		
		


    }


    public function getadspointsXML()
    {
        //для андроид 
        header('Content-type: application/xml; charset=utf-8');
        if (!$CI) {
            $CI =& get_instance();
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);


        $params = array(
            'name' => $_GET["name"],
            'sity' => $_GET["sity"],
            'rooms' => $_GET["rooms"],
            'prType' => $_GET["prType"],
            'formType' => $_GET["formType"],
            'priceMin' => $_GET["priceMin"],
            'priceMax' => $_GET["priceMax"],
            'withcontent' => $_GET["withcontent"],
            'postdate' => $_GET["postdate"],
            'cat' => $_GET["cat"]
        );
        //echo("++");	
        // print_r($params);	

        $str = "sity= " . $_POST["sity"];


        $query = searchQuery($params);

        //echo ("NUM=" . $query->num_rows());
        //header('Content-type: application/xml; charset=utf-8');	
        //header('Content-type: text/xml; charset=utf-8');
        //header("Content-Type: text/xml");
        //header('Content-Type: application/rss+xml');
        //header('Content-Type: application/xhtml+xml');

//header('Content-Type: text/xml');
//header("Cache-Control: no-cache, must-revalidate");
//header("Pragma: no-cache");
//header("Content-Type: application/json"); 
//header("Accept-Charset: utf-8");
//header('Content-Type: text/xml; charset=utf-8', TRUE);


        //< ?xml version="1.0" encoding="UTF8" standalone="yes" ? >

        $str = '<?xml version="1.0" encoding="utf-8"?>
<pointsGroup>
<title>Текущие предложения</title>
<description>Текущие предложения на neagent.by</description>
<northEastLng>82.88440320301</northEastLng>
<northEastLat>54.941776872378</northEastLat>
<southWestLng>82.999409484887</southWestLng>
<southWestLat>55.049152648577</southWestLat>
';
        if ($query->num_rows() == 0) {
            $str .= '</pointsGroup>
</xml>';
        }

        $oo = 0;
        foreach ($query->result() as $row) {
            $oo = $oo + 1;

            $ad_id = $row->ad_id;
            $ad_komnat = $row->ad_komnat;
            $ad_street = str_replace('"', "", $row->ad_street);
            $ad_price = $row->ad_price;
            $ad_url = $row->ad_url;
            $ad_date = $row->ad_date;
            $longitude = (float)$row->longitude;
            $latitude = (float)$row->latitude;
            $ad_message = $row->ad_message;
//$pin = "green_Marker".$oo.".png";
            $pin = '';
            if ($_GET["formType"] == "su") {
                $pin = "pin_" . $ad_komnat . "_" . $ad_price . '.png';
            }


            if ($_GET["cat"] == 11) {
                $urlsuff = "nasutki/";
            } else {
                $urlsuff = "sdayu/";
            }
            ;


            if ($longitude > 0) {

                $str .= '<point offers="1" street="' . $ad_street . '" number="" latitude="' . $latitude . '" longitude="' . $longitude . '">
<offer id_ad="' . $ad_id . '" rooms="' . $ad_komnat . '" price="' . $ad_price . '" url="' . $urlsuff . $ad_url . '">' . $oo . '</offer>
<message>' . $ad_message . '</message>
<price>' . $ad_price . '</price>
<komnat>' . $ad_komnat . '</komnat>
<phone>' . $ad_phone . '</phone>
<longitude>' . $longitude . '</longitude>
<latitude>' . $latitude . '</latitude>
<street>' . $ad_street . '</street>
<date>' . $ad_date . '</date>
<link>' . $ad_url . '</link>
<pin>' . $pin . '</pin>
</point>
';
            }


        }


        $str .= '</pointsGroup>';


        echo $str;


    }


    function getarea($cityId = "1")
    {


        if (!$CI) {
            $CI =& get_instance();
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        }


        $areas = array('Центральный р-н', 'Советский р-н', 'Первомайский р-н', 'Партизанский р-н',
            'Заводской р-н', 'Ленинский р-н', 'Октябрьский р-н', 'Московский р-н', 'Фрунзенский р-н');

        $areasId = array('1', '2', '3', '4',
            '5', '6', '7', '8', '9');


        $subareas = array('Ангарская', //1
            'Брилевичи ', //2
            'Великий лес', //3
            'Веснянка', //4
            'Восток', //5
            'Грушевка', //6
            'Домбровка', //7
            'Дражня', //8
            'Запад', //9
            'Зелёный Луг', //10
            'Каменная Горка', //11
            'Красный Бор', //12
            'Кунцевщина', //13
            'Курасовщина', //14
            'Лошица', //15
            'Малиновка', //16
            'Масюковщина', //17
            'Михалово', //18
            'Новинки', //19
            'Петровщина', //20
            'Ржавец', //21
            'Северный поселок', //22
            'Серебрянка', //23
            'Сокол', //24
            'Сосны', //25
            'Степянка', //26
            'Сухарево', //27
            'Уручье', //28
            'Шабаны', //29
            'Чижовка', //30
            'Юго-Запад');


        $subareasId = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14',
            '15', '16', '17', '18', '19', '20', '21', '22',
            '23', '24', '25', '26', '27', '28', '29', '30', '31');


        $str .= '
 <div class="shadow"  id="shadow" > </div>  
          <div class="canvas"  id="canvas" >
            <table cellpadding="5"  class="panel" >
              <tbody>
                <tr valign="top" >
                  <td>
                    ';


        if (4 == 4) {
            $str .= '<div id="showarmap"  class="showmap" style="float:left;">
                    <a onclick="return showmap()"  id="showareasmap" href="#" >показать на карте (ТЕСТИРУЕТСЯ!)</A>
                    </div>';
            $str .= '<div id="showarlist" class="showmap" style="display:none;  float:left; " >
                 <a onclick="return hidemap()"  id="showareasmap" href="#" >показать списком</A>
                 </div>';
        }

        $str .= '	<div class="close" >
                    <a onclick="return area_dn()"  href="#" >закрыть</A>
                    </div>';


        if (4 == 4) {
            $str .= '<div id="areasflash" style="display:none;" >
				
				<div id="fcontent_map" >
				
				

				
				</div>
 
                  
	


	

<SCRIPT LANGUAGE="JavaScript">
<!--

    var flashvars = {};
    var params           = {};
	//var params = {bgcolor:"#ffffff", allowFullScreen:"true", allowScriptAccess:"always"};
	params.swliveconnect = "true";
	params.allowScriptAccess = "always";
	var attributes       = {};
	attributes.id        = "testmovie";
	attributes.name      = "testmovie";
	swfobject.embedSWF( "http://neagent.by/themes/neagent_style/flash/mapapp.swf", "fcontent_map", "450", "360", "9.0.0", true, flashvars, params, attributes);

//alert(swfobject);
 //var so = new SWFObject("http://neagent.by/themes/neagent_style/flash/mapapp.swf", "fcontent_map", "450", "360", "7", "#2e2e2e");
//alert (so);
 //so.write("fcontent_map");



//showmap();
function showmap(){
mapdiv=document.getElementById("areasflash").style.display = "block";
mapdiv=document.getElementById("areasstring").style.display = "none";
mapdiv=document.getElementById("showarmap").style.display = "none";
mapdiv=document.getElementById("showarlist").style.display = "block";
}

function hidemap(){
mapdiv=document.getElementById("areasflash").style.display = "none";
mapdiv=document.getElementById("areasstring").style.display = "block";
mapdiv=document.getElementById("showarmap").style.display = "block";
mapdiv=document.getElementById("showarlist").style.display = "none";
}

function testmovie_DoFSCommand(command, args) {
  //alert("Здесь данные из Flash: "+command+", "+args);
  //alert (cur_form);
  //////myarea=command;
  params=args.split("|");
 //alert(command);
  //alert ("---" + command + "--");
  if (command=="area"){ 
  obj=document.getElementById("ar_" + params[0] ) ;
  
  // alert("передаем как obj " +obj.id);
  //alert("выполняем choose_area");
  choose_area(obj, params[0],  params[1]);
  
  }
  if (command=="subarea"){
   obj=document.getElementById("subar_" + params[0] ) ;
   //alert("передаем как obj " +obj.id);
  //alert("выполняем choose_subarea");
  choose_subarea(obj, params[0],  params[1]);
  
  }
  
    if (command=="request"){ //запрос данных
	//alert("запрос");
   sendVarsToFlash();
  
  }
  
  
  //$("#choosedArea_"+cur_form).html(args);
  
}
//-->
</SCRIPT>
<SCRIPT LANGUAGE="VBScript">
<!--
Sub testmovieFSCommand(ByVal command, ByVal args)
  call testmovie_DoFSCommand(command, args)
end sub
//-->
</SCRIPT>






				  </div> <div id="areasstring">';
        }


        $str .= '<ul id="underground"  >
					<li>
                        <a onclick=""  href=" "  id="175_metro" style="border-bottom:1px solid black;"><b>Адм. РАЙОНЫ:</b></a>
                                             
                    </li>
';


        $delm = "";
        $licount = 0;
        for ($i = 0; $i <= (count($areas) - 1); $i++) {
            $licount = $licount + 1;

            if ($licount == 11) {
                $str .= '</ul><ul>';
                $licount = 0;
            }


            $str .= '<li><a onclick="return choose_area(this, \'' . $areasId[$i] . '\', \'' . $areas[$i] . '\')"  href="#m-173"  id="' . $areasId[$i] . '_area" >' . $areas[$i] . '</a><input type="hidden"  id="ar_' . $areasId[$i] . '"  name="ar[]" > </li>';


//$delm=", ";

        }


        $str .= '<li><a onclick=""  href=" "  id="175_metro" style="border-bottom:1px solid black;"><b>МИКРОРАЙОНЫ:</b></a></li>';
//$licount=0;
        for ($i = 0; $i <= (count($subareas) - 1); $i++) {
            $licount = $licount + 1;
            if ($licount == 11) {
                $str .= '</ul><ul>';
                $licount = 0;
            }


            $str .= '<li><a onclick="return choose_subarea(this, \'' . $subareasId[$i] . '\',\'' . $subareas[$i] . '\' )"  href="#m-173"  id="' . $subareasId[$i] . '_area" >' . $subareas[$i] . '</a>
  <input type="hidden"  id="subar_' . $subareasId[$i] . '"  name="subar[]" >
    </li>';


        }


        $str .= '       </ul>';


        if ($mlev == 4) {
            $str .= '</div>';
        }


        $str .= ' <div class="cbtn" >
                      <a onclick="return chosen()"  href="#" >
                        <IMG onmouseout="imgou(this)"  onmouseover="imgov(this)"  src="http://neagent.by//themes/neagent_style/assets/images/btn_choose.gif"  id="btn_choose" >
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </DIV>';


        echo ($str);


    }


    function addareas()
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }

        refresh_realt_cash();

        include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/realtcash.php';
        $CI->data['cityidArr'] = $config['realt_cityes_id'];
        $CI->data['citynameArr'] = $config['realt_cityes_name'];
        $CI->data['cityuriArr'] = $config['realt_cityes_uri'];
        $CI->data['cityregionArr'] = $config['realt_cityes_region'];
        $action = $CI->input->post('action');

        if ($action == 'defined') { // город и тип выбран
//echo ("defined");
            $sity = $CI->input->post('sity_id');
            $type = $CI->input->post('type_id');
//echo ($sity);
//echo ($type );
            switch ($type) {
                case 'adm':
                    $typename = "административный район";
                    break;
                case 'mikro':
                    $typename = "микрорайон";
            }
            $sityname = getCityName($sity, $config['realt_cityes_id'], $config['realt_cityes_name']);
            $list = "";
        }


        if ($action == 'add') { // город и тип выбран

            $sity = $CI->input->post('sity');
            $type = $CI->input->post('type');
            switch ($type) {
                case 'adm':
                    $table = "realt_areas";
                    $val = "area_name";
                    break;
                case 'mikro':
                    $table = "realt_subareas";
                    $val = "subarea_name";
            }


            $Arr = split("\n", $CI->input->post('text'));

            for ($k = 0; $k < count($Arr); $k++) {
                if (strlen($Arr) > 2) {


                    $data = array(
                        $val => trim($Arr[$k]),
                        'sity' => $sity,
                    );

                    $this->db->insert($table, $data);


                }
            }


            echo("Добавлено ");
            return;


        }


        $data = array(
            'cityes_id' => $config['realt_cityes_id'],
            'cityes_name' => $config['realt_cityes_name'],
            'action' => $action,
            'sityname' => $sityname,
            'type' => $type,
            'sity' => $sity,
            'typename' => $typename

        );


        $this->data['searchform'] = $CI->parser->parse('realt_admin_addarea', $data);


    }


    function saveDeleteInfoToLog($str)
    {
        $CI =& get_instance();
        $uid = $_COOKIE["uid"];
        $uic = $_COOKIE["uic"];
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $page = $_SERVER['QUERY_STRING'];

        $page = $CI->uri->uri_string() . "/" . $page;

        $pagetitle = "";
        $conf = $str . " " . date("Y-m-d H:i:s", time()) . "; uid=" . $uid . "; uic=" . $uic . "; IP=" . $_SERVER["REMOTE_ADDR"] . "; useragent=" . $useragent . "; page=" . $page;


        $this->load->helper('file');
        $string = read_file($this->config->item('module_path') . 'Realt/config/deleting_log.txt');
        $string .= "\n" . $conf;

        if (!write_file($this->config->item('module_path') . 'Realt/config/deleting_log.txt', $string)) {

        }

    }


    function sutki_ad_delete($ad_id)
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        } else {
            return;
        }
        //if (!is_numeric($_GET["id"])) {return;}
        echo ($ad_id);
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh@mail.ru');
        $CI->email->to('dakh@mail.ru');
        $CI->email->subject('я удаляю объявление');
        $CI->email->message('я удаляю объявление на сутки' . $ad_id);
//$CI->email->send();
        echo $CI->email->print_debugger();

        $data = array('ad_show' => "0");
        $CI->db->where('ad_id', $ad_id);
        $CI->db->update('sutki', $data);
        echo $CI->db->_error_number();

    }


    function comment_delete($comment_id)
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        } else {
            return;
        }
        //if (!is_numeric($_GET["id"])) {return;}
        echo ($comment_id);

        $data = array('comment_text' => "<span style='color:red;'>Комментарий удален</span>", 'comment_show' => 0, 'comment_state' => 1);
        $CI->db->where('comment_id', $comment_id);
        $CI->db->update('realt_ads_comments', $data);
//echo $CI->db->_error_number();	
        echo ("удалено" . $comment_id . "<br>");

    }


    function user_tomoderate($user_id)
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        } else {
            return;
        }
        //if (!is_numeric($_GET["id"])) {return;}
        echo ($comment_id);

        $data = array('user_id' => (int)$user_id, 'moderate_comments' => 1);
        $CI->db->insert('realt_user_limits', $data);

        echo $CI->db->_error_number();
    }


    function comment_approve($comment_id)
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        } else {
            return;
        }
        //if (!is_numeric($_GET["id"])) {return;}
        echo ($comment_id);
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh@mail.ru');
        $CI->email->to('dakh@mail.ru');
        $CI->email->subject('я удаляю комм');
        $CI->email->message('я удаляю комм' . $ad_id);
//$CI->email->send();
        echo $CI->email->print_debugger();
        $data = array('comment_state' => 1, 'comment_show' => 1);
        $CI->db->where('comment_id', $comment_id);
        $CI->db->update('realt_ads_comments', $data);
//echo $CI->db->_error_number();
        echo ("допущено" . $comment_id . "<br>");
    }


    function comment_batch_moderate()
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();

        $remove = $CI->input->post('remove');
        $approve = $CI->input->post('approve');

//$remove  =  $a;
//$approve  =  $b;

        $removeArr = split("_", $remove);
        $approveArr = split("_", $approve);


        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        } else {
            echo "ЗАПРЕЩЕНО ";
            return;
        }


        for ($i = 0; $i < count($removeArr); $i++) {
            $this->comment_delete($removeArr[$i]);
        }

        for ($i = 0; $i < count($approveArr); $i++) {
            $this->comment_approve($approveArr[$i]);
        }


        echo "ОБРАБОТАНО ";
    }


    function ad_delete($ad_id , $delete_reason=0)
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        } else {
            return;
        }
        //if (!is_numeric($_GET["id"])) {return;}
        echo ($ad_id);
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh@mail.ru');
        $CI->email->to('dakh@mail.ru');
        $CI->email->subject('я удаляю объявление');
        $CI->email->message('я удаляю объявление' . $ad_id);
//$CI->email->send();
       // echo $CI->email->print_debugger();
$delete_reason = ($delete_reason==0)?3:$delete_reason;
        $data = array('ad_show' => "0", 'ad_pending' => "0", 'ad_delete_reazon' =>  $delete_reason);
        $CI->db->where('ad_id', $ad_id);
        $CI->db->update('ads', $data);
       // echo $CI->db->_error_number();

    }

	
	
	
	    function ad_mark_as_agent($ad_id , $delete_reason=0)
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        } else {
            return;
        }
        //if (!is_numeric($_GET["id"])) {return;}
        echo ($ad_id);
    
//$CI->email->send();
       // echo $CI->email->print_debugger();
$delete_reason = ($delete_reason==0)?3:$delete_reason;
        $data = array('ad_isagent' => "1" );
        $CI->db->where('ad_id', $ad_id);
        $CI->db->update('ads', $data);
       // echo $CI->db->_error_number();

    }
	
	
	
	
	
	
	

    function ad_approve($ad_id)
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        } else {
            return;
        }
        //if (!is_numeric($_GET["id"])) {return;}
        echo ($ad_id);

        $ad_postdate = date("Y-m-d H:i:s");

        $data = array('ad_show' => "1",
            'ad_pending' => "0",
            'ad_postdate' => $ad_postdate
        );
        $CI->db->where('ad_id', $ad_id);
        $CI->db->update('ads', $data);
        echo $CI->db->_error_number();

    }


    function ad_moderate()
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        $rez = $CI->input->post('rez');
        $ad = $CI->input->post('ad');

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('info@neagent.by');
        $CI->email->to("dakh@mail.ru");
        $CI->email->subject('Модерация');
        $mess = "  рз= " . $rez . " ad=" . $ad;
        $CI->email->message($mess);
        $CI->email->send();


        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        } else {
            return 1;
        }


        $ad_postdate = date("Y-m-d H:i:s");

        return 1;

    }


	
	
	
	
	 function adup()
    {
	
	if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        }
		
		
		$dd = date("Y-m-d H:i:s", time());
		$this->db->where("ad_id", 940162);
        $this->db->set("ad_up_date", $dd);
        $this->db->update("ads");
				
			        echo ($CI->db->last_query());	
				
				
		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	function check_site()
    {
	$url="https://kiris.urm.lt/by1/index.php";
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
		
		
		
		
		
		
		
		
		
		
		
 $config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$config['mailtype'] = 'html';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('sergej-minich@yandex.by');
$CI->email->to('dakh2008@mail.ru');
 
$CI->email->subject('проверка сайта');
$CI->email->message("333");
 
///// $CI->email->send();
		
		
		
		
		
		
		
		
		
		
		
		
		$CI->db->select('*');
		$CI->db->where('name', 'sms_send');
        $CI->db->from('realt_settings');
       
 
      


        $query = $CI->db->get(); 
		echo ($CI->db->last_query());
        if ($query->num_rows() == 0) {
            echo 'Не найдено ';
        } else {
		
		 foreach ($query->result() as $row) {


              $send=$row->content ;
		}
		
		
		}
		
		
		echo($send);
		
		
	if ($send=='0')	
	{	
	 
	
	if(!$fp = fopen($url ,"r" )) {
                return false;
            } //our fopen is right, so let's go
            $content = "";
            while(!feof($fp)) { //while it is not the last line, we will add the current line to our $content
            $content .= fgets($fp, 1024);   }
            fclose($fp); //we are done here, don't need the main source anymore

		echo("cont=:"  );
print_r( ($content));//utf-8 		
	 	 	
			
if ($content =="connection failed"){
			echo( "НЕУДАЧА");

}
else
{
////////// отправить смс и записать что  отправлено в базу
$data=array(
 	'content'	  =>'1'	 	 	 	 	 	 
)	;
$CI->db->where('name', 'sms_send');
$CI->db->update('realt_settings', $data);	
$phone="375297096944";		
	 $zapros = 'user=Minich&password=ERTs2444&recipient=' . $phone . '&message=' . 'site_works!!&sender=neagent.by';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://userarea.sms-assistent.by/api/v1/send_sms/plain");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $zapros);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);		
		echo("res=" .  $result);



}		
			
			
		
		
	}	

	
	
	
	

	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    function demon()
    {

        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        }
        //else {return;}


        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('info@neagent.by');
        $CI->email->to("info@neagent.by");
        $CI->email->subject('Запуск Demon ');
        $mess = " ";
        $CI->email->message($mess);
//$CI->email->send();


        echo ("demon");
        $dney = 5; // на сколько дней поднятие
        $pora = date("Y-m-d H:i:s", time() - (60 * 60 * 24 * $dney));
        echo ($pora);


        $CI->db->select('*');
        $CI->db->from('ads');
        $CI->db->where('ad_show', '1');
        $datest = "DATE_SUB(CURDATE(),INTERVAL 5 DAY) >=ad_up_date";
        $CI->db->where($datest);


        $this->db->where('ad_up_date !=', "0000-00-00 00:00:00");


//$results=$CI->db->count_all_results();
        echo ($CI->db->last_query());


        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            echo 'Не найдено объявлений';
        } else {

            foreach ($query->result() as $row) {


                $this->db->where("ad_id", $row->ad_id);
                $this->db->set("ad_up_date", "0000-00-00 00:00:00");
                $this->db->update("ads");

                /////////////////	

                switch ($row->ad_catid) {
                    case '2':
                    case '4':
                    case '6':
                    case '8':
                    case '10':
                        $ad_fullurl = "http://neagent.by/snimu/" . $row->ad_url;
                        break;
                    case '1':
                    case '3':
                    case '5':
                    case '7':
                    case '11':
                        $ad_fullurl = "http://neagent.by/sdayu/" . $row->ad_url;
                        break;
                }
                /////////////////	


                if (strlen($row->ad_email) > 3) {

                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $CI->load->library('email', $config);
                    $CI->email->set_newline("\r\n");
                    $CI->email->from('info@neagent.by');
                    $CI->email->to($row->ad_email . ", info@neagent.by");
                    $CI->email->subject('Ваше объявление на neagent.by. Закончился срок спецразмещения.');
                    $mess = "Закончился срок спецразмещения вашего объявления на neagent.by. Вы снова можете поднять его с помощью смс. Адрес Вашего объявления: " . $ad_fullurl;
                    $CI->email->message($mess);
                    $CI->email->send();


                }


                //return;	


                echo  ("<br><br><br>");
//echo ($row->ad_title);

                echo ($row->ad_phones);

            }

        }


//$CI->db->where('ad_up_date>', $pora);
//$CI->db->where('ad_up_date >', 0);
//$results=$CI->db->count_all_results();	

        echo ($results);


    }


    function demon2()
    {

        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $mlev = 4;
        }
        //else {return;}


        echo ("demon2");

		
		
		
		 $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $CI->load->library('email', $config);
                    $CI->email->set_newline("\r\n");
                    $CI->email->from('info@neagent.by');
                    $CI->email->to(  "dakh2008@mail.ru");
                    $CI->email->subject('Ваше объявление на neagent.by. Закончился срок спецразмещения.');
                    $mess = "DEMON2 ";
                    $CI->email->message($mess);
                    $CI->email->send();
		
		
		
		
		
		
		

        $CI->db->select('*');
        $CI->db->from('ads');
        $CI->db->where('ad_show', '1');
        $CI->db->limit(2000, 0);
        $CI->db->order_by('ad_id', 'DESC');


        $query = $CI->db->get();
        echo ($CI->db->last_query());

        if ($query->num_rows() == 0) {
            echo 'Не найдено объявлений';
        } else {

            foreach ($query->result() as $row) {


                $ad_currency = $row->ad_currency;
                $ad_price = $row->ad_price;


                $realt_currency_rate = config_item('realt_currency_rate');
                switch ($ad_currency) {
                    case "1": // рубли 
                        $currentCurrRate = (int)$realt_currency_rate[0];
                        break;
                    case "2": // доллары
                        $currentCurrRate = (int)$realt_currency_rate[1];
                        break;
                    case "3": // евро 
                        $currentCurrRate = (int)$realt_currency_rate[2];
                        break;
                    default:
                        $currentCurrRate = (int)$realt_currency_rate[1];
                        break;
                }
                if ($this->data['mlev'] == 4) {
                }
                $ad_default_price = $currentCurrRate * $ad_price;


                $this->db->where("ad_id", $row->ad_id);
                $this->db->set("ad_default_price", $ad_default_price);
                $this->db->update("ads");

/////////////////	
/////////////////	
//return;	


                echo  ("<br><br>");
//echo ($row->ad_title);

                echo ($ad_currency . " - " . $ad_price . " -> " . $ad_default_price);

            }

        }


		
		
		
		
		
		
		
		
		
		
		
		
		
		 $CI->db->select('*');
        $CI->db->from('sutki');
        $CI->db->where('ad_show', '1');
        $CI->db->limit(2000, 0);
        $CI->db->order_by('ad_id', 'DESC');


        $query = $CI->db->get();
        echo ($CI->db->last_query());

        if ($query->num_rows() == 0) {
            echo 'Не найдено объявлений';
        } else {

            foreach ($query->result() as $row) {


                $ad_currency = $row->ad_currency;
                $ad_price = $row->ad_price;
                $ad_price_min = $row->ad_price_min;
                $ad_price_max = $row->ad_price_max;

                $realt_currency_rate = config_item('realt_currency_rate');
                switch ($ad_currency) {
                    case "1": // рубли 
                        $currentCurrRate = (int)$realt_currency_rate[0];
                        break;
                    case "2": // доллары
                        $currentCurrRate = (int)$realt_currency_rate[1];
                        break;
                    case "3": // евро 
                        $currentCurrRate = (int)$realt_currency_rate[2];
                        break;
                    default:
                        $currentCurrRate = (int)$realt_currency_rate[1];
                        break;
                }
                if ($this->data['mlev'] == 4) {
                }
				
				
				if ($ad_price_min>0 && $ad_price_max>0){
				// do nothing
				}else
				{
				$ad_price_min =$ad_price_max =$ad_price;
				}
				
                $ad_default_price = $currentCurrRate * $ad_price;
                $ad_default_price_min = $currentCurrRate * $ad_price_min;
                $ad_default_price_max = $currentCurrRate * $ad_price_max;

                $this->db->where("ad_id", $row->ad_id);
                $this->db->set("ad_default_price_min", $ad_default_price_min);
				$this->db->set("ad_default_price_max", $ad_default_price_max);
				//$this->db->set("ad_default_price", $ad_default_price);
                $this->db->update("sutki");
 echo ($this->db->last_query());
 echo $this->db->_error_message();
/////////////////	
/////////////////	
//return;	


                echo  ("<br><br>");
//echo ($row->ad_title);

                echo ($ad_currency . " - " . $ad_price . " -> " . $ad_default_price);

            }

        }
		
		
		
		
		
		
		
		
		
		
		
//$CI->db->where('ad_up_date>', $pora);
//$CI->db->where('ad_up_date >', 0);
//$results=$CI->db->count_all_results();	

        echo ($results);


    }


    function idashboard()
    {

        $str = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Neagent_detector</title>
  	<style>
	*{ 
	padding:0;margin:0;
	font-family: tahoma, arial, sans-serif;
	}
  	body{
font-size:0.8em; color:#333;
}	
  	</style>
  </head>
  <body style="  background-color:#eef0f8; background:url(http://img1.neagent.by/s/d_bg.gif); background-repeat:repeat-x">
  
 
  <div style=" height:44px;  ">
 
 <div style="float:left;height:44px;width:65px;"><img src="http://img1.neagent.by/s/n32.png" style="padding-left:16px;padding-top:5px;border:none"></div> 
 <div style="float:right; height:44px; padding-right:5px;padding-top:3px;">&copy; neagent.by 2012<br></div>
<p style="padding-top:3px;">
  <b>В вашем браузере включен плагин  «проверка телефонов Neagent<sup>TM</sup>»</b> <br>
  Щелкните на подчеркнутом номере телефона, чтобы проверить его.  <a href="http://neagent.by/files/submitagent/submit.php" target="_blank">Заметили телефон агента?</a> . 
</p>
  </div>
 <div style="clear:both;background-color:#2972b5; background:url(http://img1.neagent.by/s/d_bg2.gif); color:white; text-align:center;font-size:1px;height:3px; "> </div>
	</body>
	';


        echo ($str);


    }


/////////////////////////////////////////////////////////////////////////////////////


    function androidcheck()
    {
        $str = 0;
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $sttr = "";
        $sttr .= $CI->input->post('tel');

        $sttr = str_replace("-", "", $sttr);
        $sttr = str_replace("  ", "", $sttr);
        $sttr = str_replace(" ", "", $sttr);
        $sttr = str_replace(" ", "", $sttr);
        $sttr = str_replace("+375", "80", $sttr);


        if ($sttr == "") {
            echo("Введите телефон с кодом, начиная с цифры 8");
            exit;
        }

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh@mail.ru');
        $CI->email->to('dakh@mail.ru');


//if ($_SERVER["REMOTE_ADDR"] =="195.50.4.123"){
//$result=('Введите свой номер телефона и имя.');echo("$result"); exit;
//}

        $CI->email->subject('пров. тел-a. IP=' . $_SERVER["REMOTE_ADDR"]);
        $CI->email->message($sttr . " " . date("Y-m-d H:i:s") . "; " . $_SERVER['HTTP_USER_AGENT']);
        $CI->email->send();


        if (strlen($sttr) > 1) {
            if (substr($sttr, 0, 1) != 8) {
                echo("Введите телефон с кодом, начиная с цифры 8");
                exit;
            }
        } else {
            echo("Введите телефон с кодом, начиная с цифры 8");
            exit;
        }


        $CI->db->select('*');
        $CI->db->from('realt_phonelist');
        $CI->db->where('p_number', $sttr);
        $CI->db->limit(1000, 0);
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {

            $result = ('Скорее всего не агент');
            //echo 'Не найдено объявлений';
        } else {
            foreach ($query->result() as $row) {

                $phone = $row->p_number;

                if (strpos($sttr, $phone) > -1) {
                    $str = 1;
                    $result = ('Подозрительный телефон');
                    //return;
                }


            }
        }
        //header('Content-type: application/xml; charset=utf-8');
        echo("$result");

    }


    function  phonecheck()
    {
        return $this->JSONcheck();
    }


    function JSONcheck()
    {
        $str = 0;
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $sttr = "";
        $sttr .= $CI->input->post('phonenumber');

        if ($sttr == "") {
            $sttr = $CI->uri->segment(4);
//echo($sttr);
        }

        $sttr = str_replace("-", "", $sttr);
        $sttr = str_replace("  ", "", $sttr);
        $sttr = str_replace(" ", "", $sttr);
        $sttr = str_replace(" ", "", $sttr);
        $sttr = str_replace("+375", "80", $sttr);


        if ($sttr == "") {
            $json = '{
   "error":{
     "code": "01",
     "description":{
       "lang": "ru",
       "text":"Неправильный формат номера"
     }
   }
}';

            echo($json);
//echo("Введите телефон с кодом, начиная с цифры 8");
            exit;
        }

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh@mail.ru');
        $CI->email->to('dakh@mail.ru');


//if ($_SERVER["REMOTE_ADDR"] =="195.50.4.123"){
//$result=('Введите свой номер телефона и имя.');echo("$result"); exit;
//}

        $CI->email->subject('пров. тел-json. IP=' . $_SERVER["REMOTE_ADDR"]);
        $CI->email->message($sttr . " " . date("Y-m-d H:i:s") . "; " . $_SERVER['HTTP_USER_AGENT']);
//$CI->email->send();


        if (strlen($sttr) > 1) {
            if (substr($sttr, 0, 1) != 8) {


                $json = '{
   "error":{
     "code": "01",
     "description":{
       "lang": "ru",
       "text":"Неправильный формат номера"
     }
   }
}';

                echo($json);
//echo("Введите телефон с кодом, начиная с цифры 8");
                exit;


            }
        } else {


            $json = '{
   "error":{
     "code": "01",
     "description":{
       "lang": "ru",
       "text":"Неправильный формат номера"
     }
   }
}';

            echo($json);
//echo("Введите телефон с кодом, начиная с цифры 8");
            exit;


        }


        $CI->db->select('*');
        $CI->db->from('realt_phonelist');
        $CI->db->where('p_number', $sttr);
        $CI->db->limit(1000, 0);
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {

            $text = ('Скорее всего не агент');
            $color = ('green');
            //echo 'Не найдено объявлений';
        } else {
            foreach ($query->result() as $row) {

                $phone = $row->p_number;

                if (strpos($sttr, $phone) > -1) {
                    $str = 1;
                    $text = ('Подозрительный телефон');
                    $color = ('red');

                    //return;
                }


            }
        }
        //header('Content-type: application/xml; charset=utf-8');

        $json = '{
  "phone":"' . $sttr . '",
  "description": {
    "lang": "ru",
    "text":"' . $text . '"
  },
  "style": "color:' . $color . '"
}

';

        echo($json);


    }


    function operacheck()
    {

        $str = 0;
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh@mail.ru');
        $CI->email->to('dakh@mail.ru');
        $CI->email->subject('проверка телефона тест ');
        $CI->email->message($sttr);
//$CI->email->send();


        if ($CI->input->post('tel')) {
		
		
		
		if ($_SERVER["REMOTE_ADDR"] =='61.180.49.18'){
		echo "fuck off";
		return;
		}
		
		
		if ($_SERVER["REMOTE_ADDR"] =='77.94.48.5'){
		echo "fuck off";
		return;
		}
		
		
	$code = $CI->input->post('code');	
		
		
            $sttr = $CI->input->post('tel');




            $sttr = str_replace("-", "", $sttr);
            $sttr = str_replace("  ", "", $sttr);
            $sttr = str_replace(" ", "", $sttr);
            $sttr = str_replace(" ", "", $sttr);
            $sttr = str_replace("+375", "80", $sttr);


            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $CI->load->library('email', $config);
            $CI->email->set_newline("\r\n");
            $CI->email->from('dakh@mail.ru');
            $CI->email->to('dakh@mail.ru');
            $CI->email->subject('пров. тел-n. IP=' . $_SERVER["REMOTE_ADDR"]);
            $CI->email->message($sttr . " " . date("Y-m-d H:i:s") . "; " . $_SERVER['HTTP_USER_AGENT']);
           //$CI->email->send();
			
			$sb= 'пров. тел-n. IP=' . $_SERVER["REMOTE_ADDR"];
            $ms=$sttr . " " . date("Y-m-d H:i:s") . "; " . $_SERVER['HTTP_USER_AGENT'];
			
            //saveLog('proverka_telefonov_log.txt',  $sb . $ms);
			
			
		$this->load->helper('file');
        $string = read_file($this->config->item('module_path') . 'Realt/config/proverka_telefonov_log.txt');
        $string .= "\n" . $sb . "  "  .  $ms;
        if (!write_file($this->config->item('module_path') . 'Realt/config/proverka_telefonov_log.txt', $string)) {
            //echo "-saved";
        }
			
			
			
            $color = "#eae090";
            if (substr($sttr, 0, 1) != 8) {
                $prov = 'Введите номер, начиная в 8-ки';
                $val = "8";
            } else {

                $CI->db->select('*');
                $CI->db->from('realt_phonelist');
                $CI->db->where('p_number', $sttr);
                $CI->db->limit(1000, 0);
                $query = $CI->db->get();
                if ($query->num_rows() == 0) {
                    $prov = 'Не aгент';
                    //echo('Скорее всего не агент');
                    //echo 'Не найдено объявлений';
                } else {
                    foreach ($query->result() as $row) {

                        $phone = $row->p_number;

                        if (strpos($sttr, $phone) > -1) {
                            $str = 1;
                            $prov = 'Есть в бaзе';
                            $color = "#ff90a5";
                            //echo('Подозрительный телефон');
                            //return;
                        }


                    }
                }


            }


			
			
			
			
			
			
			
//echo($str);
        }

		
		
		
		
		
	if ($_SERVER["REMOTE_ADDR"] =='91.228.53.28'){
	 $prov = 'Есть в бaзе';
     $color = "#ff90a5";
	}	
	
if ($_SERVER["REMOTE_ADDR"] =='218.108.170.169'){
	 $prov = 'Есть в бaзе';
     $color = "#ff90a5";
	}
	
	if ($code !='1'){
	$prov = 'Есть в бaзе!';
     $color = "#ff90a5";
	 
	 $string = read_file($this->config->item('module_path') . 'Realt/config/proverka_telefonov_log.txt');
        $string .= "\n" . $sb . " ДОСТУП БЕЗ КОДА "  .  $ms;
        if (!write_file($this->config->item('module_path') . 'Realt/config/proverka_telefonov_log.txt', $string)) {
            //echo "-saved";
        }
	 
	}	
		
		
		
		
		

        $mystr = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Проверка телефоны</title>
  	<style>
	*{
	padding:0;margin:0;
	font-family: helvetica, arial, sans-serif;
	}
  		h1 {
  			font-family: 14px helvetica, arial, sans-serif;
  			text-align: center;
  		 }
  	</style>
  </head>
  <body style="background-color:#eef0f8">
  
<div style="width:240px;background-color:#dde2ef;height:100%">
  	<h1 style="background-color:#e7ebf5; border-bottom:1px solid #bcc1cf; line-height:36px; font-size:1.0em; color:#4e6079">Проверка телефона</h1>
	<div id="response"> </div>
';

        if ($prov) {

            $mystr .= '<div style="padding:10px; background-color:';

            $mystr .= $color;

            $mystr .= ';"><label style="font-size:0.8em;">Результат для  ' . $sttr . ':</label>
<div style="font-weight:bold;">' . $prov . '</div></div>';

            $mystr .= '<div style="padding:10px;"><a href="tel:' . $sttr . ' ">Набрать ' . $sttr . '</a></div>';


        }

        $mystr .= '	 
<form action="http://neagent.by/n"  method="POST">
	<div style="padding:10px;">
	<label style="font-size:0.8em;">Введите номер для проверки:</label>
	<input type="hidden" name="code" value="1" >
	<input name="tel" id="tel" style="height:32px;font-size:1.2em;width:220px;" ';
        $mystr .= ' value="' . $val;

        $mystr .= '">
		<label style="font-size:0.8em;">(Пример: 80294560000)</label>
	</div>
	<div style="padding:10px;padding-top:0px;border-bottom:1px solid #bcc1cf">
	<input type="submit" style="padding:10px; width:220px; font-size:1em;" value= "Проверить" type="submin">
	</div>
	
	<div style="padding:10px; border-bottom:1px solid #bcc1cf">
	<p style="font-size:0.8em;">
	Проверка номера ведется на предмет соответствия  собранным из открытых источников телефонов агентов недвижимости
	</p>
	</div>
	
</form>
</div>


</html>

';
        echo($mystr);


    }


    function check($sttr)
    {
        $str = 0;
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $CI->db->select('*');
        $CI->db->from('realt_phonelist');
        $CI->db->where('p_number', $sttr);
        $CI->db->limit(1000, 0);
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            //echo 'Не найдено объявлений';
        } else {
            foreach ($query->result() as $row) {

                $phone = $row->p_number;

                if (strpos($sttr, $phone) > -1) {
                    $str = 1;
                    echo ($str);
                    return;
                }


            }
        }

        echo ($str);

    }


    function phones()
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $CI->db->select('*');
        $CI->db->from('realt_phonelist');
//$CI->db->where ('ad_show',  '1' );
        $CI->db->limit(200, 0);
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            //echo 'Не найдено объявлений';
        } else {
            foreach ($query->result() as $row) {
                $phone = $row->p_number;
                $city = $row->p_city;
                $str .= $delim . $phone;
                $delim = ", ";
            }
        }
        echo ($str);
    }


    function labeldelete()
    {
        header('Content-type: application/xml; charset=utf-8');
        //////////////////////////////////////	  
        $userLevel = "";
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $this->data['mlev'] = 4;
        }
        ;
        ///////////////////////////////////
        $ref = $_SERVER["HTTP_REFERER"];
        $USERIP = $_SERVER["REMOTE_ADDR"];
        $uid = $_COOKIE["uid"]; // это не то же  что в стат модели!! не присваивает, только читает
        $c_autor_type = $_COOKIE["IUser"];
        $aid = $_POST["aid"]; // foo bar 
        $label = $_POST["label"]; // baz


        //////////////////////////////////////////////  проверяем,  это метка пользователя или нет
        $CI->db->select('*');
        $CI->db->from('realt_tags');
        $CI->db->where('tag_uid', $uid);
        $CI->db->where('tag_id', $label);
        $CI->db->limit(1, 0);
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            //echo 'Не найдено объявлений';

            echo("<xml><error>error</error></xml>");
            return;
        } else {


/// удалить метку из таблицы


            $CI->db->where('ad_id', $aid);
            $CI->db->where('label_id', $label);
            $CI->db->delete('realt_adtags');


            echo("<xml><error>oklabel</error><adid>" . $aid . "</adid><labelid>" . $label . "</labelid></xml>");
            return;
        }

///////////////////////////////////////////////////////////


    }


    function label()
    {
        header('Content-type: application/xml; charset=utf-8');

        //////////////////////////////////////	  
        $userLevel = "";
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $this->data['mlev'] = 4;
        }
        ;
        ///////////////////////////////////


        $ref = $_SERVER["HTTP_REFERER"];
        $USERIP = $_SERVER["REMOTE_ADDR"];
        $uid = $_COOKIE["uid"]; // это не то же  что в стат модели!! не присваивает, только читает
        $c_autor_type = $_COOKIE["IUser"];


        $aid = $_POST["aid"]; // foo bar 
        $label = $_POST["label"]; // baz
        //$mtext = $_POST['report']; 
        $ajax = $_POST['ajax'];


        $name = $_POST["name"]; // foo bar
        $color = $_POST["color"]; // foo bar

        if ($name) {
// Если нам нужно записать новый тэг 	


            $CI->db->select('*');
            $CI->db->from('realt_tags');
            $CI->db->where('tag_name', $name);
            $CI->db->where('tag_uid', $uid);


//$results=$CI->db->count_all_results();


            $query = $CI->db->get();
            if ($query->num_rows() > 0) {
                echo("<xml><error>err:nameexist</error> </xml>");
                return;
            } else {


                $data = array(
                    tag_name => $name,
                    tag_uid => $uid,
                    tag_color => $color,
                    tag_userid => '',

                );
                $CI->db->insert('realt_tags', $data);
                $label = $CI->db->insert_id();

            }
        }


        if ($ajax != 1) {
            echo("<xml><error>error</error> </xml>");
            return;
        }


        $aid = str_replace("aid", "", $aid);
        if (!is_numeric($label)) {
            echo("<xml><error>err</error> </xml>");
            return;
        }

        if (!is_numeric($aid)) {
            echo("<xml><error>err</error> </xml>");
            return;
        }


        // проверяе номер тега. 

        $CI->db->select('*');
        $CI->db->from('realt_tags');
        $CI->db->where('tag_id', $label);

//$results=$CI->db->count_all_results();


        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            echo("<xml><error>err</error> </xml>");
            return;
        } else {


            foreach ($query->result() as $row) {

                $name = $row->tag_name; // foo bar
                $color = $row->tag_color; // foo bar

//$this->db->where("ad_id", $row->ad_id);
//$this->db->set("ad_up_date", "0000-00-00 00:00:00");
//$this->db->update("ads");				

            }
        }


        ///////////////////////////
        //Сохраняем в базу


        $c_postdate = date("Y-m-d H:i:s");


        $data = array(
            ad_id => $aid,
            label_id => $label,
        );


        $CI->db->insert('realt_adtags', $data);


//$CI->db->last_query());


/////////////////////////////


//$mtext = iconv("cp1251","utf-8",$mtext);
        $messagestr = "добавлен тег " . "mtext= " . $mtext . " adId=" . $aid . " complaint=" . $ctext . "IP=" . $USERIP . ";UID=" . $uid . "referrer= " . $ref . " перейти: http://neagent.by/board/adid/" . $aid;
//$messagestr =  $messagestr . $_SERVER['QUERY_STRING'];
//$ssss=SendLetter ("admin@flash.by", "dakh@mail.ru", "отправлена " & messagestr, messagestr)	;
        if ($this->data['mlev'] == 4) {
//echo ("STR^");
//echo ($messagestr);
        }


// вид такой: action=authabuse&aid=32126&complaint=3&report= fghfghgd&ajax=1

//Send that love letter
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh2008@mail.ru');
        $CI->email->to('info@neagent.by');
        $CI->email->subject('Жалоба');
        $CI->email->message($messagestr);

        $CI->email->send();
        //echo $CI->email->print_debugger();
//End end that love letter


        if ($this->data['mlev'] != 4) {
            // простой юзер
            echo("<xml><error>oklabel</error><adid>" . $aid . "</adid><labelname>" . $name . "</labelname><labelcolor>" . $color . "</labelcolor><labelid>" . $label . "</labelid> </xml>");
            return;
        } else { // админ 
            //echo($_SERVER['QUERY_STRING']);
            echo("<xml><error>oklabel</error><adid>" . $aid . "</adid><labelname>" . $name . "</labelname><labelcolor>" . $color . "</labelcolor><labelid>" . $label . "</labelid> </xml>");
            return;
        }


        $responsetext = "okabuse";

        //$aa= $this->addComplaint($aid, $complaint, $mtext, $USERIP, $uid, $autortype);
////////////////////////добавление собсно 


        //присвоить переменной $a  ответ, может оно уже добавлено
        //echo('add-copml');
///////////////////////	


        if ($a = "alreadyAdded") {
            $responsetext = "errabusealready";
        }
        if (getAddAbuse($aid) > 99) {
            $responsetext = "okspam";
            $f = deleteadd(ad_id);
        }
        echo('<xml><error>errabusenotselected</error> </xml>');
        return;
    }


///////////////////////////////////////////////////////////////////////////////////


    function myCashDemon()
    {
	
	//echo('st');
// заполняет  mycash - activeuid 
         
            $CI =& get_instance();
            $CI->load->library('parser');
         
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $this->data['mlev'] = 4;
        }
        ;
        ///////////////////////////////////
        $USERIP = $_SERVER["REMOTE_ADDR"];
        $uid = $_COOKIE["uid"];

        $nowdate = date("Y-m-d H:i:s");
        $timeout3days = date("Y-m-d H:i:s", time() - ((3 * 24 * 60 * 60)));


        $CI->db->from("ads");
        $CI->db->where('ad_postdate >', $timeout3days);
        $CI->db->where('ad_show', '1');
        $CI->db->order_by("ad_postdate", "desc");
        $CI->db->limit(1000, 0);
        $query = $CI->db->get();

        if ($query->num_rows() == 0) {
            $result = false;
            if ($this->data['mlev'] == 4) {
                echo ("FALSE;");
            }
        } else {
            $activeuids = "";

            foreach ($query->result() as $row) {
                $ad_uid = $row->ad_uid;
                $delim = ";";
// СДЕЛАТЬ ПРОВЕРКУ ЕСЛИ УЖЕ ЕСТЬ ТАКОЙ ГШВ  ТО НЕ ВСТАВЛЯТЬ 
                $activeuids = $activeuids . $ad_uid . $delim;
            }
            $auidCheck_date = $nowdate;


// конец сбора собираем activeuids				

// собираем actions 
//будут переменные  $sceneries_uid  $sceneries_IP   $sceneries_member    $sceneries_text   $sceneries_price
//будут переменные  uid IP member text price

            //$uid=$this->data['user_uid'];	
            $CI->db->from("realt_sceneries");
            //$this->db->where('ad_postdate >', $timeout3days);
            $CI->db->where('active', '1');

            $CI->db->limit(1000, 0);
            $query = $CI->db->get();
            //if  ($this->data['mlev']==4){echo 	($CI->db->last_query()); }


            if ($query->num_rows() == 0) {
                $result = false;
                if ($this->data['mlev'] == 4) {
                    echo ("FALSE;");
                }
            } else {

                $sceneries_uid = "";
                $sceneries_IP = "";
                $sceneries_member = "";
                $sceneries_text = "";
                $sceneries_price = "";
                $sceneries_log = "";

                foreach ($query->result() as $row) {

//echo ("__row__" . $row->param);

                    switch ($row->param) {
                        case 'uid':

                            $delimuid = ";";
// СДЕЛАТЬ ПРОВЕРКУ ЕСЛИ УЖЕ ЕСТЬ ТАКОЙ ГШВ  ТО НЕ ВСТАВЛЯТЬ 
                            $sceneries_uid = $sceneries_uid . $row->value . $delim;
                            break;


                        case 'IP':

                            $delimIP = ";";
// СДЕЛАТЬ ПРОВЕРКУ ЕСЛИ УЖЕ ЕСТЬ ТАКОЙ ГШВ  ТО НЕ ВСТАВЛЯТЬ 
                            $sceneries_IP = $sceneries_IP . $row->value . $delimIP;
                            break;


                        case 'member':

                            $delimmember = ";";
// СДЕЛАТЬ ПРОВЕРКУ ЕСЛИ УЖЕ ЕСТЬ ТАКОЙ ГШВ  ТО НЕ ВСТАВЛЯТЬ 
                            $sceneries_member = $sceneries_member . $row->value . $delimIP;
                            break;


                        case 'text':

                            $delimtext = ";";
// СДЕЛАТЬ ПРОВЕРКУ ЕСЛИ УЖЕ ЕСТЬ ТАКОЙ ГШВ  ТО НЕ ВСТАВЛЯТЬ 
                            $sceneries_text = $sceneries_text . $row->value . $delimtext;
                            break;


                        case 'price':

                            $delimprice = ";";
// СДЕЛАТЬ ПРОВЕРКУ ЕСЛИ УЖЕ ЕСТЬ ТАКОЙ ГШВ  ТО НЕ ВСТАВЛЯТЬ 
                            $sceneries_price = $sceneries_price . $row->value . $delimprice;
                            break;


                    }
                }


            }


//////////////////// ЗАПИСЬ В ФАЙЛ				
            $keys = array
            ('realt_auidCheck_date',
                'realt_activeuids',
                'sceneries_uid',
                'sceneries_IP',
                'sceneries_member',
                'sceneries_text',
                'sceneries_price'
            );

            $settings['realt_auidCheck_date'] = $nowdate;
            $settings['realt_activeuids'] = $activeuids;
            $settings['sceneries_uid'] = $sceneries_uid;
            $settings['sceneries_IP'] = $sceneries_IP;
            $settings['sceneries_member'] = $sceneries_member;
            $settings['sceneries_text'] = $sceneries_text;
            $settings['sceneries_price'] = $sceneries_price;

            /*
		 * Saving the file
		*/
            $conf = "<?php \n\n";
            foreach ($settings as $key => $val) {
                $conf .= "\$config['" . $key . "'] = '" . $val . "';\n";
            }
            //$conf .="test";
            $conf .= "\n\n";
            $conf .= '/* End of file config.php */' . "\n";
            $conf .= '/* Auto generated by realt Administration on : ' . date('Y.m.d H:i:s') . ' */' . "\n";
            $conf .= '/* Location: ' . $this->config->item('module_path') . 'Realt/config/mycash.php */' . "\n";
            $CI->load->helper('file');
            if (!write_file($CI->config->item('module_path') . 'Realt/config/mycash.php', $conf)) {
			
			 echo("ERR ");
			
			
			
			
			
			 $config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                        $CI->load->library('email', $config);
                        $CI->email->set_newline("\r\n");
                        $CI->email->from('info@neagent.by');
                        $CI->email->to('dakh2008@mail.ru');
                        $CI->email->subject("Ошибка записи в mycash");
                        $CI->email->message("");
                        $CI->email->send();
			


			
			
                //$CI->error(lang('ionize_message_error_writing_file'));				
            } else {
			
			// echo("SUCS ");
			

                //$CI->success(lang('module_realt_message_options_save'));				
            }
            //print_r ($GLOBALS['activeuids']);
            //print_r ("ND=" . $nowdate);
            //print_r ("GL=" . $GLOBALS['auidCheck_date']);
            //print_r ("TRUE");
        }

//////////////////// КОНЕЦ ЗАПИСЬ В ФАЙЛ

// в конфиг для дальнейшей работы
        $config['realt_activeuids'] = $settings['realt_activeuids'];
        $config['sceneries_uid'] = $settings['sceneries_uid'];
        $config['sceneries_IP'] = $settings['sceneries_IP'];
        $config['sceneries_member'] = $settings['sceneries_member'];
        $config['sceneries_text'] = $settings['sceneries_text'];
        $config['sceneries_price'] = $settings['sceneries_price'];

////////////////////////////////////////////////////


    }


    function complaint()
    {
        header('Content-type: application/xml; charset=utf-8');
error_reporting (0); 
        //////////////////////////////////////	  
        $userLevel = "";
        
            $CI =& get_instance();
            $CI->load->library('parser');
         
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $this->data['mlev'] = 4;
        }
        ;
        ///////////////////////////////////


        $this->load->helper('realt');


        $ref = $_SERVER["HTTP_REFERER"];
        $USERIP = $_SERVER["REMOTE_ADDR"];
        $uid = isset($_COOKIE["uid"]) ? $_COOKIE["uid"] :""; // это не то же  чт ов стат модели!! не присваивает, только читает
        $c_autor_type = isset($_COOKIE["IUser"]) ? $_COOKIE["IUser"] : "";


        $aid = $_POST["aid"]; // foo bar 
        $complaint = $_POST["complaint"]; // baz
        $mtext = isset($_POST['report']) ? $_POST['report']: "";
        $ajax = $_POST['ajax'];


        // найти $c_ad_uid


        //echo  $c_ad_uid;


        if ($ajax != 1) {

            echo("<xml><error>error</error> </xml>");
            return;
        }


        // проверяем  жаловались ли 
        $CI->db->where('c_uid', $uid);
        $CI->db->where('c_ad', $aid);
        $CI->db->from('realt_complaints');
        $co = $CI->db->count_all_results();

        if ($co != 0) {
            echo("<xml><error>errabusealready</error> </xml>");
            return;
        }


        // проверяем  жаловались ли  ip
        $CI->db->where('c_ip', $USERIP);
        $CI->db->where('c_ad', $aid);
        $CI->db->from('realt_complaints');
        $co = $CI->db->count_all_results();

        if ($co != 0) {
            echo("<xml><error>errabusealready</error> </xml>");
            return;
        }


        $c_ad_uid = getAdUid($aid);
        $complaintsCount = $this->c_Count($aid);


        if ($complaintsCount > 2) {
            $this->putModerate($c_ad_uid);
			
			
        }


        switch ($complaint) {
            case 1:
                $ctext = "подозрительный";
                break;
            case 2:
                $ctext = "агентство";
                break;
            case 3:
                $ctext = "другое";
                break;
            default:
                $ctext = "не указано";
                break;
        }


        $aid = str_replace("aid", "", $aid);
        if (!is_numeric($complaint)) {
            $complaint = 0;
        }

        if (!is_numeric($aid)) {
            echo("<xml><error>err</error> </xml>");
            return;
        }


        ///////////////////////////
        //Сохраняем в базу
        $c_postdate = date("Y-m-d H:i:s");

        $data = array(
            c_ad => $aid,
            c_reason => $ctext,
            c_description => $mtext,
            c_uid => $uid,
            c_ip => $USERIP,
            c_date => $c_postdate,
            c_ad_uid => $c_ad_uid,
        );


        $CI->db->insert('realt_complaints', $data);
        //$CI->db->last_query());


        /////////////////////////////

 
        $messagestr = "жалоба " . "mtext= " . $mtext . " adId=" . $aid . " complaint=" . 
		$ctext . "IP=" . $USERIP . ";UID=" . $uid . "referrer= " . $ref . " перейти: http://neagent.by/board/adid/" . 
		$aid . " перейти к UID: http://neagent.by/wap/uid/" . $c_ad_uid .
		" жалоб всего " . $complaintsCount;
//$messagestr =  $messagestr . $_SERVER['QUERY_STRING'];
//$ssss=SendLetter ("admin@flash.by", "dakh@mail.ru", "отправлена " & messagestr, messagestr)	;
        if ($this->data['mlev'] == 4) {
//echo ("STR^");
//echo ($messagestr);
        }


// вид такой: action=authabuse&aid=32126&complaint=3&report= fghfghgd&ajax=1

//Send that love letter
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('info@neagent.by');
        $CI->email->to('sergej-minich@yandex.by');
        $CI->email->subject('Жалоба');
        $CI->email->message($messagestr);
        $CI->email->send();
        //echo $CI->email->print_debugger();
 

        if ($this->data['mlev'] != 4) {
            // простой юзер
            echo("<xml><error>okabuse</error> </xml>");
            return;
        } else { // админ 
            //echo($_SERVER['QUERY_STRING']);
            echo("<xml><error>okabuse</error> </xml>");
            return;
        }


        $responsetext = "okabuse";

        //$aa= $this->addComplaint($aid, $complaint, $mtext, $USERIP, $uid, $autortype);
////////////////////////добавление собсно 


        //присвоить переменной $a  ответ, может оно уже добавлено
        //echo('add-copml');
///////////////////////	


        if ($a = "alreadyAdded") {
            $responsetext = "errabusealready";
        }
        if (getAddAbuse($aid) > 99) {
            $responsetext = "okspam";
            $f = deleteadd(ad_id);
        }
        echo('<xml><error>errabusenotselected</error> </xml>');
        return;
    }


    public function addComplaint($aid, $complaint, $mtext, $USERIP, $uid, $autortype)
    {
        echo('add-copml');
        return;
    }


    function getAddAbuse($aid)
    { // читает из базы вес жалоб объявления
        return 99;
    }


    function showcontact()
    {
        $CI =& get_instance();
        $uid = $_COOKIE["uid"];
        $uic = $_COOKIE["uic"];
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $page = $_SERVER['QUERY_STRING'];
        $page = $CI->uri->uri_string() . "/" . $page;
        $pagetitle = "";
		$user = $CI->connect->get_current_user();
        $conf = date("Y-m-d H:i:s", time()) . "; uid=" . $uid . "; uic=" . $uic . "; IP=" . $_SERVER["REMOTE_ADDR"] . "; useragent=" . $useragent . "; page=" . $page;

        $this->load->helper('file');
        $string = read_file($this->config->item('module_path') . 'Realt/config/log2.txt');
        $string .= "\n" . $conf;
        if (!write_file($this->config->item('module_path') . 'Realt/config/log2.txt', $string)) {
            //echo "-saved";
        }


        $limits = config_item('realt_show_phones_limit');
		
        if ($limits > 0) {
            $user = $CI->connect->get_current_user();
            $userid = (int)$user['id_user'];
			//echo($userid ."+");
			//return;
            if ($userid > 0) {
                $data['user_id'] = $userid;
                $data['date'] = $nowdate = date("Y-m-d H:i:s");
                $data['sucsess'] = 1;
				$data['ad_id'] = $_POST['id']?$_POST['id']:0;
				$data['cat_id'] = $_POST['catid']?$_POST['catid']:0;
                $CI->db->insert('realt_users_shown', $data);
//echo(config_item('realt_show_phones_limit'));
            } else {
                $data['user_id'] = $userid;
                $data['date'] = $nowdate = date("Y-m-d H:i:s");
                $data['sucsess'] = 1;
				$data['ad_id'] = $_POST['id']?$_POST['id']:0;
				$data['cat_id'] = $_POST['catid']?$_POST['catid']:0;
                $CI->db->insert('realt_users_shown', $data);
//echo "Сначала зарегистрируйтесь";
//return;
            }


        }
//header("Cache-Control: no-cache, must-revalidate");
//header("Pragma: no-cache");
//header("Content-Type: application/json"); 
//header("Accept-Charset: utf-8");
//header('Content-Type: text/html; charset=windows-1251', TRUE);
        $ad_postdate = date("Y-m-d H:i:s");
        $data = $_POST['data'];
        $adid = isset($_POST['adid']) ? $_POST['adid'] : "";
        $phones = base64_decode($data);
        if (strpos($phones, "втор скрыл") > -1) {
            echo $phones;
            return;
        }
		
		
	//////////////////	
$mdata['ad_id'] = $adid;
$mdata['cat_id'] = isset($catid)?$catid:0;
$mdata['date'] = date("Y-m-d H:i:s");
$mdata['user_id'] =(int)$user['id_user'];
$CI->db->insert('realt_phones_views', $mdata);
$str= $this->db->_error_message() .  " " . $this->db->last_query();
		if (!write_file($this->config->item('module_path') . 'Realt/config/log2.txt', $str)) {
            //echo "-saved";
        }
		
	///////////////////				

        $pdata = $_POST['pdate'];
        if ($pdata) {
            $nowdate = date("Y-m-d H:i:s");
            $date_time_string = $nowdate;
            $dt_elements = explode(' ', $date_time_string);
            $date_elements = explode('-', $dt_elements[0]);
            $time_elements = explode(':', $dt_elements[1]);
            $nn = mktime($time_elements[0], $time_elements[1], $time_elements[2], $date_elements[1], $date_elements[2], $date_elements[0]);

            $obdate = $pdata;
            $date_time_string = $obdate;
            $dt_elements = explode(' ', $date_time_string);
            $date_elements = explode('-', $dt_elements[0]);
            $time_elements = explode(':', $dt_elements[1]);
            $oo = mktime($time_elements[0], $time_elements[1], $time_elements[2], $date_elements[1], $date_elements[2], $date_elements[0]);
            $diff = $nn - $oo;

            $minutsForShow = 12;
            $sekForShow = $minutsForShow * 60;

            $sekost = ($minutsForShow * 60 - $diff); // осталось секунд 
            $minsh = floor($sekost / 60); // осталось минут
            $seksh = $sekost - $minsh * 60;


            if (($minsh) > 3) {
                $ostalos = "Будет доступен через " . $minsh . "мин. ";
            } else {
                $ostalos = "Будет доступен через " . $minsh . "мин. " . $seksh . "сек.";
            }


            if ($diff < ($minutsForShow * 60) && $diff > -1) {
                echo $ostalos;
                return;
            }
        }


        echo base64_decode($data);
    }


    function smsgate()
    {
        parse_str($_SERVER['QUERY_STRING'], $_GET);

        $test = $_GET['test'];
        $phone = $_GET['phone'];
        $cn = $_GET['cn'];
        $sn = $_GET['sn'];
        $op = $_GET['op'];
        $pref = $_GET['pref'];
        $tid = $_GET['tid'];
        $txt = $_GET['txt'];


        $CI =& get_instance();
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('info@neagent.by');
        $CI->email->to('dakh2008@mail.ru');
        $CI->email->subject('SMS  ');
        $CI->email->message('SMS=' . $txt . ";  " . $phone . ";      " . $_SERVER['QUERY_STRING']);
        $CI->email->send();


///// проверка кода

        if (strlen($txt) > 2) {
            $ad_id = substr($txt, 3);

			
			if (substr($txt, 0, 3) == 100 || substr($txt, 0, 3) == 200){
            if (substr($txt, 0, 3) == 100) {
                $ad_table = "ads";
				
            }
            if (substr($txt, 0, 3) == 200) {
                $ad_table = "sutki";
				
			//$otvet= "utf=Услуга больше не предоставляется! Свяжитесь с администратором";
            //echo ($otvet);	
			//return;	
            }


            $ad_up_date = date("Y-m-d H:i:s");
            $CI->db->where("ad_id", $ad_id);
            $CI->db->set("ad_up_date", $ad_up_date);
            $CI->db->update($ad_table);
}

//echo  "--". substr($txt,0,3) ."--";
        } else {
            echo ("utf=Неправильный код объявления");
            return;
        }

        $otvet= "utf=Ваше объявл. №" . $txt . " поднято";
        echo ($otvet);


//echo $phone;
//echo $_SERVER['QUERY_STRING'] ;

//echo "smsgate";
    }


    public function c_Count($aid)
    {

        $CI =& get_instance();
        $CI->db->where("c_ad", $aid);
        $CI->db->from("realt_complaints");
        $res = $CI->db->count_all_results();
        return $res;
    }


    function putModerate($uid)
    {

// все на модерацию  // кроме поднятых 
        $CI =& get_instance();
        $this->db->where('ad_show', 1);
        $this->db->where('ad_up_date', '0000-00-00 00:00:00');
        $this->db->where('ad_uid', $uid);
        $this->db->set('ad_pending', 1);
        $this->db->set('ad_show', 0);
        $this->db->update('ads');


        // проверяем
        $CI->db->where('param', 'uid');
        $CI->db->where('value', $uid);
        $CI->db->like('action', 'moderate', 'both');
        $CI->db->from('realt_sceneries');
        $co = $CI->db->count_all_results();


        if ($co == 0) { // если нет в сценариях 

            $data = array(
                param => 'uid',
                value => $uid,
                action => 'moderate',
                note => 'автопостановка'
            );

            $CI->db->insert('realt_sceneries', $data);

        }


    }

	
	
	
 function addToBlacklist($number,  $email=false)
    {

if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $this->data['mlev'] = 4;
        }
else{
return;
}


parse_str($_SERVER['QUERY_STRING'], $_GET);
$adid=(int)$_GET['id'];
  



echo($email);
$action = $CI->input->post('action');

 if ($action == 'doit') { 
        // проверяем
		$number = $CI->input->post('phone');
		$email = $CI->input->post('ag_email');
if (strlen($number) != 11 ||  !is_numeric($number) || substr( $number , 0,2)!='80'){
$data=array(phone=>$number,);
echo('Неправильный формат номера'); 
$str = $CI->parser->parse('realt_addtoblacklist', $data, $false);
exit;
}
        $CI->db->where('p_number', $number);
        $CI->db->from('realt_phonelist');
        $co = $CI->db->count_all_results();
        if ($co == 0) { // если нет в сценариях 
            $data = array(
                p_number => $number,
            );
            $CI->db->insert('realt_phonelist', $data);
			echo('Телефон ' . $number . ' добавлен в черный список'); 
        }
		else{
		echo('Телефон ' . $number . ' уже в  черном списке'); 
		}

		
		echo ("--");
		echo (strpos($email, '@'));
		///////////////////////// if  email 
		if (strpos($email, '@') != FALSE){
		
		
		$CI->db->where('email', $email);
        $CI->db->from('realt_black_emails');
        $co = $CI->db->count_all_results();
        if ($co == 0) { // если нет в email  
            $data = array(
                 email => $email,
            );
            $CI->db->insert('realt_black_emails', $data);
			echo('Email ' . $number . ' добавлен в черный список'); 
        }
		else{
		echo('Email ' . $email . ' уже в  черном списке'); 
		}
		}
		//////////////////////
		
		echo('<br> Переадресация....');
		echo('<meta http-equiv="refresh" content="2; url=http://neagent.by/wap/moderate">');
		
		
		
		
		
		
		
	}
else{
// показ формы
echo(" 2 " . $email);
if (substr( $number, 0,3)=='375'){
$number="80" . substr (  $number , 3 );
$number= str_replace ( " " , "" ,$number);
$number= str_replace ( " " , "" ,$number);
$number= str_replace ( "-" , "" ,$number);

}


// удаляем сразу объяву
if ($adid >0){
$this->ad_delete($adid , 2); // 2- добавили в черный список




}
echo("DELETED  <br>");

$data=array(phone=>$number,
mail=>$email,
id=>$adid
);
echo(" 3 " . $email);
$str = $CI->parser->parse('realt_addtoblacklist', $data, $false);
 
 
 
 
}	
		
		
		
		
		
		
    }
	
	
	
    function ad_comment()
    {
        $header = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head><meta http-equiv='content-type' content='text/html; charset=utf-8' /><link rel='stylesheet' href='http://neagent.by/themes/neagent_style/assets/css/style.css' type='text/css' media='screen, projection' /></head><body class='popframe'>";
        //////////////////////////////////////	  
        $userLevel = "";
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $this->data['mlev'] = 4;
        }
        ;

        ///////////////////////////////////
        $userid = $user['id_user'];
        $screen_name = $user['screen_name'];

        if ((int)$userid == 0) {
            echo ("Комментарии могут оставлять только зарегистрированные пользователи.");
            return;
        }


        if (strpos($screen_name, "@") > 0 || strlen($screen_name) < 1) {
            $ask_name = 1;
        }
        if ($this->data['mlev'] == 4) {
            $ask_name = 1;
        }


        $ref = $_SERVER["HTTP_REFERER"];
        $USERIP = $_SERVER["REMOTE_ADDR"];
        $uid = "uid-not-set";

        $aid = $_POST["ad_id"]; // foo bar 
        $comment = $_POST["comment"]; // baz

        $confi = config_item('realt_number_error_mark');

        if (likeList($comment, $confi)) {

// неправильный  номер 
            $c_ad_uid = getAdUid($aid);

            if (getAdUpdate($aid) == "0000-00-00 00:00:00") {
                $this->putModerate($c_ad_uid);
            }


        }
        ;

// проверка на спам слова
		if ($this->chkSpam($comment)) {
                    echo ("<h2>К сожалению, ваш комментарий запрещен.</h2>   <br> Скорее всего он нарушает правила сайта или содержит рекламу. <br></i>");
                    return;
                     
                };
		
		
	// проверка на наличие тегов и ссылок

$input_text = strip_tags($comment);
$input_text = htmlspecialchars($input_text);
$input_text = mysql_escape_string($input_text);
$comment = $input_text;
	
		
		
		
		
        $ad_id = (int)($CI->uri->segment(4));

        $mode = $_POST['mode'];
        $screen_name = $_POST['screen_name'];
        $sn = $_POST['sn'];


        switch ($mode) {
            case "addcomment":
// проверка отправленного кода

//3DXxZRKh


                if ($comment == "") {

                    echo ("
 $header  Вы не написали сообщение. <br><a href='http://neagent.by/realt/ad_comment/$aid'>< вернуться</a>");

                    return;
                }

                if ($sn == "1" && $screen_name == "") {

                    echo ("
 $header  Вы не указали имя. <br><a href='http://neagent.by/realt/ad_comment/$aid'>< вернуться</a>");

                    return;
                } else {


                    $dat = array(
                        screen_name => $screen_name
                    );

                    $CI->db->where('id_user', $userid);
                    $CI->db->update('users', $dat);


                }


                $postdate = date("Y-m-d H:i:s");
                $uid = $_COOKIE["uid"];


                $data = array(
                    comment_ad => $aid,
                    comment_text => $comment,
                    comment_table => 'ads',
                    comment_date => $postdate,
                    comment_uid => $uid,
                    comment_user => $userid,
                    comment_state => 0 // только что отправленный, не проверенный и т.п.
                );


                $perm = userPermissions($userid);
                if ($perm["moderate_comments"] == 1) {
                    $data['comment_show'] = 0;
                    $data['comment_state'] = 0; // ждет модерации 
                }


                $CI->db->insert('realt_ads_comments', $data);
                //echo 	($CI->db->last_query());
                $usql = "UPDATE `" . $data['comment_table'] . "` SET `ad_comments_count` = `ad_comments_count` + 1 WHERE `ad_id` = '" . $aid . "' LIMIT 1;";
                $CI->db->query($usql);


                if ($perm["moderate_comments"] == 1) {
                    echo ("$header Комментарий будет проверен и добавлен");
                } else {


                    echo ("$header Комментарий добавлен");


                }


            case " ":

                $ctext = "агентство";
                break;
            case 3:
                $ctext = "другое";
                break;
            default:


                $string = "
$header
<form action='http://neagent.by/realt/ad_comment/' method='POST'>
<div class='popframe_text'>
<input type='hidden' name='mode' value='addcomment'>
<input type='hidden' name='ad_id' value='$ad_id'><h3 style='padding-bottom:0;padding-top:0;' >Написать комментарий</h3>
 
";

                if ($ask_name == 1) {

                    $string .= "
<input type='hidden' name='sn' value='1'>
<small style='font-size:11px;'>Внимание, автор не обязательно увидит его! </small>
<br><b>Укажите имя, которое будет отображаться в комментариях: </b><br>
<input name='screen_name' value='' style='width: 270px; '><br>
<b>Текст комментария: </b><br>
<textarea name='comment' style='width: 270px; height:30px;'></textarea>";
                } else {

                    $string .= "<small style='font-size:11px;'> Внимание, автор не обязательно увидит его! Вопросы к автору объявления задавайте по телефону. </small><textarea name='comment' style='width: 270px; height:80px;'></textarea>";
                }


                $string .= "	</div>
<div class='popframe_bottom'>
<input type='submit' value='Отправить'>
 </div>
 
 </form>
 ";


                echo($string);


                break;
        }


    }


    function ad_options()
    {
        //header('Content-type: application/xml; charset=utf-8');
        $header = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head><meta http-equiv='content-type' content='text/html; charset=utf-8' /><link rel='stylesheet' href='http://neagent.by/themes/neagent_style/assets/css/style.css' type='text/css' media='screen, projection' /></head><body class='popframe'>";


        //////////////////////////////////////	  
        $userLevel = "";
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $user = $CI->connect->get_current_user();
        if (($user['group']['group_name']) == 'Super Admins') {
            $this->data['mlev'] = 4;
        }
        ;
        ///////////////////////////////////


        $ref = $_SERVER["HTTP_REFERER"];
        $USERIP = $_SERVER["REMOTE_ADDR"];
        $uid = "uid-not-set";
        $c_autor_type = $_COOKIE["IUser"];


        $aid = $_POST["aid"]; // foo bar 
        $complaint = $_POST["complaint"]; // baz
        $mtext = $_POST['report'];
        $ajax = $_POST['ajax'];
        $email = $_POST['email'];


        $ad_id = (int)($CI->uri->segment(4));
        $mode = $_POST['mode'];
        $mode = $_POST['mode'];

        if ($CI->uri->segment(4) == "remember") {
            $mode = 'remember';
            $ad_id = (int)($CI->uri->segment(5));

        }


        switch ($mode) {

            case "sendcode":


                $CI->db->select('*');
                $CI->db->where('ad_id', $aid);
                $CI->db->where('ad_email', $email);
                $CI->db->from('ads');
                $CI->db->limit(1);
                $query = $CI->db->get();

//echo $CI->db->_error_message();
//echo $CI->db->last_query();

                if ($query->num_rows() != 0) {
                    foreach ($query->result() as $row) {
                        $code = $row->ad_secretcode;
                    }
                } else {
                    echo("Неверно указан адрес электронной почты.");
                    break;
                }


                $data['ad_show'] = 0;
                $data['ad_pending'] = 1;
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $CI->load->library('email', $config);
                $CI->email->set_newline("\r\n");
                $CI->email->from('info@neagent.by');
                $CI->email->to($email);
                $CI->email->subject('Восстановление секретного кода Neagent.by ');
                $CI->email->message('Код: ' . $code);
                $CI->email->send();


                echo("Секретный код отправлен на email " . $email);


                break;
            case "remember":

                echo("
 $header
<form action='http://neagent.by/realt/ad_options/' method='POST'>
<div class='popframe_text'>
<input type='hidden' name='mode' value='sendcode'>
<input type='hidden' name='aid' value='$ad_id'><h3>Удаление объявления</h3>Введите email, который вы указали при подаче объявления<br>
<input type='text' name='email' value=''>
<br> 
</div>
<div class='popframe_bottom'>
<input type='submit' value='Выслать код'>
 </div>
 
 </form>
 ");


                break;


            case "checkcode":
// проверка отправленного кода

//3DXxZRKh

                $secretcode = $_POST['secretcode'];
                $secretcode2 = $_POST['secretcode'];
                $secretcode = rtrim(trim($secretcode));
                $secretcode = str_replace("'", "''", $secretcode);
                $secretcode = str_replace(";", "", $secretcode);

//echo ("secretcode" . $secretcode);

                if ($secretcode == "") {

                    echo ("
 $header  Вы не ввели код. <br><a href='http://neagent.by/realt/ad_options/$ad_id'>< вернуться</a>");

                    return;
                }


                if (strlen($secretcode) < 2) {
//echo (" $header  Это объявление заколдовано. <br>Его удалить нельзя.   <br><a href='http://neagent.by/realt/ad_options/$ad_id'>< вернуться</a>");

                    echo ("$header Ваше объявление удалено");


                    $ad_id = (int)$_POST['ad_id'];
                    $USERIP = $_SERVER["REMOTE_ADDR"];
                    $uid = $_COOKIE["uid"];
                    $mess_1 = 'попытка удалить объявление №' . $ad_id . "; uid удалившего " . $uid . "; IP " . $USERIP . "ввели код" . $secretcode2;


                    //echo (" - ");
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $CI->load->library('email', $config);
                    $CI->email->set_newline("\r\n");
                    $CI->email->from('dakh@mail.ru');
                    $CI->email->to('dakh@mail.ru');
                    $CI->email->subject('попытка удалить');
                    $CI->email->message($mess_1);
                    //echo (" - ");

                    $this->saveDeleteInfoToLog("попытка удалить объявление №" . $ad_id . " ввели код" . $secretcode2);

                    $CI->email->send();

                    //$CI->email->print_debugger();

                    return;
                }


                $ad_id = (int)$_POST['ad_id'];
//echo ("ad_id=" . $ad_id." ");
                $CI->db->where('ad_secretcode', $secretcode);
                $CI->db->where('ad_id', $ad_id);
                $CI->db->from('ads');
                $co = $CI->db->count_all_results();
                //echo ("ad_id=" . $ad_id ." ");
                //echo ("ad_id=" . $secretcode ." ");
                //echo ("результат" . $co . " ");

                $str00 = $CI->db->last_query() . " ";

                if ($co > 0) {
// УДАЛЯЕМ 
                    $USERIP = $_SERVER["REMOTE_ADDR"];
                    $uid = $_COOKIE["uid"];


                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $CI->load->library('email', $config);
                    $CI->email->set_newline("\r\n");
                    $CI->email->from('dakh@mail.ru');
                    $CI->email->to('dakh@mail.ru');
                    $CI->email->subject('удаляют объявление');
                    $CI->email->message('Удалили объявление №' . $ad_id . "; uid удалившего " . $uid . "; IP " . $USERIP);
//$CI->email->send();
                    //echo $CI->email->print_debugger();
//End end that love letter

//$CI->db->update('ads', array('ad_show' => "0"), "ad_id = '$ad_id'");	
//echo $CI->db->_error_message();	

                    $data = array('ad_show' => "0", "ad_delete_reazon" => 4);
                    $CI->db->where('ad_id', $ad_id);
                    $CI->db->like('ad_secretcode', $secretcode);
                    $CI->db->update('ads', $data);

                    $str = "Удалили объявление №" . $ad_id . "(введен код " . $secretcode . ") ";

                    $this->saveDeleteInfoToLog($str);


                    echo ("$header Ваше объявление удалено");


                } else {
                    echo ("
 $header
неправильный код.<br><a href='http://neagent.by/realt/ad_options/$ad_id'>< вернуться</a>");

//echo("c=".$secretcode."; c2=" . $secretcode2);
//print_r ($_POST);
                    return;


                }


            case " ":

                $ctext = "агентство";
                break;
            case 3:
                $ctext = "другое";
                break;
            default:


                echo("
 $header
<form action='http://neagent.by/realt/ad_options/' method='POST'>
<div class='popframe_text'>
<input type='hidden' name='mode' value='checkcode'>
<input type='hidden' name='ad_id' value='$ad_id'><h3>Удаление объявления</h3>Введите секретный код, который вы получили при подаче объявления<br>
<input type='text' name='secretcode' value=''>
 <br><small style='font-size:11px;'><a href='http://neagent.by/realt/ad_options/remember/$ad_id' style=''>Забыли код?</a></small>
<br>
</div>
<div class='popframe_bottom'>
 
<input type='submit' value='Удалить '> 
 
 </div>
 
 </form>
 ");


                break;
        }


    }


    /**
     * Return a JSON error message and stop the script
     *
     * @param    String        Error message
     *
     */


    // ------------------------------------------------------------------------


    /**
     * Clean the file name for security
     *
     *
     * @access    public
     * @param    string
     * @return    string
     */


    // --------------------------------------------------------------------


    /**
     * Prep Filename
     * Copied from CI Upload lib as this lib is a Upload lib private one.
     *
     * Prevents possible script execution from Apache's handling of files multiple extensions
     * http://httpd.apache.org/docs/1.3/mod/mod_mime.html#multipleext
     *
     * @access    private
     * @param    string
     * @return    string
     *
     */


    // --------------------------------------------------------------------


    /**
     * List of Mime Types
     * Copied from CI
     *
     * This is a list of mime types.  We use it to validate
     * the "allowed types" set by the developer
     *
     * @access    public
     * @param    string
     * @return    string
     */


    // ------------------------------------------------------------------------


    /**
     * Prepare and sends the mails.
     *
     * @param  string
     * @param  string
     * @param  string
     * @return bool
     */


    function streets()
    {
// header("Content-type: text/xml");
        echo '["Рокоссовсого, ул","Якубова, ул"]';
    }

	
	 function autocomplete()
    {
// header("Content-Type: application/json"); 
//header('Content-Type: text/html; charset=utf-8');
$str=' 
{
"query":"Li", 
"suggestions":["Liberia","Libyan Arab","Liechtenstein","Lithuania"], 
"data":["LR","LY","LI","LT"] 
}
	 ';
//header("Content-type: text/xml");
$str="";
$CI =& get_instance();
parse_str($_SERVER['QUERY_STRING'], $_GET);
  $r=isset($_GET['query']) ?   (string)$_GET['query'] :false;
   $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('info@neagent.by');
        $CI->email->to('dakh2008@mail.ru');
        $CI->email->subject('upl adtype= '  );
        $CI->email->message($r);
 //$CI->email->send();
//echo ($_GET['q']);
$q= isset($_GET['q']) ? $_GET['q'] : false;
//$q=urldecode($_GET['q']);
$str=' 
{
"query":"' . $q . '",';
//$str.=$q;
// echo($p);
//$p =  iconv(  "windows-1251", "UTF-8",  $p) ;
// echo($p);
$CI->db->where('city', 1);
$CI->db->like('LOWER(name)', strtolower($r));
// $CI->db->like('name', $q);
$CI->db->from("realt_streets");
$query = $CI->db->get();
// echo($CI->db->last_query());
// echo($CI->db->_error_message());
if ($query->num_rows() == 0) {
$str.='"suggestions":[';    
$str.=']}'; 
} else {
$values = array();
$i = 0;
$str.='"suggestions":['; 
$qq="";
foreach ($query->result() as $row) {
			$i = $i +1;
			//$str.= $row->id . "|" . $row->name . "|" . $row->prefix . "\n";
            $str.=$qq . '"'.$row->name. ' '    . $row->prefix .'"'; 
			$qq=',';
            }
			$str.=']}'; 
            //$result = $query->row_array();
        }
  echo $str;
}



 function autocompletephone()
    {
// header("Content-Type: application/json"); 
//header('Content-Type: text/html; charset=utf-8');
$str=' 
{
"query":"Li", 
"suggestions":["Liberia","Libyan Arab","Liechtenstein","Lithuania"], 
"data":["LR","LY","LI","LT"] 
}
	 ';
//header("Content-type: text/xml");
$str="";
if (!$CI) {$CI =& get_instance();}
$user = $CI->connect->get_current_user();  
$phonesArr=suggestUserPhones($user['id_user']);
//$phonesArr=suggestUserPhones(1);
//print_r($phonesArr);
parse_str($_SERVER['QUERY_STRING'], $_GET);
  $r=(string)$_GET['query'];
   $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('info@neagent.by');
        $CI->email->to('dakh2008@mail.ru');
        $CI->email->subject('upl adtype= ' . $adtype);
        $CI->email->message($r);
 //$CI->email->send();
//echo ($_GET['q']);
$q= $_GET['q'];
//$q=urldecode($_GET['q']);
$str='{"query":"' . $q . '",';




if (!$phonesArr) {
$str.='"suggestions":[';    
$str.=']}'; 
} else {
$values = array();
$i = 0;
$str.='"suggestions":['; 
$qq="";
for ($k = 0; $k < count($phonesArr); $k++) {
			$i = $i +1;
			//$str.= $row->id . "|" . $row->name . "|" . $row->prefix . "\n";
			 $base_url = str_replace(",", ".", $phonesArr[$k]); 
			 $base_url = str_replace('"', " ", $phonesArr[$k]); 
            $str.=$qq . '"'.$phonesArr[$k] . '"'; 
			$qq=',';
            }
			$str.=']}'; 
            //$result = $query->row_array();
        }
  echo $str;
}


    ///////////////////////////// Скрипт загрузки файлов 

	
	function email(){




$ci = get_instance();
$ci->load->library('SMPT_email');
$config['protocol'] = "smtp";
$config['smtp_host'] = "ssl://smtp.gmail.com";
$config['smtp_port'] = "465";
$config['smtp_user'] = "vabhtc@gmail.com"; 
$config['smtp_pass'] = "lufaulufauvG";
$config['charset'] = "utf-8";
$config['mailtype'] = "html";
$config['newline'] = "\r\n";
$config['smtp_user'] = "vabhtc@gmail.com"; 


$ci->SMPT_email->initialize($config);

$ci->SMPT_email->from('vabhtc@gmail.com', 'Blabla');
//$list = array('8888@gmail.com', '77756767756756756775675675675677567567567567567@gmail.com');
//$ci->SMPT_email->to($list);
$ci->SMPT_email->to('dakh@mail09.ru87');
$ci->SMPT_email->reply_to('my-email@gmail.com', 'Explendid Videos');
$ci->SMPT_email->subject('This is an email test');
$ci->SMPT_email->message('It is working. Great!'); 
$ci->SMPT_email->return_path('dakh2008@mail.ru'); // return path добавлено мной 
$result = $ci->SMPT_email->send();  // дата

  

 echo $ci->SMPT_email->print_debugger();


echo strtotime($result);

//$CI->email->set_newline("\r\n");

// Set to, from, message, etc.

//$result = $CI->SMPT_email->send();
echo 	 $result;
	
	
	
	
	
	
	
	 
	 
	}
	
	
	
	
	
	
function smpt_mail_demon(){

//$host        = 'imap.mail.ru';
//$port        =  993;
//$login       = 'uchetonline@mail.ru';
///$pass        = 'lufaulufauuM';
//$param       = '/imap/ssl/novalidate-cert';
//$folder      = 'INBOX';

$ci = get_instance();
$ci->load->library('SMPT_email');
$config['protocol'] = "smtp";
$config['smtp_host'] = "imap.mail.ru";
$config['smtp_port'] = "993";
$config['smtp_user'] = "uchetonline@mail.ru"; 
$config['smtp_pass'] = "lufaulufauuM";
$config['charset'] = "utf-8";



 //$config['smtp_host'] = "imap.yandex.ru";
 //$config['smtp_port'] = "993";
 //$config['smtp_user'] = "sergej-minich"; 
 //$config['smtp_pass'] = "lufaulufausY";
 ///$config['smtp_port'] = "25";

 
$config['smtp_host'] = "imap.gmail.com";
$config['smtp_port'] = "993";
$config['smtp_user'] = "vabhtc@gmail.com"; 
$config['smtp_pass'] = "lufaulufauvG";
//$config['charset'] = "iso-8859-1"; 
 //iso-8859-1 or us-ascii

$ci->SMPT_email->initialize($config);

$ci->SMPT_email->checkmail($config);



 
return 0;
	
	
}
	
	
	
	
	
	
	
	
	
	
	

    function upload($adtype)
    {
	error_reporting (0);
        // Upload folder
        //echo ($adtype);	 exit;
        $CI =& get_instance();
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh@mail.ru');
        $CI->email->to('dakh@mail.ru');
        $CI->email->subject('upl adtype= ' . $adtype);
        $CI->email->message($messagestr);
//$CI->email->send();


        $upload_path = config_item('realt_temp_upload_folder');
        // Upload result
        $return = array();

        /**
         * Get the connected users data
         * These data are encrypted through the CI Encryption library
         *
         */
        if (empty($this->encrypt))
            $this->load->library('encrypt');

        //$username = $this->encrypt->decode(rawurldecode($_POST['usrn']));
        //$email = $this->encrypt->decode(rawurldecode($_POST['usre']));

        // Try to get the user
        //$user = Connect()->get_user($username);

        // If we have an user and an upload path
        //if ($user && $upload_path != false && $upload_path !='')
        //{
        // Users group
        //$usergroup = Connect()->get_group($user['id_group']);

        // Fancy upload upload allowed group
        //$fancygroup = Connect()->get_group(config_item('fancyupload_group'));

        /**
         * If the users email and the users group has the right to upload,
         * we can start uploading
         *
         */
        //if ($user['email'] == $email && $usergroup['level'] >= $fancygroup['level'])
        //{
        // Do we get a file ?
        if (!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name'])) {


            //echo ("error: nofile "  );

            //echo ($_FILES['Filedata'] );
            //echo ($_FILES['Filedata']['tmp_name']);

            //exit("-");
            $this->error(lang('module_fancyupload_invalid_upload'));
        } else {


            // Before move : Clean the file name
            // and add user email to file name if defined

            //$new_file_name = $this->_prep_filename($this->clean_file_name($_FILES['Filedata']['name']));

            $new_file_name = $this->_make_filename($this->clean_file_name($_FILES['Filedata']['name']));

            //echo ("error: newfilename =" . $new_file_name) ;
            //exit("-");


            //if (config_item('board_file_prefix') == '1')
            //{
            //	$new_file_name = $email . '_' . $new_file_name;
            //}				

            if (!@move_uploaded_file($_FILES['Filedata']['tmp_name'], config_item('realt_temp_upload_folder') . $new_file_name)) {
                $return['status'] = '0';


                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $CI->load->library('email', $config);
                $CI->email->set_newline("\r\n");
                $CI->email->from('dakh@mail.ru');
                $CI->email->to('dakh@mail.ru');
                $CI->email->subject("не удалось ");
                $CI->email->message("");
//$CI->email->send();


                echo ("error: est file 0 root =" . $_SERVER["DOCUMENT_ROOT"] . " ; " . $_FILES['Filedata']['tmp_name'] . " - " . $new_file_name . config_item('realt_temp_upload_folder'));
                exit("-");

            } else {
                $return['status'] = '1';


                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $CI->load->library('email', $config);
                $CI->email->set_newline("\r\n");
                $CI->email->from('dakh@mail.ru');
                $CI->email->to('dakh@mail.ru');
                $CI->email->subject("удалось ");
                $CI->email->message("");
//$CI->email->send();

                //сделать картинку 75x100  изатем ее выдать 	
                //
                $f = config_item('realt_temp_upload_folder') . $new_file_name;
                $newf = config_item('realt_temp_upload_folder') . "t_" . $new_file_name;
                $type = 0; // картинка будет   36 х 36

                if ($adtype == 'sutki') {
                    $type = 1; // картинка будет   72 х 72
                }


                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $CI->load->library('email', $config);
                $CI->email->set_newline("\r\n");
                $CI->email->from('dakh@mail.ru');
                $CI->email->to('dakh@mail.ru');
                $CI->email->subject("удалось0 ");
                $CI->email->message($f . "--" . $newf . "--" . $type);
//$CI->email->send();				   


                $thumb_file_name = $this->resizePic($f, $newf, $type);
                $thumb_file_name = $newf;


                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $CI->load->library('email', $config);
                $CI->email->set_newline("\r\n");
                $CI->email->from('dakh@mail.ru');
                $CI->email->to('dakh@mail.ru');
                $CI->email->subject("удалось1 ");
                $CI->email->message($newf);
//$CI->email->send();					


                $f1 = $f; // это файл полный 
                $f2 = str_replace("/tmp/", "/tmp/temp_", $f); // это  новый путь файл полный

                if (!copy($f1, $f2)) {
                    echo "error: failed to copy file1...\n";
                }


                echo ("http://neagent.by/modules/Realt/files/tmp/" . "t_" . $new_file_name);

                $type = 3;
                $r_file_name = $this->resizePic($f2, $f, $type);

                unlink($f2);


                exit("");


                // Send an alert mail to the admin if the option is set.
                if (config_item('fancyupload_send_alert') == '1' && config_item('fancyupload_email') != '') {
                    $to = config_item('fancyupload_email');

                    $subject_admin = lang('fancyupload_alert_mail_subject') . ' : ' . $user['screen_name'];

                    // Email preparation
                    $data = array(
                        'username' => $user['username'],
                        'screen_name' => $user['screen_name'],
                        'email' => $user['email'],
                        'filename' => $new_file_name,
                        'upload_date' => date('d.m.Y H:i:s'),
                        'upload_folder' => config_item('fancyupload_folder')
                    );

                    // Email to Admin
                    $message = $this->load->view('emails/fancyupload_upload_admin_alert', $data, true);

                    $this->send_mail($to, $message, $subject_admin);
                }
            }
            $return['src'] = config_item('fancyupload_folder') . $new_file_name;

        }
        //}
        // The user mail is not corresponding to the saved mail or the user group level < authorized group : 
        // Not allowed to upload
        //else
        //{
        $this->error(lang('module_fancyupload_no_right'));

        //}
        //}

        echo json_encode($return);
    }


    /**
     * Return a JSON error message and stop the script
     *
     * @param    String        Error message
     *
     */
    function error($message)
    {
        $return = array(
            'status' => '0',
            'error' => $error
        );
        echo $return;

        die();
    }


    // ------------------------------------------------------------------------


    /**
     * Clean the file name for security
     *
     *
     * @access    public
     * @param    string
     * @return    string
     */
    function clean_file_name($filename)
    {
        $bad = array(
            "<!--",
            "-->",
            "'",
            "<",
            ">",
            '"',
            '&',
            '$',
            '=',
            ';',
            '?',
            '/',
            "%20",
            "%22",
            "%3c", // <
            "%253c", // <
            "%3e", // >
            "%0e", // >
            "%28", // (
            "%29", // )
            "%2528", // (
            "%26", // &
            "%24", // $
            "%3f", // ?
            "%3b", // ;
            "%3d" // =
        );

        $filename = str_replace($bad, '', $filename);


        return stripslashes($filename);
    }


    // --------------------------------------------------------------------


    /**
     * Prep Filename
     * Copied from CI Upload lib as this lib is a Upload lib private one.
     *
     * Prevents possible script execution from Apache's handling of files multiple extensions
     * http://httpd.apache.org/docs/1.3/mod/mod_mime.html#multipleext
     *
     * @access    private
     * @param    string
     * @return    string
     *
     */

    function _getlastfilename()
    {
        if (!$CI) {
            $CI =& get_instance();
        }


        $CI->db->where('name', 'lastfilename');
        $CI->db->from("realt_settings");
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            $lfn = 0;

            $data = array(name => 'lastfilename', content => $lfn);
            $CI->db->insert('realt_settings', $data);


        } else {

            $values = array();
            $i = 0;
            foreach ($query->result() as $row) {
                $lfn = (int)$row->content + 1;

                $CI->db->where('name', 'lastfilename');
                $this->db->set('content', $lfn);
                $this->db->update('realt_settings');


                $i++;
            }
            //$result = $query->row_array();
        }
        ;


        return $lfn;


    }


    function _make_filename($filename)
    {
        if (strpos($filename, '.') === FALSE) {
            $filename = $this->_getlastfilename();
            return $filename;
        }

        $parts = explode('.', $filename);
        $ext = array_pop($parts);
        $filename = array_shift($parts);


        $filename = $this->_getlastfilename();


        // file name override, since the exact name is provided, no need to
        // run it through a $this->mimes check.
        /*
		if ($this->file_name != '')
		{
			$filename = $this->file_name;
		}
		*/

        $filename .= '.' . $ext;
        //echo $filename;
        return $filename;
    }


    function _prep_filename($filename)
    {
        if (strpos($filename, '.') === FALSE) {
            return $filename;
        }

        $parts = explode('.', $filename);
        $ext = array_pop($parts);
        $filename = array_shift($parts);

        foreach ($parts as $part) {
            if ($this->mimes_types(strtolower($part)) === FALSE) {
                $filename .= '.' . $part . '_';
            } else {
                $filename .= '.' . $part;
            }
        }

        // file name override, since the exact name is provided, no need to
        // run it through a $this->mimes check.
        /*
		if ($this->file_name != '')
		{
			$filename = $this->file_name;
		}
		*/

        $filename .= '.' . $ext;

        return $filename;
    }


    // --------------------------------------------------------------------


    /**
     * List of Mime Types
     * Copied from CI
     *
     * This is a list of mime types.  We use it to validate
     * the "allowed types" set by the developer
     *
     * @access    public
     * @param    string
     * @return    string
     */
    function mimes_types($mime)
    {
        global $mimes;

        if (count($this->mimes) == 0) {
            if (@require_once(APPPATH . 'config/mimes' . EXT)) {
                $this->mimes = $mimes;
                unset($mimes);
            }
        }

        return (!isset($this->mimes[$mime])) ? FALSE : $this->mimes[$mime];
    }


    // ------------------------------------------------------------------------


    /**
     * Prepare and sends the mails.
     *
     * @param  string
     * @param  string
     * @param  string
     * @return bool
     */
    private function send_mail($to, $message, $subject = 'Upload')
    {
        $CI =& get_instance();

        if (!isset($CI->email))
            $CI->load->library('email');

        $CI->email->from(Settings::get('site_email'), Settings::get('site_title'));
        $CI->email->to($to);
        $CI->email->subject($subject);

        $CI->email->message($message);

        return $CI->email->send();
    }


    public function resizePic($f, $newf, $type)
    {
// $type=1;
        //'/home/vabby/www/tolkuchka.by/modules/Board/files/tmp/'
// $f="/home/vabby/www/tolkuchka.by/modules/Board/files/tmp/00.jpg";
// $newf="/home/vabby/www/tolkuchka.by/modules/Board/files/tmp/r_00.jpg";


// f - имя файла
// type - способ масштабирования
// q - качество сжатия
// src - исходное изображение
// dest - результирующее изображение
// w - ширниа изображения
// ratio - коэффициент пропорциональности
// str - текстовая строка
        $w = 90;
// тип преобразования, если не указаны размеры
        if ($type == 0) $w = 36; // квадратная 36x36
        if ($type == 1) $w = 72; // квадратная 72x72 ' для суток
        if ($type == 2) $w = 550; // пропорциональная шириной 218
        if ($type == 3) $w = 550; // пропорциональная шириной до 550
        if ($type == 4) $w = 100;
        $h = 75; // пропорциональная шириной до 70x100

// качество jpeg по умолчанию
        if (!isset($q)) $q = 100;


        $CI =& get_instance();
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh@mail.ru');
        $CI->email->to('dakh@mail.ru');
        $CI->email->subject("resize enter ");
        $CI->email->message(strtolower($f));
//$CI->email->send();	


// создаём исходное изображение на основе
// исходного файла и опеределяем его размеры

        if (strpos(strtolower($f), ".jpg") == (strlen($f) - 4)) {
            $src = imagecreatefromjpeg($f);
        }
        if (strpos(strtolower($f), ".jpeg") == (strlen($f) - 5)) {
            $src = imagecreatefromjpeg($f);
        }
        if (strpos(strtolower($f), ".gif") == (strlen($f) - 4)) {
            $src = imagecreatefromgif($f);
        }
        if (strpos(strtolower($f), ".png") == (strlen($f) - 4)) {
            $src = imagecreatefrompng($f);
        }

        $w_src = imagesx($src);
        $h_src = imagesy($src);


//echo $h_src;
// если размер исходного изображения
// отличается от требуемого размера
        if ($w_src != $w && 1 != 0) {
// операции для получения прямоугольного файла
            if ($type == 2) {
                // вычисление пропорций
                $ratio = $w_src / $w;
                $w_dest = round($w_src / $ratio);
                $h_dest = round($h_src / $ratio);

                // создаём пустую картинку
                // важно именно truecolor!, иначе будем иметь 8-битный результат
                $dest = imagecreatetruecolor($w_dest, $h_dest);
                $str = "neagent.by";
                imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

                // определяем координаты вывода текста
                $size = 2; // размер шрифта
                $x_text = $w_dest - imagefontwidth($size) * strlen($str) - 3;
                $y_text = $h_dest - imagefontheight($size) - 3;

                // определяем каким цветом на каком фоне выводить текст
                $white = imagecolorallocate($dest, 255, 255, 255);
                $black = imagecolorallocate($dest, 0, 0, 0);
                $gray = imagecolorallocate($dest, 127, 127, 127);
                if (imagecolorat($dest, $x_text, $y_text) > $gray) $color = $black;
                if (imagecolorat($dest, $x_text, $y_text) < $gray) $color = $white;

                // выводим текст
                imagestring($dest, $size, $x_text - 1, $y_text - 1, $str, $white - $color);
                imagestring($dest, $size, $x_text + 1, $y_text + 1, $str, $white - $color);
                imagestring($dest, $size, $x_text + 1, $y_text - 1, $str, $white - $color);
                imagestring($dest, $size, $x_text - 1, $y_text + 1, $str, $white - $color);

                imagestring($dest, $size, $x_text - 1, $y_text, $str, $white - $color);
                imagestring($dest, $size, $x_text + 1, $y_text, $str, $white - $color);
                imagestring($dest, $size, $x_text, $y_text - 1, $str, $white - $color);
                imagestring($dest, $size, $x_text, $y_text + 1, $str, $white - $color);

                imagestring($dest, $size, $x_text, $y_text, $str, $color);
            }


            if ($type == 4) {

                // создаём пустую прям  картинку
                // важно именно truecolor!, иначе будум иметь 8-битный результат
                $dest = imagecreatetruecolor($w, $h);

                // вырезаем квадратную серединку по x, если фото горизонтальное
                if ($w_src > $h_src)
                    imagecopyresampled($dest, $src, 0, 0, round((max($w_src, $h_src) - min($w_src, $h_src)) / 2), 0, $w, $h, min($w_src, $h_src), min($w_src, $h_src));

                // вырезаем квадратную верхушку по y,
                // если фото вертикальное (хотя можно тоже середику)
                if ($w_src < $h_src) {

                    imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, min($w_src, $h_src), min($w_src, $h_src));

                }
                // квадратная картинка масштабируется без вырезок
                if ($w_src == $h_src)
                    imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $w_src, $w_src);


            }


            if ($type == 3) {
                if ($w_src > $w) {


                    // вычисление пропорций
                    $ratio = $w_src / $w;
                    $w_dest = round($w_src / $ratio);
                    $h_dest = round($h_src / $ratio);

                    // создаём пустую картинку
                    // важно именно truecolor!, иначе будем иметь 8-битный результат
                    $dest = imagecreatetruecolor($w_dest, $h_dest);
                    $str = "neagent.by";
                    imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

                    // определяем координаты вывода текста
                    $size = 2; // размер шрифта
                    $x_text = $w_dest - imagefontwidth($size) * strlen($str) - 3;
                    $y_text = $h_dest - imagefontheight($size) - 3;

                    // определяем каким цветом на каком фоне выводить текст
                    $white = imagecolorallocate($dest, 255, 255, 255);
                    $black = imagecolorallocate($dest, 0, 0, 0);
                    $gray = imagecolorallocate($dest, 127, 127, 127);
                    if (imagecolorat($dest, $x_text, $y_text) > $gray) $color = $black;
                    if (imagecolorat($dest, $x_text, $y_text) < $gray) $color = $white;

                    // выводим текст
                    imagestring($dest, $size, $x_text - 1, $y_text - 1, $str, $white - $color);
                    imagestring($dest, $size, $x_text + 1, $y_text + 1, $str, $white - $color);
                    imagestring($dest, $size, $x_text + 1, $y_text - 1, $str, $white - $color);
                    imagestring($dest, $size, $x_text - 1, $y_text + 1, $str, $white - $color);
                    imagestring($dest, $size, $x_text - 1, $y_text, $str, $white - $color);
                    imagestring($dest, $size, $x_text + 1, $y_text, $str, $white - $color);
                    imagestring($dest, $size, $x_text, $y_text - 1, $str, $white - $color);
                    imagestring($dest, $size, $x_text, $y_text + 1, $str, $white - $color);
                    imagestring($dest, $size, $x_text, $y_text, $str, $color);

                } else {

                    $dest = @imagecreatetruecolor($w_src, $h_src);
                    imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_src, $h_src, $w_src, $h_src);
                    //readfile($f);

                }


            }


            // операции для получения квадратного файла
            if (($type == 0) || ($type == 1)) {
                //echo ("type=" . $type);
                //echo ("w_src=" . $w_src);
                //echo ("h_src=" . $h_src);
                // создаём пустую квадратную картинку
                // важно именно truecolor!, иначе будум иметь 8-битный результат
                $dest = @imagecreatetruecolor($w, $w);
                ////////or die('Cannot Initialize new GD image stream');

////echo ("-----------w=". $w . "--");
                // вырезаем квадратную серединку по x, если фото горизонтальное
                if ($w_src > $h_src)
                    imagecopyresampled($dest, $src, 0, 0, round((max($w_src, $h_src) - min($w_src, $h_src)) / 2), 0, $w, $w, min($w_src, $h_src), min($w_src, $h_src));

                // вырезаем квадратную верхушку по y,
                // если фото вертикальное (хотя можно тоже середику)
                if ($w_src < $h_src) {
                    // echo ("-1-");
                    imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $w, min($w_src, $h_src), min($w_src, $h_src));
                    // echo ("-2-");

                }
                // квадратная картинка масштабируется без вырезок
                if ($w_src == $h_src)
                    imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $w, $w_src, $w_src);
            }

            // вывод картинки и очистка памяти

            //echo "http--------d=" . $dest;
            //echo "-d2=" .$newf;

            imagejpeg($dest, $newf, $q);
            imagedestroy($dest);
            imagedestroy($src);
        } // если картинка не требует масштабирования
// выводим её напрямую
        else {
            readfile($f);
        }

        return 1;

    }


    ///////////////////////////// Конец скрипт загрузки файлов


} // конеw класса 









function decodeHeader($hdr, $cset = 'UTF8')
	{
		// Copied nearly intact from PEAR's Mail_mimeDecode.
		$hdr = preg_replace('/(=\?[^?]+\?(q|b)\?[^?]*\?=)(\s)+=\?/i', '\1=?', $hdr);
		$m = array();
		if(is_array($hdr))
			$hdr = $hdr[0];
		while(preg_match('/(=\?([^?]+)\?(q|b)\?([^?]*)\?=)/i', $hdr, $m))
		{
			$encoded  = $m[1];
			$charset  = strtoupper($m[2]);
			$encoding = strtolower($m[3]);
			$text     = $m[4];
 
			switch($encoding)
			{
				case 'b':
					$text = base64_decode($text);
					break;
				case 'q':
					$text = str_replace('_', ' ', $text);
					preg_match_all('/=([a-f0-9]{2})/i', $text, $m);
					foreach($m[1] as $value)
                    $text = str_replace('=' . $value, chr(hexdec($value)), $text);
					break;
			}
			if($charset !== $cset)
				$text = charconv($charset, $cset, $text);
			$hdr = str_replace($encoded, $text, $hdr);
		}
		return $hdr;
	}
 
    /* workaround to make most of headers to parse properly */
	function charconv($enc_from, $enc_to, $text)
	{
		if(function_exists('iconv'))
			return iconv($enc_from, $enc_to, $text);
		elseif(function_exists('recode_string'))
        return recode_string("$enc_from..$enc_to", $text);
		elseif(function_exists('mb_convert_encoding'))
        return mb_convert_encoding($text, $enc_to, $enc_from);
		return $text;
	}
/* End of file fancyupload.php */
/* Location: ./modules/Fancyupload/controllers/fancyupload.php */