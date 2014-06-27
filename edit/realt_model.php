<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');







class Realt_model extends Base_model
{
    public $CI;
    public $data;
    public $user;
    public $route;
    public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('realt');
		$this->load->helper('user');
        $this->load->helper('map');
        $this->load->helper('smartsearch');
        $this->load->helper('code');
		$this->data['wap_view']=0;
		 
		
		if(!$this->CI){
header("Content-Type:   text/html; charset=utf-8");
        $this->CI =& get_instance();
        $this->CI->load->library('parser');
		$this->CI->load->model('realt_route_model' );
		$this->CI->load->model('city_model');
		$this->CI->load->model('map_model');
		$this->CI->load->model('realt_search_model', 's');
		$this->CI->load->model('realt_ad_model' ,'ad');
		// $this->CI->s->ini();
		  //echo ($this->CI->search_model->searchdata );
		
		/*
		  echo("--". "<br>");
		  echo($this->CI->realt_route_model->mysegments[0] . "<br>");
		   echo($this->CI->realt_route_model->mysegments[1]. "<br>");
		    echo($this->CI->realt_route_model->mysegments[2]. "<br>");
			 echo($this->CI->realt_route_model->mysegments[3]. "<br>");
		  echo("--");
		  */
        $this->CI->city_model->set_City($this->CI->realt_route_model->mysegments[2]);
		$this->CI->map_model->set_City($this->CI->realt_route_model->mysegments[2]);
		////////// переписать все ниже, чтоб эти переменные не использовать!!
        $this->data['cityid']=$this->CI->city_model->cityID;
		$this->data['cityuri']=$this->CI->city_model->cityUri;
		$this->data['cityname']=$this->CI->city_model->cityName;
		
		
		
		
		
		
		$user = $this->CI->connect->get_current_user();    
		 
		//print_r($user );
       // $this->user = $user;
		 //echo(99);
//print_r( $user);
        if ($user['id_user'] == 6) {$this->user['moderator'] = 1;}


        if (($user['group']['group_name']) == 'Super Admins') {
            $this->data['mlev'] = 4;
            $this->CI->data['page_view'] = "default/wap_page";
        } else {
            $this->data['mlev'] = 0;
        };
		
		
		
		//$this->data['email2'] = config_item('realt_email2');
		 
		
		
		if($this->data['mlev'] == 4){
		//echo $this->data['email2'];
		//$this->CI->load->model('realt_search_model');
		//echo $this->CI->s->inival;
		//$this->CI->s->ini();
		  //echo ($this->CI->search_model->searchdata );
		}
		
		
		
		
		
		
        }
		
		
		
		 
		
		
		// МЕНЮ 
		
		//echo("****************************" . $this->CI->realt_route_model->base_url); 
		
		 $data = array(
            'base_url' => $this->CI->realt_route_model->base_url,
         );
		 $this->data['menu'] = $this->CI->parser->parse('realt_menu', $data);
		
	 
         //if(!isset($CI) || !$CI){
		
		 
	 
		  
		
        

        ini_set('zlib.output_compression', 'On');
        ini_set('zlib.output_compression_level', '2');


        $this->data['phone_verification'] = config_item('realt_phone_verification');
        if ($this->data['mlev'] != 4) {
            //$this->data['phone_verification'] =0;
        }


        $this->data['map_view'] = 0;
        $this->CI->data['map_view'] = 0;
        $this->data['map_view'] = isset($_COOKIE["mapview"])?(int)$_COOKIE["mapview"]:false;
        parse_str($_SERVER['QUERY_STRING'], $_GET);

	 
	 
 if(isset($_GET['mapview'])){
        if ($_GET['mapview'] == "1") {
            $this->data['map_view'] = 1;
            $this->CI->data['map_view'] = 1;
            setcookie("mapview", 1, time() + 3600 * 24 * 30 * 12, "/"); // вроде на год
        } else {
            if ($_GET['mapview'] == "0") {
//echo ("-" .$_GET['mapview'] . "-");
                setcookie("mapview", 0, time() + 3600 * 24 * 30 * 12, "/"); // вроде на год
                $this->data['map_view'] = 0;
                $this->CI->data['map_view'] = 0;
            }
        }
}


//echo ($this->data['map_view']);

        $first = $this->CI->uri->segment(3);
        $this->data['base_url'] = "http://neagent.by/";
        if ($first . $this->CI->uri->segment(4) == "boardwap" || $first == "wap") {
            $this->data['wap_view'] = 1;
            $this->data['view_prefix'] = 'wap_';


            $this->data['base_url'] = "http://neagent.by/wap/";
            $segmentOff = 1; // это поправка к сегменту.

//echo("+" . $CI->data['page_view']);
            $this->CI->data['page_view'] = "default/wap_page";
//echo("*" .$CI->data['page_view']);

        }

 
        if ($this->data['wap_view'] == 1) {

            $this->data['$searchform_view'] = 'wap_searchform';
            $this->data['adform_view'] = 'wap_realt_ad_form';

        } else {

            if ($this->data['mlev'] == 4) {
                //$this->data['$searchform_view'] = 'searchform_input';
				$this->data['$searchform_view'] = 'searchform';
				
                $this->data['adform_view'] = 'realt_ad_form';

            } else {
                $this->data['$searchform_view'] = 'searchform';
                $this->data['adform_view'] = 'realt_ad_form';
            }


        }
 
include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/sutkicash.php';
if(isset($config['sutki_vip_ads'])){
 $this->CI->data['sutki_vip'] = getSutkiVipBlock($config['sutki_vip_ads']);
}



        $ip = $_SERVER["REMOTE_ADDR"];
        $this->CI->data['mapType'] = "yandex";
	 
        if ($this->data['mlev'] == 4) {

            //$this->CI->data['mapType'] = "google";

            $this->data['debug'] = "DEBUG: ";
            //$this->data['showmap']=true;
        }
        $this->data['usemap'] = true;

        if ($this->data['wap_view'] != 1) {
            $this->data['showmap'] = true;
        }
        //Это 3 строчки для технических работ

		
		 

       
		
		
		
		
		
		
        $teh = 0; // технические работы 
        $tehtime = "16.15"; // технические работы 
        if ($teh == 1) {
            if ($this->data['mlev'] != 4) {
                echo('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	  		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"><head>			<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	  		<body><h1> Объявления временно недоступны </h1>Идут технические работы до ' . $tehtime . '<br> ');
                exit;
            }
        }


///////	////Подстановка скриптов для  страницы.	
//		<!-- 
//	<0script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/ajax_object.js"></script>
//    <0script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/req_script.js"></script>
//	<0script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/jquery.js"></script>
//	<0script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/jquery.form.js"></script>
//	<0script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/ads_js.js"></script>
//	<0script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/complaint_script.js"></script>
//	<0script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/jquery.tools.min.js"></script>
//	<0script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/swfobject-2.2.min.js"></script>
//	<!--<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/evercookie.js-"></script>--> -->	

//$start = microtime(true);
//for ($i = 1; $i <= 2000; $i++) {
        getJS($this->data); // делает css и тор  - codehelper
//}
//echo "done in " . (microtime(true) - $start) . "<br/>";
////////////		


        if ($this->data['wap_view'] == 1) {

            $this->data['registerform'] = '';
        } else {

            if ($user['id_user'] > 0) {
                $this->data['registerform'] = "<image src='http://neagent.by/themes/neagent_style/assets/images/user.png'>Вы вошли как <a href='http://neagent.by/board/user'><b style='color:#61ad49;'>" . $user['username'] . "</b> </a><br>";

                if ($user['id_group'] == 16) {
                    $this->data['registerform'] .= "<a href='http://neagent.by/client/'>управление заказами<br>";
                }

                $this->data['registerform'] .= "<form action='http://neagent.by/board/loginuser' method='POST'>
<input type='hidden' name='act' value='logout'>
<input type='submit' value='Выйти'> 
</form>";
            } else {
                $addata = array('names' => "");
                $strform = $this->CI->parser->parse('register_form', $addata);
                $this->data['registerform'] = $strform;
            }


        }


        if ($this->data['mlev'] == 4) {
            adsProlongation();
        }

        include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/realtcash.php';
        $this->data['cityidArr'] = $config['realt_cityes_id'];
        $this->data['citynameArr'] = $config['realt_cityes_name'];
        $this->data['cityuriArr'] = $config['realt_cityes_uri'];
		
		$this->data['cityArr'] = $config['realt_cityes_array'];
		$this->data['cityesIndex'] = $config['realt_cityes_index'];
		$this->data['cityesCount'] = $config['realt_cityes_count'];
		 
		 
        $this->data['regionsArr'] = $config['realt_cityes_region'];
        $this->data['realt_subcats'] = $config['realt_subcats'];
        $this->data['realt_cats'] = $config['realt_cats'];

        $data['cityidArr'] = $config['realt_cityes_id'];
        $data['citynameArr'] = $config['realt_cityes_name'];
        $data['cityuriArr'] = $config['realt_cityes_uri'];
		$data['regionsArr'] = $config['realt_cityes_region'];
        $data['cityesIndex'] = $config['realt_cityes_index'];
		
		
		
		
        $this->data['cityid'] = 1;
        $this->data['cityname'] = getCityName($this->data['cityid'], $config['realt_cityes_id'], $config['realt_cityes_name']);
        $this->data['cityname_in'] = getCityName_in($this->data['cityname']);


        $this->data['regionMenu'] = "";

////////////// СТАТУС ПОЛЬЗОВАТЕЛЯ  - проверить, давал ли он объявления, подтвердил ли свой телефон и тд. 
        $this->data['userstatus'] = $this->getUserStatus();
		
		//echo("us" . $this->data['userstatus']);
		
//print_r($this->CI->city_model);
        $this->data['regionMenu'] = "<div class='div_region'>Город : <a   href='http://neagent.by/board/regions'>" . $this->CI->city_model->cityName . "</a></div>";
        $this->CI->data['cityname'] = $this->data['cityname'];
        //$CI ->data['cityid'] = $this->data['cityid'];
/////// это  - наверное не надо совсем 


//if ($this->data['showmap']) {$this->data['css']  .=  get_mapScript_code();} 


        getScenery($this->CI->data);
//$this->data['debug'] .= ">>>>"  . config_item('realt_autoupdate');
        if (config_item('realt_autoupdate') == 1) {
            autoUp($this->CI->data, $this);
        }


        $this->data['labels_flag'] = (config_item('realt_labels_flag') > 0) ? config_item('realt_labels_flag') : 0;

