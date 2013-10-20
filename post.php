<?php
define("POSTCOUNT_PERPAGE", 2);
include('base/org.php');
class Index extends baseMod {
	function get(){}
	function post(){
		if(isset($_POST['mod'])){
			switch($_POST['mod']){
				case 'requestPost':
					if(isset($_POST['p'])){
						if($_POST['p']!==""){
								
							$sql = "SELECT COUNT(*) FROM `post`;";
							$result = mysql_query($sql) or die("MySQL query error");
							$row = mysql_fetch_row($result);
							$postCount = $row[0];
							$requestPage = intval($_POST['p']);
							
							if($requestPage > 0 && $postCount > 0){
							
								$finalResult = array();
								$msg1 = array();
								$msg1['cmd'] = 'Pager';
								
								$arr = array();
								$arr['startPage'] = 1;
								$arr['nowPage'] = $requestPage;
								$arr['endPage'] = ($postCount%POSTCOUNT_PERPAGE > 0)?
													floor($postCount/POSTCOUNT_PERPAGE) + 1:
													$postCount/POSTCOUNT_PERPAGE;
								$msg1['data'] = json_encode($arr);
								$finalResult[] = json_encode($msg1);
							
								$msg = array();
								
								$from_r = $requestPage*POSTCOUNT_PERPAGE-POSTCOUNT_PERPAGE;
								$from_r = ($from_r<1)?0:$from_r;
								
								$sql = "SELECT `poster_id`, `title`, `byline`, `date`, `img`, `content` FROM `post` ORDER BY `id` LIMIT	".$from_r.",".POSTCOUNT_PERPAGE.";";
								$result = mysql_query($sql) or die(mysql_error());
								
								$arr = array();
								$count = 0;

								while ($row = mysql_fetch_assoc($result)) {
									$pack = array();
									$pack['title'] = $row['title'];
									$pack['byline'] = $row['byline'];
									$pack['date'] = strtotime($row['date']);
									$pack['img'] = $row['img'];
									$pack['content'] = $row['content'];
									
									$arr[$count] = json_encode($pack);
									$count++;
								}
								
								$msg['cmd'] = 'PostData';
								$msg['data'] = json_encode($arr);
								
								$finalResult[] = json_encode($msg);
								echo json_encode($finalResult);
							}
						}
					}
					break;
			}
		}
	}
	function nodata(){}
	function doing(){}
	function view(){}
}
$main = new Index();
?>


