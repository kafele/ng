<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package        CodeIgniter
 * @author        ExpressionEngine Dev Team
 * @copyright    Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license        http://codeigniter.com/user_guide/license.html
 * @link        http://codeigniter.com
 * @since        Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter File Helpers
 *
 * @package        CodeIgniter
 * @subpackage    Helpers
 * @category    Helpers
 * @author        ExpressionEngine Dev Team
 * @link        http://codeigniter.com/user_guide/helpers/file_helpers.html
 */

// ------------------------------------------------------------------------

/**
 * Read File
 *
 * Opens the file specfied in the path and returns it as a string.
 *
 * @access    public
 * @param    string    path to file
 * @return    string
 */


 
if (!function_exists('inEmailBlackList')) { 
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
 }
 
 
 
 
 
 
 
 
 
if (!function_exists('createAdData')) {
    function createAdData($row, &$data)
    {
        $CI =& get_instance();

        $street = ($row->ad_street != "" && $row->ad_street != " ") ? (" - " . $row->ad_street) : "";
		$data['single_ad']=isset($data['single_ad'])?$data['single_ad']:0;
		if ($data['single_ad'] == 1){
        $data['meta_title'] = $row->ad_title . $street . " - Neagent.by"; //$data['NAME'];
        $data['meta_description'] = "Сдать квартиру, доска объявлений без агентств";
		}
		
$data['short_keywords'] = isset($data['short_keywords'])?$data['short_keywords']:"";

        $addata = array('ad_catid' => $row->ad_catid,
            'ad_id' => $row->ad_id,
            'ad_title' => $row->ad_title,
            'ad_message' => $row->ad_message,
            'ad_price' => $row->ad_price,
            'ad_price_min' => $row->ad_price_min,
            'ad_price_max' => $row->ad_price_max,
            'ad_currency' => $row->ad_currency,
            'ad_phones' => $row->ad_phones,
            'ad_contactname' => $row->ad_contactname,
            'ad_postdate' => $row->ad_postdate,
            'ad_firstdate' => $row->ad_firstdate,
            'ad_up_date' => $row->ad_up_date,
            'ad_email' => $row->ad_email,
            'ad_pictures' => $row->ad_pictures,
			'ad_city' => $row->ad_city,
            'ad_area' => $row->ad_area,
            'ad_subarea' => $row->ad_subarea,
            'ad_street' => $row->ad_street,
            'ad_dom' => $row->ad_dom,
            'ad_korpus' => $row->ad_korpus,
            'ad_url' => $row->ad_url,
            'ad_komnat' => $row->ad_komnat,
            'ad_komnat_min' => $row->ad_komnat_min,
            'ad_komnat_max' => $row->ad_komnat_max,
			'ad_etazh' => $row->ad_etazh,
						'ad_etazhej' => $row->ad_etazhej,
						'ad_pl_o' => $row->ad_pl_o,
						'ad_pl_z' => $row->ad_pl_z,
						'ad_pl_k' => $row->ad_pl_k,
            'ad_uid' => $row->ad_uid,
            'ad_evc' => $row->ad_evc,
            'ad_ip' => $row->ad_ip,
            'ad_cref' => $row->ad_cref,
            'ad_show' => $row->ad_show,
            'ad_pending' => $row->ad_pending,
            'ad_secretcode' => $row->ad_secretcode,
            'ad_imgtitle' => $data['short_keywords'],
            'ad_imgalt' => $data['short_keywords'],
            'ad_showpolitic' => $row->ad_showpolitic,
            'ad_confirmed' => $row->m_confirmed,
            'ad_comments_count' => $row->ad_comments_count,
            'ad_hits' => $row->ad_hits,
			'partner_link' => $row->partner_link,
			'ad_icons' => $row->ad_icons,
            'ad_fakefor' => $row->ad_fakefor,
			'ad_isagent' => $row->ad_isagent,
        );
        $delayed = false;
		
		 
		
		 $addata['ad_icons']=processIcons($addata['ad_icons']);
		
		
		
		 include 'inc_hrepl_phones.php';
		
		
		
		
		
		
		
		
		
		if ($addata['ad_etazh']==0 || $addata['ad_etazhej']==0 )
					{
					$addata['ad_etazh']=false ; $addata['ad_etazhej']=false;
					}
					
					if ($addata['ad_pl_o']==0)  {$addata['ad_pl_o']="-";};					
					if ($addata['ad_pl_z']==0)  {$addata['ad_pl_z']="-";};	
                    if ($addata['ad_pl_k']==0)  {$addata['ad_pl_k']="-";};	

					if ($addata['ad_pl_o']=="-" && $addata['ad_pl_z']=="-" && $addata['ad_pl_k']=="-" )
					{
					$addata['ad_pl_o']=null;
					}
					
					
		//		$addata['ad_city']{
//$addata['ad_city'] =="";

//}


				

        //print_r ($addata);
        //echo("<hr>");
        $addata['longitude'] = (float)$row->longitude;
        $addata['latitude'] = (float)$row->latitude;

        if ($addata['ad_confirmed'] != '1') {
            $addata['ad_email'] = "" . $addata['ad_email'] . "[?]";
        }


        if ($data['labels_flag'] == 1) {
            $addata['labels_flag'] = 1;
            $labelmark = getlabelmark($row->ad_id); // возвращает прямо строчку которую нужно вставить 
            $addata['labelmark'] = $labelmark;
        }


        if (strlen($addata['ad_fakefor']) > 2) {
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $CI->load->library('email', $config);
            $CI->email->set_newline("\r\n");
            $CI->email->from('dakh@mail.ru');
            $CI->email->to('dakh@mail.ru');
            $CI->email->subject('Показано объявление fake ');
            $CI->email->message('uid= ' . $CI->data['user_uid'] . ";  ad_fakefor=" . $addata['ad_fakefor']);
            $CI->email->send();
        }


        //echo ("00");
        if (strlen($addata['ad_pictures']) > 0) {
//echo ("--");
            $ad_pictures = explode("; ", $addata['ad_pictures']);
            $addata['ad_pictures'] = $ad_pictures;
            $addata['ad_thumbs'] = $ad_pictures;
            $addata['pic_folder'] = "http://neagent.by/modules/Realt/files/";
            $addata['ad_mainpic'] = "http://neagent.by/modules/Realt/files/" . "t_" . $ad_pictures[0];
        } else {


            $addata['ad_pictures'] = array();
            $addata['ad_mainpic'] = getMainPicture($addata['ad_catid'], $addata['ad_komnat']);

            if ($data['wap_view'] == 1) {
                $addata['ad_mainpic'] = "w_" . $addata['ad_mainpic'];
            }

        }


///////// Если эт опоказ одиночного /////// 
if ($data['single_ad'] == 1){
        $hits = (int)$row->ad_hits;
        $CI->db->where("ad_id", $row->ad_id);
        $CI->db->set("ad_hits", $hits + 1);
        $CI->db->update("ads");
}		
//////////////////////////////////////// //


        $addata['newpage'] = config_item('realt_newpage');
        $cat_params = getCatData($row->ad_catid);
        $addata['show_phones'] = config_item('realt_show_phones');

//if ($_GET['nohide']==1){
//$addata['show_phones']=0;
//saveLog('parsing_nohide', ' ');
//}

        if ($_SERVER["REMOTE_ADDR"] == '75.101.132.85') {
            $addata['show_phones'] = 1;
            saveLog('parsing_nohide', ' ');
        }


        $addata['newpage'] = config_item('realt_newpage');
//$addata['single_ad']= 1;


//echo("us" . $data['userstatus']);



        if ($addata['ad_showpolitic'] == "true" || $addata['ad_showpolitic'] == "combi" || $addata['ad_showpolitic'] == "true2") {

 //echo("sp=" . $addata['ad_showpolitic']);	
	//echo("us" . $data['userstatus']);	
            if ($data['userstatus'] != "active"  && $data['userstatus'] != "allowed") {
			//echo("us2" . $data['userstatus'] . ";");
			
                $tel = $addata['ad_phones'];
                $addata['ad_phones'] = "";
                if ($data['mlev'] == 4) {
                    $addata['ad_phones'] = $tel . " ";
                }
                $addata['ad_phones'] .= "скрыт. <a href='http://neagent.by/board/access'>Как увидеть телефон?</a>";
            }
        }


//// сокрытие телефона если рано еще

        $pdata = $row->ad_firstdate;
        $nowdate = date("Y-m-d H:i:s");
        $date_time_string = $nowdate;
        $dt_elements = explode(' ', $date_time_string);
        $date_elements = explode('-', $dt_elements[0]);
        $time_elements = explode(':', $dt_elements[1]);
        $nn = mktime($time_elements[0], $time_elements[1], $time_elements[2], $date_elements[1], $date_elements[2], $date_elements[0]);
//echo( "n=" . $nowdate  . ";");

        $obdate = $pdata;
        $date_time_string = $obdate;
        $dt_elements = explode(' ', $date_time_string);
        $date_elements = explode('-', $dt_elements[0]);
        $time_elements = explode(':', $dt_elements[1]);
        $oo = mktime($time_elements[0], $time_elements[1], $time_elements[2], $date_elements[1], $date_elements[2], $date_elements[0]);
//echo( "0b=" . $pdata  . ";");

        $diff = $nn - $oo;
//echo($diff . "+");
        $minutsForShow = (int)config_item('realt_post_delay');
        $sekForShow = $minutsForShow * 60;

        $sekost = ($minutsForShow * 60 - $diff); // осталось секунд 
        $minsh = floor($sekost / 60); // осталось минут
//echo($minsh . "-" . $sekost);

//echo ("`".$minsh);
        $seksh = $sekost - $minsh * 60;
//echo ("`".$seksh);
        if (($minsh) > 3) {
            $ostalos = "Будет доступен через " . $minsh . "мин. ";
        } else {
            $ostalos = "Будет доступен через " . $minsh . "мин. " . $seksh . "сек.";
        }
        if ($diff < ($minutsForShow * 60) && $diff > -1) {
            $addata['ad_phones'] = $ostalos;
        }

////////


        $addata['cat_name'] = $cat_params['cat_name'];
        $addata['cat_URI'] = $cat_params['cat_URI'];


        $addata['ad_firstpic'] = "<img src='" . base_url() . "themes/neagent_style/assets/images/kvartira.gif' width='60' height='50'  alt='Квартира' />";
// привести дату в нормальный вид


        if (config_item('realt_modify_date') == '1') {
            $addata['ad_postdate'] = modifier_dat2post($addata['ad_postdate']);
        } //модификатор дат
        ////////////////  СУТКИИ ЭТО  
        $addata['ad_komnat_txt'] = getKomnatString($addata['ad_komnat']);
        $addata['mlev'] = $data['mlev']; // помечаем админа или кого еще чтобы в объявлении можно было видеть

        if (strlen($addata['ad_url']) < 2) {
            $addata['ad_url'] = $addata['ad_id'];
        }
		
		 $addata['sutki_pictures']=isset($addata['sutki_pictures'])?$addata['sutki_pictures']:"";
		 
        if (strlen($addata['sutki_pictures']) > 2) {
//imagesArr=split(pictures, ",")
//firstpic="<a rel=""pics_" & strAdId & """ href=""" & "uploads/n_" & imagesArr(0) & """><img src=""uploads/t_" & imagesArr(0)&  """ width=""60"" height=""50""   />" 
//firstpic="<a   href=""default.asp?ad_id=" &  strAdId &"""><img src=""uploads/t_" & imagesArr(0)&  """ width=""60"" height=""60""   />" 
        } else {
            $addata['sutki_firstpic'] = "<img src='" . base_url() . "themes/neagent_style/assets/images/nopic.gif' width='60' height='50'   />";
// firstpic="<img src=""themes/neagent/images/pic.gif"" width=""60"" height=""50""   />"
        }


        if ($data['wap_view'] == 1) {
            $addata['ad_url'] = "http://neagent.by/wap/snimu/" . $addata['ad_url'];
        } else {

            switch ($addata['ad_catid']) {
                case '2':
                case '4':
                case '6':
                case '8':
                case '10':
                case '12':
                    $addata['ad_url'] = "http://neagent.by/snimu/" . $addata['ad_url'];
                    break;
                case '1':
                case '3':
                case '5':
                case '7':
                case '9':
                case '11':
                case '13':
                default:
                    $addata['ad_url'] = "http://neagent.by/sdayu/" . $addata['ad_url'];
                    break;
            }

        }


        $addata['ad_isup'] = '';
///////////// Если поднято, установить маркер
        if ($addata['ad_up_date'] != "0000-00-00 00:00:00") {
///////////// Если удалено уже, то обнулить поднятие
            if ($addata['ad_show'] == 0) {
                $CI->db->where("ad_id", $row->ad_id);
                $CI->db->set("ad_up_date", "0000-00-00 00:00:00");
                $CI->db->update("ads");
            }
            $addata['ad_isup'] = '&nbsp;<img src="http://img1.neagent.by/s/up_ad.png" title="Объявление поднято.">';
        }


        if ($addata['ad_komnat_min'] < $addata['ad_komnat_max']) {
//echo($addata['ad_komnat_min'] .  "—" . $addata['ad_komnat_max'] . " комн.");
            $addata['ad_komnat'] = $addata['ad_komnat_min'] . "–" . $addata['ad_komnat_max'];
            $addata['ad_komnat'] = $addata['ad_komnat_max'];
            $addata['ad_komnat_txt'] = $addata['ad_komnat_min'] . "–" . $addata['ad_komnat_max'] . " комн.";
            $addata['ad_komnat_txt'] = $addata['ad_komnat_min'] . "–" . $addata['ad_komnat_max'] . " комн.";
        } else {
            if ($addata['ad_komnat_max'] != 0) {
                $addata['ad_komnat'] = $addata['ad_komnat_max'];
            }
            $addata['ad_komnat_txt'] = getKomnatString($addata['ad_komnat']);
        }

//echo("$$$$$$$$$$$$$$$;"); 
        if ($addata['ad_price_min'] < $addata['ad_price_max']) {
//echo("min меньше  max;"); 

            if ($addata['ad_price_min'] == 0) {
//echo("min=0;"); 
                $addata['ad_price'] = "до " . $addata['ad_price_max'];
            } else {
//echo("min!=0;"); 
                $addata['ad_price'] = $addata['ad_price_min'] . "–" . $addata['ad_price_max'];
//$addata['ad_price'] = $addata['ad_price_max'] ;
            }


        } else {
            if ($addata['ad_price_max'] != 0) {
                //echo("*max!=0;"); 
                $addata['ad_price'] = $addata['ad_price_max'];
            }
        }


        //print_r ($addata);


        return $addata;


    }
}



