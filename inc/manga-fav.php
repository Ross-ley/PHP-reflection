<?php
use function GuzzleHttp\json_encode;
use PHPMailer\PHPMailer\Exception;

// Initialize the session
session_start();
 include('config.php');
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

$user = $_SESSION['username'];



$idM = [];
$imgM = [];
$titleM = [];
$synopsisM = [];
$linkTargetM = [];

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
    $results = count($total);
    $resultsTotal = $results / $limit;
    // How many pages will there be
    $pages = ceil($resultsTotal); 
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

if (isset($total)) {

    for ($i = $offset; $i < ($offset + $limit); $i++){
        if (!empty($total[$i]['id'])) {
            $idArrayM[] = $total[$i]['id'];
        }
    }

    $count = 0;

    foreach ($idArrayM as $idManga) {
        $responseM = file_get_contents('https://kitsu.io/api/edge/manga?filter[id]=' . $idManga);
        $responseM = json_decode($responseM);

        //Manga
        $idM[] = $idManga;
        $sizes = ['original', 'large', 'small', 'tiny'] ;
        $langs = ['en_jp','en_cn', 'en_kr', 'en_us', 'ja_jp', 'en_th', 'en', ''];
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

        }
        if (empty($synopsisM[] = $mainTargetM->synopsis)) {
            $synopsisM[] = "Sorry there is no blurb";
        }
        /** End */
    }
}
include('nav-bar.php');
if (!isset($total)) {
    echo "
        <div class='container max'>    
            <h2> There is so much you can like in the Manga section the more you like the more will show. </h2>
            <a class='btn back-btn' href='user.php'>Back</a>
        </div>
    ";
} else {
?>
    <div class="container">
    <h2 class="header">Liked Manga</h2>
        <div id="results" data-url="#">
        <?php 
           for($i = 0; $i < $counterA; $i++) {
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
                            echo "<span> <a href='manga-fav.php?page=$i'>$i</a> </span>";
                        }
            ?>
    <a class="btn back-btn" href="<?php echo 'user.php'?>">Back</a>
    </div>
<?php
}
    include("footer.php");
?>