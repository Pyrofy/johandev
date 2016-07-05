<?php
	header('Content-type: text/html; charset=utf-8');
	//include 'auth.php';
	//include 'db.php';
	function headerimg(){
		$headerimg = '<img src="http://www.hegnar.no/var/hegnar/storage/images/4/8/2/7/1767284-1-nor-NO/46157_binary_56881_full_article.jpg" alt="F-16 Fighting Falcon" height="512" width="1024">';
		return $headerimg;
	}
	function menu(){
		$menu = '
			<div id=menubuttons>
			<a id=navstyle href="/">
				<div id=button1>
					Home
				</div>
			</a>
			<a id=navstyle href="/login.php">
				<div id=button2>
					Login
				</div>
			</a>
			<a id=navstyle href="/quiz.php">
				<div id=button3>
					Quiz
				</div>
			</a>';
				if(authuser()){
					$menu .= '
						<a id=navstyle href="/?action=logout">
							<div id=button4>
								Log out
							</div>
						</a>';
				}
			$menu .= '</div>';
			//$menu = 'meny';
			return $menu;		
	}
	function dispq(){
		$con = con();
		$sql = "SELECT * FROM spm";	
		$result = $con->query($sql);
		$nrows = 0;
		$nrows = $result->num_rows;
		
		if ($result->num_rows > 0) {
			?>
				<form action="/quiz.php?action=answer" method="post">
			<?php
			$itt = 1;
			//output data of each row
			while($row = $result->fetch_assoc()) {
				//echo "id: " . $row["id"]. " <br /> Un: " . $row["un"]. " <br /> pw:" . $row["pw"]. "<br />";
				//if($row["id"]==1 AND $nrows==1){
				//}
				?>
					Question <?php echo $itt." | ID: ".$row["id"]; ?>: <?php echo $row["question"]; ?> <br /><br />
					Option 1: <input type="radio" name="q<?php echo $row["id"]; ?>" value="1"> <?php echo $row["aw1"]; ?> <br />
					Option 2: <input type="radio" name="q<?php echo $row["id"]; ?>" value="2"> <?php echo $row["aw2"]; ?> <br />
					Option 3: <input type="radio" name="q<?php echo $row["id"]; ?>" value="3"> <?php echo $row["aw3"]; ?> <br />
					<input type="radio" name="q<?php echo $row["id"]; ?>" id="radiohidden" style="display:none" value="4" checked>
					<br /><br />	
				<?php
				$itt++;
			}
			?>
					<input type="submit" value="Submit" />
				</form>
			<?php
		}
	}
	function coraw($id){
		$con = con();
		$sql = "SELECT id, coraw FROM spm WHERE id='".$id."'";
		$result = $con->query($sql);
		$nrows = $result->num_rows;
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$returnval = $row["coraw"];
			}
		}
		$con->close();
		return $returnval;
	}
	function numq(){
		$con = con();
		$sql = "SELECT id FROM spm";
		$result = $con->query($sql);
		if($result->num_rows > 0){
			$nrows = $result->num_rows;
		}
		$con->close();
		return $nrows;
	}
	function score(){
		//get a list of id's
		$con = con();
		$sql = "SELECT id FROM spm";
		$result = $con->query($sql);
		$nrows = $result->num_rows;
		if($result->num_rows > 0){
			$ids = array();
			$i=0;
			while($row = $result->fetch_assoc()){
				$ids[] = $row["id"];
				//echo "id".$i.": ".$ids[$i]."<br />";
				$i++;
			}
		}
		
		
		$con->close();
		$i=1;
		$x=0;
		$score=0;
		$q="q".$ids[$x];
		while(isset($_POST[$q])){
			$q="q".$ids[$x];
			//echo "post: ".$_POST[q16]."<br />";
			$coraw = coraw($ids[$x]);
			//echo "id :".$ids[$x]."<br />";
			if($_POST[$q] == $coraw AND $_POST[$q] != ""){
				$score++;
			}
			if($_POST[$q] != ""){
				if($_POST[$q] != "4"){
					echo "Q: ".$i." | ID: ".$ids[$x]." Answer: ".$_POST[$q]." | Correct answer: ".$coraw."<br />";
				}
			}
			$i++;
			$x++;
			//$q="q".$i;
		}
		return $score;
	}
?>