<?php
include('base/org.php');
class Index extends baseMod {
	function get(){}
	function post(){
		
	}
	function nodata(){}
	function doing(){}
	function view(){
		$this->loadHeader(true);
?>
	<script>
		var _nowPage=1;
		var _articleUnits = [];
		var _pagerUnits = [];
		var _previousHellip, _nextHellip;
		
		function PagerUnit(startPage,nowPage,endPage,myPage,view){
			this.startPage = startPage;
			this.nowPage = nowPage;
			this.endPage = endPage;
			this.myPage = myPage;
			this.view = view;
		}
		PagerUnit.prototype = {
			show: function(){
				switch(this.myPage){
					case -1:
						if(this.nowPage-this.startPage > 3){
							this.view.style.display = "";
						}else{
							this.view.style.display = "none";
						}
						break;
					case -2:
						if(this.endPage-this.nowPage > 3){
							this.view.style.display = "";
						}else{
							this.view.style.display = "none";
						}
						break;
					default:
						
						if(this.myPage==this.nowPage){
							this.view.className = 'active';
							this.view.style.cursor="default";
							this.view.setAttribute("onclick", "");
						}else{
							this.view.className = '';
							this.view.style.cursor="pointer";
							this.view.setAttribute("onclick", "changePage(this)");
						}
						
						if(Math.abs(this.myPage-this.nowPage) > 2 &&
							this.myPage !== this.startPage &&
							this.myPage !== this.endPage)
						{
							this.view.style.display = "none";
						}else{
							this.view.style.display = "";
						}
						
						break;
				}
			},
			updatePageStatus: function(startPage,nowPage,endPage){
				this.startPage = startPage;
				this.nowPage = nowPage;
				this.endPage = endPage;
			}
		}
		function ArticleUnit(title,byline,date,img,content,num){
			
			var ci = document.getElementById('content-inner');
			
			var a = document.createElement("article");
			a.id = "articleUnit_"+num;
			a.className = "is-post is-post-excerpt";
			
			var ah = document.createElement("header");
			var ah2 = document.createElement("h2");
			ah2.innerHTML = '<a id="titleArea_'+num+'"></a>';
			var ahs = document.createElement("span");
			ahs.id = "bylineArea_"+num;
			ahs.className = "byline";
			ah.appendChild(ah2);
			ah.appendChild(ahs);
			
			var ad = document.createElement("div");
			ad.className = "info";
			var ads = document.createElement("span");
			ads.className = "date";
			var adssm = document.createElement("span");
			adssm.id = "MDateArea_"+num;
			adssm.className = "month";
			var adssd = document.createElement("span");
			adssd.id = "DDateArea_"+num;
			adssd.className = "day";
			var adssy = document.createElement("span");
			adssy.id = "YDateArea_"+num;
			adssy.className = "year";
			ads.appendChild(adssm);
			ads.appendChild(adssd);
			ads.appendChild(adssy);
			ad.appendChild(ads);
			
			var adu = document.createElement("ul");
			adu.className = "stats";
			var adul1 = document.createElement("li");
			adul1.innerHTML = '<a href="#" class="link-icon24 link-icon24-1">16</a>';
			var adul2 = document.createElement("li");
			adul2.innerHTML = '<a href="#" class="link-icon24 link-icon24-2">32</a>';
			var adul3 = document.createElement("li");
			adul3.innerHTML = '<a href="#" class="link-icon24 link-icon24-3">64</a>';
			var adul4 = document.createElement("li");
			adul4.innerHTML = '<a href="#" class="link-icon24 link-icon24-4">128</a>';
			adu.appendChild(adul1);
			adu.appendChild(adul2);
			adu.appendChild(adul3);
			adu.appendChild(adul4);
			ad.appendChild(adu);
			
			var aa = document.createElement("a");
			aa.id = "imageArea_"+num;
			aa.className = "image image-full";
			//aa.href = "#";
			var ap = document.createElement("p");
			ap.id = "contentArea_"+num;
			
			a.appendChild(ah);
			a.appendChild(ad);
			a.appendChild(aa);
			a.appendChild(ap);
			ci.insertBefore(a,document.getElementById('divPager'));
			
			this.title = title;
			this.byline = byline;
			this.date = date;
			this.img = img;
			this.content = content;
			this.num = num;
			this.view = a;
		}
		ArticleUnit.prototype = {
			show: function(){
				
				var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];

				document.getElementById('titleArea_'+this.num).innerHTML = this.title;
				document.getElementById('bylineArea_'+this.num).innerHTML = this.byline;
				document.getElementById('MDateArea_'+this.num).innerHTML = months[this.date.getMonth()];
				document.getElementById('DDateArea_'+this.num).innerHTML = this.date.getDate();
				document.getElementById('YDateArea_'+this.num).innerHTML = this.date.getFullYear();
				if(this.img == "" || this.img == undefined){
					document.getElementById('imageArea_'+this.num).innerHTML = '';
				}else{
					document.getElementById('imageArea_'+this.num).innerHTML = '<img src="upload_images/'+this.img+'" alt="" />';
				}
				document.getElementById('contentArea_'+this.num).innerHTML = this.content;
				this.display(true);
			},
			updateInfo: function(title,byline,date,img,content){
				this.title = title;
				this.byline = byline;
				this.date = date;
				this.img = img;
				this.content = content;
			},
			display: function(s){
				if(s===true){
					this.view.style.display = "";
				}else{
					this.view.style.display = "none";
				}
			}
		}
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
		function receivePost(data){
			
			_articleUnits.map(function(a){a.display(false);});
			
			var size = 0, key;
			for (key in data) {
			    if (data.hasOwnProperty(key)) size++;
			}
			
			for(var i=0;i<size;i++){
				
				var pack=$.parseJSON(data[i]);
				var a = document.getElementById('articleUnit_'+i);
				
				if(a===null){
					_articleUnits.push(new ArticleUnit(	pack.title,
										pack.byline,
										new Date(pack.date*1000),
										pack.img,
										pack.content,
										i));
				}else{
					_articleUnits[i].updateInfo(	pack.title,
									pack.byline,
									new Date(pack.date*1000),
									pack.img,
									pack.content);
				}
				
				_articleUnits[i].show();
			}
		}
		function requestPost(p){
			outputArea.innerHTML = 'loading...';
			var str = 	"mod=requestPost" +
						"&p="+p;
			xmlhttp.open('POST', 'post.php', true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send(str);
		}
		function ready(){
			_previousHellip = new PagerUnit(1,1,1,-1,document.getElementById('previousHellip'));
			_nextHellip = new PagerUnit(1,1,1,-2,document.getElementById('nextHellip'));
			
			requestPost(_nowPage);
		}
		function displayPager(data){
			var startPage = data.startPage;
			var nowPage = data.nowPage;
			var endPage = data.endPage;
			
			_nowPage = nowPage;
			var pPages = document.getElementById('pagerPages');
			var pBtn = document.getElementById('buttonPrevious');
			var nBtn = document.getElementById('buttonNext');
			
			if(startPage==nowPage)	pBtn.style.display="none";
			else			pBtn.style.display="";
			if(endPage==nowPage)	nBtn.style.display="none";
			else			nBtn.style.display="";
			
			//pagerPages
			for(var i=1;i<=endPage;i++){
				
				var a = document.getElementById('pagerUnit_'+i);
				
				if(a===null){
					a = document.createElement("a");
					a.id = 'pagerUnit_'+i;
					a.innerHTML = i;
					pPages.appendChild(a);
					_pagerUnits.push(new PagerUnit(startPage,nowPage,endPage,i,a));
				}
			}
			
			_pagerUnits.map(function(u){
				u.updatePageStatus(startPage,nowPage,endPage);
				u.show();
			});
			
			$(_previousHellip.view).insertAfter(_pagerUnits[0].view);
			pPages.insertBefore(_nextHellip.view,_pagerUnits[_pagerUnits.length-1].view);
			_previousHellip.updatePageStatus(startPage,nowPage,endPage);
			_nextHellip.updatePageStatus(startPage,nowPage,endPage);
			_previousHellip.show();
			_nextHellip.show();
		}
		function changePage(n){
			requestPost(n.innerHTML)
		}
		function buttonPrevious(){
			requestPost(_nowPage-1);
		}
		function buttonNext(){
			requestPost(_nowPage+1);
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
							<li class="current_page_item"><a href="#">Latest Post</a></li>
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


