<?php
include "partials/_dbconnect.php";

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss - Coding Forums</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'partials/_dbconnect.php'  ?>
    <?php include 'partials/_header.php'  ?>



    <div class="container search my-3" id="ques">
        <h1 class="py-2">Search results for: <em>"<?php echo $_GET['query']; ?>"</em></h1>
        <?php
        $noResult = true;
        $query = $_GET['query'];
        $sql = "SELECT * FROM `threads` WHERE MATCH(thread_title, thread_desc) against ('$query')";

        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_id = $row['thread_id'];
            $url = "thread.php?threadid=".$thread_id;

            echo '<div class="result">
            <h3><a href="'.$url.'" class="text-dark">'.$title.'</a></h3>
            <p>'.$desc.'</p>
        </div>';
        }
        if($noResult){
            echo '
            <div class="p-4 mb-2 bg-body-tertiary rounded-3">
            <h1 class="py-2">No results Found</h1>
                <div class="container-fluid py-3">
                    <p class="col-md-10 fs-5">Suggestions:<ul>

                    <li>Make sure that all words are spelled correctly.</li>
                    <li>Try different keywords.</li>
                    <li>Try more general keywords.</p></li>
                    </ul>
                </div>
            </div>';
        }
        ?>
    </div>

    <?php include "partials/_footer.php" ?>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>