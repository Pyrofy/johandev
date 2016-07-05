<?php
//this document contains authentication related functions

//login
function login($email, $pw){
	$con = con();
	$sql = "SELECT id, email, pw FROM users WHERE un='".$email."' AND pw='".$pw."'";	
		$result = $con->query($sql);
		$nrows = 0;
		$nrows = $result->num_rows;
		
		if ($result->num_rows > 0) {
			//output data of each row
			while($row = $result->fetch_assoc()) {
				//echo "id: " . $row["id"]. " <br /> Un: " . $row["email"]. " <br /> pw:" . $row["pw"]. "<br />";
				if($row["id"]==1 AND $nrows==1){
					//set admin email cookie
					$name = "email";
					$value = $row["email"];
					setcookie($name, $value, time()+(86400 * 30), "/");
					//set admin pw cookie
					$name = "pw";
					$value = $row["pw"];
					setcookie($name, $value, time()+(86400*30), "/");
					?>
						<script>
							window.location = "/index.php";
						</script>
					<?php
				}
				elseif($nrows==1){
					//set admin email cookie
					$name = "email";
					$value = $row["email"];
					setcookie($name, $value, time()+(86400 * 30), "/");
					//set admin pw cookie
					$name = "pw";
					$value = $row["pw"];
					setcookie($name, $value, time()+(86400*30), "/");
					?>
						<script>
							window.location = "/index.php";
						</script>
					<?php
				}
			}
		} else {
			echo "0 results";
		}
		$con->close();
}

//logout
function logout(){
	setcookie("email", "", time() - (86400 * 30));
	setcookie("pw", "", time() - (86400 * 30));
	?>
		<script>
			window.location = "/index.php";
		</script>
	<?php
}

//check if logged in as admin
function authadmin(){
	$email = $_COOKIE["email"];
	$pw = $_COOKIE["pw"];
	$result = "notset";
	$con=con();
	$sql = "SELECT id, un, pw FROM users WHERE un='".$email."' AND pw='".$pw."'";	
	$result = $con->query($sql);
	$nrows = 0;
	$nrows = $result->num_rows;
	$check = FALSE;
	
	if ($result->num_rows > 0) {
		//output data of each row
		while($row = $result->fetch_assoc()) {
			//echo "id: " . $row["id"]. " <br /> Un: " . $row["email"]. " <br /> pw:" . $row["pw"]. "<br />";
			if($row["id"]==1 AND $nrows==1){
				if(!isset($_COOKIE["email"]) OR !isset($_COOKIE["pw"])) {
					$check = FALSE;
				} 
				else {
					if($_COOKIE["email"]==$row["email"] AND $_COOKIE["pw"] == $row["pw"] AND $row["id"] == 1){
						$check = TRUE;
					}
				}
			}
		}
	} 
	else {
		$check = FALSE;
	}
	$con->close();
	return $check;
}

//check if logged in
function authuser(){
	$email = $_COOKIE["email"];
	$pw = $_COOKIE["pw"];
	$result = "notset";
	$con=con();
	$sql = "SELECT id, un, pw FROM users WHERE un='".$email."' AND pw='".$pw."'";	
	$result = $con->query($sql);
	$nrows = 0;
	$nrows = $result->num_rows;
	$check = FALSE;
	
	if ($result->num_rows > 0) {
		//output data of each row
		while($row = $result->fetch_assoc()) {
			//echo "id: " . $row["id"]. " <br /> Un: " . $row["email"]. " <br /> pw:" . $row["pw"]. "<br />";
			if($nrows==1){
				if(!isset($_COOKIE["email"]) OR !isset($_COOKIE["pw"])) {
					$check = FALSE;
				} 
				else {
					if($_COOKIE["email"]==$row["email"] AND $_COOKIE["pw"] == $row["pw"]){
						$check = TRUE;
					}
				}
			}
		}
	} 
	else {
		$check = FALSE;
	}
	$con->close();
	return $check;
}

//Register new user
function register(){
	//Grilstad's code goes here
	//Fylling, her is ur code 
	$email = $_POST["un"];
	$pw = $_POST["pw"];
	
	$con = con(); //Make connection 
	
	//Checks if the email and password is allowed to use
	$usLength = strlen($email);
	$pwLength = strlen($pw);
	
	if ($usLength >= 4 && $usLength <= 20) {
		$errorMessage = "";
	}
	else {
		$errorMessage = $errorMessage . "Brukernavnet har ikke godkjent lengde" . "<BR>";
	}
	if ($pwLength >=4 && $pwLength <= 20){
		$errorMessage = "";
	}
	else {
		$errorMessage = $errorMessage . "Passordet har ikke godkjent lengde" . "<BR>";
	}
	
	//Checks if the email is used before
	$sql = "SELECT * FROM users WHERE un = '".$email."'";
	$result = $con->query($sql);
	$num_rows = $result->num_rows;
	if ($num_rows > 0) { //If email is used before
		$errorMessage = "Brukernavnet er allerede registrert";
		echo "num rows: ".$num_rows."<br />";
	}
	else { //If email is good
		$errorMessage = "";
	}
	
	//Saves new user in database
	if ($errorMessage == "") {
		$sql = "INSERT INTO `quiz`.`users` (`un`, `pw`) 
				VALUES ('".$email."', '".$pw."')"; //This info goes to the table
		
		if ($con->query($sql) === TRUE) { //Sends new info to table, and receives status 
			echo "Ny bruker lagt til";
		} 
		else {
			echo "Error: Kunne ikke legge til ny bruker" . $sql . "<br>" . $con->error;
		}
		
		$con -> close(); //Close sql connetction 
		
		login($email, $pw);
		?>
		
		<script>	
		window.location = "/index.php";
		</script>
	
		
		<?php
	}
	else {
		echo "Brukernavnet eller passordet er ikke godkjent";
	}
}

?>