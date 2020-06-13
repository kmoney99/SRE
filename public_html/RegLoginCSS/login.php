<?php

include("header.php");

?>

<link rel="stylesheet" type="text/css" href="style.css">

<h1 style="background-color:Orange;">Login</h1>

<form method="POST">

	<div style='text-align:center'>
	<label for="email">Email:<font color=red>*</font>
	<input type="email" id="email" name="email" autocomplete="off" />
	</label>

	<label for="p">Password:<font color=red>*</font>
	<input type="password" id="p" name="password" autocomplete="off"/>
	</label>

	<input type="submit" name="login" value="Login"/>

</form>

<?php

//echo var_export($_GET, true);
//echo var_export($_POST, true);
//echo var_export($_REQUEST, true);
if(isset($_POST["login"])){
	if (empty($_POST['email'])) {
		echo "Email is required";
	}
	
	if (empty($_POST['password'])) {
		echo "Password is required";
	}
}
	
		//require("config.php");
			$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
			try{
				$db = new PDO($connection_string, $dbuser, $dbpass);
				$stmt = $db->prepare("SELECT * FROM Users where email = :email LIMIT 1");
				$stmt->execute(array(
					":email" => $email
				));
				$e = $stmt->errorInfo();
				if($e[0] != "00000"){
					echo var_export($e, true);
				}
				else{
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($result){
						$rpassword = $result["password"];
						if(password_verify($password, $rpassword)){
							echo "<div>Passwords matched! You are technically logged in!</div>";
							$_SESSION["user"] = array(
								"id"=>$result["id"],
								"email"=>$result["email"],
								"first_name"=>$result["first_name"],
								"last_name"=>$result["last_name"]
							);
							
					
					
							echo var_export($_SESSION, true);
							header("Location: home.php");
						}
						else{
							echo "<div>Invalid password!</div>";
						}
					}
					else{
						echo "<div>Invalid user</div>";
					}
				
				}
			}
			catch (Exception $e){
				echo $e->getMessage();
			}

?>