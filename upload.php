<?php
include('base/org.php');
class Upload extends baseMod {
	function get(){}
	function post(){
		if(!isset($_POST['mod'])){
			echo "error mod";
			return;
		}
		switch($_POST['mod']){
			case 'uploadPost':
				
				if(	isset($_POST['title']) && 
					isset($_POST['byline']) && 
					isset($_POST['postContent'])){
					$title = mysql_real_escape_string($_POST['title']);
					$byline = mysql_real_escape_string($_POST['byline']);
					$postContent = mysql_real_escape_string($_POST['postContent']);
					$newName = "";
					
					if($_FILES['img']['error'] > 0){
						echo 'Return Code: '.$_FILES['img']['error'].'<br />';
					}else{
						
						if(file_exists('upload_images/'.$_FILES['img']['name'])){
							echo $_FILES['img']['name'].'already exists.';
						}else{
							$path_parts = pathinfo($_FILES["img"]["name"]);
							$file_extn = $path_parts['extension'];
							//$file_extn = end(explode(".", strtolower($_FILES['img']['name'])));
							$timestamp = time(); 
							$newName = 'img_'.date('YmdHis',$timestamp).'.'.$file_extn;
							move_uploaded_file($_FILES['img']['tmp_name'],
											'upload_images/'.$newName);
							chmod('upload_images/'.$newName, 0777);
							echo 'Image Stored in: '.'upload_images/'.$newName;
						}
					}
					
					$sql = "INSERT INTO `post`(	`poster_id`, 
												`title`, 
												`byline`, 
												`date`, 
												`img`, 
												`content`) 
										VALUES ('1',
												'".$title."',
												'".$byline."',
												NOW(),
												'".$newName."',
												'".$postContent."');";
					$result = mysql_query($sql) or die(mysql_error());
					
					if($result){
						echo 'Upload Success1';
						header("Location: edit.php");
					}else{
						echo "Upload error";
					}
				}else{
					echo "error input";
					return;
				}
				break;
			default:
					echo "default";
				break;
		}
	}
	function nodata(){}
	function doing(){}
	function view(){}
}
$main = new Upload();
?>


