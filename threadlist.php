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
    <?php include 'partials/_header.php'  ?>
    <?php include 'partials/_dbconnect.php'  ?>

    <?php
    $id = $_GET['catid'];
    // echo $id;
    $sql = "SELECT * FROM `categories` WHERE category_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == "POST") {
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];

        $th_title = str_replace(">", "gt;", $th_title);
        $th_title = str_replace("<", "lt;", $th_title);

        $th_desc = str_replace(">", "gt;", $th_desc);
        $th_desc = str_replace("<", "lt;", $th_desc);

        $sno = $_POST['sno'];
        if ($th_title != null && $th_desc != null) {
            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`) VALUES ('$th_title', '$th_desc', '$id', '$sno')";
            $result = mysqli_query($conn, $sql);
        }
        $showAlert = true;
        if ($showAlert && $th_title != null && $th_desc != null) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread has been successfully added! Please wait for community to response
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        } else {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Warning!</strong> Please enter valid information
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>

    <div class="container my-4">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-4">
                <h1 class="display-5 fw-bold">Welcome to <?php echo $catname; ?> Forums</h1>
                <p class="col-md-10 fs-5"><?php echo $catdesc; ?></p>
                <hr class="my-4">
                <p>&#x2022;This is a peer to peer forum for knowledge sharing with each other. <br>
                    &#x2022;Be civil. Don't post anything that a reasonable person would consider offensive, abusive, or
                    hate
                    speech. <br>
                    &#x2022;Keep it clean. Don't post anything obscene or sexually explicit. <br>
                    &#x2022;Respect each other. Don't harass or grief anyone, impersonate people, or expose their
                    private
                    information. <br>
                    &#x2022;Respect our forum. <br>
                </p>
            </div>
        </div>
    </div>

    <?php
    echo '<div class="container">';
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo ' 
        <h1 class="py-2"><b>Start a Discussion</b></h1>
        
        <form action="' . $_SERVER["REQUEST_URI"] . '" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title as short and crisp as possible.</div>
            </div>
            <div class="mb-3">
                <label for="text">Ellaborate your concern</label>
                <textarea class="form-control my-2" id="desc" name="desc"></textarea>
                <input type="hidden" name="sno" value="' . $_SESSION['sno'] . '">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    ';
    } else {
        echo ' 
        <h1 class="py-2"><b>Start a Discussion</b></h1>
        <div class="p-4 mb-2 bg-body-tertiary rounded-3">
            <div class="container-fluid py-3">
                <p class="col-md-10 fs-5">You are not login.Login to be able to start a Discussion!</p>
            </div>
        </div>';
    }
    echo '</div>';
    ?>


    <div class="container" id="ques">
        <h1 class="py-2"><b>Browse &lt; Questions</b></h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id'];

            $sql2 = "SELECT * FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);


            echo '<div class="d-flex my-3">
            <div class="flex-shrink-0">
                <img src="https://www.pngitem.com/pimgs/m/150-1503945_transparent-user-png-default-user-image-png-png.png"
                    width="54px" class="mr-3" alt="...">
            </div>
            <div class="flex-grow-1 ms-3">
                <div class="media-body">' .
                '<h5 class="mt-0"> <a class="text-dark" href="thread.php?threadid=' . $id . '">' . $title . ' </a></h5>
                ' . $desc . ' </div>' . '<p class="my-0">Asked by: <b>' . $row2['user_name'] . '</b> At ' . $thread_time . '</p>
            </div>
        </div>';
        }
            
        if ($noResult) {
            echo ' <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-3">
                <p class="display-5 ">No Threads Found</p>
                <p class="col-md-10 fs-5">Be the first person to ask a question</p>
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