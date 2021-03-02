<?php
// check if value was posted
if($_POST){

    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/place.php';

    // get database connection
    $database = new Database();
    /** @var PDO $db */
    $db = $database->getConnection();

    // construct empty object of type place with db connection
    $place = new Place($db);

    // set place id to be deleted
    $place->id = $_POST['object_id'];

    // delete the place
    if($place->delete()){
        echo "This place was deleted.";
    }

    // if unable to delete the place
    else{
        echo "Unable to delete this place.";
    }
}
?>