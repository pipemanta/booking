<?php
// retrieve one place will be here
    // get ID of the product to be edited
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


// set page header
$page_title = "Update Place";
include_once "libs/php/layout_header.php";

// contents will be here
    echo "<div class='right-button-margin'>
              <a href='index.php' class='btn btn-default pull-right'>Read Places</a>
         </div>";

    ?>
    <!-- 'update place' form will be here -->
        <!-- post code will be here -->
            <?php
            // if the form was submitted
            if($_POST){
            
                // set place property values
                $place->name = strlen($_POST['name'])? htmlspecialchars(strip_tags($_POST['name'])) : null;
                // strlen($_POST['name'])? = empty string are not null by default, just empty string, needs to be defined as null
                $place->description = htmlspecialchars(strip_tags($_POST['description']));
                $place->category_id = htmlspecialchars(strip_tags($_POST['category_id']));
                $place->rooms = htmlspecialchars(strip_tags($_POST['rooms']));
                $place->toilets = htmlspecialchars(strip_tags($_POST['toilets']));
                $place->price = htmlspecialchars(strip_tags($_POST['price']));

                // update the place
                $updated = $place->update();
                if(is_bool($updated) && $updated){
                    $_POST = [];

                    // [] is the same as array() !!!

                    echo "<div class='alert alert-success alert-dismissable'>Place was updated.</div>";
                }

                // if unable to create the place, tell the user
                else{
                    echo sprintf("<div class='alert alert-danger alert-dismissable'>Unable to update place. %s</div>", $updated);
                }
            }
            ?>

        <!-- form will be here -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
                <table class='table table-hover table-responsive table-bordered'>
    
                    <tr>
                        <td>Name</td>
                        <td><input type='text' name='name' class='form-control' required value='<?php echo $place->name; ?>' /><span class="error">*</span></td>
                    </tr>
    
                    <tr>
                        <td>Description</td>
                        <td><textarea name='description' class='form-control'><?php echo $place->description; ?></textarea></td>
                    </tr>
    
                    <tr>
                        <td>Category</td>
                        <td>
                            <!-- categories select drop-down will be here -->
                                <?php
                                // read the place categories from the database
                                $stmt = $category->read();
        
                                // put them in a select drop-down
                                echo "<select class='form-control' name='category_id' required >";
                                echo "<option>Select category...</option>";
                                
                                while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    $category_id=$row_category['id'];
                                    $category_name = $row_category['name'];
        
                                    // current category of the place must be selected
                                    if($place->category_id==$category_id){
                                        echo "<option value='$category_id' selected>";
                                    }else{
                                        echo "<option value='$category_id'>";
                                    }
        
                                    echo "$category_name</option>";
                                }
                                echo "</select>";
                                ?>
                                <span class="error">*</span>
                        </td>
                    </tr>
    
                    <tr>
                        <td>Rooms</td>
                        <td><input type='number' name='rooms' class='form-control' required value='<?php echo $place->rooms; ?>' /><span class="error">* <?php echo $roomsErr;?></span></td>
                    </tr>
    
                    <tr>
                        <td>Toilets</td>
                        <td><input type='number' name='toilets' class='form-control' required value='<?php echo $place->toilets; ?>' /><span class="error">* <?php echo $toiletsErr;?></span></td>
                    </tr>
    
                    <tr>
                        <td>Price</td>
                        <td><input type='text' name='price' class='form-control' required value='<?php echo $place->price; ?>' /><span class="error">* <?php echo $priceErr;?></span></td>
                    </tr>
    
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </td>
                    </tr>
    
                </table>
            </form>

<?php

// set page footer
include_once "libs/php/layout_footer.php";
?>