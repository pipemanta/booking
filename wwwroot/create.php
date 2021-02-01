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
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

                <table class='table table-hover table-responsive table-bordered'>

                    <tr>
                        <td>Name</td>
                        <td><input type='text' name='name' class='form-control' /></td>
                    </tr>

                    <tr>
                        <td>Price</td>
                        <td><input type='text' name='price' class='form-control' /></td>
                    </tr>

                    <tr>
                        <td>Description</td>
                        <td><textarea name='description' class='form-control'></textarea></td>
                    </tr>

                    <tr>
                        <td>Category</td>
                        <td>
                            <!-- categories from database will be here -->
                                <?php
                                // read the place categories from the database
                                $results = $category->read();

                                // put them in a select drop-down
                                echo "<select class='form-control' name='category_id'>";
                                echo "<option>Select category...</option>";

                                while ($row_category = $results->fetch(PDO::FETCH_ASSOC)){
                                    extract($row_category);
                                    echo "<option value='{$id}'>{$name}</option>";
                                }

                                echo "</select>";
                                ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Rooms</td>
                        <td><input type='text' name='price' class='form-control' /></td>
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