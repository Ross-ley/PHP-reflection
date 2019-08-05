<?php
use function GuzzleHttp\json_encode;
use PHPMailer\PHPMailer\Exception;

// Initialize the session
session_start();
 include('../config.php');
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

$user = $_SESSION['username'];
 
try { 
    $sqlA = "SELECT id FROM animelike WHERE username = ? ";
 
    $userDataA = $pdo->prepare($sqlA);
    $userDataA->bindParam('1', $user, PDO::PARAM_STR);
    $userDataA->execute();
    $idArrayA = $userDataA->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}


try {
    // Find out how many items are in the table
    $stmt = $pdo->prepare('SELECT id FROM mangalike WHERE username = ? ');

    // Bind the query params
    $stmt->bindParam(1 , $user, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        // Define how we want to fetch the results
        $total = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // How many items to list per page
    $limit = 5;
    var_dump($total);
    $results = count($total); echo $results.'<br>'; 
    $resultsTotal = $results / $limit; echo $results.'<br>'; 
    // How many pages will there be
    $pages = ceil($resultsTotal); echo $pages;
    // What page are we currently on?
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    ));
    // Calculate the offset for the query
    $offset = ($page - 1)  * $limit;
    // Some information to display to the user
    $start = $offset + 1;
    $end = $page * $limit;
}
} catch (Exception $e) {
    die;
}
for ($i = $offset; $i < ($offset + $limit); $i++){
    $idArrayM[] = $total[$i]['id'];
}
$count = 0;

$idA = [];
$idM = [];
$imgA = [];
$titleA = [];
$synopsisA = [];
$imgM = [];
$titleM = [];
$synopsisM = [];
$linkTargetA = [];
$linkTargetM = [];
$langs = ['en_jp','en_cn', 'en_kr', 'en_us', 'ja_jp', 'en_th', 'en', ''];

