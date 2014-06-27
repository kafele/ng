<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    // parse an incoming mail 
    // Version 0.5, 2005/03/16 
    // Copyright (c) Frank Rust, TU Braunschweig (f.rust@tu-bs.de) 
    // 
    // This code is free software; you can redistribute it and/or modify 
    // it under the terms of the GNU General Public License as published by 
    // the Free Software Foundation; either version 2 of the License, or 
    // (at your option) any later version. 
    //  
    // This code is distributed in the hope that it will be useful, 
    // but WITHOUT ANY WARRANTY; without even the implied warranty of 
    // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
    // GNU General Public License for more details. 
    //  
    // Since this is a very short Program the GNU General Public License 
    // is not included. Please find it on the website of the Open Software 
    // Foundation at 
    //     http://www.fsf.org/licensing/licenses/lgpl.txt 
    // or write to the Free Software Foundation, Inc., 59 Temple Place,  
    // Suite 330, Boston, MA  02111-1307  USA 
     
    class parseBSB { 
        var $date=""; 
        var $doc=""; 
        var $name=""; 
        var $debet=""; 
        var $credit=""; 
        var $description=""; 
        var $items =false; 
        
		 
		 
        // decode a mail header 
function parseBSB($text="") { 
		
require('modules/Realt/phpQuery/phpQuery/phpQuery.php');
//require('home/vabby/www/neagent.by/modules/Realt/phpQuery/phpQuery/phpQuery/phpQuery.php');
$doc = phpQuery::newDocument($text) ;
$elements = $doc->find('table');
$info = array();

foreach ($elements as $element){ 
 $txt= pq($element)->text();
  if ((strpos($txt, "ВЫПИСКА ПО СЧЕТУ") == false)&& (strpos($txt, "док.№") > -1)) {
       $mytable= pq($element);
       $rows = $mytable->find('tr');
	   $rownum=0;
	   $rowstart=false;
	   foreach ($rows as $row){  //// ПЕРЕБОР ЯЧЕЕК 
	   
	   $rownum= $rownum+1;
	   $rtxt= pq($row)->text();
	   
		// echo("<br> чейка $rownum");
		
		
	   if ((strpos($rtxt, "Входящее сальдо"))&& $rownum==3) {
	   $rowstart=true;   // если был такой текст в третьем ряду то значит это та талица
	   }
	  
	   
	   
	   
	   
		  if ($rowstart==true){
		   
		    $tdc = pq($row)->find('td');
			if (count($tdc) == 8){
			
			$mytablecopy = phpQuery::newDocument(pq($element)->html()) ; //- эта эта таблица 
			$rows2 = $mytablecopy->find('tr');
			$rownum2=0;
		 	foreach ($rows2 as $row2){ 
		 	$rownum2= $rownum2+1;
		 	if  ($rownum2 == $rownum +1 ){
            $rtxt2= pq($row2)->text();
		 	}
		 	}

			
			
//////////////////
			//теперь выцепливаем все данные
			 $date = pq($row)->find('td')->eq(0)->text();
			 $docnum = pq($row)->find('td')->eq(1)->text();
			 $name = pq($row)->find('td')->eq(5)->text();
			 $debet = pq($row)->find('td')->eq(6)->text();
			 $credit = pq($row)->find('td')->eq(7)->text();
			 $description = $rtxt2;
//////////////////////
if ($this->items == false){ 
$this->items = array();
}

		 $data = array(
		  num => $rownum,
                date => $date,
			    docnum => $docnum,
			    name => $name,
			    debet => $debet,
			    credit => $credit,
			    description =>$description,
				sep => "<br>",
        );

		array_push($this->items, $data);	
	
			}

		  
		  }
	   
	   
	   
	   }
	   
   
   
   
   
  }
  else{

  }
  



}


 
  

 
 
 
        } 
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
        // decode a multipart header  
        function multipartHeaders($partid,$mailbody) { 
            $text=substr($mailbody,$this->part[$partid]['start'], 
                         $this->part[$partid]['ende']-$this->part[$partid]['start']); 

            $start=0; 
            $lastheader=""; 
            while (true) { 
                $end=strpos($text,"\n",$start); 
                $line=substr($text,$start,$end-$start); 
                $start=$end+1; 
                if ($line=="") break; // end of headers! 
                if (substr($line,0,1)=="\t") { 
                    $$last.="\n".$line; 
                } 
                if (preg_match("/^(Content-Type:)\s*(.*)$/",$line,$matches)) { 
                    $last="c_t"; 
                    $$last=$matches[2]; 
                } 
                if (preg_match("/^(Content-Transfer-Encoding:)\s*(.*)$/",$line,$matches)) { 
                    $last="c_t_e"; 
                    $$last=$matches[2]; 
                } 
                if (preg_match("/^(Content-Description:)\s*(.*)$/",$line,$matches)) { 
                    $last="c_desc"; 
                    $$last=$matches[2]; 
                } 
                if (preg_match("/^(Content-Disposition:)\s*(.*)$/",$line,$matches)) { 
                    $last="c_disp"; 
                    $$last=$matches[2]; 
                } 
            } 
            if ($c_t_e=="base64") { 
                $this->part[$partid]['content']=base64_decode(substr($text,$start)); 
                $c_t_e="8bit"; 
            } else { 
                $this->part[$partid]['content']=substr($text,$start);     
            } 
            $this->part[$partid]['Content-Type']=$c_t; 
            $this->part[$partid]['Content-Transfer-Encoding']=$c_t_e; 
            $this->part[$partid]['Content-Description']=$c_desc; 
            $this->part[$partid]['Content-Disposition']=$c_disp; 
            unset($this->part[$partid]['start']); 
            unset($this->part[$partid]['ende']); 
        } 
        // we have a multipart message body 
        // split the parts  
        function multipartSplit($boundary,$text) { 
            $start=0; 
            $b_len=strlen("--".$boundary); 
            $partcount=0; 
            while (true) { // should have an emergency exit... 
                $end=strpos($text,"--".$boundary,$start); 
                if (substr($text,$end+$b_len,1)=="\n") { 
                    // '\n' => part boundary 
                    $this->part[$partcount]['start']=$end+$b_len+1; 
                    if ($partcount) {  
                        $this->part[$partcount-1]['ende']=$end-1; 
                        $this->multipartHeaders($partcount-1,$text); 
                    } 
                    $start=$end+$b_len+1; 
                    $partcount++; 
                } else { 
                    // '--' => end boundary 
                    $this->part[$partcount-1]['ende']=$end-1;                 
                    $this->multipartHeaders($partcount-1,$text); 
                    break; 
                } 
            }     
        } 
    }  
   
?>