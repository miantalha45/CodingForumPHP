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

    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $noResult = false;
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];

        $sql2 = "SELECT * FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_name'];
    }
    
    ?>
    <?php
    $showAlert = false;
    $id = $_GET['threadid'];
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == "POST") {
        $comment = $_POST['comment'];
        $comment = str_replace(">", "gt;", $comment);
        $comment = str_replace("<", "lt;", $comment);
        $sno = $_POST['sno'];
        // if ($comment != null) {
            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`) VALUES ('$comment', '$id', '$sno')";
            $result = mysqli_query($conn, $sql);
        // }

        $showAlert = true;
        if ($showAlert && $comment != null) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment has been successfully published!
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
                <h1 class="display-5 fw-bold"><?php echo $title ?> </h1>
                <p class="col-md-10 fs-5"><?php echo $desc ?></p>    
                <hr class="my-4">
                <p>&#x2022;This is a peer to peer forum for knowledge sharing with each other. <br>
                    &#x2022;Be civil. Don\'t post anything that a reasonable person would consider offensive, abusive, or
                    hate
                    speech. <br>
                    &#x2022;Keep it clean. Don\'t post anything obscene or sexually explicit. <br>
                    &#x2022;Respect each other. Don\'t harass or grief anyone, impersonate people, or expose their
                    private
                    information. <br>
                    &#x2022;Respect our forum. <br>
                </p>
                <p>Posted By: <b><em><?php echo $posted_by ?></em></b></p>
            </div>
        </div>
    </div>


    <?php
    echo '<div class="container">';
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '
        <h1 class="py-2">Type a comment</h1>

        <form action="' . $_SERVER["REQUEST_URI"] . '" method="post">
            <div class="mb-3">
                <label for="text">Type a Comment</label>
                <textarea class="form-control my-2" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="' . $_SESSION['sno'] . '">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    ';
    } else {
        echo ' 
        <h1 class="py-2"><b>Type a Comment</b></h1>
        <div class="p-4 mb-2 bg-body-tertiary rounded-3">
            <div class="container-fluid py-3">
                <p class="col-md-10 fs-5">You are not login.Login to be able to type a Comment!</p>
            </div>
        </div>';
    }
    echo '</div>';
    ?>

    <div class="container mb-5" id="ques">
        <h1 class="py-2">Discussions</h1>

        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comm_time'];
            $comment_by = $row['comment_by'];

            $sql2 = "SELECT * FROM `users` WHERE sno='$comment_by'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);


            echo '<div class="d-flex my-3">
            <div class="flex-shrink-0">
                <img src="https://www.pngitem.com/pimgs/m/150-1503945_transparent-user-png-default-user-image-png-png.png"
                    width="54px" class="mr-3" alt="...">
            </div>
            <div class="flex-grow-1 ms-3">
                <div class="media-body">
                <p class="my-0"><b>' . $row2['user_name'] . '</b> At ' . $comment_time . '</p>
                    ' . $content . '
                </div>
            </div>
        </div>';
        }

        if ($noResult) {
            echo ' <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-3">
                <p class="display-5 ">No Comments yet</p>
                <p class="col-md-10 fs-5">Be the first person to comment</p>
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