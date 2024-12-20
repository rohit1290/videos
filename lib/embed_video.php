<?php
/**
 * Embed Video Library
 * Functions to parse flash video urls and create the flash embed object
 *
 * @package Embed Video Library
 * @license http://www.gnu.org/licenses/gpl.html GNU Public License version 2
 *
 *
 * Current video sites supported:
 *
 * youtube/youtu.be
 * vimeo
 * metacafe
 * veoh
 * dailymotion
 * blip.tv
 * teacher tube
 * hulu
 *
 */


/**
 * Public API for library
 *
 * @param string $url either the url or embed code
 * @param integer $guid unique identifier of the widget
 * @param integer $videowidth override the admin set default width
 * @return string html video div with object embed code or error message
 */
function videoembed_create_embed_object($url, $guid, $videowidth=0) {

	if (!isset($url)) {
		return '<p><b>' . elgg_echo('embedvideo:novideo') . '</b></p>';
	}

	if (strpos($url, 'youtube.com') != false) {
		return videoembed_youtube_handler($url, $guid, $videowidth);
	} else if (strpos($url, 'youtu.be') != false) {
		return videoembed_youtube_shortener_parse_url($url, $guid, $videowidth);
	} else if (strpos($url, 'facebook.com') != false) {
		return videoembed_facebook_shortener_parse_url($url, $guid, $videowidth);
	} else if (strpos($url, 'video.google.com') != false) {
		return videoembed_google_handler($url, $guid, $videowidth);
	} else if (strpos($url, 'vimeo.com') != false) {
		return videoembed_vimeo_handler($url, $guid, $videowidth);
	} else if (strpos($url, 'metacafe.com') != false) {
		return videoembed_metacafe_handler($url, $guid, $videowidth);
	} else if (strpos($url, 'veoh.com') != false) {
		return videoembed_veoh_handler($url, $guid, $videowidth);
	} else if (strpos($url, 'viddler.com') != false) {
		return '<p><b>not handling viddler.com videos yet</b></p>';
	} else if (strpos($url, 'dailymotion.com') != false) {
		return videoembed_dm_handler($url, $guid, $videowidth);
	} else if (strpos($url, 'blip.tv') != false) {
		return videoembed_blip_handler($url, $guid, $videowidth);
	} else if (strpos($url, 'teachertube.com') != false) {
		return videoembed_teachertube_handler($url, $guid, $videowidth);
	} else if (strpos($url, 'hulu.com') != false) {
		return videoembed_hulu_handler($url, $guid, $videowidth);
	} else {
		return '<p><b>' . elgg_echo('embedvideo:unrecognized') . '</b></p>';
	}
}

/**
 * generic css insert
 *
 * @param integer $guid unique identifier of the widget
 * @param integer/string $width
 * @param integer/string $height
 * @return string style code for video div
 */
function videoembed_add_css($guid, $width, $height) {
	$videocss = "
      <style type=\"text/css\">
        #embedvideo{$guid} {
          height: {$height}px;
          width: {$width}px;
        }
      </style>";

	return $videocss;
}

/**
 * generic <object> creator
 *
 * @param string $type
 * @param string $url
 * @param integer $guid unique identifier of the widget
 * @param integer/string $width
 * @param integer/string $height
 * @return string <object> code
 */
