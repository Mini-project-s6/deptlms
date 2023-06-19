<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Search Books</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php');?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Search Books</h4>
                </div>
            </div>

            <!-- Search Form -->
            <div class="row">
                <div class="col-md-6">
                    <form method="get" action="search-books.php">
                        <div class="form-group">
                            <input type="text" id="search-input" name="search" class="form-control" placeholder="Search Books" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>


            <div class="row">
                <!-- Display Search Results -->
                <?php
                if (isset($_GET['search'])) {
                    $search = trim($_GET['search']);
                    if (!empty($search)) {
                        $sql = "SELECT * FROM tblbooks WHERE BookName LIKE :search ";
                        $query = $dbh->prepare($sql);
                        $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_ASSOC);

                        if (count($results) > 0) {
                            foreach ($results as $result) {
                                // Display search results here
                                echo "<div class='col-md-4'>";
                                echo "<div class='panel panel-default'>";
                                echo "<div class='panel-heading'>" . $result['BookName'] . "</div>";
                                echo "<div class='panel-body'>";
                                echo "<p>Author: " . $result['Author'] . "</p>";
                                echo "<p>Category: " . $result['Category'] . "</p>";
                                echo "<p>ISBN: " . $result['ISBNNumber'] . "</p>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No results found.</p>";
                        }
                    } else {
                        echo "<p>Please enter a search term.</p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
