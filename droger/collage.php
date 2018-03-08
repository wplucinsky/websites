<?php
	require_once('src/scripts/droger.php');
	$droger = new droger();
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Douglas C. Roger - Personal Collage</title>
		<link rel="icon" type="image/png" href="src/icons/logo-min.png">
		<meta name="description" content=""/>
		<meta name="keywords" content="">
		<meta name="author" content="Will Plucinsky">
		<meta name="theme-color" content="#efefef">
		<meta name="msapplication-navbutton-color" content="#efefef">
		<meta name="apple-mobile-web-app-status-bar-style" content="#efefef">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link href="https://fonts.googleapis.com/css?family=Playfair+Display|Slabo+27px" rel="stylesheet">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<script src="src/js/masonry.pkgd.min.js"></script>
		<link rel="stylesheet" type="text/css" href="src/style/style.css">
	</head>
	<body>
		<div class="headerBar">
			<div class="logoHolder">
				<div class="height100">
					<img src='src/icons/logo.svg' class="height100">
				</div>
			</div>

			<label for="menuToggle" id="navToggle">
				<div class="barParent">
					<div class="barHolder">
					&#8203;
						<div class="firstBar"></div>
						<div class="secondBar"></div>
						<div class="thirdBar"></div>
					</div>
				</div>
			</label>
			<input type="checkbox" id="menuToggle"/>

			<div class="navbarText" id="menu">
				<a href="index.html">
					<div class="spanGeneral firstSpan">
						<span class="spanText slabo">
							<div>HOME</div>
						</span>
					</div>
				</a>
				<a href="education.html">
					<div class="spanGeneral">
						<span class="spanText slabo">
							<div>EDUCATION</div>
						</span>
					</div>
				</a>
				<a href="experience.html">
					<div class="spanGeneral">
						<span class="spanText slabo">
							<div>PROFESSIONAL EXPERIENCE</div>
						</span>
					</div>
				</a>
				<a href="community.html">
					<div class="spanGeneral">
						<span class="spanText slabo">
							<div>COMMUNITY PARTICIPATION</div>
						</span>
					</div>
				</a>
				<a href="personal.html">
					<div class="spanGeneral lastSpan">
						<span class="spanText slabo">
							<div>PERSONAL INTERESTS</div>
						</span>
					</div>
				</a>
			</div>

		</div>
		<div class="mainContainer">

			<div class="windowSize">
				<div>
					<h1 class='playfair'>DOUGLAS C. ROGER</h1>
					<div class="subBox">
						<span class="separatorBarSlimLeft"></span>
							<h2 class='playfairm subTitle'>Collage</h2>
						<span class="separatorBarSlimRight"></span>
					</div>
				</div>
			</div>

			<div class="collage">
				<div>
					<div id="grid">
						<?php 
						$collage = $droger->getCollage();
						foreach ($collage as $key => $value) { 
							echo '<div class="item"><img src="src/collage/resize/'. $value['imgname'].'"></div>';
						} 
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="mainContainer marginTop">
			<div class="windowSize noPadding">
				<div class="separatorBar">
					<div class="leftWhiteBox"></div>
					<div class="leftBox"></div>
					<div class="topBar"></div>
					<div class="topBarSub"></div>
					<div class="midBar"></div>
					<div class="bottomBarSub"></div>
					<div class="bottomBar"></div>
					<div class="rightBox"></div>
					<div class="rightWhiteBox"></div>
				</div>
			</div>

			<div class="windowSize noPadding">
				<div>
					<div class="addressBox">
						<span class="addressStreet slabo"><a target="_blank" href="https://www.google.com/maps/place/14+S+Plum+St,+Media,+PA+19063/@39.9186189,-75.3924742,17z/data=!4m5!3m4!1s0x89c6e9087ba41ac9:0x5bcab6135ccb6e59!8m2!3d39.9186189!4d-75.3902856">14 South Plum Street</a></span>
						<span class="addressCity slabo"><a target="_blank" href="https://www.google.com/maps/place/14+S+Plum+St,+Media,+PA+19063/@39.9186189,-75.3924742,17z/data=!4m5!3m4!1s0x89c6e9087ba41ac9:0x5bcab6135ccb6e59!8m2!3d39.9186189!4d-75.3902856">Media, PA 19063</a></span>
						<div class="addressBullet"></div>
					</div>
					<div class="contactBox">
						<span class="contactPhone slabo"><a href="tel:6105652010">610 565 2010</a></span>
						<span class="contactEmail slabo"><a href="mailto:drogerjr@gmail.com">drogerjr@gmail.com</a></span>
						<div class="contactBullet slabo"></div>
					</div>
				</div>
			</div>

		</div>
		<script type="text/javascript">
			$(function(){
				$('#grid').masonry({
					// options
					isFitWidth: true,
					itemSelector : '.item',
					columnWidth : 220
				});
			})

			console.log(" __    __ _ _ _     ___ _            _           _          \n/ / /\\ \\ (_) | |   / _ \\ |_   _  ___(_)_ __  ___| | ___   _ \n\\ \\/  \\/ / | | |  / /_)/ | | | |/ __| | '_ \\/ __| |/ / | | |\n \\  /\\  /| | | | / ___/| | |_| | (__| | | | \\__ \\   <| |_| |\n  \\/  \\/ |_|_|_| \\/    |_|\\__,_|\\___|_|_| |_|___/_|\\_\\\\__, |\n                                                       |___/ \n    Linkedin: https://www.linkedin.com/in/willplucinsky");
		</script>
	</body>
</html>