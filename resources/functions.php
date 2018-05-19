<?php

 //echo "from functions";
function redirect($value)
{
	# code...
	header("Location: $value");
}

function set_message($m){
  if(!empty($m)){
    $_SESSION["message"] = $m;
  }else{
    $m="";
  }
}

function display_message(){
  if(isset($_SESSION["message"])){
    echo $_SESSION["message"];
    unset($_SESSION["message"]);
  }
}


function query($sql)
{
	global $connection;
	return mysqli_query($connection,$sql);
}

function confirm($result)
{
	if(!$result){
		die("Query Failed : ".mysqli_error($connection));
	}
}

function escape_string($string)
{
	global $connection;
	return mysqli_real_escape_string($connection,$string);
}

function fetch($result){
	return mysqli_fetch_assoc($result);
}

//get products
function get_products(){
	$query = query("SELECT * FROM products;");
	confirm($query);
	while($row = fetch($query)){
		$product = <<<DELIMETER
<div class="col-sm-4 col-lg-4 col-md-4">
               <div class="thumbnail">
                   <a href="item.php?id={$row["product_id"]}"><img src="http://placehold.it/320x150" alt=""></a>
                   <div class="caption">
                       <h4 class="pull-right">&#36;{$row["product_price"]}</h4>
                       <h4><a href="item.php?id={$row["product_id"]}">{$row["product_title"]}</a>
                       </h4>
                       <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                       <a class="btn btn-primary" target="_blank" href="cart.php?add={$row["product_id"]}">Add to cart</a>
                   </div>
               </div>
           </div>
DELIMETER;
        echo $product;
	}
}

function get_categories()
{
$query = query("SELECT * FROM categories;");
confirm($query);
while($row = fetch($query))
{
 $categories_links = <<<DELIMETER2
 <a href='category.php?id={$row["cat_id"]}' class='list-group-item'>{$row['cat_title']}</a>
DELIMETER2;
echo $categories_links;
 }
}

function get_products_in_cat_page()
{
   $query = query("SELECT * FROM products WHERE product_category_id=".escape_string($_GET["id"]).";");
   confirm($query);
   while($row=fetch($query))
   {
   	$product=<<<DELIMETER
       <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="{$row["product_image"]}" alt="">
                    <div class="caption">
                        <h3>{$row["product_title"]}</h3>
                        <p>{$row["short_desc"]}</p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row["product_id"]}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMETER;
echo $product;
   }
}

function get_products_in_shop_page()
{
   $query = query("SELECT * FROM products");
   confirm($query);
   while($row=fetch($query))
   {
   	$product=<<<DELIMETER
       <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="{$row["product_image"]}" alt="">
                    <div class="caption">
                        <h3>{$row["product_title"]}</h3>
                        <p>{$row["short_desc"]}</p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row["product_id"]}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMETER;
echo $product;
   }
}


function login_user(){
  if(isset($_POST["submit"])){
    $u = escape_string($_POST["username"]);
    $p = escape_string($_POST["password"]);
    $query = query("SELECT * FROM users WHERE username = '{$u}' AND password = '{$p}';");
    confirm($query);
    if(mysqli_num_rows($query)==0){
      set_message("Invalid username/password");
      redirect("login.php");
    }else{
      set_message("Welcome to Admin {$u}");
      redirect("admin");
    }
  }
}

function send_message(){
  if(isset($_POST["submit"])){
     $from_name = escape_string($_POST["name"]);
     $subject = escape_string($_POST["subject"]);
     $email = escape_string($_POST["email"]);
     $message = escape_string($_POST["message"]);
     $headers = "From: {$from_name} {$email}";
     $to = "vedanshdwivedi0@gmail.com";

     $result = mail($to, $subject, $message,$headers);
     if($result){
      echo "SENT";
     }else{
      echo "ERROR";
     }
  }
}

?>