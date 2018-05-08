<?php include("include/header.php"); ?>

<div id="fullscreen">
	<div id="screen-index" class="page">
		<div class="header"><div class="leftbutton"><img src="images/pixel.gif" width=50 height=50></div><div class="rightbutton"><img src="images/pixel.gif" width=50 height=50></div><div class="title">Albums</div></div>
		<div class="header-pad"> </div>
		<div id="albumlist"></div>
	</div>

	<div id="screen-album" class="page nodisplay">
		<div class="header"><div class="leftbutton"><img src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/pixel.gif" width=50 height=50></div><div class="title" id="album-title"></div></div>
		<div class="header-pad"> </div>
		<div id="imagelist"></div>
	</div>

	<div id="screen-image-0" class="screen-image page nodisplay">
		<div class="image-header"><div class="leftbutton"><img src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/download.png" width=50 height=50 onclick="downloadImage()"></div><div id="img-title-0" class="title"></div></div>
		<img id="mainimg-thumb-0" class="mainimg-thumb" src="">
		<img id="mainimg-0" class="mainimg" src="">
	</div>

	<div id="screen-image-1" class="screen-image page nodisplay">
		<div class="image-header"><div class="leftbutton"><img src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/download.png" width=50 height=50 onclick="downloadImage()"></div><div id="img-title-1" class="title"></div></div>
		<img id="mainimg-1" class="mainimg" src="">
	</div>

	<div id="screen-image-2" class="screen-image page nodisplay">
		<div class="image-header"><div class="leftbutton"><img src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/download.png" width=50 height=50 onclick="downloadImage()"></div><div id="img-title-2" class="title"></div></div>
		<img id="mainimg-2" class="mainimg" src="">
	</div>

	<div id="screen-image-3" class="screen-image page nodisplay">
		<div class="image-header"><div class="leftbutton"><img src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/download.png" width=50 height=50 onclick="downloadImage()"></div><div id="img-title-3" class="title"></div></div>
		<img id="mainimg-3" class="mainimg" src="">
	</div>

	<div id="screen-image-4" class="screen-image page nodisplay">
		<div class="image-header"><div class="leftbutton"><img src="images/back.png" width=50 height=50 onclick="window.history.back();"></div><div class="rightbutton"><img src="images/download.png" width=50 height=50 onclick="downloadImage()"></div><div id="img-title-4" class="title"></div></div>
		<img id="mainimg-4" class="mainimg" src="">
	</div>
</div>

<?php include("include/footer.php"); ?>