if (!function_exists('getRegionsHTML')) {
function getRegionsHTML( )
    {
	

	
	
	
}
}	
	
	



if (!function_exists('ad_view_counter')) {

    function ad_view_counter($ad_id) //( с префиксом 100 или 200) 
    {
       $CI =& get_instance();
		$uid = $_COOKIE["uid"];
        $ip = $_SERVER["REMOTE_ADDR"];
       $ad_id = (int)$ad_id;

	   if (!$uid){
	   $uid=$CI->data['user_uid'] ;
	   }
	   
	   
	   if (!$ip || !$uid){
	   
	    $config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                        $CI->load->library('email', $config);
                        $CI->email->set_newline("\r\n");
                        $CI->email->from('info@neagent.by');
                        $CI->email->to('dakh2008@mail.ru');
                        $CI->email->subject('нет uid или IP');
                        $CI->email->message(' ip=' . $ip . ";  uid=" . $uid);
                        $CI->email->send();

	   
	   return;
	   }
	   
	   $CI->db->where('ad', $ad_id);
	   $CI->db->where("(ip = '$ip' OR uid = '$uid')");
       $CI->db->from("ads_views");
       $query = $CI->db->get();
       $co=  $query->num_rows();

        if ($co == 0) {
		$CI->db->where('ad', $ad_id);
        $CI->db->from("ads_views");
		$query = $CI->db->get();
        $co=  $query->num_rows();
        $views=$co ;
		//$views=1;
		$data = array(
                    ad => $ad_id,
					ip=>$ip,
					uid=>$uid,
				);	
             $CI->db->insert('ads_views', $data);

        } else {

		$CI->db->where('ad', $ad_id);
        $CI->db->from("ads_views");
		// $co = $CI->db->count_all_results();
		  $query = $CI->db->get();
    //echo($CI->db->last_query());
//$CI->db->_error_message();
$co=  $query->num_rows();
           $views=$co;
        }
        ;
        //echo ( " вернули count = " . count($params));	
        return $views;
    }
}





if (!function_exists('ad_phonesview_counter')) {

    function ad_phonesview_counter($ad_id) //( с префиксом 100 или 200) 
    {
        $CI =& get_instance();
		$uid = $_COOKIE["uid"];
        $ip = $_SERVER["REMOTE_ADDR"];
        $ad_id = (int)$ad_id;

	   if (!$ip || !$uid){
	   return;
	   }
	   
	   $CI->db->where('ad', $ad_id);
	   $CI->db->where("(ip = '$ip' OR uid = '$uid')");
       $CI->db->from("ads_phone_views");
		$query = $CI->db->get();

$co=  $query->num_rows();

        if ($co == 0) {
        $views=$co + 1;
		//$views=1;
		$data = array(
                    ad => $ad_id,
					ip=>$ip,
					uid=>$uid,
				);	
             $CI->db->insert('ads_phone_views', $data);

        } else {

		$CI->db->where('ad', $ad_id);
        $CI->db->from("ads_phone_views");
		// $co = $CI->db->count_all_results();
		  $query = $CI->db->get();
    //echo($CI->db->last_query());
//$CI->db->_error_message();
$co=  $query->num_rows();
           $views=$co;
        }
        ;
        //echo ( " вернули count = " . count($params));	
        return $views;
    }
}











if (!function_exists('processIcons')) {

    function processIcons($ad_icons) 
    {
$tselect=1;
$CI =& get_instance();
$iconsArr=split(";" , $ad_icons);
$newArr=array();
for ($i = 0; $i < (count($iconsArr)); $i++) {

 switch ($iconsArr[$i]) {
                case 'i1'://
                $val = array('class' => 'ai_smoke', 'id' => 1);
				 $val['title'] =($tselect==1)?'Курение разрешено':'Курю';
				array_push($newArr, $val);   
                break;
                case 'i2':
                 $val = array('class' => 'ai_nosmoke', 'title_spros' => 'Не курю', 'title_predl' =>'Курение запрещено', 'id' => 1);
				 $val['title'] =($tselect==1)?'Курение запрещено':'Не курю';
                array_push($newArr, $val);
                    break;
                case 'i3':
                 $val = array('class' => 'ai_pets', 'title_spros' => 'Домашние животные', 'title_predl' =>'Возможно с домашними животными', 'id' => 3);
				 $val['title'] =($tselect==1)?'Возможно с домашними животными':'Домашние животние';
                array_push($newArr, $val);
                    break;
				 
					case 'i5':
                 $val = array('class' => 'ai_internet', 'title_spros' => 'Интернет', 'title_predl' =>'Интернет', 'id' => 5);
				 $val['title'] =($tselect==1)?'Интернет':'Интернет';
                array_push($newArr, $val);
                    break;
					case 'i7':
                 $val = array('class' => 'ai_videodom', 'title_spros' => 'Видеодомофон', 'title_predl' =>'Видеодомофон', 'id' => 7);
				 $val['title'] =($tselect==1)?'Видеодомофон':'Видеодомофон';
                array_push($newArr, $val);
                    break;
					case 'i9':
                 $val = array('class' => 'ai_park', 'title_spros' => 'Рядом парк', 'title_predl' =>'Рядом парк', 'id' => 9);
				 $val['title'] =($tselect==1)?'Рядом парк':'Рядом парк';
                array_push($newArr, $val);
                    break;
                case 'i10':
                 $val = array('class' => 'ai_gf', 'title_spros' => 'Gay-friendly/без предрассудков', 'title_predl' =>'Gay-friendly/без предрассудков', 'id' => 10);
				 $val['title'] =($tselect==1)?'Gay-friendly':'Gay-friendly/без предрассудков';
                array_push($newArr, $val);
                    break;
		
            }
 

}


if (count($newArr)==0){
$newArr=false;
}

        //echo ( " вернули count = " . count($params));	
        return $newArr;
    }
}





	

if (!function_exists('getParams')) {

    function getParams($parent_id, $parent_subcat)
    {

//return "GETRAPAMS_HELPER";
//$parent_id = 0 - это значит просто в субкатегории , если есть , то значит 3-го уровня
        $CI =& get_instance();
        $CI->db->order_by("param_id", "ASC");
        //echo ("parent_subcat=" . $parent_subcat);
        if ($parent_id == 0) {
            $CI->db->where('param_subcat', $parent_subcat);
            //$CI->db->where('param_parent', -1);
        } else {
            $CI->db->where('param_parent', $parent_id);
            //$CI->db->where('param_subcat', 0);
        }

        $CI->db->from("board_params");
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            //$result =  false;
            $params = array();

            //echo "-no_param-";
            // echo ( " а при подсчете = " . count($params));

            return $params;
            $pending_id = -1;
        } else {
            // echo "-есть _param-"; 
            $params = array();
            $i = 0;
            foreach ($query->result() as $row) {
                //echo "-$row->param_name-"; 
                $params[$i]["id"] = $row->param_id;
                $params[$i]["name"] = $row->param_name;
                $params[$i]["isparent"] = $row->param_isparent;
                $params[$i]["isnumber"] = $row->param_isnumber;
                $params[$i]["ismain"] = $row->param_ismain;
                $i++;
            }
            //$result = $query->row_array();
        }
        ;
        //echo ( " вернули count = " . count($params));	
        return $params;
    }
}











if (!function_exists('getUIDComplaints')) {

    function getUIDComplaints($uid)
    {

 //echo($uid);
        $CI =& get_instance();
        //$CI->db->order_by("param_id", "ASC");
 
 
          $CI->db->where("c_ad_uid" , $uid);
        $CI->db->from("realt_complaints");
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            //$result =  false;
            $str = "";
            return $str;
             
        } else {
            // echo "-есть _param-";
$str ="<div style='border:1px solid red'>";			
            $str .= "Есть жалобы на UID<br>";
            
            foreach ($query->result() as $row) {
			$str .=  $row->c_reason . " (ip " . $row->c_ip. " " . $row->c_date ." " . $row->c_description ." )<br>" ;   
               
            }
			$str .="</div>";
            //$result = $query->row_array();
        }
        ;
        //echo ( " вернули count = " . count($params));	
        return $str;
    }
}


if (!function_exists('attributeSearch')) {
function attributeSearch($array, $v_key, $v_value)
 {
foreach ($array as $k=>$v){
      if($v[$v_key] == $v_value){
     return $k;
     } 
 }
return FALSE;
 }
}

 

///////////////////////////////////////////////////////
if (!function_exists('dataFromPost')) {

function dataFromPost( ) //  modelfrompost по сути 
    {
$CI =& get_instance();
$user = $CI->connect->get_current_user();
$data=array();
$CI->load->model('realt_ad_model' ,'ad');
$ad = $CI->ad;
$CI->load->library('form_validation'); 
//$CI->load->library('form_validation'); 
//$CI->form_validation->set_rules($ad->rules());
//$CI->config->set_item('language','russian');
//$CI->lang->load('russian','russian');
//$CI->form_validation->set_rules('current_password', 'current password', 'trim|min_length[6]');
//$CI->form_validation->set_rules('content', 'Текст объявления', 'trim|min_length[200]');
 
$CI->form_validation->set_rules($ad->rules());



if ($CI->form_validation->run() === TRUE) {
//сохраняем введенные данные (например, в БД)
//..........
//отправляем пользователя на главную страницу
//print_r ($CI->form_validation);
//echo("---yes--");
    //$this->load->view('index');
}
else {
    //$this->load->helper('form');
//echo("==no===");
    //$this->load->view('userdata');
//echo	form_error('content');
//echo   $CI->form_validation->error_string ( );
}
 
 $CI->load->library('realt_validation'); 
 $CI->realt_validation->set_rules($ad->rules2()); 
 if ($CI->realt_validation->run() === TRUE) {
 }
 else {
 // echo   $CI->realt_validation->error_string ( );
 }
 
 
 
foreach($_POST as $key => $value) {
$mkey = attributeSearch($ad->attributeLabels(),  "var", $key);
if ($mkey){
$ad->setdata($mkey, $value);  
}
// echo "POST parameter '$key' has '$value' <br>";
// echo ("$mkey   <br>");
}

//echo('<pre>');
//print_r ($ad->fields);
//echo('</pre>');
return  $ad->fields;
}
}

