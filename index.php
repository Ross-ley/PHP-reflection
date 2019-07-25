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
	$responseA = file_get_contents("https://kitsu.io/api/edge/anime?filter[text]=" . $search);
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
	$langs = ['en','en_jp','ja_jp','en_cn','zh_cn'];

	for($i = 0; $i < 5; $i++) {
		$mainTargetA[] = $responseA->data[$i]->attributes;
		foreach ($sizes as $size) {
			if (empty($mainTargetA[$i]->posterImage->$size)) {
				if (empty($mainTargetA[$i]->coverImage->$size)) {
					// Default image if none found.
					$imgA[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';

				} elseif (strpos(get_headers($mainTargetA[$i]->coverImage->$size, 1)[0], '404')) {
						//checks if the img has a 404 in its head if it dose then it returns a broken img else it returns the img.
						$imgA[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';
				} else {
					$imgA[] = $mainTargetA[$i]->coverImage->$size;
					break;
				}
			} elseif (strpos(get_headers($mainTargetA[$i]->posterImage->$size, 1)[0], '404')) {
					//checks if the img has a 404 in its head if it dose then it returns a broken img else it returns the img.
					$imgA[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';
			} else {
				$imgA[] = $mainTargetA[$i]->posterImage->$size;
				break;
			}
		} // end foreach
		foreach ($langs as $lang) {
			if (empty($mainTargetA[$i]->titles->$lang)) {
				// $titleA[] = "Sorry no title.";
			} else {
				$titleA[] = $mainTargetA[$i]->titles->$lang;
				break;
			}
		}
		if (empty($synopsisA[] = $mainTargetA[$i]->synopsis)) {
			$synopsisA[$i] = "Sorry there is no blurb";
		}
	}

	//Manga
	$mainTargetM = [];
	$imgM = [];
	$titleM = [];
	$synopsisM = [];
	$langs = ['en','en_jp','en_cn', 'en_kr'];

	for($i = 0; $i < 5; $i++) {
		$mainTargetM[] = $responseM->data[$i]->attributes;
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
			if (empty($mainTargetM[$i]->titles->$lang)) {
				//dont populate other wise the it will overwrite the title code/
			} else {
				$titleM[] = $mainTargetM[$i]->titles->$lang;
				break;
			}
		}
		if (empty($synopsisM[] = $mainTargetM[$i]->synopsis)) {
			$synopsisM[$i] = "Sorry there is no blurb";
		}
	}
	$alt = 'Sorry image not found.'; 

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
		            	<a href="<?php  //echo $response->getUrl(); ?>" class="btn btn-primary btn-card" target="_blank">View on Kitsu</a>
                	</div>
				</div>
				<?php
					};
				?>
			</div>
				
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
		        		<a href="<?php // echo $manga1->getUrl(); ?>" class="btn btn-primary btn-card" target="_blank">View on Kitsu</a> 
            		</div>
				</div>
				<?php
					};
				?>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>