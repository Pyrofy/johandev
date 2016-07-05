<script>
function pwEqual(){
	var x = document.forms["regform"]["pw"].value;
	var y = document.forms["regform"]["pwre"].value;
	if(x != y){
		document.write("not equal");
	}
	else{
		document.write("equal");
	}
}
</script>