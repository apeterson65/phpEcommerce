<?php

//helper functions



function redirect($location) {

header("Location: $location");

}

function query($sql) {

    global $connection; 
    
    return mysqli_query($connection, $sql) ;       
    
}

function confirm($result){

    global $connection; 
    if(!$result) {

        die("QUERY FAILED " . mysqli_error($connection));

    }
}

function escape_string($string){

    global $connection; 
    return mysqli_real_escape_string($connection, $string);

}

function fetch_array($result) {
    return mysqli_fetch_array($result);
}

//*********************************FRONT END FUNCTIONS *****************************/
//get products

function get_products() {

   $query = query("SELECT * FROM products");

   confirm ($query);

   while($row = fetch_array($query)) {
       
       $product = <<<DELIMITER
            <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <img src="{$row['product_image']}" alt="">
                <div class="caption">
                    <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                    <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                    </h4>
                    
                    <a class="btn btn-primary" target="_blank" href="item.php?id={$row['product_id']}">Add to cart</a>
                </div>
                
            </div>
        </div>
       DELIMITER;
        echo $product;
   }

}

function get_categories() {

    $query =  query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)) {

        $categories_links = <<<DELIMITER
        <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
   DELIMITER;

   echo $categories_links;
       
    }

}

function get_products_in_cat_page() {

    $query = query("SELECT * FROM products WHERE product_category_id" . escape_string($_GET['id']) . " ");
 
    confirm ($query);
 
    while($row = fetch_array($query)) {
        
        $product = <<<DELIMITER
             
             <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                <img src="<?php {$row['product_image']}; ?>" alt="">
                    <div class="caption">
                        <h3>"<?php {$row['product_title']}; ?></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>   
         </div>
        DELIMITER;
         echo $product;
    }
 
 }
//*********************************BACK END FUNCTIONS *****************************/

?>