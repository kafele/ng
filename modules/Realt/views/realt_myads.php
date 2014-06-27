 

<?
//if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	

		
		//$user = $CI->connect->get_current_user();
		//if (($user['group']['group_name'])=='Super Admins'){$this->data['mlev']=4;};
       /// $mlev=$this->data['mlev'] 
		// echo (  $this->data['mlev']);
		//if  ($this->data['mlev']!=4){echo("Сначала войдите"); exit;}
		
		

	
	
		
?>
 

<h2> Поиск объявления по коду</h2>

 
<form action="http://neagent.by/board/access" method="POST" class="checkform"> <input type='hidden' name="act" value="checkuser">
 <br><br>
 
<label>Введите код объявления:</label>
<input type='text' name="code"><br><br>
<label>Введите ваш email:</label>
<input type='text' name="email">
<br><br>

<input type='submit' value = "Найти объявление"><br> 




</form>