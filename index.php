<?php
include('base/org.php');
class Index extends baseMod {
	function get(){}
	function post(){}
	function nodata(){}
	function doing(){}
	function view(){
		$this->loadHeader(true);
?>
	<script src="js/articleBrowse.js"></script>
	<script>
		function updateView(data){
			//console.log('updateView= '+data);
			
			var cmds = $.parseJSON(data);
			
			for(var i=0;i<cmds.length;i++){
				var row = $.parseJSON(cmds[i]);
				//console.log('row.cmd= '+row.cmd);
				switch(row.cmd){
					case 'PostData':
						receivePost($.parseJSON(row.data));
						$("html, body").animate({ scrollTop: 0 }, "slow");
						outputArea.innerHTML = '';
						break;
					case 'Pager':
						displayPager($.parseJSON(row.data));
						break;
				}
				
			}
		}
		function ready(){
			ready_ArticleBrowse();
		}
		
	</script>
	
	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Content -->
			<div id="content">
				<div id="content-inner">
					<!-- Post -->
					
					<!-- Pager -->
				
					<div class="pager" id="divPager">
						<a class="button previous" id="buttonPrevious" onclick="buttonPrevious();" style="cursor:pointer;">Previous Page</a>
						<div class="pages" id="pagerPages">
							<span id="previousHellip">&hellip;</span>
							<span id="nextHellip">&hellip;</span>
						</div>
						<a class="button next" id="buttonNext" onclick="buttonNext();" style="cursor:pointer;">Next Page</a>
					</div>
				</div>
				
			</div>

		<!-- Sidebar -->
			<div id="sidebar">
			
				<!-- Logo -->
					<div id="logo">
						<h1>PPG</h1>
					</div>
			
				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li class="current_page_item"><a href="#">Article Browse</a></li>
							<li><a href="#">Article Post</a></li>
							<li><a href="#">About PPG</a></li>
							<li><a href="#">Contact PPG</a></li>
						</ul>
					</nav>

				<!-- Search -->
					<section class="is-search">
						<form method="post" action="#">
							<input type="text" class="text" name="search" placeholder="Search" />
						</form>
					</section>
			
				<!-- Text -->
					<section class="is-text-style1">
						<div class="inner">
							<p>
								<strong>Striped:</strong> A free and fully responsive HTML5 site
								template designed by <a href="http://n33.co/">AJ</a> for <a href="http://html5up.net/">HTML5 up!</a>
							</p>
						</div>
					</section>
			
				<!-- Recent Posts -->
					<section class="is-recent-posts">
						<header>
							<h2>Recent Posts</h2>
						</header>
						<ul>
							<li><a href="#">Nothing happened</a></li>
							<li><a href="#">My Dearest Cthulhu</a></li>
							<li><a href="#">The Meme Meme</a></li>
							<li><a href="#">Now Full Cyborg</a></li>
							<li><a href="#">Temporal Flux</a></li>
						</ul>
					</section>
			
				<!-- Recent Comments -->
					<section class="is-recent-comments">
						<header>
							<h2>Recent Comments</h2>
						</header>
						<ul>
							<li>case on <a href="#">Now Full Cyborg</a></li>
							<li>molly on <a href="#">Untitled Post</a></li>
							<li>case on <a href="#">Temporal Flux</a></li>
						</ul>
					</section>
			
				

				<!-- Copyright -->
					<div id="copyright">
						<p>
							&copy; 2013 An Untitled Site.<br />
							Images: <a href="http://n33.co">n33</a>, <a href="http://fotogrph.com">fotogrph</a>, <a href="http://iconify.it">Iconify.it</a>
							Design: <a href="http://html5up.net/">HTML5 UP</a>
						</p>
					</div>

			</div>

	</div>	
	
	<div id="outputArea"></div>
		
<?php
		$this->loadFooter();
	}
}
$main = new Index();
?>


