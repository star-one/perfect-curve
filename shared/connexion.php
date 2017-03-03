<?php
    $host_name  = "hostname";
    $database   = "database";
    $user_name  = "username";
    $password   = "password";
	
	$SiteDomain = "https://www.perfect-curve.co.uk/";
	$SiteName = "The Perfect Curve";
	$SiteSubTitle = "For when the Twitterbook becomes history";
	$Logo = "<h1 id=\"logo\" style=\"font-weight: bolder;\">The <img src=\"/shared/french_curve.svg\" alt=\"\" style=\"height: 15px; color: white;\" /> Perfect <img src=\"/shared/french_curve.svg\" alt=\"\" style=\"height: 15px;\" /> Curve</h1>";

	date_default_timezone_set ('Europe/London');

    global $connect;
	$connect = new mysqli($host_name, $user_name, $password, $database);
    if ($connect->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	}
	
	function bind_all(&$stmt, &$out) {	// See http://stackoverflow.com/questions/1290975/how-to-create-a-secure-mysql-prepared-statement-in-php for this
		$data = mysqli_stmt_result_metadata($stmt);
		$fields = array();
		$out = array();

		$fields[0] = $stmt;
		$count = 1;

		while($field = mysqli_fetch_field($data)) {
			$fields[$count] = &$out[$field->name];
			$count++;
		}
		call_user_func_array(mysqli_stmt_bind_result, $fields);
	}

	function slugify($string) {
		$string = str_replace(" ", "-", strtolower($string));
		$string = preg_replace("/[^a-zA-Z0-9-]/", "", $string);
		return $string;
	}

	function sanitise($string) {
		if(strpos(strtolower($string),'<script>') !== false) {
 		   // do the big alert email and redirect elsewhere; eventually set a session cookie to keep baddies away for 20 minutes
			header("Location: http://www.google.co.uk/");
			die();
		}
		$string = strip_tags($string,"<ul><ol><li><b><i><strong><em><p><br><br /><a><h2><h3><h4><h5><hr><hr /><blockquote><table><th><tbody><tr><td><s><img><img />");
		return $string;
	}
	
	function unescape($string) { // eventually replace b and i with strong and em here as well
		$string = str_replace("\\r\\n", "", $string);
		$string = str_replace("\\", "", $string);
		$string = str_replace("<h2>", "<h2 class=\"content\">", $string); // These are to override the tabber hides
		$string = str_replace("<h3>", "<h3 class=\"content\">", $string); // They won't be necessary on non-tabber sites
		$string = str_replace("<h4>", "<h4 class=\"content\">", $string);
		$string = str_replace("<h5>", "<h5 class=\"content\">", $string);
		return $string;
	}

	/**
	 * Get either a Gravatar URL or complete image tag for a specified email address.
	 *
	 * @param string $email The email address
	 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
	 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
	 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
	 * @param boole $img True to return a complete IMG tag False for just the URL
	 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
	 * @return String containing either just a URL or a complete image tag
	 * @source http://gravatar.com/site/implement/images/php/
	 */
	function get_gravatar( $email, $s = 80, $d = 'identicon', $r = 'g', $img = false, $atts = array() ) {
	    $url = 'https://www.gravatar.com/avatar/';
	    $url .= md5( strtolower( trim( $email ) ) );
	    $url .= "?s=$s&amp;d=$d&amp;r=$r";
	    if ( $img ) {
	        $url = '<img src="' . $url . '"';
	        foreach ( $atts as $key => $val )
	            $url .= ' ' . $key . '="' . $val . '"';
	        $url .= ' />';
	    }
	    return $url;
	}


/////////////////////// Site specific functions //////////////////////////////////////////


?>