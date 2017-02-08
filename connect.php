<?php
require_once('include/header.php');
require_once('include/sidebar.php');

if (!isset($_SESSION['user_id'])) 
{

	if (isset($_POST['submit'])) 
	{
		
		$password=$_POST['password'];
		$email=$_POST['email'];

		if (!empty($password && $email)) 
		{
			$result=$db->query("SELECT id FROM users WHERE email='$email'");
			if ($result->fetchColumn()) 
			{
				$result=$db->query("SELECT * FROM users WHERE email='$email'");
				$result=$result->fetch(PDO::FETCH_OBJ);

				$_SESSION['user_id']=$result->id;
				$_SESSION['user_name']=$result->username;
				$_SESSION['user_email']=$result->email;
				$_SESSION['user_password']=$result->password;
			}
			else
			{
			?>
				<script type="text/javascript">alert('Pas de correspondance.');</script>
			<?php
			}
			
		}

		else
		{
			?>
			<script type="text/javascript">alert('Veuillez remplir tous les champs');</script>
			<?php
		}
	}

	?>
	<h1>Connexion</h1><br>

	<form action="" method="POST">

		<label for="email">E-mail</label><br>
		<input type="email" name="email"><br><br>
		<label for="password">Mot de passe</label><br>
		<input type="password" name="password"><br><br>
		
		<input type="submit" name="submit">

	</form>

	<br><a href="register.php">S'inscrire</a>

<?php
	
}

else
{
	header('Location: my_account.php');
}

require_once('include/footer.php');
?>