<?php

	$config = parse_ini_file("/etc/nowgallery.conf");

?> <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="format-detection" content="telephone=no" />
		<meta name="msapplication-tap-highlight" content="no" />
		<!-- WARNING: for iOS 7, remove the width=device-width and height=device-height attributes. See https://issues.apache.org/jira/browse/CB-4323 -->
		<!-- Removed for font sizes: target-densitydpi=device-dpi -->
		<!-- <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height" /> -->
		<meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-title" content="Gallery">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<link rel="apple-touch-icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJgAAACYCAYAAAAYwiAhAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKT2lDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVNnVFPpFj333vRCS4iAlEtvUhUIIFJCi4AUkSYqIQkQSoghodkVUcERRUUEG8igiAOOjoCMFVEsDIoK2AfkIaKOg6OIisr74Xuja9a89+bN/rXXPues852zzwfACAyWSDNRNYAMqUIeEeCDx8TG4eQuQIEKJHAAEAizZCFz/SMBAPh+PDwrIsAHvgABeNMLCADATZvAMByH/w/qQplcAYCEAcB0kThLCIAUAEB6jkKmAEBGAYCdmCZTAKAEAGDLY2LjAFAtAGAnf+bTAICd+Jl7AQBblCEVAaCRACATZYhEAGg7AKzPVopFAFgwABRmS8Q5ANgtADBJV2ZIALC3AMDOEAuyAAgMADBRiIUpAAR7AGDIIyN4AISZABRG8lc88SuuEOcqAAB4mbI8uSQ5RYFbCC1xB1dXLh4ozkkXKxQ2YQJhmkAuwnmZGTKBNA/g88wAAKCRFRHgg/P9eM4Ors7ONo62Dl8t6r8G/yJiYuP+5c+rcEAAAOF0ftH+LC+zGoA7BoBt/qIl7gRoXgugdfeLZrIPQLUAoOnaV/Nw+H48PEWhkLnZ2eXk5NhKxEJbYcpXff5nwl/AV/1s+X48/Pf14L7iJIEyXYFHBPjgwsz0TKUcz5IJhGLc5o9H/LcL//wd0yLESWK5WCoU41EScY5EmozzMqUiiUKSKcUl0v9k4t8s+wM+3zUAsGo+AXuRLahdYwP2SycQWHTA4vcAAPK7b8HUKAgDgGiD4c93/+8//UegJQCAZkmScQAAXkQkLlTKsz/HCAAARKCBKrBBG/TBGCzABhzBBdzBC/xgNoRCJMTCQhBCCmSAHHJgKayCQiiGzbAdKmAv1EAdNMBRaIaTcA4uwlW4Dj1wD/phCJ7BKLyBCQRByAgTYSHaiAFiilgjjggXmYX4IcFIBBKLJCDJiBRRIkuRNUgxUopUIFVIHfI9cgI5h1xGupE7yAAygvyGvEcxlIGyUT3UDLVDuag3GoRGogvQZHQxmo8WoJvQcrQaPYw2oefQq2gP2o8+Q8cwwOgYBzPEbDAuxsNCsTgsCZNjy7EirAyrxhqwVqwDu4n1Y8+xdwQSgUXACTYEd0IgYR5BSFhMWE7YSKggHCQ0EdoJNwkDhFHCJyKTqEu0JroR+cQYYjIxh1hILCPWEo8TLxB7iEPENyQSiUMyJ7mQAkmxpFTSEtJG0m5SI+ksqZs0SBojk8naZGuyBzmULCAryIXkneTD5DPkG+Qh8lsKnWJAcaT4U+IoUspqShnlEOU05QZlmDJBVaOaUt2ooVQRNY9aQq2htlKvUYeoEzR1mjnNgxZJS6WtopXTGmgXaPdpr+h0uhHdlR5Ol9BX0svpR+iX6AP0dwwNhhWDx4hnKBmbGAcYZxl3GK+YTKYZ04sZx1QwNzHrmOeZD5lvVVgqtip8FZHKCpVKlSaVGyovVKmqpqreqgtV81XLVI+pXlN9rkZVM1PjqQnUlqtVqp1Q61MbU2epO6iHqmeob1Q/pH5Z/YkGWcNMw09DpFGgsV/jvMYgC2MZs3gsIWsNq4Z1gTXEJrHN2Xx2KruY/R27iz2qqaE5QzNKM1ezUvOUZj8H45hx+Jx0TgnnKKeX836K3hTvKeIpG6Y0TLkxZVxrqpaXllirSKtRq0frvTau7aedpr1Fu1n7gQ5Bx0onXCdHZ4/OBZ3nU9lT3acKpxZNPTr1ri6qa6UbobtEd79up+6Ynr5egJ5Mb6feeb3n+hx9L/1U/W36p/VHDFgGswwkBtsMzhg8xTVxbzwdL8fb8VFDXcNAQ6VhlWGX4YSRudE8o9VGjUYPjGnGXOMk423GbcajJgYmISZLTepN7ppSTbmmKaY7TDtMx83MzaLN1pk1mz0x1zLnm+eb15vft2BaeFostqi2uGVJsuRaplnutrxuhVo5WaVYVVpds0atna0l1rutu6cRp7lOk06rntZnw7Dxtsm2qbcZsOXYBtuutm22fWFnYhdnt8Wuw+6TvZN9un2N/T0HDYfZDqsdWh1+c7RyFDpWOt6azpzuP33F9JbpL2dYzxDP2DPjthPLKcRpnVOb00dnF2e5c4PziIuJS4LLLpc+Lpsbxt3IveRKdPVxXeF60vWdm7Obwu2o26/uNu5p7ofcn8w0nymeWTNz0MPIQ+BR5dE/C5+VMGvfrH5PQ0+BZ7XnIy9jL5FXrdewt6V3qvdh7xc+9j5yn+M+4zw33jLeWV/MN8C3yLfLT8Nvnl+F30N/I/9k/3r/0QCngCUBZwOJgUGBWwL7+Hp8Ib+OPzrbZfay2e1BjKC5QRVBj4KtguXBrSFoyOyQrSH355jOkc5pDoVQfujW0Adh5mGLw34MJ4WHhVeGP45wiFga0TGXNXfR3ENz30T6RJZE3ptnMU85ry1KNSo+qi5qPNo3ujS6P8YuZlnM1VidWElsSxw5LiquNm5svt/87fOH4p3iC+N7F5gvyF1weaHOwvSFpxapLhIsOpZATIhOOJTwQRAqqBaMJfITdyWOCnnCHcJnIi/RNtGI2ENcKh5O8kgqTXqS7JG8NXkkxTOlLOW5hCepkLxMDUzdmzqeFpp2IG0yPTq9MYOSkZBxQqohTZO2Z+pn5mZ2y6xlhbL+xW6Lty8elQfJa7OQrAVZLQq2QqboVFoo1yoHsmdlV2a/zYnKOZarnivN7cyzytuQN5zvn//tEsIS4ZK2pYZLVy0dWOa9rGo5sjxxedsK4xUFK4ZWBqw8uIq2Km3VT6vtV5eufr0mek1rgV7ByoLBtQFr6wtVCuWFfevc1+1dT1gvWd+1YfqGnRs+FYmKrhTbF5cVf9go3HjlG4dvyr+Z3JS0qavEuWTPZtJm6ebeLZ5bDpaql+aXDm4N2dq0Dd9WtO319kXbL5fNKNu7g7ZDuaO/PLi8ZafJzs07P1SkVPRU+lQ27tLdtWHX+G7R7ht7vPY07NXbW7z3/T7JvttVAVVN1WbVZftJ+7P3P66Jqun4lvttXa1ObXHtxwPSA/0HIw6217nU1R3SPVRSj9Yr60cOxx++/p3vdy0NNg1VjZzG4iNwRHnk6fcJ3/ceDTradox7rOEH0x92HWcdL2pCmvKaRptTmvtbYlu6T8w+0dbq3nr8R9sfD5w0PFl5SvNUyWna6YLTk2fyz4ydlZ19fi753GDborZ752PO32oPb++6EHTh0kX/i+c7vDvOXPK4dPKy2+UTV7hXmq86X23qdOo8/pPTT8e7nLuarrlca7nuer21e2b36RueN87d9L158Rb/1tWeOT3dvfN6b/fF9/XfFt1+cif9zsu72Xcn7q28T7xf9EDtQdlD3YfVP1v+3Njv3H9qwHeg89HcR/cGhYPP/pH1jw9DBY+Zj8uGDYbrnjg+OTniP3L96fynQ89kzyaeF/6i/suuFxYvfvjV69fO0ZjRoZfyl5O/bXyl/erA6xmv28bCxh6+yXgzMV70VvvtwXfcdx3vo98PT+R8IH8o/2j5sfVT0Kf7kxmTk/8EA5jz/GMzLdsAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAACV9JREFUeNrsnV+IXFcdxz9zdwwEAlsXU1YqGyMpFDQS3ywWo7GBYkpe+hD8Vyp5Smmt2AeRQgW1D1WqlhYKhWBFKgp9EiOxSjAQUErBYrBYCg0tBoMpq2smOzN37vkdH865u7OT3WT+nPn//cCwk5uZm5tzPvs7v/O7595bWVnZx4jZDywDB4EVYC+wABzqYR+74vfniYtA3sPn3wAccBV4L37/CnBplAddGYFgR4DDwFHgbsQk8BpwFjgPnJs2wXYDXwOORbn2qD8nmlqU7AzwC6A+qYKtAI8AJ4El9dtUsgqcBp6Pw+pECLYEPBHl2qU+mgnyKNlTUbq+yQY8kMeAd4BvSa6ZYlfs03diH49csDuAV4GfAovqj5llMfbxq3HmPxLB7gP+GmeFYj44Cvwt9v1QBTsJ/JZQuxLzxd7Y9yd7+dLC4uJt3X72SeAnCfI2Mb1kwHHAE2poyQR7Avi+2ldEPg80gQspBDsFPKM2FR3cC/wbeH2QHOwY8JzaUuzAc9GRvgRbBn5GOBEtxLYjYHRkuR/BXtZsUXQ5u3y5V8FOEU5UC9ENR6IzN7Dducgl4G10wlr0xipwJx3nLreLYD+QXKIPlqI7N41g+4F/oBPXoj9y4C7aVs12RjCtihCDUK7C2DaCLQL/RCtQxWDUgI8Aa50R7ITkEgnYE126YYg8rrYRiTjeOUQuEc4rqWovUuCA24HVMoIdkVwiIQvRKapxwz0p9vqhb/96qlrh/adPSIXhcQ/wShnBDqs9RGIOl0n+PF6GL4bPQWBXBhxQ/iWGlIcdyBS9xDCjWEa4xlGIYXCHBBNDFaxKn1fsDoz35Zv41rdtG9Uh9PbvVSoVKdMby1XGsfbL+yiWBzO8t82f3vPGgXtHcxyJLmfZ9419Uml7lqqM6QS39x7vHJjDihzviiCZOXXL7LCnylhuXhIiF+awVhPLG1iriXdFkE7MCotjEcx78N6wIsfyBq5ew5r1IJprqVtmTLBxDJBhOHRFiGDNOkX9Gtas44tc3TJDVAn3VB15CNtI7F0RIlezjjWuY62memWGcrDyXORYyhTeHN45zLXwRb6Rj4mZYaE6vn871qA2IpnbEK7nikfcm4+lND/y3xXV0242RE4tpUxmYB6chZdZ2P6l5UMjOY5P/DzNfv7+0H8k2KRhBoWDwqDZglaxKZqYDMGmdqmOJ0SuwqCew3oTGjnkRZBOjJ3dY6vkpxoiXYxc601Yuw61RnifF+rdCWDX1OdgzsKw2MiDXP+NkjVVr1UOlmSIjPlWXoTIVWvAtTrUVU6bCKb+jtGeIFjhgmTNVpBrXScEFMGSlir8pmhFHDZ7NrX8Ue7Uj/r/Mnv1tKp+x4JInmCp9+CdB4sd7uGV3318NMdxf5rdHDzzZwk2cZjHO493YC3DCo838ObVNhJs8DwuRC5wTcM1Dcs91grSCQk2cCLnncdaQa7iuqOoG9YIkUxIsAT1DrDCY7mnqBtFLUrW0jknCZYiyfch57KWxxpGUTfcusPlimCDoCentUsWE30r4nCZe1xDEUwRLE0atiWSeRfKFb7wPS0H2Lja0/vNyQPze72nBEs+G/WYB8PjzGM+vDyw/vh3RnIcf3wszX6O3veABJs0zEPhDWeepnO0zOOiZPPY2BIs8dBURq564agXBQ1n5M7hvOd2CSYGHSLLyFUvCv6Xt6i1CuqFIzcnwcTgEwXznpZ5Gs6otQrW8pzrrYLmnK7hlmBJI1jItZz35M5RLxzXWwXX8oLGnN4SQXWwIQyTG5KZo+mMhnOstwoJJtIk+j7OGp15CvMUZhRzuipDggkJJiSYEBJMSDAhwYSQYEKCCQkmhAQTEkxIMCEkmJBgQkgwIcGEBBNCggkJJiSYEBJMSDAhwYRISNIru99/+kRXn9u4dtAMM8M5h5nDzMK9rU6qYxTBhJBgQoIJCSaEBBMSTMwfE3QDukp8CQmWSqlK5YYXwNLXP9j1PsqaWllXa//z51RPm0/BSpHKBwaUcmVZFrf5ngUzs6l4QKcEG0MEy7IKkG3I0gulXGEfYBafbCUkWCmXWUaW+S1RrVvKyGVmlI9NM8sY+fOQxWQJVqlU8N5TqQS5SrF6Ecx73zasEvcHWWaYgpgi2KZklS3ve0/wDe9DNPQ+zEaVjkmwLQn/IHhfzkBLUSWYBEso207lDiHBks5GOwX7ywPv9jHc3lhP4yGJMpeCqZ4mwUYawVRPk2BDE0z1tMkVrAbsmWa5VE+bWPIqMPXPmVM9bWKpz8zzIlVPUw428bKpnibBRjIb7RTso7/6fR/D7Y31tK/OqWC5xFI9bUi4KlBX7KJDLNXTElHTENkhmOpp6YfINamletqQWJNg20qmelpKwWpSa/ASx1bRVE9rz8FWpVVa2VRP22C1ClyRSsOZjXYK9unPHJ20I90ox2RZxsLCAlmWpfzFuFIFLkuJtBEvRT1tlIJ1ypQw6l6WYEOMYIPU08ZxrEMYzi9XgTelRPpOG7SeNuqo2y5ZQt6sAm8RluwsSI2UpY7+62njEqz9fQIc8FZ5LvIicEh6pJasv3raOGfLCY/zInHBIcAFCTYZJY4ZOtYLsLlc5zzwiLSQbKkFK+9weI4ZWDotJgYH/KFdsFXgrNpFJOJsdGrLPVp/o3YRidhwqbKysq98vwj8C9it9hEDUAc+TFyl0x7B1oCX1D5iQF6ibQlY523Mf4TW6Iv+yaND7CTYJeC02kn0yenoENvlYCVLwNvxpxDdsgrcScf6wmyHD35X7SV65Htss3h1p0fJvEAovgrRDeeA57f7i50Ec8BX0HJq0d3Q+CA7nAm62cOwrtzsi0JENx7kJotWb/W0tTPAo2pHsQOPRkd2ZGFx8bZb7eR14APAZ9Weoo2ngB/e6kPdCFYmcRlwWO0q4ozxyW4+2K1gAH8inKv8InqQ6TznXKeAZ7r9Qq+ivAjcr9nlXHI19v2LvXypn0h0FvgkqpPNE+eAT9HHmsF+h7rLwBeAx9HNU2aZNeCbsa/7un520Fzqx8DHCJV/1ctmK9d6Ifbts4PsKEWyvgo8DNwVD0YRbboj1rOxLx9OkWtvt5piUPYAXwaOAUeY4oc8zAm1mGOdAX5J4tt5DUOwTo4Q6mdHgbvVnxPBazFhPz/sydooBOtkP7AMHARWgL1xW+f6s6W4XdyaS9sMZ6tx+1XgPcKV1lfoWBA4bP4/AEdp7Bmo4zmPAAAAAElFTkSuQmCC">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/slide.css" />
		<title>Gallery</title>
		<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/jquery.touchSwipe.min.js"></script>
		<script type="text/javascript">
			var webimages = "<?php echo $config["webimages"]; ?>";
			var sourceimages = "<?php echo $config["sourceimages"]; ?>";
			<?php
				if ($config["username"] == "" || (isset($_COOKIE['loginCredentials']) && !empty($_COOKIE['loginCredentials']))) {
					echo "var loggedIn = true;\n";
					echo "var loggedInUsername = '".$config["username"]."';\n";
				} else {
					echo "var loggedIn = false;\n";
					echo "var loggedInUsername = '';\n";
				}
				if (isset($_GET['login']) && $_GET['login'] == "failed") {
					echo "var loginFailed = true;\n";
				} else {
					echo "var loginFailed = false;\n";
				}
			?>
		</script>
		<script type="text/javascript" src="js/script.js"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	</head>
	<body>
