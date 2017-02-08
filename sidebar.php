<div class="col-xs-3" id="sidebar">
<h3 style="text-decoration: underline;">Derniers articles</h3>

<?php
	//Affiche les 3 derniers articles mis en ligne recement
	$select = $db->prepare("SELECT *, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS datetime_fr 
							FROM products ORDER BY id DESC LIMIT 0,3");
	$select->execute();

		while ($s=$select->fetch(PDO::FETCH_OBJ)) 
		{
		?>
		
			<a href="?show=<?php echo $s->title; ?>"> <img src="admin/imgs/<?php echo $s->title; ?>.jpg"/> </a>
			<a href="?show=<?php echo $s->title; ?>"> <h2><?php echo $s->title; ?></h2></a>
			<h4><?php echo $s->price; ?> €</h4>
			<p>Ajouté le : <?php echo $s->datetime_fr; ?></p>  <hr><br>
	
			
		<?php
		}

		//articles les moins chers

		?>
			<br><h3 style="text-decoration: underline;">Articles à petits prix</h3>
		<?php
		$select = $db->prepare("SELECT *, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS datetime_fr 
							FROM products ORDER BY price ASC LIMIT 0,3");
		$select->execute();

		while ($s=$select->fetch(PDO::FETCH_OBJ)) 
		{
		?>
		
			<a href="?show=<?php echo $s->title; ?>"> <img src="admin/imgs/<?php echo $s->title; ?>.jpg"/> </a>
			<a href="?show=<?php echo $s->title; ?>"> <h2><?php echo $s->title; ?></h2></a>
			<h4><?php echo $s->price; ?> €</h4>
			<p>Ajouté le : <?php echo $s->datetime_fr; ?></p>  <hr><br>
	
			
		<?php
		}

		?>
		<br>
		<div style="text-align: left;">

			<h3 style="text-decoration: underline;">Nous contacter :</h3> <br>
				<h4><img src="http://i.ebayimg.com/images/g/oNgAAOxyTjNSg4uN/s-l300.jpg" width="8%">  02.99.99.66.66</h4>
				<a href="mailto:ozbone@gmail.com"><h4>@         E-mail</h4></a><br>
				<h4>Azone Skateshop</h4>
				<h4>6 Impasse de l'imposture</h4>
				<h4>35750 CEDEX 89</h4>
				<h4>RENNES</h4>
		</div>
		<?php
		
?>
	
</div>