        if ($this->data['labels_flag'] == 1) {
            $this->data['labels_flag'] = 1;
            $uid = $this->CI->data['user_uid'];
//echo ("посылаем - " . $uid);
            $ULabelsArr = getULabels('uid', $uid);
            $this->data['usertagsJS'] = $ULabelsArr[0];


            $this->CI->data['ul_id'] = $ULabelsArr[1];
            $this->CI->data['ul_name'] = $ULabelsArr[2];
            $this->CI->data['ul_color'] = $ULabelsArr[3];
            $this->CI->data['al_aid'] = $ULabelsArr[4];
            $this->CI->data['al_lid'] = $ULabelsArr[5];

            $this->CI->data['ul_count'] = countLabels($this->CI->data['ul_id'], $this->CI->data['al_lid']);

            $this->data['userlabelsMenu'] = getUserTagsMenu($this->CI->data['ul_id'], $this->CI->data['ul_name'], $this->CI->data['ul_color'], $this->CI->data['ul_count']);


        }

    }


    public function getRegionsPage()
    {
        $this->load->helper('realt');
        $region =  $CI->city_model->cityID;
            $addata = array(
			'names' => $this->CI->city_model->citynameArr,
            'uri' => $this->CI->city_model->cityuriArr,
            'id' =>$this->CI->city_model->cityidArr,
			'regions' => $this->CI->city_model->regionsArr ,
			'index' => $this->CI->city_model->cityesIndex ,
			'count' =>$this->CI->city_model->cityesCount ,
            );
            $str_add = $this->CI->parser->parse('realt_regions', $addata);
            $this->data['realt'] = "" . $str_add;
            return;
    }

	
	

    public function getCatIndex($parenturi)
    {
        $cats = $this->data['realt_cats'];
        $pi = -1;
        for ($k = 0; $k < count($cats); $k++) {
            if ($cats[$k]['uri'] == $parenturi) {
                $pi = $cats[$k]['id'];
            }
        }
        return $pi;
    }


    public function getSubcatIndex($parenturi, $caturi)
    {
        $subcats = $this->data['realt_subcats'];
        $cats = $this->data['realt_cats'];
        $si = -1; $pi = -1;
		
		
	if ($this->CI->realt_route_model->mysegments[3]=='na-sutki'){
	$si=10;  return 10;
	}
if ($this->CI->realt_route_model->mysegments[3] . "/" . $this->CI->realt_route_model->mysegments[4]=='kvartira/na-sutki'){
	$si=10;  return 10;
	}	

        for ($k = 0; $k < count($cats); $k++) {
            if ($cats[$k]['uri'] == $parenturi) {
                $pi = $cats[$k]['id'];
				break;
            }
        }
		
        for ($k = 0; $k < count($subcats); $k++) {
            if ($subcats[$k]['uri'] == $caturi) {
 			      if ($subcats[$k]['parent'] == $pi) {
                    $si = $k;
					break;
                }
            }
        }
        return $si;
    }


	
	
    public function getMeta($subcatindex)
    {
        if ($subcatindex == -1) {
            $this->data['short_keywords'] = 'Снять квартиру в ' . $this->data['cityname_in'] . ', сдать квартиру в ' . $this->data['cityname_in'] . ', объявления без посредников, квартиры на сутки - Neagent.by.';
            $this->data['meta_title'] = 'Снять квартиру в ' . $this->data['cityname_in'] . ', сдать квартиру в ' . $this->data['cityname_in'] . ', объявления без посредников, квартиры на сутки - Neagent.by.';
            $this->data['meta_description'] = 'Снять квартиру в ' . $this->data['cityname_in'] . ', сдать квартиру в ' . $this->data['cityname_in'] . ', сдать в аренду, объявления без посредников, аренда на сутки - Neagent.by.';
        } else {
            $subcats = $this->data['realt_subcats'];
            $this->data['short_keywords'] = $subcats[$subcatindex]['meta_keywords']; //$data['NAME']; 
$this->data['meta_keywords'] = $subcats[$subcatindex]['meta_keywords']; //$data['NAME'];			
            $this->data['meta_title'] = $subcats[$subcatindex]['meta_title']; //$data['NAME'];
            $this->data['meta_description'] = $subcats[$subcatindex]['meta_description'];
        }
    }

	

    public function init_str_add()
    {
	$str_add="";
// добавляет код перед объявлениями 
//$str_add .= getUserEvc($CI->data['user_uid'],$this->data['mlev']);
//$str_add .= getUserEvc($CI->data['user_uid'],0);
        if ($this->data['labels_flag'] == 1) {
            $str_add .= "<script>" . $this->data['usertagsJS'] . "</script>";
        }
        //если mlev=4 то еще дополнительно показывает всё получает и устанавливает кукисы- возвращает строку с кодом 
        if (isset($this->data['scenery_alert'])&& $this->data['scenery_alert'] == 1) {
            $str_add .= "<div style='background-color:#ffcc99; padding:18px;'>" . $this->data['scenery_alert_param'] . "</div>";
        }
        return $str_add;
    }


    public function setCity($cityid)
    {
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/realtcash.php';
        $this->data['cityid'] = $cityid;
//echo("dd" . $this->data['cityid']);
        $CI->data['citymapid'] = $cityid;
        $this->data['cityname'] = getCityName($this->data['cityid'], $config['realt_cityes_id'], $config['realt_cityes_name']);
        $this->data['cityname_in'] = getCityName_in($this->data['cityname']);
        $addata = array('names' => $this->data['citynameArr'],
            'uri' => $this->data['cityuriArr'],
            'id' => $this->data['cityidArr'],
			'regions' => $this->data['regionsArr'],
			'index' => $this->data['cityesIndex'],
			'count' =>$this->data['cityesCount'],
			
        );
        $str_reg = $CI->parser->parse('realt_regions', $addata);
$this->data['regionMenu'] = "
<script>
function regions(){
//$('#regionSelect').modal({overlayClose:true});
$('#regionSelect').modal({
	opacity:80,
	overlayCss: {backgroundColor:'#000'}
});
}
</script>
<div id='regionSelect' style='display:none; background-color:white;padding:22px; width:400px;height:400px; overflow:scroll; border:3px solid #3c92d1'>
<p>" .   $str_reg . " </p>
<p>  <a href='#' class='simplemodal-close'><< Отмена</a>.</p>
</div>
<div class='div_region'>Город: <a   href='http://neagent.by/board/regions' onclick='regions();return false;'>" . $this->data['cityname'] . "</a> </div>";
    }

	
	

    


	
    public function agent()
    {
        include 'inc_agentpage.php';
    }

	
	public function up()
    {
        include 'inc_up.php';
    }
	
	public function accessPage()
    {
        include 'inc_access.php';
    }
	
	 public function uidPage()
    {
        include 'inc_getadsfuid.php';
    }
	 public function adidPage()
    {
        include 'inc_getad_adid.php';
    }
	
	 public function allPage()
    {
        include 'inc_getadsfall.php';
    }
	
    public function userpage()
    {
        include 'inc_userpage.php';
    }

    public function register()
    {
        include 'inc_register.php';
    }

    public function register2()
    {
        include 'inc_register2.php';
    }

    public function login($returnurl=false)
    {
        include 'inc_login.php';
    }

    public function sendpassword()
    {
        include 'inc_sendpassword.php';
    }

    public function resetpassword()
    {
        include 'inc_resetpassword.php';
    }

	
	
	
	public function moderationPage(){
	 include 'inc_getadsmoderate.php';
	  
	 return $this->data['realt'];
	}
	
	public function commentsModerationPage(){
	 include 'inc_commentsmoderate.php';
	 return $this->data['realt'];
	}
	
	
	public function verificationPage(){
	 include 'inc_verification.php';
	  
	 return $this->data['realt'];
	}

    public function getMyAdsPage()
    { // страницв - мои объявления
        if (!$CI) {
            $CI =& get_instance();
            $CI->load->library('parser');
        }
        $addata = array('ad_id' => $row->ad_id);

		
		

        if ($this->data['wap_view'] == 1) {
            $this->data['searchform'] = $CI->parser->parse('wap_searchform', $addata);
        } else {


            if ($this->data['mlev'] == 4) {
                $this->data['$searchform_view'] = 'searchform_input';
            } else {
                $this->data['$searchform_view'] = 'searchform';
            }


        }
        $str_add .= $this->init_str_add(); //  Для всх страниц. Запись evc  ,  alert если есть и т.п. 	
        $str_add .= $this->data['MESSAGE_FOR_USER']; //	алерт , если установлен 

        $addata = array();
        $str_add .= $CI->parser->parse('realt_myads', $addata);

        include 'inc_myads.php';
    }


    public function getAdsPage()
    { // показ всех объявлений в том числе и поиск
    $CI =& $this->CI;
$str_add="";
	
	    $sqs = $_SERVER['QUERY_STRING'];
        parse_str($_SERVER['QUERY_STRING'], $_GET);
	
	
	   // $CI->data['mapType'] = "google"; //показывать крту гугл но пока не работает как надо 
       // $this->data['showmap']=false;  // отключает показ карты

        if ($this->data['showmap']) {
            $this->data['css'] .= $this->CI->map_model->get_mapScript_code();
        }

  // $ind = $this->getSubcatIndex($this->data['segment_cat'], $this->data['segment_subcat']);
	
	$ind = $this->getSubcatIndex($this->CI->realt_route_model->mysegments[3], $this->CI->realt_route_model->mysegments[4]);
	
if (isset($_GET['mode']) && $_GET['mode'] == 'search') {
$search="search";
$this->CI->s->ini();
$ind=$this->CI->s->params['cat']['id'];
}
	
	
	
	if (!isset($search) ) {
	$str_add .= getRubricsCode();
	}
	else{
	 if ($this->data['mlev'] == 4) {
	  $str_add .='<!-- SEARCHDATA --><div>Подписаться на новые результаты поиска</div></div><div id="contentIns" style="margin-top:10px;" >';
	}
	}
	
	
	
	
 //echo( $this->CI->realt_route_model->mysegments[3] . " / ".  $this->CI->realt_route_model->mysegments[4]	 );
 //echo("index= " . $ind);

$data = array(
            'cityid' => $this->CI->city_model->cityID,
            'cityname_in' => "в " . $this->CI->city_model->cityNameIn,
            'cat' => $ind
        );
 $this->data['searchform'] = $CI->parser->parse($this->data['$searchform_view'], $data);


 //$str_add .="<div style='color:red; font-size:14px;'> <br>Внимание! если вы видите телефон агента на сайте, не расстраивайтесь.  1) договаривайтесь на встречу, 2)смотрите квартиру,  3)платите хозяину деньги, заселяйтесь 4)агенту платить не надо. Потому что все люди, разместившие здесь бъявления, подтвердили, что они НЕ ЯВЛЯЮТСЯ ПОСРЕДНИКАМИ и не требуют денег за показ или подбор квартиры. Если с вас требуют деньги - значит вас обманули. С вас никто не может требовать денег, если только вы и хозяин квартиры  не заключали договор с посредником.  </div>" ;


        $str_add .= $this->init_str_add(); //  Для всх страниц. Запись evc  ,  alert если есть и т.п. 

		$mess= isset($this->data['MESSAGE_FOR_USER'])? $this->data['MESSAGE_FOR_USER'] : "";
        $str_add .= $mess; //	алерт , если установлен 		


        if (isset($this->user['moderator']) && $this->user['moderator'] == 1) {
            include 'inc_moder.php';
        }

 
        if ($this->data['wap_view'] != 1 &&  (!isset($search))  ) {
            $str_addREM  = "</div><div  class='contentIns mainpageinfo' style='background-color:#ffcc33;padding:10px; '> <div style='font-size:26px;padding-bottom:8px;'>Теперь 100% объявлений без комиссии агентам.</div> Собственники и лучшие агенты города решат ваш жилищный вопрос абсолютно бесплатно. Вы оплачиваете <b>только проживание</b>. Мы не размещаем ни одного объявления от тех посредников, которые просят дополнительную оплату за услуги, берут оплату по факту заселения или предоставляют информацию о квартирах за деньги. Все податели объявлений подтвердили свое согласие с тем, что вам нужно оплатить только стоимость проживания непосредственно хозяину жилья. <br>Неагент - самый посещаемый сайт по аренде квартир в Беларуси. №1 по запросу «снять квартиру» в <noindex><a href='https://www.google.by/search?client=opera&rls=ru&q=%D1%81%D0%BD%D1%8F%D1%82%D1%8C+%D0%BA%D0%B2%D0%B0%D1%80%D1%82%D0%B8%D1%80%D1%83&sourceid=opera&ie=utf-8&oe=utf-8&channel=suggest' rel='nofollow' target='_blank'>Google</a></noindex>. Единственный сайт о недвижимости, на котором телефоны <b>проверяются</b> с помощью подтверждения по смс (таким образом исключаются ложные объявления на чужие номера телефонов)  и фильтруются объявления от мошенников.<br> </div><div  class='contentIns' style='margin-top:10px;'>  ";
			
			$str_add .= "</div><div  class='contentIns mainpageinfo' style='background-color:#ffcc33;padding:10px; '> <div style='font-size:26px;padding-bottom:8px;'>Приношу свои извинения за нестабильную работу сайта.</div> 
			Позавчера сайт был полностью отключен без предупреждения и без альтернатив. Поэтому перенос сайта на новый сервер был неожиданным и неподготовленным. Слава богу, на hoster.by нашлись люди, которые понимают значение этого ресурса и помогли сделать все быстро.  Стоимость размещения и обслуживания сайта увеличилась в 10 раз, но это более мощная площадка, которая позволит работать быстрее и без сбоев. Однако не  факт, что чьи-то интересы  удовлетворены и сайт снова не будет отключен.  Идет восстановление работы, многие функции могут работать неправильно, но делается все возможное чтобы это исправить своими силами. 

			
			  <br>Неагент - самый посещаемый сайт по аренде квартир в Беларуси. №1 по запросу «снять квартиру» в <noindex><a href='https://www.google.by/search?client=opera&rls=ru&q=%D1%81%D0%BD%D1%8F%D1%82%D1%8C+%D0%BA%D0%B2%D0%B0%D1%80%D1%82%D0%B8%D1%80%D1%83&sourceid=opera&ie=utf-8&oe=utf-8&channel=suggest' rel='nofollow' target='_blank'>Google</a></noindex>. Единственный сайт о недвижимости, на котором телефоны <b>проверяются</b> с помощью подтверждения по смс (таким образом исключаются ложные объявления на чужие номера телефонов)  и фильтруются объявления от мошенников.<br> 
			   
			  
			  </div><div  class='contentIns' style='margin-top:10px;'>  ";
			
			
        }
		
		
		
 
		
		
		

  //$str_add .="<br><div style='color:red; font-size:24px;' >Осторожно с квартирой на Неманской 68! Мошенники. <a href='http://neagent.by/articles/n68'></a>  </div><br>";


// если был поиск


/////// проверка обычного показа только для админа сделал
$_GET['mode'] = isset($_GET['mode'])?$_GET['mode']:false;

if ($this->data['mlev'] == 44 && $_GET['mode'] != 'search') {
$criteria= $CI->load->model('cidbcriteria');
$CI->cidbcriteria->criteriesFromGet( ); // хоть get и нету  но есть сегменты, оттуда можно вытянуть категорию и город
$CI->cidbcriteria->searchparams['ad_isagent']=0;
//$CI->cidbcriteria->build(false); // false(без limit и offset для count)
$countresults=$CI->cidbcriteria->count(); //  build и  возвращает количество
///////////////
 //print_r($CI->cidbcriteria->searchparams);
		//$CI->cidbcriteria->build(); // просто составляет запрос из переданных параметров
		//echo "--4--";
		// остается только его вызвать
		 // $query = $CI->db->get(); 
		// $countresults=$CI->db->count_all_results();
		//echo "--5--";
		 // echo $CI->db->_error_message();
        //echo $CI->db->last_query();
//////////////////////
//$CI->load->model('realt_ad_model' ,'ad');
//$countresults=$CI->db->count_all_results();
$CI->cidbcriteria->build();
$query = $CI->db->get();
echo "[realt_model 739]";
echo $CI->db->_error_message();
echo $CI->db->last_query();
$ads=$CI->ad->modelsFromQuery($query);
		$CI->load->model('ads_list');
		$params['col1_rows']=count($ads);
		$params['col2_rows']=0;
		$params['total_rows']=$countresults;
		$params['cidbcriteria'] =$CI->cidbcriteria ;
		$str_add.=$CI->ads_list->parse($ads, $params);
		$this->data['realt'] = $str_add;
 return;
}




        if ( isset($search)) {

            if ($this->data['mlev'] == 4) {
            //include 'inc_smartsearch.php';

			// $CI->load->model('realt_ad_model' ,'ad');
			//$ad = $CI->ad;
			//$ad->setdataArr($addata);
			//$ad->set_table('ads_cash');
			//$ad->fields['ad_user']=1;
		// $criteries= searchCriteriesFromPost();
		//$ad->setdataArr($addata);
		 

		 	
       // $criteria=new CIDbCriteria(array(
		//	'condition'=>'status=1',
		//	'order'=>'date_last_modified DESC',
		//	'with'=>'commentCount',
		//));
		
		 //echo "--1--";
		$criteria= $CI->load->model('cidbcriteria');
		// echo "--2--";
        $CI->cidbcriteria->criteriesFromGet( ); // составляется четкий список валидированный который передадим для составления запроса
		
		
		
		  echo $CI->cidbcriteria->fields;
		$CI->cidbcriteria->searchparams['ad_isagent']=0;
		//$CI->cidbcriteria->
		
	    //print_r($CI->cidbcriteria->searchparams);
		//$CI->cidbcriteria->build(); // просто составляет запрос из переданных параметров
		//echo "--4--";
		// остается только его вызвать
		  // $query = $CI->db->get(); 
		 // echo ($CI->db->_error_message());
		 // echo ($CI->db->last_query());
		$countresults=$CI->cidbcriteria->count(); //  build и  возвращает количество
 
		// echo $CI->db->_error_message();
        //echo $CI->db->last_query();
 
 
 
		$CI->cidbcriteria->build();
        $query = $CI->db->get();
		
		
		 //echo (000);
         
		$ads=$CI->ad->modelsFromQuery($query);
		
		//$CI->cidbcriteria->searchparams['ad_isagent']=1;
		//$CI->cidbcriteria->build(); 
		//$countresults2=$CI->db->count_all_results();
		//$CI->cidbcriteria->build();
		//$query2 = $CI->db->get();
		 // echo $CI->db->_error_message();
          //echo $CI->db->last_query();
		// echo ("" . $countresults2);
		//$ads2=$CI->ad->modelsFromQuery($query2);
		
		
		//$new_array = array_merge($ads, $ads2);
		
		$CI->load->model('ads_list');
		 
		$params['col1_rows']=count($ads);
		//$params['col2_rows']=count($ads2);
		$params['total_rows']=$countresults;
		 echo ("COUNT" . $countresults);
		
		
		$params['cidbcriteria'] =$CI->cidbcriteria ;
		$str_add.=$CI->ads_list->parse($ads, $params);
		$this->data['realt'] = $str_add;
                return;
		
		
		
		

 

            } else {
            include 'inc_search.php';
$str_add = str_replace("<!-- SEARCHDATA -->", $str_searched, $str_add); 				
                $this->data['realt'] = $str_add;
                return;
            }


        }
        ;

         

// Показываем список объявлений всех 


        $table = "ads";
        $catrow = "ad_catid";


/// Это всё можно и в роутес поместить 


        //$ind = $this->getSubcatIndex($this->data['segment_cat'], $this->data['segment_subcat']);
		$ind = $this->getSubcatIndex($this->CI->realt_route_model->mysegments[3], $this->CI->realt_route_model->mysegments[4]);
		//echo($ind);
		
		$cat=isset($this->data['segment_cat'])?$this->data['segment_cat']:null;
        $par = $this->getCatIndex($cat);
 //echo(" ind =". $ind);

        $this->getMeta($ind); // 
          $mcatind = ($ind>-1)?$ind:0;
        $mcat = (int)$this->data['realt_subcats'][$mcatind ]['id']; ///  ЭТО для карты 
		$mcat=$ind+1;
		 //echo("mcat =". $mcat);
		
        $cat_id = $this->data['realt_subcats'][$mcatind ]['id']; ///  ЭТО очень важно а я удалил 


        if (($ind != -1) && ($this->data['wap_view'] == 1)) {
            $this->data['menu'] = "";
        }
		
 if ($ind == 10) {// если сутки
            $this->data['menu'] = "";
        }
		
		
	
		
		
		
		
		

        if ($ind == -1) {
            if ($this->data['wap_view'] != 1) {
//include 'inc_mainpage.php';
                //include 'inc_detector.php';
            }

            if ($this->data['mlev'] == 4) {

            }


            $this->data['short_keywords'] = "Снять квартиру, снять квартиру в Минске"; //$data['NAME'];
        } else {
            $str_add .= "<a href='http://neagent.by/'>Главная</a> / <a href='' title='" . $this->data['realt_subcats'][$ind]['fullname'] . "' >" . $this->data['realt_subcats'][$ind]['fullname'] . " в " . $this->data['cityname_in'] . "</a>";

            $ss = $this->data['realt_subcats'][$ind]['text'];
            $subcattextarr = explode('|', $ss);

            if ($subcattextarr[0]) {
                if ($this->data['wap_view'] != 1) {
                    $str_add .= $subcattextarr[0];
                }
            }


            $table = $this->data['realt_subcats'][$ind]['table'];
            $par = $this->getCatIndex($cat);
            $this->data['js_menu'] = "shiftSubDiv(" . $par . ");";
        }


        $CI->load->library('pagination');
// $config['base_url'] = site_url('/board/'.$CI->uri->segment(4)); // 


        switch ($this->CI->realt_route_model->mysegments[3]!="") {
            case 'kvartira':
            case 'komnata':
            case 'dom':
            case 'office':
                $config['base_url'] = "http://neagent.by/" . ($this->CI->realt_route_model->mysegments[3] . "/" . $this->CI->realt_route_model->mysegments[4]); //
                $config['uri_segment'] = 6;
                break;
            default:
                $config['uri_segment'] = 4;

                // echo(" ".$this->data['base_url']." ");

                if ($CI->data['segment_city']) { // если есть город в сегменте 
                    $config['uri_segment'] = 5;

                    $config['base_url'] = $this->data['base_url']; //
                } else {
                    $config['base_url'] = $this->data['base_url'] . "board/"; //
                }


                $config['base_url'] = str_replace("board/board/", "board/", $config['base_url']);
        }

		
		
		
		// print_r($this->CI->realt_route_model);
		$config['base_url']=$this->CI->realt_route_model->pagination_base_url;
	//	echo("config['base_url']=" . $this->CI->realt_route_model->pagination_base_url );
		$config['uri_segment']=$this->CI->realt_route_model->page_segment;
	//	echo("сегмент  перед паджингом: " . $CI->uri->segment($this->CI->realt_route_model->page_segment-1));
	//	echo("сегмент  паджинга: " . $CI->uri->segment($this->CI->realt_route_model->page_segment)); 
	//	$config['base_url'] = $this->CI->realt_route_model->base_url ;
		
		
        // исправить totalrows  - тут неправильны результат

 //echo( "iiii" . $this->CI->city_model->cityID); 
        $CI->db->where("ad_city", $this->CI->city_model->cityID);
		 
		
        $CI->db->where("ad_show", 1);
        $CI->db->from($table);
        $config['total_rows'] = $CI->db->count_all_results();


        //$CI->db->count_all('ads'); //   было $CI->$config['total_rows'] = $CI->db->count_all('records'); // 
        $config['per_page'] = (config_item('realt_ads_per_page') > 0) ? config_item('realt_ads_per_page') : 25; //  выводить на страницу


        if ($table == "sutki") {

            $this->data['map_view'] = 0;
            $config['per_page'] = (config_item('realt_ads_per_page_sutki') > 0) ? config_item('realt_ads_per_page_sutki') : $config['per_page']; //  выводить на страницу сутки
        }


        $config['num_links'] = 6; //  количество ссылок - косметический параметр
        $config['padding'] = 1;
        //$config['uri_segment'] = 2;  //  
        $config['first_link'] = 'В начало';


        $cat_id = (int)$cat_id;


        if ($cat_id > 0) {
            if ($table == "ads") {
                $CI->db->where('ad_city', $this->CI->city_model->cityID);
                $CI->db->where('ad_catid', $cat_id);
            }
            ;
            $CI->db->where("ad_show", 1);
            $CI->db->from($table);
            $CI->db->where('ad_city', $this->CI->city_model->cityID);
            $allresults = $CI->db->count_all_results();
            $config['total_rows'] = $allresults;
        } else {

            $CI->db->where('ad_city', $this->CI->city_model->cityID);
            $CI->db->where("ad_show", 1);
            $CI->db->from($table);
            $CI->db->where('ad_city', $this->CI->city_model->cityID);
            $allresults = $CI->db->count_all_results();
            $config['total_rows'] = $allresults;


        }

        if ($this->data['mlev'] == 4) {
//echo ($this->data['cityid']. "5555") ;
        }

        $firstad = (int)($CI->uri->segment($config['uri_segment']) + 0); // +1 потому чт онулевое объявление уже показано 

         
		
		
		
        if ($ind == -1) {
            if ($this->data['wap_view'] != 1) {


                if ($this->data['mlev'] == 4) {
                    //echo ($this->data['cityname']) ;
                }


                $cityrod = $this->CI->city_model->cityNameIn;

                switch ($cityrod) {
                    case 'Минск':
                    case 'Брест':
                    case 'Витебск':
                    case 'Новополоцк':
                    case 'Могилев':
                    case 'Минск':
                        $cityrod .= "е";
                        break;
                    case 'Гомель':
                        $cityrod = "Гомеле";
                        break;
                    default:
					 $cityrod = "г." . $cityrod ;
					
                }
                $this->data['cityname_in'] = $cityrod;

                $addata = array(
                    'cityid' => $this->CI->city_model->cityID,
                    'cityname' => $cityrod ,
                );
				
				$str_add .=" <div  class='contentIns' style='margin-top:10px;padding:10px;'>";
                $str_add .= $CI->parser->parse('realt_fastlinksblock', $addata);
				$str_add .="</div>";
				
            }
        }
        ;
		
		
 


		//echo("mcat" . $mcat);
		
		if ($this->data['cityid']!=1){
		 $str_add .= "<h1>Объявления о недвижимости  в г."  . $cityrod . "</h1>";
		 $str_add .= "<i>Квартиры в г."  . $cityrod . ", комнаты в г."  . $cityrod . ". Прелдожения об аренде и продаже недвижимости в городе  "  . $cityrod . ". </i>";
		} 
		
		 
		
  
        if ($this->data['showmap'] && $mcat == 11) {
            $mparams = array(
                'city' => 1,
                'postdate' => '0',
                'cat' => $mcat
            );
            $str_add .= get_map_params($mparams); //получает параметры для передачи в карту
            $str_add .= get_map_code(); //получает код вставки карты
			 
        }

        if ($this->data['showmap'] && $mcat == 3 && ($firstad == 0 || $mapview == 1)) {
            $mparams = array(
                'city' => 1,
                'postdate' => '0',
                'cat' => $mcat
            );
            $str_add .= get_map_params($mparams); //получает параметры для передачи в карту
            $str_add .= get_map_code(); //получает код вставки карты
        }

        if ($this->data['showmap'] && $mcat == 9 && ($firstad == 0 || $mapview == 1)) {
            $mparams = array(
                'city' => 1,
                'postdate' => '0',
                'cat' => $mcat
            );
            $str_add .= get_map_params($mparams); //получает параметры для передачи в карту
            $str_add .= get_map_code(); //получает код вставки карты
        }

        if ($this->data['showmap'] && $mcat == 1 && ($firstad == 0 || $mapview == 1)) {
		
		 
            $mparams = array(
                'city' => 1,
                'postdate' => '0',
                'cat' => $mcat
            );
            $str_add .= get_map_params($mparams); //получает параметры для передачи в карту
			//echo("<textarea>" . get_map_params($mparams) .  "</textarea>" );
            $str_add .= get_map_code(); //получает код вставки карты
			
			//echo("<textarea>" . get_map_code() .  "</textarea>" );
        }

        if ($this->data['showmap'] && $mcat == 7 && ($firstad == 0 || $mapview == 1)) {
            $mparams = array(
                'city' => 1,
                'postdate' => '0',
                'cat' => $mcat
            );
            $str_add .= get_map_params($mparams); //получает параметры для передачи в карту
            $str_add .= get_map_code(); //получает код вставки карты
        }

        if ($this->data['showmap'] && $mcat == 13 && ($firstad == 0 || $mapview == 1)) {
            $mparams = array(
                'city' => 1,
                'postdate' => '0',
                'cat' => $mcat
            );
            $str_add .= get_map_params($mparams); //получает параметры для передачи в карту
            $str_add .= get_map_code(); //получает код вставки карты
        }

		
		
        if ($ind == -1) {

            if ($this->data['showmap']) {
                $mparams = array('city' => 1);
                $str_add .= get_map_params($mparams); //получает параметры для передачи в карту
                $str_add .= get_map_code(); //получает код вставки карты
			//echo("<textarea>" . get_map_code() ."</textarea>");	
				
            }
        }


		
		
 


        $lastad = $firstad + $config['per_page'] - 1;
        if ($lastad > $allresults) {
            $lastad = $allresults;
        }
        ;
 


//	продолжаем pagination
        $config['full_tag_open'] = '<div class="pagination"><div class="page_numbers"><span class="page-first">' . lang('module_realt_pagination_page') . '</span>';
        $config['full_tag_close'] = '</div><p class="page_items">' . $firstad . lang('module_realt_pagination_tire') . $lastad . lang('module_realt_pagination_from') . $allresults . lang('module_realt_pagination_ads') . '</p></div>';
        $config['cur_tag_open'] = '<span class="selected">';
        $config['cur_tag_close'] = '</span>';


        $config['first_tag_close'] = '';
        $config['next_tag_close'] = '';
        $config['prev_tag_open'] = '';
        $config['num_tag_open'] = '';
        $config['next_tag_open'] = '';
        $config['prev_tag_open'] = '';
        $config['prev_tag_close'] = '';
        $config['prev_tag_open'] = '';
        $config['first_link'] = '<i class="dblleftarr">first</i>';
        $config['last_link'] = '<i class="dblrightarr">last</i>';
        $config['next_link'] = '<i class="rightarr">next</i>';
        $config['prev_link'] = '<i class="leftarr">prev</i>';

//


        


//$config['total_rows'] = $CI->db->count_all($table);//$CI->db->count_all('ads'); //   было $CI->$config['total_rows'] = $CI->db->count_all('records'); // 
//$config['per_page'] =    (config_item('realt_ads_per_page')>0)?config_item('realt_ads_per_page'): 20;   //  выводить на страницу
//$config['num_links'] = 6;    //  количество ссылок - косметический параметр
//$config['padding'] = 1;

            //$config['uri_segment'] = 2;  //  
//$config['first_link'] = 'В начало';
            $config['full_tag_open'] = '<div class="pagination"><div class="page_numbers"><span class="page-first">' . '</span>';
            $config['full_tag_close'] = '</div><p class="page_items">' . $firstad . lang('module_realt_pagination_tire') . $lastad . lang('module_realt_pagination_from') . $allresults . lang('module_realt_pagination_ads') . '</p></div>';
            $config['cur_tag_open'] = '<span class="selected">';
            $config['cur_tag_close'] = '</span>';


            $sortlink = "";

            if ($this->data['mlev'] == 4) {
                $config['full_tag_close'] = '</div><div class="pagination_sort">сортировать: <a href="$sortlink">по дате</a></div><p class="page_items">' . $firstad . lang('module_realt_pagination_tire') . $lastad . lang('module_realt_pagination_from') . $allresults . lang('module_realt_pagination_ads') . '</p></div>';
            } else {
                $config['full_tag_close'] = '</div><div class="pagination_sort"><a href="$sortlink"></a></div><p class="page_items">' . $firstad . lang('module_realt_pagination_tire') . $lastad . lang('module_realt_pagination_from') . $allresults . lang('module_realt_pagination_ads') . '</p></div>';

            }


            $str_add .= "
<style>


</style>










";


         


        $CI->pagination->initialize($config);
        $data['pager'] = $CI->pagination->create_links();


        $from = ($CI->uri->segment($config['uri_segment']));
        if (!$from) {
            $from = 0;
        }
        // $from=$from-10;
 //echo ("f=".$from);


        $params = array(
            'city_id' => $this->CI->city_model->cityID,
            'cat_id' => $cat_id,
            'ad_show' => '1',
            'order' => 'ad_postdate',
            'ordertype' => 'desc'

        );


//if  ($this->data['mlev']==4){  

        $params['ad_fakefor'] = "UID=" . $CI->data['user_uid'] . ";";

//}


        if ($this->data['mlev'] == 4) {
            unset($params['ad_show']);
        }


        if ($table == "sutki") {

//$config['per_page']=3;
            $params['ad_show'] = '1';
            unset($params['cat_id']);
            unset($params['ad_fakefor']);
        }


       // print_r ($params);

 if ($this->data['mlev'] == 4) {
 //$table="partner_ads ";
  //$table  = array('partner_ads', 'ads'  );
 }
 
 /////////////////// это функция getadspage  - показ всех объявлений 
        $query = $this->getAds($table, $from, $config['per_page'], $params);


        if ($this->data['mlev'] == 4) {
		
 //echo  ($CI->db->last_query());
 //echo  ($query->num_rows());

            $this->data['debug'] .= $CI->db->last_query();

        }


        if ($query->num_rows() == 0) {
//echo ("Объявление не найдено");
            $str_add .= "<h2>Объявления не найдены. Выбран город:  " . $this->CI->city_model->cityName . "</h2> .";
        }


//print_r($query);


        //$str_add .= $data['pager'];

        $currentpageUrl = "http://neagent.by/" . $_SERVER['REQUEST_URI'];

        if ($this->data['showmap'] == true) {
            $str_add .= get_detailTab_code($currentpageUrl, $this->data['map_view']);
        }


        switch ($table) {
            case 'sutki':
// начата обработка объявлений 

/// сначала записываем все варианты в массив.
$sutkiAdsArray = array();
$sutkiAdsArrayb0 = array();
$sutkiAdsArrayb1 = array();
$sutkiAdsArrayb2 = array();
$sutkiAdsArrayb3 = array();
$sutkiAdsArrayb4 = array();
 


                $alt = 1; // начата обработка объявлений 

                $counter = 0;
                foreach ($query->result() as $row) {
                    $counter = $counter + 1;
                    if ($counter == 577777) {
                        $str_add .= "<div style='padding:7px;'><h2>Сдаете квартиру на сутки? Приглашаем разместить объявление в рубрике.</h2>Разместить объявление о сдаче <em>квартир на сутки</em> можно, нажав на кнопку «Подать объявление». Рубрика «<b>Квартиры на сутки</b>» позволяет разместить объявление на одной из самых посещаемых площадок Беларуси. Здесь представлены квартиры посуточно и на длительный срок от хозяев. </div>";
                    }
                    if ($alt == 1) {
                        $alt = 0;
                    } else {
                        $alt = 1;
                    }
                    $itemalt = ($alt == 1) ? " itemalt" : "";
                    $addata = array(
                        'ad_id' => $row->ad_id,
                        'ad_catid' => $row->ad_catid,
                        'ad_title' => $row->ad_title,
                        'ad_message' => $row->ad_message,
                        'ad_price' => $row->ad_price,
                        'ad_price2' => $row->ad_price2,
                        'ad_price3' => $row->ad_price3,
                        'ad_period2' => $row->ad_period2,
                        'ad_period3' => $row->ad_period3,
                        'ad_currency' => $row->ad_currency,
                        'ad_phones' => $row->ad_phones,
                        'ad_contactname' => $row->ad_contactname,
                        'ad_postdate' => $row->ad_postdate,
                        'ad_email' => $row->ad_email,
                        'ad_pictures' => $row->ad_pictures,
                        'ad_area' => $row->ad_area,
                        'ad_subarea' => $row->ad_subarea,
                        'ad_street' => $row->ad_street,
                        'ad_dom' => $row->ad_dom,
                        'ad_korpus' => $row->ad_korpus,
                        'ad_url' => $row->ad_url,
                        'ad_komnat' => $row->ad_komnat,
                        
                        'itemalt' => $itemalt,
                        'ad_sp_mest' => $row->ad_sp_mest,
                        'ad_mainpic' => $row->ad_mainpic,
                        'ad_show' => $row->ad_show,
                        'ad_type' => $row->ad_type,
                        'ad_comments_count' => $row->ad_comments_count
                    );
                    $delayed = false;

					
					
					
					
										
						 
					
					
					
					
					
					
					
					
					
					
// замена телефонов
//include 'inc_repl_phones.php';


                    $addata['ad_mainpic'] = "http://neagent.by/modules/Realt/files/" . $addata['ad_mainpic'];
					


                    if ($addata['ad_type'] >0) {
                        $addata['itemalt'] = "vip";
                    }

					
				
					
                    $addata['ad_firstpic'] = "<img src='" . base_url() . "themes/neagent_style/assets/images/kvartira.gif' width='60' height='50'  alt='Квартира' />";
// привести дату в нормальный вид   ...... ЭТО СУТКИИ  
                    $addata['ad_postdate'] = $addata['ad_postdate'];
                    $addata['ad_komnat_txt'] = getKomnatString($addata['ad_komnat']);
                    $addata['mlev'] = $this->data['mlev']; // помечаем админа или кого еще чтобы в объявлении можно было видеть
                    if (strlen($addata['ad_url']) < 2) {
                        $addata['ad_url'] = $addata['ad_id'];
                    }
// добавляем у url начало snimu или sdayou


                    $addata['ad_url'] = "http://neagent.by/nasutki/" . $addata['ad_url'];


//switch ($addata['ad_catid']) {
//case '2':case '4':case '6':case '8':case '10':
//$addata['ad_url']="http://neagent.by/snimu/".$addata['ad_url'];break; 
//case '1':case '3':case '5':case '7':case '11':
//$addata['ad_url']="http://neagent.by/sdayu/".$addata['ad_url'];break;
// }
$addata['sutki_pictures'] = isset($addata['sutki_pictures'])?$addata['sutki_pictures']:"";

                    if (strlen($addata['sutki_pictures']) > 2) {
//imagesArr=split(pictures, ",")
//firstpic="<a rel=""pics_" & strAdId & """ href=""" & "uploads/n_" & imagesArr(0) & """><img src=""uploads/t_" & imagesArr(0)&  """ width=""60"" height=""50""   />" 
//firstpic="<a   href=""default.asp?ad_id=" &  strAdId &"""><img src=""uploads/t_" & imagesArr(0)&  """ width=""60"" height=""60""   />" 
                    } else {
                        $addata['sutki_firstpic'] = "<img src='" . base_url() . "themes/neagent_style/assets/images/nopic.gif' width='60' height='50'   />";
// firstpic="<img src=""themes/neagent/images/pic.gif"" width=""60"" height=""50""   />"
                    }

					


  // switch ($addata['ad_type']) {
            // case 7: // рубли 
			// case 6:
			// case 5:
	// array_push($sutkiAdsArrayb0 , $addata );			
			 // break;
			  // case 4: 
		// array_push($sutkiAdsArrayb1 , $addata );	 
			 // break;
			 // case 3: 
		// array_push($sutkiAdsArrayb2 , $addata ); 
			  // break;
			 // case 4: 
		// array_push($sutkiAdsArrayb3 , $addata ); 
		 // break;
			 // default:
		// array_push($sutkiAdsArrayb4 , $addata ); 
 		
// }
					
					
					
array_push($sutkiAdsArray , $addata );						
					
					
					
					
					
                    


		
	//$AdArray=array( ,  $str_add);	
	  				
					
					
					
					
                }


				
// даные собраны , теперь сортируем. 


// $s  = shuffle($sutkiAdsArrayb1);
// $s  = shuffle($sutkiAdsArrayb2);
// $s  = shuffle($sutkiAdsArrayb3);

// $sutkiAdsArray = array_merge($sutkiAdsArrayb0, $sutkiAdsArrayb1, $sutkiAdsArrayb2, $sutkiAdsArrayb3, $sutkiAdsArrayb4 );


//// сортировка пропущена

if ($this->data['mlev'] == 4) {
//$sutkiAdsArray = sortSutki( $sutkiAdsArray);
}



$alt = 1; // начата обработка объявлений 
$counter = 0;	



				
			for ($j = 0; $j<count($sutkiAdsArray); $j++){	
			 $counter = $counter + 1;
                    if ($counter == 5) {
                        $str_add .= "<div style='padding:7px;'><h2>Сдаете квартиру на сутки? Приглашаем разместить объявление в рубрике.</h2>Разместить объявление о сдаче <em>квартир на сутки</em> можно, нажав на кнопку «Подать объявление». Рубрика «<b>Квартиры на сутки</b>» позволяет разместить объявление на одной из самых посещаемых площадок Беларуси. Здесь представлены квартиры посуточно и на длительный срок от хозяев. </div>";
                    }
                    if ($alt == 1) {
                        $alt = 0;
                    } else {
                        $alt = 1;
                    }	
				
				
				
				
				if ($this->data['mlev'] == 4) {
                        $str_add .= $CI->parser->parse('realt_sutki_ad', $sutkiAdsArray[$j]);
                    } else {
                        $str_add .= $CI->parser->parse('realt_sutki_ad', $sutkiAdsArray[$j]);
                    }
				

				
				
			 }
				
				
				
				
				
// Обработка всех объявлений закончена


                break;


                break;

            case 'partner_ads':
            case 'ads':
                $alt = 1; // начата обработка объявлений 
                $adcounter = 0;


                $js_points = "var map_points=Array();";


				if ($this->data['mlev'] == 4) {
			//	$data = array(
             //           'header' => "1",
             //           );
				// $str_add .= "<table class='table-result'>";
			//	$str_add .= $CI->parser->parse('realt_ad_table', $data);
				 }
				 
				 
				 
				
				
                foreach ($query->result() as $row) {
                    $adcounter = $adcounter + 1;

                    if ($adcounter == 5 || $adcounter == 10) {
                        $str_add .= '<div style="background-color:#f4f3e5;margin-top:18px;margin-bottom:18px;"><script type="text/javascript"><!--<![CDATA[
/* (c)AdOcean 2003-2011 */
/* PLACEMENT: smartcode.neagent.by.468_60 */
if(location.protocol.substr(0,4)==\'http\')document.write(unescape(\'%3C\')+\'script id="smartcode.neagent.by.468_60" src="\'+location.protocol+\'//by.adocean.pl/_\'+(new Date()).getTime()+\'/ad.js?id=M2AMhFoG7YcmAb3TJ3W8x4S9bPBSQ2bxyWWoW.qgb.f.B7/x=\'+screen.width+\'/y=\'+screen.height+\'" type="text/javascript"\'+unescape(\'%3E%3C\')+\'/script\'+unescape(\'%3E\'));
//]]>--></script></div>
';

                    }

                    if (isset($subcattextarr[1]) && $subcattextarr[1] && $adcounter == 4) {
                        $str_add .= "<div class='sctxt'>" . $subcattextarr[1] . "</div>";
                    }

                    if (isset($subcattextarr[2]) &&  $subcattextarr[2] && $adcounter == 7) {
                        $str_add .= "<div class='sctxt'>" . $subcattextarr[2] . "</div>";
                    }

                    if ($alt == 1) {
                        $alt = 0;
                    } else {
                        $alt = 1;
                    }
                    $itemalt = ($alt == 1) ? " itemalt" : "";


//////////// ПОКАЗ  ВСЕГО СПИСКА ОБЪЯВЛЕНИЙ ТУТ 
                    $addata = createAdData($row, $this->data);

					
					
					include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/realtcash.php';
					  $addata['ad_city'] = getCityName($addata['ad_city'], $config['realt_cityes_id'], $config['realt_cityes_name']);
					 
					//print_r($config['realt_cityes_id']);
					
					
					
					
                    //print_r ($addata);


                    $jcounter = (int)$adcounter - 1;
                    if ($this->data['map_view'] == 1) {

					
				$longitude	= isset ($longitude) ?$longitude:false;
				$latitude	= isset ($latitude) ?$latitude:false;
				$addata['ad_dom']	= isset ($addata['ad_dom']) ?$addata['ad_dom']:false;
				$addata['ad_price']	= isset ($addata['ad_price']) ?$addata['ad_price']:false;
				$addata['ad_komnat']= isset ($addata['ad_komnat']) ?$addata['ad_komnat']:false;	
               $addata['ad_url']= isset ($longitude) ?$longitude:false;
                        $addata['ad_marker'] = "green_Marker" . $adcounter . ".png";
                        $js_points .= 'map_points[' . $jcounter . ']=Array();';
                        $js_points .= 'map_points[' . $jcounter . ']["longitude"]=' . $longitude . ';';
                        $js_points .= 'map_points[' . $jcounter . ']["latitude"]=' . $latitude . ';';
                        $js_points .= 'map_points[' . $jcounter . ']["street"]="' . str_replace('"', '\"', $addata['ad_street']) . '";';
                        $js_points .= 'map_points[' . $jcounter . ']["number"]="' . $addata['ad_dom'] . '";';
                        $js_points .= 'map_points[' . $jcounter . ']["price"]="' . $addata['ad_price'] . '";';
                        $js_points .= 'map_points[' . $jcounter . ']["rooms"]="' . $addata['ad_komnat'] . '";';
                        $js_points .= 'map_points[' . $jcounter . ']["url"]="' . $addata['ad_url'] . '";';
                    }


                    if ($this->data['wap_view'] == 1) {

                        echo ($CI->page);
                        $str_add .= $CI->parser->parse('wap_realt_ad', $addata);
                    } else {

                        if ($addata['ad_show'] == 1) {
							if ($addata['ad_uid'] == "bling.by") {
							$str_add .= $CI->parser->parse('realt_partner_ad', $addata);
							}
							else{
							
							
							
							  
							 
							 $str_add .= $CI->parser->parse('realt_ad', $addata);
							  
							 
							 
							 
							 
							}	
								
							
							
                        }

                    }


                }
				
				if ($this->data['mlev'] == 4) {
				 
						//$str_add .= "</table>";
				 
				 }
// Обработка всех объявлений закончена


                break;

            default:
                $str_add .= "no table";
                break;


        }

	if ($this->data['map_view'] != 1 &&$this->data['mlev'] == 4) {
		$str_add  .=  getTAPE();
}	
		
		
        if ($this->data['map_view'] == 1) {
            $this->data['css'] .= "<script>var mapview=1;" . $js_points . "</script>";
        }

		
		$data['pager'] = isset($data['pager'])?$data['pager']:"";
        $str_add .= "<br style='clear:both;'><div style='clear:both;height:25px;'>";
        $str_add .= $data['pager'];
        $str_add .= "</div>";
		
		
		
 //echo($data['pager']);
// если это страница с сутками и первая страница  то показывем статью
        if ($cat_id == 11 && $firstad == 0 && $this->data['cityid'] == 1) {
            include 'inc_sutki_article.php';
        }

        $this->data['realt'] = $str_add;

        if (($ind == -1) && ($this->data['wap_view'] == 1)) {
            $this->data['realt'] = " ";
        }
//echo ($str_add);
//echo ("<textarea>".$CI->data['realt']."</textarea>");
        return;
    }


    //$this->load->library('pagination');
    // $config['base_url'] = '/blog/index/'; // ïóòü ê ñòðàíèöàì â ïåéäæåðå
    // $config['total_rows'] = $this->db->count_all('records'); // âñåãî çàïèñåé
    // $config['per_page'] =  5;   // êîëè÷åñòâî çàïèñåé íà ñòðàíèöå
    //$config['num_links'] = 5;    // êîëè÷åñòâî ññûëîê â ïåéäæåðå (òî÷íåå N/2)
    //$config['uri_segment'] = 3;  // óêàçûâàåì ãäå â URL íîìåð ñòðàíèöû
    //$this->pagination->initialize($config);
    // $data['pager']=$this->pagination->create_links();

    //// $from=intval($this->uri->segment(3));
    // $this->db->limit(5,$from);
    // $this->db->orderby("id", "desc");
    //$data['query']=$this->db->get('records');
    //$this->load->view('blog_view',$data);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
// показ одного объявления одно 
    public function getSingleAd()
    {
	
	 $CI =& get_instance();
        if (!$CI) {
            
            $CI->load->library('parser');
        }
		
	$data = array(
            'cityid' => $this->CI->city_model->cityID,
            'cityname_in' => "в " . $this->CI->city_model->cityNameIn,
            'cat' => 0
        );
 $this->data['searchform'] = $CI->parser->parse($this->data['$searchform_view'], $data);	
		
		
		
		
		
// должен быть сниму или сдаю (nj чтоопределено в htaccess 
$str_add="";

        $str_add .= $this->init_str_add(); //  Для всх страниц. Запись evc  ,  alert если есть и т.п. 

 
   //     if ($CI->uri->segment(4) == "snimu" || $CI->uri->segment(4) == "sdayu" || $CI->uri->segment(4) == "nasutki") {
  //      } else {
   //         $this->data['realt'] = "Неверные параметры страницы";
   //         return;
   //     }

   //     if (strlen($CI->uri->segment(5)) > 1) {
        $ad_url = $CI->uri->segment(5);
		
		$ad_url=$this->CI->realt_route_model->mysegments[4];
	//	echo($ad_url);
		
		
   //     } else {
    //        $this->data['realt'] = "Неверные параметры страницы";
    //        return;
    //    }

// СДЕЛАТЬ выборку по категориям только 1, 3, 5, 7 например на сниму и остальне на сдаю
        if ($this->data['mlev'] == 4) {
//echo  "1". $CI->uri->segment(1);echo  "2".$CI->uri->segment(2);
//echo  "3".$CI->uri->segment(3);echo  "4".$CI->uri->segment(4);
//echo  "5".$CI->uri->segment(5);echo  "6".$CI->uri->segment(6);
        }


        $params = array(
            'ad_url' => $ad_url,
            'ad_show' => '1',
            'order' => 'ad_postdate',
            'ordertype' => 'desc',
        );
        //echo $cat_id;

        unset($params['ad_show']);
        if ($this->data['mlev'] == 4) {

            unset($params['ad_show']);
        }


        switch ($this->CI->realt_route_model->mysegments[3]) {
            case 'snimu':
            case 'sdayu':
                $table = "ads";
                break;
            case 'nasutki':
            case 'sdayu':
                $table = "sutki";
                break;
        }
///echo($table);

//if ($this->data['mlev']==4){print_r ($params);}	
 //print_r ($params);
 
 $params['ad_show']=1;
 
        $query = $this->getAds($table, 0, 1, $params);
 //echo ($CI->db->last_query());
	 //echo (333333333333);	
//searchcode 		
	  	
		
		
		

        if ($this->data['mlev'] == 4) {
 
        }


        if ($query->num_rows() == 0) {
            $str_add .= "<h3>Объявление не найдено.</h3>Возможно вы зашли по старой ссылке и оно уже удалено.";
        } else {

            if (isset($row->ad_street) && strlen($row->ad_street) > 1) {
                $txtstreet = ", " . $row->ad_street;
            }


            switch ($table) {
                case 'sutki':
// начата обработка объявлений 

                    $alt = 1; // начата обработка объявлений 
                    foreach ($query->result() as $row) {
                        if ($alt == 1) {
                            $alt = 0;
                        } else {
                            $alt = 1;
                        }
                        $itemalt = ($alt == 1) ? " itemalt" : "";
                        $addata = array(
                            'ad_id' => $row->ad_id,
                            'ad_catid' => $row->ad_catid,
                            'ad_title' => $row->ad_title,
                            'ad_message' => $row->ad_message,
                            'ad_price' => $row->ad_price,
                            'ad_price2' => $row->ad_price2,
                            'ad_price3' => $row->ad_price3,
                            'ad_period2' => $row->ad_period2,
                            'ad_period3' => $row->ad_period3,
                            'ad_currency' => $row->ad_currency,
                            'ad_phones' => $row->ad_phones,
                            'ad_contactname' => $row->ad_contactname,
                            'ad_postdate' => $row->ad_postdate,
                            'ad_enddate' => $row->ad_enddate,
                            'ad_email' => $row->ad_email,
                            'ad_pictures' => $row->ad_pictures,
                            'ad_area' => $row->ad_area,
                            'ad_subarea' => $row->ad_subarea,
                            'ad_street' => $row->ad_street,
                            'ad_dom' => $row->ad_dom,
                            'ad_korpus' => $row->ad_korpus,
                            'ad_url' => $row->ad_url,
                            'ad_komnat' => $row->ad_komnat,
                            'ad_komnat' => $row->ad_komnat,
							
                            'itemalt' => $itemalt,
                            'ad_sp_mest' => $row->ad_sp_mest,
                            'ad_mainpic' => $row->ad_mainpic,
                            'ad_show' => $row->ad_show,
                            'ad_link' => $row->ad_link,
                            'ad_comments_count' => $row->ad_comments_count,
                        );
                        $delayed = false;

// замена телефонов
//include 'inc_repl_phones.php';



 
                        $addata['longitude'] = (float)$row->longitude;
                        $addata['latitude'] = (float)$row->latitude;


                        $addata['ad_mainpic'] = "http://neagent.by/modules/Realt/files/" . $addata['ad_mainpic'];


                        $addata['ad_firstpic'] = "<img src='" . base_url() . "themes/neagent_style/assets/images/kvartira.gif' width='60' height='50'  alt='Квартира' />";
// привести дату в нормальный вид
                        $addata['ad_postdate'] = $addata['ad_postdate'];
                        $addata['ad_komnat_txt'] = getKomnatString($addata['ad_komnat']);
                        $addata['mlev'] = $this->data['mlev']; // помечаем админа или кого еще чтобы в объявлении можно было видеть
                        if (strlen($addata['ad_url']) < 2) {
                            $addata['ad_url'] = $addata['ad_id'];
                        }
// добавляем у url начало snimu или sdayou
                        switch ($addata['ad_catid']) {
                            case '2':
                            case '4':
                            case '6':
                            case '8':
                            case '10':
                                $addata['ad_url'] = "http://neagent.by/snimu/" . $addata['ad_url'];
                                break;
                            case '1':
                            case '3':
                            case '5':
                            case '7':
                            case '11':
                                $addata['ad_url'] = "http://neagent.by/sdayu/" . $addata['ad_url'];
                                break;
                            default:
                                $addata['ad_url'] = "http://neagent.by/sdayu/" . $addata['ad_url'];
                        }

                        if (strlen($addata['ad_pictures']) > 2) {


                            $picarr = split("; ", $addata['ad_pictures']);


                            for ($i = 0; $i < count($picarr); $i++) {
                                $addata['ad_picturesarray'][$i] = "http://neagent.by/modules/Realt/files/" . $picarr[$i];
                                $addata['ad_picturesarraybig'][$i] = "http://neagent.by/modules/Realt/files/" . str_replace(".jpg", "-big.jpg", $picarr[$i]);
                                $addata['ad_picturesarraybig'][$i] = "http://neagent.by/modules/Realt/files/" . $picarr[$i];
                                $addata['ad_picturesarray'][$i] = "http://neagent.by/modules/Realt/files/" . "t_" . $picarr[$i];

                            }


//print_r($addata['ad_picturesarray']);


//imagesArr=split(pictures, ",")
//firstpic="<a rel=""pics_" & strAdId & """ href=""" & "uploads/n_" & imagesArr(0) & """><img src=""uploads/t_" & imagesArr(0)&  """ width=""60"" height=""50""   />" 
//firstpic="<a   href=""default.asp?ad_id=" &  strAdId &"""><img src=""uploads/t_" & imagesArr(0)&  """ width=""60"" height=""60""   />" 
                        } else {
                            $addata['sutki_firstpic'] = "<img src='" . base_url() . "themes/neagent_style/assets/images/nopic.gif' width='60' height='50'   />";
// firstpic="<img src=""themes/neagent/images/pic.gif"" width=""60"" height=""50""   />"
                        }

                        if ($this->data['mlev'] == 4) {
// Получить параметры клиента
                            $addata['admin_options'] = "<a href=''>Удалить </a><br>";
                            $addata['client'] = $row->ad_client;
                            $clientInfo = getClientInfo($row->ad_client);
//echo("id = " + $row->ad_client); 
                            $addata['client_name'] = $clientInfo['name'];
//$addata['end_date']=$clientInfo['name'];
                        }


                        $str_add .= $CI->parser->parse('realt_sutki_ad_single', $addata);


                        $cref = isset($_COOKIE["cref"]) ?$_COOKIE["cref"] :false ;
                        saveLog('zahod_na_sutki', ' cref=' . $CI->data['user_cref'] . " " . $cref);


                        $hits = (int)$row->ad_hits;
                        $this->db->where("ad_id", $row->ad_id);
                        $this->db->set("ad_hits", $hits + 1);
                        $this->db->update("sutki");

//$str_add .= $CI->parser->parse('realt_ad_options', $addata);


                    }
// Обработка всех объявлений закончена














                    break;


                    break;


                case 'ads':

				
				$txtstreet = isset($txtstreet)?$txtstreet:"";
				
 if (isset($row->ad_title)){
				$this->data['meta_title'] = $row->ad_title . $txtstreet . "- Neagent.by"; // /////////// исправить - tilу есть влюбом случае!!!!!!
				}
                 else{
				 
				 
				 $this->data['meta_title'] =   $txtstreet . "- Neagent.by"; //$data['NAME'];

}				 
					
					
                    $this->data['meta_description'] = $this->data['meta_title'] . "доска объявлений - Neagent.by";
					
					

$partner_arr=array();					
					

                    foreach ($query->result() as $row) {
/////// ПОКАЗ ОДИНОЧНОГО 

                        $this->data['single_ad'] = 1;
                        $addata = createAdData($row, $this->data);
						
						
						
						include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/realtcash.php';
					  $addata['ad_city'] = getCityName($addata['ad_city'], $config['realt_cityes_id'], $config['realt_cityes_name']);
					  
					  
					  
                        $addata['single_ad'] = 1;


                        if ($this->data['wap_view'] == 1) {
                            $ad_view = "wap_realt_ad_single";
                        } else {
						
						if ($addata['ad_uid'] == "bling.by") {
						
						
						array_push ($partner_arr, $addata);
						continue;
							  $ad_view = "realt_partner_ad";
							}
							else{
							 $ad_view = "realt_ad";
							}

							
                        }

						
						
						
						
						$ad_unic_views="xx";
						
					//	$ad_unic_views = ad_view_counter("100" . $addata['ad_id']);
						
						
						
						 $addata['ad_unic_views'] = $ad_unic_views;
						 

                        if ($addata['ad_show'] == 0 && $addata['ad_pending'] == 1) {
                            $str_add .= "<div> <div style='border:1px solid red; padding:18px;'><div style='color:red;'>Это объявление на модерации. 
После проверки модератором оно станет доступно в рубрике.</div>Время проверки может занять от получаса часа до трех часов. 
После проверки объявление появится в рубрике первым.</div></div>";
                        }


                        if ($addata['ad_show'] == 0 && $addata['ad_pending'] == 0) {
                            $str_add .= "<div> <div style='border:1px solid red; padding:18px;'><div style='color:red;'>Это объявление удалено. 
</div>Объявление может быть удалено автором, автоматически через 14 дней после подачи, или модератором. Причины удаления объявлений читайте в рубрике вопрос-ответ.</div></div>";
                            if ($this->data['mlev'] == 4) {
                                $str_add .= $CI->parser->parse($ad_view, $addata);
                            }
                        } else {
                            $str_add .= $CI->parser->parse($ad_view, $addata);
                        }


////////////////


//<script type="text/javascript"><!--<![CDATA[
///* (c)AdOcean 2003-2011 */
///* PLACEMENT: smartcode.neagent.by.240_400 */
//if(location.protocol.substr(0,4)==\'http\')document.write(unescape(\'%3C\')+\'script id="smartcode.neagent.by.240_400" src="\'+location.protocol+\'//by.adocean.pl/_\'+(new Date()).getTime()+\'/ad.js?id=hNIM7u0t7SJtV88TXoG.XPWjngddn3t_vJAL3rGApBX.47/x=\'+screen.width+\'/y=\'+screen.height+\'" type="text/javascript"\'+unescape(\'%3E%3C\')+\'/script\'+unescape(\'%3E\'));
////]]>--></script>


                    }


					
					///еще раз пробегаемся и показываем объявы от партнеров
					
				for ($i = 0; $i < (count($partner_arr)); $i++) {	
					$addata = $partner_arr [$i];
					$ad_view = "realt_partner_ad";
					 $str_add .= $CI->parser->parse($ad_view, $addata);
					
					}
					
					
					
					
/////////////// показ на карте ////////////////////////////////////////
                    $mparams = array(
                        'city' => 1,
                        'postdate' => '0',
                        'cat' => -1
                    );
                    $str_add .= get_map_params($mparams);
                    $mapdata = array(
                        'mapcode' => get_map_code(),
                        'address' => 'Это где-то здесь',
                        'longitude' => $addata['longitude'],
                        'latitude' => $addata['latitude']
                    );


                    if ($this->data['wap_view'] == 1) {
                        $str_add .= $CI->parser->parse('wap_realt_ad_map', $mapdata);
                    } else {
                        $str_add .= $CI->parser->parse('realt_ad_map', $mapdata);
//////////////////////////////////////////////////////////////////////////////////
                    }


                    if ($this->data['wap_view'] == 1) {
                    } else {

                        if ($addata['ad_show'] != 0 || $this->data['mlev'] == 4) {
//if ($this->data['mlev']==4) {
                            $str_add .= $CI->parser->parse('realt_ad_options', $addata);
//}
                            if (1 == 1) {
//echo("cc=" . $addata['ad_comments_count']);

                                if ($addata['ad_comments_count'] > 0) {
                                    $addata['ad_comments'] = getAdComments($row->ad_id, $row->ad_email, $row->ad_uid, "", $this->data['mlev']);
                                }
                                $str_add .= $CI->parser->parse('realt_ad_comments', $addata);
                            } else {
                                if ($addata['ad_comments_count'] > 0) {
                                    $str_add .= "<br>Комментарии могут читать только зарегистрированные пользователи.<br>";
                                }
                            }
                        }

                    }


            } //end case ads


        }

// end else
        if ($this->data['mlev'] == 4) {
//$str_add .= $CI->parser->parse('realt_ad_map', $addata);
        }


        if ($this->data['wap_view'] == 1) {
        } else {

            $str_add .= '<div style="background-color:#f4f3e5;margin-top:18px;"><script type="text/javascript"><!--<![CDATA[
/* (c)AdOcean 2003-2011 */
/* PLACEMENT: smartcode.neagent.by.468_60 */
if(location.protocol.substr(0,4)==\'http\')document.write(unescape(\'%3C\')+\'script id="smartcode.neagent.by.468_60" src="\'+location.protocol+\'//by.adocean.pl/_\'+(new Date()).getTime()+\'/ad.js?id=M2AMhFoG7YcmAb3TJ3W8x4S9bPBSQ2bxyWWoW.qgb.f.B7/x=\'+screen.width+\'/y=\'+screen.height+\'" type="text/javascript"\'+unescape(\'%3E%3C\')+\'/script\'+unescape(\'%3E\'));
//]]>--></script></div>
';
        }


//$str_add .= "Просмотр объявления";

        $this->data['realt'] = $str_add;
		
		
		
		
		
		
		
		
//echo ($str_add);
//echo ("<textarea>".$CI->data['realt']."</textarea>");
        return;


    }


    function add_hit($ad_id, $table)
    {
        $CI =& get_instance();
        $CI->db->where("ad_id", $ad_id);
        $CI->db->set('ad_hits', 'ad_hits+1', FALSE);
        $CI->db->update($table);
    }


    public function getAds($table, $from, $limit, $params)
    {
// Параметр table - ключевой - он определяет  как будут обработаны данные из данной таблицы, т.к. данные в таблицах могут быть абсолютно разные
//echo ("table=$table;" );
//echo ("limit=$limit;" );

$CI =& get_instance();
 //print_r($params);
 $city_id = isset($params['city_id'])?$params['city_id']:false;
 $cat_id = isset($params['cat_id'])?$params['cat_id']:0;
 $ad_url = isset($params['ad_url'])?$params['ad_url']:0;
 $cat_id = (int)$cat_id;
 $CI->db->limit($limit, $from);
 $order = $params['order'];

 $ordertype = $params['ordertype'];
 $cat_id = (int)$cat_id;
$ad_show = isset($params['ad_show'])?$params['ad_show']:null;

//echo (8888);

        if (($ad_show == "1") || ($ad_show == "0")) {
 //echo ("as" . $ad_show);
            if (isset($params['ad_fakefor'])) {
                $CI->db->where("(ad_show=" . $ad_show . " or ad_fakefor LIKE '%" . $params['ad_fakefor'] . "%' ) ");
            } else {
                $CI->db->where('ad_show', $ad_show);
            }
        } else {

 
            if (isset($params['ad_fakefor'])) {
                $CI->db->where("((ad_show=1 or ad_show=0)  or ad_fakefor LIKE '%" . $params['ad_fakefor'] . "%' ) ");

            } else {

            }


        }

        if (isset($params['ad_pending'])) {
            $CI->db->where("ad_pending", $params['ad_pending']);

        }

        switch ($table) {
            case 'sutki':
                $CI->db->select('*');
                if ($city_id > 0) {
                    $CI->db->where('ad_city', "" . $city_id . "");
                }
                ;
                if ($cat_id > 0) {
                    $CI->db->where('ad_catid', "" . $cat_id . "");
                }
                ;
                if ($ad_url != '') {
                    $CI->db->where('ad_url', $ad_url);
                }
                ;
                $this->db->order_by("ad_type", "desc");
                $this->db->order_by("ad_up_date", "desc");
                $this->db->order_by("ad_postdate", "desc");
                $CI->db->from('sutki');
                break;


                default: // Это таблица ads  или другие 
                $CI->db->select('*');
                if ($cat_id > 0) {
                    $CI->db->where('ad_catid', "" . $cat_id . "");
                }
                ;
                if ($ad_url != '') {
                    $CI->db->where('ad_url', $ad_url);
                }
				else{$CI->db->where('ad_city', $city_id);}
                ;
                $this->db->order_by("ad_up_date", "desc");
                $this->db->order_by("ad_postdate", "desc");
                $CI->db->from($table);
                break;
        }


        $query = $CI->db->get();

        //echo 	("<!--");
        // echo 	($CI->db->last_query());
        // echo 	("-->");
//echo 	("-----");
// Ниже показана переменная, сколько на странице объявлений.
//echo (config_item('realt_ads_per_page')."iii");

        return $query;
        //return ;
    }


	
	
	
	
	
	
	
	
	
	
	
	
	
	
    public function getAddFormPage()
    {
//работа с отправкой объявления
$CI =& get_instance();
 $CI->load->library('parser'); 
        if ($this->data['wap_view'] == 1) {$this->data['searchform'] = ""; }
//Определить город





$str_add="";



//
// определить, переданы ли данные? в зависимости от этого устанавливаем модэ 

        $act = (isset($_POST['act']) &&  $_POST['act'] != '') ? $_POST['act'] : "default";
		
		
		
        $str_add .= $this->init_str_add(); //  Для всх страниц. Запись evc  ,  alert если есть и т.п. 

//echo ("==========");
        $segment_cat = $CI->uri->segment(3);
        $segment_subcat = $CI->uri->segment(4);
        if ($segment_subcat != "" && $segment_cat != "wap") {
            $act = "edit";
            $act = ($_POST['act'] != '') ? $_POST['act'] : "edit"; // может и лишнее, но работает 
        }

        switch ($act) {
            case 'post':
            case 'doedit':
//СОХРАНЕНИЕ ОБЪЯВЛЕНИЯ

                if ($this->data['usemap'] == true) {
// определяем координаты

                    $ad_city = (int)chkString($CI->input->post('ad_city'), "SQLString");
                    $ad_street = chkString($CI->input->post('street'), "SQLString");
                    $ad_dom = chkString($CI->input->post('dom'), "SQLString");
                    $ad_korpus = chkString($CI->input->post('korpus'), "SQLString");
					$ad_etazh = chkString($CI->input->post('etazh'), "SQLString");
				    $ad_etazhej = chkString($CI->input->post('etazhej'), "SQLString");
					$ad_pl_o = chkString($CI->input->post('pl_o'), "SQLString");
					$ad_pl_z = chkString($CI->input->post('pl_z'), "SQLString");
					$ad_pl_k = chkString($CI->input->post('pl_k'), "SQLString");
						 $ad_pl_o=str_replace (",", ".",  $ad_pl_o);
						 $ad_pl_z=str_replace (",", ".",  $ad_pl_z);
						 $ad_pl_k=str_replace (",", ".",  $ad_pl_k);
						 $ad_pl_o=((int)($ad_pl_o * 100)) / 100;
						 $ad_pl_z=((int)($ad_pl_z * 100)) / 100;
						 $ad_pl_k=((int)($ad_pl_k * 100)) / 100;
						
                    $ad_srok = (int)$CI->input->post('srok');
                    if ($ad_srok == 0) {
                        $ad_srok = 14;
                    }

                    if ($ad_city == 0) {
                        $ad_city = 1;
                    }

                    $gorod = getCityName($ad_city, $config['realt_cityes_id'], $config['realt_cityes_name']);
                    $value = "Беларусь,+" . $gorod . ",+" . $ad_street;

                    if ($ad_dom != "") {
                        $value .= ", дом " . $ad_dom;
                    }
                    if ($ad_korpus != "") {
                        $value .= ", к " . $ad_korpus;
                    }
                    $coordinates = getcoordinates($value);
                    if ($coordinates) {
                        $pos = split(" ", $coordinates);
                        $longitude = $pos[0];
                        $latitude = $pos[1];
                    }
                }
//

                $ad_for = chkString($CI->input->post('for'), "SQLString");
                $ad_street = chkString($CI->input->post('street'), "SQLString");
                $ad_area = chkString($CI->input->post('ar'), "SQLString");
                if (!is_numeric($ad_area)) {
                    $ad_area = 0;
                }
                $ad_subarea = chkString($CI->input->post('subar'), "SQLString");
                if (!is_numeric($ad_subarea)) {
                    $ad_subarea = 0;
                }
                $ad_catid = chkString($CI->input->post('cat'), "SQLString");
                if (!is_numeric($ad_catid)) {
                    $err_mess = '<li>Не выбрана категория объявления</li>';
                }
                $ad_message = chkString($CI->input->post('content'), "SQLString");
                $ad_phones = chkString($CI->input->post('phones'), "SQLString");
                $ad_contactname = chkString($CI->input->post('ad_name'), "SQLString");
                $ad_email = chkString($CI->input->post('ad_email'), "SQLString");
                $form_userid = chkString($CI->input->post('userid'), "SQLString");

                if ($this->user['id_user'] > 0) {
                    $ad_email = $this->user['email'];
                }


                $ad_hideemail = chkString($CI->input->post('hideemail'), "SQLString");

                $ad_komm_type = chkString($CI->input->post('ad_kommtype'), "SQLString");

                $ad_postdate = date("Y-m-d H:i:s");
                $ad_enddate = dateAddDays($ad_postdate, $ad_srok);


/////////////////
/// ПРОВЕРКА ПОДЛИННЫЙ ЛИ ТЕЛЕФОН 


                $vcats = config_item('realt_phone_verification_cats');
                $vcatsArr = explode(",", $vcats);


                $verificateThisCat = false; // ini
                if ((count($vcatsArr) == 0) || in_array($ad_catid, $vcatsArr)) {
                    $verificateThisCat = true;
                }

                if ($this->data['phone_verification'] == 1) {
				
				
	////////////////////
	           if ( $ad_email == "vlad.glebov.81@mail.ru"){
			   $this->user['id_user'] == 92979;
			   }
	////////////////////////////////////
	
                    if (!$this->user['id_user'] > 0) {
//echo("--" .$user['id_user']);

                    saveLog('errors.txt', 'Ошибка вход не выполнен.  ' .  $this->user['id_user']  . " | " .  $_SERVER['HTTP_USER_AGENT'] . " | "     );
						
                    $this->data['realt'] = "<h2>Вход не выполнен</h2><i>Требуется снова войти на сайт. Поля формы были автоматически сохранены.</i>";
					

					$addata= dataFromPost();
					$ad = $CI->ad;
					$ad->setdataArr($addata);
					//print_r($ad->fields);
					$ad->set_table('ads_cash');
					$ad->save($ad->fields);
					
					
$this->login("http://neagent.by/ad-form");
					
                    return;
	
                    }

					
					

                    $phone = getonlydigits($ad_phones);
                    $thisPhoneAllowed = phoneAllowed($phone, $this->user['id_user']);
                    if ($verificateThisCat == true) {
                        if ($thisPhoneAllowed == false) {
                            $this->data['realt'] = "<h2>Телефон " . $ad_phones . " не проверен</h2><i>Требуется верификация номера телефона через СМС</i>";
                            return;
                        }
                    }

                }


//$ad_phones
////////////////////


                $table = getTableFromCatID($ad_catid);
                $ad_city = (int)chkString($CI->input->post('ad_city'), "SQLString");


                include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/realtcash.php';
                $cityname = getCityName($ad_city, $config['realt_cityes_id'], $config['realt_cityes_name']);
                $autotitle = generateAutoTitle($table, $ad_catid, $ad_message, $cityname, $ad_street, $ad_subarea);


                $ad_title = $autotitle['title'];
                $ad_url = $autotitle['url'];
                $ad_showpolitic = chkString($CI->input->post('showto'), "SQLString");
                $ad_komnat = chkString($CI->input->post('komnat'), "SQLString");


                if (strpos($ad_komnat, "-")) {

                    $ad_komnat_Arr = explode("-", $ad_komnat);
                    $ad_komnat_min = $ad_komnat_Arr[0];
                    $ad_komnat_max = $ad_komnat_Arr[1];
                    if ($ad_komnat_min > $ad_komnat_max) {
                        $err_mess = '<li>Неверное значение количества комнат.</li>';
                    }
                    if (!is_numeric($ad_komnat_min)) {
                        $err_mess = '<li>Неверное значение количества комнат.</li>';
                    }
                    if (!is_numeric($ad_komnat_max)) {
                        $err_mess = '<li>Неверное значение количества комнат.</li>';
                    }
                    $ad_komnat = $ad_komnat_min; // для совместимости. Потом поле ad_komnat вобще лучше удалить 
                } else {
                    if (!is_numeric($ad_komnat)) {
                        $err_mess = '<li>Не выбрано количество комнат</li>';
                    }
                    $ad_komnat_min = $ad_komnat;
                    $ad_komnat_max = $ad_komnat;
                }


                $ad_price = chkString($CI->input->post('price'), "SQLString");
                $ad_price_object = chkString($CI->input->post('priceobject'), "SQLString");
if (!is_numeric($ad_price_object)) {
$ad_price_object=0;
}				
 				
				
                $ad_price = str_replace("до", "0-", $ad_price);


                if (strpos($ad_price, "-")) {
                   // echo(1);
                    $ad_price_Arr = explode("-", $ad_price);
                    $ad_price_min = $ad_price_Arr[0];
                    $ad_price_max = $ad_price_Arr[1];
                    if ($ad_price_min > $ad_price_max) {
                        $err_mess = '<li>Неверное значение дапазона цен.</li>';
                    }
                    if (!is_numeric($ad_price_min)) {
                        $err_mess = '<li>Неверное значение дапазона цен.</li>';
                    }
                    if (!is_numeric($ad_price_max)) {
                        $err_mess = '<li>Неверное значение дапазона цен.</li>';
                    }
                    $ad_komnat = $ad_price_min; // для совместимости. Потом поле ad_komnat вобще лучше удалить 
                } else {
                   // echo(2);
                    if (!is_numeric($ad_price)) {
                        $err_mess = '<li>Неверное значение цены.</li>';
                    }
                    $ad_price_min = $ad_price;
                    $ad_price_max = $ad_price;
                }


                $ad_show = 1;


                if (!is_numeric($ad_price)) {
                    $err_mess = '<li>Не выбрана цена</li>';
                }

                $ad_price2 = chkString($CI->input->post('ad_price2'), "SQLString");
                $ad_price3 = chkString($CI->input->post('ad_price3'), "SQLString");
                $ad_period2 = chkString($CI->input->post('ad_period2'), "SQLString");
                $ad_period3 = chkString($CI->input->post('ad_period3'), "SQLString");

                $ad_currency = chkString($CI->input->post('currency'), "SQLString");
                if (!is_numeric($ad_currency)) {
                    $ad_currency = 2; // Редактировать. Пока валюта устанавливается в доллары
                }

                $realt_currency_rate = config_item('realt_currency_rate');
//print_r ( $realt_currency_rate);

                $ad_default_price = defaultPrice($ad_currency, $ad_price, $realt_currency_rate); // формируем цену по умолчанию - для поиска 
                $ad_default_price_min = defaultPrice($ad_currency, $ad_price_min, $realt_currency_rate);
                $ad_default_price_max = defaultPrice($ad_currency, $ad_price_max, $realt_currency_rate);
//$ad_currency= 1 рубли 2 доллары 3 евро


//формирует пароль для нового 
                if ($act == "post") {
                    $ad_secretcode = generate_password(7);
                    if ($this->data['mlev'] == 4) {
//echo("<br>2-" . (microtime()-$CI -> data['timestart']));
                    }
/// проверка на уникальность 
                    $sc_ex = secretCodeExists($code);
                    $j = 0;
                    while ($sc_ex != TRUE) {
                        $ad_secretcode = generate_password(7);
                        $j = $j + 1;
                    }


                    if ($this->data['mlev'] == 4) {
//echo("<br>3-" . (microtime()-$CI -> data['timestart']));
                    }


/// отправка письма, если более 3 попыток генерации кода уникального 
                    if ($j > 2) {
                        $config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                        $CI->load->library('email', $config);
                        $CI->email->set_newline("\r\n");
                        $CI->email->from('dakh@mail.ru');
                        $CI->email->to('dakh@mail.ru');
                        $CI->email->subject('secretcode - более трех попыток');
                        $CI->email->message('попытка=' . $j . "; ad_secretcode=" . $ad_secretcode);
                        $CI->email->send();
                    }
                }


// если реферрер не тот - скорее всего автоматическая рассылка 
                $refer = strtolower($_SERVER['HTTP_REFERER']);
                if (!strpos($refer, "neagent.by") || strpos($refer, "neagent.by") < 1) {
//$this->data['realt']="Вернитесь на <a href='http://neagent.by/ad-form'>страницу подачи объявления</a> и заполните форму. ";
                    $msg = "ad_message = $ad_message; ad_komnat=$ad_komnat;  ad_price = $ad_price;   ad_phones=$ad_phones  referrrer=" . $_SERVER['HTTP_REFERER'];
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

//$ad_email ="tr@toomail.biz";

                if (strpos($ad_email, "@") > 1 && $table == "ads") {
                    $ad_email = rtrim(trim($ad_email));
					$inblack = inEmailBlackList($ad_email);
                    if ($inblack) {
                        $ad_uid = $CI->data['user_uid'];
                        $config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                        $CI->load->library('email', $config);
                        $CI->email->set_newline("\r\n");
                        $CI->email->from('info@neagent.by');
                        $CI->email->to('info@neagent.by');
                        $CI->email->subject('Email отклонен. написано что он агент  ' . $ad_email);
                        $CI->email->message($ad_email . "; тел. " . $ad_phones . "; uid=" . $ad_uid);
                        $CI->email->send();
//$ad_email="info@neagent.by";

if ($inblack==1) {
                        $this->data['realt'] = "<h2>ВЫ АГЕНТ</h2><i>Система определила вас как агента. Объявление отклонено.</i>";
}						
else{
                        $this->data['realt'] = "<h2>Email сервер заблокирован. </h2><i> Почта $ad_email , которую вы используете, заблокирована.</i>"   ;
}						
						
                        return;
                    }
                }
                ////////
//если  в адресе есть подозрительные сервера то на модерацию
				
		
	
if (strpos($ad_email, "mailblog.biz") >-1 || strpos($ad_email, "rainmail.biz") >-1 || strpos($ad_email, "postalmail.biz") >-1) {
$CI->data['scenery_moderate'] = 1;
$CI->data['scenery_descriptions'] = $CI->data['scenery_descriptions'] . " +  email подозр. ";
}	
				
				
	
//если  телефон на 025 и имя сергей или владимир или пустое  и с этого же uid  есть уже хоть одно объявление на другой улице 
//то оба в модерацию.

// $has_different = user_has_different_ads($CI->data['user_uid'], $ad_phones . $ad_street);
$has_different =false; // не проверяем 



if ((strpos($phone, "37525") >-1)&&($ad_contactname=="Сергей"||$ad_contactname=="Владимир"||$ad_contactname==" "||$ad_contactname=="")&&$has_different){
$CI->data['scenery_moderate'] = 1;
$CI->data['scenery_descriptions'] = $CI->data['scenery_descriptions'] . " +  владим. дает на разные. ";
putModerateAllAds($CI->data['user_uid']);
}



if ($has_different){
$CI->data['scenery_moderate'] = 1;
$CI->data['scenery_descriptions'] = $CI->data['scenery_descriptions'] . " +  есть другие об. ";
putModerateAllAds($CI->data['user_uid']);
}
	
				
				/////////////
				
				
				
				
				

//''''''''''''''''' ОПРЕДЕЛЯЕМ, АГЕНТСТВО ИЛИ НЕТ ПО НОМЕРУ ТЕЛЕФОНА 

                    $chk_phon = chkPhones($ad_phones); // если агент то тру 
                    
					
					
					
					
///////////////////////////////////// отмена блокировки для одного клиента в рубрику продам ////////////////////////
					if ( $ad_catid == "13" ){
					if (strpos($ad_phones, "3254983")>0 ||strpos($ad_phones, "6875649")>0 ||strpos($ad_phones, "8519499")>0 ||strpos($ad_phones, "3254983")>0  ){
					 $chk_phon =false;
					}
					if (strpos($ad_phones, "325-49-83")>0 ||strpos($ad_phones, "687-56-49")>0 ||strpos($ad_phones, "851-94-99")>0 ||strpos($ad_phones, "325-49-83")>0  ){
					 $chk_phon =false;
					}
					
					
					}
////////////////////////////////////////////////////////////////////////



                if ($chk_phon && $table == "ads") {
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $CI->load->library('email', $config);
                    $CI->email->set_newline("\r\n");
                    $CI->email->from('dakh@mail.ru');
                    $CI->email->to('dakh@mail.ru');
                    $CI->email->subject('блокировка по номеру тел');
                    $CI->email->message('агент пытался дать тел=' . $ad_phones . ";" . $str . "; uid=" . $CI->data['user_uid']);
                    $CI->email->send();

//echo ("---в черном списке!!!!!!!!!---");
                    $inLIST = true;
                    $BLACKNUMBER = true;
                    switch (config_item('realt_black_action')) {
                        case 'deny':
                            $this->data['realt'] = "<h2>К сожалению, подача Вашего объявления запрещена.</h2><i>Этот номер телефона в черном списке. <br> Возможно этот телефон как-то связан с агентствами, или заблокирован за нарушения. <br></i>";
                            return;
                            break;
                        case 'selfuid':
                            $ad_fakefor = "UID=" . $uid . "; - SELFUID";
                            break;
                        case 'sessionblock':
                            $this->data['realt'] = "<h2>Вы заблокированы</h2><i>Вы даете объявление на телефон, который похож не телефон агентства. Этот номер в черном списке. <br>Сочувствуем, но вы на некоторе время ограничены в пользовании сайтом. ";
                            return;
                            break;
                        default: // 'allow' 
                            break;
                    }
                }
//////////////////////////


                if (chkCodes($ad_phones)) {
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $CI->load->library('email', $config);
                    $CI->email->set_newline("\r\n");
                    $CI->email->from('dakh@mail.ru');
                    $CI->email->to('dakh@mail.ru');
                    $CI->email->subject('не прошел код');
                    $CI->email->message('  тел=' . $ad_phones . ";" . $str . "; uid=" . $CI->data['user_uid']);
                    $CI->email->send();


                    $CI->data['scenery_moderate'] = 1;
                    $CI->data['scenery_descriptions'] = $CI->data['scenery_descriptions'] . " +  код ошибочный ";


//$this->data['realt']="<h2>К сожалению, подача Вашего объявления запрещена.</h2><i>Этот номер телефона в черном списке. <br> Возможно этот телефон как-то связан с агентствами, или заблокирован за нарушения. <br></i>";
//return; 
//break;


                }


///////////////////////////
//Определяем, не написано ли слишком много цифр


                if (config_item('realt_moderate_max_digits') != '') {
                    $digcount = strlen(getonlydigits($ad_message));
                    if ($digcount > config_item('realt_moderate_max_digits')) {
                        $CI->data['scenery_moderate'] = 1;
                        $CI->data['scenery_descriptions'] = $CI->data['scenery_descriptions'] . " + слишком  много цифр";
                    }
                }
////////////////////////


                ///////////////////////////
//Определяем, не написано ли слишком много цифр в группе 


                if (config_item('realt_moderate_max_digits') != '') {
                    $digcount = getmaxdigits($ad_message);
                    $digs = (int)$digcount[0];
                    if ($digs > config_item('realt_moderate_max_digits_group')) {
                        $CI->data['scenery_moderate'] = 1;
                        $CI->data['scenery_descriptions'] = $CI->data['scenery_descriptions'] . " + слишком  много цифр в группе:" . $digs . "  " . $digcount[1];
                    }
                }
////////////////////////


                ///////////////////////////
//Определяем, не слишком ли короткое имя
                if (config_item('realt_moderate_min_name_lenth') != '') {
                    $cncount = strlen($ad_contactname);
                    if ($cncount < config_item('realt_moderate_min_name_lenth')) {
                        $CI->data['scenery_moderate'] = 1;
                        $CI->data['scenery_descriptions'] = $CI->data['scenery_descriptions'] . " + слишком  короткое имя";
                    }
                }
////////////////////////


if ($ad_email == "Zubator87@mail.ru") {
$CI->data['scenery_moderate'] = 0;
}





////////////проверяем на спам-слова
                if (chkSpam($ad_message)) {
                    $this->data['realt'] = "<h2>К сожалению, подача Вашего объявления запрещена.</h2><i>Ваше объявление определено системой, как нежелательное. <br> Скорее всего оно нарушает правила сайта или содержит рекламу.Возможно также, что этот телефон как-то связан с агентствами, или заблокирован за нарушения. <br></i>";
                    return;
                    break;
                }


///обработка 
                $ad_message = removeExtraExclamations($ad_message);

                if ($table == "ads") {
                    $ad_message = addSpaceAfterComma($ad_message);
                }


                $ad_uid = $CI->data['user_uid'];
                $ad_uic = (int)$_COOKIE["uic"];
                $ad_cref = $CI->data['user_cref'];
                $ad_ip = $_SERVER["REMOTE_ADDR"];
                $ad_evc1 = $_COOKIE["evc"];
                $ad_evc = chkString($CI->input->post('evc'), "SQLString");


                if ($act == "post") { // это отправка нового объявления. Не редактирование 

//////////////////// сохранение картинок 
                    $filesArray = $CI->input->post('images');
                    $images = "";
                    $del = "";
                    if ($filesArray) { // если картинки есть в форме
                        foreach ($filesArray as $i => $value) {
                            $imageURL = $filesArray[$i];
                            //echo(" imageURL" . $imageURL); ///del
                            $imageURL = str_replace("/tmp/t_", "/", $imageURL);
                            //echo(" imageURLrepl" . $imageURL);
                            if (strpos($filesArray[$i], '/tmp/t_') === FALSE) {
                                echo "Ошибка p4";
                                return;
                            }
                            $filename = $filesArray[$i];
                            $parts = explode('/tmp/t_', $filename);
                            $filename = array_pop($parts); // чистое имя файла без t_
                            $fullfilename = config_item('realt_temp_upload_folder') . $filename;
                            $fullthumbname = config_item('realt_temp_upload_folder') . "t_" . $filename;
                            $oldfile1 = $fullfilename; // это файл полный 
                            $newfile1 = str_replace("/tmp/", "/", $fullfilename); // это  новый путь файл полный
                            $oldfile2 = $fullthumbname; //  это файл превью 
                            $newfile2 = str_replace("/tmp/", "/", $fullthumbname); // это новый путь для превью
                            if (!copy($oldfile1, $newfile1)) {
                                echo "failed to copy file1...\n";
                            }
                            if (!copy($oldfile2, $newfile2)) {
                                echo "failed to copy file2...\n";
                            }
                            $images .= $del . $filename;
                            $del = "; ";
                        }
                    } // конец if 
/////////////////////////////////////

//return ; ///del

///// Это редактирование
///// Если сутки, то создать первую картинку
                    if ($filesArray) {
                        $filename = $filesArray[0];
                        $parts = explode('/tmp/t_', $filename);
                        $filename = array_pop($parts); // чистое имя файла без t_
                        $f = config_item('realt_temp_upload_folder') . $filename;
                        $newf = config_item('realt_temp_upload_folder') . "main_" . $filename;
                        $mainpic = "";


                        $mainpic = resizePic($f, $newf, 5);
                        $mainpic = $newf;
                        $oldfileMain = $mainpic;
                        $newfileMain = str_replace("/tmp/", "/", $mainpic);
                        if (!copy($oldfileMain, $newfileMain)) {
                            echo "failed to copy filemain...\n";
                        }
                        $filename = $mainpic;
                        $parts = explode('/tmp/', $filename);
                        $mainpic = array_pop($parts); // чистое имя файла без t_
                    }
                }


                if ($act == "doedit") {
//////////////////// сохранение картинок 
                    $filesArray = $CI->input->post('images'); // это картинки которые мы должны сохранить
                   
                    //echo('<br>');
                    $images = "";
                    $del = "";
                    if ($filesArray) { // если картинки есть в форме
                        foreach ($filesArray as $i => $value) {
                            $imageURL = $filesArray[$i];
                            //echo(" обрабатывается imageURL" . $imageURL);
                            $imageURL = str_replace("/tmp/t_", "/", $imageURL);
                            //echo(" imageURLrepl" . $imageURL);
                            //print_r($filesArray);
                            if (strpos($filesArray[$i], '/tmp/t_') === FALSE) { // ЕСЛИ не в темп _ЗНАЧИТ КАРТИНКА УЖЕ ОБРАБОТАНА БЫЛА 
                                //echo(" картинка была обработана"  ); //del	
                                $filename = $filesArray[$i];
                                //$parts		= explode('/t_', $filename);
                                //$filename	= array_pop($parts); // чистое имя файла без t_		
                                //echo ("Ошибка p4");
                            } else {
//echo(" картинка не была обработана"  ); //del	
                                $filename = $filesArray[$i];
                                $parts = explode('/tmp/t_', $filename);
                                $filename = array_pop($parts); // чистое имя файла без t_
                                $fullfilename = config_item('realt_temp_upload_folder') . $filename;
                                $fullthumbname = config_item('realt_temp_upload_folder') . "t_" . $filename;
                                $oldfile1 = $fullfilename; // это файл полный 
                                $newfile1 = str_replace("/tmp/", "/", $fullfilename); // это  новый путь файл полный
                                $oldfile2 = $fullthumbname; //  это файл превью 
                                $newfile2 = str_replace("/tmp/", "/", $fullthumbname); // это новый путь для превью
                                if (!copy($oldfile1, $newfile1)) {
                                    echo "failed to copy file1...\n";
                                }
                                if (!copy($oldfile2, $newfile2)) {
                                    echo "failed to copy file2...\n";
                                }
                            }
                            $images .= $del . $filename;
                            $del = "; ";
                        }
                    } // конец if 


///////// ЭТО редактирование тоже
///// Если сутки, то создать первую картинку  
                    if ($filesArray) {
                        $filename = $filesArray[0];
                        $mainpic = "main_" . $filename;
///////// ИСПРАВИТЬ ВЕДЬ МОЖЕТ ЭТО ДРУГАЯ КАРТИНКА А НЕ ПЕРВАЯ, ДЕЛАТЬ ПРЕВЬЮЩКУ, ЕСЛИ ФАЙЛА НЕ СУЩЕСТВУЕТ
                        if (strpos($filesArray[0], '/tmp/t_') === FALSE && 0 == 2) { // проверка, если 
                        } else {
                            $parts = explode('/tmp/t_', $filename);
                            $filename = array_pop($parts); // чистое имя файла без t_
                            $f = config_item('realt_temp_upload_folder') . $filename;
                            $newf = config_item('realt_temp_upload_folder') . "main_" . $filename;
                            $mainpic = "";


                            if (!file_exists($f)) {
//echo("нет такого файла!");
                                $f = str_replace("/tmp/", "/", $f);

                            }


                            $mainpic = resizePic($f, $newf, 5);
                            $mainpic = $newf;
                            $oldfileMain = $mainpic;
                            $newfileMain = str_replace("/tmp/", "/", $mainpic);
                            if (!copy($oldfileMain, $newfileMain)) {
                                echo "failed to copy filemain...\n";
                            }
                            $filename = $mainpic;
                            $parts = explode('/tmp/', $filename);
                            $mainpic = array_pop($parts); // чистое имя файла без t_
                        }
                    }
//////
                }


//////////// Если платное объявление , то переадресуем на страницу с данными ип
                if (($ad_catid == 11 || $ad_catid == 12) && $act == "post") {

////////////////////
//для суток-  сохраняем картинки и отправиляем пока на почут мне 
                    $filesArray = $CI->input->post('images');
                    $images2 = "";

                    if ($filesArray) {
                        foreach ($filesArray as $i => $value) {
                            $images2 .= " " . $filesArray[$i];
                        }

                        $config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                        $CI->load->library('email', $config);
                        $CI->email->set_newline("\r\n");
                        $CI->email->from('dakh@mail.ru');
                        $CI->email->to('dakh@mail.ru');
                        $CI->email->subject('Картинки для суток - редактирование ');
                        $CI->email->message($images2 . " uid=" . $CI->data['user_uid'] . " объявл.=" . $ad_message);
                        $CI->email->send();
                    }


///////////////////////... Если платное, записываем в сутки пендинг  и генерируем еще одну страницу.
// проверка если email пустой, просим заполнить  пункт email 
                    if (strlen($ad_email) < 2) {
                        $this->data['realt'] = 'Вы даёте объявление в рубрику "на сутки". Укажите, пожалуйста адрес электронной почты. На него будет выслана квитанция на оплату. 
<br> Если вы не хотите, чтобы email был виден в объявлении, под строкой поставьте галочку "скрыть email".
<br><a href="javascript:history.back()"> &lt;Вернуться</a>
';
                        return;
                    }


//////// проверяем пользователя
                    if ($CI->input->post('id_user')) {
                        $user = $CI->connect->get_current_user();
                        $username = $user['username'];
                        $id_user = $user['id_user'];
                        $userGroupID = $user['id_group'];
                        $post_id_user = chkString($CI->input->post('id_user'), "SQLString");
                        if ($post_id_user != $id_user) {
                            $this->data['realt'] = "Время ожидания истекло. Войдите еще раз.";
                            return;
                        }

                    } else {
                    }


///////   Это запись в пендинг 

                    $addata = array(
                        ad_catid => $ad_catid,
                        ad_title => $ad_title,
                        ad_message => $ad_message,
                        ad_komnat => $ad_komnat,
                        ad_price => $ad_price,
                        ad_postdate => $ad_postdate,
                        ad_enddate => $ad_enddate,
                        ad_email => $ad_email,
                        ad_contactname => $ad_contactname,
                        ad_phones => $ad_phones,
                        ad_show => $ad_show,
                        ad_ip => $ad_ip,
                        ad_uid => $ad_uid,
                        ad_cref => $ad_cref,
                        ad_hideemail => $ad_hideemail,
                        ad_street => $ad_street,
                        ad_dom => $ad_dom,
                        ad_korpus => $ad_korpus,
                        ad_area => $ad_area,
                        ad_subarea => $ad_subarea,
                        ad_city => $ad_city,
                        ad_url => $ad_url,
                    );

////////// я закоментировал строку ниже. типа картинки можно добавлять			
//if ($act=="post"){  // если doedit то это пропускается 
                    // картинки сохраняем тока ессли это post 

                    $allowEditPictures = 1; //  разрешено ли редактировать картинки

                    if ($allowEditPictures == 1) {
                        $addata['ad_pictures'] = $images;
                        $addata['ad_mainpic'] = $mainpic;
                    }


//}	


                    if ($id_user > 1) { // это от вошедшего пользователя 
                        $addata['ad_client_id'] = $id_user;
                    }


                    $CI->db->insert('realt_sutki_pending', $addata);
                    //echo $this->db->_error_message();
                    //echo $this->db->last_query();
/// всунули, теперь считать ID 

                    $pending_id = $CI->db->insert_id();


//echo ("pending_id= $pending_id");


                    if ($this->data['mlev'] == 4) {
//echo ("<br>5-" . now());
                    }


                    $addata = array(
                        ad_pending_id => $pending_id,
                        ad_postdate => $ad_postdate
                    );

                    //echo ($id_user);		
                    if ($id_user > 1 && getclientData($id_user)) {
                        $addata['client'] = true;
                        $addata['id_user'] = $id_user;
                        $addata['username'] = $username;
                        $clientData = getclientData($id_user);

                         
                        $addata['firmname'] = $clientData['firmname'];
                        $addata['unp'] = $clientData['unp'];
                        $addata['email'] = $ad_email;
                        $addata['client_id'] = $clientData['id'];

 
//echo($clientData['firmname']);
//echo($clientData['unp']);

                    } else {
                        $addata['client'] = false;
//echo("нет данных клиента");

                    }


                    $str_add .= $CI->parser->parse('realt_ad_step2', $addata);
                    if ($this->data['mlev'] == 4) {
//cho ("<br>7-" . now());
                    }
                    $this->data['realt'] = $str_add;


                    return;

                }


///////////////////////////////// конец переадресовки на сутки 

                if ($this->data['mlev'] == 4) {

                    $this->data['debug'] .= chkflood($ad_catid, $ad_message, $ad_uid);


                }


                if (chkflood($ad_catid, $ad_message, $ad_uid)) {
                    $str_add = "Вы уже недавно опубликовали одно похожее объявление. Если хотите повторить еще раз, сделайте это через некоторое время.";
                    $this->data['realt'] = $str_add;
                    return;
                }


                if ($act == "post") {


                    $email_confirm = config_item('realt_email_confirm');


                    if ($this->data['phone_verification'] == 1) { // если  все  верифицируется по телефону


                        $email_confirm = 0;
                        $ad_email = $this->user['email'];
// но если пользователь  старый, не подтвердил email то пусть подтвердит. 
                        if ($this->user['verified'] != 1) {
                            $email_confirm = 1;

                        }


                    }


                    if ($thisPhoneChecked == true) {
                        $ad_phones = $ad_phones . " <small style='color:#5baf3a; font-weight:normal;'>тел. подтвержден.</small>";
                    }


                    if ($this->data['mlev'] == 4) {

//$email_confirm =1;	

                    }

					
					
if ($this->user['id_user']>0){
}
else
{

$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to('dakh2008@mail.ru');
$CI->email->subject('Будет ошибка вставки  пользователь неопределен');
$CI->email->message($this->user  );
$CI->email->send();

 $str_add = "Произошла ошибка. Вероятно вы вышли из системы. Повторите отправку формы!";
 $this->data['realt'] = $str_add;
 return;


}	
					
					
					
					
					
					
					
					

// Сохранение объявления 
// ВСТАВКА В БАЗУ  ads   и сохранение картинок
                    $data = array(
                        ad_catid => $ad_catid,
                        ad_title => $ad_title,
                        ad_message => $ad_message,
                        ad_komnat => $ad_komnat,
                        ad_komnat_min => $ad_komnat_min,
                        ad_komnat_max => $ad_komnat_max,


                        ad_price => $ad_price,
                        ad_price_min => $ad_price_min,
                        ad_price_max => $ad_price_max,
						ad_price_object => $ad_price_object,
                        ad_currency => $ad_currency,
                        ad_default_price => $ad_default_price,
                        ad_default_price_min => $ad_default_price_min,
                        ad_default_price_max => $ad_default_price_max,
                        ad_postdate => $ad_postdate,
                        ad_firstdate => $ad_postdate,
                        ad_enddate => $ad_enddate,
                        ad_email => $ad_email,
                        ad_contactname => $ad_contactname,
                        ad_phones => $ad_phones,
                        ad_show => $ad_show,
                        ad_ip => $ad_ip,
                        ad_uid => $ad_uid,
                        ad_uic => $ad_uic,
                        ad_evc => $ad_evc,
                        ad_cref => $ad_cref,
                        ad_hideemail => $ad_hideemail,
                        ad_street => $ad_street,
                        ad_dom => $ad_dom,
                        ad_korpus => $ad_korpus,
						ad_etazh => $ad_etazh,
						ad_etazhej => $ad_etazhej,
						ad_pl_o => $ad_pl_o,
						ad_pl_z => $ad_pl_z,
						ad_pl_k => $ad_pl_k,
                        ad_area => $ad_area,
                        ad_subarea => $ad_subarea,
                        ad_city => $ad_city,
                        ad_pictures => $images,
                        ad_secretcode => $ad_secretcode,
                        ad_url => $ad_url,
                        ad_showpolitic => $ad_showpolitic,
                        longitude => $longitude,
                        latitude => $latitude,
                        ad_komm_type => $ad_komm_type,
 
                        ad_srok => $ad_srok,
						ad_user => $this->user['id_user']



                    );


                    if ($this->data['mlev'] == 4) {
                        $data['ad_fakefor'] = $ad_for;
                        $data['ad_show'] = 0;
                    }


                    if ($this->data['mlev'] == 4) {
//print_r($data);
                    }
//print_r($data);


                    if ($email_confirm == 1) {
                        $data['ad_show'] = 0;
                        $data['m_confirmed'] = 0;
                        $data['m_confirm_code'] = generate_password(22);
                        $m_confirm_code = $data['m_confirm_code'];
                    }
                    ;


/////////////////// Защта от спама   - проверить чтоб одинаковый текст не слали
                    if ($CI->data['scenery_moderate'] == 1) {
                        $data['ad_show'] = 0;
                        $data['ad_pending'] = 1;
//echo ("!!!!!!!!!!!!на модерации!!!!!!!!!!!!!");
                        $config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                        $CI->load->library('email', $config);
                        $CI->email->set_newline("\r\n");
                        $CI->email->from('dakh@mail.ru');
                        $CI->email->to('dakh@mail.ru');
                        $CI->email->subject('Сценарий - moderate ' . $CI->data['scenery_descriptions']);
                        $CI->email->message('moderate=' . $spwords[$i] . ";  " . $str . "; uid=" . $CI->data['user_uid'] . " " . "http://neagent.by/board/uid/" . $CI->data['user_uid'] . " ссылка для допуска http://neagent.by/realt/ad_approve/");
                        $CI->email->send();
                    }


$CI->db->insert('ads', $data);
$last_id = $CI->db->insert_id();
	


// удажление кэша если был	
$this->db->where('ad_user', $this->user['id_user']);
$this->db->delete('ads_cash');				
 					
					
					
					
					
					
					

//echo ($CI->db->last_query());
//echo ( $CI->db->_error_message());

if (($CI->db->_error_message())){
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to('dakh2008@mail.ru');
$CI->email->subject('Ошибка вставки ');
$CI->email->message($CI->db->_error_message() . " " . $CI->db->last_query());
$CI->email->send();
}

// ВСТАВКА В БАЗУ	
// epyftv ID последней записи
                    
	
					
					
					
					
					
//////// отправка мне письма
if ($ad_catid==1 && $ad_price <350 && $ad_komnat <3){
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to('sergej-minich@yandex.by');
$CI->email->subject('Пришла квартира');
$CI->email->message( " Новая квартира http://neagent.by/wap/snimu/" . $ad_url . " цена "  .  $ad_price . " тел." . $ad_phones . "<br>"  . $ad_message);
$CI->email->send();
///echo(111);
}
else{
///echo(000);
}

					
					
					
					
					
					
					
					
					
					
					
					

                    if ($CI->data['scenery_moderate'] == 1) {
                        $data2 = array(ad_id => $last_id, description => $CI->data['scenery_descriptions']);
                        $CI->db->insert('realt_ad_description', $data2);
                    }


                } else { // act==edit


                    $table = chkString($CI->input->post('ad_tab'), "SQLString");
                    $ad_id = chkString($CI->input->post('ad_id'), "SQLString");


/////////////////
//ПРОВЕРИТЬ, ЕСТЬ ЛИ ПРАВА У ПОЛЬЗОВАТЕЛЯ 
//


                    if ($this->data['mlev'] != 4) {


                        $user = $CI->connect->get_current_user();
                        $current_user_id = $user['id_user'];
                        $CI->db->limit(1);
                        $CI->db->order_by("ad_id", "DESC");
                        $CI->db->where('ad_id', $ad_id);
                        $CI->db->from("sutki");
                        $query = $CI->db->get();
                        if ($query->num_rows() == 0) {
                            echo("Ошибка;");
                            return;
                        } else {
                            foreach ($query->result() as $row) {
                                //	НА САМОМ ДЕЛЕ ТУТ ОДНАСТРОКА, так что пройдет только одна проверка
                                $ad_client = $row->ad_client;
                            }
                        }
                        ;


                        if ($ad_client != $current_user_id && $this->data['mlev'] != 4) {
                            //echo ("- $ad_client - $current_user_id" ); 
                            $this->data['realt'] = 'Недостаточно  прав.<br><a href="javascript:history.back()"> &lt;Вернуться</a>';
                            return;
                        }


                        if ($table != "sutki") {
                            $this->data['realt'] = 'Редактирование недоступно.<br><a href="javascript:history.back()"> &lt;Вернуться</a>';
                            return;
                        }


                    }


//
//END ПРОВЕРИТЬ, ЕСТЬ ЛИ ПРАВА У ПОЛЬЗОВАТЕЛЯ 
////////////////////


// подготовка для update -
                    $data = array(
                        //ad_title		=>	 $ad_title	, 	 	 	 	 	 
                        ad_message => $ad_message,
                        ad_komnat => $ad_komnat,
                        ad_price => $ad_price,
                        ad_email => $ad_email,
                        ad_contactname => $ad_contactname,
                        ad_phones => $ad_phones,
                        //ad_show	=>		$ad_show 	, 	 	 	 	 	 
                        //ad_ip      =>     $ad_ip,
                        ad_uid => $ad_uid,
                        ad_hideemail => $ad_hideemail,
                        ad_street => $ad_street,
                        ad_dom => $ad_dom,
                        ad_korpus => $ad_korpus,
                        ad_currency => $ad_currency,
                        ad_area => $ad_area,
                        ad_subarea => $ad_subarea
                    );

                    if (!is_numeric($ad_currency)) {
                        $ad_currency = 2; // Редактировать. Пока валюта устанавливается в доллары
                    }
//echo ($ad_currency);


                    $data['ad_pictures'] = $images;
                    $data['ad_mainpic'] = $mainpic;


                    if ($table == "sutki") {
                        $ad_sp_mest = chkString($CI->input->post('ad_spmest'), "SQLString");
                        $data['ad_sp_mest'] = $ad_sp_mest;
//unset($data['ad_show']);

                        $ad_price2 = chkString($CI->input->post('ad_price2'), "SQLString");
                        $data['ad_price2'] = $ad_price2;
                        $ad_price3 = chkString($CI->input->post('ad_price3'), "SQLString");
                        $data['ad_price3'] = $ad_price3;
                        $ad_period2 = chkString($CI->input->post('ad_period2'), "SQLString");
                        $data['ad_period2'] = $ad_period2;
                        $ad_period3 = chkString($CI->input->post('ad_period3'), "SQLString");
                        $data['ad_period3'] = $ad_period3;


                    }

                    if ($this->data['mlev'] == 4) {
                        unset($data['ad_uid']);
                    }


                    if ($this->data['mlev'] == 4) {
                        echo("DATA!!!@");
                        print_r($data);

                    }


                    if (($CI->data['scenery_moderate'] == 1) && $table == "ads") {
                        $data['ad_show'] = 0;
                        $data['ad_pending'] = 1;
                        $config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                        $CI->load->library('email', $config);
                        $CI->email->set_newline("\r\n");
                        $CI->email->from('dakh@mail.ru');
                        $CI->email->to('dakh@mail.ru');
                        $CI->email->subject('Сценарий - moderate' . $CI->data['scenery_descriptions']);
                        $CI->email->message('moderate=' . $spwords[$i] . ";  " . $str . "; uid=" . $CI->data['user_uid'] . " " . "http://neagent.by/board/uid/" . $CI->data['user_uid'] . " ссылка для допуска http://neagent.by/realt/ad_approve/");
                        $CI->email->send();
                    }


                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $CI->load->library('email', $config);
                    $CI->email->set_newline("\r\n");
                    $CI->email->from('dakh@mail.ru');
                    $CI->email->to('dakh@mail.ru');
                    $CI->email->subject('Отредактировано объявление' . $ad_id);
                    $CI->email->message('moderate=' . $spwords[$i] . ";  " . $str . "; uid=" . $CI->data['user_uid'] . " " . "http://neagent.by/board/uid/" . $CI->data['user_uid'] . " ссылка для допуска http://neagent.by/realt/ad_approve/");
                    $CI->email->send();


                    $CI->db->where('ad_id', $ad_id);
//$CI->db->like('ad_secretcode', $secretcode);
                    $CI->db->update($table, $data);

                    //echo $CI->db->_error_message();
                    //echo $CI->db->last_query();
                }


                if ($act == "post") {
//отправляем письмо пользователю

                    if (strlen($ad_email) > 3) {
                        $subject_letter = "Ваше объявление на Neagent.by";
                        switch ($ad_catid) {
                            case '2':
                            case '4':
                            case '6':
                            case '8':
                            case '10':
                                $ad_fullurl = "http://neagent.by/snimu/" . $ad_url;
                                break;
                            case '1':
                            case '3':
                            case '5':
                            case '7':
                            case '11':
                                $ad_fullurl = "http://neagent.by/sdayu/" . $ad_url;
                                break;
                            default:
                                $ad_fullurl = "http://neagent.by/sdayu/" . $ad_url;
                        }

                        $letterdata = array(
                            'secret_code' => $ad_secretcode,
                            'ad_moderate' => $data['scenery_moderate'],
                            'ad_url' => $ad_fullurl,
                            'ad_id' => $last_id,
                            'autoup' => config_item('realt_autoupdate')

                        );


                        if ($email_confirm == 1) {
                            $subject_letter = "Пожалуйста, подтвердите ваш email на neagent.by ";
                            $letterdata['m_confirm_code'] = $m_confirm_code;
                            $message = $this->load->view('emails/ad_confirm_email', $letterdata, true);


                        } else {


                            $message = $this->load->view('emails/ad_added_email', $letterdata, true);

                            $messagestr2 = "Вы отправили объявление на Neagent.by. Код объявления: " . $ad_secretcode . " . 
Сохраните этот код, с ним Вы сможете отредактировать или удалить Ваше обьявление. 
Для удаления объявления щелкните на его заголовке, перейдете на его страницу, 
сразу под ним будут ссылки для редактирования и удаления.";

                            if ($CI->data['scenery_moderate'] == 1 && $table == "ads") {
                                $messagestr2 = $messagestr2 . " Ваше объявление появится на сайте после проверки модератором. ";
                            }

                            $messagestr3 = "<br>Код объявления отправлен на ваш email.<br> ";


                        }


                        $config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                        $config['mailtype'] = 'html';
                        $CI->load->library('email', $config);
                        $CI->email->set_newline("\r\n");
                        $CI->email->from('info@neagent.by');
                        $CI->email->to($ad_email);
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


                if ($act == "post") {


                    if ($email_confirm == 1) {
                        $this->data['realt'] = "<b>Ваше объявление ожидает активации.</b> <br>На ваш адрес <b>" . $ad_email . "</b> отправлено письмо с кодом подтверждения. Перейдите по ссылке, указанной в письме, чтобы активировать объявление.";
						
						
						
					if   (strpos($ad_email, 'tut.by') > -1) {
					$this->data['realt'] .= "<br>Вы используете почту tut.by. Если письма нет в папке <b>входящие</b>, проверьте, не попадает ли оно в папку <b>СПАМ</b> <br><img src='http://img1.neagent.by/s/tut_by_spam.jpg'><br>Если это так, нажмите на кнопу 'не спам' или переместите письмо в папку 'входящие'";
					}
						
						
						
						
						
						
                    } else {


                        if (config_item('realt_post_delay') > 0) {
                            $this->data['realt'] = "Ваше объявление опубликовано. Доступно к просмотру оно станет через " . config_item('realt_post_delay') . " минут. " . "Код объявления : " . $ad_secretcode . $messagestr3;
                        } else {
                            $this->data['realt'] = "Ваше объявление опубликовано." . "Код объявления : " . $ad_secretcode . $messagestr3;
                            if ($CI->data['scenery_moderate'] == 1) {
                                $this->data['realt'] = "Ваше объявление  появится на сайте после проверки модератором. Это может занять от получаса до трех часов. " . "Код объявления : " . $ad_secretcode . $messagestr3;
                            }
                        }

                    }

                    $logstr = "адрес объявления = " . $ad_fullurl;
                    $logstr .= "email юзера = " . $ad_email;

                    saveLog('dobavlenie_objavlenij', 'Конец Пользователь разместил объявление.  ' . $logstr);


                } else // Если это редактирование
                {

                    $this->data['realt'] = "Ваше объявление изменено. <br><a href='javascript:history.go(-2)'> &lt;Вернуться</a>";
                    if ($CI->data['scenery_moderate'] == 1 && $table == "ads") {
                        $this->data['realt'] = "Оно появится на сайте после проверки модератором. Это может занять от получаса  до трех часов. ";
                    }

                }


                break;
            case 'edit':
////////////////////////////форма редактирования объявления////////////////////////////////////////////////////////////////////////////////////////////////////

                $page = $CI->uri->segment(2) . $CI->uri->segment(4);

                $adnumber = $CI->uri->segment(4);
//echo $adnumber;

//$adnumber = intval($adnumber)?intval($adnumber):-1;


                if (!ctype_digit($adnumber) || strlen($adnumber) < 4) {
                    $this->data['realt'] = 'Ошибка..';
                    break;
                }


                switch (substr($adnumber, 0, 3)) {
                    case '100':
                        $table = "ads";
                        break;
                    case '200':
                        $table = "sutki";
                        break;
                }

                if ($table == "") {
                    $this->data['realt'] = 'Ошибка.';
                    break;
                }
                $ad_id = substr($adnumber, 3);


                $CI->db->select('*');
                $CI->db->where('ad_id', "" . $ad_id . "");
                //$CI->db->where ('ad_show', "1");
                $CI->db->limit(1);
                $CI->db->from($table);


                $query = $CI->db->get();
                if ($query->num_rows() == 0) {
                    $this->data['realt'] = 'Не найдено объявление.';
                    break;
                } else {

                    foreach ($query->result() as $row) {


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
                                    'ad_hideemail' => $row->ad_hideemail,
                                    'ad_catid' => $row->ad_catid,
                                    'ad_comments_count' => $row->ad_comments_count
                                );

                                if (strlen($addata['ad_pictures']) > 1) {
                                    $ad_pictures = explode("; ", $addata['ad_pictures']);
                                    $addata['ad_pictures'] = $ad_pictures;
                                    $addata['ad_thumbs'] = $ad_pictures;
                                    $addata['pic_folder'] = "http://neagent.by/modules/Realt/files/";
                                    $addata['ad_mainpic'] = "http://neagent.by/modules/Realt/files/" . "t_" . $ad_pictures[0];
                                } else {
                                    $addata['ad_pictures'] = array();
                                    $addata['ad_mainpic'] = "http://neagent.by/themes/neagent_style/assets/images/kvartira.gif";
                                }


                                $sstr = "";
                                for ($k = 0; $k < count($this->data['cityuriArr']); $k++) {
                                    $sstr .= "<OPTION value=" . $this->data['cityidArr'][$k] . " >" . $this->data['citynameArr'][$k] . "</OPTION>";
                                }

                                $cstr = "";
                                for ($k = 0; $k < count($this->data['realt_cats']); $k++) {
                                    $cid = $this->data['realt_cats'][$k]['id'];
//echo ("Выбранный сat=" . $cid);
                                    for ($h = 0; $h < count($this->data['realt_subcats']); $h++) {
                                        if ($this->data['realt_subcats'][$h]['parent'] == $cid) {
                                            $cstr .= "<OPTION value=" . $this->data['realt_subcats'][$h]['id'] . " >" . $this->data['realt_cats'][$k]['name'] . " » " . $this->data['realt_subcats'][$h]['name'] . "</OPTION>";
                                        }
                                    }
                                }


                                $addata['cityes'] = $sstr;
                                $addata['cats'] = $cstr;


                                $str_add .= "<h1>Редактирование объявления</h1>";
                                $str_add .= $CI->parser->parse($this->data['adform_view'], $addata);
                                $this->data['realt'] = $str_add;

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


                                if ($addata['ad_client'] != $user['id_user']) { //$addata['ad_client']   - это user id

                                    $str_add .= "---------------";
//$str_add .= "Вы должны войти под своим паролем в панель пользователя, чтобы редактировать объявление. Перейдите на страницу <a href='http://neagent.by/client'> http://neagent.by/client</a>";
//$this->data['realt']=$str_add;

//return; 
                                }


                                if (!is_numeric($ad_currency)) {
                                    $ad_currency = 2; // Редактировать. Пока валюта устанавливается в доллары
                                }
                                $addata['ad_currency'] = $ad_currency;


                                if (strlen($addata['ad_pictures']) > 1) {
                                    $ad_pictures = explode("; ", $addata['ad_pictures']);
                                    $addata['ad_pictures'] = $ad_pictures;
                                    $addata['ad_thumbs'] = $ad_pictures;


//echo ($ad_pictures[0]);
                                    $addata['pic_folder'] = "http://neagent.by/modules/Realt/files/";
                                    $addata['ad_mainpic'] = "http://neagent.by/modules/Realt/files/" . "" . $ad_pictures[0];


                                } else {
                                    $addata['ad_pictures'] = array();


                                    $addata['ad_mainpic'] = "http://neagent.by/themes/neagent_style/assets/images/kvartira.gif";


                                }


                                $sstr = "";

                                for ($k = 0; $k < count($this->data['cityuriArr']); $k++) {
                                    $sstr .= "<OPTION value=" . $this->data['cityidArr'][$k] . " >" . $this->data['citynameArr'][$k] . "</OPTION>";
                                }

                                $cstr = "";
                                for ($k = 0; $k < count($this->data['realt_cats']); $k++) {
                                    $cid = $this->data['realt_cats'][$k]['id'];
//echo ("Выбранный сat=" . $cid);
                                    for ($h = 0; $h < count($this->data['realt_subcats']); $h++) {
                                        if ($this->data['realt_subcats'][$h]['parent'] == $cid) {
                                            $cstr .= "<OPTION value=" . $this->data['realt_subcats'][$h]['id'] . " >" . $this->data['realt_cats'][$k]['name'] . " » " . $this->data['realt_subcats'][$h]['name'] . "</OPTION>";
                                        }
                                    }
                                }


                                $addata['cityes'] = $sstr;
                                $addata['cats'] = $cstr;


                                $str_add .= "<h1>Редактирование объявления</h1>";
                                $str_add .= $CI->parser->parse($this->data['adform_view'], $addata);
                                $this->data['realt'] = $str_add;

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


                $ad_street = chkString($CI->input->post('street'), "SQLString");


                $this->data['realt'] = 'Редактирование объявления недоступно.';
                break;


            case 'check': //act = "check"   - для  шага 2 это уже проверка данных и запись пользователя в базу для суток 


                $pend_id = (int)$CI->input->post('pend_id');
                if ($pend_id == 0) {
                    $errstr .= "Произошла ошибка";
                    return;
                }
                $ad_postdate = chkString($CI->input->post('ad_postdate'), "SQLString");
                $firmname = chkString($CI->input->post('firmname'), "SQLString");
                $unp = chkString($CI->input->post('unp'), "SQLString");
                $juraddress = chkString($CI->input->post('juraddress'), "SQLString");
                $postaddress = chkString($CI->input->post('postaddress'), "SQLString");
                $sposob = chkString($CI->input->post('sposob'), "SQLString");
                $account = chkString($CI->input->post('account'), "SQLString");
                $bank = chkString($CI->input->post('bank'), "SQLString");
                $kod = chkString($CI->input->post('kod'), "SQLString");
                $srok = chkString($CI->input->post('srok'), "SQLString");
                $phone = chkString($CI->input->post('phone'), "SQLString");
                $email = chkString($CI->input->post('email'), "SQLString");
                $postdate = date("Y-m-d H:i:s");


                if ($this->data['mlev'] == 4) {
//echo(32434234234);
//print_r($user);
                }

                $email = "";


// вставляем в базу 

                $data = array(

                    firmname => $firmname,
                    unp => $unp,
                    juraddress => $juraddress,
                    postaddress => $postaddress,

                    account => $account,
                    bank => $bank,
                    kod => $kod,
                    email => $this->user['email'],
                    phone => $phone,
                    postdate => $postdate,
                    status => 1
                );

                if ($this->data['mlev'] == 4) {
//echo('dat45');
//print_r($this->user['email']);

                }

                $CI->db->insert('fin_clients', $data);


///echo $CI->db->_error_message();
//echo $CI->db->last_query();


/// получить client_id
                $client_id = $CI->db->insert_id();


                $client_id = (int)$client_id;
                if ($client_id == 0) {
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

                if ($query->num_rows() == 0) {
                    //$result =  false;
                    $pending_id = -1;
                } else {

                    foreach ($query->result() as $row) {
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
                        $pending_id = $row->ad_id;

                    }
                    //$result = $query->row_array();
                }
                ;


                if ($data['ad_catid'] == 11) {
                    $data['ad_catid'] = "Квартиры на сутки";
                }
                ;
                if ($data['ad_catid'] == 12) {
                    $data['ad_catid'] = "Дома, коттеджи на сутки";
                }
                ;

                $data['client_id'] = $client_id;
                $data['pend_id'] = $pending_id;
                $data['firmname'] = $firmname;
                $data['unp'] = $unp;
                $data['juraddress'] = $juraddress;
                $data['postaddress'] = $postaddress;
                $data['sposob'] = $sposob;
                $data['account'] = $account;
                $data['bank'] = $bank;
                $data['kod'] = $kod;
                $data['srok'] = $srok;
                $data['phone'] = $phone;
                $data['postdate'] = $postdate;


//$str_add .= $CI->parser->parse('realt_ad', $addata);
                $str_add .= $CI->parser->parse('realt_ad_step3', $data);
                $this->data['realt'] = $str_add;
                return;


                break;


            case 'invoice': //act = "invoice"   -  создаёт счет 


//////// проверяем пользователя


                if ($CI->input->post('id_user')) {
                    $user = $CI->connect->get_current_user();
                    $username = $user['username'];
                    $id_user = $user['id_user'];
                    $userGroupID = $user['id_group'];
                    $post_id_user = chkString($CI->input->post('id_user'), "SQLString");
                    if ($post_id_user != $id_user) {
                        $this->data['realt'] = "Время ожидания истекло. Войдите еще раз.";
                        return;
                    }

                }

                if ($id_user > 0) {
///// Если зарегистрированный пользователь добавляет объявление, то его сразу допускаем в sutki


                }


//echo "ttytty";
                $pend_id = (int)$CI->input->post('pend_id');
                if ($pend_id == 0) {
                    $str_add = "произошла ошибка 1. Если она будет повторяться, сообщите о ней администратору сайта. info@neagent.by";
                    $this->data['realt'] = $str_add;
                    $errstr .= "Произошла ошибка";
                    return;
                }
                $client_id = (int)$CI->input->post('client_id');
//echo ("cid=" . $client_id . ";");


                if ($client_id == 0) {
                    $str_add = "произошла ошибка 2. Если она будет повторяться, сообщите о ней администратору сайта. info@neagent.by ";


                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $CI->load->library('email', $config);
                    $CI->email->set_newline("\r\n");
                    $CI->email->from('info@neagent.by');
                    $CI->email->to('info@neagent.by');
                    $CI->email->subject('ошибка 2');
                    $CI->email->message($pend_id);
                    $CI->email->send();


                    $this->data['realt'] = $str_add;
                    $errstr .= "Произошла ошибка";
                    return;
                }


                $srok = chkString($CI->input->post('srok'), "SQLString");
                if ($srok == 0) {
                    $str_add = "произошла ошибка 3. Если она будет повторяться, сообщите о ней администратору сайта.";
                    $this->data['realt'] = $str_add;
                    $errstr .= "Произошла ошибка";
                    return;
                }

//echo ("4");	
                $CI->db->limit(1);
                $CI->db->order_by("ad_id", "DESC");
                $CI->db->where('ad_id', $pend_id);
                $CI->db->from("realt_sutki_pending");
                $query = $CI->db->get();
                if ($query->num_rows() == 0) {
                    //$result =  false;
                    $pending_id = -1;
                } else {

                    foreach ($query->result() as $row) {
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
                }
                ;


                /////echo ("5");		

                $CI->db->limit(1);
                $CI->db->order_by("id", "DESC");
                $CI->db->where('id', $client_id);
                $CI->db->from("fin_clients");
                $query = $CI->db->get();
                if ($query->num_rows() == 0) {
                    //$result =  false;
                    $pending_id = -1;
                } else {

                    foreach ($query->result() as $row) {
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
                }
                ;


//echo ($CI->db->last_query());	
                //echo ($clientdata['id']);
                //print_r ($clientdata);
                $message = "";

                if ($id_user > 0) {
                    $message .= "Заказ от старого клиента \r\n";
                }

                $message .= "pend_id=$pend_id \r\n";
                $message .= "client_id = " . $client_id . "\r\n";
                $message .= "firmname = " . $clientdata['firmname'] . "\r\n";


                $message .= "srok=$srok \r\n";


                ////////////////////// в таблицу заказы

                $data = array(
                    client_id => $client_id,
                    sutki_ad_id => $pend_id,
                    user_id => $juraddress,
                    status => 1,
                    srok => $srok
                );

                if ($this->data['mlev'] == 4) {
                    echo('data767');
                    print_r($data);


                }
                $CI->db->insert('fin_zakazy', $data);


                //////////////////////////////


                $clientmessage = "Вы заказали размещение объявления на neagent.by. \r\n
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
                $CI->email->to(config_item('realt_email2'));
                $CI->email->subject('Заказ на Neagent.by');
                $CI->email->message($message);


                $CI->email->send();


//$str_add .= $CI->parser->parse('realt_ad', $addata);
                $str_add .= $CI->parser->parse('realt_ad_step4', $data);
                $this->data['realt'] = $str_add;
                return;


                break;
            default:


                saveLog('dobavlenie_objavlenij', 'НАЧАЛО Пользователь зашел на страницу. Показываем форму');


//echo(98989); 
 
// конец кукисы


                $addata['tt'] = "jj"; // это чтоб пустой параметр не передавать 
//$str_add .=$CI->parser->parse('realt_add_form', $addata);
//$str_add .= file_get_contents(MODPATH.'Realt/views/realt_add_form'.EXT); // берем просто готовую форму


                $addata = array(
                    'ad_id' => "-",
                    'ad_postdate' => "000",
                    'ad_price' => "333",
                    'ad_mlev' => 0,
                    'mlev' => 0
                );

                if ($CI->data['mlev'] == 4) {
//print_r($addata);
//echo('data7987');
                }

                $addata['mlev'] = $this->data['mlev'];


                $user = $CI->connect->get_current_user();
                $username = $user['username'];
                $id_user = $user['id_user'];
                $userGroupID = $user['id_group'];

                if ($id_user > 1) {
                    $addata['id_user'] = $id_user;
                    $addata['username'] = $username;
                    $addata['userGroupID'] = $userGroupID;
                }
                $addata['evc'] = isset($_COOKIE["evc"])? $_COOKIE["evc"]:"";


//////////////


                $sstr = "";

                for ($k = 0; $k < count($this->data['cityuriArr']); $k++) {
                    $sstr .= "<OPTION value=" . $this->data['cityidArr'][$k] . " >" . $this->data['citynameArr'][$k] . "</OPTION>";
                }

                $cstr = "";
                for ($k = 0; $k < count($this->data['realt_cats']); $k++) {
                    $cid = $this->data['realt_cats'][$k]['id'];
//echo ("Выбранный сat=" . $cid);
                    for ($h = 0; $h < count($this->data['realt_subcats']); $h++) {
                        if ($this->data['realt_subcats'][$h]['parent'] == $cid) {
                            $cstr .= "<OPTION value=" . $this->data['realt_subcats'][$h]['id'] . " >" . $this->data['realt_cats'][$k]['name'] . " » " . $this->data['realt_subcats'][$h]['name'] . "</OPTION>";
                        }
                    }
                }


                $addata['cityes'] = $sstr;
                $addata['cats'] = $cstr;

//////////////////


//echo( "00-". $this->data['adform_view']);

                $addata['phone_verification'] = $this->data['phone_verification'];


if ($this->data['phone_verification'] == 1) {
// если пользователь зарегистрирован и email подтвержден, то 
//если нет  -предупреждение
//print_r($user);

                    if ($user['id_user'] > 0) { // Если зарегистрирован
                        $addata['id_user'] = $user['id_user'];
						$addata['username'] =   $user['username'];
                        $addata['useremail'] = $user['email'];
                        $addata['verification_cats'] = config_item('realt_phone_verification_cats');
						
						
					//$CI->load->model('realt_ad_model' ,'ad');
					$ad = $CI->ad;
					//$ad->setdataArr($addata);
					$ad->set_table('ads_cash');
					$ad->fields['ad_user']=1;
					$cashdata = $ad->search();
					if ($cashdata){
					$cashdata2 = (array)$cashdata[0];
					$addata = array_merge($addata, $cashdata2);
					$addata['cash']=true;
					 }
					//print_r($result);
					
					//$ad->save($ad->fields);
						
						
						
						
						
						// первый показ формы
                        $str_add .= $CI->parser->parse($this->data['adform_view'], $addata);
                        if ($CI->data['mlev'] == 4) {
//echo('data++3');
                        }

                    } else {  // Если не зарегистрирован

                        $addata['redirect'] = $user['ad-form'];
                        if ($this->data['wap_view'] != 1) {
                            $str_add .= $CI->parser->parse('realt_register_form', $addata);
                        } else {
                            $str_add .= $CI->parser->parse('wap_realt_register_form', $addata);
                        }
						
						
						if (!isset($_COOKIE["uid"])){
					 $str_add .="<br>У вас отключены кукисы. ";
					   }


                    }


                } else {

//echo($this->data['$adform_view']);

                    $str_add .= $CI->parser->parse($this->data['adform_view'], $addata);

                }


                $this->data['realt'] = $str_add;

        }


    }


    function addAd()
    {

        $CI =& get_instance();
//$date=$CI->load->helper('date');
//$now=$date->now()
        $now = time();
        //$CI->load->database();
        $post_cat = chkString($CI->input->post('cat'), "SQLString");
        $post_price = chkString($CI->input->post('price'), "SQLString");
        $post_komnat = chkString($CI->input->post('komnat'), "SQLString");
        $post_message = chkString($CI->input->post('content'), "SQLString");
        $post_title = chkString($CI->input->post('title'), "SQLString");
        $post_phones = chkString($CI->input->post('phones'), "SQLString");
        $post_name = chkString($CI->input->post('ad_name'), "SQLString");
        $post_email = chkString($CI->input->post('ad_email'), "SQLString");
        $post_hideemail = chkString($CI->input->post('hideemail'), "SQLString");
        $post_title = 'Автозаголовок';

        $data = array(
            'ad_message' => $post_message,
            'ad_komnat' => $post_komnat,
            'ad_price' => $post_price,
            'ad_catid' => $post_cat,
            'ad_title' => $post_title,
            'ad_postdate' => $now,
            'ad_enddate' => '',
            'ad_email' => $post_email,
            'ad_contactname' => $post_name,
            'ad_phones' => $post_phones,
            'ad_show' => '1',
//'ad_fakefor' => '',
//'ad_ip' => '',
        );

//echo("$$$$$$$$$$$$_______________");
//print_r ($CI->data);

        if ($CI->data['scenery_moderate'] == 1) {

            $data['ad_pending'] = 1;
            $data['ad_show'] = 0;

//echo ("!!!!!!!!!!!!на модерации!!!!!!!!!!!!!");
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $CI->load->library('email', $config);
            $CI->email->set_newline("\r\n");
            $CI->email->from(config_item('realt_email'));
            $CI->email->to(config_item('realt_email2'));
            $CI->email->subject('Сценарий - moderate' . $CI->data['scenery_descriptions']);
            $CI->email->message('moderate=' . $spwords[$i] . ";  " . $str . "; uid=" . $CI->data['user_uid'] . " " . "http://neagent.by/board/uid/" . $CI->data['user_uid']);
            $CI->email->send();


        }


        $CI->db->insert('ads', $data);

//echo $sql;		


        // $sql = 'INSERT INTO ads(ad_message, ad_komnat, ad_price) VALUES ("'.$post_message.'", '.$post_komnat.', '.$post_price.')';
        //$bindings = array ($listing['id'], $CI->tank_auth->get_user_id(), set_value('feedback'));

        //$CI->db->query($sql, $bindings);
        //return 3;
        return;
    }


    //function Guestbook_model()
    //{


    //}

    function debug4($param)
    {
        if ($this->data['mlev'] == 4) {
//echo($param);
        }
        return 0;
    }


    function get($params = array())
    {
        $default_params = array
        (
            'order_by' => 'id DESC',
            'limit' => 1,
            'start' => null,
            'where' => null,
            'like' => null,
        );

        foreach ($default_params as $key => $value) {
            $params[$key] = (isset($params[$key])) ? $params[$key] : $default_params[$key];
        }
        $hash = md5(serialize($params));
        if (!$result = $this->cache->get('get' . $hash, $this->table)) {
            if (!is_null($params['like'])) {
                $this->db->like($params['like']);
            }
            if (!is_null($params['where'])) {
                $this->db->where($params['where']);
            }
            $this->db->order_by($params['order_by']);
            $this->db->limit(1);
            //$this->db->select('');
            $this->db->from($this->table);

            $query = $this->db->get();

            if ($query->num_rows() == 0) {
                $result = false;
            } else {
                $result = $query->row_array();
            }

            $this->cache->save('get' . $hash, $result, $this->table, 0);
        }

        //return $result;
        return;


    }

    function get_list($params = array())
    {
        $default_params = array
        (
            'order_by' => 'id DESC',
            'limit' => null,
            'start' => null,
            'where' => null,
            'like' => null,
        );

        foreach ($default_params as $key => $value) {

            $params[$key] = (isset($params[$key])) ? $params[$key] : $default_params[$key];

        }
        $hash = md5(serialize($params));

        //echo ($hash);
        //if(!$result = $this->cache->get('get_list' . $hash, $this->table))
        //{
        if (!is_null($params['like'])) {
            $this->db->like($params['like']);
        }
        if (!is_null($params['where'])) {
            $this->db->where($params['where']);
        }
        $this->db->order_by($params['order_by']);
        $this->db->limit($params['limit'], $params['start']);
        $this->db->select('');
        $this->db->from($this->table);

        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            $result = false;
        } else {
            $result = $query->result_array();
        }

        // $this->cache->save('get_list' . $hash, $result, $this->table, 0);
        // }


        //return $result;
        return;

    }

    function get_total($params = array())
    {
        $default_params = array
        (
            'order_by' => 'id DESC',
            'limit' => null,
            'start' => null,
            'where' => null,
            'like' => null,
        );

        foreach ($default_params as $key => $value) {
            $params[$key] = (isset($params[$key])) ? $params[$key] : $default_params[$key];
        }
        $hash = md5(serialize($params));
        //	if(!$result = $this->cache->get('get_total' . $hash, $this->table))
        //{
        if (!is_null($params['like'])) {
            $this->db->like($params['like']);
        }
        if (!is_null($params['where'])) {
            $this->db->where($params['where']);
        }
        $this->db->order_by($params['order_by']);

        $this->db->select('count(id) as cnt');
        $this->db->from($this->table);

        $query = $this->db->get();

        $row = $query->row_array();

        $result = $row['cnt'];

        //$this->cache->save('get_total' . $hash, $result, $this->table, 0);
        //}

        return $result;

    }

    function delete($params = array())
    {
        $this->db->where($params['where']);
        $this->db->delete($this->table);
        $this->cache->remove_group($this->table);
    }

    function save($data = array())
    {
        $this->db->set($data);

        //$this->cache->remove_group($this->table);
        return $this->db->insert($this->table);
    }

    function update($where = array(), $data = array(), $escape = true)
    {
        $this->db->where($where);
        $this->db->set($data, null, $escape);
        $this->db->update($this->table);
        $this->cache->remove_group($this->table);
    }

    function get_params($id)
    {
        if ($params = $this->cache->get($id, 'search_' . $this->table)) {
            return $params;
        } else {
            return false;
        }
    }

    function save_params($params)
    {
        $id = md5($params);
        if ($this->cache->get($id, 'search_' . $this->table)) {
            return $id;
        } else {

            $this->cache->save($id, $params, 'search_' . $this->table, 0);
            return $id;
        }
    }

    function get_settings()
    {


        $query = $this->db->get('guestbook_settings');
        // пусто выдало
        //echo  ($query);
        // echo  ("query");
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                //echo  ($row->value );
                $this->settings[$row->name] = $row->value;
            }
        }

    }


    function save_settings($name, $value)
    {
        //update only if changed
        if (!isset($this->settings[$name])) {
            $this->settings[$name] = $value;
            $this->db->insert('guestbook_settings', array('name' => $name, 'value' => $value));
        } elseif ($this->settings->$name != $value) {
            $this->settings->$name = $value;
            $this->db->update('guestbook_settings', array('value' => $value), "name = '$name'");
        }
    }


    function saveClientInfoToLog()
    {

        //$conf .= "\$config['".$key."'] = '".$val."';\n";

        $CI =& get_instance();


        $uid = $_COOKIE["uid"];
        $uic = $_COOKIE["uic"];
        $useragent = $_SERVER['HTTP_USER_AGENT'];

//if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	
//parse_str($_SERVER['QUERY_STRING'], $_GET);

        $page = $_SERVER['QUERY_STRING'];
        $page = $CI->uri->uri_string() . "/" . $page;

        //$page=$CI->uri->segment(2). $CI->uri->segment(3);


        $pagetitle = "";
        $conf = date("Y-m-d H:i:s", time()) . "; uid=" . $uid . "; uic=" . $uic . "; IP=" . $_SERVER["REMOTE_ADDR"] . "; useragent=" . $useragent . "; page=" . $page;


        $this->load->helper('file');

        $string = read_file($this->config->item('module_path') . 'Realt/config/log.txt');
        $string .= "\n" . $conf;


        if (!write_file($this->config->item('module_path') . 'Realt/config/log.txt', $string)) {
            //echo "-saved";
        }


    }


    function getUserStatus()
    {
        $CI =& get_instance();

		
		 $status = "allowed";  //// добавлено для уменьшения базы
            return $status;  //// добавлено для уменьшения базы
		
		
        if ($this->user['id_group'] == 16) {
//echo ("allowed");
            $status = "allowed";
            return $status;
        }


        $ip = $_SERVER["REMOTE_ADDR"];
        $uid = $CI->data['user_uid'];

        $CI->db->where('ad_uid', $uid);
        $CI->db->where('ad_show', '1');

        $rubrics = array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15);
        $CI->db->where_in('ad_catid', $rubrics);


        $CI->db->from('ads');
        $co = $CI->db->count_all_results();

        if ($co > 0) {
            $exist = 1;
            $status = "active";
        } else {

            $CI->db->where('uid', $uid);
            $CI->db->from('realt_rights');
            $co = $CI->db->count_all_results();

            if ($co > 0) {
                $exist = 1;
                $status = "allowed";
            } else {
                $status = "0";
                $exist = 0;
            }


        }


        return $status;


    }


}

///// КОНЕЦ КЛАССА


function ChkString($fString, $fField_Type)
{ //## Types - name, password, title, message, url, urlpath, email, number, list
    $fString = rtrim(trim($fString));
    if ($fString == "") {
        $fString = " ";
    }
    ;


    if ($fField_Type == "SQLString") {

        $fString = str_replace("'", "''", $fString);
        $fString = str_replace("", "", $fString);
        //$fString = str_replace( "\", "\\", $fString);
        //$path=str_replace('\"',"\\",$path);			
        $fString = HTMLEncode($fString);

        return $fString;
    }


    //if fField_Type = "JSurlpath" then
    //	fString = Replace(fString, "'", "\'")
    ////	fString = Server.URLEncode(fString)
    //	ChkString = fString
    //	exit function
    //end if
    //if fField_Type = "edit" then		
    //	if strAllowHTML <> "1" then			
    //		fString = HTMLEncode(fString)		
    //	end if		
    //	fString = Replace(fString, """", "&quot;")
    //	ChkString = fString		
    //	exit function	
    //end if
    //if fField_Type = "display" then
    //	if strAllowHTML <> "1" then
    //		fString = HTMLEncode(fString)
    //	end if
    //	if strBadWordFilter = "1" then
    //		fString = chkBadWords(fString)
    //	end if
    //	fString = replace(fString,"+","&#043;")
    //	fString = replace(fString, """", "&quot;")
    //    	ChkString = fString
    //	exit function
    //elseif fField_Type = "message" then
    //		if strAllowHTML <> "1" then
    //			fString = HTMLEncode(fString)
    //		end if
    //elseif fField_Type = "hidden" then
    //	fString = HTMLEncode(fString)
    ////end if
    //if fField_Type = "displayimage" then
    //	fString = Replace(fString, " ", "")
    //	fString = Replace(fString, """", "")
    //	fString = Replace(fString, "<", "")
    //	fString = Replace(fString, ">", "")
    //	chkString = fString
    //exit function
    //end if
    //
    //if strAllowForumCode = "1" and fField_Type <> "signature" then
    //	fString = doCode(fString, "[marquee]", "[/marquee]", "<marquee>", "</marquee>")
    //	fString = doCode(fString, "[sup]", "[/sup]", "<sup>", "</sup>")
    //	fString = doCode(fString, "[sub]", "[/sub]", "<sub>", "</sub>")
    //	fString = doCode(fString, "[tt]", "[/tt]", "<tt>", "</tt>")
    //	fString = doCode(fString, "[hl]", "[/hl]", "<span style='background-color: #FFFF00'>", "<b></b></span>")
    //	fString = doCode(fString, "[pre]", "[/pre]", "<pre><font size=" & strDefaultFontSize & " face=""" & strDefaultFontFace & """>", "</font></pre>")
    //	fString = replace(fString, "[hr]", "<hr>", 1, -1, 1)
    //	fString = doCode(fString, "[b]", "[/b]", "<b>", "</b>")
    //	fString = doCode(fString, "[s]", "[/s]", "<s>", "</s>")
    //	fString = doCode(fString, "[strike]", "[/strike]", "<s>", "</s>")
    //	fString = doCode(fString, "[u]", "[/u]", "<u>", "</u>")
    //	fString = doCode(fString, "[i]", "[/i]", "<i>", "</i>")
    //	if fField_Type <> "title" then
    //		fString = doCode(fString, "[font=Andale Mono]", "[/font=Andale Mono]", "<font face='Andale Mono'>", "</font id='Andale Mono'>")
    //		fString = doCode(fString, "[font=Arial]", "[/font=Arial]", "<font face='Arial'>", "</font id='Arial'>")
    //		fString = doCode(fString, "[font=Arial Black]", "[/font=Arial Black]", "<font face='Arial Black'>", "</font id='Arial Black'>")
    //		fString = doCode(fString, "[font=Book Antiqua]", "[/font=Book Antiqua]", "<font face='Book Antiqua'>", "</font id='Book Antiqua'>")
    //		fString = doCode(fString, "[font=Century Gothic]", "[/font=Century Gothic]", "<font face='Century Gothic'>", "</font id='Century Gothic'>")
    //		fString = doCode(fString, "[font=Courier New]", "[/font=Courier New]", "<font face='Courier New'>", "</font id='Courier New'>")
    //		fString = doCode(fString, "[font=Comic Sans MS]", "[/font=Comic Sans MS]", "<font face='Comic Sans MS'>", "</font id='Comic Sans MS'>")
    //		fString = doCode(fString, "[font=Georgia]", "[/font=Georgia]", "<font face='Georgia'>", "</font id='Georgia'>")
    //		fString = doCode(fString, "[font=Impact]", "[/font=Impact]", "<font face='Impact'>", "</font id='Impact'>")
    //		fString = doCode(fString, "[font=Tahoma]", "[/font=Tahoma]", "<font face='Tahoma'>", "</font id='Tahoma'>")
    //		fString = doCode(fString, "[font=Times New Roman]", "[/font=Times New Roman]", "<font face='Times New Roman'>", "</font id='Times New Roman'>")
    //		fString = doCode(fString, "[font=Trebuchet MS]", "[/font=Trebuchet MS]", "<font face='Trebuchet MS'>", "</font id='Trebuchet MS'>")
    //		fString = doCode(fString, "[font=Script MT Bold]", "[/font=Script MT Bold]", "<font face='Script MT Bold'>", "</font id='Script MT Bold'>")
    //		fString = doCode(fString, "[font=Stencil]", "[/font=Stencil]", "<font face='Stencil'>", "</font id='Stencil'>")
    //		fString = doCode(fString, "[font=Verdana]", "[/font=Verdana]", "<font face='Verdana'>", "</font id='Verdana'>")
    //		fString = doCode(fString, "[font=Lucida Console]", "[/font=Lucida Console]", "<font face='Lucida Console'>", "</font id='Lucida Console'>")

    //		fString = doCode(fString, "[red]", "[/red]", "<font color=red>", "</font id=red>")
    //		fString = doCode(fString, "[green]", "[/green]", "<font color=green>", "</font id=green>")
    //		fString = doCode(fString, "[blue]", "[/blue]", "<font color=blue>", "</font id=blue>")
    //		fString = doCode(fString, "[white]", "[/white]", "<font color=white>", "</font id=white>")
    //		fString = doCode(fString, "[purple]", "[/purple]", "<font color=purple>", "</font id=purple>")
    //		fString = doCode(fString, "[yellow]", "[/yellow]", "<font color=yellow>", "</font id=yellow>")
    //		fString = doCode(fString, "[violet]", "[/violet]", "<font color=violet>", "</font id=violet>")
    //		fString = doCode(fString, "[brown]", "[/brown]", "<font color=brown>", "</font id=brown>")
    //		fString = doCode(fString, "[black]", "[/black]", "<font color=black>", "</font id=black>")
    //		fString = doCode(fString, "[pink]", "[/pink]", "<font color=pink>", "</font id=pink>")
    //		fString = doCode(fString, "[orange]", "[/orange]", "<font color=orange>", "</font id=orange>")
    //		fString = doCode(fString, "[gold]", "[/gold]", "<font color=gold>", "</font id=gold>")
//
    //		fString = doCode(fString, "[beige]", "[/beige]", "<font color=beige>", "</font id=beige>")
    //		fString = doCode(fString, "[teal]", "[/teal]", "<font color=teal>", "</font id=teal>")
    //		fString = doCode(fString, "[navy]", "[/navy]", "<font color=navy>", "</font id=navy>")
    //		fString = doCode(fString, "[maroon]", "[/maroon]", "<font color=maroon>", "</font id=maroon>")
    //		fString = doCode(fString, "[limegreen]", "[/limegreen]", "<font color=limegreen>", "</font id=limegreen>")
//
    //		fString = doCode(fString, "[h1]", "[/h1]", "<h1>", "</h1>")
    //		fString = doCode(fString, "[h2]", "[/h2]", "<h2>", "</h2>")
    //		fString = doCode(fString, "[h3]", "[/h3]", "<h3>", "</h3>")
    //		fString = doCode(fString, "[h4]", "[/h4]", "<h4>", "</h4>")
    //		fString = doCode(fString, "[h5]", "[/h5]", "<h5>", "</h5>")
    //		fString = doCode(fString, "[h6]", "[/h6]", "<h6>", "</h6>")
    //		fString = doCode(fString, "[size=1]", "[/size=1]", "<font size=1>", "</font id=size1>")
    //		fString = doCode(fString, "[size=2]", "[/size=2]", "<font size=2>", "</font id=size2>")
    //		fString = doCode(fString, "[size=3]", "[/size=3]", "<font size=3>", "</font id=size3>")
    //		fString = doCode(fString, "[size=4]", "[/size=4]", "<font size=4>", "</font id=size4>")
    //		fString = doCode(fString, "[size=5]", "[/size=5]", "<font size=5>", "</font id=size5>")
    //		fString = doCode(fString, "[size=6]", "[/size=6]", "<font size=6>", "</font id=size6>")
    //		fString = doCode(fString, "[list]", "[/list]", "<ul>", "</ul>")
    //		fString = doCode(fString, "[list=1]", "[/list=1]", "<ol type=1>", "</ol id=1>")
    //		fString = doCode(fString, "[list=a]", "[/list=a]", "<ol type=a>", "</ol id=a>")
    //		fString = doCode(fString, "[*]", "[/*]", "<li>", "</li>")
    //		fString = doCode(fString, "[left]", "[/left]", "<div align=left>", "</div id=left>")
    //		fString = doCode(fString, "[center]", "[/center]", "<center>", "</center>")
    //		fString = doCode(fString, "[centre]", "[/centre]", "<center>", "</center>")
    //		fString = doCode(fString, "[right]", "[/right]", "<div align=right>", "</div id=right>")
    //		fString = doCode(fString, "[code]", "[/code]", "<pre id=code><font face=courier size=" & strDefaultFontSize & " id=code>", "</font id=code></pre id=code>")
    //		fString = doCode(fString, "[quote]", "[/quote]", "<BLOCKQUOTE id=quote><font size=" & strFooterFontSize & " face=""" & strDefaultFontFace & """ id=quote>quote:<hr height=1 noshade id=quote>", "<hr height=1 noshade id=quote></BLOCKQUOTE id=quote></font id=quote><font face=""" & strDefaultFontFace & """ size=" & strDefaultFontSize & " id=quote>")
    //		fString = replace(fString, "[br]", "<br>", 1, -1, 1)
    //		if strIMGInPosts = "1" then
    //			fString = ReplaceImageTags(fString)
    //		end if
    //	end if
    //end if
    //if strIcons = "1" and _
    //fField_Type <> "title" and _
    //fField_Type <> "hidden" then
    //	fString= smile(fString)
    //end if
    //if fField_Type = "preview" then
    //	if strAllowHTML <> "1" then
    //		fString = HTMLEncode(fString)
    //	end if
    //end if
    //if fField_Type <> "hidden" and _
    //fField_Type <> "preview" then
    //	fString = Replace(fString, "'", "''")
    //end if
    //ChkString = fString

}


function HTMLEncode($fString)
{


    $fString = rtrim(trim($fString));
    if ($fString == "") {
        $fString = " ";
    }
    ;


    if (rtrim(trim($fString)) == "") {
        return " ";
    } else {
        $fString = str_replace(">", "&gt;", $fString);
        $fString = str_replace("<", "&lt;", $fString);
        return $fString;
    }

}


function getKomnatString($str)
{

    switch ($str) {
        case '1':
            return "1-комн";
        case '2':
            return "2-комн";
        case '3':
            return "3-комн";
        case '4':
            return "4-комн";
        case '0':
            return "Комната";
        default:
            return "Не указано";
    }
}


function generateAutoTitle($table, $cat, $str, $city, $street, $subarea)
{

    switch ($city) {
        case 'Минск':
        case 'Брест':
        case 'Витебск':
        case 'Новополоцк':
        case 'Могилев':
        case 'Минск':
            $city .= "е";
            break;
        case 'Гомель':
            $city = "Гомеле";
            break;
        default:

    }


    if (strlen($street) > 3) {
        $st = " " . $street . " ";
    } else {
        if (strlen($subarea) > 3) {
            $st = " " . $subarea . " ";
        }
    }

    $cp = "без посредников| ";
    if (strpos(strtolower($str), "срочно")) {
        $cp = "без посредников|срочно";
    }
    ;
    if (strpos(strtolower($str), "без посредников")) {
        $cp = "без посредников|без агентств";
    }
    ;
    if (strpos(strtolower($str), "без агент")) {
        $cp = "без посредников|без агентств";
    }
    ;
    if (strpos(strtolower($str), "агент")) {
        $cp = "без посредников|без агентств";
    }
    ;
    $cd = "на длительный срок| | | ";

    switch ($cat) {
        case 1:
            $c1 = "Сдаю квартиру в Минске|Сдается квартира|Аренда квартиры|Сдам квартиру в Минске|Квартира в Минске";
            $c1 = randonPhraze($c1) . " " . randonPhraze($cp) . " " . randonPhraze($cd);
            $c1 = str_replace("Минске", $city, $c1);

            $cURL = randonPhraze($c1) . $st . " " . randonPhraze($cp);
            break;
        case 2:
            $c1 = "Ищу квартиру|Сниму квартиру в Минске|Сниму квартиру|Сниму квартиру в Минске";
            $c1 = randonPhraze($c1) . " " . randonPhraze($cp) . " " . randonPhraze($cd);
            $c1 = str_replace("Минске", $city, $c1);
            $cURL = randonPhraze($c1) . $st . " " . randonPhraze($cp);
            break;
        case 3:
            $c1 = "Сдаю комнату в Минске";
            $c1 = randonPhraze($c1) . " " . randonPhraze($cp) . " " . randonPhraze($cd);
            $c1 = str_replace("Минске", $city, $c1);
            $cURL = randonPhraze($c1) . $st . " " . randonPhraze($cp) . " " . randonPhraze($cd);
            break;
        case 4:
            $c1 = "Сниму комнату в Минске";
            $cURL = randonPhraze($c1) . $st . " " . randonPhraze($cp);
            $c1 = str_replace("Минске", $city, $c1);


            break;
        case 5:
            $c1 = "Сдаю дом, коттедж";
            $cURL = randonPhraze($c1) . $st . " " . randonPhraze($cp);

            break;
        case 6:
            $c1 = "Сниму дом, коттедж";
            $cURL = randonPhraze($c1) . $st . " " . randonPhraze($cp) . " " . randonPhraze($cd);


            break;
        case 7:
            $c1 = "Сдаю офис";
            $cURL = randonPhraze($c1) . $st . " " . randonPhraze($cp) . " " . randonPhraze($cd);
            break;
        case 8:
            $c1 = "Сниму офис";
            $cURL = randonPhraze($c1) . $st . " " . randonPhraze($cp) . " " . randonPhraze($cd);
            break;


        case 9:
            $c1 = "Возьму на подселение";
            $cURL = randonPhraze($c1) . $st . " " . randonPhraze($cp) . " " . randonPhraze($cd);
            break;
        case 10:
            $c1 = "Подселюсь";
            $cURL = randonPhraze($c1) . $st . " " . randonPhraze($cp) . " " . randonPhraze($cd);
            break;


        case 13:
            $c1 = "Продам квартиру";
            $cURL = randonPhraze($c1) . $st;
            break;
        case 14:
            $c1 = "Куплю квартиру";
            $cURL = randonPhraze($c1) . $st;
            break;

        default:
            $c1 = "------";
    }
    ;


// создаем строку для URL тринслитерацией 
    $cURL = rtrim(trim($cURL));
    $urlstr = translitIt($cURL);
    $urlstr = makeUniqueURL($urlstr, $table);


// конец проверить на уникальность url 
//} 


    $result = array(
        'title' => $c1,
        'url' => $urlstr
    );

    return $result;
}


function translitIt($str)
{
    $str = trim($str);
    $tr = array(
        "А" => "a", "Б" => "b", "В" => "v", "Г" => "g",
        "Д" => "d", "Е" => "e", "Ж" => "j", "З" => "z", "И" => "i",
        "Й" => "y", "К" => "k", "Л" => "l", "М" => "m", "Н" => "n",
        "О" => "o", "П" => "p", "Р" => "r", "С" => "s", "Т" => "t",
        "У" => "u", "Ф" => "f", "Х" => "h", "Ц" => "ts", "Ч" => "ch",
        "Ш" => "sh", "Щ" => "sch", "Ъ" => "", "Ы" => "yi", "Ь" => "",
        "Э" => "e", "Ю" => "yu", "Я" => "ya", "а" => "a", "б" => "b",
        "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
        "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
        "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
        "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
        "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
        "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
        " " => "-", "." => "-", "/" => "_"
    );
    $urlstr = strtr($str, $tr);
    $urlstr = preg_replace('/[^A-Za-z0-9_\-]/', '', $urlstr);
    return $urlstr;
}


function randonPhraze($phraze)
// Выбор случайной фразы из строки, фраз ,разделенных символом |
{
    if (strpos($phraze, "|")) {
        $phrazeArr = split("\|", $phraze);
        $r = rand(0, count($phrazeArr));
        return ($phrazeArr[$r]);
    } else {
        return $phraze;
    }
}


function chkPhones($strPhones)
{
    $strPhones = str_replace(".", ",", $strPhones);
    $phonearr = split(",", $strPhones);
    for ($i = 0; $i <= (count($phonearr) - 1); $i++) {
        $phonearr[$i] = getonlydigits($phonearr[$i]);
        if (strlen($phonearr[$i]) > 6) {
            if (inBlackList($phonearr[$i])) {
                return true;
            }
        }
    }
}


function chkCodes($strPhones)
{

    $arrayCodes = array('025', '029', '033', '017', '044');

    $strPhones = str_replace(".", ",", $strPhones);
    $phonearr = split(",", $strPhones);
    for ($i = 0; $i <= (count($phonearr) - 1); $i++) {
//echo ("44= " . $phonearr[$i] . "; ");

        $phonearr[$i] = getonlydigits($phonearr[$i]);
        if (strlen($phonearr[$i]) > 8) {

            $cod = substr($phonearr[$i], 1, 3);
            //echo ("с= " . $cod . "; ");
            if (substr($phonearr[$i], 0, 1) == '8') {
                if (!in_array($cod, $arrayCodes)) {
                    //echo ("CCCCCCCC= " . $cod . "; ");
                    return true;
                }

            }
        }

    }


}

function getonlydigits($str)
{
    if (strlen($str) < 1) {
        return "";
    }
    $digitsString = "";
    for ($i = 0; $i <= (strlen($str)); $i++) {
        $simb = substr($str, $i, 1);
        if (is_numeric($simb)) {
            $digitsString = $digitsString . $simb;
        }
    }
    return $digitsString;
}


function getmaxdigits($str)
{
// длина группы цифр 
    if (strlen($str) < 1) {
        return "";
    }
    $digitsString = "";
    $maxdigitsString = "";
    $simbafter = 0;
    $maxsimbafter = 2; //константа
    $dglenth = 0;
    $maxlen = 0;

    for ($i = 0; $i <= (strlen($str)); $i++) {
        $simb = substr($str, $i, 1);

        if (is_numeric($simb) && $simbafter < $maxsimbafter + 1) {
            $dglenth = $dglenth + 1;
            $digitsString = $digitsString . $simb;
            $simbafter = 0;
        } else {
// не цифра
            if ($simbafter > $maxsimbafter) {
                if ($dglenth > $maxlen) {
                    $maxlen = $dglenth;
                    $maxdigitsString = $digitsString;
                }
                $dglenth = 0;
                $digitsString = "";


            }
            $simbafter = $simbafter + 1;


        }
    }

    if ($dglenth > $maxlen) {
        $maxlen = $dglenth;
        $maxdigitsString = $digitsString;
    }


//echo($maxdigitsString);
    $data = split($maxlen, $maxdigitsString);

    return $data;
}


function inBlackList($num)
{
    $CI =& get_instance();
    $CI->db->where('p_number', $num);
    $CI->db->from('realt_phonelist');
    $co = $CI->db->count_all_results();
    if ($co > 0) {


        $usql = "UPDATE `realt_phonelist` SET `p_popytok` = `p_popytok` + 1 WHERE `p_number` = '" . $num . "' LIMIT 1;";
        $CI->db->query($usql);

        return TRUE;
    } else {
        return FALSE;
    }


}


function inEmailBlackList($email)
{
    $CI =& get_instance();
    $CI->db->where('email', $email);
    $CI->db->from('realt_black_emails');
    $co = $CI->db->count_all_results();
    if ($co > 0) {
        $usql = "UPDATE `realt_black_emails` SET `popytok` = `popytok` + 1 WHERE `email` = '" . $email . "';";
        $CI->db->query($usql);
        return 1;
    } else {
        
    }
	 
	
	$mailserver = substr($email, strrpos($email, '@')+1);
	//echo("mailserver" . $mailserver);
	$email = "*@" . $mailserver;
	
	$CI->db->where('email', $email);
    $CI->db->from('realt_black_emails');
    $co = $CI->db->count_all_results();
    if ($co > 0) {
        $usql = "UPDATE `realt_black_emails` SET `popytok` = `popytok` + 1 WHERE `email` = '" . $email . "';";
        $CI->db->query($usql);
        return 2;
    } else {
        
    }
	
	
	return FALSE;
	
	
	
}


function generate_password($number)
{
    $arr = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z',
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '1', '2', '3', '4', '5', '6', '7', '8', '9', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    // Генерируем пароль
    $pass = "";
    for ($i = 0; $i < $number; $i++) {
        $index = rand(0, count($arr) - 1); // Вычисляем случайный индекс массива
        $pass .= $arr[$index];
    }
    return $pass;
}


function secretCodeExists($code)
{
    $CI =& get_instance();
    $CI->db->where('ad_secretcode', $code);
    $CI->db->from('ads');
    $co = $CI->db->count_all_results();
    if ($co > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}


function urlExists($code)
{
    $CI =& get_instance();
    $CI->db->where('ad_url', $code);
    $CI->db->from('ads');
    $co = $CI->db->count_all_results();
    if ($co > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}


function getLastAdOfUID($aduid)
{
// Возвращает объявление, которое пора поднять
// если объявление новое (моложе 30 минут) то возвращаем -1 - т.к поднимать его н енадо


//$timeout=date("Y-m-d H:i:s",time()-( 30*60));

    if ($CI->data['mlev'] == 4) {
        //echo($timeout);
         
        //print_r ("ND=" . $nowdate);
        //echo ("GL1=" . $GLOBALS['auidCheck_date']);
    }


    $CI =& get_instance();
    $CI->db->where('ad_uid', $aduid);
//$CI->db->where('ad_postdate <', $timeout);
    $CI->db->from('ads');
    $CI->db->where('ad_show', '1');
    $CI->db->limit(1, 0);
    $CI->db->order_by("ad_postdate", "desc");
    $query = $CI->db->get();

    //if  ($CI->data['mlev']==4){	echo 	($CI->db->last_query()); }
    if ($query->num_rows() == 0) {
        $result = false;

        if ($CI->data['mlev'] == 4) {

            //echo ("result=FALSE;");

        }
        $getlastadUid = array('lastad_id' => "-1", 'lastad_postdate' => "0");
        return $getlastadUid;
    } else {
        //$result = $query->result_array();

//$i=0;
//$GLOBALS['activeuids']="";
        $activeuids = "";

        foreach ($query->result() as $row) {
//$ad_id=$row->ad_id;
            $getlastadUid = array('lastad_id' => $row->ad_id, 'lastad_postdate' => $row->ad_postdate);
            return $getlastadUid;
        }


    }


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


function my_date_diff($start, $end)
{
    $date_time_string = $start;
// Разбиение строки в 2 части - date and time
    $dt_elements = explode(' ', $date_time_string);
// Разбиение date
    $date_elements = explode('-', $dt_elements[0]);
// Разбиение time
    $time_elements = explode(':', $dt_elements[1]);
// Собираем результат 
// Формат int mktime(int hour, int minute, int second, int month, int day, int year, int [is_dst] ); 
    $start = mktime($time_elements[0], $time_elements[1], $time_elements[2], $date_elements[1], $date_elements[2], $date_elements[0]);


//$timeout3days=date("Y-m-d H:i:s",time()-( (3*24*60*60)));


    $date_time_string = $end;
// Разбиение строки в 2 части - date and time
    $dt_elements = explode(' ', $date_time_string);
// Разбиение date
    $date_elements = explode('-', $dt_elements[0]);
// Разбиение time
    $time_elements = explode(':', $dt_elements[1]);
// Собираем результат 
// Формат int mktime(int hour, int minute, int second, int month, int day, int year, int [is_dst] ); 
    $last = mktime($time_elements[0], $time_elements[1], $time_elements[2], $date_elements[1], $date_elements[2], $date_elements[0]);

    return $start - $last;

}


function getcurrentscenery()
{
    $CI =& get_instance();
    $scenery = array();
    $sceneryParam = array();
    $sceneryDescr = array();
	$found_text="";
    $uid = $CI->data['user_uid'];
    $ip = $_SERVER["REMOTE_ADDR"];
    $member = "";
    $text = "";
    $price = "";
    $text = chkString($CI->input->post('content'), "SQLString");
    $CI->db->from("realt_sceneries");
    $CI->db->where('active', '1');
    $CI->db->limit(1000, 0);
    $query = $CI->db->get();
    if ($query->num_rows() == 0) {
        $result = false;

    } else {

        foreach ($query->result() as $row) {

            switch ($row->param) {
                case 'uid':

//echo( "   val:" . $row->value . "-");
//echo("-c:" . $uid . "-");
                    if ($row->value == $uid && $uid != "" && $row->value != "") {

                        array_push($scenery, $row->action);
                        array_push($sceneryParam, $row->action_params);
                        array_push($sceneryDescr, $row->note);
                    }
                    break;
                case 'ip':
                    if ($row->value == $ip && $ip != "" && $row->value != "") {
                        array_push($scenery, $row->action);
                        array_push($sceneryParam, $row->action_params);
                        array_push($sceneryDescr, $row->note);
                    }
                    break;
                case 'member':
                    if ($row->value == $member && $member != "" && $row->value != "") {
                        array_push($scenery, $row->action);
                        array_push($sceneryParam, $row->action_params);
                        array_push($sceneryDescr, $row->note);
                    }
                    break;

                case 'text':
//if ($row->value == $text && $text!="" &&  $row->value!=""){$scenery .= $row->action . ";";}
                    if ($text != "" && $row->value != "") {
//echo("текст параметр задан и не равен нулю");
                        $pos = strpos(strtolower($text), strtolower($row->value));

//echo("row-value=". $row->value);
//echo("text=". $text);
//echo("поз=". $pos);

                        if ($pos > -1) {

                            $found_text = $row->value;
                            array_push($scenery, $row->action);
                            array_push($sceneryParam, $row->action_params);
                            array_push($sceneryDescr, $row->note);
                        }
                    }

                    break;
                case 'price':
                    if ($row->value == $price && $price != "" && $row->value != "") {
                        array_push($scenery, $row->action);
                        array_push($sceneryParam, $row->action_params);
                        array_push($sceneryDescr, $row->note);
                    }

            }
        }


    }

    $sceneryArr = array($scenery, $sceneryParam, $sceneryDescr, $found_text);
    return ($sceneryArr);


}


function getTableFromCatID($ad_catid)
{
    // возвращает название таблицы по категории
    if ($ad_catid == 11 || $ad_catid == 12) {
        $table = "sutki";
    } else {
        $table = "ads";
    }
    return $table;
}


function getNextUrlIndex($str, $table)
{


    $ip = $_SERVER["REMOTE_ADDR"];
    $refer = strtolower($_SERVER['HTTP_REFERER']);
    $CI =& get_instance();


    $CI =& get_instance();
    $CI->db->like('ad_url', $str . "_", 'after');
    $CI->db->order_by("ad_id", "desc");
    $CI->db->from($table);

    $query = $CI->db->get();
    $strtopost .= " " . $CI->db->last_query() . " ";
    if ($query->num_rows() == 0) {
        $NextUrlIndex = 1;
    } else {
        foreach ($query->result() as $row) {
            $str1 = $row->ad_url;
            $posrev = strpos(strrev($str1), "_"); //
            $strtopost .= ' найден урл=' . $str1;
            $strtopost .= ' posrev=' . $posrev;
            if (strlen($str1) >= $pos) {
                $lastSegment = substr($str1, strlen($str1) - $posrev, strlen($str1));
                $strtopost .= '; находим lastsegment=' . $lastSegment . ";";
                if (is_numeric($lastSegment)) {

                    $CI->db->where('ad_url', $str . "_" . $lastSegment + 1);
                    $CI->db->from($table);
                    $co = $CI->db->count_all_results();
                    if ($co == 0) {
                        $NextUrlIndex = $lastSegment + 1;


                        $CI =& get_instance();
                        $config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                        $CI->load->library('email', $config);
                        $CI->email->set_newline("\r\n");
                        $CI->email->from('dakh@mail.ru');
                        $CI->email->to('dakh2008@mail.ru');
                        $CI->email->subject('test-url');
                        $CI->email->message($strtopost);
                        $CI->email->send();


                        return $NextUrlIndex;
                    }

                }

            }

        }


        $CI =& get_instance();
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('dakh@mail.ru');
        $CI->email->to('dakh@mail.ru');
        $CI->email->subject('test-url-вернули ноль');
        $CI->email->message($strtopost);
        $CI->email->send();


    }

    return $NextUrlIndex;
}


function makeUniqueURL($str, $table)
{

    $str = str_replace("---", "-", $str);
    $str = str_replace("--", "-", $str);
    $str = str_replace("--", "-", $str);
    $str = trim($str, "-");

//проверить на уникальность url  ,добавить суффикс в конце если не уникален

    if (!strpos(strrev($str), "-")) {
        $str = "ad" . $str;
    }
    ;


//$url_ex=getNextUrlIndex($str, $table); //  возврашает цифровой суффикс следующего пустого  URL с таким именем. 

    $url_ex = getlastfilename();


    $ip = $_SERVER["REMOTE_ADDR"];
    $refer = strtolower($_SERVER['HTTP_REFERER']);
    $CI =& get_instance();


    return $str . "_" . $url_ex;


}


function chkflood($ad_catid, $ad_message, $ad_uid)
{




    $CI =& get_instance();
    $uid = $CI->data['user_uid'];
    $ip = $_SERVER["REMOTE_ADDR"];
    $CI->db->from("ads");
    $where = "(ad_show='1' OR ad_pending='1')";
    $CI->db->where($where);
    $CI->db->where('ad_uid', $ad_uid);
    $CI->db->where('ad_catid', $ad_catid);
    if (strlen($ad_message) > 21) {
        $CI->db->like('ad_message', $ad_message);
    }
    $timeout1hour = date("Y-m-d H:i:s", time() - ((0.10 * 60 * 60))); // 15 мин
    $CI->db->where('ad_firstdate >', $timeout1hour);
    $CI->db->limit(1000, 0);
    $query = $CI->db->get();

    if ($CI->data['mlev'] == 4) {
//echo ($CI->db->last_query());
    }
    if ($query->num_rows() == 0) {
        $result = false;

    } else {

        $result = true;
    }
    return $result;
}


function getCatData($ad_catid)
{

//echo " ad_catid = $ad_catid";
    switch ($ad_catid) {
        case '1':
            $catname = "Снять квартиру";
            $catURI = "kvartira/snyat";
            break;
        case '2':

            $catname = "Сдать квартиру";
            $catURI = "kvartira/sdat";
            break;
        case '3':

            $catname = "Снять комнату";
            $catURI = "komnata/snyat";
            break;
        case '4':

            $catname = "Сдать комнату";
            $catURI = "komnata/sdat";
            break;
        case '5':


            $catname = "Снять дом, коттедж";
            $catURI = "dom/snyat";
            break;
        case '6':

            $catname = "Сдать дом, коттедж";
            $catURI = "dom/sdat";
            break;
        case '7':

            $catname = "Снять под офис";
            $catURI = "office/snyat";
            break;
        case '8':

            $catname = "Сдать под офис";
            $catURI = "office/sdat";
            break;
        case '9':

            $catname = "Возьму на подселение";
            $catURI = "dom/sdat";
            break;
        case '10':

            $catname = "Подселюсь";
            $catURI = "dom/sdat";
            break;
        case '11':

            $catname = "Квартиры на сутки в Минске";
            $catURI = "kvartira/na-sutki";
            break;
        case '12':
            $catname = "Снять дом, коттедж на сутки";
            $catURI = "kvartira/na-sutki";

            break;
        default:
            $catname = "Аренда";
            $catURI = "";

    }

    $catURI = "http://neagent.by/" . $catURI;


    return array('cat_name' => $catname, 'cat_URI' => $catURI);


}


function resizePic($f, $newf, $type)
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
    if ($type == 4) {
        $w = 100;
        $h = 75;
    } // пропорциональная шириной до 70x100
    if ($type == 5) {
        $w = 230;
        $h = 90;
    } // пропорциональная шириной до 70x100


// качество jpeg по умолчанию
    if (!isset($q)) $q = 100;

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
    //echo " -- " ;
// echo $w_src;


// если размер исходного изображения отличается от требуемого размера
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


        if ($type == 5) {

            // создаём пустую прям  картинку
            // важно именно truecolor!, иначе будум иметь 8-битный результат
            //$dest = imagecreatetruecolor($w,$h);

            $ratio = $w_src / $w;
            $prop = 230 / 90;
            $prop_src = $w_src / $h_src;
            $w_dest = round($w_src / $ratio);
            $h_dest = round($h_src / $ratio);

            // создаём пустую картинку
            // важно именно truecolor!, иначе будем иметь 8-битный результат
            $dest = imagecreatetruecolor($w, $h);
            //imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
            //получаем по ширине 230px


            // вырезаем квадратную серединку по x, если фото горизонтальное
            if ($prop_src < $prop) { // картинка слишком высока ,обрезать нужно верх-низ  
                //echo (round((max($w_src,$h_src)-min($w_src,$h_src))/2));
                // echo ("  ");
                //echo (min($w_src,$h_src));

//echo (" var  1 ");


                //imagecopyresampled($dest, $src, 0, 0, 0, round((max($w_src,$h_src)-min($w_src,$h_src))/2), $w, $h, $w_src, $h_src);

                $xx = $w_src * $h / $w;
                $x2 = round(($h_src - $xx) / 2);
                imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $w_src, $h_src - $x2);


                //imagecopyresampled($dest, $dest, 0, 0, round((max($w_src,$h_src)-min($w_src,$h_src))/2), 0, $w, $h, min($w_src,$h_src), min($w_src,$h_src));


            }
            // вырезаем квадратную верхушку по y,
            // если фото вертикальное (хотя можно тоже середику)
            if ($prop_src > $prop) { //   

//echo ("  var 2 ");

                //   imagecopyresampled($dest, $src, 0, 0, 0, round((max($w_src,$h_src)-min($w_src,$h_src))/2), $w, $h, min($w_src,$h_src), min($w_src,$h_src));

                imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $w_src, $h_src);


            }
            // квадратная картинка масштабируется без вырезок
            if ($prop_src == $prop) {
                //echo ("  3 ");
                imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_src, $h_src, $w_src, $h_src);
            }

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
 

