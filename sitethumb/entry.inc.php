<div class="wrap">
  <h2>Site-Thumb General Options<a NAME="regtrack"></a></h2>
  <form action="<?=SiteThumb::full_url();?>" method="post" name="sitethumb_mgmt">
	<table width="100%" cellspacing="2" cellpadding="5" class="editform">
      <tr> 
        <th style="vertical-align:top;width:200px;">Thumbnail Generator:</th>
        <td> <input name="url" type="text" id="url" value="<?php if(empty($url)) $url = 'http://'; echo $url; ?>" size="64" /> 
          <div>* URL address for the thumbnail generator (required)</div>
          <div>* Must use `{SITE}` tag for Site-Thumb to parse the website URL</div></td>
      </tr>
      <tr> 
        <th style="vertical-align:top;"> Image Alt / Title:</th>
        <td> <input name="title" type="text" value="<?php echo $title; ?>" size="64" /> 
          <div>* Alternate Text for the image</div></td>
      </tr>
    </table>
	 
	 
    <h2>CSS Style Options</h2>
    <table width="100%" cellpadding="5" cellspacing="2" class="editform">
      <tr> 
        <th style="vertical-align:top;width:200px;"> Style:</th>
        <td> <textarea name="style" cols="64" rows="6" id="style"><?php echo $style; ?></textarea> 
          <div>* Set your own CSS Style for the thumbnail images. <a href="http://www.w3schools.com/css/default.asp" target="_blank">Click 
            here</a> to learn CSS.</div>
		  <div>* To enable this feature, make sure `wp_head()` function is triggered 
            within the &lt;head&gt;&lt;/head&gt; section of your theme or you 
            could just add one in `/&lt;your theme&gt;/header.php`</div>
		  </td>
      </tr>
      <tr> 
        <th>&nbsp;</th>
        <td><p class="submit" style="text-align:left;"> 
            <input type="button" name="action_cancel" value="<?php _e('Cancel'); ?>" onClick="history.back(0);" />
            <input type="submit" name="action" value="<?php _e($button_caption); ?>" />
            <input NAME="formact" TYPE="hidden" id="formact" value="<?=$formact;?>">
          </p></td>
      </tr>
    </table>
  </form></div>