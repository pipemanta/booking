<?php

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

// retrieve records here
    // include database and object files
    include_once 'config/database.php';
    include_once 'objects/place.php';
    include_once 'objects/category.php';
    include_once 'libs/php/functions.php';

    // instantiate database and objects
    $database = new Database();
    /** @var PDO $db */
    $db = $database->getConnection();

    $place = new Place($db);
    $category = new Category($db);

    // query places
    $stmt = $place->readAll($from_record_num, $records_per_page);
    $num = $stmt->rowCount();

// set page header
$page_title = "Read Places";
include_once "libs/php/layout_header.php";

// contents will be here
    echo "<div class='right-button-margin'>
        <a href='create_place.php' class='btn btn-default pull-right'>Create place</a>
    </div>";

    // display the places if there are any
    if($num>0){

        echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
        echo "<th>Place</th>";
        echo "<th>Description</th>";
        echo "<th>Category</th>";
        echo "<th>Rooms</th>";
        echo "<th>Toilets</th>";
        echo "<th>Price</th>";
        echo "<th>Actions</th>";
        echo "</tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);

            echo "<tr>";
            echo "<td>{$name}</td>";
            echo "<td>";
            echo truncate($description, 50);
            echo "</td>";
            echo "<td>";
            $category->id = $category_id;
            $category->readName();
            echo $category->name;
            echo "</td>";
            echo "<td>{$rooms}</td>";
            echo "<td>{$toilets}</td>";
            echo "<td>{$price}</td>";

            echo "<td>";
            // read one, edit and delete button will be here
            // read, edit and delete buttons
            echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>
                <span class='glyphicon glyphicon-list'></span> Read
            </a>
            <a href='update_place.php?id={$id}' class='btn btn-info left-margin'>
                <span class='glyphicon glyphicon-edit'></span> Edit
            </a>
            <a delete-id='{$id}' class='btn btn-danger delete-object'>
                <span class='glyphicon glyphicon-remove'></span> Delete
            </a>";
            echo "</td>";

            echo "</tr>";

        }

        echo "</table>";

        // paging buttons will be here
            // the page where this paging is used
            $page_url = "index.php?";

            // count all places in the database to calculate total pages
            $total_rows = $place->countAll();

            // paging buttons here
            include_once 'libs/php/paging.php';
    }

    // tell the user there are no places
    else{
        echo "<div class='alert alert-info'>No places found.</div>";
    }

// set page footer
include_once "libs/php/layout_footer.php";
?>