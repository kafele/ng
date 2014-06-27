<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$params = array(
'ad_show'=> '0' ,
'ad_pending'=> '1' ,	
'order'=> 'ad_postdate',
'ordertype'=> 'desc'
  );


			
$query= $this->getAds('ads', 0, 10, $params );

//////// обработка 
$alt=0;// начата обработка объявлений 
$adcounter=0;

//echo("modddd");

foreach ($query->result() as $row){

//if ($alt==1){$alt=0;}else{$alt=1;}

$itemalt=($alt==1)?" itemalt" :"";
$addata = array(
'ad_id' => $row->ad_id,
'ad_catid' => $row->ad_catid,
            'ad_title' => $row->ad_title,
            'ad_message' => $row->ad_message,
			'ad_price' => $row->ad_price,
			'ad_currency' => $row->ad_currency,
			'ad_phones' => $row->ad_phones,
			'ad_contactname' => $row->ad_contactname,
			'ad_postdate' => $row->ad_postdate,
			'ad_firstdate' => $row->ad_firstdate,
			'ad_up_date' => $row->ad_up_date,
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
			'ad_uid' => $row->ad_uid,
			'ad_evc' => $row->ad_evc,
			'ad_ip' => $row->ad_ip,
			'ad_cref' => $row->ad_cref,
			'ad_show' => $row->ad_show,
			'ad_pending' => $row->ad_pending,
			'ad_secretcode' => $row->ad_secretcode,
			 'ad_imgtitle' => $this->data['short_keywords'],
			 'ad_imgalt' => $this->data['short_keywords'],
			 'ad_showpolitic' => $row->ad_showpolitic,
			 'ad_confirmed' => $row->m_confirmed,
			 'ad_comments_count' => $row->ad_comments_count,
			 'ad_fakefor' => $row->ad_fakefor
           );
$delayed=false;

$longitude = (float)$row->longitude;
$latitude = (float)$row->latitude;

// замена телефонов
include 'inc_repl_phones.php';

if ($addata['ad_confirmed']!='1'){$addata['ad_email']="" .$addata['ad_email'] . "[?]";}

if ($this->data['labels_flag']==1){
$addata['labels_flag']=1;
$labelmark=getlabelmark($row->ad_id); // возвращает прямо строчку которую нужно вставить 
$addata['labelmark']=$labelmark;}

if (strlen($addata['ad_pictures'])>1) {
$ad_pictures= explode("; ", $addata['ad_pictures']);
$addata['ad_pictures']=$ad_pictures;
$addata['ad_thumbs']=$ad_pictures;
$addata['pic_folder']="http://neagent.by/modules/Realt/files/";
$addata['ad_mainpic']="http://neagent.by/modules/Realt/files/" . "t_".  $ad_pictures[0];
}
else
{ $addata['ad_pictures']=array();
$addata['ad_mainpic']=getMainPicture($addata['ad_catid'], $addata['ad_komnat']); 
}

$addata['show_phones']= config_item('realt_show_phones');
$addata['newpage']= config_item('realt_newpage');

$addata['ad_isup']='';
///////////// Если поднято, установить маркер
if ($addata['ad_up_date']!="0000-00-00 00:00:00"){
///////////// Если удалено уже, то обнулить поднятие
if ($addata['ad_show']==0){
$CI->db->where("ad_id", $row->ad_id);
$CI->db->set("ad_up_date", "0000-00-00 00:00:00");
$CI->db->update("ads");
}
$addata['ad_isup']=' ^';
}



if ($addata['ad_showpolitic']=="true"||$addata['ad_showpolitic']=="combi"||$addata['ad_showpolitic']=="true2"){

   if ($this->data['userstatus']!="active"&&$this->data['userstatus']!="allowed"){
   $addata['ad_phones']="скрыт. <a href='http://neagent.by/board/access'>Как увидеть телефон?</a>";
   }
}





$addata['ad_firstpic']="<img src='". base_url()."themes/neagent_style/assets/images/kvartira.gif' width='60' height='50'  alt='Квартира' />";
// привести дату в нормальный вид
 if (config_item('realt_modify_date')=='1'){$addata['ad_postdate']=modifier_dat2post($addata['ad_postdate']);}//модификатор дат

$addata['ad_komnat_txt']=getKomnatString($addata['ad_komnat']);
$addata['mlev']=$this->data['mlev']; // помечаем админа или кого еще чтобы в объявлении можно было видеть
if (strlen($addata['ad_url'])<2) {$addata['ad_url']=$addata['ad_id'];}
// добавляем у url начало snimu или sdayou
switch ($addata['ad_catid']) {
case '2':
case '4':
case '6':
case '8':
case '10':
$addata['ad_url']="http://neagent.by/snimu/".$addata['ad_url'];
break; 
case '1':
case '3':
case '5':
case '7':
case '11':
$addata['ad_url']="http://neagent.by/sdayu/".$addata['ad_url'];
break;
default:$addata['ad_url']="http://neagent.by/sdayu/".$addata['ad_url'];
 }

if (strlen($addata['sutki_pictures'])>2) {
//imagesArr=split(pictures, ",")
//firstpic="<a rel=""pics_" & strAdId & """ href=""" & "uploads/n_" & imagesArr(0) & """><img src=""uploads/t_" & imagesArr(0)&  """ width=""60"" height=""50""   />" 
//firstpic="<a   href=""default.asp?ad_id=" &  strAdId &"""><img src=""uploads/t_" & imagesArr(0)&  """ width=""60"" height=""60""   />" 
}
 else
{
 $addata['sutki_firstpic']="<img src='". base_url()."themes/neagent_style/assets/images/nopic.gif' width='60' height='50'   />";
// firstpic="<img src=""themes/neagent/images/pic.gif"" width=""60"" height=""50""   />"
} 




$show=1;
if (strlen($addata['ad_fakefor'])>2 && strpos($addata['ad_fakefor'], "UID=")>-1 && strpos($addata['ad_fakefor'], ";") >1){
$fakebeg=strpos($addata['ad_fakefor'], "UID=")+4;
$fakeend=strpos($addata['ad_fakefor'], ";");
$fakeuid=substr($addata['ad_fakefor'],$fakebeg,$fakeend);
$show=0;
if ($fakeuid == $CI->data['user_uid']){$show=1;}
} 


$jcounter=(int)$adcounter-1;
if ($this->data['map_view']==1){ 
$addata['ad_marker']="green_Marker". 1 . ".png"    ;
}



switch ($addata['ad_catid']) {
case '2':case '4':case '6':case '8':case '10':

$str_add2 .= $CI->parser->parse('realt_moderator_ad', $addata);
break; 
case '1':case '3':case '5':case '7':case '11':

$str_add1 .= $CI->parser->parse('realt_moderator_ad', $addata);

break;
default:

$str_add2 .= $CI->parser->parse('realt_moderator_ad', $addata);


 }
 



}
// Обработка всех объявлений закончена