//////////////////////////////////////////////////////




///////////////////////////////////////////////////////
if (!function_exists('searchCriteriesFromPost')) {

function searchCriteriesFromPost( ) //  modelfrompost по сути 
    {
$CI =& get_instance();
$user = $CI->connect->get_current_user();
$data=array();
$CI->load->model('realt_ad_model' ,'ad');
$ad = $CI->ad;
 ////// Тут валидации нету
 
 
foreach($_POST as $key => $value) {
$mkey = attributeSearch($ad->attributeLabels(),  "var", $key);
if ($mkey){
$ad->setdata($mkey, $value);  
}
// echo "POST parameter '$key' has '$value' <br>";
// echo ("$mkey   <br>");
}

//echo('<pre>');
//print_r ($ad->fields);
//echo('</pre>');
return  $ad->fields;
}
}

//////////////////////////////////////////////////////






if (!function_exists('suggestUserPhones')) {

function suggestUserPhones($user_id)
    {
$CI =& get_instance();
$user = $CI->connect->get_current_user();
if ($user['id_user'] <1) { 


saveLog('vihod.txt', "при подаче вышел из системы="    . $user_id . " ");






return (array(" "));

}


$delim="####";
$str = "";
        $CI->db->where("ad_user" , $user_id);
		//$CI->db->where("ad_show" , 1);
        $CI->db->from("ads");
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
        } else {
            foreach ($query->result() as $row) {
			if (strpos($str, $row->ad_phones . $delim)===false ) { 
			$str .=  $row->ad_phones  . $delim ;
			}
            }
        };
		
		
		$CI->db->where("ad_client" , $user_id);
		//$CI->db->where("ad_show" , 1);
        $CI->db->from("sutki");
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
        } else {
            foreach ($query->result() as $row) {
			if (strpos($str, $row->ad_phones . $delim)===false) { 
			$str .=  $row->ad_phones . $delim ;
			}
            }
        };
		
		
		$CI->db->where("ad_client_id" , $user_id);
		//$CI->db->where("ad_show" , 1);
        $CI->db->from("realt_sutki_pending");
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
        } else {
            foreach ($query->result() as $row) {
			if ( strpos($str, $row->ad_phones . $delim)===false) { 
			$str .=  $row->ad_phones    . $delim ;
			}
            }
        };
		
		
        //echo ( " вернули count = " . count($params));	
		
		if (!strpos($str, $delim)) { 
		  return false;
		}
		$str= trim($str, $delim);
		$phonesArr = explode($delim, $str);
        return $phonesArr;
    }
}





if (!function_exists('getMainPicture')) {
    function getMainPicture($cat, $komnat)
    {
        $mp = "http://neagent.by/themes/neagent_style/assets/images/kvartira.gif";
        if ($cat == 1) {
            switch ($komnat) {
                case '0':
                    $mp = "http://img1.neagent.by/s/icon0k.png";
                    break;
                case '1':
                    $mp = "http://img1.neagent.by/s/icon1k.png";
                    break;
                case '2':
                    $mp = "http://img1.neagent.by/s/icon2k.png";
                    break;
                case '3':
                    $mp = "http://img1.neagent.by/s/icon3k.png";
                    break;
            }
        }
        if ($cat == 3) {
            $mp = "http://img1.neagent.by/s/icon0k.png";

        }


        return $mp;
    }

}


if (!function_exists('generate_password')) {
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
}



if (!function_exists('suggest_invoice_number')) {
    function suggest_invoice_number()
    {
        $CI =& get_instance();
		$CI->db->select('*');

        $CI->db->limit(1);
        $CI->db->from('fin_ipay_zakaz');
		$CI->db->order_by("invoice_number", "desc");
		
		
                $query = $CI->db->get();
        if ($query->num_rows() == 0) {
                  return 10000;  
 
                } else {
				

				foreach ($query->result() as $row) {

				$num= $row->invoice_number;
	     $num=$num+1;
		 return $num;
		
		
		}
		}
		
		
		
		
        
    }
}




if (!function_exists('generate_code')) {
    function generate_code($number) // код для телефона
    {
        $arr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '1', '2', '3', '4', '5', '6', '7', '8', '9', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        // Генерируем пароль
        $pass = "";
        for ($i = 0; $i < $number; $i++) {
            $index = rand(0, count($arr) - 1); // Вычисляем случайный индекс массива
            $pass .= $arr[$index];
        }
        return $pass;
    }
}




if (!function_exists('inBlackList')) {
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
}








if (!function_exists('likeList')) // проверяет нет ли в списке  - то же что и inblacklist только можно подставляь сам лист 
{
    function likeList($str, $configlist)
    {

//echo($str ); 
        //echo($configlist ); 
        $str = "" . trim($str);
        $words = split("\|", trim($configlist));

        for ($i = 0; $i < (count($words)); $i++) {

//echo("вход=". $str .";"); 
//echo("проверка=". strtolower($words[$i]) .";"); 

            if (strlen($words[$i]) > 2) {
//echo("$"); 


                if (strpos(strtolower($str), strtolower($words[$i])) !== false) {
//echo("@"); 	

                    $ip = $_SERVER["REMOTE_ADDR"];
                    $refer = strtolower($_SERVER['HTTP_REFERER']);
                    $CI =& get_instance();
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $CI->load->library('email', $config);
                    $CI->email->set_newline("\r\n");
                    $CI->email->from('dakh@mail.ru');
                    $CI->email->to('dakh@mail.ru');
                    $CI->email->subject('like detected');
                    $CI->email->message('спам=' . $words[$i] . "; текст=" . $str . "; uid=" . $CI->data['user_uid'] . "; ip=" . $ip . "refer=$refer; new_uid=" . $CI->data['new_uid'] . "; uic=" . $CI->data['user_uic']);
                    $CI->email->send();


                    return true;
                }
            }
        }

        return false;


    }
}


if (!function_exists('defaultPrice')) {
    function defaultPrice($currency, $price, $realt_currency_rate)
    {

        switch ($currency) {
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
                $currentCurrRate = 1;
                break;
        }

        $defprice = $currentCurrRate * $price;
        return $defprice;

    }
}


if (!function_exists('userPermissions')) {
    function userPermissions($userid)
    {


        $CI =& get_instance();
//echo($userid); 			 
        $perm = array();
        $CI->db->where('user_id', $userid);
        $CI->db->from("realt_user_limits");
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            //echo("8-"); 
            $perm["moderate_comments"] = 0; // умолчание

        } else {


            foreach ($query->result() as $row) {
                //echo("9-");

                $perm["moderate_comments"] = $row->moderate_comments;
                //echo("5-" . $row->moderate_comments); 		 

            }


        }
        ;

        return $perm;


    }
}


if (!function_exists('modifier_dat2post')) {
    function modifier_dat2post($string)
    {

        $monn = array(
            '',
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря'
        );
        //Разбиваем дату в массив
        $a = preg_split("/[^\d]/", $string);
        $today = date('Ymd');
        $nowyear = date('Y');
        if (($a[0] . $a[1] . $a[2]) == $today) {
            //Если сегодня
            return ("Сегодня в " . $a[3] . ":" . $a[4]);
        } else {
            $b = explode("-", date("Y-m-d"));
            $tom = date("Ymd", mktime(0, 0, 0, $b[1], $b[2] - 1, $b[0]));
            if (($a[0] . $a[1] . $a[2]) == $tom) {
                //Если вчера
                return ("Вчера в " . $a[3] . ":" . $a[4]);
            } else {
                //Если позже
                $mm = intval($a[1]);

                if ($a[0] == $nowyear) {
                    return ($a[2] . " " . $monn[$mm] . " " . $a[3] . ":" . $a[4]);
                } else {
                    return ($a[2] . " " . $monn[$mm] . " " . $a[0] . " " . $a[3] . ":" . $a[4]);
                }


            }
        }


    }
}


if (!function_exists('dateAddDays')) {

    function dateAddDays($datestr, $days)
    { // добавляет к дате дни
        $date_s = $datestr;
        $date = strtotime($date_s);
        $date = $date + ($days * 86400);
        $date_s = date("Y-m-d H:i:s", $date);
        return $date_s;

    }
}


if (!function_exists('getValues')) {

    function getValues($parent_id)
    {
//$parent_id = 0 - это значит просто в субкатегории , если есть , то значит 3-го уровня
        $CI =& get_instance();
        $CI->db->order_by("value_id", "ASC");

        $CI->db->where('parent_id', $parent_id);
        $CI->db->from("board_param_values");
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            //$result =  false;
            return false;
            //echo "-no_value-"; 
            //$pending_id = -1;
        } else {
            //echo "-есть _value-"; 
            $values = array();
            $i = 0;
            foreach ($query->result() as $row) {
                //echo "-$row->param_name-"; 
                $values[$i]["id"] = $row->value_id;
                $values[$i]["name"] = $row->value_text;
                $values[$i]["isparent"] = $row->value_isparent;

                $i++;
            }
            //$result = $query->row_array();
        }
        ;
        return $values;
    }

}


if (!function_exists('getAdDescription')) {
    function getAdDescription($ad_id, $table)
    {
        $CI =& get_instance();
        $CI->db->limit(1);
        $CI->db->where('ad_id', $ad_id);
        $CI->db->from("realt_ad_description");
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            foreach ($query->result() as $row) {
                $description = $row->description;
            }
        }
        ;
        return $description;
    }
}

if (!function_exists('getonlydigits')) {
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
}


if (!function_exists('phoneChecked')) {
    function phoneChecked($num, $user)
    {

        saveLog('verify_phone.txt', "TEST=" . $num . "  " . $user . " ");

        $CI =& get_instance();
        $CI->db->limit(1);
        $CI->db->where('phone', $num);
        $CI->db->where('user_id', $user);
        $CI->db->where('kod_entered >', 0);
        $CI->db->from("realt_phone_verification");
        $query = $CI->db->get();

        saveLog('verify_phone.txt', "TEST2=" . $CI->db->last_query());


        if ($query->num_rows() == 0) {
            return false;
        } else {
            return true;
        }
        ;
    }
}

if (!function_exists('phoneAllowed')) {
    function phoneAllowed($num, $user)
    {

        saveLog('verify_phone.txt', "TEST=" . $num . "  " . $user . " ");

        $CI =& get_instance();
        $CI->db->limit(1);
        $CI->db->where('phone', $num);
        $CI->db->where('user_id', $user);
        $CI->db->where('kod_entered', 1);
        $CI->db->or_where('kod_entered', 2); // Это если не проверен, но при отсутствии денег временно пропущен
        $CI->db->from("realt_phone_verification");
        $query = $CI->db->get();

        saveLog('verify_phone.txt', "TEST2=" . $CI->db->last_query());


        if ($query->num_rows() == 0) {
            return false;
        } else {
            return true;
        }
        ;
    }
}


if (!function_exists('removeExtraExclamations')) {
    function removeExtraExclamations($str)
    {
        $str = str_replace("!!!!", "!", $str);
        $str = str_replace("!!!", "!", $str);
        $str = str_replace("!!", "!", $str);
        $str = str_replace(" !", "!", $str);
        return $str;
    }
}


