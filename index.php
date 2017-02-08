<?php

require_once('include/header.php');

?>
<div class="row">

	<div class="body_carousel">
		<div class="carousel">
			<div class="canvas">
				<div class="item">
					<img src="images/soldes.jpg"/>
				</div>
				<div class="item">
					<img src="images/slide-helas.jpg"/>
				</div>
				<div class="item">
					<img src="images/board-serge.jpg"/>
				</div>	
			</div>
		</div>
		<a class="carousel-prev" href="#"> 
			<img src="images/fleche_left.png" class="fleches">
		</a>
		<a class="carousel-next" href="#">
			<img src="images/fleche_right.png" class="fleches">
		</a>
	</div>


</div>



<?php
	

	$select = $db->prepare("SELECT *, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS datetime_fr 
							FROM products ORDER BY id DESC LIMIT 0,20");
	$select->execute();

		while ($s=$select->fetch(PDO::FETCH_OBJ)) 
		{
		?>
			<div class="index_article_view">
			<a href="store.php?show=<?php echo $s->title; ?>"> <img src="admin/imgs/<?php echo $s->title; ?>.jpg"/> </a>
			<a href="store.php?show=<?php echo $s->title; ?>"> <h2><?php echo $s->title; ?></h2></a>
			<h4><?php echo $s->price; ?> €</h4>
			<p>Ajouté le : <?php echo $s->datetime_fr; ?></p>  <hr><br>
			</div>
			
		<?php
		}
		


			

require_once('include/footer.php');

?>