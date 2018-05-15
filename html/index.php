<?php include("include/header.php"); ?>

<div id="fullscreen">
	<div id="screen-index" class="page">
		<div class="header"><div class="leftbutton"><img src="images/menu.png" width=50 height=50 onclick="toggleMenu()"></div><div class="rightbutton"><img src="images/pixel.gif" width=50 height=50></div><div class="title">Albums</div></div>
		<div class="header-pad"> </div>
		<div id="albumlist"></div>
	</div>

	<div id="screen-album-0" class="page nodisplay">
		<div class="header"><div class="leftbutton"><img id="album-back-0" src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/pixel.gif" width=50 height=50></div><div class="title" id="album-title-0"></div></div>
		<div class="header-pad"> </div>
		<div id="imagelist-0"></div>
	</div>

	<div id="screen-album-1" class="page nodisplay">
		<div class="header"><div class="leftbutton"><img id="album-back-1" src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/pixel.gif" width=50 height=50></div><div class="title" id="album-title-1"></div></div>
		<div class="header-pad"> </div>
		<div id="imagelist-1"></div>
	</div>

	<div id="screen-image-0" class="screen-image page nodisplay">
		<div class="image-header"><div class="leftbutton"><img src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/download.png" width=50 height=50 onclick="downloadImage()"></div><div id="img-title-0" class="title"></div></div>
		<img id="mainimg-thumb-0" class="mainimg-thumb" src="">
		<img id="mainimg-0" class="mainimg" src="">
		<video id="mainvid-0" class="mainvid" src="" type="video/mp4" controls>
	</div>

	<div id="screen-image-1" class="screen-image page nodisplay">
		<div class="image-header"><div class="leftbutton"><img src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/download.png" width=50 height=50 onclick="downloadImage()"></div><div id="img-title-1" class="title"></div></div>
		<img id="mainimg-1" class="mainimg" src="">
		<video id="mainvid-1" class="mainvid" src="" type="video/mp4" controls>
	</div>

	<div id="screen-image-2" class="screen-image page nodisplay">
		<div class="image-header"><div class="leftbutton"><img src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/download.png" width=50 height=50 onclick="downloadImage()"></div><div id="img-title-2" class="title"></div></div>
		<img id="mainimg-2" class="mainimg" src="">
		<video id="mainvid-2" class="mainvid" src="" type="video/mp4" controls>
	</div>

	<div id="screen-image-3" class="screen-image page nodisplay">
		<div class="image-header"><div class="leftbutton"><img src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/download.png" width=50 height=50 onclick="downloadImage()"></div><div id="img-title-3" class="title"></div></div>
		<img id="mainimg-3" class="mainimg" src="">
		<video id="mainvid-3" class="mainvid" src="" type="video/mp4" controls>
	</div>

	<div id="screen-image-4" class="screen-image page nodisplay">
		<div class="image-header"><div class="leftbutton"><img src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/download.png" width=50 height=50 onclick="downloadImage()"></div><div id="img-title-4" class="title"></div></div>
		<img id="mainimg-4" class="mainimg" src="">
		<video id="mainvid-4" class="mainvid" src="" type="video/mp4" controls>
	</div>

	<div id="screen-login" class="page">
		<div class="header"><div class="leftbutton"><img src="images/pixel.gif" width=50 height=50></div><div class="rightbutton"><img src="images/pixel.gif" width=50 height=50></div><div class="title">Login</div></div>
		<div class="header-pad"> </div>
		<div class="header-pad"> </div>
		<center>
		<div id="error" class="error">Invalid username or password.<p></div>
		<form method="POST" action="login.php">
			<div class="fieldlabel">Username</div>
			<div class="fieldinputdiv"><input type="text" size=20 class="fieldinput" id="username" name="username"></div>
			<div class="header-pad"> </div>
			<div class="fieldlabel">Password</div>
			<div class="fieldinputdiv"><input type="password" size=20 class="fieldinput" id="password" name="password"></div>
			<div class="header-pad"> </div>
			<div class="fieldinputdiv"><input type="submit" class="fieldbutton" value="Login" id="submit"></div>
		</form>
		</center>
	</div>

	<div id="menushade" onclick="toggleMenu()">&nbsp;</div>

	<div id="menu">
		<div id="menutop">
			<img src="images/settings.png">
			<br>
			<br>
			Options
		</div>
		<div onclick="toggleView()">
			<div class="menuimage"><img id="viewimg" src="images/menu-folder.png"></div>
			<div class="menutext" id="view">View as folders</div>
		</div>
		<div id="logoutmenu" onclick="logout()">
			<div class="menuimage"><img src="images/menu-logout.png"></div>
			<div class="menutext">Logout</div>
		</div>
	</div>

	<div id="nav-next" onclick="swipeL()"><img src="images/nav-next.png"></div>
	<div id="nav-prev" onclick="swipeR()"><img src="images/nav-prev.png"></div>
</div>

<?php include("include/footer.php"); ?>
