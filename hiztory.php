<?php
/*
Plugin Name: Hiztory - This Day in History
Version: 0.1.4
Plugin URI: http://www.beliefmedia.com/wp-plugins/hiztory.php
Description: Displays "This Day in History" events/deaths/births/aviation events on your WordPress website with shortcode. Includes a 'generator' to manufacture appropriate shortcode you can copy and paste into your website.
Author: Marty
Author URI: http://www.beliefmedia.com/
*/


	/* Blog Time */
	function beliefmedia_internoetics_current_date_time() {
	  $blogtime = current_time( 'mysql' ); 
	  list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $blogtime );
	  $return = $today_month . '/' . $today_day . '/' . $today_year;
	 return date('jS F Y', strtotime($return));
	}


	/* Replace Words function */
	function beliefmedia_replace_words($keywords, $line, $callback) {
    	  return preg_replace_callback(
            '/(^|[^\\w\\-])(' . implode('|', array_map('preg_quote', $keywords)) . ')($|[^\\w\\-])/mi',
            function($v) use ($callback) { return $v[1] . $callback($v[2]) . $v[3]; },
            $line
          );
	}


	/*
		Simply returns post-slug by tag name
		http://codex.wordpress.org/Function_Reference/get_term_by
	*/


	function beliefmedia_getTagSlug($term) {
 	  $termSlug = get_term_by('name', $term, 'post_tag');
 	  return $termSlug->slug;
	}


	function beliefmedia_tagLinks($str) {
   	 $tags = get_tags();
          if (!empty($tags)) {
   	    foreach ( $tags as $tag ) {
              $keywords[] = $tag->name;
   	    }
   	      $newContent = beliefmedia_replace_words($keywords, $str, function($v) {
    	        $identWord = "{$v}";
                $tagname = get_option('tag_base') != '' ? strtolower(get_option('tag_base')) : 'tag';
    	        $word = '<a href="' . get_bloginfo('wpurl') . '/' . $tagname . '/' . beliefmedia_getTagSlug($identWord) . '">' . $v . '</a>';
    	        return $word;
   	      });
  	     return $newContent;
           } else {
          return $str;
         }
	}


	/* Add Admin Menu Action */
	add_action('admin_menu', 'beliefmedia_hiztory');


	/* Menu & JS/CSS for Admin Page */
	function beliefmedia_hiztory() {
	 $hiztory_settings = add_submenu_page( 'options-general.php', 'Hiztory Shortcode', 'Hiztory Shortcode', 'manage_options', 'hiztory-shortcode', 'hiztory_shortcode_page' ); 
	 add_action( "admin_head-{$hiztory_settings}", 'hiztory_admin_js_css' );
	 }
	 function hiztory_admin_js_css() { ?>

 	 <script language="JavaScript">
  	  function showhidefield() {
    	   if (document.frm.chkbox.checked) {
             document.getElementById("hideablearea").style.visibility = "hidden";
    	   } else {
             document.getElementById("hideablearea").style.visibility = "visible";
    	   }
  	 }
	 </script>

	<?php
	}

	/* Menu Links */
	function hiztory_action_links($links, $file) {
    	   static $this_plugin;
    	   if (!$this_plugin) {
            $this_plugin = plugin_basename(__FILE__);
    	   }
    	   if ($file == $this_plugin) {
          $links[] = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=hiztory-shortcode">Settings</a>';
          $links[] = '<a href="http://www.internoetics.com/" target="_blank">Internoetics</a>';
          $links[] = '<a href="http://www.flight.org/" target="_blank">Flight</a>';
    	  }
    	 return $links;
	}
	add_filter('plugin_action_links', 'hiztory_action_links', 10, 2);


	/* SC Generator */
	function hiztory_shortcode_page() {
	  echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
	    if ( ($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['shortcode_options'])) ) {
		echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Successfully Generated Hiztory Shortcode</strong></p></div>';
		} elseif ( ($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['shortcode_sidebar'])) ) {
		echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Successfully Updated "Shortcodes in Widgets" Setting ' . $hiztory_sc_mg . '</strong></p></div>';
		}
	
		echo '<h2>Hiztory Shortcode Generator</h2>';

		if ( ($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['shortcode_options'])) ) {

		echo '<h3 class="title">Shortcode Result</h3>';
		echo "Now copy the following shortcode and paste it into your WordPress <strong>text editor</strong>.<br><br>";

		$number = $_POST['number'];
		$wpDate = $_POST['chkbox'];
		$type = $_POST['type'];
		$number = $_POST['number'];
		$random = $_POST['random'];
		$list = $_POST['list'];
		$datetags = $_POST['datetags'];
		$separator = $_POST['separator'];
		$cseparator = $_POST['cseparator'];
		$time = $_POST['time'];
		$ctime = $_POST['ctime'];
		$afterpost = $_POST['afterpost'];
		$linkify = $_POST['linkify'];
		$cache = $_POST['cache'];

		$hizshortcode .= "&#91;hiztory";

		if (!$wpDate) {
		$date = $_POST['date'];
		$month = $_POST['month'];
		$hizshortcode .= "&nbsp;date=&quot;$date&quot; month=&quot;$month&quot;";
		}

		if ($number != 1) {
		$hizshortcode .= "&nbsp;number=&quot;$number&quot;";
		}

		if ( ($type) && ($type != 'aviation') ) {
		  if ($number == 1) $type = rtrim($type, 's');
		  $hizshortcode .= "&nbsp;type=&quot;$type&quot;";
		}
		  

		if ( (!$random) && ($number != 1) ) {
		$hizshortcode .= "&nbsp;random=&quot;0&quot;";
		}

		if ($datetags) {
		$hizshortcode .= "&nbsp;datetags=&quot;$datetags&quot;";
		}

		if (!$list) {
		$hizshortcode .= "&nbsp;returnaslist=&quot;$list&quot;";
		}

		if ($ctime != "") {
		$hizshortcode .= "&nbsp;dateformat=&quot;$ctime&quot;";
		} elseif ($time != 0) {
		 if ($time == 1) $time = 'D j M Y';
		 if ($time == 2) $time = 'l jS M, Y';
		 if ($time == 3) $time = 'D jS M, Y';
		$hizshortcode .= "&nbsp;dateformat=&quot;$time&quot;";
		}

		if ( ($separator != '1') && (!$cseparator) ) {
		 if ($separator == '1') $separator = "&nbsp;-&nbsp;";
		 if ($separator == '2') $separator = "";
		 if ($separator == '3') $separator = "&nbsp;";
		 if ($separator == '4') $separator = "&nbsp;:&nbsp;";
		 if ($separator == '5') $separator = "&nbsp;::&nbsp;";
		 $hizshortcode .= "&nbsp;separator=&quot;$separator&quot;";
		  } elseif ($cseparator) {
		  $hizshortcode .= "&nbsp;separator=&quot;$cseparator&quot;";
		}

		if ($afterpost) {
		$hizshortcode .= "&nbsp;afterpost=&quot;$afterpost&quot;";
		}

		if ($linkify) {
		$hizshortcode .= "&nbsp;linkify=&quot;1&quot;";
		}

		if ($cache) {
		$hizshortcode .= "&nbsp;cache=&quot;$cache&quot;";
		}

 		$hizshortcode .= "&#93;";

		echo '<input type="text" value = "' . $hizshortcode . '" STYLE="font-size: 16px; width: 45em;" onClick="this.select();">';

		}
		?>

		<h3 class="title">Hiztory Shortcode Generator.</h3>

		The generator will do nothing but assist with creating suitable shortcode for you copy and paste into your website.<br><br>


		<form action="" method="post" name="frm" id="hiztoryshortcode">
		<table class="form-table" style="width: 100%;">

			<tr>
				<th scrope="row"><label for="position">Date Option:</label></th>
				<td>

 				<input type="checkbox" name="chkbox" value="1" onclick="showhidefield()" CHECKED> <em>Yes</em>, use WordPress blog time of for data requests? Currently <strong><?php echo beliefmedia_internoetics_current_date_time(); ?></strong>. 
 				<div id='hideablearea' style='visibility:hidden;'>
				... or show results from the <select name="date" id="date">
					<option value="01">1st</option>
					<option value="02">2nd</option>
					<option value="03">3rd</option>
					<option value="04">4th</option>
					<option value="05">5th</option>
					<option value="06">6th</option>
					<option value="07">7th</option>
					<option value="08">8th</option>
					<option value="09">9th</option>
					<option value="10">10th</option>
					<option value="11">1th1</option>
					<option value="12">12th</option>
					<option value="13">13th</option>
					<option value="14">14th</option>
					<option value="15">15th</option>
					<option value="16">16th</option>
					<option value="17">17th</option>
					<option value="18">18th</option>
					<option value="19">19th</option>
					<option value="20">20th</option>
					<option value="21">21st</option>
					<option value="22">22nd</option>
					<option value="23">23rd</option>
					<option value="24">24th</option>
					<option value="25">25th</option>
					<option value="26">26th</option>
					<option value="27">27th</option>
					<option value="28">28th</option>
					<option value="29">29th</option>
					<option value="30">30th</option>
					<option value="31">31th</option>
				</select>
				&nbsp;of&nbsp;
				<select name="month" id="month">
					<option value="01">01 - Jan</option>
					<option value="02">02 - Feb</option>
					<option value="03">03 - March</option>
					<option value="04">04 - April</option>
					<option value="05">05 - May</option>
					<option value="06">06 - June</option>
					<option value="07">07 - July</option>
					<option value="08">08 - Aug</option>
					<option value="09">09 - Sep</option>
					<option value="10">10 - Oct</option>
					<option value="11">11 - Nov</option>
					<option value="12">12 - Dec</option>
				</select>
				</div>
				</td>
			</tr>

			<tr>
				<th scrope="row"><label for="type">Type of results?</label></th>

				<td>Show events relating to <select name="type" id="type">
					<option value="aviation">Aviation</option>
					<option value="events">Events</option>
					<option value="births">Births</option>
					<option value="deaths">Deaths</option>
				</select></td>
			</tr>

			<tr>
				<th scrope="row"><label for="number">How many results?</label></th>

				<td><select name="number" id="number">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
				</select></td>
			</tr>

			<tr>
				<th scrope="row"><label for="random">Randomise Results?</label></th>

				<td>
				<select name="random" id="random">
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>
				</td>
			</tr>

			<tr>
				<th scrope="row"><label for="list">Return results in a list (if more than one)?</label></th>

				<td>
				<select name="list" id="list">
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>
				</td>
			</tr>

			<tr>
				<th scrope="row"><label for="linkify">Linkify text based on category tags?</label></th>

				<td>
				<select name="linkify" id="linkify">
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
				</td>
			</tr>

			<tr>
				<th scrope="row"><label for="datetags">HTML for the date (no &lt; or &gt; tags):<br><small>eg. <code>em,strong</code></small></label></th>

				<td>
				<input type="text" name="datetags" id="datetags">
				</td>
			</tr>

			<tr>
				<th scrope="row"><label for="datetags">Separator between date & content?</label></th>

				<td>
				<select name="separator" id="separator">
					<option value="1">&nbsp;-&nbsp;</option>
					<option value="2">NIL</option>
					<option value="3">BLANK SPACE</option>
					<option value="4">&nbsp;:&nbsp;</option>
					<option value="5">&nbsp;::&nbsp;</option>
				</select> or enter your own (others will be ignored) <input type="text" name="cseparator" id="cseparator" size="10">
				</td>
			</tr>

			<tr>
				<th scrope="row"><label for="time">Date Format:</label></th>

				<td>
				<select name="time" id="time">
					<option value="0">jS F Y - 3rd December 2004</option>
					<option value="1">D j M Y - Sun 3 Dec 1944</option>
					<option value="2">l jS M, Y - Sunday 3rd Dec, 1944</option>
					<option value="3">D jS M, Y - Sun 3rd Dec, 1944</option>
				</select> or enter <a href="http://www.php.net/manual/en/function.date.php" target="_blank">your own</a> (others will be ignored) <input type="text" name="ctime" id="ctime" size="10">
				</td>
			</tr>

			<tr>
				<th scrope="row"><label for="afterpost">After post HTML:<br><small>After post if NOT a list</small></label></th>

				<td>
				<input type="text" name="afterpost" id="afterpost" size="10"><br>If not sepcified, it'll default to &lt;br&gt; (preferred).
				</td>
			</tr>

			<tr>
				<th scrope="row"><label for="cache">Cache Results Locally for:</label></th>

				<td>
				<select name="cache" id="cache">
					<option value="0">1 hour (default)</option>
					<option value="7200">2 hours</option>
					<option value="10800">3 hours</option>
					<option value="14400">4 hours</option>
				</select>
				</td>
			</tr>

			<tr>

				<th scrope="row">Help:</th>
				<td>
				The best place to get any help is via the <a href="http://www.beliefmedia.com/wp-plugins/hiztory.php" target="_blank">BeliefMedia</a> website.
				</td>
			</tr>

		</table>
		<p class="submit"><input type="submit" name="shortcode_options" value="Get Shortcode &raquo;" class="button button-primary"/></p>
		<?php // submit_button( 'Generate Shortcode' ); ?>
		</form>