foreach ($idArrayA as $idAnime) {
    $responseA = file_get_contents('https://kitsu.io/api/edge/anime?filter[id]=' . $idAnime['id']);
    $responseA = json_decode($responseA);

    //Anime
    $idA[] = $idAnime['id'];
    $sizes = ['original', 'large', 'small', 'tiny'] ;
    $langs = ['en_jp','ja_jp','en_cn','zh_cn','en_us', '', 'en'];

    $mainTargetA = $responseA->data[0]->attributes;
    $linkTargetA[] = $responseA->data[0]->links;
    foreach ($sizes as $size) {
        if (empty($mainTargetA->posterImage->$size)) {
            if (empty($mainTargetA->coverImage->$size)) {
                // Default image if none found.
                $imgA[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';
                break;

            } elseif (strpos(get_headers($mainTargetA->coverImage->$size, 1)[0], '404')) {
                    //checks if the img has a 404 in its head if it dose then it returns a broken img else it returns the img.
                    $imgA[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';
                    break;
            } else {
                $imgA[] = $mainTargetA->coverImage->$size;
                break;
            }
        } elseif (strpos(get_headers($mainTargetA->posterImage->$size, 1)[0], '404')) {
                //checks if the img has a 404 in its head if it dose then it returns a broken img else it returns the img.
                $imgA[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';
                break;
        } else {
            $imgA[] = $mainTargetA->posterImage->$size;
            break;
        }
    } // end foreach
    foreach ($langs as $lang) {
        if (!empty($mainTargetA->titles->$lang)){
            $titleA[] = $mainTargetA->titles->$lang;
            break;
        } 
        // else {
        // 	$titleA[$i] = "Sorry no Title avalibel";
        // }
    }
    if (empty($synopsisA[] = $mainTargetA->synopsis)) {
        $synopsisA[] = "Sorry there is no blurb";
    }
    /** End */
}
foreach ($idArrayM as $idManga) {
    $responseM = file_get_contents('https://kitsu.io/api/edge/manga?filter[id]=' . $idManga);
    $responseM = json_decode($responseM);

    //Manga
    $idM[] = $idManga;
    $sizes = ['original', 'large', 'small', 'tiny'] ;
    $langs = ['en_jp','ja_jp','en_cn','zh_cn','en_us', '', 'en'];

    $mainTargetM  = $responseM->data[0]->attributes;
    $linkTargetM[] = $responseM->data[0]->links;
    foreach ($sizes as $size) {
        if (empty($mainTargetM->posterImage->$size)) {
            if (empty($mainTargetM->coverImage->$size)) {
                // Default image if none found.
                $imgM[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';
                break;

            } elseif (strpos(get_headers($mainTargetM->coverImage->$size, 1)[0], '404')) {
                    //checks if the img has a 404 in its head if it dose then it returns a broken img else it returns the img.
                    $imgM[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken0-heart-z0VDl3D-600.jpg';
                    break;
            } else {
                $imgM[] = $mainTargetM->coverImage->$size;
                break;
            }
        } elseif (strpos(get_headers($mainTargetM->posterImage->$size, 1)[0], '404')) {
                //checks if the img has a 404 in its head if it dose then it returns a broken img else it returns the img.
                $imgM[] = 'http://atlas-content-cdn.pixelsquid.com/stock-images/broken-heart-z0VDl3D-600.jpg';
                break;
        } else {
            $imgM[] = $mainTargetM->posterImage->$size;
            break;
        }
    } // end foreach
    foreach ($langs as $lang) {
        if (!empty($mainTargetM->titles->$lang)){
            $titleM[] = $mainTargetM->titles->$lang;
            break;
        } 
        // else {
        // 	$titleA[$i] = "Sorry no Title ";
        // }
    }
    if (empty($synopsisM[] = $mainTargetM->synopsis)) {
        $synopsisM[] = "Sorry there is no blurb";
    }
    /** End */
}


// $mainTargetM = 'https://kitsu.io/api/edge/anime?filter[text]=' . $rowA = $q->fetch();
//https://kitsu.io/api/edge/anime?filter[id]=
// https://kitsu.io/api/edge/anime?filter[text]=
// https://kitsu.io/api/edge/manga?filter[text]=

include('../nav-bar.php');
?>
    <div class="container">
        <div id="results" data-url="#">
        <?php 
            $counterA = count($linkTargetM);
            if ($counterA <= 0) {
                echo '<h2> There is so much you can like in the Manga section the more you like the more will show. </h2>';
            } else {
           for($i = 0; $i < 5; $i++) {
        ?>
            <div class="card" >  <!--card 1--> 
	            <div class="img-section">
		            <img class="card-img-top" src="<?php  echo $imgM[$i]; ?>" alt="dummy">
	            </div>
	            <div class="card-body">
		            <h5 class="card-title"><?php echo $titleM[$i]; ?></h5>
		            <p class="card-text"><?php  echo substr($synopsisM[$i], 0, 200)."..."; ?></p>
				    <a href="<?php echo "https://kitsu.io/manga/" . $idM[$i]; ?>" class="btn btn-primary btn-card" target="_blank">View on Kitsu</a>
					<div class="anime">
						<div class="mangaStar">
							<span data-id="<?php echo substr($linkTargetM[$i]->self, 32 ); ?>" class="fa fa-star fa-2x active_star"></span>
						</div>
					</div>
                </div>
           </div>
            <?php }
            ?>
            </div>
            <?php
                    // The "back" link
                    $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
                    // The "forward" link
                    $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
                    // Display the paging information
                    echo '<div id="paging"><p>'. $prevlink. ' Page '. $page. ' of '. $pages. ' pages, displaying '. $start. '-'. $end. ' of '. $results. ' results '. $nextlink. ' </p></div>';
                
                    // Do we have any results?
                    
                        // Display the results
                        for ($i = 1; $i <= $pages; $i++) {
                            echo '<p>'. $i. '</p>';
                        }
            }
            ?>
    <a class="btn back-btn" href="<?php echo '../liked-page.php'?>">Back</a>
    </div>
<?php
    include("../footer.php");
?>