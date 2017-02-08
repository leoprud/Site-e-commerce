<link href="../assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>

<?php

require_once('include/header.php');


require_once('include/function.php');


	$erreur=false;

	$action = (isset($_POST['action'])?$_POST['action']:(isset($_GET['action'])?$_GET['action']:null));

	if ($action!=null) 
	{
		if (!in_array($action, array('add', 'delete', 'refresh'))) 
		
			$erreur=true;

			$l = (isset($_POST['l'])?$_POST['l']:(isset($_GET['l'])?$_GET['l']:null));
			$q = (isset($_POST['q'])?$_POST['q']:(isset($_GET['q'])?$_GET['q']:null));
			$p = (isset($_POST['p'])?$_POST['p']:(isset($_GET['p'])?$_GET['p']:null));

			$l=preg_replace("#\v#", '', $l);
			$p=floatval($p);

			if(is_array($q))
			{
				$product_qte=array();
				$i=0;

				foreach($q as $contenu) 
				{
					$product_qte[$i++] = intval($contenu);
				}
			}

			else
			{
				$q=intval($q);
			}
		
	}

	if (!$erreur) 
	{
		basket_creation();
		switch ($action) {
			case 'add':
				add_article($l, $q, $p);
				break;

			case 'delete':
				delete_product($l);
				break;

			case 'refresh':
				for ($i=0; $i<count($product_qte); $i++) 
				{ 
					modify_product_qte($_SESSION['basket']['product_libelle'][$i++], $product_qte);
					var_dump($product_qte);
				}

				break;
			
			default:
				# code...
				break;
		}
	}

?>

<h2>Votre Panier</h2> 

<form action="" method="POST">
	<table width="800" border="2px">

		<tr>
			<td>Libéllé produit</td>

			<td>Prix unitaire</td>

			<td>Quantité</td>

			<td>TVA</td>

			<td>Action</td>
		</tr>

		<?php

		if(isset($_GET['deletebasket']) && $_GET['deletebasket'] == true)
		{
			delete_basket();
		}

		if(basket_creation())
		{

			$products_nb = count($_SESSION['basket']['product_libelle']);

			if ($products_nb<=0) 
			{
				?>
					<p style="color: red">Panier vide</p>
				<?php
			}

			else
			{

				for($i=0; $i<$products_nb; $i++)
				{
					?>
					
					<tr>						
					<td><?php echo $_SESSION['basket']['product_libelle'][$i]; ?></td><br>
					<td><?php echo $_SESSION['basket']['product_price'][$i]."€"; ?></td><br>
					<td><input type="text" name="q[]" value="<?php echo $_SESSION['basket']['product_qte'][$i]; ?>"></td><br>
					<td><?php echo $_SESSION['basket']['tva']."%"; ?></td><br>

					<td><a href="basket.php?action=delete&amp;l=<?php echo rawurldecode($_SESSION['basket']['product_libelle'][$i]) ?>">Supprimer</a></td>
					</tr>

					

					<tr>
						<td colspan="5"><br>
							<p>Total commande : <?php echo global_price()."€"; ?></p><br>
							<p>Total(tva incluse) : <?php echo global_price_tva()."€"; ?></p><br>
							<p>+ Frais de ports : <?php echo calc_fdp(); ?></p><br><br>
							<p>A payer : <?php echo calc_fdp()+global_price_tva(); ?></p>
							<p></p>
						</td>
					</tr>

					<?php
				}
					?>

					<tr>
						<td colspan="5">
							<input type="hidden" name="action" value="refresh">
							<input type="submit" name="valid" value="Rafraichir">
							
							<a href="?deletebasket=true">Supprimer le panier</a>
						</td>
					</tr>
					<?php
				
			}
		}
		?>

	</table>

</form>






<?php

require_once('include/footer.php');


?>