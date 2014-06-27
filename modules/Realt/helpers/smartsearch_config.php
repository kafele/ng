<?php 

$smartsearch['synonims'] =  array(
array("квартирку","квартира"),
array("квартиру","квартира"),
array("сутки","посуточно"),
array("хату","квартира") 
            );

			
$smartsearch['keys'] =  array(
// keyword         param       value          relevant              add 
//ключевое слово                         в процентах   добавлять к существующим 
// параметтрры  
array("квартира",  "object",      "",                  "",    "kvartira" ,           "100"  ,        "1" ),
array("комната",  "object",        "",                 "",    "komnata" ,           "100"  ,        "1" ),
array("недорого",  "pricemax",     "",                 "",       "250" ,           "100"  ,        "0" ),
// слово          что,       от чего зависит,         
array("недорого", "pricemax",    "object",     "kvartira" ,          "250" ,   "100"  , "0" ),
array("недорого", "pricemax",    "object",      "komnata" ,         "120"  ,   "100"  , "0" )

 );