<?php

		/* Shortcode Filter Option */
		if ( ($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['shortcode_sidebar'])) ) {
		$new_sc_value = $_POST['widget_shortcode'];
		if ( get_option('widget_shortcode', 0) !== false ) {
		  update_option('widget_shortcode', "$new_sc_value");
		  } else {
		  add_option('widget_shortcode', "$new_sc_value", $deprecated = null, $autoload = 'no' );
		  }
		}

		echo '<h3>Sidebar Shortcode Support?</h3>';

		echo 'Enable shortcode support to sidebar widgets? (Use <strong>only</strong> if your shortcode doesn\'t execute and instead shows plain text)';

		echo '<table class="form-table" style="width: 100%;">';
		echo '<tr><th scrope="row"><label for="scmsg">Enable Shortcodes in Widgets?<br>' . $hiztory_sc_mg . '</label></th>';
		echo '<form method="post" action="">';
		$hiztory_sc_mg = get_option('widget_shortcode');
	        ($hiztory_sc_mg == '1') ? $hiztory_sc_mg = '<code>Currently set to <strong>Yes</strong> (active)</code>' : $hiztory_sc_mg = '<code>Currently set to <strong>No</strong> (disabled)</code>';
		echo '<td><select name="widget_shortcode" id="widget_shortcode"><option value="0">No</option><option value="1">Yes</option></select>&nbsp;<strong>Status</strong> :: ' . $hiztory_sc_mg . '</td></tr>';	
		echo '</table>';
		echo '<p class="submit"><input type="submit" name="shortcode_sidebar" value="Update &raquo;" class="button button-primary" /></p>';
		// submit_button();
		echo '</form>';

	  echo '</div>';
}


