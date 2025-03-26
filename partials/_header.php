<?php
session_start();
echo '<nav class="navbar navbar-expand-lg bg-dark navbar-dark sticky-top">
<div class="container-fluid">
  <a class="navbar-brand" href="/forum">iDiscuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/forum">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="navitem dropdown">
      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      Top Categories
    </a>

        <ul class="dropdown-menu">';
$sql = "SELECT category_name,category_id FROM `categories` LIMIT 5";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
  echo '<li><a class="dropdown-item" href="/forum/threadlist.php?catid=' . $row['category_id'] . '">' . $row['category_name'] . '</a></li>';
}

echo '
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="contact.php">Contact</a>
      </li>
      </ul>';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

  echo '<p class="text-light my-0 fw-bold pe-4 text-center">Welcome ' . $_SESSION['username'] . '</p>
  <form class="d-flex" role="search" method="get" action="search.php">
  <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
  <button class="btn btn-success" type="submit">Search</button>
  </form>';
} else {

  echo '<form class="d-flex" role="search" method="get" action="search.php">
        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
        <button class="btn btn-success" type="submit">Search</button>
        <button class="btn btn-outline-success mx-2" type="button"  data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-outline-success ml-2" type="button"  data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>
        </form>';
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  // echo var_dump($_SESSION['loggedin']);
  echo '<a href="partials/_logout.php" class="btn btn-danger mx-2" type="button" ">Logout</a>';
}
echo '
      
  </div>
</div>
</nav>

';

include '_loginModal.php';
include '_signupModal.php';

if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Success! </strong>You can login now!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
} else if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "false") {
  echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
          Email already exists!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
} else if (isset($_GET['login']) && $_GET['login'] == "false") {
  echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
          Please Enter valid credentials!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
