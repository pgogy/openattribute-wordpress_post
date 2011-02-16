<?php
/*
Plugin Name: Open Attribute
Plugin URI: http://openattribute.com
add licensing info to a Wordpress blog or post
Version: 0.01
Author: Open Attribute team
Author URI: http://openattribute.com
*/



function add_openattribute_action() {
  
	?>
	<script language="Javascript" type="text/javascript">
				
				function insert() {
					
					license_url = document.getElementById('license_oa').options[document.getElementById('license_oa').selectedIndex].getAttribute("license_value");
					license_shorthand = document.getElementById('license_oa').options[document.getElementById('license_oa').selectedIndex].text;
      	      				
           			
      				string = '<span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">' + document.getElementById("title_oa").value + '</span>'
      				string += ' by <a xmlns:cc="http://creativecommons.org/ns#" href="' + document.getElementById("url_oa").value + '" property="cc:attributionName" rel="cc:attributionURL">' + document.getElementById("author_oa").value + '</a>';
      				string += ' is licensed under a <a rel="license" href="' + license_url + '">' + license_shorthand + '</a>.<br />';
      				string += ' Based on a work at <a xmlns:dct="http://purl.org/dc/terms/" href="<? echo $_GET['post']; ?>" rel="dct:source"><?php echo $_GET['post']; ?></a>.';
      				
      				
      				var win = window.dialogArguments || opener || parent || top;
      				win.send_to_editor(string);
      				
      				return false;
    			}
    			
    			function insert_author(){
    			
    				document.getElementById("author_oa").value = document.getElementById('user').options[document.getElementById('user').selectedIndex].text;
    				document.getElementById("url_oa").value = "<?php echo get_option('home'); ?>/?author=" + document.getElementById('user').selectedIndex;
    			
    			}
    
    </script>
    <link rel='stylesheet' id='colors-css'  href='<?PHP echo WP_PLUGIN_URL . '/openattribute_posts/'; ?>openattribute.css' type='text/css' media='all' />
	<div id="openattribute">
		<h1>OpenAttribute</h1>
    	<h3>Adding licensing to your blog post</h3>
    	<p>Choose the author for this blog 
    <?php 
    
    	$args = array(
			'show_option_all'         => '',
			'orderby'                 => 'display_name',
			'order'                   => 'ASC',
			'multi'                   => true,
			'show'                    => 'display_name',
			'name'                    => 'user',
			'id'                      => 'user',
			'class'                   => '', 
			'blog_id'                 => $GLOBALS['blog_id']
		);
		
		wp_dropdown_users( $args ); ?></p><p>Next click to insert the author<input type="button" class="button" onclick="insert_author()" value="Insert" /></p>
		<p>If you wish to change the details you can do so now <input id="author_oa" type="text" value="" size="105" /></p>
		<p>If you wish to give the work a title you can do so<input id="title_oa" type="text" value="" size="105" /></p>
		<p>You can set a URL for yourself as an author (Wordpress address set by default)<input id="url_oa" type="text" value="" size="105" /></p>
		<p>Now choose a license
			<select name="license_oa" id="license_oa">
				<?PHP 
						
						$licenses = explode("\n",get_option('licenses')); 						
						
						while($license_pair = array_shift($licenses)){
						
							$data = explode(",",$license_pair);
			
							?><option license_value="<?PHP echo $data[0]; ?>"><?PHP echo $data[1]; ?></option><?PHP
			
						}
						?>						
			</select>		
		</p>
		<p><input type="button" class="button" onclick="insert()" value="Insert" /></p>
	<?php
}

// Adiciona novo media button
function openattribute_button($context) {
  
    $icon_url = WP_PLUGIN_URL . '/' . str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) . 'openatt.png';
    
    $string = get_permalink();
    
    $result = '<a href="media-upload.php?type=openattribute&amp;post=' . $string . '&amp;TB_iframe=1" class="thickbox" title="' . __('Add Licensing information') . '"><img src="'.$icon_url.'" alt="'. __('Add license') .'" title="'. __('Add licensing information') .'" /></a>';
       
    return $context . $result;
}

function register_mysettings() {
	//register our settings
	register_setting( 'open_attribute', 'licenses' );
}

function openattribute_options_page() {
  ?>
  	<div class="wrap">
	<h2>Open Attribute</h2>
	<p>Please enter the licenses you wish to use below</p>
	<form method="post" action="options.php">
    <?php settings_fields( 'open_attribute' ); ?>
    <textarea rows="25" cols="100" name="licenses" ><?php 
    
    														$string = get_option('licenses');
    														
    														if($string==""){
    														
    															echo "http://creativecommons.org/licenses/by-nd/3.0,Attribution-NoDerivatives CC BY-ND\n";
																echo "http://creativecommons.org/licenses/by-nc-sa/3.0,Attribution-NonCommercial-ShareAlike CC BY-NC-SA\n";
																echo "http://creativecommons.org/licenses/by-sa/3.0,Attribution-ShareAlike CC BY-SA\n";
																echo "http://creativecommons.org/licenses/by-nc/3.0,Attribution-NonCommercial CC BY-NC\n";
																echo "http://creativecommons.org/licenses/by-nc-nd/3.0,Attribution-NonCommercial-NoDerivatives CC BY-NC-ND\n";
    														
    														}else{
    														
    															echo $string;
    														
    														}
    														 
    														
    												?></textarea>    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
	</form>
</div>
  
  <?php
}

function openattribute_menu_option() {
  add_options_page('OpenAttribute Options', 'OpenAttribute Options', 'manage_options', 'openattribute', 'openattribute_options_page');
}

add_action('admin_init', 'register_mysettings' );
add_action('admin_menu', 'openattribute_menu_option');
add_filter('media_buttons_context', 'openattribute_button');
add_filter('media_upload_openattribute', 'add_openattribute_action');
?>
