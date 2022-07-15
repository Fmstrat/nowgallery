var albums, images, ismobile, wh;
var wha = [];
var curScreen = "listing";
var curScroll = 0;
var curAlbumScroll = 0;
var loadingImages = false;
var imagesLoaded = false;
var loadpos = 0;
var curImage = 0;
var curAlbum = 0;
var thisImage, nextImage, prevImage, nextNextImage, prevPrevImage;
var albumHistory = [];
var albumNameHistory = [];
var imgCount, dirCount = 0;

function containLinks() {
	// Mobile Safari in standalone mode
	if(("standalone" in window.navigator) && window.navigator.standalone){
		// If you want to prevent remote links in standalone web apps opening Mobile Safari, change 'remotes' to true
		var noddy, remotes = true;
		document.addEventListener('click', function(event) {
			noddy = event.target;
			// Bubble up until we hit link or top HTML element. Warning: BODY element is not compulsory so better to stop on HTML
			while(noddy.nodeName !== "A" && noddy.nodeName !== "HTML") {
				noddy = noddy.parentNode;
			}
			if('href' in noddy && noddy.href.indexOf('http') !== -1 && (noddy.href.indexOf(document.location.host) !== -1 || remotes)) {
				event.preventDefault();
				document.location.href = noddy.href;
			}
		},false);
	}
}

