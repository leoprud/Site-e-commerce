<?php
	
	function basket_creation()
	{
		try
		{
			$db = new PDO('mysql:host=localhost;dbname=site_e_commerce;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch (Exception $e)
		{
	    	die('Erreur : ' . $e->getMessage());
		}


		if (!isset($_SESSION['basket'])) 
		{
			$_SESSION['basket']=array();
			$_SESSION['basket']['product_libelle']=array();
			$_SESSION['basket']['product_qte']=array();
			$_SESSION['basket']['product_price']=array();
			$_SESSION['basket']['lock']=array();

			$select=$db->query('SELECT tva FROM products');
			$data=$select->fetch(PDO::FETCH_OBJ);
			$_SESSION['basket']['tva']=$data->tva;
		}

		return true;
	}



	function add_article($product_libelle, $product_qte, $product_price)
	{
		if (basket_creation() && !is_locked()) 
		{
			$product_position = array_search($product_libelle, $_SESSION['basket']['product_libelle']);

			if ($product_position!== false) 
			{
				$_SESSION['basket']['product_libelle'][$product_position] += $product_qte;
			}

			else
			{
				array_push($_SESSION['basket']['product_libelle'], $product_libelle);
				array_push($_SESSION['basket']['product_qte'], $product_qte);
				array_push($_SESSION['basket']['product_price'], $product_price);
			}
		}

		else
		{
			?>
			<script type="text/javascript">alert('Erreur');</script>
			<?php
		}
	}



	function modify_product_qte($product_libelle, $product_qte)
	{
		if (basket_creation()) 
		{
			if ($product_qte>0) 
			{
				$product_position=array_search($product_libelle, $_SESSION['basket']['product_libelle']);

				if ($product_position!==false) 
				{
					$_SESSION['basket']['product_qte'][$product_position] *= $product_qte;
				}
			}

			else
			{
				delete_product($product_libelle);
			}
		}

		else
		{
			?>
			<script type="text/javascript">alert('Erreur');</script>
			<?php

		}
	}



	function delete_product($product_libelle)
	{
		if (basket_creation() && !is_locked()) 
		{
			$tmp=array();
			$tmp['product_libelle']=array();
			$tmp['product_qte']=array();
			$tmp['product_price']=array();
			$tmp['lock']=$_SESSION['basket']['lock'];
			$tmp['tva']=$_SESSION['basket']['tva'];

			for($i=0; $i<count($_SESSION['basket']['product_libelle']); $i++)
			{
				if ($_SESSION['basket']['product_libelle'][$i] !== $product_libelle) 
				{
					array_push($_SESSION['basket']['product_libelle'], $_SESSION['basket']['product_libelle'][$i]);
					array_push($_SESSION['basket']['product_qte'], $_SESSION['basket']['product_qte'][$i]);
					array_push($_SESSION['basket']['product_price'], $_SESSION['basket']['product_price'][$i]);
				}
			}

			$_SESSION['basket']=$tmp;
			unset($tmp);
		}


		else
		{
			?>
			<script type="text/javascript">alert('Erreur');</script>
			<?php
		}
	}


	function delete_basket()
	{
		if(isset($_SESSION['basket']))
		{
			unset($_SESSION['basket']);
		}
	}



	function global_price()
	{
		$total=0;

		for($i=0; $i<count($_SESSION['basket']['product_libelle']); $i++)
		{
			$total+=$_SESSION['basket']['product_qte'][$i]*$_SESSION['basket']['product_price'][$i];
		}

		return $total;
	}



	function global_price_tva()
	{
		$total=0;

		for($i=0; $i<count($_SESSION['basket']['product_libelle']); $i++)
		{
			$total+=$_SESSION['basket']['product_qte'][$i]*$_SESSION['basket']['product_price'][$i];
		}

		return $total+$total*($_SESSION['basket']['tva']/100);
	}



	function is_locked()
	{
		if (isset($_SESSION['basket']) && isset($_SESSION['is_locked'])) 
		{
			return true;
		}

		else
		{
			return false;
		}
	}



	function count_articles()
	{
		if (isset($_SESSION['basket'])) 
		{
			return count($_SESSION['basket']['product_libelle']);
		}

		else
		{
			return 0;
		}
	}

	function calc_fdp()
	{

		try
		{
			$db = new PDO('mysql:host=localhost;dbname=site_e_commerce;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch (Exception $e)
		{
	    	die('Erreur : ' . $e->getMessage());
		}


		
		$weight_product = "";
		$shipping = "";

		for ($i=0; $i < count_articles() ; $i++) 
		{ 
			for ($j=0; $j < $_SESSION['basket']['product_qte'][$i] ; $j++) 
			{ 
				$title=$_SESSION['basket']['product_libelle'][$i];
				$select=$db->query("SELECT weight FROM products WHERE title='$title'");
				$result = $select->fetch(PDO::FETCH_OBJ);
				$weight=$result->weight;

				$weight_product+=$weight*count_articles();

				$select=$db->query("SELECT price FROM weights WHERE value = '$weight_product'");
				$resultat = $select->fetch(PDO::FETCH_OBJ); 

				
					$shipping=$resultat->price;
				


			}
		}
		
		return $shipping;

	}




?>