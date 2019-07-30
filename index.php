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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['search'])) {
		$search = urlencode($_POST['search']);
	}
	if (empty($search)) {
		$search = $strA;
	}

	//Anime page search
	$responseA = file_get_contents("https://kitsu.io/api/edge/anime?filter[text]=" . $search); //"?page[limit]=5&page[offset]=20"
	$responseA = json_decode($responseA);

	//Manga page search
	$responseM = file_get_contents("https://kitsu.io/api/edge/manga?filter[text]=" . $search);
	$responseM = json_decode($responseM);



} else {

	//Anime call page lode up
	$responseA = file_get_contents($strA);
	$responseA = json_decode($responseA);

	// var_dump($responseA);
	//Manga call page lode up
	$responseM = file_get_contents($strM);
	$responseM = json_decode($responseM);

}
	//Anime

	$mainTargetA = [];
	$imgA = [];
	$titleA = [];
	$synopsisA = [];
	$sizes = ['original', 'large', 'small', 'tiny'] ;
	$langs = ['en_jp','ja_jp','en_cn','zh_cn','en_us', '', 'en'];

	for($i = 0; $i < 5; $i++) {
		$mainTargetA[] = $responseA->data[$i]->attributes;
		$linkTargetA[] = $responseA->data[$i]->links;
		foreach ($sizes as $size) {
			if (empty($mainTargetA[$i]->posterImage->$size)) {
				if (empty($mainTargetA[$i]->coverImage->$size)) {
					// Default image if none found.
					$imgA[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';
					break;

				} elseif (strpos(get_headers($mainTargetA[$i]->coverImage->$size, 1)[0], '404')) {
						//checks if the img has a 404 in its head if it dose then it returns a broken img else it returns the img.
						$imgA[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';
						break;
				} else {
					$imgA[] = $mainTargetA[$i]->coverImage->$size;
					break;
				}
			} elseif (strpos(get_headers($mainTargetA[$i]->posterImage->$size, 1)[0], '404')) {
					//checks if the img has a 404 in its head if it dose then it returns a broken img else it returns the img.
					$imgA[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';
					break;
			} else {
				$imgA[] = $mainTargetA[$i]->posterImage->$size;
				break;
			}
		} // end foreach
		foreach ($langs as $lang) {
			if (!empty($mainTargetA[$i]->titles->$lang)){
				$titleA[] = $mainTargetA[$i]->titles->$lang;
				break;
			} 
			// else {
			// 	$titleA[$i] = "Sorry no Title avalibel";
			// }
		}
		if (empty($synopsisA[] = $mainTargetA[$i]->synopsis)) {
			$synopsisA[$i] = "Sorry there is no blurb";
		}
	}

	//Manga
	$mainTargetM = [];
	$linkTargetM = [];
	$imgM = [];
	$titleM = [];
	$synopsisM = [];
	$langs = ['en_jp','en_cn', 'en_kr', 'en_us', 'ja_jp', 'en_th', 'en', ''];

	for($i = 0; $i < 5; $i++) {
		$mainTargetM[] = $responseM->data[$i]->attributes;
		$linkTargetM[] = $responseM->data[$i]->links;
		foreach ($sizes as $size) {
			if (empty($mainTargetM[$i]->posterImage->$size)) {
				if (empty($mainTargetM[$i]->coverImage->$size)) {
					// Default image if none found.
					$imgM[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';

				} elseif (strpos(get_headers($mainTargetM[$i]->coverImage->$size, 1)[0], '404')) {
						//checks if the img has a 404 in its head if it dose then it returns a broken img else it returns the img.
						$imgM[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';
				} else {
					$imgM[] = $mainTargetM[$i]->coverImage->$size;
					break;
				}
			} elseif (strpos(get_headers($mainTargetM[$i]->posterImage->$size, 1)[0], '404')) {
					//checks if the img has a 404 in its head if it dose then it returns a broken img else it returns the img.
					$imgM[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';
			} else {
				$imgM[] = $mainTargetM[$i]->posterImage->$size;
				break;
			}
		} // end foreach
		foreach ($langs as $lang) {
			if (!empty($mainTargetM[$i]->titles->$lang)) {
				$titleM[] = $mainTargetM[$i]->titles->$lang;
				break;
			} 
		}
		// if (!empty($mainTargetM[$i]->titles->$lang)) {
		// 	$titleM[] = $mainTargetM[$i]->titles->$lang;
		// 	break;
		// }else {
		// 	$titleM[] = "Sorry no title avalble";
		// }
		if (empty($synopsisM[] = $mainTargetM[$i]->synopsis)) {
			$synopsisM[$i] = "Sorry there is no blurb";
		}
	}
	
	// // this tests to see if the data array is populated.
	// $targetA = [];
	// $targetM = [];
	// $targetA[] = $responseA->data;
	// $targetM[] = $responseM->data;
	// if (empty($targetA) || empty($targetM)) {
	// 	echo "This should be empty";
	// } else {
	// 	echo "this should be full";
	// }
	// $alt = 'Sorry image not found.'; 

	/** need to remove as these are for test. */

	// var_dump('https://kitsu.io/api/edge/anime?filter[text]=amazing-nurse-nanako');
	//  var_dump('https://kitsu.io/api/edge/anime?filter[text]=amazing-nurse-nanako?page[limit]=5&page[offset]=0');



include 'nav-bar.php';
?>

    <div class="Main">
        <div class="container">
            <h2>Anime search bar</h2>
            <form method="post" action="index.php">
                <input type="text" name="search" placeholder="Search.."/>
                <button type="submit">Search</button>
            </form>
			<br/>
            <h2>Animes</h2>
            <div id="results" data-url="#">
				<?php
					for($i = 0; $i < 5; $i++) {
				?>
            	<div class="card" > <!-- //card 1 -->
	            	<div class="img-section">
		            	<img class="card-img-top" src="<?php echo $imgA[$i]; ?>" alt="<?php echo $alt ?>">
	            	</div>
	            	<div class="card-body">
		            	<h5 class="card-title"><?php echo $titleA[$i]; ?></h5>
		            	<p class="card-text"><?php  echo substr($synopsisA[$i], 0, 200)."..."; ?></p>
		            	<a href="<?php  echo "https://kitsu.io/anime" . substr($linkTargetA[$i]->self, 31); ?>" class="btn btn-primary btn-card" target="_blank">View on Kitsu</a>
                	</div>
				</div>
				<?php
					};
				?>
			</div>
			<!-- <div class="pag">
				<span class="last">
					<a href="<?php $responseA ?>">Previours</a>
				</span>
				<span class="next">
					<a href="<?php $responseA ?>">Next</a>
				</span>
			</div> -->

				
        	<h2>Manga</h2>
        	<div id="results" class="space">
			<?php
					for($i = 0; $i < 5; $i++) {
				?>
        		<div class="card" >
	        		<div class="img-section">
		        		<img class="card-img-top" src="<?php echo $imgM[$i]; ?>" alt="<?php echo $alt ?>">
	        		</div>
	        		<div class="card-body">
		        		<h5 class="card-title"><?php echo $titleM[$i]; ?></h5>
		        		<p class="card-text"><?php  echo substr($synopsisM[$i], 0, 200)."..."; ?></p>
		        		<a href="<?php  echo "https://kitsu.io/manga" . substr($linkTargetM[$i]->self, 31); ?>" class="btn btn-primary btn-card" target="_blank">View on Kitsu</a> 
            		</div>
				</div>
				<?php
					};
				?>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>