function videoembed_add_object($type, $url, $guid, $width, $height) {
	$videodiv = "<div id=\"embedvideo{$guid}\" class=\"videoembed_video\">";

	// could move these into an array and use sprintf
	switch ($type) {
                case 'facebook':
			?>
                        <div id="fb-root"></div> <script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));</script>
                        <?php
                        $videodiv .= "<object width=\"$width\" height=\"$height\"><div class=\"fb-post\" data-href=\"{$url}\" data-width=\"$width\"></div></object>";
                        break;
		case 'youtube':
			$videodiv .= "<iframe type=\"text/html\" width=\"{$width}\" height=\"{$height}\" src=\"https://{$url}\" frameborder=\"0\"></iframe>";
			break;
		case 'google':
			$videodiv .= "<embed id=\"VideoPlayback\" src=\"https://video.google.com/googleplayer.swf?docid={$url}&hl=en&fs=true&\" style=\"width:{$width}px;height:{$height}px\" allowFullScreen=\"true\" allowScriptAccess=\"always\" type=\"application/x-shockwave-flash\" wmode=\"transparent\"> </embed>";
			break;
		case 'vimeo':
			$videodiv .= "<iframe type=\"text/html\" width=\"{$width}\" height=\"{$height}\" src=\"//player.vimeo.com/video/{$url}\" frameborder=\"0\"></iframe>";
			break;
		case 'metacafe':
			$videodiv .= "<embed src=\"https://www.metacafe.com/fplayer/{$url}.swf\" width=\"$width\" height=\"$height\" wmode=\"transparent\" pluginspage=\"https://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\"></embed>";
			break;
		case 'veoh':
			$videodiv .= "<embed src=\"https://www.veoh.com/veohplayer.swf?permalinkId={$url}&player=videodetailsembedded&videoAutoPlay=0\" allowFullScreen=\"true\" width=\"$width\" height=\"$height\" bgcolor=\"#FFFFFF\" type=\"application/x-shockwave-flash\" pluginspage=\"https://www.macromedia.com/go/getflashplayer\"></embed>";
			break;
		case 'dm':
			$videodiv .= "<object width=\"$width\" height=\"$height\"><param name=\"movie\" value=\"https://www.dailymotion.com/swf/{$url}\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowScriptAccess\" value=\"always\"></param><embed src=\"https://www.dailymotion.com/swf/{$url}\" type=\"application/x-shockwave-flash\" width=\"$width\" height=\"$height\" allowFullScreen=\"true\" allowScriptAccess=\"always\"></embed></object>";
			break;
		case 'blip':
			$videodiv .= "<embed src=\"https://blip.tv/play/{$url}\" type=\"application/x-shockwave-flash\" width=\"$width\" height=\"$height\" allowscriptaccess=\"always\" allowfullscreen=\"true\"></embed>";
			break;
		case 'teacher':
			$videodiv .= "<embed src=\"https://www.teachertube.com/embed/player.swf\" width=\"$width\" height=\"$height\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" flashvars=\"file=https://www.teachertube.com/embedFLV.php?pg=video_{$url}&menu=false&&frontcolor=ffffff&lightcolor=FF0000&logo=https://www.teachertube.com/www3/images/greylogo.swf&skin=https://www.teachertube.com/embed/overlay.swf&volume=80&controlbar=over&displayclick=link&viral.link=https://www.teachertube.com/viewVideo.php?video_id={$url}&stretching=exactfit&plugins=viral-2&viral.callout=none&viral.onpause=false\"></embed>";
			break;
		case 'hulu':
			$videodiv .= "<object width=\"{$width}\" height=\"{$height}\"><param name=\"movie\" value=\"https://www.hulu.com/embed/{$url}\"></param><param name=\"allowFullScreen\" value=\"true\"></param><embed src=\"https://www.hulu.com/embed/{$url}\" type=\"application/x-shockwave-flash\" allowFullScreen=\"true\"  width=\"{$width}\" height=\"{$height}\"></embed></object>";
			break;
	}

	$videodiv .= "</div>";

	return $videodiv;
}

/**
 * calculate the video width and size
 *
 * @param $width
 * @param $height
 * @param $toolbar_height
 */
function videoembed_calc_size(&$width, &$height, $aspect_ratio, $toolbar_height) {
	// set video width and height
	if (!$width) {
		$width = elgg_get_plugin_setting('videowidth', 'embedvideo');
	}

	// make sure width is a number and greater than zero
	if (!isset($width) || !is_numeric($width) || $width < 0) {
		$width = 284;
	}

        if (elgg_in_context('widgets')) {
                $width = 200;
        }
	$height = round($width / $aspect_ratio) + $toolbar_height;
}

/**
 * main youtube interface
 *
 * @param string $url
 * @param integer $guid unique identifier of the widget
 * @param integer $videowidth  optional override of admin set width
 * @return string css style, video div, and flash <object>
 */
function videoembed_youtube_handler($url, $guid, $videowidth) {
	// this extracts the core part of the url needed for embeding
	$videourl = videoembed_youtube_parse_url($url);
	if (!isset($videourl)) {
		return '<p><b>' . sprintf(elgg_echo('embedvideo:parseerror'), 'youtube') . '</b></p>';
	}

	videoembed_calc_size($videowidth, $videoheight, 425/320, 24);

	$embed_object = videoembed_add_css($guid, $videowidth, $videoheight);

	$embed_object .= videoembed_add_object('youtube', $videourl, $guid, $videowidth, $videoheight);

	return $embed_object;
}

/**
 * parse youtube url
 *
 * @param string $url
 * @return string subdomain.youtube.com/v/hash
 */
