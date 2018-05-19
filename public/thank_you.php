<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>
<?php require_once("cart.php"); ?>
<?php
	if(isset($_GET["tx"])){
		$transaction = $_GET["tx"];
		$status = $_GET["st"];
		$currency = $_GET["cc"];
		$amount = $_GET["amt"];

		$query = query("INSERT INTO orders (order_amount,order_transaction,order_status,order_currency)values({$amount},'{$transaction}','{$status}','{$currency}')");
		confirm($query);
		session_destroy();

	}else{
		redirect("index.php");
	}

?>

    <!-- Page Content -->
<div class="container">
	<h1 class="text-center">THANK YOU</h1>
</div><!--/.container-->

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>