if (!function_exists('getAdComments')) {
    function getAdComments($adid, $ad_email, $ad_uid, $ad_user, $mlev)
    {
//echo("prol");
        $CI =& get_instance();


        $comments = array();

        $CI->db->from("realt_ads_comments");
        $CI->db->where("comment_ad", $adid);

        if ($mlev != 4) {
            $CI->db->where("comment_show", 1);
        }


        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {

            $i = 0;
            foreach ($query->result() as $row) {
                $text = $row->comment_text;


                $show = $row->comment_show;
                $text = $row->comment_text;
                $date = $row->comment_date;
                $id = $row->comment_id;
                $comment_user = $row->comment_user;

                $isautor = 0;


                $CI->db->select('*');
                $CI->db->where('id_user', $comment_user);

                $CI->db->limit(1);
                $CI->db->from('users');


                $quer = $CI->db->get();
                if ($quer->num_rows() != 0) {
                    foreach ($quer->result() as $row) {

                        $screen_name = $row->screen_name;
                        $email = $row->email;


                        if (strpos($screen_name, "@") > 0) {
                            $end = strpos($screen_name, "@");
                            if ($end > 3) {
                                $screen_name = substr($screen_name, 0, 4) . "...";
                            } else {
                                $screen_name = substr($screen_name, 0, $end);
                            }
                            //$screen_name =substr();
                            //$screen_name = "user ".$comment_user;


                        }

                    }

                }


                if ($ad_email == $email) {
                    $isautor = 1;
                }


                $val = array('text' => $text, 'date' => $date, 'id' => $id, 'comment_user' => $comment_user, 'show' => $show, 'screen_name' => $screen_name, isautor => $isautor);

                array_push($comments, $val);
                $i++;
            }
            //$result = $query->row_array();
        }
        ;


        return $comments;
    }
}


if (!function_exists('adsProlongation')) {
    function adsProlongation()
    {


//echo("prol");
        $CI =& get_instance();
        $autocreate_prolongation_days = (config_item('autocreate_prolongation_days') > 0) ? config_item('autocreate_prolongation_days') : 4; //   
//echo($autocreate_prolongation_days);		
        $CI->db->from("sutki");
        $CI->db->where("ad_show", 1);
        $datest = "DATE_SUB(CURDATE(),INTERVAL $autocreate_prolongation_days DAY) >=ad_enddate";
        $CI->db->where($datest);

        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {

            $i = 0;
            foreach ($query->result() as $row) {
                $ad_id = $row->ad_id;
                $enddate = $row->ad_enddate;

                if (prolongation_created($ad_id, "sutki") == false) {

                    $letter = 'Срок размещения ввашего объявления на neagent.by заканчивается  ' . $enddate . '. ';
                    $letter .= 'Адрес объявления:  http://neagent.by/nasutki/' . $row->ad_url . '. ';
                    $letter .= 'В ближайшее время вам будет сформирован счет и отправлен на email. При отсутствии оплаты объявление будет удалено. ';


                    create_prolongation($ad_id, "sutki", $letter);
                }


                //echo "-$row->param_name-"; 
                //$currency[$i]["id"]=$row->id;
                //$currency[$i]["name"]=$row->name;
                //$currency[$i]["isdefault"]=$row->  isdefault;
                //$currency[$i]["rate"]=$row->  rate;
                $i++;
            }
            //$result = $query->row_array();
        }
        ;
        return  ;
    }
}


if (!function_exists('prolongation_created')) {
    function prolongation_created($ad, $table)
    {
        $CI =& get_instance();
        $CI->db->from("realt_ads_prolongation");
        $CI->db->where("p_ad", $ad);
        $CI->db->where("p_status", '0');
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }
}



if (!function_exists('user_has_different_ads')) {
    function user_has_different_ads($uid, $phone_street )
    {
	//echo("enter_DIFF_ADS");
        $CI =& get_instance();
        $CI->db->from("ads");
        $CI->db->where("ad_uid", $uid);
		$CI->db->where("ad_show", 1);
        //$CI->db->where("p_status", '0');
        $query = $CI->db->get();
		 //echo $CI->db->last_query();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            foreach ($query->result() as $row) {
			if (($row->ad_phones . $row->ad_street)!=$phone_street){
			
			 //echo("!DIFF_ADS");
			//echo($row->ad_phones . $row->ad_street);
			return true;
			}
            }
        }
		return false;

    }
}


if (!function_exists('putModerateAllAds')) {  // отправляет ан модерацию все объявления от юзера но не записывает в автомодерате
    function putModerateAllAds($uid)
    {
// все на модерацию  // кроме поднятых 
        $CI =& get_instance();
        $CI->db->where('ad_show', 1);
        $CI->db->where('ad_up_date', '0000-00-00 00:00:00');
        $CI->db->where('ad_uid', $uid);
        $CI->db->set('ad_pending', 1);
        $CI->db->set('ad_show', 0);
        $CI->db->update('ads');
    }
}


if (!function_exists('create_prolongation')) {
    function create_prolongation($ad, $table, $letter)
    {

// Если счета еще нет, то пишем админу. 
// если счет готов, то создаем пролонгацию


        $CI =& get_instance();
        $nowdate = date("Y-m-d H:i:s");
        $data = array(
            p_ad => $ad,
            p_created => $nowdate,
            p_sent => 0,
            p_table => $table,
        );
        $CI->db->insert('realt_ads_prolongation', $data);


        ///////////////////
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('info@neagent.by');
        $CI->email->to('info@neagent.by');
        $CI->email->subject('Заканчивается срок размещения объявления на neagent.by ');
        $CI->email->message($letter);
        $CI->email->send();
        //Отправка письма. 
        //////////////////


    }
}


if (!function_exists('getlastfilename')) {

    function getlastfilename()
    {
       
            $CI =& get_instance();
        
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
                $CI->db->set('content', $lfn);
                $CI->db->update('realt_settings');
                $i++;
            }
        }
        ;
        return $lfn;
    }

}


if (!function_exists('date_diff')) {
    function date_diff($date1, $date2)
    {
        $diff = strtotime($date2) - strtotime($date1);
        return abs($diff);
    }
}


if (!function_exists('addSpaceAfterComma')) {
    function addSpaceAfterComma($str)
    {
        $str = str_replace(",", ", ", $str);
        $str = str_replace(",  ", ", ", $str);
        $str = str_replace(" ,", ",", $str);

        $str = str_replace(".", ". ", $str);
        $str = str_replace(".  ", ". ", $str);
        $str = str_replace(" .", ".", $str);


        return $str;
    }
}

if (!function_exists('getcoordinates')) {
    function getcoordinates($value)
    {

//$content = file_get_contents("http://geocode-maps.yandex.ru/1.x/?geocode=".$value."&key=ABlMIk0BAAAAFPsVKgIAchtJ0doEiLBrxOxaznCER6RZb7YAAAAAAAAAAAB1lE0vqNVR_jBPUVq7ogDg1I3nqA==");


        $xml = simplexml_load_file("http://geocode-maps.yandex.ru/1.x/?geocode=" . $value . "&key=ABlMIk0BAAAAFPsVKgIAchtJ0doEiLBrxOxaznCER6RZb7YAAAAAAAAAAAB1lE0vqNVR_jBPUVq7ogDg1I3nqA==&results=1"); //Интерпретирует XML-документ в объект


        // Если геокодировать удалось, то записываем в БД

        $found = $xml->GeoObjectCollection->metaDataProperty->GeocoderResponseMetaData->found;

        //echo ("ff=" . $found );

        if ($found > 0) {

            $coords = str_replace(' ', ' ', $xml->GeoObjectCollection->featureMember->GeoObject->Point->pos);
//echo ("cc=" . $coords );
            //$result .= '<tr><td>'.$row['address'].'</td><td>'.$coords.'</td></tr>';
            //mysql_query("UPDATE `{$config['tablename']}` SET coords = '".mysql_real_escape_string($coords)."' WHERE id = {$row['id']}") or die("Ошибка при обновлении данных в таблице: ".mysql_error());

        } else {
            $coords = false;
            //$result .= '<tr style="color:red"><td>'.$row['address'].'</td><td>ошибка</td></tr>';
            //$countGeocodeFault++;
        }


        return $coords;
    }
}


if (!function_exists('getCityName')) {
    function getCityName($cityid, $idarr, $namearr)
    {
        $name = "";
        if (is_array($idarr)) {
            foreach ($idarr as $key => $value) {
                if ($value == $cityid) {
                    $name = $namearr[$key];
                }
            }
        }
        return $name;
    }
}


if (!function_exists('getCityName_in')) {
    function getCityName_in($cityname)
    {
        switch ($cityname) {
            case 'Минск':
            case 'Брест':
            case 'Витебск':
            case 'Новополоцк':
            case 'Могилев':
            case 'Минск':
                $cityname .= "е";
                break;
            case 'Гомель':
                $cityname = "Гомеле";
                break;
            default:
        }
        return $cityname;
    }
}


if (!function_exists('getCity')) {
    function getCity()
    {
        $city = (int)$_COOKIE["region"];
        if ($city == 0) {
            setcookie("region", 1, time() + 3600 * 24 * 30 * 12, "/"); // вроде на год
            $city = 1;
        }
        return $city;
    }
}


if (!function_exists('setRegion')) {
    function setRegion($reg)
    {
        setcookie("region", $reg, time() + 3600 * 24 * 30 * 12, "/"); // вроде на год
        return $city;

    }
}


if (!function_exists('getRegionCSS')) {
    function getRegionCSS($reg)
    {
        switch ($reg) {
            case '1':
                $regionCSS = "background-position: 275px -120px;";
                break;
            case '2':
                $regionCSS = "background-position: 190px -20px;";
                break;
            case '3':
                $regionCSS = "background-position: 130px -200px;";
                break;
            case '4':
                $regionCSS = "background-position: 415px -135px;";
                break;
            case '5':
                $regionCSS = "background-position: 430px -235px;";
                break;
            case '6':
                $regionCSS = "background-position: 160px -105px;";
                break;
                break;
            default:
                $regionName = "minsk";
        }
        return $regionCSS;
    }
}


if (!function_exists('getCurrency')) {


    function getCurrency()
    {
//$parent_id = 0 - это значит просто в субкатегории , если есть , то значит 3-го уровня
        $CI =& get_instance();
        $CI->db->from("board_currency");
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            //$result =  false;
            return false;
            //echo "-no_value-"; 
            //$pending_id = -1;
        } else {
            //echo "-есть _value-"; 
            $currency = array();
            $i = 0;
            foreach ($query->result() as $row) {
                //echo "-$row->param_name-"; 
                $currency[$i]["id"] = $row->id;
                $currency[$i]["name"] = $row->name;
                $currency[$i]["isdefault"] = $row->isdefault;
                $currency[$i]["rate"] = $row->rate;
                $i++;
            }
            //$result = $query->row_array();
        }
        ;
        return $currency;
    }

}


// ------------------------------------------------------------------------

/**
 * Write File
 *
 * Writes data to the file specified in the path.
 * Creates a new file if non-existent.
 *
 * @access    public
 * @param    string    path to file
 * @param    string    file data
 * @return    bool
 */
if (!function_exists('write_file')) {
    function write_file($path, $data, $mode = FOPEN_WRITE_CREATE_DESTRUCTIVE)
    {
        if (!$fp = @fopen($path, $mode)) {
            return FALSE;
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $data);
        flock($fp, LOCK_UN);
        fclose($fp);

        return TRUE;
    }
}

// ------------------------------------------------------------------------

/**
 * Delete Files
 *
 * Deletes all files contained in the supplied directory path.
 * Files must be writable or owned by the system in order to be deleted.
 * If the second parameter is set to TRUE, any directories contained
 * within the supplied base directory will be nuked as well.
 *
 * @access    public
 * @param    string    path to file
 * @param    bool    whether to delete any directories found in the path
 * @return    bool
 */
if (!function_exists('delete_files')) {
    function delete_files($path, $del_dir = FALSE, $level = 0)
    {
        // Trim the trailing slash
        $path = rtrim($path, DIRECTORY_SEPARATOR);

        if (!$current_dir = @opendir($path))
            return;

        while (FALSE !== ($filename = @readdir($current_dir))) {
            if ($filename != "." and $filename != "..") {
                if (is_dir($path . DIRECTORY_SEPARATOR . $filename)) {
                    // Ignore empty folders
                    if (substr($filename, 0, 1) != '.') {
                        delete_files($path . DIRECTORY_SEPARATOR . $filename, $del_dir, $level + 1);
                    }
                } else {
                    unlink($path . DIRECTORY_SEPARATOR . $filename);
                }
            }
        }
        @closedir($current_dir);

        if ($del_dir == TRUE AND $level > 0) {
            @rmdir($path);
        }
    }
}

// ------------------------------------------------------------------------

