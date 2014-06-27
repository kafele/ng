 <? $CI->load->library('pagination');
$countresults=$CI->db->count_all_results();
$allresults=$countresults;
$config['total_rows'] = $CI->db->count_all_results();
$config['per_page'] =    (config_item('realt_ads_per_page')>0)?config_item('realt_ads_per_page'): 25;   //  выводить на страницу

if ($table == "sutki") {
     $config['per_page'] = (config_item('realt_ads_per_page_sutki') > 0) ? config_item('realt_ads_per_page_sutki') : $config['per_page']; //  выводить на страницу сутки
}



		
		$config['num_links'] = 6;    //  количество ссылок - косметический параметр
		$config['padding'] = 1;
		$config['first_link'] = 'В начало';
		$config['last_link'] = 'В конец';
$limit=$config['per_page'];


if ($this->data['mlev']==4) {
$this->data['debug'] .= $this->db->last_query();
}





if ($countresults==0){
$str_add .= "<br><br><h2>По вашему запросу ничего не найдено</h2> <i>Попробуйте расширить условия поиска.</i>";
$str_searched = "<br><br><h2>По вашему запросу ничего не найдено</h2> <i>Попробуйте расширить условия поиска.</i>";
}
else{
if ($this->data['mlev']==4) {
$str_add .=  "<br><b>" . $str_searched . "</b>";
}
} ?>

