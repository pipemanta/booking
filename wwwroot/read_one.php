<?php
// retrieve one place will be here
    // get ID of the place to be read
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

    // include database and object files
    include_once 'config/database.php';
    include_once 'objects/place.php';
    include_once 'objects/category.php';

    // get database connection
    $database = new Database();
    /** @var PDO $db */
    $db = $database->getConnection();

    // construct empty object on category type with db connection
    $category = new Category($db);

    // construct empty object of type place with db connection
    $place = new Place($db);

    // set ID property of place to be edited
    $place->id = htmlspecialchars(strip_tags($id));

    // read the details of place to be edited
    $place->readOne();

// set page headers
$page_title = "Read One Place";
include_once "libs/php/layout_header.php";

// read places button
echo "<div class='right-button-margin'>
              <a href='index.php' class='btn btn-default pull-right'>Read Places</a>
         </div>";

// HTML table for displaying a place details
echo "<table class='table table-hover table-responsive table-bordered'>";

    echo "<tr>";
        echo "<td>Name</td>";
        echo "<td>{$place->name}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Description</td>";
        echo "<td>{$place->description}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Category</td>";
        echo "<td>";
            // display category name
            $category->id=$place->category_id;
            $category->readName();
            echo $category->name;
        echo "</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Rooms</td>";
        echo "<td>{$place->rooms}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Toilets</td>";
        echo "<td>{$place->toilets}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Price</td>";
        echo "<td>{$place->price}</td>";
    echo "</tr>";

echo "</table>";

// set footer
include_once "libs/php/layout_footer.php";
?>