/**
 * Get Filenames
 *
 * Reads the specified directory and builds an array containing the filenames.
 * Any sub-folders contained within the specified path are read as well.
 *
 * @access    public
 * @param    string    path to source
 * @param    bool    whether to include the path as part of the filename
 * @param    bool    internal variable to determine recursion status - do not use in calls
 * @return    array
 */
if (!function_exists('get_filenames')) {
    function get_filenames($source_dir, $include_path = FALSE, $_recursion = FALSE)
    {
        static $_filedata = array();

        if ($fp = @opendir($source_dir)) {
            // reset the array and make sure $source_dir has a trailing slash on the initial call
            if ($_recursion === FALSE) {
                $_filedata = array();
                $source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
            }

            while (FALSE !== ($file = readdir($fp))) {
                if (@is_dir($source_dir . $file) && strncmp($file, '.', 1) !== 0) {
                    get_filenames($source_dir . $file . DIRECTORY_SEPARATOR, $include_path, TRUE);
                } elseif (strncmp($file, '.', 1) !== 0) {
                    $_filedata[] = ($include_path == TRUE) ? $source_dir . $file : $file;
                }
            }
            return $_filedata;
        } else {
            return FALSE;
        }
    }
}

// --------------------------------------------------------------------

/**
 * Get Directory File Information
 *
 * Reads the specified directory and builds an array containing the filenames,
 * filesize, dates, and permissions
 *
 * Any sub-folders contained within the specified path are read as well.
 *
 * @access    public
 * @param    string    path to source
 * @param    bool    whether to include the path as part of the filename
 * @param    bool    internal variable to determine recursion status - do not use in calls
 * @return    array
 */
if (!function_exists('get_dir_file_info')) {
    function get_dir_file_info($source_dir, $include_path = FALSE, $_recursion = FALSE)
    {
        static $_filedata = array();
        $relative_path = $source_dir;

        if ($fp = @opendir($source_dir)) {
            // reset the array and make sure $source_dir has a trailing slash on the initial call
            if ($_recursion === FALSE) {
                $_filedata = array();
                $source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
            }

            while (FALSE !== ($file = readdir($fp))) {
                if (@is_dir($source_dir . $file) && strncmp($file, '.', 1) !== 0) {
                    get_dir_file_info($source_dir . $file . DIRECTORY_SEPARATOR, $include_path, TRUE);
                } elseif (strncmp($file, '.', 1) !== 0) {
                    $_filedata[$file] = get_file_info($source_dir . $file);
                    $_filedata[$file]['relative_path'] = $relative_path;
                }
            }
            return $_filedata;
        } else {
            return FALSE;
        }
    }
}

// --------------------------------------------------------------------

/**
 * Get File Info
 *
 * Given a file and path, returns the name, path, size, date modified
 * Second parameter allows you to explicitly declare what information you want returned
 * Options are: name, server_path, size, date, readable, writable, executable, fileperms
 * Returns FALSE if the file cannot be found.
 *
 * @access    public
 * @param    string    path to file
 * @param    mixed    array or comma separated string of information returned
 * @return    array
 */
if (!function_exists('get_file_info')) {
    function get_file_info($file, $returned_values = array('name', 'server_path', 'size', 'date'))
    {

        if (!file_exists($file)) {
            return FALSE;
        }

        if (is_string($returned_values)) {
            $returned_values = explode(',', $returned_values);
        }

        foreach ($returned_values as $key) {
            switch ($key) {
                case 'name':
                    $fileinfo['name'] = substr(strrchr($file, DIRECTORY_SEPARATOR), 1);
                    break;
                case 'server_path':
                    $fileinfo['server_path'] = $file;
                    break;
                case 'size':
                    $fileinfo['size'] = filesize($file);
                    break;
                case 'date':
                    $fileinfo['date'] = filectime($file);
                    break;
                case 'readable':
                    $fileinfo['readable'] = is_readable($file);
                    break;
                case 'writable':
                    // There are known problems using is_weritable on IIS.  It may not be reliable - consider fileperms()
                    $fileinfo['writable'] = is_writable($file);
                    break;
                case 'executable':
                    $fileinfo['executable'] = is_executable($file);
                    break;
                case 'fileperms':
                    $fileinfo['fileperms'] = fileperms($file);
                    break;
            }
        }

        return $fileinfo;
    }
}

// --------------------------------------------------------------------

/**
 * Get Mime by Extension
 *
 * Translates a file extension into a mime type based on config/mimes.php.
 * Returns FALSE if it can't determine the type, or open the mime config file
 *
 * Note: this is NOT an accurate way of determining file mime types, and is here strictly as a convenience
 * It should NOT be trusted, and should certainly NOT be used for security
 *
 * @access    public
 * @param    string    path to file
 * @return    mixed
 */
if (!function_exists('get_mime_by_extension')) {
    function get_mime_by_extension($file)
    {
        $extension = substr(strrchr($file, '.'), 1);

        global $mimes;

        if (!is_array($mimes)) {
            if (!require_once(APPPATH . 'config/mimes.php')) {
                return FALSE;
            }
        }

        if (array_key_exists($extension, $mimes)) {
            if (is_array($mimes[$extension])) {
                // Multiple mime types, just give the first one
                return current($mimes[$extension]);
            } else {
                return $mimes[$extension];
            }
        } else {
            return FALSE;
        }
    }
}


//
//getULabels  - возвращает лэйбы пользователя. param - это "uid" пока  val  -value того uid
//
//
//


if (!function_exists('getULabels')) {
    function getULabels($param, $val)
    {

        $ul_id = array();
        $ul_name = array();
        $ul_count = array();
        $ul_color = array();
        $al_aid = array();
        $al_lid = array();


        $CI =& get_instance();
        if ($param != "uid") {
            return;
        }


        $CI->db->select('*');
        $CI->db->from('realt_tags');
        if ($param == "uid") {
            $CI->db->where('tag_uid', $val);
        }


//$results=$CI->db->count_all_results();


        $r = 0;

        $query = $CI->db->get();
//echo ($CI->db->last_query());
        if ($query->num_rows() == 0) {
            // echo 'Не найдено меток';
        } else {


            //echo 'Найдены метки'; 

            foreach ($query->result() as $row) {
                array_push($ul_id, $row->tag_id);
                array_push($ul_name, $row->tag_name);
                array_push($ul_color, $row->tag_color);
                $r = $r + 1;
            }
        }

// теперь формируем al_aid и al_lab	 если вобще есть метки у юзера

        //echo(count($ul_id));
        if (count($ul_id) > 0) {

            $CI->db->select('*');
            $CI->db->from('realt_adtags');
            $CI->db->where_in('label_id', $ul_id);
//$results=$CI->db->count_all_results();
            $query = $CI->db->get();
//echo ($CI->db->last_query());
            if ($query->num_rows() == 0) {
            } else {
                foreach ($query->result() as $row) {
                    array_push($al_aid, $row->ad_id);
                    array_push($al_lid, $row->label_id);
                }
            }

        }


        $str = "";
        $str .= "var ul_id = new Array(\"" . implode("\",\"", $ul_id) . "\");";
        $str .= "var ul_name = new Array(\"" . implode("\",\"", $ul_name) . "\");";
        $str .= "var ul_color = new Array(\"" . implode("\",\"", $ul_color) . "\");";

        $str .= "var al_aid = new Array(\"" . implode("\",\"", $al_aid) . "\");";
        $str .= "var al_lid = new Array(\"" . implode("\",\"", $al_lid) . "\");";

        //echo($str); 


        $returnArr = array();
        array_push($returnArr, $str);
        array_push($returnArr, $ul_id);
        array_push($returnArr, $ul_name);
        array_push($returnArr, $ul_color);
        array_push($returnArr, $al_aid);
        array_push($returnArr, $al_lid);
        return $returnArr;


    }
}


if (!function_exists('getAdsWithLabel')) {
    function getAdsWithLabel($label_id)
    { // Возвращает массив объявлений с заданный лэйбом
        $marr = array();
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('realt_adtags');
        $CI->db->where('label_id', $label_id);
        $query = $CI->db->get();
//echo ($CI->db->last_query());
        if ($query->num_rows() == 0) {
            // echo 'Не найдено ';
        } else {


            //echo 'Найдены метки'; 

            foreach ($query->result() as $row) {
                array_push($marr, $row->ad_id);
            }

        }

        return $marr;

    }
}



if (!function_exists('getsitiesFromRegion')) {
    function getSityesFromRegion($regionId)
    {
        $CI =& get_instance();

        $CI->db->from("realt_cityes");
        $CI->db->where('city_region', $regionId);
        $query = $CI->db->get();

        if ($query->num_rows() == 0) {
            $result = "";

        } else {
            $delim = "";
            foreach ($query->result() as $row) {
                $result .= $delim . "" . $row->city_id . "";
                //$realt_cityes_region_array .= $delim . "'" . $row->city_region . "'";
                $delim = ", ";
            }
        }

        return $result;
    }
}


if (!function_exists('cityAdsCount')) {
    function cityAdsCount($id)
    {
        $CI =& get_instance();
		
		$str= "SELECT * FROM `ads` `sutki` WHERE `ad_show`=1  and `ad_city`=" . $id;
		$query = $CI->db->query($str);
		
       // $CI->db->from("ads");
		//$CI->db->from("sutki");
       // $CI->db->where('ad_city', $id);
		//$CI->db->where('ad_show', 1);
        //$query = $CI->db->get();

        if ($query->num_rows() == 0) {
            $result = 0;
        } else {
			$result = $query->num_rows();
        }

		
		
		
		//$CI->db->from("sutki");
      //  $CI->db->where('ad_city', $id);
		//$CI->db->where('ad_show', 1);
       // $query = $CI->db->get();

      //  if ($query->num_rows() == 0) {
            //$result = 0;
      //  } else {
		//	$result = $result + $query->num_rows();
      //  }
		
		
		
		
        return $result;
    }
}



if (!function_exists('refresh_realt_cash')) {
    function refresh_realt_cash()
    {
///////////// список рубрик, подрубрик, городов, улиц, все для realt - основное. 	

        // список городов
        $CI =& get_instance();
        $CI->db->from("realt_cityes");
        $CI->db->where('city_active', 1);
        $query = $CI->db->get();

        if ($query->num_rows() == 0) {
            $result = false;
            $realt_cityes_id_array .= "";
            $realt_cityes_name_array .= "";
            $realt_cityes_uri_array = "";
            $realt_cityes_region_array = "";
        } else {
            $delim = "";
			 $arrdelim = "";
			 $delim2="";
			  $count=0;
            foreach ($query->result() as $row) {
			
			    $adscount=cityAdsCount($row->city_id);
			    $realt_cityes_array .= $arrdelim . "array("  . '"id" => "' . $row->city_id . '", "name" => "' . $row->city_name .
				'", "uri" => "' . $row->city_uri .  
				'", "count" => "' . $adscount . '" )';
				
				$arrdelim = ", ";
				$realt_cityes_index .= $delim2 . '"' . $row->city_id . '"=>"' . $count . '"';
				$delim2 = ", ";
				$count=$count+1;
                $realt_cityes_id_array .= $delim . "" . $row->city_id . "";
				$realt_cityes_count_array .= $delim . "" . $adscount;
                $realt_cityes_name_array .= $delim . "'" . $row->city_name . "'";
                $realt_cityes_uri_array .= $delim . "'" . $row->city_uri . "'";
               // $realt_cityes_region_array .= $delim . "'" . $row->city_region . "'";
                $delim = ", ";
            }
        }





        // список областей
        $CI =& get_instance();
        $CI->db->from("realt_cityes");
        $CI->db->where('city_active', 1);
        $CI->db->where('city_region', -1);
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            $realt_cityes_region_array = "";
        } else {

            $arrdelim = "";
            foreach ($query->result() as $row) {
                $delim = "";
                $realt_cityes_region_array .= $arrdelim . "array( ";
                $realt_cityes_region_array .= $delim . "" . $row->city_id . "";
                $delim = ", ";
                $realt_cityes_region_array .= $delim . getSityesFromRegion($row->city_id);
                $realt_cityes_region_array .= ") ";
                $arrdelim = ", ";
            }
        }
        $realt_cityes_region_array =  $realt_cityes_region_array;














        // список рубрик 


        $CI =& get_instance();
        $CI->db->from("realt_cats");
        $CI->db->where('cat_active', 1);
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            $result = false;
            $catsArr .= "array();";
        } else {
            $delim = "";
            foreach ($query->result() as $row) {


                $catsArr .= $delim . ' array( 
	    "id" => "' . $row->cat_id . '", 
	    "name" => "' . $row->cat_name . '", 
		"uri" => "' . $row->cat_uri . '",
	  ) ';
                $delim = ",";
            }
            $catsArr = "array(" . $catsArr . ");";
        }


        $CI =& get_instance();
        $CI->db->from("realt_subcats");
        $CI->db->where('subcat_active', 1);
        $query = $CI->db->get();

        if ($query->num_rows() == 0) {
            $result = false;
            $subcatsArr .= "array();";
        } else {
            $delim = "";
            foreach ($query->result() as $row) {
//  uri , catname человеческий   , page description  , page keywords ,  short_keywords meta_title meta_description  js_menu

                $subcatsArr .= $delim . ' array( 
	    "id" => "' . $row->subcat_id . '", 
	    "name" => "' . $row->subcat_name . '", 
		"fullname" => "' . $row->subcat_fullname . '" ,
	    "parent" => "' . $row->subcat_parent . '" ,
		"autotitles" => "' . $row->subcat_autotitles . '", 
		"uri" => "' . $row->subcat_uri . '", 
		"table" => "' . $row->subcat_table . '" ,
		"text" => "' . $row->subcat_text . '" ,
		"meta_title" => "' . $row->subcat_meta_title . '" ,
		"meta_keywords" => "' . $row->subcat_meta_keywords . '" ,
		"meta_description" => "' . $row->subcat_meta_description . '" 
	  ) ';
                $delim = ",";

            }
            $subcatsArr = "array(" . $subcatsArr . ");";
        }


