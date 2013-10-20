<?php
include('base/org.php');
class Edit extends baseMod {
	var $_state = 0;
	function get(){
		if(isset($_GET['mod'])){
			switch($_GET['mod']){
				case 's':
					$this->_state = 1;
					
					break;
			}
		}
	}
	function post(){}
	function nodata(){}
	function doing(){}
	function view(){
		$this->loadHeader(true);
		
		if($this->_state == 1){
			echo "<script>
					document.getElementById('outputArea').innerHTML = 'Upload成功';
					</script>";
		}
		
?>
	<script>
		/*
		function updateView(data){
			console.log('updateView= '+data);
			switch(data){
				case 'Upload Success':
					outputArea.innerHTML = 'Upload成功';
					break;
				default:
					//outputArea.innerHTML = data;
					break;
			}
		}
		function upload(){
			outputArea.innerHTML = '上傳中...';
			var title = document.getElementById('title').value;
			var byline = document.getElementById('byline').value;
			var image_file = document.getElementById('image_file').files[0].name;
			var postContent = document.getElementById('postContent').value;
			var str = 	"mod=uploadPost" +
						"&title=" + title +
						"&byline=" + byline +
						"&img=" + image_file +
						"&content=" + postContent;
			xmlhttp.open('POST', 'edit.php', true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send(str);
			console.log(str);
		}
		*/
	</script>
	
	<form action="upload.php" method="POST" enctype="multipart/form-data">
		<label for="title">Title</label>
			<input type="text" name="title" id="title">
		<label for="byline">Byline</label>
			<input type="text" name="byline" id="byline">
		<label for="img">Upload Image:</label>
			<input type="file" name="img" id="img"><br>
		<label for="postContent">Content</label>
			<textarea rows="5" cols="50" name="postContent" id="postContent"></textarea>
		
		<input type="submit" value="Upload">
		<input type="hidden" name="mod" value="uploadPost">
	</form>
	
	<p id="outputArea"></p>

<?php
		
		$this->loadFooter();
	}
}
$main = new Edit();
?>