/*
	Add shortcode filter if enabled
*/


	if (get_option('widget_shortcode', 0) != '0') add_filter('widget_text', 'do_shortcode');


/*
	Hiztory Shortcode
*/


function beliefmedia_internoetics_get_hiztory($atts) {
 extract(shortcode_atts(array(
    'type' => 'aviation',
    'month' => '',
    'date' => '',
    'number' => '1',
    'useblogdate' => 1,
    'returnaslist' => 1,
    'after' => '<br>',
    'datetags' => '',
    'separator' => ' - ',
    /* Date format :: http://php.net/manual/en/function.date.php */
    'dateformat' => 'jS F Y',
    'random' => '1',
    'tags' => '0',
    'linkify' => '0',
    'cache' => '3600' // 1 hour
  ), $atts));

 /* Construct date tag(s) */
 if ($datetags) {
  $tags = explode(",", $datetags);
    foreach($tags as $tag) {
    $htmltag .= '<' . $tag . '>';  
   }
  $datetags = $htmltag;
  $closingdatetag = str_replace('<', '</', "$datetags");
 }

 /* If we're using time from our WP website */
 if ( ($useblogdate) && ((!$month) && (!$date)) ) {
 $blogtime = current_time('mysql'); 
 list($today_year, $today_month, $today_day) = split( '([^0-9])', $blogtime );
 $month = $today_month;
 $date = $today_day;
 }

 /* Correct Defaults */
 if ( (!$returnaslist) && ($after == '') ) $after = "<br>";
 (($number != '1') && ($random)) ? $num = '15' : $num = $number;

 /* If we're not using blog time and haven't specified a date. Server time. */
 if ( (!$useblogdate) && ((!$month) && (!$date)) ) {
 $timeNow = time();
 $month = date('m', $timeNow);
 $date = date('d', $timeNow);
   $length = strlen($date);
   if ($length == '1') {
   $date = '0' . $date; 
   }
 }

 /* Retrieve Cached WP Results */
 $ident = md5("$number.$cache.$type.$month.$date.$useblogdate.$returnaslist.$dateformat.$after.$separator.$datetags.$linkify.$random");
 $hiztoryRecord = 'hzty_' . $ident;
 $cachedposts = get_transient($hiztoryRecord);
 if ($cachedposts !== false) {
 return $cachedposts;

 } else {

  $typ = rtrim($type, 's');

   if ($number == '1') {

     if ( ($month) && ($date) ) {
     $xml = simplexml_load_file('http://api.hiztory.org/date/' . $typ . '/' . $month . '/' . $date . '/api.xml');
     } else {
     $xml = simplexml_load_file('http://api.hiztory.org/random/' . $typ . '.xml');
     }

	if ($xml->status->attributes()->{'code'} == '200') {
	$content = (string) $xml->event->attributes()->{'content'};
	$date = (string) $xml->event->attributes()->{'date'};
	 $date = date("$dateformat", strtotime($date));
	$return .= $content;
	if ($separator) $return .= $separator;
	if ($datetags) $return .= $datetags;
	$return .= $date;
	if ($datetags) $return .= $closingdatetag;

	} else {
	 $return = "History data unavailable for a short time. Check back soon";
	 $cache = '600'; // Try again in 10 minutes
	}
  
    } else {

     /* API info :: http://api.hiztory.org */
     $xml = simplexml_load_file('http://api.hiztory.org/' . $type . '/' . $month . '/' . $date . '/1/' . $num . '/api.xml');

     /* Create Temp Array */
     if ($xml->status->attributes()->{'code'} == '200') {

	 foreach ($xml->events->event as $event) {
	   $temp['content'] = (string) $event->attributes()->{'content'};
	    $date = (string) $event->attributes()->{'date'};
	   $temp['date'] = date("$dateformat", strtotime($date));
	   $result[] = $temp;
	   }

      /* Randomise result */
      if ($random) shuffle($result);

      /* Create output */
	$i = 1;
        if ($returnaslist) $return .= '<ul>';
         foreach ($result as $hiztory) {
	  if ($returnaslist) $return .= '<li>';
          $return .= $hiztory['content'];
	  if ($separator) $return .= $separator;
	  if ($datetags) $return .= $datetags;
	  $return .= $hiztory['date'];
	  if ($datetags) $return .= $closingdatetag;
	  if (($after) && ($i < $number)) $return .= $after;
	  if ($returnaslist) $return .= '</li>';
	 if ($i == $number) break; $i++;
         }
        if ($returnaslist) $return .= '</ul>';

   } else {
   $return = "History data unavailable for a short time. Check back soon";
   $cache = '600'; // Try again in 10 minutes
   }

  }
 }

 if ($linkify) $return = beliefmedia_tagLinks($return);
 set_transient($hiztoryRecord, $return, $cache); 
 return $return;
}
add_shortcode('hiztory','beliefmedia_internoetics_get_hiztory');
?>