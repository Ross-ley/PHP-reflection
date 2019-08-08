<?php 
include("inc/functions.php");

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
		if (empty($synopsisM[] = $mainTargetM[$i]->synopsis)) {
			$synopsisM[$i] = "Sorry there is no blurb";
		}
	}


include('inc/nav-bar.php');
?>
	<?php
		if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	?>
    	<div class="" id="logedIn">
	<?php 
		} else {
	?>
		<div class="Main">
	<?php 
		}
	?>
        <div class="container">
			<?php
			 if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
			?>
			<h1>
				Welcome  <?PHP echo $_SESSION['username']; ?> 
			</h1>
			<?php 
			 } else {
			?>
			<h2>Anime search bar</h2>
			<?php 
			 }
			?>
			<?php
			 if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
			?>
            <form method="post" action="user.php">
			<?php 
			 } else {
			?>
			<form method="post" action="index.php">
			<?php 
			 }
			?>
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
						<a href="<?php  echo "https://kitsu.io/anime/" . substr($linkTargetA[$i]->self, 32); ?>" class="btn btn-primary btn-card" target="_blank">View on Kitsu</a>
						<?php 
							if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
						?>
						<div class="anime">
							<div class="animeStar">
								<span data-id="<?php	echo substr($linkTargetA[$i]->self, 32 ); ?>" class="fa fa-star fa-2x disactive_star"></span>
							</div>
						</div>
						<?php
							}
						?>
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
		        		<a href="<?php  echo "https://kitsu.io/manga" . substr($linkTargetM[$i]->self, 31); ?>" class="btn btn-primary btn-card" target="_blank">View on Kitsu</a> 
					</div>
					<?php 
							if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
						?>
						<div class="manga">
							<div class="mangaStar">
								<span data-id="<?php	echo substr($linkTargetM[$i]->self, 32 ); ?>" class="fa fa-star fa-2x disactive_star"></span>
							</div>
						</div>
						<?php
							}
						?>
				</div>
				<?php
					}
				?>
			</div>
		</div>
		<?php
			if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		?>
			<a href="reset-password.php" class="btn Reset_btn">Reset password</a>
			<div class="user_likeA">
			<a href="anime-fav.php" class="btn anime_btn">Liked Anime</a>
			</div>
			<div class="user_likeM">
			<a href="manga-fav.php" class="btn manga_btn">Liked Manga</a> 
			</div>
		<?php 
			}
		?>
	</div>
<?php include("inc/footer.php"); ?>