/////////// ЗАПИСЬ всего в файл
        $conf = "<?php \n\n";
        $conf .= "\$config['realt_cityes_id'] = array(" . $realt_cityes_id_array . ");\n";
        $conf .= "\$config['realt_cityes_name'] = array(" . $realt_cityes_name_array . ");\n";
        $conf .= "\$config['realt_cityes_uri'] = array(" . $realt_cityes_uri_array . ");\n";
        $conf .= "\$config['realt_cityes_region'] = array(" . $realt_cityes_region_array . ");\n";
		$conf .= "\$config['realt_cityes_array'] = array(" . $realt_cityes_array . ");\n";
		$conf .= "\$config['realt_cityes_index'] = array(" . $realt_cityes_index . ");\n";
		$conf .= "\$config['realt_cityes_count'] = array(" . $realt_cityes_count_array . ");\n";
		 
		
		
        $conf .= "\$config['realt_subcats'] = " . $subcatsArr . "\n";
        $conf .= "\$config['realt_cats'] = " . $catsArr . "\n";
        $conf .= "\n\n";
        $conf .= '/* End of file realtcash.php */' . "\n";
        $conf .= '/* Auto generated by realt Administration on : ' . date('Y.m.d H:i:s') . ' */' . "\n";
        $conf .= '/* Location: ' . $CI->config->item('module_path') . 'Realt/config/realtcash.php */' . "\n";
        $CI->load->helper('file');

        if (!write_file($CI->config->item('module_path') . 'Realt/config/realtcash.php', $conf)) {
            //$CI->error(lang('ionize_message_error_writing_file'));				
        } else {
            //$CI->success(lang('module_realt_message_options_save'));				
        }


    }
}


if (!function_exists('getUserTagsMenu')) {
    function getUserTagsMenu($ul_id_arr, $ul_name_arr, $ul_color_arr, $ul_count_arr)
    {
        $str = "";
        if (count($ul_id_arr) > 0) {


            $str = "Мои метки:<br> ";
            for ($k = 0; $k < count($ul_id_arr); $k++) {
                $str .= "<div class='ng_label' style='background-color:" . $ul_color_arr[$k] . "; color:white;'>
		<a href=\"http://neagent.by/board/label/" . $ul_id_arr[$k] . "\">" . $ul_name_arr[$k] . "(" . $ul_count_arr[$k] . ")</a>
	</div>";

            }

        }


        return $str;

    }
}


if (!function_exists('searchQuery')) {
    function searchQuery($params)
    {


        $sity = (int)$params["sity"];
        $rooms = $params["rooms"];
        $prType = $params["prType"];
        $formType = $params["formType"];
        $priceMin = $params["priceMin"];
        $priceMax = $params["priceMax"];
        $withcontent = $params["withcontent"];
        $postdate = (int)$params["postdate"];
        $cat = (int)$params["cat"];
        $description = array();

        if ($sity == 0) {
            $description['sity'] = "Все города";
        } else {
            $description['sity'] = $sity;
        }


        $table = "ads"; // по умолчанию. на сутки переопределяется ниже 
        switch ($formType . "/" . $prType) {
            case 'kv/arenda':
                $cat_id = 1;
                break;
            case 'kv/snimu':
                $cat_id = 2;
                break;
            case 'kv/prodam':
                $cat_id = 13;
                break;
            case 'kv/kuplu':
                $cat_id = 14;
                break;
            case 'kom/arenda':
                $cat_id = 3;
                break;
            case 'kom/podselenie_pr':
                $cat_id = 9;
                break;
            case 'kom/podselenie_spr':
                $cat_id = 10;
                break;
            case 'su/su_kv':
                $cat_id = 11;
                $table = "sutki";
                break;
            default:
                echo ("");
            case 'kv/arenda':
                $cat_id = 1;
                break;
        }

        if ($cat != 0) {
//echo ("cat-0999");

            $cat_id = $cat;
        }

        if ($cat == 11 || $cat == 12) {
            $table = "sutki";
        }


        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from($table);

        if ($sity != 0) {
            $CI->db->where('ad_city', $sity);
        }


/////////////// Закомментировано районы 

//if (count($arr_values)>0&&count($subarr_values)>0){
//array_push($arr_values, 0);
//array_push($subarr_values, 0);
//$arr_valuesStr=join(",",$arr_values);
//$subarr_valuesStr=join(",",$subarr_values);
//$CI->db->where("(ad_area in ($arr_valuesStr) OR ad_subarea in ($subarr_valuesStr))");
//$CI->db->order_by('ad_area', 'DESC');
//$CI->db->order_by('ad_subarea', 'DESC');
//}


///if (count($arr_values)>0&&count($subarr_values)==0){
//array_push($arr_values, 0);
//$CI->db->where_in('ad_area', $arr_values);
//$CI->db->order_by('ad_area', 'DESC');
//}

//if (count($arr_values)==0&&count($subarr_values)>0){
//array_push($subarr_values, NULL);
//$CI->db->where_in('ad_subarea', $subarr_values);
//$CI->db->order_by('ad_subarea', 'DESC');
//}

        $limit = 30000; /////////////// пока так стоит, но нужно будет передавать
        $from = 0;

        $CI->db->limit($limit, $from);
        $CI->db->where('ad_catid', $cat_id);

        if ($CI->data['mlev'] != 4) {
            $CI->db->where('ad_show', 1);
        }

        $condition = "";
        $cand = "";

        if ($rooms) {
		$roomsall=0;
            if (strpos($rooms, "1") > -1) {
                $condition = $condition . $cand . '`ad_komnat`=1';
                $cand = " or ";$roomsall=$roomsall+1;
            }
            if (strpos($rooms, "2") > -1) {
                $condition = $condition . $cand . '`ad_komnat`=2';
                $cand = " or ";$roomsall=$roomsall+1;
            }
            if (strpos($rooms, "3") > -1) {
                $condition = $condition . $cand . '`ad_komnat`=3';
                $cand = " or ";$roomsall=$roomsall+1;
            }
            if (strpos($rooms, "4") > -1) {
                $condition = $condition . $cand . '`ad_komnat`=4';
                $cand = " or ";$roomsall=$roomsall+1;
            }
            if (strpos($rooms, "0") > -1) {
                $condition = $condition . $cand . '`ad_komnat`=0';
                $cand = " or ";$roomsall=$roomsall+1;
            }
        }
if ($roomsall==5){ // значит все комнаты
$condition = "";
 $cand = "";
}
		
		
		
// Дата 
        if ($postdate != 0) {
            $datest = "DATE_SUB(CURDATE(),INTERVAL $postdate DAY) <=ad_postdate";
            $CI->db->where($datest);
        }


        if ($withcontent != "") {
            $withcontentSQL = "`ad_message` like '%$withcontent%' or `ad_phones` like '%$withcontent%'   or `ad_street` like '%$withcontent%'  or `ad_email` like '%$withcontent%'";
            $CI->db->where("(" . $withcontentSQL . ")");
        }


        if ($table == "ads") {
            if ($priceMin != 0) {
                $CI->db->where('ad_default_price >', $priceMin - 1);
            }
            if ($priceMax != 0) {
                $CI->db->where('ad_default_price <', $priceMax + 1);
            }
        } else {
            if ($priceMin != 0) {
                $CI->db->where('ad_price >', $priceMin - 1);
            }
            if ($priceMax != 0) {
                $CI->db->where('ad_price <', $priceMax + 1);
            }
        }


        $CI->db->where('longitude >', 0);


        if ($condition != "") {
            $CI->db->where('(' . $condition . ')');
        }

        $CI->db->order_by("ad_id", "desc");


        $query = $CI->db->get();
 //$query = 1;
        //echo ($CI->db->last_query());
		
		
		
		
		//$s = serialize($query);
		//$handle = fopen('slow_query_1.log', "a+");
		//echo($this->config->item('module_path'));
		//write_file($this->config->item('module_path') . 'Realt/config/query.txt', $s);
		//write_file('query.txt', $s);
        return $query;


    }
}


if (!function_exists('countLabels')) {
    function countLabels($ul_id_arr, $al_lid_arr)
    {

        $ul_count = array();

        $ul_labela_counded_arr = array_count_values($al_lid_arr);
//print_r($ul_labela_counded_arr);

        for ($k = 0; $k < count($ul_id_arr); $k++) {

            //$count_v - искомое  количество  вхождений 
            $count_v = (int)$ul_labela_counded_arr[$ul_id_arr[$k]];
//echo("<br>");	
            //echo($ul_id_arr[$k]);
            //echo("---" .$count_v);
            array_push($ul_count, $count_v);


        }

        return $ul_count;

    }
}


if (!function_exists('getlabelmark')) {
    function getlabelmark($aid)
    {
        $CI =& get_instance();
// узнать позицию в массиве если есть 
//echo(" - get la");


        $str = "";
        for ($kk = 0; $kk < count($CI->data['al_aid']); $kk++) {


//echo(" k=" . $k);	
            if ($aid == $CI->data['al_aid'][$kk]) {

                $k = $kk;


                // узнать номер лэйбы 
                $l = $CI->data['al_lid'][$k];
                //echo(" l=" . $l);
                $i = array_search($l, $CI->data['ul_id']);

                $str .= "<div class='ng_label' id=\"" . $aid . "_" . $CI->data['ul_id'][$i] . "\"   style=\"background-color:" . $CI->data['ul_color'][$i] . ";color:white;\"> " . $CI->data['ul_name'][$i] . "<a href='' onclick='deleteLabel(\"" . $CI->data['ul_id'][$i] . "\", \"" . $aid . "\");return false;'>×</a></div>";
                //echo  ($str);
            }


        }


        return $str;

    }

}


if (!function_exists('getAdUid')) {
    function getAdUid($ad_id)
    {
        $info = "";
        $CI =& get_instance();
        $CI->db->limit(1, 0);
        $CI->db->where('ad_id', $ad_id);
        $query = $CI->db->get('ads');
        if ($query->num_rows() == 0) {
        }
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {

                $info = $row->ad_uid;

            }
        }
        return $info;
    }
}


if (!function_exists('getAdUpdate')) {
    function getAdUpdate($ad_id)
    {
        $info = "";
        $CI =& get_instance();
        $CI->db->limit(1, 0);
        $CI->db->where('ad_id', $ad_id);
        $query = $CI->db->get('ads');
        if ($query->num_rows() == 0) {
        }
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {

                $info = $row->ad_up_date;

            }
        }
        return $info;
    }
}