function mobileCheck() {
	var check = false;
	(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
	return check;
}

function dirname(path) {
	return path.replace(/\\/g,'/').replace(/\/[^\/]*$/, '');
}

function logout() {
	if (loggedInUsername != '')
		window.location = "logout.php";
}

//function login() {
	//var username = $('#username').val();
	//var password = $('#password').val();
	//$.post("ajax/login.php", { username: username, password: password }, function(data) {
		//alert(data);
		//if (data == 'SUCCESS') {
			//$('#screen-login').hide();
			//loadAlbums();
			//loggedIn = true;
		//} else {
			//alert("Invalid username or password.");
		//}
	//});
//}

function loadAlbums() {
	$.get("ajax/albumlist.php", function(data) {
		albums = JSON.parse(data);
		var html = "";
		albums.forEach(function(o,i) {
			let cover = encodeURI(o.cover).replace("?", "%3F");
			html += '<div id="wrapper" onclick="openAlbum('+i+',true)">';
			html += '<div id="first"><img src="'+cover+'"></div>';
			html += '<div id="second"><p>'+o.album+'</p></div>';
			html += '</div>';
		});
		$('#albumlist').html(html);
		$('#screen-index').show();
		$('#screen-album-0').hide();
		$('#screen-album-1').hide();
		$('#screen-image-0').hide();
		$('#screen-image-1').hide();
		$('#screen-image-2').hide();
		$('#screen-image-3').hide();
		$('#screen-image-4').hide();
	});
}

function loadDirectories() {
	curAlbum = 0;
	albumHistory = [];
	albumNameHistory = [];
	openAlbum(systemWebimages+"/thumb/", true, false, false, true);
	$('#view').text("View in albums");
	$('#viewimg').attr("src", "images/menu-album.png");
	$('#screen-index').hide();
	$('#screen-album-0').show();
	$('#screen-album-1').hide();
	$('#screen-image-0').hide();
	$('#screen-image-1').hide();
	$('#screen-image-2').hide();
	$('#screen-image-3').hide();
	$('#screen-image-4').hide();
}

function openListing() {
	curScreen = "listing"
	loadingImages = false;
	$('#view').text("View in folders");
	$('#viewimg').attr("src", "images/menu-folder.png");
	$("#screen-index").toggle("slide", {direction: "left"}, 500);
	$("#screen-album-"+curAlbum).toggle("slide", {direction: "right"}, 500);
}

function backOneAlbum() {
	if (albumHistory.length > 1)
		openAlbum("", false, true, true);
}

function openAlbum(i, addToHistory, subdir, back, root) {
	if (addToHistory)
		window.history.pushState({ noBackExitsApp: true }, '')
	curScreen = "album";
	var ap = "ajax/album.php";
	var displayname = "";
	if (back) {
		ap = albumHistory.pop();
		displayname = albumNameHistory.pop();
		ap = albumHistory[albumHistory.length-1];
		displayname = albumNameHistory[albumNameHistory.length-1];
	} else {
		if (!Number.isInteger(i)) {
			ap += "?r=0&d=1&p="+i;
			displayname = "Images";
		} else {
			if (!subdir) {
				ap += "?r=1&d=0&p="+albums[i].albumpath;
				displayname = albums[i].album;
			} else {
				ap += "?r=0&d=1&p="+images[i].src;
				displayname = images[i].name;
			}
		}
		if (showDirectories) {
			albumHistory.push(ap);
			albumNameHistory.push(displayname);
		}
	}
	if (showDirectories) {
		if (albumHistory.length == 1) {
			$('#album-back-0').attr("src", "images/menu.png");
			$('#album-back-1').attr("src", "images/menu.png");
			$('#album-back-0').attr("onclick", "toggleMenu()");
			$('#album-back-1').attr("onclick", "toggleMenu()");
		} else {
			$('#album-back-0').attr("src", "images/back.png");
			$('#album-back-1').attr("src", "images/back.png");
			$('#album-back-0').attr("onclick", "window.history.back()");
			$('#album-back-1').attr("onclick", "window.history.back()");
		}
	} else {
		$('#album-back-0').attr("src", "images/back.png");
		$('#album-back-0').attr("onclick", "backToAlbumList()");
	}
	$.get(ap, function(data) {
		images = JSON.parse(data);
		var prevyear = -1;
		var prevmonth = "";
		var html = "<center>";
		var imgAlbum = curAlbum;
		if (subdir)
			if (curAlbum == 0)
				imgAlbum = 1;
			else
				imgAlbum = 0;
		if (showDirectories) {
			dirCount = 0;
			images.forEach(function(o,i) {
				if (o.type == "dir") {
					html += '<div class="thumbdiv" style="width: '+wh+'px">';
					html += '<img width='+wh+' height='+wh+' onclick="openAlbum('+i+', true, true)" id="img-'+imgAlbum+'-'+o.id+'" class="thumb" src="images/folder.png">'+o.name;
					html += '</div>';
					dirCount++;
				}
			});
		}
		imgCount = 0;
		images.forEach(function(o,i) {
			if (o.type != "dir") {
				if (o.year != prevyear || o.month != prevmonth) {
					if (o.year == 0)
						html += '<div class="datetext">Unknown</div>';
					else
						html += '<div class="datetext">'+o.month+', '+o.year+'</div>';
					prevyear = o.year;
					prevmonth = o.month;
				}
				html += '<div class="thumbdiv">';
				html += '<img width='+wh+' height='+wh+' onclick="openImage('+i+')" id="img-'+imgAlbum+'-'+o.id+'" class="thumb" src="images/image.png">';
				html += '</div>';
				imgCount++;
			}
		});
		html += "</center>";
		if (!subdir) {
			curAlbum = 0;
			$('#imagelist-0').html(html);
			$('#album-title-0').text(displayname);
			if (root) {
				$("#screen-album-"+curAlbum).show();
				$("#screen-index").hide();
			} else {
				$("#screen-index").toggle("slide", {direction: "left"}, 500);
				$("#screen-album-0").toggle("slide", {direction: "right"}, 500);
			}
			$("#screen-album-0").scroll(function() {
				clearTimeout($.data(this, 'scrollTimer'));
				$.data(this, 'scrollTimer', setTimeout(function() {
					stoppedScrolling();
				}, 250));
			});
		} else {
			var nextAlbum = 1;
			if (curAlbum == 1)
				nextAlbum = 0;
			$('#imagelist-'+nextAlbum).html(html);
			$('#album-title-'+nextAlbum).text(displayname);
			if (!back) {
				$("#screen-album-"+curAlbum).toggle("slide", {direction: "left"}, 500);
				$("#screen-album-"+nextAlbum).toggle("slide", {direction: "right"}, 500);
			} else {
				$("#screen-album-"+curAlbum).toggle("slide", {direction: "right"}, 500);
				$("#screen-album-"+nextAlbum).toggle("slide", {direction: "left"}, 500);
			}
			//$('#imagelist-'+curAlbum).html("");
			$("#screen-album-"+nextAlbum).scroll(function() {
				clearTimeout($.data(this, 'scrollTimer'));
				$.data(this, 'scrollTimer', setTimeout(function() {
					stoppedScrolling();
				}, 250));
			});
			curAlbum = nextAlbum;
		}
		loadImages();
	});
}

function backToAlbumList() {
	window.history.back();
	setTimeout(function() {
		document.getElementById('screen-index').scrollTop = curAlbumScroll;
	}, 1000);
}

function loadImages() {
	loadpos = 0;
	loadingImages = true;
	imagesLoaded = false;
	function iteration() {
		if (loadingImages && loadpos < imgCount) {
			while (loadpos < images.length && images[loadpos].loaded == 1) {
				loadpos++;
			}
			if (loadpos < images.length) {
				if (images[loadpos].type != "dir") {
					let img = webimages+"/thumb/"+encodeURI(images[loadpos].src).replace("?", "%3F");
					$('#img-'+curAlbum+'-'+loadpos).attr("src", img);
				}
				images[loadpos].loaded = 1;
				loadpos += 1;
				if (loadpos < images.length)
					setTimeout(iteration, 10);
				else
					checkAllLoaded();
			} else {
				checkAllLoaded();
			}
		}
	}
	iteration();
}

function checkAllLoaded() {
	var allloaded = true;
	for (var i = 0; i < images.length; i++) {
		if (images[i].loaded == 0) {
			allloaded = false;
			break;
		}
	}
	if (!allloaded)
		loadImages();
	else
		imagesLoaded = true;
}

function stopLoadingImages() {
	loadingImages = false;
}

function scrollBack() {
	setTimeout(function() {
		document.getElementById('screen-album-'+curAlbum).scrollTop = curScroll;
	}, 1000);
}

function stoppedScrolling() {
	curScroll = $('#screen-album-'+curAlbum).scrollTop();
	if (!imagesLoaded) {
		var across = Math.floor(window.innerWidth/wh);
		var down = Math.floor(curScroll/wh);
		var l = down*across;
		var top = $('#img-'+curAlbum+'-'+l).position().top;
		var origtop = top;
		while (top > 50 && l > 0) {
			l--;
			top = $('#img-'+curAlbum+'-'+l).position().top;
		}
		if (origtop != top && l+1 < images.length) {
			l++;
		}
		var newloadpos = l-across;
		if (newloadpos > 0)
			loadpos = newloadpos;
		else
			loadpos = l;
	}
}

function stoppedAlbumScrolling() {
	curAlbumScroll = $('#screen-index').scrollTop();
}

function videoFilename(v) {
	var nv = v.slice(0, -4);
	nv += ".mp4";
	return nv;
}

function loadImage(s, i) {
	if (i < images.length && i >= 0) {
		//alert(s+" "+i);
		$("#img-title-"+s).text(images[i].name);
		let img = encodeURI(images[i].src).replace("?", "%3F");
		if (images[i].type == "image") {
			$("#mainimg-"+s).attr("src", webimages+"/mid/"+img);
			$("#mainimg-"+s).show();
			$("#mainvid-"+s).hide();
		} else {
			$("#mainvid-"+s).attr("src", webimages+"/mid/"+videoFilename(img));
			$("#mainvid-"+s).show();
			$("#mainimg-"+s).hide();
		}
	}
}

function openImage(i) {
	window.history.pushState({ noBackExitsApp: true }, '')
	curScreen = "image";
	thisImage = 0;
	nextImage = 1;
	prevImage = 2;
	nextNextImage = 3;
	prevPrevImage = 4;
	curImage = i;
	$("#img-title-"+thisImage).text(images[i].name);
	$("#mainimg-"+thisImage).hide();
	$("#mainvid-"+thisImage).hide();
	$("#mainimg-thumb-"+thisImage).show();
	let img = encodeURI(images[i].src).replace("?", "%3F");
	$("#mainimg-thumb-"+thisImage).attr("src", webimages+"/thumb/"+img);
	$(".image-header").stop().show();
	if (!ismobile) {
		moveNav();
		$("#nav-next").stop().show();
		if (i < images.length-1)
			$("#nav-next").stop().show();
		else
			$("#nav-next").stop().hide();
		if (i != 0)
			$("#nav-prev").stop().show();
		else
			$("#nav-prev").stop().hide();
	}
	$("#screen-album-"+curAlbum).toggle("slide", {direction: "left"}, 500);
	$("#screen-image-"+thisImage).toggle("slide", {direction: "right"}, 500, function() {
		$(".image-header").stop().fadeOut(500);
		if (!ismobile) {
			$("#nav-next").stop().fadeOut(500);
			$("#nav-prev").stop().fadeOut(500);
		}
		loadImage(nextImage, i+1);
		loadImage(nextNextImage, i+2);
		loadImage(prevImage, i-1);
		loadImage(prevPrevImage, i-2);
	});
}

function swipeL() {
	// Next image
	if (curImage+1 < imgCount) {
		$("#screen-image-"+thisImage).toggle("slide", {direction: "left"}, 500);
		$("#screen-image-"+nextImage).toggle("slide", {direction: "right"}, 500, function() {
			var t = prevPrevImage;
			prevPrevImage = prevImage;
			prevImage = thisImage;
			thisImage = nextImage;
			nextImage = nextNextImage;
			nextNextImage = t;
			curImage++;
			if (!ismobile) {
				if (curImage < imgCount-1)
					$("#nav-next").stop().fadeIn(100);
				else
					$("#nav-next").stop().fadeOut(100);
				if (curImage != 0)
					$("#nav-prev").stop().fadeIn(100);
				else
					$("#nav-prev").stop().fadeOut(100);
			}
			loadImage(nextNextImage, curImage+2);
		});
	}
}

function swipeR() {
	// Prev image
	if (curImage-1 >= 0) {
		$("#screen-image-"+thisImage).toggle("slide", {direction: "right"}, 500);
		$("#screen-image-"+prevImage).toggle("slide", {direction: "left"}, 500, function() {
			var t = nextNextImage;
			nextNextImage = nextImage;
			nextImage = thisImage;
			thisImage = prevImage;
			prevImage = prevPrevImage;
			prevPrevImage = t;
			curImage--;
			if (!ismobile) {
				if (curImage < imgCount-1)
					$("#nav-next").stop().fadeIn(100);
				else
					$("#nav-next").stop().fadeOut(100);
				if (curImage != 0)
					$("#nav-prev").stop().fadeIn(100);
				else
					$("#nav-prev").stop().fadeOut(100);
			}
			loadImage(prevPrevImage, curImage-2);
		});
	}
}

function backToAlbum() {
	curScreen = "album";
	$("#screen-album-"+curAlbum).toggle("slide", {direction: "left"}, 500);
	$("#screen-image-"+thisImage).toggle("slide", {direction: "right"}, 500);
}

function downloadImage() {
	var d = dirname(images[curImage].src);
	window.open(sourceimages+"/"+d+"/"+images[curImage].name);
}

function moveImg(inimage, inw, inh) {
	var image = "mainimg-0";
	if (inimage)
		image = inimage;
	if (curScreen == "image") {
		var i = document.getElementById(image);
		var ih = i.clientHeight;
		var iw = i.clientWidth;
		if (inw && inh) {
			ih = inh;
			iw = inw;
		}
		var winh = window.innerHeight;
		var winw = window.innerWidth;
		var nh = ih;
		var nw = iw;
		var a = "";
		var l = 0;
		var t = 0;
		if (iw/ih <= winw/winh) {
			// If the aspect of the screen is wider, match to the height
			a = "screen wider";
			nh = winh;
			nw = Math.floor(winh/ih*iw);
			l = Math.floor(winw/2-nw/2);
			t = 0;
		} else {
			// Otherwise match width
			a = "screen narrower";
			nh = Math.floor(winw/iw*ih);
			nw = winw;
			l = 0;
			t =  Math.floor(winh/2-nh/2);
		}
		//alert("image:"+image+" a:"+a+" iw:"+iw+" ih:"+ih+" l:"+l+" t:"+t+" winh:"+winh+" winw:"+winw+" nh:"+nh+" nw:"+nw);
		i.style.left = l+'px';
		i.style.top = t+'px';
		i.style.height = nh+"px";
		i.style.width = nw+"px";
	}
}

function moveAllImages() {
	moveNav();
	moveImg("mainimg-0", wha[0].w, wha[0].h);
	moveImg("mainimg-1", wha[1].w, wha[1].h);
	moveImg("mainimg-2", wha[2].w, wha[2].h);
	moveImg("mainimg-3", wha[3].w, wha[3].h);
	moveImg("mainimg-4", wha[4].w, wha[4].h);
	moveImg("mainvid-0", wha[0].w, wha[0].h);
	moveImg("mainvid-1", wha[1].w, wha[1].h);
	moveImg("mainvid-2", wha[2].w, wha[2].h);
	moveImg("mainvid-3", wha[3].w, wha[3].h);
	moveImg("mainvid-4", wha[4].w, wha[4].h);
}

function moveNav() {
	if (!ismobile) {
		var winh = window.innerHeight;
		var winw = window.innerWidth;
		var t = Math.floor(winh/2-(75/2));
		$("#nav-next").css("top", t+"px");
		$("#nav-prev").css("top", t+"px");
	}
}

function toggleHeader() {
	if ($(".image-header").is(":visible")) {
		$(".image-header").stop().fadeOut(500);
		if (!ismobile) {
			$("#nav-next").stop().fadeOut(500);
			$("#nav-prev").stop().fadeOut(500);
		}
	} else {
		$(".image-header").stop().fadeIn(500);
		if (!ismobile) {
			if (curImage < imgCount-1)
				$("#nav-next").stop().fadeIn(500);
			else
				$("#nav-next").stop().fadeOut(500);
			if (curImage != 0)
				$("#nav-prev").stop().fadeIn(500);
			else
				$("#nav-prev").stop().fadeOut(500);
		}
	}
}

function toggleMenu() {
	if ( $('#menu').is(":visible") ) {
		$("#menu").toggle("slide", {direction: "left"}, 250);
		$('#menushade').fadeOut(250);
	} else {
		//$('#menu').slide("right");
		$("#menu").toggle("slide", {direction: "left"}, 250);
		$('#menushade').fadeIn(250);
	}
}

function toggleView() {
	if (showDirectories) {
		showDirectories = false;
		loadAlbums();
		toggleMenu();
		$('#view').text("View as folders");
		$('#viewimg').attr("src", "images/menu-folder.png");
	} else {
		showDirectories = true;
		loadDirectories();
		toggleMenu();
		$('#view').text("View in albums");
		$('#viewimg').attr("src", "images/menu-album.png");
	}
}

window.addEventListener("orientationchange", function() { moveAllImages(); }, false);

window.onresize = function() { moveAllImages(); };

window.addEventListener('popstate', function(event) {
	if (curScreen == "album") {
		if (!showDirectories) {
			openListing();
		} else {
			backOneAlbum();
		}
	}
	if (curScreen == "image")
		backToAlbum();
})

window.onload = function() { 
	containLinks();
	ismobile = mobileCheck();
	moveNav();
	wh = 100;
	if (ismobile) {
		wh = Math.floor(window.innerWidth/4);
	}
	for (var i = 0; i <= 4; i++) {
		var who = {
			w:100,
			h:100
		};
		wha.push(who);
	}
	$(function() {
		$("#screen-image-0").swipe({ fingers:'all', swipeLeft:swipeL, swipeRight:swipeR, tap:toggleHeader, allowPageScroll:"auto"} );
		$("#screen-image-1").swipe({ fingers:'all', swipeLeft:swipeL, swipeRight:swipeR, tap:toggleHeader, allowPageScroll:"auto"} );
		$("#screen-image-2").swipe({ fingers:'all', swipeLeft:swipeL, swipeRight:swipeR, tap:toggleHeader, allowPageScroll:"auto"} );
		$("#screen-image-3").swipe({ fingers:'all', swipeLeft:swipeL, swipeRight:swipeR, tap:toggleHeader, allowPageScroll:"auto"} );
		$("#screen-image-4").swipe({ fingers:'all', swipeLeft:swipeL, swipeRight:swipeR, tap:toggleHeader, allowPageScroll:"auto"} );
	});
	$("#mainimg-0").on("load", function() {
		wha[0].w = this.width;
		wha[0].h = this.height;
		setTimeout(function() {
			$("#mainimg-thumb-0").hide();
			$("#mainimg-0").show();
			moveImg("mainimg-0", wha[0].w, wha[0].h);
		}, 15);
	});
	$("#mainimg-1").on("load", function() {
		wha[1].w = this.width;
		wha[1].h = this.height;
		setTimeout(function() {
			moveImg("mainimg-1", wha[1].w, wha[1].h);
		}, 15);
	});
	$("#mainimg-2").on("load", function() {
		wha[2].w = this.width;
		wha[2].h = this.height;
		setTimeout(function() {
			moveImg("mainimg-2", wha[2].w, wha[2].h);
		}, 15);
	});
	$("#mainimg-3").on("load", function() {
		wha[3].w = this.width;
		wha[3].h = this.height;
		setTimeout(function() {
			moveImg("mainimg-3", wha[3].w, wha[3].h);
		}, 15);
	});
	$("#mainimg-4").on("load", function() {
		wha[4].w = this.width;
		wha[4].h = this.height;
		setTimeout(function() {
			moveImg("mainimg-4", wha[4].w, wha[4].h);
		}, 15);
	});
	$("#mainimg-thumb-0").on("load", function() {
		moveImg("mainimg-thumb-0", this.width, this.height);
		let img = encodeURI(images[curImage].src).replace("?", "%3F");
		if (images[curImage].type == "image")
			$("#mainimg-0").attr("src", webimages+"/mid/"+img);
		else
			$("#mainvid-0").attr("src", webimages+"/mid/"+videoFilename(img));
	});
	$("#mainvid-0").on("loadedmetadata", function() {
		$("#mainimg-thumb-0").hide();
		$("#mainvid-0").show();
		wha[0].w = this.videoWidth;
		wha[0].h = this.videoHeight;
		moveImg("mainvid-0", this.videoWidth, this.videoHeight);
	});
	$("#mainvid-1").on("loadedmetadata", function() {
		wha[0].w = this.videoWidth;
		wha[0].h = this.videoHeight;
		moveImg("mainvid-1", this.videoWidth, this.videoHeight);
	});
	$("#mainvid-2").on("loadedmetadata", function() {
		wha[0].w = this.videoWidth;
		wha[0].h = this.videoHeight;
		moveImg("mainvid-2", this.videoWidth, this.videoHeight);
	});
	$("#mainvid-3").on("loadedmetadata", function() {
		wha[0].w = this.videoWidth;
		wha[0].h = this.videoHeight;
		moveImg("mainvid-3", this.videoWidth, this.videoHeight);
	});
	$("#mainvid-4").on("loadedmetadata", function() {
		wha[0].w = this.videoWidth;
		wha[0].h = this.videoHeight;
		moveImg("mainvid-4", this.videoWidth, this.videoHeight);
	});
	$("#screen-index").scroll(function() {
		clearTimeout($.data(this, 'scrollTimer'));
		$.data(this, 'scrollTimer', setTimeout(function() {
			stoppedAlbumScrolling();
		}, 250));
	});
	if (loggedIn) {
		if (loggedInUsername != '') {
			$('#logoutmenu').show();
		}
		if (!showDirectories)
			loadAlbums();
		else
			loadDirectories();
	} else {
		$('#screen-login').show();
		if (loginFailed)
			$('#error').show();
	}
};