function videoembed_youtube_parse_url($url) {

	if (strpos($url, 'feature=hd') != false) {
		// this is high def with a different aspect ratio
	}

	// This provides some security against inserting bad content.
	// Divides url into http://, www or localization, domain name, path.
	if (!preg_match('/(https?:\/\/)([a-zA-Z]{2,3}\.)(youtube\.com\/)(.*)/', $url, $matches)) {
		//echo "malformed youtube url";
		return;
	}

	$domain = $matches[2] . $matches[3];
	$path = $matches[4];

	$hash = "";
	$parts = parse_url($url);
	if (isset($parts['query'])) {
	    parse_str($parts['query'], $vars);
	    $hash = array_key_exists('v', $vars) ? $vars['v'] : "";
	}

	if($hash == "" || $hash == null){
		$url_f = explode("?",$url);
		if (strpos($url_f[0], 'embed') !== false) {
			$url_f2 = explode("embed/",$url_f[0]);
			return $domain . 'embed/' . $url_f2[1];
		}
	} else {
		//return $domain . 'v/' . $hash;
		return $domain . 'embed/' . $hash;
	}

}

/**
 * parse youtu.be url
 *
 * @param string $url
 * @return string youtube.com/v/hash
 */
function videoembed_youtube_shortener_parse_url($url, $guid, $videowidth) {
	$path = parse_url($url, PHP_URL_PATH);
	$videourl = 'youtube.com/v' . $path;

	videoembed_calc_size($videowidth, $videoheight, 425/320, 24);

	$embed_object = videoembed_add_css($guid, $videowidth, $videoheight);

	$embed_object .= videoembed_add_object('youtube', $videourl, $guid, $videowidth, $videoheight);

	return $embed_object;
}

/**
 * main facebook interface
 *
 * @param string $url
 * @param integer $guid unique identifier of the widget
 * @param integer $videowidth  optional override of admin set width
 * @return string css style, video div, and flash <object>
 */

function videoembed_facebook_shortener_parse_url($url, $guid, $videowidth) {
        $aspect_ratio = 0.8;

        videoembed_calc_size($videowidth, $videoheight, $aspect_ratio, 20);

        $embed_object = videoembed_add_css($guid, $videowidth, $videoheight);

        $embed_object .= videoembed_add_object('facebook', $url, $guid, $videowidth, $videoheight);

        return $embed_object;
}


/**
 * main google interface
 *
 * @param string $url
 * @param integer $guid unique identifier of the widget
 * @param integer $videowidth  optional override of admin set width
 * @return string css style, video div, and flash <object>
 */
function videoembed_google_handler($url, $guid, $videowidth) {
	// this extracts the core part of the url needed for embeding
	$videourl = videoembed_google_parse_url($url);
	if (!isset($videourl)) {
		return '<p><b>' . sprintf(elgg_echo('embedvideo:parseerror'), 'google') . '</b></p>';
	}

	videoembed_calc_size($videowidth, $videoheight, 400/300, 27);

	$embed_object = videoembed_add_css($guid, $videowidth, $videoheight);

	$embed_object .= videoembed_add_object('google', $videourl, $guid, $videowidth, $videoheight);

	return $embed_object;
}

/**
 * parse google url
 *
 * @param string $url
 * @return string hash
 */
function videoembed_google_parse_url($url) {
	// separate parsing embed url
	if (strpos($url, 'embed') != false) {
		return videoembed_google_parse_embed($url);
	}

	if (!preg_match('/(https?:\/\/)(video\.google\.com\/videoplay)(.*)/', $url, $matches)) {
		//echo "malformed google url";
		return;
	}

	$path = $matches[3];
	//echo $path;

	// forces rest of url to start with "?docid=", followed by hash, and rest of options start with &
	if (!preg_match('/^(\?docid=)([0-9-]*)#?(&.*)?$/',$path, $matches)) {
		//echo "bad hash";
		return;
	}

	$hash = $matches[2];
	//echo $hash;

	return $hash;
}

/**
 * parse google embed code
 *
 * @param string $url
 * @return string hash
 */
function videoembed_google_parse_embed($url) {

	if (!preg_match('/(src=)(https?:\/\/video\.google\.com\/googleplayer\.swf\?docid=)([0-9-]*)(&hl=[a-zA-Z]{2})(.*)/', $url, $matches)) {
		//echo "malformed embed google url";
		return;
	}

	$hash   = $matches[3];
	//echo $hash;

	// need to pull out language here
	//echo $matches[4];

	return $hash;
}

