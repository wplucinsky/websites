<?php

	class ImageResize {
		private $servername = getenv('SERVERNAME');
		private $username = getenv('USERNAME');
		private $password = getenv('PWD');
		private $dbname = getenv('DBNAME');
		private $image_base;
		private $size;

		/*
		Incoming File Structure
			"file" [
				"name" = "filename.jpg",
				"type" = "image/jpeg",
				"tmp_name" = "/tmp/phpn6HkG1",
				"error" = 0,
				"size" = 1015871
			]
		*/

		function __construct(){
			$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
			if ($this->conn->connect_error) {
				die("Connection failed: " . $this->conn->connect_error);
			}
		}

		public function start($key){
		/*
			This function recieves the uploaded image information and determines the 
			appropriate aspect ratio for the end image. It takes the key of the file
			in the $_FILES array.
		*/
			$this->key = $key;
			$this->size = getimagesize($_FILES['file']['tmp_name'][$this->key]);
			if ($this->size[0] > 200) {
				$ratio = $this->size[0] / $this->size[1];
				$this->newWidth = 200;
				$this->newHeight = 200 / $ratio;
			}

			return $this->createNewImage();
		}

		private function createNewImage(){
		/*
			This function gets the uploaded image width and height information and 
			creates a resized jpeg/png out of it.
		*/
			$this->name = str_replace(' ', '', $_FILES['file']['name'][$this->key]);
			move_uploaded_file($_FILES['file']['tmp_name'][$this->key], '../collage/orig/'.$this->name);
			$dst = imagecreatetruecolor($this->newWidth, $this->newHeight);

			if ($_FILES['file']['type'][$this->key] == 'image/jpeg') {
				return $this->fromJPEG($dst);
			} elseif ($_FILES['file']['type'][$this->key] == 'image/png') {
				return $this->fromPNG($dst);
			} else {
				return  array(	"filetype" => $_FILES["file"]["type"][$this->key], 
								"orig" => "", 
								"new" => "", 
								"size" => $this->newWidth . "px X " . $this->newHeight . "px",
								"error" => "ERROR: Invalid Filetype" );
			}
		}

		private function fromJPEG($dst){
		/*
			This function copies the old JPEG, resizes it, and places it onto a new JPEG image
		*/
			$src = imagecreatefromjpeg('../collage/orig/'.$this->name);
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $this->size[0], $this->size[1]);
			imagejpeg($src, '../collage/orig/'.$this->name); 
			imagejpeg($dst, '../collage/resize/'.$this->name);

			$this->upload();

			return array(	"filetype" => $_FILES["file"]["type"][$this->key], 
							"orig" => "../collage/orig/" . $this->name, 
							"new" => "../collage/resize/" . $this->name, 
							"size" => $this->newWidth . "px X " . $this->newHeight . "px",
							"error" => "" );
		}

		private function fromPNG($dst){
		/*
			This function copies the old PNG, resizes it, and places it onto a new PNG image
		*/
			$src = imagecreatefrompng('../collage/orig/'.$this->name);
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $this->size[0], $this->size[1]);

			imagepng($src, '../collage/orig/'.$this->name); 
			imagepng($dst, '../collage/resize/'.$this->name);

			$this->upload();

			return  array(	"filetype" => $_FILES["file"]["type"][$this->key], 
							"orig" => "../collage/orig/" . $this->name, 
							"new" => "../collage/resize/" . $this->name, 
							"size" => $this->newWidth . "px X " . $this->newHeight . "px",
							"error" => "" );
		}

		private function upload(){
		/*
			This function upload the image names and info to SQL to be viewed on the collage
			page later.
		*/
			$sql = "INSERT INTO `collage` (`imgname`, `orig_width`, `orig_height`, `new_width`, `new_height`) VALUES ('".$this->name."', '".$this->size[0]."', '".$this->size[1]."', '".$this->newWidth."', '".$this->newHeight."')";
			$result = $this->conn->query($sql);
		}
	}

	$data = array();
	if (isset($_FILES['file'])) {
		$resize = new ImageResize();
		foreach ($_FILES['file']['name'] as $key => $value) {
			$data[] = $resize->start($key);
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Douglas C. Roger - Image Uploader</title>
	<link rel="icon" type="image/png" href="/src/icons/logo-min.png">
	<meta name="description" content="Resize Images to 200px Width"/>
	<meta name="keywords" content="">
	<meta name="author" content="Will Plucinsky">
	<meta name="theme-color" content="#efefef">
	<meta name="msapplication-navbutton-color" content="#efefef">
	<meta name="apple-mobile-web-app-status-bar-style" content="#efefef">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display|Slabo+27px" rel="stylesheet">
	<style type="text/css">
		body { background-color: #efefef;}
		.playfair{ font-family: 'Playfair Display', serif; }
		.slabo { font-family: 'Slabo 27px', serif; font-size: 15px; }
		.slabo p { text-align: center; }
		a { text-decoration: none; color: black; }
		label { cursor: pointer; }
		.mainContainer { position: absolute; width: 100%; top: 30%; height: 200px; }
		.windowSize { width: 40%; margin: auto; text-align: center; }
		.height100 { height:100%; }
		/* START Nav Bar */
			.headerBar{
				width: 100%;position: absolute;top: 0px;left: 0px;height: 50px;background-color: white;
			}
			.spanGeneral{
				display: inline-block;margin-right: 20px;height: 100%;
			}
			.spanText{
				position: relative;top:15px;
			}
			.navbarText{
				width: 710px;margin: auto;
			}
			.logoHolder{
				height: 100%;position: absolute;top: 0px;
			}
			.lastSpan{
				margin-right: 0px;
			}
			#navToggle{
				display: none;
			}
			.barParent{
				position: absolute; right: 0px;top:0px;width: 65px;height: 50px;
			}
			.barHolder{
				position: relative;width: 30px; margin: auto;margin-top:-3px;margin-right: 14px;
			}
			.firstBar{
				width: 30px; height: 4px; background-color: black; border: 0px solid;border-radius: 3px;
			}
			.secondBar{
				width: 30px; height: 4px; background-color: black; border: 0px solid;border-radius: 3px;position: relative;top: 4px;
			}
			.thirdBar{
				width: 30px; height: 4px; background-color: black; border: 0px solid;border-radius: 3px;position: relative;top: 8px;
			}
			#menuToggle{
				display: none;
			}
		/* END Nav Bar */
		/* START Header */
			.subBox{
				position: relative;top: -20px;
			}
			.separatorBarSlimLeft{
				width: 38%;background-color: black;height: 2px;position: relative;top: 15px;float: left;
			}
			.subTitle{
				width: 20%;margin: auto;position: relative;top: 0px;font-style: italic;
			}
			.separatorBarSlimRight{
				width: 36%;background-color: black;height: 2px;float: right;position: relative;top: -15px;
			}
		/* END Header */
		/* START Viewbox Size */
			@media screen and (max-width:950px){
				.windowSize{
					width: 80%; 
				}
			}

			@media screen and (max-width:767px){
				#navToggle{
					display: block;
				}
				.spanGeneral{
					display: block;margin-bottom: 10px;text-align: right;height: 50%;
				}
				.lastSpan{
					margin-right: 20px;margin-bottom: 20px;
				}
				.navbarText{
					width: 220px;margin-top: 50px;float: right;background-color: white;position: relative;z-index: 1000;
				}
				.firstSpan{
					margin-top:20px;
				}
				#menu{
					display: none;
				}
				.spanText{
					top:0px;
				}
			}

			@media screen and (max-width:500px){    
				.subTitle {
					width: 30%; 
				}
				.separatorBarSlimLeft {
					width: 30%;
				}
				.separatorBarSlimRight{
					width: 30%;
				}
				.noPadding{
					width: 100%;
				}
			}

			#menuToggle:checked + #menu {
				display: block !important;
			}
		/* END Viewbox Size */

		.box { width: 250px; margin: auto; }
		.box #file { width: 185px; float: left; }
		.box #submit { padding: 0; float: right; }
	</style>
