<?php
function printer(){
	if($_GET[action]){
		if($_GET[action]=="login"){
			echo "Processing login <br />";
			//collect login info from forms
			$un=$_POST[un];
			$pw=$_POST[pw];
			//Run login function
			login($un, $pw);
		}
		elseif($_GET["action"]=="logout"){
			logout();
		}
		elseif($_GET["action"]=="register"){
			register();
		}
		else{
			echo "Something went wrong. Contact admin or try again later";
		}
	}
	elseif($_GET[content]){
		if($_GET[content]=="register"){
			regContent();
		}
		elseif($_GET[content]=="profile"){
			if(authuser() OR authadmin()){
				//show profile info
			}
			else{
				?>Don't have a user yet? register in the forms below:<br /><br /><?php
				regContent();
			}
		}
		else{
			echo "404 - page not found!<br />";
		}
	}
	else{
		echo "Sup?<br />";
	}
}

function loginbar(){
	if(authuser() OR authadmin()){
		//logout button and user info
	}
	else{
		//loginform
		?>
		<form action="/?action=login" method="post">
			<input type="text" name="un" placeholder="Username">
			<input type="password" name="pw" placeholder="Password" />
			<input type="submit" value="Login" />
		</form>
		Dont't have a user? <a href="/?content=register">Register here.</a>
		<?php
	}
}

function regContent(){
	?>
		<script>
		function pwEqual(){
			var x = document.forms["regform"]["pw"].value;
			var y = document.forms["regform"]["pwre"].value;
			if(x != y){
				document.getElementById("pw").style.border = "2px solid red";
				//document.getElementById("pw").style.border.radius = "4px";
				document.getElementById("pwre").style.border = "2px solid red";
			}
			else{
				document.getElementById("pw").style.border = "2px solid green";
				document.getElementById("pwre").style.border = "2px solid green";
				//document.getElementById("pw").style.border.radius = "4px";
			}
		}
		</script>
		Registrer new user: <br />
		<form name="regform" action="/?action=register" method="post">
			Username: <br />
			<input type="text" name="un" placeholder="Username"> <br />
			Password: <br />
			<input id="pw" type="password" name="pw" placeholder="Password" /> <br />
			Retype password: <br />
			<input id="pwre" type="password" name="pwre" placeholder="Password" onkeyup="pwEqual()" /> <br />
			<div id="notEqual"></div>
			<input type="submit" value="Register" />
		</form>
	<?php
}

function sideMenu(){
	?>
	<a href="/"><div id="sidemenubutton">Home</div></a>
	<a href="/?content=profile"><div id="sidemenubutton">Profile</div></a>
	<a href="/?content=stuff"><div id="sidemenubutton">Stuff</div></a>
	<a href="/?content=morestuff"><div id="sidemenubutton">More Stuff</div></a>
	<a href="/?content=morestuff"><div id="sidemenubutton">More Stuff</div></a>
	<?php
}

?>