/**
 * main vimeo interface
 *
 * @param string $url
 * @param integer $guid unique identifier of the widget
 * @param integer $videowidth  optional override of admin set width
 * @return string css style, video div, and flash <object>
 */
function videoembed_vimeo_handler($url, $guid, $videowidth) {
	// this extracts the core part of the url needed for embeding
	$videourl = videoembed_vimeo_parse_url($url);
	if (!isset($videourl)) {
		return '<p><b>' . sprintf(elgg_echo('embedvideo:parseerror'), 'vimeo') . '</b></p>';
	}

	// aspect ratio changes based on video - need to investigate
	videoembed_calc_size($videowidth, $videoheight, 400/300, 0);

	$embed_object = videoembed_add_css($guid, $videowidth, $videoheight);

	$embed_object .= videoembed_add_object('vimeo', $videourl, $guid, $videowidth, $videoheight);

	return $embed_object;
}

/**
 * parse vimeo url
 *
 * @param string $url
 * @return string hash
 */
function videoembed_vimeo_parse_url($url) {
        if (strpos($url, 'groups') != false) {
                if (!preg_match('/(https?:\/\/)(www\.)?(vimeo\.com\/groups)(.*)(\/videos\/)([0-9]*)/', $url, $matches)) {
                        //echo "malformed vimeo group url";
                        return;
                }

                $hash = $matches[6];
        } else {
                if (!preg_match('/(https:\/\/)(www\.)?(vimeo.com\/)([0-9]*)/', $url, $matches)) {
                        //echo "malformed vimeo url";
                        return;
                }

                $hash = $matches[4];
		
		//GK, parse last part of URL, in case of staff picked or group URL's
		if(empty($hash)){
			$hash = end(explode( "/", $url ));
		}

        }

        return $hash;
}


/**
 * parse vimeo embed code
 *
 * @param string $url
 * @return string hash
 */
function videoembed_vimeo_parse_embed($url) {
	if (!preg_match('/(value="https?:\/\/vimeo\.com\/moogaloop\.swf\?clip_id=)([0-9-]*)(&)(.*" \/)/', $url, $matches)) {
		//echo "malformed embed vimeo url";
		return;
	}

	$hash   = $matches[2];
	//echo $hash;

	return $hash;
}

/**
 * main metacafe interface
 *
 * @param string $url
 * @param integer $guid unique identifier of the widget
 * @param integer $videowidth  optional override of admin set width
 * @return string css style, video div, and flash <object>
 */
function videoembed_metacafe_handler($url, $guid, $videowidth) {
	// this extracts the core part of the url needed for embeding
	$videourl = videoembed_metacafe_parse_url($url);
	if (!isset($videourl)) {
		return '<p><b>' . sprintf(elgg_echo('embedvideo:parseerror'), 'metacafe') . '</b></p>';
	}

	videoembed_calc_size($videowidth, $videoheight, 400/295, 40);

	$embed_object = videoembed_add_css($guid, $videowidth, $videoheight);

	$embed_object .= videoembed_add_object('metacafe', $videourl, $guid, $videowidth, $videoheight);

	return $embed_object;
}

/**
 * parse metacafe url
 *
 * @param string $url
 * @return string hash
 */
function videoembed_metacafe_parse_url($url) {
	// separate parsing embed url
	if (strpos($url, 'embed') != false) {
		return videoembed_metacafe_parse_embed($url);
	}

	if (!preg_match('/(https?:\/\/)(www\.)?(metacafe\.com\/watch\/)([0-9a-zA-Z_-]*)(\/[0-9a-zA-Z_-]*)(\/)/', $url, $matches)) {
		//echo "malformed metacafe group url";
		return;
	}

	$hash = $matches[4] . $matches[5];

	//echo $hash;

	return $hash;
}

/**
 * parse metacafe embed code
 *
 * @param string $url
 * @return string hash
 */
function videoembed_metacafe_parse_embed($url) {
	if (!preg_match('/(src="https?:\/\/)(www\.)?(metacafe\.com\/fplayer\/)([0-9]*)(\/[0-9a-zA-Z_-]*)(\.swf)/', $url, $matches)) {
		//echo "malformed embed metacafe url";
		return;
	}

	$hash   = $matches[4] . $matches[5];
	//echo $hash;

	return $hash;
}

