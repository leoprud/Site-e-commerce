<?php
session_start();

	try
		{
		$db = new PDO('mysql:host=localhost;dbname=site_e_commerce;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
	catch (Exception $e)
		{
	    die('Erreur : ' . $e->getMessage());
		}


?>


<!DOCTYPE html>
<html>
	<head>
		<link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="js/index.js"></script>
		<script type="text/javascript" src="js/select_data.js"></script>
	</head>
	<body>
	<div class="container">
	
		<div class="row" id="inscription_connexion">
				<div class="row">

					<div class="col-xs-3"><a href="register.php">Inscription</a></div>
					<div class="col-xs-3"><a href="connect.php">Connexion</a></div>
					<div class="col-xs-3"><a href="conditions.php">Conditions générales de ventes</a></div>
					<div class="col-xs-3"><a href="basket.php">
					<img src="http://www.skeelbox.com/wp-content/uploads/2014/06/panier.png" style=" width:2%;position: fixed; right: 250px; z-index:1;">
					</a>
					</div>

				</div>
		</div><hr>

		<header>
			
	          <ul>
	                <li><a href="index.php"><img src="images/azone.png" alt="logo"></a></li>

	                <li><a href="store.php">SHOP</a></li>

	                <li><a href="basket.php">PANIER</a></li>

	                <li>
	                <a href="store.php">MARQUES</a>
	                    <ul>
	                         <li>
	                         <?php $select=$db->query("SELECT DISTINCT UPPER(brand) AS brand FROM products ORDER BY brand");
	                         		while ($s = $select->fetch(PDO::FETCH_OBJ))
	                         		{
	                         			?>
	                         			<a href="store.php?brand=<?php echo $s->brand; ?>"><?php echo $s->brand; ?></a>
	                         			<?php
	                         		}
	                          ?>	
	                         </li>
	                    </ul>
	                </li>

	                <li><a href="azoneTV.php"><img src="images/azoneTV.png" alt="logo"></a></li> 
	            
	          </ul>
			
		</header> 

