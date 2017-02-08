<link href="../assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>

<?php
	require_once('include/header.php');

	require_once('include/sidebar.php');

	if (isset($_GET['show'])) //recupère affichage article individuel
	{
		$product = $_GET['show'];
		$select = $db->prepare("SELECT *, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS datetime_fr 
								FROM products
								WHERE title='$product'");
		$select->execute();
		$s=$select->fetch(PDO::FETCH_OBJ);

		?>
		<div class="article">
			<div class="zoom"><img src="admin/imgs/<?php echo $s->title; ?>.jpg"/></div>
			<h2><?php echo $s->title; ?></h2>
			<p><?php echo $s->description; ?></p>
			<h4>Tailles disponibles: <?php echo $s->size; ?></h4>
			<h4>Prix :<?php echo $s->price; ?> €</h4>
			<p>Ajouté le : <?php echo $s->datetime_fr; ?></p>
		<?php
			if ($s->stock>0) 
			{
				if ($s->stock<=5) 
				{
					?>
					<p style="color:red">Plus que <?php echo $s->stock; ?> article(s) en stock.</p>
					<?php
				}

				else
				{
					?>
					<p>Il reste <?php echo $s->stock; ?> articles en stock.</p>
					<?php
				}
				?>

				<a href="basket.php?action=add&amp;l=<?php echo $s->title; ?>&amp;q=1&amp;p=<?php echo $s->price; ?>">
					Ajouter au panier</a> <br>
				<?php
			}


			else
			{
				?>
				<p>Stock épuisé</p>
				<?php
			}
		?>
			
		</div>
		<?php
	}


	else
	{
		if (isset($_GET['price']))//selection par prix
		{
			?>
				<h3 style="margin-left: 530px; color:  #d3531a;">Trier par</h3>

						<div id="nav-icon1">
						  <span></span>
						  <span></span>
						  <span></span>
						</div>
				<div class="select_data">
						<h2 style="text-decoration: underline;">Trier par</h2>
							<ul>

								<li><h3>Prix</h3></li>
									<ul><h4><a href="?price=ASC">Croissant</a></ul></h4>
									<ul><h4><a href="?price=DESC">Déroissant</a></ul></h4>

	                        	<li><h3>Categories</h3></li>
									<?php $st=$db->query("SELECT name FROM category");
			                         		while ($show = $st->fetch(PDO::FETCH_OBJ))
			                         		{
			                         			?>

			                         			<ul><h4>
			                         				<a href="?category=<?php echo $show->name; ?>"><?php echo $show->name; ?></a>
			                         			</h4></ul>
			                         			<?php
			                         		}
			                        ?>

			                   <li><h3>Marques</h3></li>

			                        <?php $select_brand=$db->query("SELECT DISTINCT brand FROM products");
			                         		while ($s_brand = $select_brand->fetch(PDO::FETCH_OBJ))
			                         		{
			                         			?>
			                         			<ul><h4>
			                         			<a href="?brand=<?php echo $s_brand->brand; ?>"><?php echo $s_brand->brand; ?></a>
			                         			</h4></ul>
			                         			<?php
			                         		}
			                        ?>
	                        

			                   <li><h3>Sexe</h3></li>

			                   		<?php $select_gender=$db->query("SELECT DISTINCT gender FROM products");
			                         		while ($s_gender = $select_gender->fetch(PDO::FETCH_OBJ))
			                         		{
			                         			?>
			                         			<ul><h4>
			                         			<a href="?gender=<?php echo $s_gender->gender; ?>">
			                         			<?php
			                         				 $gender=$s_gender->gender;
			                         				 if ($gender=="H") 
			                         				 {
			                         				  	echo "Homme";
			                         				 } 
			                         				  else if($gender=="F")
			                         				  {
			                         				  	echo "Femme";
			                         				  }
			                         			?></a>
			                         			</h4></ul>
			                         			<?php
			                         		}
			                        ?>
			            </ul>
					</div>
			<?php

				if($_GET['price']=="ASC")
				{
					
					$select = $db->prepare("SELECT *, DATE_FORMAT(date_creation, '%d/%m/%Y à %H:%i:%ss') AS datetime_fr 
											FROM products
											ORDER BY price ASC");
					$select->execute();

					while ($s=$select->fetch(PDO::FETCH_OBJ)) 
						{

							$lenght = 28;
							$lenght2 = 15;
							$description = $s->description;
							$affichage_description = substr($description,0, $lenght)."...";

							?>
							<div class="store_article_view">
								<a href="?show=<?php echo $s->title; ?>"> <img src="admin/imgs/<?php echo $s->title; ?>.jpg"/> </a>
								<a href="?show=<?php echo $s->title; ?>"> <h2><?php echo $s->title; ?></h2></a>
								<p><?php echo $affichage_description; ?></p>
								<p>Tailles: <?php echo $s->size; ?></p>
								<h4>Prix :<?php echo $s->price; ?> €</h4>
								<p>Ajouté le : <?php echo $s->datetime_fr; ?></p>
								<?php
									if ($s->stock!=0) 
									{
										?>
										<a href="basket.php?action=add&amp;l=<?php echo $s->title; ?>&amp;q=1&amp;p=<?php echo $s->price; ?>">
										Ajouter au panier</a> <br>
										<?php
									}

									else
									{
										?>
										<p>Stock épuisé</p>
										<?php
									}
								?>
							</div>
							<?php
						}
				}

				else if($_GET['price']=="DESC")
				{
					
					$select = $db->prepare("SELECT *, DATE_FORMAT(date_creation, '%d/%m/%Y à %H:%i:%ss') AS datetime_fr 
											FROM products
											ORDER BY price DESC");
					$select->execute();

					while ($s=$select->fetch(PDO::FETCH_OBJ)) 
						{

							$lenght = 28;
							$lenght2 = 15;
							$description = $s->description;
							$affichage_description = substr($description,0, $lenght)."...";

							?>
							<div class="store_article_view">
								<a href="?show=<?php echo $s->title; ?>"> <img src="admin/imgs/<?php echo $s->title; ?>.jpg"/> </a>
								<a href="?show=<?php echo $s->title; ?>"> <h2><?php echo $s->title; ?></h2></a>
								<p><?php echo $affichage_description; ?></p>
								<p>Tailles: <?php echo $s->size; ?></p>
								<h4>Prix :<?php echo $s->price; ?> €</h4>
								<p>Ajouté le : <?php echo $s->datetime_fr; ?></p>
								<?php
									if ($s->stock!=0) 
									{
										?>
										<a href="basket.php?action=add&amp;l=<?php echo $s->title; ?>&amp;q=1&amp;p=<?php echo $s->price; ?>">
										Ajouter au panier</a> <br>
										<?php
									}

									else
									{
										?>
										<p>Stock épuisé</p>
										<?php
									}
								?>
							</div>
							<?php
						}
				}
		}

		else if (isset($_GET['gender']))//selection par sexe
		{
			?>
				<h3 style="margin-left: 530px; color:  #d3531a;">Trier par</h3>

						<div id="nav-icon1">
						  <span></span>
						  <span></span>
						  <span></span>
						</div>
				<div class="select_data">
						<h2 style="text-decoration: underline;">Trier par</h2>
							<ul>

								<li><h3>Prix</h3></li>
									<ul><h4><a href="?price=ASC">Croissant</a></ul></h4>
									<ul><h4><a href="?price=DESC">Déroissant</a></ul></h4>

	                        	<li><h3>Categories</h3></li>
									<?php $st=$db->query("SELECT name FROM category");
			                         		while ($show = $st->fetch(PDO::FETCH_OBJ))
			                         		{
			                         			?>

			                         			<ul><h4>
			                         				<a href="?category=<?php echo $show->name; ?>"><?php echo $show->name; ?></a>
			                         			</h4></ul>
			                         			<?php
			                         		}
			                        ?>

			                   <li><h3>Marques</h3></li>

			                        <?php $select_brand=$db->query("SELECT DISTINCT brand FROM products");
			                         		while ($s_brand = $select_brand->fetch(PDO::FETCH_OBJ))
			                         		{
			                         			?>
			                         			<ul><h4>
			                         			<a href="?brand=<?php echo $s_brand->brand; ?>"><?php echo $s_brand->brand; ?></a>
			                         			</h4></ul>
			                         			<?php
			                         		}
			                        ?>
	                        

			                   <li><h3>Sexe</h3></li>

			                   		<?php $select_gender=$db->query("SELECT DISTINCT gender FROM products");
			                         		while ($s_gender = $select_gender->fetch(PDO::FETCH_OBJ))
			                         		{
			                         			?>
			                         			<ul><h4>
			                         			<a href="?gender=<?php echo $s_gender->gender; ?>">
			                         			<?php
			                         				 $gender=$s_gender->gender;
			                         				 if ($gender=="H") 
			                         				 {
			                         				  	echo "Homme";
			                         				 } 
			                         				  else if($gender=="F")
			                         				  {
			                         				  	echo "Femme";
			                         				  }
			                         			?></a>
			                         			</h4></ul>
			                         			<?php
			                         		}
			                        ?>
			            </ul>
					</div>
			<?php

			$gender = $_GET['gender'];
			$select = $db->prepare("SELECT *, DATE_FORMAT(date_creation, '%d/%m/%Y à %H:%i:%ss') AS datetime_fr 
									FROM products
									WHERE gender='$gender'");
			$select->execute();

			while ($s=$select->fetch(PDO::FETCH_OBJ)) 
				{

					$lenght = 28;
					$lenght2 = 15;
					$description = $s->description;
					$affichage_description = substr($description,0, $lenght)."...";

					?>
					<div class="store_article_view">
						<a href="?show=<?php echo $s->title; ?>"> <img src="admin/imgs/<?php echo $s->title; ?>.jpg"/> </a>
						<a href="?show=<?php echo $s->title; ?>"> <h2><?php echo $s->title; ?></h2></a>
						<p><?php echo $affichage_description; ?></p>
						<p>Tailles: <?php echo $s->size; ?></p>
						<h4>Prix :<?php echo $s->price; ?> €</h4>
						<p>Ajouté le : <?php echo $s->datetime_fr; ?></p>
						<?php
							if ($s->stock!=0) 
							{
								?>
								<a href="basket.php?action=add&amp;l=<?php echo $s->title; ?>&amp;q=1&amp;p=<?php echo $s->price; ?>">
								Ajouter au panier</a> <br>
								<?php
							}

							else
							{
								?>
								<p>Stock épuisé</p>
								<?php
							}
						?>
					</div>
					<?php
				}


		}

		else if (isset($_GET['brand']))//selection par marque effectuée
		{
			?>
				<h3 style="margin-left: 530px; color:  #d3531a;">Trier par</h3>

						<div id="nav-icon1">
						  <span></span>
						  <span></span>
						  <span></span>
						</div>
				<div class="select_data">
						<h2 style="text-decoration: underline;">Trier par</h2>
							<ul>

								<li><h3>Prix</h3></li>
									<ul><h4><a href="?price=ASC">Croissant</a></ul></h4>
									<ul><h4><a href="?price=DESC">Déroissant</a></ul></h4>

	                        	<li><h3>Categories</h3></li>
									<?php $st=$db->query("SELECT name FROM category");
			                         		while ($show = $st->fetch(PDO::FETCH_OBJ))
			                         		{
			                         			?>

			                         			<ul><h4>
			                         				<a href="?category=<?php echo $show->name; ?>"><?php echo $show->name; ?></a>
			                         			</h4></ul>
			                         			<?php
			                         		}
			                        ?>

			                   <li><h3>Marques</h3></li>

			                        <?php $select_brand=$db->query("SELECT DISTINCT brand FROM products");
			                         		while ($s_brand = $select_brand->fetch(PDO::FETCH_OBJ))
			                         		{
			                         			?>
			                         			<ul><h4>
			                         			<a href="?brand=<?php echo $s_brand->brand; ?>"><?php echo $s_brand->brand; ?></a>
			                         			</h4></ul>
			                         			<?php
			                         		}
			                        ?>
	                        

			                   <li><h3>Sexe</h3></li>

			                   		<?php $select_gender=$db->query("SELECT DISTINCT gender FROM products");
			                         		while ($s_gender = $select_gender->fetch(PDO::FETCH_OBJ))
			                         		{
			                         			?>
			                         			<ul><h4>
			                         			<a href="?gender=<?php echo $s_gender->gender; ?>">
			                         			<?php
			                         				 $gender=$s_gender->gender;
			                         				 if ($gender=="H") 
			                         				 {
			                         				  	echo "Homme";
			                         				 } 
			                         				  else if($gender=="F")
			                         				  {
			                         				  	echo "Femme";
			                         				  }
			                         			?></a>
			                         			</h4></ul>
			                         			<?php
			                         		}
			                        ?>
			            </ul>
					</div>
			<?php

			$brand = $_GET['brand'];
			$select = $db->prepare("SELECT *, DATE_FORMAT(date_creation, '%d/%m/%Y à %H:%i:%ss') AS datetime_fr 
									FROM products
									WHERE brand='$brand'");
			$select->execute();

			while ($s=$select->fetch(PDO::FETCH_OBJ)) 
				{

					$lenght = 28;
					$lenght2 = 15;
					$description = $s->description;
					$affichage_description = substr($description,0, $lenght)."...";

					?>
					<div class="store_article_view">
						<a href="?show=<?php echo $s->title; ?>"> <img src="admin/imgs/<?php echo $s->title; ?>.jpg"/> </a>
						<a href="?show=<?php echo $s->title; ?>"> <h2><?php echo $s->title; ?></h2></a>
						<p><?php echo $affichage_description; ?></p>
						<p>Tailles: <?php echo $s->size; ?></p>
						<h4>Prix :<?php echo $s->price; ?> €</h4>
						<p>Ajouté le : <?php echo $s->datetime_fr; ?></p>
						<?php
							if ($s->stock!=0) 
							{
								?>
								<a href="basket.php?action=add&amp;l=<?php echo $s->title; ?>&amp;q=1&amp;p=<?php echo $s->price; ?>">
								Ajouter au panier</a> <br>
								<?php
							}

							else
							{
								?>
								<p>Stock épuisé</p>
								<?php
							}
						?>
					</div>
					<?php
				}


		}

		else if (isset($_GET['category'])) // rentre dans la categorie
		{
			?>

				<h3 style="margin-left: 530px; color:  #d3531a;">Trier par</h3>

					<div id="nav-icon1">
					  <span></span>
					  <span></span>
					  <span></span>
					</div>
				
			<?php

			
				$category = $_GET['category'];
				$select = $db->prepare("SELECT *, DATE_FORMAT(date_creation, '%d/%m/%Y à %H:%i:%ss') AS datetime_fr 
										FROM products
										WHERE category='$category'");
				$select->execute();

				?>
					


					<div class="select_data">
						<h2 style="text-decoration: underline;">Trier par</h2>
							<ul>

								<li><h3>Prix</h3></li>
									<ul><h4><a href="?price=ASC">Croissant</a></ul></h4>
									<ul><h4><a href="?price=DESC">Déroissant</a></ul></h4>


	                        	<li><h3>Categories</h3></li>
									<?php $st=$db->query("SELECT name FROM category");
			                         		while ($show = $st->fetch(PDO::FETCH_OBJ))
			                         		{
			                         			?>

			                         			<ul><h4>
			                         				<a href="?category=<?php echo $show->name; ?>"><?php echo $show->name; ?></a>
			                         			</h4></ul>
			                         			<?php
			                         		}
			                        ?>

			                   <li><h3>Marques</h3></li>

			                        <?php $select_brand=$db->query("SELECT DISTINCT brand FROM products");
			                         		while ($s_brand = $select_brand->fetch(PDO::FETCH_OBJ))
			                         		{
			                         			?>
			                         			<ul><h4>
			                         			<a href="?brand=<?php echo $s_brand->brand; ?>"><?php echo $s_brand->brand; ?></a>
			                         			</h4></ul>
			                         			<?php
			                         		}
			                        ?>
	                        

			                   <li><h3>Sexe</h3></li>

			                   		<?php $select_gender=$db->query("SELECT DISTINCT gender FROM products");
			                         		while ($s_gender = $select_gender->fetch(PDO::FETCH_OBJ))
			                         		{
			                         			?>
			                         			<ul><h4>
			                         			<a href="?gender=<?php echo $s_gender->gender; ?>">
			                         			<?php
			                         				 $gender=$s_gender->gender;
			                         				 if ($gender=="H") 
			                         				 {
			                         				  	echo "Homme";
			                         				 } 
			                         				  else if($gender=="F")
			                         				  {
			                         				  	echo "Femme";
			                         				  }
			                         			?></a>
			                         			</h4></ul>
			                         			<?php
			                         		}
			                        ?>
			            </ul>
					</div>
									
				<?php
		

				while ($s=$select->fetch(PDO::FETCH_OBJ)) 
				{

					$lenght = 28;
					$lenght2 = 15;
					$description = $s->description;
					$affichage_description = substr($description,0, $lenght)."...";

				?>
				<div class="store_article_view">
					<a href="?show=<?php echo $s->title; ?>"> <img src="admin/imgs/<?php echo $s->title; ?>.jpg"/> </a>
					<a href="?show=<?php echo $s->title; ?>"> <h2><?php echo $s->title; ?></h2></a>
					<p><?php echo $affichage_description; ?></p>
					<p>Tailles: <?php echo $s->size; ?></p>
					<h4>Prix :<?php echo $s->price; ?> €</h4>
					<p>Ajouté le : <?php echo $s->datetime_fr; ?></p>
					<?php
						if ($s->stock!=0) 
						{
							?>
							<a href="basket.php?action=add&amp;l=<?php echo $s->title; ?>&amp;q=1&amp;p=<?php echo $s->price; ?>">
							Ajouter au panier</a> <br>
							<?php
						}

						else
						{
							?>
							<p>Stock épuisé</p>
							<?php
						}
					?>
				</div>
				<?php
				}
			
			
		}	

		else
		{
			$select = $db->query("SELECT UPPER(name) AS cat_name FROM category"); // page d'entrée boutique

			?>
				<h1 style="text-align: center;text-decoration: underline; text-decoration-color: black; font-family: Courier; color: rgba(255,30,17,1);">CATEGORIES</h1><br><hr>
			<?php
			while ($s=$select->fetch(PDO::FETCH_OBJ)) 
			{
			?>

			<div class="select_fromStore_homePage">
				<a href="?category=<?php echo $s->cat_name; ?>"><h2><?php echo $s->cat_name; ?></h2></a>
				<a href="?category=<?php echo $s->cat_name; ?>"><img src="images/<?php echo $s->cat_name; ?>".jpg></a>
			</div><hr>
				
			<?php
			}
		}
	}

	require_once('include/footer.php');

?>