/**
 * main veoh interface
 *
 * @param string $url
 * @param integer $guid unique identifier of the widget
 * @param integer $videowidth  optional override of admin set width
 * @return string css style, video div, and flash <object>
 */
function videoembed_veoh_handler($url, $guid, $videowidth) {
	// this extracts the core part of the url needed for embeding
	$videourl = videoembed_veoh_parse_url($url);
	if (!isset($videourl)) {
		return '<p><b>' . sprintf(elgg_echo('embedvideo:parseerror'), 'veoh') . '</b></p>';
	}

	videoembed_calc_size($videowidth, $videoheight, 410/311, 30);

	$embed_object = videoembed_add_css($guid, $videowidth, $videoheight);

	$embed_object .= videoembed_add_object('veoh', $videourl, $guid, $videowidth, $videoheight);

	return $embed_object;
}

/**
 * parse veoh url
 *
 * @param string $url
 * @return string hash
 */
function videoembed_veoh_parse_url($url) {
	// separate parsing embed url
	if (strpos($url, 'embed') != false) {
		return videoembed_veoh_parse_embed($url);
	}

	if (!preg_match('/(http:\/\/www\.veoh\.com\/.*\/videos#watch%3D)([0-9a-zA-Z]*)/', $url, $matches)) {
		//echo "malformed veoh url";
		return;
	}

	$hash = $matches[2];

	//echo $hash;

	return $hash;
}

/**
 * parse veoh embed code
 *
 * @param string $url
 * @return string hash
 */
function videoembed_veoh_parse_embed($url) {
	if (!preg_match('/(src="https?:\/\/)(www\.)?(veoh\.com\/static\/swf\/webplayer\/WebPlayer\.swf\?version=)([0-9a-zA-Z.]*)&permalinkId=([a-zA-Z0-9]*)&(.*)/', $url, $matches)) {
		//echo "malformed embed veoh url";
		return;
	}

	$hash   = $matches[5];
	//echo $hash;

	return $hash;
}

/**
 * main dm interface
 *
 * @param string $url
 * @param integer $guid unique identifier of the widget
 * @param integer $videowidth  optional override of admin set width
 * @return string css style, video div, and flash <object>
 */
function videoembed_dm_handler($url, $guid, $videowidth) {
	// this extracts the core part of the url needed for embeding
	$videourl = videoembed_dm_parse_url($url);
	if (!isset($videourl)) {
		return '<p><b>' . sprintf(elgg_echo('embedvideo:parseerror'), 'daily motion') . '</b></p>';
	}

	videoembed_calc_size($videowidth, $videoheight, 420/300, 35);

	$embed_object = videoembed_add_css($guid, $videowidth, $videoheight);

	$embed_object .= videoembed_add_object('dm', $videourl, $guid, $videowidth, $videoheight);

	return $embed_object;
}

/**
 * parse dm url
 *
 * @param string $url
 * @return string hash
 */
function videoembed_dm_parse_url($url) {
	// separate parsing embed url
	if (strpos($url, 'embed') != false) {
		return videoembed_dm_parse_embed($url);
	}

	if (!preg_match('/(http:\/\/www\.dailymotion\.com\/.*\/)([0-9a-z]*)/', $url, $matches)) {
		//echo "malformed daily motion url";
		return;
	}

	$hash = $matches[2];

	//echo $hash;

	return $hash;
}

/**
 * parse dm embed code
 *
 * @param string $url
 * @return string hash
 */
function videoembed_dm_parse_embed($url) {
	if (!preg_match('/(value="http:\/\/)(www\.)?dailymotion\.com\/swf\/video\/([a-zA-Z0-9]*)/', $url, $matches)) {
		//echo "malformed embed daily motion url";
		return;
	}

	$hash   = $matches[3];
	//echo $hash;

	return $hash;
}

/**
 * main blip interface
 *
 * @param string $url
 * @param integer $guid unique identifier of the widget
 * @param integer $videowidth  optional override of admin set width
 * @return string css style, video div, and flash <object>
 */
function videoembed_blip_handler($url, $guid, $videowidth) {
	// this extracts the core part of the url needed for embeding
	$videourl = videoembed_blip_parse_url($url);
	if (!is_array($videourl)) {
		if ($videourl == 1) {
			return '<p><b>Only embed supported for blip.tv</b></p>';
		} else {
			return '<p><b>' . sprintf(elgg_echo('embedvideo:parseerror'), 'blip.tv') . '</b></p>';
		}
	}

	$width = $videourl[1];
	$height = $videourl[2] - 30;

	videoembed_calc_size($videowidth, $videoheight, $width/$height, 30);

	$embed_object = videoembed_add_css($guid, $videowidth, $videoheight);

	$embed_object .= videoembed_add_object('blip', $videourl[0], $guid, $videowidth, $videoheight);

	return $embed_object;
}

