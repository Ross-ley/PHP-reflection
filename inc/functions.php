<?php
/** random anime defalut when page loads */
function randomAM() {
	$names = array(
		'fukigen-na-mononokean',
		'zettai-shougeki-platonic-heart',
		'rail-wars',
		'haibane-renmei',
		'non-non-biyori',
		'kokkoku',
		'god-eater',
		'monster',
		'persona-5-the-animation',
		'tate-no-yuusha-no-nariagari'
	);
	return $names[rand ( 0 , count($names) -1)];
}

function Anime() {return randomAM();}
$strA="https://kitsu.io/api/edge/anime?filter[text]=". Anime();


$replaced = preg_replace_callback("~([a-z]+)\(\)~", 
	 function ($m){
		  return $m[1]();
	}, $strA
);

/** end of random anime */

	/** random manga defalut when page loads */
	function Manga() {return randomAM();}
	$strM="https://kitsu.io/api/edge/manga?filter[text]=". Manga();


	$replaced = preg_replace_callback("~([a-z]+)\(\)~", 
     	function ($m){
          	return $m[1]();
		}, $strM
	);
		/** end of random manga */