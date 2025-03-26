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

    <!-- Slider start here -->

    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/carousel-1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/carousel-2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/carousel-3.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <div class="container my-4"  id="ques">
        <h2 class="text-center my-4 fw-bold">iDiscuss - Browse Categories</h2>
        <div class="row my-4">
            <?php $sql = "SELECT * FROM `categories`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                    <div class="col-md-4 my-2">
                        <div class="card" style="width: 18rem;">
                            <img src="https://source.unsplash.com/500x400/?' . $row["category_name"] . ',progrmming" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><a class="text-dark" href="threadlist.php?catid='. $row["category_id"] .'">' . $row["category_name"] . '</a></h5>
                                <p class="card-text">' . substr($row["category_description"],0,90) . '...
                                </p>
                                <a href="threadlist.php?catid='. $row["category_id"] .'" class="btn btn-success">View Thread</a>
                            </div>
                        </div>
                </div>';
            }
            ?>
        </div>
    </div>


    <?php include "partials/_footer.php" ?>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>