/**
 * parse blip url
 *
 * @param string $url
 * @return string hash
 */
function videoembed_blip_parse_url($url) {
	// separate parsing embed url
	if (strpos($url, 'embed') === false) {
		return 1;
	}

	if (!preg_match('/(src="https?:\/\/blip\.tv\/play\/)([a-zA-Z0-9%]*)(.*width=")([0-9]*)(.*height=")([0-9]*)/', $url, $matches)) {
		//echo "malformed blip.tv url";
		return 2;
	}

	$hash[0] = $matches[2];
	$hash[1] = $matches[4];
	$hash[2] = $matches[6];

	//echo $hash[0];

	return $hash;
}

/**
 * main teacher tube interface
 *
 * @param string $url
 * @param integer $guid unique identifier of the widget
 * @param integer $videowidth  optional override of admin set width
 * @return string css style, video div, and flash <object>
 */
function videoembed_teachertube_handler($url, $guid, $videowidth) {
	// this extracts the core part of the url needed for embeding
	$videourl = videoembed_teachertube_parse_url($url);
	if (!is_numeric($videourl)) {
		return '<p><b>' . sprintf(elgg_echo('embedvideo:parseerror'), 'teacher tube') . '</b></p>';
	}

	videoembed_calc_size($videowidth, $videoheight, 425/330, 20);

	$embed_object = videoembed_add_css($guid, $videowidth, $videoheight);

	$embed_object .= videoembed_add_object('teacher', $videourl, $guid, $videowidth, $videoheight);

	return $embed_object;
}

/**
 * parse teachertube url
 *
 * @param string $url
 * @return string hash
 */
function videoembed_teachertube_parse_url($url) {
	// separate parsing embed url
	if (strpos($url, 'embed') !== false) {
		return videoembed_teachertube_parse_embed($url);;
	}

	if (!preg_match('/(https?:\/\/www\.teachertube\.com\/viewVideo\.php\?video_id=)([0-9]*)&(.*)/', $url, $matches)) {
		//echo "malformed teacher tube url";
		return;
	}

	$hash = $matches[2];

	echo $hash;

	return $hash;
}

/**
 * parse teacher tube embed code
 *
 * @param string $url
 * @return string hash
 */
function videoembed_teachertube_parse_embed($url) {
	if (!preg_match('/(flashvars="file=https?:\/\/www\.teachertube\.com\/embedFLV.php\?pg=video_)([0-9]*)&(.*)/', $url, $matches)) {
		//echo "malformed teacher tube embed code";
		return;
	}

	$hash   = $matches[2];
	//echo $hash;

	return $hash;
}

/**
 * main hulu interface
 *
 * @param string $url
 * @param integer $guid unique identifier of the widget
 * @param integer $videowidth  optional override of admin set width
 * @return string css style, video div, and flash <object>
 */
function videoembed_hulu_handler($url, $guid, $videowidth) {
	// this extracts the core part of the url needed for embeding
	$videourl = videoembed_hulu_parse_url($url);
	if (is_numeric($videourl)) {
		if ($videourl == 1) {
			return '<p><b>Only embed supported for hulu.com</b></p>';
		} else {
			return '<p><b>' . sprintf(elgg_echo('embedvideo:parseerror'), 'hulu.com') . '</b></p>';
		}
	}

	videoembed_calc_size($videowidth, $videoheight, 512/296, 0);

	$embed_object = videoembed_add_css($guid, $videowidth, $videoheight);

	$embed_object .= videoembed_add_object('hulu', $videourl, $guid, $videowidth, $videoheight);

	return $embed_object;
}

/**
 * parse hulu url
 *
 * @param string $url
 * @return string hash
 */
function videoembed_hulu_parse_url($url) {
	// separate parsing embed url
	if (strpos($url, 'embed') === false) {
		return 1;
	}

	if (!preg_match('/(value="https?:\/\/www\.hulu\.com\/embed\/)([a-zA-Z0-9_-]*)"(.*)/', $url, $matches)) {
		//echo "malformed blip.tv url";
		return 2;
	}

	$hash = $matches[2];

	//echo $hash;

	return $hash;
}