$str_add .=  "<div style='padding:20px; background-color:#cce7cc; margin-bottom:22px;'>";

$str_add .=  "Вы - модератор. Для вас показаны объявления, которые нужно допустить к показу или отклонить. Сначала идут объявления в рубрике СДАЮ. Их нужно прозвонить, и только после этого сделать выбор. Затем показаны объявления из рубрик СНИМУ. Их нужно проверить на наличиесоответствие правилам сайта";

$str_add .=  "<h1>ПРОЗВОНИТЬ!</h1>";
$str_add .=  $str_add1;
 
$str_add .=  "<h1>ПРОСТО ПРОВЕРИТЬ СООТВЕТСТВИЕ ПРАВИЛАМ САЙТА</h1>";
$str_add .=  $str_add2;


$str_add .=  "</div>";



?>
<script>

function sendmoderation(ad, rez){

 //var author = $("#author").val();
       //var message = $("#message").val();
	   
 
	// alert(ad);   
	   
	//  alert( rez);    
      $.ajax({
          type: "POST",
          url: 'http://neagent.by/realt/ad_moderate/',
          data: {"rez": rez, "ad": ad},
          cache: false,
         success: function(response){
              var messageResp = new Array('Ваше сообщение отправлено','Сообщение не отправлено Ошибка базы данных','Нельзя отправлять пустые сообщения');
              var resultStat = messageResp[Number(response)];
              if(response == 0){
                 
              }
              $("#resp").text(resultStat).show().delay(1500).fadeOut(800);
                                                                
                                                }
           });
           return false;

}






</script>

<div id="resp">00</div>