if (!function_exists('getClientInfo')) {
    function getClientInfo($user_id)
    {
        $info = array();
        $CI =& get_instance();
        $CI->db->limit(1, 0);
        $CI->db->where('user_id', $user_id);
        $query = $CI->db->get('fin_clients');
        if ($query->num_rows() == 0) {
        }
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $info['id'] = $row->id;
                $info['user_id'] = $row->user_id;
                $info['name'] = $row->firmname;
                $info['unp'] = $row->unp;
                $info['phone'] = $row->phone;
            }
        }
        return $info;
    }
}


/**
 * refresh_vip_cash
 *
 * Эта функция обновляет кэш вип объявлений, которые крутятся на первой странице.
 * Должна вызываться редко, раз в 15 минут, или лучше после обновления объявлений на сутки. или вручную.
 *
 *
 *
 *
 * @access    public
 * @param    string    path to file
 * @return    mixed
 */

if (!function_exists('refresh_vip_cash')) {
    function refresh_vip_cash()
    {
        $CI =& get_instance();
        $CI->db->from("sutki");
        $CI->db->where('ad_type', '1');
        $CI->db->where('ad_show', '1');
        $query = $CI->db->get();
        if ($query->num_rows() == 0) {
            $result = false;
            //if  ($CI->data['mlev']==4){echo ("FALSE refresh_vip_cash;");}


            $conf = "<?php \n\n";
            $conf .= "\$config['sutki_vip_ads'] = array();\n";
            $conf .= "\n\n";
            $conf .= '/* End of file sutkicash.php */' . "\n";
            $conf .= '/* Auto generated by realt Administration on : ' . date('Y.m.d H:i:s') . ' */' . "\n";
            $conf .= '/* Location: ' . $CI->config->item('module_path') . 'Realt/config/sutkicash.php */' . "\n";
            $CI->load->helper('file');
            if (!write_file($CI->config->item('module_path') . 'Realt/config/sutkicash.php', $conf)) {
                //$CI->error(lang('ionize_message_error_writing_file'));				
            } else {
                //$CI->success(lang('module_realt_message_options_save'));				
            }


        } else {
            $sutki_vip_ads = "";
            $delim = "";


            foreach ($query->result() as $row) {

                if ($row->ad_id > 665) {
                    $sutki_vip_ads .= $delim . "'" . $row->ad_url . "%%%" . $row->ad_title . "%%%http://neagent.by/modules/Realt/files/" . $row->ad_mainpic . "'";
                } else {
                    $sutki_vip_ads .= $delim . "'" . $row->ad_url . "%%%" . $row->ad_title . "%%%" . $row->ad_mainpic . "'";
                }

                $delim = ", ";
            }


            $conf = "<?php \n\n";
            $conf .= "\$config['sutki_vip_ads'] = array(" . $sutki_vip_ads . ");\n";
            $conf .= "\n\n";
            $conf .= '/* End of file sutkicash.php */' . "\n";
            $conf .= '/* Auto generated by realt Administration on : ' . date('Y.m.d H:i:s') . ' */' . "\n";
            $conf .= '/* Location: ' . $CI->config->item('module_path') . 'Realt/config/sutkicash.php */' . "\n";
            $CI->load->helper('file');

            if (!write_file($CI->config->item('module_path') . 'Realt/config/sutkicash.php', $conf)) {
                //$CI->error(lang('ionize_message_error_writing_file'));				
            } else {
                //$CI->success(lang('module_realt_message_options_save'));				
            }
        }
    }
}


// Создаёт блок вип-квартир на сутки


if (!function_exists('getSutkiVipBlock')) {
    function getSutkiVipBlock($arr)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/sutkicash.php';

        $SutkiArr = $config['sutki_vip_ads'];
//$SutkiArr=$CI->$config['sutki_vip_ads'];
        $count = sizeof($SutkiArr);

        if ($count == 0) {
            $str = "";
        } else {
            $curr = rand(1, $count) - 1;
//print_r ($SutkiArr);
//echo (  "count=" . $count . $SutkiArr[$curr]);
            $element = explode("%%%", $SutkiArr[$curr]);
            $str = "<h2>$element[1]</h2><a href='http://neagent.by/nasutki/$element[0]'><img src='$element[2]'></a>";
        }

        return $str;

    }
}


if (!function_exists('autoUp')) {
    function autoUp(& $data, & $realt)
    {
        $CI =& get_instance();

        include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/mycash.php';
//// проверяем, есть ли данный uid  в списке 
        $pos = strpos($config['realt_activeuids'], $data['user_uid'] . ";");
        if ($pos > -1) {
//////// ПРОСМОТР АКТИВНЫМ UID
            $last_adid = getLastAdOfUID($data['user_uid']);
            if ($last_adid['lastad_id'] > 1) {
                $pora = date("Y-m-d H:i:s", time() - (15 * 60)); // каждые 15 минуты поднятие
                if (my_date_diff($pora, $last_adid['lastad_postdate']) / 60 > 0) {
// Если прошло более 3 минут с последнего объявления
                    $autoupdate = TRUE;
                    if ($autoupdate == TRUE) {
                        $ad_postdate = date("Y-m-d H:i:s");
                        $CI->db->where("ad_id", $last_adid['lastad_id']);
                        $CI->db->set("ad_postdate", $ad_postdate);
                        $CI->db->update("ads");

                        $realt->data['MESSAGE_FOR_USER'] = "<div style='border:1px solid red; margin-bottom:18px; padding:9px;'><b><font color='red' size=28>ВАШЕ ОБЪЯВЛЕНИЕ АВТОМАТИЧЕСКИ ПОДНЯТО НАВЕРХ</font></b><br>
Если вы сейчас просматриваете сайт, значит  Ваше последнее объявление актуально, 
и оно поднимается в результатах поиска каждые 10-30 минут. Дата объявления заменяется на текущую, как если бы вы подали его только что. 
Это относится только к последнему объявлению, поданному с Вашего компьютера.
<br><br>Пишите свои предложения в <a href='http://neagent.by/gbook'>гостевую книгу</a></div>
";
                    }
                }
            }
        }


    }
}


if (!function_exists('getScenery')) {
    function getScenery(& $data)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/mycash.php';
        $CI =& get_instance();
        $pos = strpos($config['sceneries_uid'], $data['user_uid'] . ";");

//$pos2=strpos($config['sceneries_ip'],  $_SERVER["REMOTE_ADDR"]; .";");
// ай, для всех, т.к текст сложно вычислять. потом
        $pos = 1;

//echo ("pos" . $pos);

        if ($pos > -1) {
//////// ПРОСМОТР АКТИВНЫМ UID
//if  ($this->data['mlev']==4){echo ("просмотр активным  sceneries_uid;");}

            $sceneryArr = getcurrentscenery();
            $sceneryA = $sceneryArr[0]; // массив сценариев
            $sceneryParam = $sceneryArr[1]; // массив параеров к ним 
            $sceneryDescr = $sceneryArr[2]; // массив дескрипшинов к ним 
            $found_text = $sceneryArr[3];
            $data['scenery_descriptions'] = join(" ;", $sceneryDescr);
            $scenery = join(";", $sceneryA);
            $scenery22 = join(";", $sceneryParam);
//$scenery=getcurrentscenery2();
//print_r ($sceneryArr);
//echo ("sceneryuid=" . $uid);
//echo ( 'pos' . strpos(strtolower($scenery), "moderate"));

            if (strpos($scenery . ";", "sendletter") > -1) {
                $data['scenery_sendletter'] = 1;
            }

            if (strpos($scenery . ";", "fakephones") > -1) {
                $data['scenery_fakephones'] = 1;
            }

            if (strpos($scenery . "", "moderate") > -1) {
//echo("##модерация##");
                $data['scenery_moderate'] = 1;
                $data['scenery_descriptions'] = $data['scenery_descriptions'] . " + сценарий-moderate" . $scenery . " " . $scenery22 . " тект=" . $found_text;

            }

            if (strpos($scenery . "", "alert") > -1) {
//echo("##модерация##");
                $data['scenery_alert'] = 1;
//echo("alert");
//$фрукты = array("яблоко", "груша", "слива", "персик", "груша");

                for ($key = 0, $size = count($sceneryA); $key < $size; $key++) {
                    if ($sceneryA[$key] == "alert") {
                        $data['scenery_alert_param'] = $sceneryParam[$key];
                    }
                }


            }


            if (strpos($scenery . ";", "no-up") > -1) {
                $data['scenery_no-up'] = 1;
            }

            if (strpos($scenery . ";", "log") > -1) {


                $data['scenery_log'] = 1;
            }


//if (($this->data['scenery_alert']) && $this->data['scenery_alert']==1){


//}


            if ((isset($data['scenery_sendletter']) )&& $data['scenery_sendletter'] == 1) {
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $CI->load->library('email', $config);
                $CI->email->set_newline("\r\n");
                $CI->email->from('dakh@mail.ru');
                $CI->email->to('dakh@mail.ru');
                $CI->email->subject('Сценарий - отправка письма');
                $CI->email->message('Сценарий=' . $spwords[$i] . ";  " . $str . "; uid=" . $data['user_uid']);
                $CI->email->send();
            }


//$this->saveClientInfoToLog();

            $uic = isset($_COOKIE["uic"])?(int)$_COOKIE["uic"]:0;


       //     if ($data['scenery_log'] == 1 || $uic > 500) {
//  $this->saveClientInfoToLog();  поправить  - пока отключил
       //     }


        }


    }
}

// --------------------------------------------------------------------

/**
 * Symbolic Permissions
 *
 * Takes a numeric value representing a file's permissions and returns
 * standard symbolic notation representing that value
 *
 * @access    public
 * @param    int
 * @return    string
 */
if (!function_exists('symbolic_permissions')) {
    function symbolic_permissions($perms)
    {
        if (($perms & 0xC000) == 0xC000) {
            $symbolic = 's'; // Socket
        } elseif (($perms & 0xA000) == 0xA000) {
            $symbolic = 'l'; // Symbolic Link
        }
        elseif (($perms & 0x8000) == 0x8000) {
            $symbolic = '-'; // Regular
        }
        elseif (($perms & 0x6000) == 0x6000) {
            $symbolic = 'b'; // Block special
        }
        elseif (($perms & 0x4000) == 0x4000) {
            $symbolic = 'd'; // Directory
        }
        elseif (($perms & 0x2000) == 0x2000) {
            $symbolic = 'c'; // Character special
        }
        elseif (($perms & 0x1000) == 0x1000) {
            $symbolic = 'p'; // FIFO pipe
        }
        else {
            $symbolic = 'u'; // Unknown
        }

        // Owner
        $symbolic .= (($perms & 0x0100) ? 'r' : '-');
        $symbolic .= (($perms & 0x0080) ? 'w' : '-');
        $symbolic .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x') : (($perms & 0x0800) ? 'S' : '-'));

        // Group
        $symbolic .= (($perms & 0x0020) ? 'r' : '-');
        $symbolic .= (($perms & 0x0010) ? 'w' : '-');
        $symbolic .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x') : (($perms & 0x0400) ? 'S' : '-'));

        // World
        $symbolic .= (($perms & 0x0004) ? 'r' : '-');
        $symbolic .= (($perms & 0x0002) ? 'w' : '-');
        $symbolic .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x') : (($perms & 0x0200) ? 'T' : '-'));

        return $symbolic;
    }
}

// --------------------------------------------------------------------

/**
 * Octal Permissions
 *
 * Takes a numeric value representing a file's permissions and returns
 * a three character string representing the file's octal permissions
 *
 * @access    public
 * @param    int
 * @return    string
 */
if (!function_exists('octal_permissions')) {
    function octal_permissions($perms)
    {
        return substr(sprintf('%o', $perms), -3);
    }
}


if (!function_exists('getAdidFromCode')) {
    function getAdidFromCode($code)
    {
        $CI =& get_instance();
        $CI->db->where('ad_secretcode', $code);
        $CI->db->from('ads');
        $query = $CI->db->get();

        if ($query->num_rows() == 0) {
            return "-1";
        } else {
            foreach ($query->result() as $row) {
                return $row->ad_id;
            }
        }

    }
}


