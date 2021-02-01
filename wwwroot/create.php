<?php
// set page headers //
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


$page_title = "Create place";
include_once "layout_header.php";

?>

<div class='right-button-margin'>
    <a href='index.php' class='btn btn-default pull-right'>Read places</a>
</div>

    <!-- 'create place' html form will be here -->
        <!-- PHP post code will be here -->
            <?php
            // if the form was submitted - PHP OOP CRUD Tutorial
            if($_POST){

                // construct empty object of type place with db connection
                $place = new Place($db);

                $place->name = htmlspecialchars(strip_tags($_POST['name']));
                $place->price = htmlspecialchars(strip_tags($_POST['price']));
                $place->description = htmlspecialchars(strip_tags($_POST['description']));
                $place->category_id = htmlspecialchars(strip_tags($_POST['category_id']));

                // create the place
                $created = $place->create();
                if(is_bool($created) && $created){
                    echo "<div class='alert alert-success'>Place was created.</div>";
                }

                // if unable to create the place, tell the user
                else{
                    echo sprintf("<div class='alert alert-danger'>%s</div>", $created);
                }
            }
            ?>

        <!-- HTML form for creating a place -->
            <?php
            // define variables and set to empty values
//            $nameErr = $descriptionErr = $roomsErr = $toiletsErr = $priceErr = "";
//            $name = $description = $rooms = $toilets = $price = "";
//
//            if ($_SERVER["REQUEST_METHOD"] == "POST") {
//                if (empty($_POST["name"])) {
//                    $nameErr = "Name is required";
//                } else {
//                    $name = test_input($_POST["name"]);
//                }
//                if (empty($_POST["description"])) {
//                    $descriptionErr = "Description is required";
//                } else {
//                    $description = test_input($_POST["description"]);
//                }
//                if (empty($_POST["rooms"])) {
//                    $roomsErr = "Rooms is required";
//                } else {
//                    $rooms = test_input($_POST["rooms"]);
//                }
//                if (empty($_POST["toilets"])) {
//                    $toiletsErr = "Toilets is required";
//                } else {
//                    $toilets = test_input($_POST["toilets"]);
//                }
//                if (empty($_POST["price"])) {
//                    $priceErr = "Price is required";
//                } else {
//                    $price = test_input($_POST["price"]);
//                }
//            }
//
//            function test_input($data) {
//                $data = trim($data);
//                $data = stripslashes($data);
//                $data = htmlspecialchars($data);
//                return $data;
//            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

                <table class='table table-hover table-responsive table-bordered'>

                    <tr>
                        <td>Name</td>
                        <td><input type='text' name='name' class='form-control' required='required' value="<?php echo $_POST['name'];?>" /><span class="error">* <?php echo $nameErr;?></span></td>
                    </tr>

                    <tr>
                        <td>Description</td>
                        <td><textarea name='description' class='form-control' value="<?php echo $_POST['description'];?>" ></textarea></td>
                    </tr>

                    <tr>
                        <td>Category</td>
                        <td>
                            <!-- categories from database will be here -->
                                <?php
                                // read the place categories from the database
                                $results = $category->read();

                                // put them in a select drop-down
                                echo "<select class='form-control' name='category_id' required >";
                                echo "<option value=''>Select category...</option>";

                                while ($row_category = $results->fetch(PDO::FETCH_ASSOC)){
                                    extract($row_category);
                                    echo "<option value='{$id}'>{$name}</option>";
                                }

                                echo "</select>";
                                ?>
                            <span class="error">* <?php echo $roomsErr;?></span>
                        </td>
                    </tr>

                    <tr>
                        <td>Rooms</td>
                        <td><input type='number' name='rooms' class='form-control' required='required' value="<?php echo $_POST['rooms'];?>" /><span class="error">* <?php echo $roomsErr;?></span></td>
                    </tr>

                    <tr>
                        <td>Toilets</td>
                        <td><input type='number' name='toilets' class='form-control' required='required' value="<?php echo $_POST['toilets'];?>" /><span class="error">* <?php echo $toiletsErr;?></span></td>
                    </tr>

                    <tr>
                        <td>Price</td>
                        <td><input type='text' name='price' class='form-control' required='required' value="<?php echo $_POST['price'];?>" /><span class="error">* <?php echo $priceErr;?></span></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </td>
                    </tr>

                </table>
            </form>
<?php

// footer
include_once "layout_footer.php";
?>