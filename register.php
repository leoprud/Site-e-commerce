<?php
require_once('include/header.php');
require_once('include/sidebar.php');

if (!isset($_SESSION['user_id'])) 
{

	if (isset($_POST['submit'])) 
	{
		$username=$_POST['username'];
		$password=$_POST['password'];
		$repassword=$_POST['repassword'];
		$email=$_POST['email'];

		if (!empty($username && $password && $repassword && $email)) 
		{
			if ($password==$repassword) 
			{
				$db->query("INSERT INTO users VALUES('', '$username', '$email', '$password')");
				?>
					<h3>Bienvenue <?php echo $username; ?>, votre compte à été créé. <a href="connect.php">Se connecter</a></h3>
				<?php
			}

			else
			{
			?>
				<script type="text/javascript">alert('Veuillez entrer des mots passe indentiques');</script>
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
	<h1>S'enregistrer</h1><br>

	<form action="" method="POST">
		<label for="username">Pseudo</label><br>
		<input type="text" name="username"><br><br>
		<label for="email">E-mail</label><br>
		<input type="email" name="email"><br><br>
		<label for="password">Mot de passe</label><br>
		<input type="password" name="password"><br><br>
		<label for="repassword">Confirmation mot de passe</label><br>
		<input type="password" name="repassword"><br><br>
		<input type="submit" name="submit">

	</form>

<br><a href="register.php">Se connecter</a>

<?php
}

else
{
	header('Location: my_account.php');
}
require_once('include/footer.php');
?>