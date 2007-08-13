<?php

if (!class_exists('SiteThumb')) {
class SiteThumb {

	function SiteThumb() {
		add_action('init', array('SiteThumb','init_sitethumb'));
	}
	function init_sitethumb() {
		global $wpdb, $uritag;
		global $table_prefix;
		$uritag = '{SITE}';
		
		SiteThumb::create_tables();
		add_action('deactivate_sitethumb/sitethumb.php', array('SiteThumb','drop_table'));
		add_action('admin_menu', array('SiteThumb', 'create_tab'));		
		add_filter('admin_footer', array('SiteThumb', 'sitethumb_quicktag_like_button'));
		
		SiteThumb::form_action();		
		add_filter('the_content', array('SiteThumb', 'call_thumb'));
	}
	

	
	//--------------------------------------------------------------------\\
	// add button to tinymce editor	
	//--------------------------------------------------------------------\\	
	function sitethumb_quicktag_like_button() {
		$start_tag = '[sitethumb://]';
		  // Only add the javascript to post.php, post-new.php, page-new.php, or
		  // bookmarklet.php pages
		if (strpos($_SERVER['REQUEST_URI'], 'post.php') ||
		  	strpos($_SERVER['REQUEST_URI'], 'post-new.php') ||
		  	strpos($_SERVER['REQUEST_URI'], 'page-new.php') ||
		  	strpos($_SERVER['REQUEST_URI'], 'bookmarklet.php')) {
			// Print out the HTML/Javascript to add the button
			echo '<script language="JavaScript" type="text/javascript">
				  var sitethumb_toolbar = document.getElementById("ed_toolbar");
				  if (sitethumb_toolbar) {
						var theButton = document.createElement("input");
						theButton.type = "button";
						theButton.value = "Site-Thumb";
						theButton.onclick = sitethumb_button;
						theButton.className = "ed_button";
						theButton.title = "Site-Thumb";
						theButton.id = "ed_sitethumb";
						sitethumb_toolbar.appendChild(theButton);
				  }					
				  function sitethumb_button() {
						insertHtml("'.$start_tag.'");
						return false;
				  }
					function insertHtml(myValue) {
						insertAtCursor(window.document.post.content, myValue);
					}
					function insertAtCursor(myField, myValue) {
						if (document.selection && !window.opera) {
							myField.focus();
							sel = window.document.selection.createRange();
							sel.text = myValue;
						}
						else if (myField.selectionStart || myField.selectionStart == "0") {
							var startPos = myField.selectionStart;
							var endPos = myField.selectionEnd;
							myField.value = myField.value.substring(0, startPos)
							+ myValue
							+ myField.value.substring(endPos, myField.value.length);
						} else {
							myField.value += myValue;
						}
					}
				  </script>';
		}
	}
	

	//--------------------------------------------------------------------\\
	// convert sitethumb:http://URL to embed object code
	//--------------------------------------------------------------------\\
	function call_thumb($text) {
		global $wpdb, $uritag;
		$postid = get_post($post,ARRAY_A);
		$posttitle = $postid['post_title'];
		
		$psplit = preg_split("/(\[sitethumb:\/\/.*\])/Us", $text, -1, PREG_SPLIT_DELIM_CAPTURE);
		for($i=0; $i<count($psplit); $i++) {
			$ex_text = $psplit[$i];
			if(strlen($ex_text) > 0 && strpos($ex_text,'sitethumb:')!==false) {
				$row_url = $wpdb->get_row("SELECT url, title, style 
						   FROM `".SiteThumb::tbl_sitethumb()."` 
						   WHERE id=1 LIMIT 1", ARRAY_A);
				preg_match("/\[sitethumb:\/\/(.*)\]/Us", $ex_text, $opt);
				$newstr = str_replace($uritag,$opt[1],$row_url['url']);
				$styler = ereg_replace("(\r\n|\n|\r)",'',$row_url['style']);
				$ex_text = '<div>';
				$ex_text .= '<a href="http://'.$opt[1].'">';
				$ex_text .= '<img src="'.$newstr.'" title="'.$row_url['title'].'" alt="'.$row_url['title'].'" style="'.$styler.'"/>';
				$ex_text .= '</a></div>';
			}
			$final_text .= $ex_text;
		}
		return $final_text;
	}
	
	//--------------------------------------------------------------------\\
	// admin management	
	//--------------------------------------------------------------------\\
	function create_tab() {
		add_options_page('Site-Thumb Management Page', 'Site-Thumb', 8, __FILE__, array('SiteThumb', 'sitethumb_entry'));
	}
	
	function sitethumb_entry() {
		global $wpdb, $usrname, $show_alert;
		$formact = 'edit';
		$button_caption = 'Update Site-Thumb Generator';
		
		//edit record
		$que = "SELECT * FROM `".SiteThumb::tbl_sitethumb()."` WHERE id=1 LIMIT 1";			
		$rstrack = $wpdb->get_row($que);
		if(count($rstrack) > 0) {
			foreach ($rstrack as $key => $val) {  
			// Expands SQL result to variables
				$$key = $val;
			}
			$button_caption = 'Update Site-Thumb Setting';
		}		
		echo $show_alert;
		require_once('entry.inc.php');
	}
	
	function form_action() {
		global $wpdb;
		switch($_POST['formact']) {
			case 'edit':
				$title = $wpdb->escape(trim($_POST['title']));
				$url = $wpdb->escape(trim($_POST['url']));
				$style = $wpdb->escape(trim($_POST['style']));
				$wpdb->query("UPDATE `".SiteThumb::tbl_sitethumb()."` 
							  SET url='$url', title='$title', style='$style'
							  WHERE id=1 LIMIT 1;");
				SiteThumb::call_alert("Site-Thumb setting has been updated.");
				break;
			default:				
		}
	}

	//--------------------------------------------------------------------\\
	// database
	//--------------------------------------------------------------------\\
	function tbl_sitethumb() {
		global $table_prefix;
		return $table_prefix . 'sitethumb';
	}
	function create_tables() {
		global $wpdb, $uritag;		
		if($wpdb->get_var("SHOW TABLES LIKE '".SiteThumb::tbl_sitethumb()."'") != SiteThumb::tbl_sitethumb()) {
			$wpdb->query("CREATE TABLE `".SiteThumb::tbl_sitethumb()."` (
						  `id` int(1) NOT NULL auto_increment,
						  `url` varchar(255) NOT NULL,
						  `title` varchar(255) NOT NULL,
						  `style` text NOT NULL,
						  PRIMARY KEY  (`id`),						  
						  UNIQUE KEY `url` (`url`))");
			$wpdb->query("INSERT INTO `".SiteThumb::tbl_sitethumb()."` (`id`, `url`, `title`, `style`) 
						  VALUES (1, 
						  'http://www.artviper.net/screenshots/screener.php?url=".$uritag."&sdx=1024&sdy=768&w=120&h=90',
						  'artViper designstudio website thumbnail',
						  'padding: 3px;\nborder:1px #ddd solid;');");
		}
	}
	function drop_table () {
		global $wpdb;
		$table_name = SiteThumb::tbl_sitethumb();
		$wpdb->query("DROP TABLE {$table_name}");
	} 
	//--------------------------------------------------------------------\\
	// misc functions	
	//--------------------------------------------------------------------\\
	function version() {
		return '1.0';
	}
	function full_url() {
		return '?page=sitethumb/sitethumb.class.php';
	}
	function call_alert($msg) {
		global $show_alert;
		$show_alert = '<div id="message" class="updated fade"><p>'.$msg.'</p></div>';
	}
	
} // end class
} // end if
?>