<?php
/*
$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 1200 //1200 Seconds is 20 Minutes
    )
));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['search'])) {
		$search = urlencode($_POST['search']);
	}
	
	//Anime page search
	// $responseA = file_get_contents("https://kitsu.io/api/edge/anime?filter[text]=" . $search, false, $ctx);
	$responseA = json_decode($responseA);

	//Manga page search
	// $responseM = file_get_contents("https://kitsu.io/api/edge/manga?filter[text]=" . $search, false, $ctx);
	$responseM = json_decode($responseM);



} else {
	//Anime call page lode up
	// $responseA = file_get_contents("https://kitsu.io/api/edge/anime?filter[text]=shokugeki-no-souma", false, $ctx);
	$responseA = json_decode($responseA);

	// var_dump($responseA);
	//Manga call page lode up
	// $responseM = file_get_contents("https://kitsu.io/api/edge/manga?filter[text]=shokugeki-no-souma", false, $ctx);
	$responseM = json_decode($responseM);
	
}
	//Anime

	$mainTargetA = [];
	$imgA = [];
	$titleA = [];
	$synopsisA = [];
	$sizes = ['tiny', 'small', 'large', 'original'];
	$langs = ['en','en_jp','ja_jp','en_cn','zh_cn'];

	$urlM = 'https://media.kitsu.io/manga/poster_images/53941/tiny.jpg?1535807199'; // this is a test link for the code.
	$urlB ='https://media.kitsu.io/manga/cover_images/1554/tiny.jpg?1431740482';

	$yolo = get_headers($urlM, 1); 

	for($i = 0; $i < 5; $i++) {
		$mainTargetA[] = $responseA->data[$i]->attributes;
		foreach ($sizes as $size) {
			if (empty($mainTargetA[$i]->coverImage->$size)) {
				if (empty($mainTargetA[$i]->posterImage->$size)) {
					// Default image if none found.
					echo `<h3>Sorry No image was found</h3>`;
					} else {
						$imgA[] = $mainTargetA[$i]->posterImage->$size;
						break;
					}
				} elseif (strpos($yolo[0], '404')) {
					//checks if the img has a 404 in its head if it dose then it returns a broken img else it returns the img.
					$alt = "sorry image not found";
				} else {
					$imgA[] = $mainTargetA[$i]->coverImage->$size;
					break;
				}
			}
			// foreach ($langs as $lang) {
			// 	if (!empty($mainTargetA[$i]->titles->$lang)) {
					
			// 	$titleA[] = $mainTargetA[$i]->titles->$lang;

			// 	} else {
			// 		// $titleA[] = "Sorry no title could be found.";
			// 		// break;
			// 	}
			// }
		$titleA[] = $mainTargetA[$i]->titles->en_jp;
		$synopsisA[] = $mainTargetA[$i]->synopsis;
	}

	//Manga
	$mainTargetM = [];
	$imgM = [];
	$titleM = [];
	$synopsisM = [];
	$sizes = ['tiny', 'small', 'large', 'original'];
	$langs = ['en','en_jp','en_cn'];

	$urlM = 'https://media.kitsu.io/manga/poster_images/53941/tiny.jpg?1535807199';
	$urlB ='https://media.kitsu.io/manga/cover_images/1554/tiny.jpg?1431740482';

	// var_dump(http_response_code());

	// // Set a response code
	// var_dump(http_response_code(404));
	
	$yolo = get_headers($urlM, 1); 
	 
	// // Get the new response code
	// var_dump(http_response_code());

	for($u = 0; $u < 5; $u++) {
		$mainTargetM[] = $responseM->data[$u]->attributes;
		foreach ($sizes as $size) {
			if (empty($mainTargetM[$u]->coverImage->$size)) {
				if (empty($mainTargetM[$u]->posterImage->$size)) {
					// Default image if none found.
				} elseif (strpos($yolo[0], '404')) {
					//checks if the img has a 404 in its head if it dose then it returns a broken img else it returns the img.
					$alt = "sorry image not found";
				} else {
					$imgM[] = $mainTargetM[$u]->posterImage->$size;
					break;
				}
			} elseif (strpos($yolo[0], '404')) {
				//checks if the img returns a null value if it dose default img shows.
				$alt = 'Sorry no image found';
			} else{
				$imgM[] = $mainTargetM[$u]->coverImage->$size;
				break;
			}
		}
		foreach ($langs as $lang) {
			if (!empty($mainTargetM[$u]->titles->$lang)) {
				
			$titleM[] = $mainTargetM[$u]->titles->$lang;

			} 
		}
		$synopsisM[] = $mainTargetM[$u]->synopsis;
	}
	$alt = 'Sorry image not found.' ;

*/
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
		            	<img class="card-img-top" src="<?php /*echo $imgA[$i];*/ ?>" alt="<?php /*echo $alt*/ ?>">
	            	</div>
	            	<div class="card-body">
		            	<h5 class="card-title"><?php/* echo $titleA[$i];*/ ?></h5>
		            	<p class="card-text"><?php /* echo substr($synopsisA[$i], 0, 200)."...";*/ ?></p>
		            	<a href="<?php  /*echo $response->getUrl();*/ ?>" class="btn btn-primary" target="_blank">View on Kitsu</a>
                	</div>
				</div>
				<?php
					};
				?>
			</div>
				
        	<h2>Manga</h2>
        	<div id="results" class="space">
			<?php
					for($u = 0; $u < 5; $u++) {
				?>
        		<div class="card" >
	        		<div class="img-section">
		        		<img class="card-img-top" src="<?php /*echo $imgM[$u];*/ ?>" alt="<?php /*echo $alt*/ ?>">
	        		</div>
	        		<div class="card-body">
		        		<h5 class="card-title"><?php /* echo $titleM[$u];*/ ?></h5>
		        		<p class="card-text"><?php  /*echo substr($synopsisM[$u], 0, 200)."..."; */?></p>
		        		<a href="<?php // echo $manga1->getUrl(); ?>" class="btn btn-primary" target="_blank">View on Kitsu</a> 
            		</div>
				</div>
				<?php
					};
				?>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>