<body>
	<div class="headerBar">
		<div class="logoHolder">
			<div class="height100">
				<img src='/src/icons/logo.svg' class="height100">
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
			<a href="/index.html">
				<div class="spanGeneral firstSpan">
					<span class="spanText slabo">
						<div>HOME</div>
					</span>
				</div>
			</a>
			<a href="/education.html">
				<div class="spanGeneral">
					<span class="spanText slabo">
						<div>EDUCATION</div>
					</span>
				</div>
			</a>
			<a href="/experience.html">
				<div class="spanGeneral">
					<span class="spanText slabo">
						<div>PROFESSIONAL EXPERIENCE</div>
					</span>
				</div>
			</a>
			<a href="/community.html">
				<div class="spanGeneral">
					<span class="spanText slabo">
						<div>COMMUNITY PARTICIPATION</div>
					</span>
				</div>
			</a>
			<a href="/personal.html">
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
				<h1 class='playfair'>IMAGE UPLOADER</h1>
				<div class="subBox">
					<span class="separatorBarSlimLeft"></span>
						<h2 class='playfairm subTitle'>Script</h2>
					<span class="separatorBarSlimRight"></span>
				</div>
			</div>
		</div>
		<?php
		if (sizeof($data) > 0) {
			$errors = 0;
			foreach ($data as $key => $value) { $errors += ($value['error'] == "") ? 0 : 1; }
			$error = $errors == 1 ? 'Error' : 'Errors';

			echo '<div><p class="slabo" style="text-align: center; margin-bottom: 0px;">'.sizeof($data).' Images Uploaded</p></div>';
			echo '<div><p class="slabo" style="text-align: center; margin-top: 0px;">'.$errors.' '.$error.' Occurred</p></div>';
		} else {
			echo '<div><p class="slabo" style="text-align: center; margin-top: 0px;">Select JPEG and PNG Images to Upload to Collage</p></div>';
		}
		?>
		<div class="windowSize">
			<form action="collage.php" method="post" enctype="multipart/form-data">
				<div class="box">
					<input type="file" id="file" name="file[]" accept="image/*" multiple>
					<input type="submit" id="submit">
				</div>
			</form>
		</div>
	</div>
</body>
</html>