if (!function_exists('getClientData')) {
    function getClientData($client_id)
    {
        $CI =& get_instance();
        $CI->db->limit(1, 0);
        $CI->db->where('user_id', $client_id);
        $query = $CI->db->get('fin_clients');
        if ($query->num_rows() == 0) {
            $info = "";
        }
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $info['id'] = $row->id;
                $info['firmname'] = $row->firmname;
                $info['unp'] = $row->unp;
                $info['juraddress'] = $row->juraddress;
                $info['postaddress'] = $row->postaddress;
                $info['account'] = $row->account;
                $info['bank'] = $row->bank;
                $info['kod'] = $row->kod;
                $info['phone'] = $row->phone;
            }
        }
        return $info;
    }
}


if (!function_exists('getUserEvc')) {
    function getUserEvc($uid, $mlev)
    {
        $CI =& get_instance();


        if ($mlev != 4) {

            $str .= '		
<script>var val = "' . $uid . '";var ec = new evercookie();
getC(1);
//setTimeout(getC, 500, 1);
function getC(dont)
{	ec.get("evc", function(best, all) {
		document.getElementById("idtag").innerHTML = best;
		if (!best){ setC(); };
		var txt = document.getElementById("cookies");
		//for (var item in all)
		//txt.innerHTML += item + " mechanism: " + (val == all[item] ? "<b>" + all[item] + "</b>" : all[item]) + "<br>";
	}, dont);}

function setC(){
ec.set("evc", val); setTimeout(getC, 1000, 1); }</script> 
';
        } else {
            $str .= '		
<script>var val = "' . $uid . '";var ec = new evercookie();
getC(1);
//setTimeout(getC, 500, 1);
function getC(dont)
{	ec.get("evc", function(best, all) {
		document.getElementById("idtag").innerHTML = best;
		if (!best){ setC(); };
		
		var txt = document.getElementById("cookies");
		for (var item in all)
		txt.innerHTML += item + " mechanism: " + (val == all[item] ? "<b>" + all[item] + "</b>" : all[item]) + "<br>";
	}, dont);}

function setC(){
ec.set("evc", val); setTimeout(getC, 1000, 1); }</script> 
';
        }


        if ($mlev == 4) {
            $str .= "
    Click to create an evercookie. Don't worry, the cookie is a
    random number between 1 and 1000, not enough for me to track
    you, just enough to test evercookies.
    <input type=button value='Click to create an evercookie' onClick=\"document.getElementById('idtag').innerHTML = '*creating*'; document.getElementById('cookies').innerHTML = ''; ec.set('evc', val); setTimeout(getC, 1000, 1); \"> 
    <div id='cookies'></div> 
    Now, try deleting this 'uid' cookie anywhere possible, then
    <input type=button value='Click to rediscover cookies' onClick=\"document.getElementById('idtag').innerHTML = '*checking*'; document.getElementById('cookies').innerHTML = ''; setTimeout(getC, 300);\"> 
      or 
    <input type=button value='Click to rediscover cookies WITHOUT reactivating deleted cookies' onClick=\"document.getElementById('idtag').innerHTML = '*checking*'; document.getElementById('cookies').innerHTML = ''; setTimeout(getC, 300, 1);\"> 
 
";
        }


        $str .= "<span id=\"idtag\" style='display:none;'></span> 
";


        return $str;
    }
}


if (!function_exists('phonespam')) {
    function phonespam($phone, $uid, $ip, $userid)
    {
// блокирует повторную отправку  телефона.
        $CI =& get_instance();


        $CI->db->where('phone', $phone);
        $CI->db->where('kod_entered', 0);
        $CI->db->from('realt_phone_verification');
        $query = $CI->db->get();
        if ($query->num_rows() < 2) {
            return false;
        } else {
            foreach ($query->result() as $row) {
                if ($row->phone == $phone) {
                    if ($row->user_id == $userid) {
                        //$kem= " вами.";
                    } else {

                        //$kem= " другим пользователем.";
                    }

                    return "Ошибка. Если вы не получили смс , напишите администратору " . $kem; // дописать , на этого юзера или на другого 
                }

            }
        }


        $CI->db->where('phone', $phone);
        $CI->db->or_where('uid', $uid);
        $CI->db->or_where('ip', $ip);
        $CI->db->or_where('user_id', $userid);
        $CI->db->from('realt_phone_verification');
        $timeout = date("Y-m-d H:i:s", time() - ((0.5 * 60 * 60))); // полчаса  
        $CI->db->where('date >', $timeout);
        $query = $CI->db->get();
        if ($query->num_rows() < 2) {

        } else {
            foreach ($query->result() as $row) {
                //проверить чтоб не чаще 1 раза в день с uid 
                //чтоб не чаще 1 раза в час с ip 
                //чтоб не чаще 1 раза в час с user 
                if ($row->uid == $uid || $row->ip == $ip || $row->user_id == $userid) {
                    return "Запрещено.";
                }
            }
        }


    }
}


if (!function_exists('checkSecretcode')) {
    function checkSecretcode($data, $code)
    {
        $CI =& get_instance();

        // Тут проверять идату также !!!!!!!! илитеелфон , хоть что-то
        //$CI->db->select('*');
        $CI->db->where('ad_secretcode', $code);
        $rubrics = array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15);
        $CI->db->where_in('ad_catid', $rubrics);
        $CI->db->from('ads');

        $query = $CI->db->get();


        if ($query->num_rows() == 0) {
            return "0";
        } else {


            foreach ($query->result() as $row) {

                //$str .= ($row->ad_firstdate) . " 1--";
                //$str .=  date("Y-m-d H:i:s"). " 0--";
                //$str .= strtotime(now()) . " 2--";
                $dif = my_date_diff(date("Y-m-d H:i:s"), $row->ad_firstdate);
                $diffdays = $dif / 60 / 60 / 24;


                if ($row->ad_pending == 1) {
                    return "2"; // на модерации
                }

                if ($row->ad_show == "0") {
                    return "4"; // не показано, удалено 
                }


              //  if ($diffdays > 15) {
              //     return "3"; // старое очень более 15 дней
              //  }

                return "1"; // свсё ок


            }

        }


        return "Вернул проверку кода";
    }
}


if (!function_exists('http_request')) {
    /**
     * HTTP Request v1.0 by Denik
     * Parametres:
     *     - (string) or (array)[url] - site url
     *     - [method] - POST | GET
     *  - [data] - array of post data
     *  - [port] - connection port
     *  - [timeout] - timeout connection
     *  - [redirect] - true, allow redirects in headers
     *  - [return] - content|headers|array - type of return data, default - content
     **/
    function http_request($params)
    {
        if (!is_array($params)) {
            $params = array(
                'url' => $params,
                'method' => 'GET'
            );
        }

        if ($params['url'] == '') return FALSE;

        if (!isset($params['method'])) $params['method'] = (isset($params['data']) && is_array($params['data'])) ? 'POST' : 'GET';
        $params['method'] = strtoupper($params['method']);
        if (!in_array($params['method'], array('GET', 'POST'))) return FALSE;

        /* Приводим ссылку в правильный вид */
        $url = parse_url($params['url']);
        if (!isset($url['scheme'])) $url['scheme'] = 'http';
        if (!isset($url['path'])) $url['path'] = '/';
        if (!isset($url['host']) && isset($url['path'])) {
            if (strpos($url['path'], '/')) {
                $url['host'] = substr($url['path'], 0, strpos($url['path'], '/'));
                $url['path'] = substr($url['path'], strpos($url['path'], '/'));
            } else {
                $url['host'] = $url['path'];
                $url['path'] = '/';
            }
        }
        $url['path'] = preg_replace("/[\\/]+/", "/", $url['path']);
        if (isset($url['query'])) $url['path'] .= "?{$url['query']}";

        $port = isset($params['port']) ? $params['port']
            : (isset($url['port']) ? $url['port'] : ($url['scheme'] == 'https' ? 443 : 80));

        $timeout = isset($params['timeout']) ? $params['timeout'] : 30;
        if (!isset($params['return'])) $params['return'] = 'content';

        $scheme = $url['scheme'] == 'https' ? 'ssl://' : '';
        $fp = @fsockopen($scheme . $url['host'], $port, $errno, $errstr, $timeout);
        if ($fp) {
            /* Mozilla */
            if (!isset($params['User-Agent'])) $params['User-Agent'] = "Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16";

            $request = "{$params['method']} {$url['path']} HTTP/1.0\r\n";
            $request .= "Host: {$url['host']}\r\n";
            $request .= "User-Agent: {$params['User-Agent']}" . "\r\n";
            $request .= "Connection: close\r\n";
            if ($params['method'] == 'POST') {
                if (isset($params['data']) && is_array($params['data'])) {
                    foreach ($params['data'] AS $k => $v)
                        $data .= urlencode($k) . '=' . urlencode($v) . '&';
                    if (substr($data, -1) == '&') $data = substr($data, 0, -1);
                }
                $data .= "\r\n\r\n";

                $request .= "Content-type: application/x-www-form-urlencoded\r\n";
                $request .= "Content-length: " . strlen($data) . "\r\n";
            }
            $request .= "\r\n";

            if ($params['method'] == 'POST') $request .= $data;

            @fwrite($fp, $request); /* Send request */

            $res = "";
            $headers = "";
            $h_detected = false;
            while (!@feof($fp)) {
                $res .= @fgets($fp, 1024); /* читаем контент */

                /* Проверка наличия загловков в контенте */
                if (!$h_detected && strpos($res, "\r\n\r\n") !== FALSE) {
                    /* заголовки уже считаны - корректируем контент */
                    $h_detected = true;

                    $headers = substr($res, 0, strpos($res, "\r\n\r\n"));
                    $res = substr($res, strpos($res, "\r\n\r\n") + 4);

                    /* Headers to Array */
                    if ($params['return'] == 'headers' || $params['return'] == 'array'
                        || (isset($params['redirect']) && $params['redirect'] == true)
                    ) {
                        $h = explode("\r\n", $headers);
                        $headers = array();
                        foreach ($h as $k => $v) {
                            if (strpos($v, ':')) {
                                $k = substr($v, 0, strpos($v, ':'));
                                $v = trim(substr($v, strpos($v, ':') + 1));
                            }
                            $headers[strtoupper($k)] = $v;
                        }
                    }
                    if (isset($params['redirect']) && $params['redirect'] == true && isset($headers['LOCATION'])) {
                        $params['url'] = $headers['LOCATION'];
                        if (!isset($params['redirect-count'])) $params['redirect-count'] = 0;
                        if ($params['redirect-count'] < 10) {
                            $params['redirect-count']++;
                            $func = __FUNCTION__;
                            return @is_object($this) ? $this->$func($params) : $func($params);
                        }
                    }
                    if ($params['return'] == 'headers') return $headers;
                }
            }

            @fclose($fp);
        } else return FALSE;
        /* $errstr.$errno; */

        if ($params['return'] == 'array') $res = array('headers' => $headers, 'content' => $res);

        return $res;
    }
}


if (!function_exists('saveLog')) {
    function saveLog($filename, $message)
    {
	// config_item('realt_ads_per_page_sutki')
	return;
	
        $CI =& get_instance();
        $uid = $_COOKIE["uid"];
        $uic = $_COOKIE["uic"];
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $page = $_SERVER['QUERY_STRING'];
        $page = $CI->uri->uri_string() . "/" . $page;


        $conf = $message . "; ";

        $conf .= date("Y-m-d H:i:s", time()) . "; uid=" . $uid . "; uic=" . $uic . "; IP=" . $_SERVER["REMOTE_ADDR"] . "; page=" . $page;


        $CI->load->helper('file');
        $string = read_file($CI->config->item('module_path') . 'Realt/config/' . $filename);
        $string .= "\n" . $conf;
        if (!write_file($CI->config->item('module_path') . 'Realt/config/' . $filename, $string)) {
            //echo "-saved";
        }

    }
}






if (!function_exists('AutoTitle')) {
function AutoTitle($table, $cat, $str, $city)
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
    //$cURL = rtrim(trim($cURL));
    //$urlstr = translitIt($cURL);
    //$urlstr = makeUniqueURL($urlstr, $table);


// конец проверить на уникальность url 
//} 


    

    return $c1;
}
}


if (!function_exists('randonPhraze')) {
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
}

/* End of file file_helper.php */
/* Location: ./system/helpers/file_helper.php */
/* Location: ./system/helpers/file_helper.php */