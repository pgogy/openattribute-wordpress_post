<?php
/*
Plugin Name: Open Attribute
Plugin URI: http://openattribute.com
OpenAttribute allows you to add licensing information to your WordPress site and individual blogs. It places information into posts and RSS feeds as well as other user friendly features.
Version: 1
Author: OpenAttribute, pgogy
Author URI: http://openattribute.com
*/

function openattribute_firstrun() {

	if ( get_option( 'openattribute_firstrun' ) == '1' ) {

		echo "<div class='updated fade'>";

		echo '<p style="text-decoration:underline; font-weight:bold">Information on OpenAttribute</p>';

		echo '<p>Thanks for installing OpenAttribute. You can find out about how to use our <a href="http://openattribute.com/first-run-wordpress/" target="_blank">wordpress plugin</a> on our <a href="http://openattribute.com">OpenAttribute</a> site, where we also have browser plugins.</p>';

		echo "<p>If you'd like to get started straight away - either go to <a href=\"options-general.php?page=openattribute\">OpenAttribute settings page</a> or start a new blog post and look for the symbol below.</p>";

		echo '<p><img src="' . WP_PLUGIN_URL . '/' . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) . 'information.png" /></p>';

		echo '<p>You can turn this screen off on the <a href="options-general.php?page=openattribute">OpenAttribute settings page</a></p>';

		echo '</div>';

		update_option( 'openattribute_firstrun', 0 );

	}

}

function add_openattribute_action() {

	?>

	<script language="Javascript" type="text/javascript">

				function insert() {

					var win = window.dialogArguments || opener || parent || top;

					var data = win.document.getElementById('content_ifr');

					if(data==null){

						data = win.document.getElementById('content').value;

					}else{

						data = data.contentWindow.document.body.innerHTML;

					}

					current_author="";
					current_title="";
					current_oashorthand="";
					current_attribution_url="";

					author_data = data.split('oaattributionurl');

					if(author_data.length!=1){

						author = author_data[1];

						author = author.split('>');

						author = author[1];

						author = author.split('<');

						current_author=author[0];

					}

					title_data = data.split('oatitle');

					if(title_data.length!=1){

						title = title_data[1];

						title = title.split('>');

						title = title[1].split('<');

						if(title.length!=1){

							current_title=title[0];

						}

					}

					attribution_url_data = data.split('oaattributionurl');

					if(attribution_url_data.length!=1){

						attribution_url = attribution_url_data[1];

						attribution_url = attribution_url.split('href="');

						attribution_url = attribution_url[1];

						attribution_url = attribution_url.split('"');

						if(attribution_url.length!=1){

							current_attribution_url=attribution_url[0];

						}

					}

					oashorthand_data = data.split('oalicense');

					if(oashorthand_data.length!=1){

						oashorthand = oashorthand_data[1];

						oashorthand = oashorthand.split('>');

						oashorthand = oashorthand[1];

						oashorthand = oashorthand.split('<');

						if(oashorthand.length!=1){

							current_oashorthand=oashorthand[0];

						}

					}

					oalicenseurl_data = data.split('rel="license" href="');

					if(oalicenseurl_data.length!=1){

						oalicenseurl = oalicenseurl_data[1];

						oalicenseurl = oalicenseurl.split('"');

						if(oalicenseurl.length!=1){

							current_oalicenseurl=oalicenseurl[0];

						}

					}

					license_url = document.getElementById('license_oa').options[document.getElementById('license_oa').selectedIndex].getAttribute("license_value");
					license_shorthand = document.getElementById('license_oa').options[document.getElementById('license_oa').selectedIndex].text;
						title = document.getElementById("title_oa").value;
						attribution_url = document.getElementById("url_oa").value;
						author = document.getElementById("author_oa").value;

						if((current_oashorthand!="")||(current_attribution_url!="")||(current_title!="")||(current_author!="")){

							var data_drop = win.document.getElementById('content_ifr');

						if(data_drop==null){

							win.document.getElementById('content').value = "";

						}else{

							data_drop.contentWindow.document.body.innerHTML = "";

						}

							string = data;

							string = string.split('>' + current_title + '</a>').join(' xmlns:dc="http://purl.org/dc/terms/" property="dc:title">' + title + '</a>');

							string = string.split('xmlns:cc="http://creativecommons.org/ns#" href="' + current_attribution_url).join('xmlns:cc="http://creativecommons.org/ns#" href="' + attribution_url);
							string = string.split(' oaauthor="' + current_author + '">' + current_author + '</a>').join(' oaauthor="' + author + '">' + author + '</a>');
							string = string.split('rel="license" href="' + current_oalicenseurl + '">').join('rel="license" href="' + license_url + '">');
							string = string.split(current_oashorthand + '</a>').join(license_shorthand + '</a>');

						}else{

						  string = ' <a xmlns:dc="http://purl.org/dc/terms/" property="dc:title" id="oatitle" href="<?PHP echo $_GET['post']; ?>">' + title + '</a>'
						  string += ' by <a id="oaattributionurl" xmlns:cc="http://creativecommons.org/ns#" href="' + attribution_url + '" property="cc:attributionName" rel="cc:attributionURL" oaauthor="' + author + '">' + author + '</a>';
						  string += ' is licensed under a <a id="oalicense" rel="license" href="' + license_url + '">' + license_shorthand + '</a>.<br />';
						  string += ' Based on a work at <a xmlns:dct="http://purl.org/dc/terms/" href="<?PHP echo $_GET['post']; ?>" rel="dct:source"><?PHP echo $_GET['post']; ?></a>.';

					  }



					  win.send_to_editor('<?php echo get_option( 'openattribute_pre_license_html' ); ?>' + string + '<?php echo get_option( 'openattribute_post_license_html' ); ?>');

					  return true;

				}

				function insert_author(){

					document.getElementById("author_oa").value = document.getElementById('user').options[document.getElementById('user').selectedIndex].text;
					document.getElementById("url_oa").value = "<?php echo get_option( 'home' ); ?>/?author=" + document.getElementById('user').selectedIndex;

				}

	</script>
	<link rel='stylesheet' id='colors-css'  href='<?php echo WP_PLUGIN_URL . '/openattribute/'; ?>openattribute_iframe.css' type='text/css' media='all' />
	<div id="openattribute">
		<img src="<?PHP echo WP_PLUGIN_URL . '/openattribute/'; ?>openAttrLogo.jpg" />
		<h3>Adding licensing to your blog post</h3>
		<p>Choose the author for this blog
	<?php

		global $current_user;

		wp_get_current_user();

		$args = array(
			'show_option_all' => '',
			'orderby'         => 'display_name',
			'order'           => 'ASC',
			'multi'           => true,
			'show'            => 'display_name',
			'name'            => 'user',
			'selected'        => $current_user->ID,
			'id'              => 'user',
			'class'           => '',
			'blog_id'         => $GLOBALS['blog_id'],
		);

		wp_dropdown_users( $args );
	?>
		</p><p>Next click to insert the author<input type="button" class="button" onclick="insert_author()" value="Insert" /></p>
		<script type="text/javascript">

			var win = window.dialogArguments || opener || parent || top;

			var data = win.document.getElementById('content_ifr');

			if(data==null){

				data = win.document.getElementById('content').value;

			}else{

				data = data.contentWindow.document.body.innerHTML;

			}

			author_data = data.split('oaattributionurl');

			if(author_data.length!=1){

				author_data = author_data[1];

				author = author_data.split('>');

				author = author[1];

				author = author.split('<');

				author=author[0];

				if(author!=""){

					document.write('<p>If you wish to change the details you can do so now <input id="author_oa" type="text" value="' + author + '" size="90" /></p>');

				}

			}else{

				<?PHP

				if ( $current_user->user_firstname == '' ) {

					$author = $current_user->user_nicename;

				} else {

					$author = $current_user->user_firstname . ' ' . $current_user->user_lastname;

				}

				?>

				document.write('<p>If you wish to change the details you can do so now <input id="author_oa" type="text" value="<?PHP echo $author; ?>" size="90" /></p>');

			}


			title_data = data.split('oatitle');

			if(title_data.length!=1){

				title = title_data[1];

				title = title.split('>');

				title = title[1];

				title = title.split('<');

				if(title.length!=1){

					title=title[0];

					if(title!=""){

						document.write('<p>If you wish to give the work a title you can do so<input id="title_oa" type="text" value="' + title + '" size="90" /></p>');

					}

				}else{



					document.write('<p>If you wish to give the work a title you can do so<input id="title_oa" type="text" value="" size="90" /></p>');

				}

			}else{

				title = win.document.getElementById('title').value;

				document.write('<p>If you wish to give the work a title you can do so<input id="title_oa" type="text" value="' + title + '" size="90" /></p>');

			}

			attribution_url_data = data.split('oaattributionurl');

			if(attribution_url_data.length!=1){

				attribution_url = attribution_url_data[1].split('href="');

				attribution_url = attribution_url[1].split('"');

				if(attribution_url.length!=1){

					attribution_url=attribution_url[0];

				}

				if(attribution_url!=""){

					document.write('<p>You can set a URL for yourself as an author (WordPress address set by default)<input id="url_oa" type="text" value="' + attribution_url + '" size="90" /></p>');

				}else{

					document.write('<p>You can set a URL for yourself as an author (WordPress address set by default)<input id="url_oa" type="text" value="<?PHP echo site_url(); ?>" size="90" /></p>');

				}

			}else{

				document.write('<p>You can set a URL for yourself as an author (WordPress address set by default)<input id="url_oa" type="text" value="<?PHP echo site_url(); ?>" size="90" /></p>');

			}

		</script>
		<p>Now choose a license
			<select name="license_oa" id="license_oa">
				<?PHP

						$licenses = explode( "\n", get_option( 'openattribute_licenses' ) );

				while ( $license_pair = array_shift( $licenses ) ) {

					$data = explode( ',', $license_pair );

					?>
							<option license_value="<?PHP echo $data[0]; ?>"><?PHP echo $data[1]; ?></option>
							<?PHP

				}
				?>
			</select>
		</p>
		<script type="text/javascript">

			var win = window.dialogArguments || opener || parent || top;

			var data = win.document.getElementById('content_ifr');

			if(data==null){

				data = win.document.getElementById('content').value;

			}else{

				data = data.contentWindow.document.body.innerHTML;

			}

			oashorthand_data = data.split('oalicense');

			if(oashorthand_data.length!=1){

				oashorthand = oashorthand_data[1];

				oashorthand = oashorthand.split('>');

				oashorthand = oashorthand[1];

				oashorthand = oashorthand.split('<');

				if(oashorthand.length!=1){

					oashorthand=oashorthand[0];

					if(oashorthand!=""){

						document.write('<p>The current license is set as ' + oashorthand + '</p>');

					}

				}

			}

		</script>
		<p><input type="button" class="button" onclick="insert()" value="Insert" /></p>
	<?php
}

function openattribute_button( $context ) {

	$icon_url = WP_PLUGIN_URL . '/' . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) . 'openatt.png';

	$string = get_permalink();

	$result = '<a href="media-upload.php?type=openattribute&amp;post=' . $string . '&amp;TB_iframe=1" class="thickbox" title="' . __( 'OpenAttribute - Add Licensing information' ) . '"><img src="' . $icon_url . '" alt="' . __( 'Add license' ) . '" title="' . __( 'Add licensing information' ) . '" /></a>';

	return $context . $result;
}

function openattribute_register() {

	update_option( 'openattribute_licenses', "http://creativecommons.org/licenses/by/3.0,Creative Commons Attribution CC BY 3.0\nhttp://creativecommons.org/licenses/by-nd/3.0,Creative Commons Attribution-NoDerivatives CC BY-ND 3.0\nhttp://creativecommons.org/licenses/by-nc-sa/3.0,Creative Commons Attribution-NonCommercial-ShareAlike CC BY-NC-SA 3.0 \nhttp://creativecommons.org/licenses/by-sa/3.0,Creative Commons Attribution-ShareAlike CC BY-SA 3.0\nhttp://creativecommons.org/licenses/by-nc/3.0,Creative Commons Attribution-NonCommercial CC BY-NC 3.0\nhttp://creativecommons.org/licenses/by-nc-nd/3.0,Creative Commons Attribution-NonCommercial-NoDerivatives CC BY-NC-ND 3.0\nhttps://creativecommons.org/publicdomain/zero/1.0/,Creative Commons Public Domain Dedication\nhttp://creativecommons.org/licenses/by/4.0,Creative Commons Attribution CC BY 4.0\nhttp://creativecommons.org/licenses/by-nd/4.0,Creative Commons Attribution-NoDerivatives CC BY-ND 4.0\nhttp://creativecommons.org/licenses/by-nc-sa/4.0,Creative Commons Attribution-NonCommercial-ShareAlike CC BY-NC-SA 4.0 \nhttp://creativecommons.org/licenses/by-sa/4.0,Creative Commons Attribution-ShareAlike CC BY-SA 4.0\nhttp://creativecommons.org/licenses/by-nc/4.0,Creative Commons Attribution-NonCommercial CC BY-NC 4.0\nhttp://creativecommons.org/licenses/by-nc-nd/4.0,Creative Commons Attribution-NonCommercial-NoDerivatives CC BY-NC-ND 4.0\n" );
	add_option( 'openattribute_firstrun', 1 );
	add_option( 'openattribute_rss', 1 );
	add_option( 'openattribute_blogoverride', 1 );
	add_option( 'openattribute_buttonset', 1 );
	add_option( 'openattribute_linkset', 1 );
	add_option( 'openattribute_widgetset', 1 );
	add_option( 'openattribute_rdfa', 1 );
	add_option( 'openattribute_disable', 1 );
	add_option( 'openattribute_site_license', '' );
	add_option( 'openattribute_site_author', '' );
	add_option( 'openattribute_site_attribution_url', '' );
	add_option( 'openattribute_append_content', '1' );
	add_option( 'openattribute_append_footer', '1' );
	add_option( 'openattribute_pre_license_html', '<div>' );
	add_option( 'openattribute_post_license_html', '</div>' );
	add_option( 'openattribute_authoroverride', '' );
	add_option( 'openattribute_index', 0 );
	add_option( 'openattribute_indexsingle', 0 );
	add_option( 'openattribute_postsonly', 0 );
	add_option( 'openattribute_postsonly', 0 );

}

function openattribute_options_page() {
	?>
	  <div class="wrap">
	<h2>Open Attribute</h2>
	<p>OpenAttribute is a WordPress plugin designed to allow users to add reuse licenses into their WordPress sites.</p>
	<p>Built to allow users to be as flexible as possible with their licenses, OpenAttribute allows you to attribute your entire site or attribute each post / page individually if required.</p>
	<p>On this control panel options for licensing are therefore divided between <a href="#blog">per page / post</a> and <a href="#site">per site</a> options. You can also <a href="#license">add</a> any licenses you would like to be able to use</p>
	<p>This control panel also has <a href="#plugin">plugin settings</a> to control features such as RSS and attribution buttons</p>
	<form method="post" action="<?PHP echo $_SERVER[ REQUEST_URI ]; ?>">
	<input name="submitted" type="hidden" value="openattribute" />
	<?PHP

		$first_run      = get_option( 'openattribute_firstrun' ) == '1' ? 'checked' : '';
		$rss_feed       = get_option( 'openattribute_rss' ) == '1' ? 'checked' : '';
		$blog_override  = get_option( 'openattribute_blogoverride' ) == '1' ? 'checked' : '';
		$buttonset      = get_option( 'openattribute_buttonset' ) == '1' ? 'checked' : '';
		$linkset        = get_option( 'openattribute_linkset' ) == '1' ? 'checked' : '';
		$widgetset      = get_option( 'openattribute_widgetset' ) == '1' ? 'checked' : '';
		$rdfa           = get_option( 'openattribute_rdfa' ) == '1' ? 'checked' : '';
		$disable        = get_option( 'openattribute_disable' ) == '1' ? 'checked' : '';
		$append_content = get_option( 'openattribute_append_content' ) == '1' ? 'checked' : '';
		$append_footer  = get_option( 'openattribute_append_footer' ) == '1' ? 'checked' : '';
		$indexposts     = get_option( 'openattribute_index' ) == '1' ? 'checked' : '';
		$indexsingle    = get_option( 'openattribute_indexsingle' ) == '1' ? 'checked' : '';
		$postsonly      = get_option( 'openattribute_postsonly' ) == '1' ? 'checked' : '';
		$altlink        = get_option( 'openattribute_altlink' );

	?>
	<h3><a name="plugin">Attribution appearance settings</a></h3>
	<p>Here you can set settings for the plugin, these settings can be changed at anytime.</p>
	<div style="width:95%; padding:10px; border:1px solid black"><b><u>Choosing how the visitor sees the attribution</u></b><br/>
		<p>
			The attribution can appear in two ways (both can be used if you wish).
		</p>
		<div style="float:left; position:relative; width:50%; text-align:center; height:75px; padding-bottom:10px;">
			<img src="<?PHP echo WP_PLUGIN_URL . '/' . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) . 'attrib_button.png'; ?>" />
			<p>
				As this button.
			</p>
		</div>
		<div style="float:left; position:relative; width:50%; text-align:center; height:75px; padding-bottom:10px;">
			<p>
				<a href="">
					Attribute this resource
				</a>
			</p>
			<p>
				As a link such as the one above.
			</p>
		</div>
		<br />
		<input type="checkbox" name="openattribute_buttonset" <?PHP echo $buttonset; ?> /> If this box is ticked, an Open Attribute "Attribute Me" button will appear on all attributed resources (pages and posts) <br />
		Replace the Open Attribute "Attribute Me" button with a different URL <input type="text" size="100" name="openattribute_altlink" value="<?PHP echo $altlink; ?>" /><br />
		<input type="checkbox" name="openattribute_linkset" <?PHP echo $linkset; ?> /> If this box is ticked, an Open Attribute "Attribute Me" link will appear on all attributed resources (pages and posts) <br />
		   <input type="checkbox" name="openattribute_widgetset" <?PHP echo $widgetset; ?> /> Display attribution in the widget. In doing this the Widget can be made to appear anywhere your theme supports Widgets <br />
		</p>
	</div>
	<div style="width:95%; padding:10px; border:1px solid black; margin-top:7px;"><b><u>Where will the link / button appear?</u></b><br/>
		<p>
			Your license can either appear directly at the end of your post or page - or after comments. You can tick both boxes if you prefer. You can use this and insert attribution as text into a page or post's content.<br><br>
			<b>Using this option</b> is like setting a site license, and so will appear on all content.
		</p>
		<input type="checkbox" name="openattribute_append_content" <?PHP echo $append_content; ?> /> Display the attribution after the blog's content (before comments)<br />
		<input type="checkbox" name="openattribute_append_footer" <?PHP echo $append_footer; ?> /> Display the attribution after comments on the blog <br />
		<input type="checkbox" name="openattribute_index" <?PHP echo $indexposts; ?> /> Display attribution on the index page <br />
		<input type="checkbox" name="openattribute_indexsingle" <?PHP echo $indexsingle; ?> /> Display attribution on the index page (if multiple posts appear)  <br />
		<input type="checkbox" name="openattribute_postsonly" <?PHP echo $postsonly; ?> /> Display the attribution only on blog posts (not pages) <br />
		<div>
			<p style="font-weight:bold">Please note the following</p>
			<?PHP echo '<p><img src="' . WP_PLUGIN_URL . '/' . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) . 'information.png" /></p>'; ?>
			<p>If you insert using this button then the license is added as text to the post / page content itself, and will therefore be displayed where you put it in the page / post. The options above (after content / after comments) will not affect the location for this license.</p>
		</div>
	</div>
	<div style="width:95%; padding:10px; border:1px solid black; margin-top:7px;"><b><u>HTML Options</u></b><br/>
		<p>
			This section allows you (if you wish) to style how the attribution will appear.
		</p>
		<p>Before<br/>
		<textarea cols="100" name="openattribute_pre_license_html"><?PHP echo stripslashes( get_option( 'openattribute_pre_license_html' ) ); ?></textarea><br />
		</p><p>After<br/>
		<textarea cols="100" name="openattribute_post_license_html"><?PHP echo get_option( 'openattribute_post_license_html' ); ?></textarea><br />
		   </p>
	</div>
	<div style="width:95%; padding:10px; border:1px solid black; margin-top:7px;"><b><u>Add licensing info to the RSS feeds</u></b><br/>
		<p>
			Ticking this box will add attribution information to the RSS / RDFa / RSS2 feeds
		</p>
		<input type="checkbox" name="openattribute_rss" <?PHP echo $rss_feed; ?> /> If this box is ticked, the license information will be added to the RSS and Atom feeds <br />
	</div>
	<div style="width:95%; padding:10px; border:1px solid black; margin-top:7px;"><b><u>Administrative features</u></b><br/>
		<p>
			You can allow an author to override a site license with a post / page specific license (inserted using the button shown above), or allow a user to opt out of licensing a specific post / page completely.
		</p>
		<input type="checkbox" name="openattribute_blogoverride" <?PHP echo $blog_override; ?> /> If this box is ticked, if you add a license into the page / post, then the site license will not be displayed <br />
		 <input type="checkbox" name="openattribute_disable" <?PHP echo $disable; ?> /> If this box is ticked, a page / post author can opt out of having their work attributed<br />
	</div>
	<div style="width:95%; padding:10px; border:1px solid black; margin-top:7px;"><b><u>The first run page</u></b><br/>
		<p>
			You can turn off the first run page here.
		</p>
		<input type="checkbox" name="openattribute_firstrun" <?PHP echo $first_run; ?> /> If this box is ticked, the "first run" guidance will be displayed <br />
	</div>
	<h3><a name="licenses">Add Licenses</a></h3>
	<p>Please enter the licenses you wish to use below. The format for the license is "<b>URL</b><b>,</b><b>text to display on screen</b>". If you wish to use a custom license, perhaps create a page on your blog to hold your licensing info. By default you have been provided with some <a href="http://www.creativecommons.org" target="_blank">Creative Commons licenses</a>.</p>
	<textarea rows="5" cols="100" style="width:100%; height:200px;" name="openattribute_licenses" >
	<?php

															$string = get_option( 'openattribute_licenses' );

	if ( $string == '' ) {

		echo "http://creativecommons.org/licenses/by-nd/3.0,Attribution-NoDerivatives CC BY-ND\n";
		echo "http://creativecommons.org/licenses/by-nc-sa/3.0,Attribution-NonCommercial-ShareAlike CC BY-NC-SA\n";
		echo "http://creativecommons.org/licenses/by-sa/3.0,Attribution-ShareAlike CC BY-SA\n";
		echo "http://creativecommons.org/licenses/by-nc/3.0,Attribution-NonCommercial CC BY-NC\n";
		echo "http://creativecommons.org/licenses/by-nc-nd/3.0,Attribution-NonCommercial-NoDerivatives CC BY-NC-ND\n";

	} else {

		echo $string;

	}

	?>
													</textarea>
	<h3><a name="site">Setup a site license</a></h3>
	<p>Choose a site license from this list - you can add new licenses in the box above</p>
	<select name="openattribute_license_for_site" id="openattribute_license_for_site">
			<?PHP

					$licenses = explode( "\n", get_option( 'openattribute_licenses' ) );

			while ( $license_pair = array_shift( $licenses ) ) {

				$data = explode( ',', $license_pair );

				?>
						<option license_value="
						<?PHP

						echo $data[0];

						echo '" ';

						if ( trim( get_option( 'openattribute_site_license' ) ) == trim( $data[1] ) ) {

							echo ' selected ';

						}

						echo '>' . $data[1] . '</option>';

			}
			?>
	</select><p>The current license is -
	<?PHP

		echo get_option( 'openattribute_site_license' );

	?>
	<p>Choose an author name to display for this site<br />
	<?PHP

	$args = array(
		'show_option_all' => '',
		'orderby'         => 'display_name',
		'order'           => 'ASC',
		'multi'           => true,
		'show'            => 'display_name',
		'name'            => 'user',
		'id'              => 'user',
		'class'           => '',
		'blog_id'         => $GLOBALS['blog_id'],
	);

														   wp_dropdown_users( $args );

	?>
	or enter a name <input type="text" size="50" name="oa_author" value="
	<?PHP

		echo get_option( 'openattribute_site_author' );

	?>
	" /></p>
	<p>Do you wish to use a URL for this author (called an attribution url)<input value="
	<?PHP

		echo get_option( 'openattribute_site_attribution_url' );

		$author_override = get_option( 'openattribute_authoroverride' ) == '1' ? 'checked' : '';

	?>
	" type="text" size="50" name="oa_url" /></p>
	<input type="checkbox" name="openattribute_authoroverride" <?PHP echo $author_override; ?> /> If this box is ticked, the author of the page / post will be attributed.<br />
	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
	<input type="reset" class="button-primary" value="Cancel" id="cancel" />
	</p>
	</form>
</div>

	<?php
}

function openattribute_postform() {

	if ( ( isset( $_POST['submitted'] ) ) && ( $_POST['submitted'] == 'openattribute' ) ) {

		update_option( 'openattribute_licenses', $_POST['openattribute_licenses'] );

		if ( $_POST['openattribute_firstrun'] == 'on' ) {

			update_option( 'openattribute_firstrun', 1 );

		} else {

			update_option( 'openattribute_firstrun', 0 );

		}

		if ( $_POST['openattribute_rss'] == 'on' ) {

			update_option( 'openattribute_rss', 1 );

		} else {

			update_option( 'openattribute_rss', 0 );

		}

		if ( $_POST['openattribute_blogoverride'] == 'on' ) {

			update_option( 'openattribute_blogoverride', 1 );

		} else {

			update_option( 'openattribute_blogoverride', 0 );

		}

		if ( $_POST['openattribute_buttonset'] == 'on' ) {

			update_option( 'openattribute_buttonset', 1 );

		} else {

			update_option( 'openattribute_buttonset', 0 );

		}

		if ( $_POST['openattribute_linkset'] == 'on' ) {

			update_option( 'openattribute_linkset', 1 );

		} else {

			update_option( 'openattribute_linkset', 0 );

		}

		if ( $_POST['openattribute_widgetset'] == 'on' ) {

			update_option( 'openattribute_widgetset', 1 );

		} else {

			update_option( 'openattribute_widgetset', 0 );

		}

		update_option( 'openattribute_pre_license_html', $_POST['openattribute_pre_license_html'] );

		update_option( 'openattribute_post_license_html', $_POST['openattribute_post_license_html'] );

		if ( $_POST['openattribute_rdfa'] == 'on' ) {

			update_option( 'openattribute_rdfa', 1 );

		} else {

			update_option( 'openattribute_rdfa', 0 );

		}

		if ( $_POST['openattribute_disable'] == 'on' ) {

			update_option( 'openattribute_disable', 1 );

		} else {

			update_option( 'openattribute_disable', 0 );

		}

		if ( $_POST['openattribute_append_content'] == 'on' ) {

			update_option( 'openattribute_append_content', 1 );

		} else {

			update_option( 'openattribute_append_content', 0 );

		}

		if ( $_POST['openattribute_append_footer'] == 'on' ) {

			update_option( 'openattribute_append_footer', 1 );

		} else {

			update_option( 'openattribute_append_footer', 0 );

		}

		if ( $_POST['oa_author'] != '' ) {

			update_option( 'openattribute_site_author', $_POST['oa_author'] );

		} else {

			update_option( 'openattribute_site_author', get_the_author_meta( 'display_name', $_POST['user'] ) );

		}

		if ( $_POST['openattribute_authoroverride'] != '' ) {

			update_option( 'openattribute_authoroverride', 1 );

		} else {

			update_option( 'openattribute_authoroverride', 0 );

		}

		if ( $_POST['openattribute_index'] != '' ) {

			update_option( 'openattribute_index', 1 );

		} else {

			update_option( 'openattribute_index', 0 );

		}

		if ( $_POST['openattribute_indexsingle'] != '' ) {

			update_option( 'openattribute_indexsingle', 1 );

		} else {

			update_option( 'openattribute_indexsingle', 0 );

		}

		if ( $_POST['openattribute_altlink'] != '' ) {

			update_option( 'openattribute_altlink', $_POST['openattribute_altlink'] );

		} else {

			update_option( 'openattribute_altlink', $_POST['openattribute_altlink'] );

		}

		if ( $_POST['openattribute_postsonly'] != '' ) {

			update_option( 'openattribute_postsonly', 1 );

		} else {

			update_option( 'openattribute_postsonly', 0 );

		}

		update_option( 'openattribute_site_license', $_POST['openattribute_license_for_site'] );
		update_option( 'openattribute_site_attribution_url', $_POST['oa_url'] );

	}

}

function openattribute_menu_option() {
	add_options_page( 'OpenAttribute Options', 'OpenAttribute Options', 'manage_options', 'openattribute', 'openattribute_options_page' );
}

function openattribute_save_post( $post_id ) {

	if ( ! wp_verify_nonce( $_POST['openattribute_noncename'], plugin_basename( __FILE__ ) ) ) {
		  return $post_id;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		  return $post_id;
	}

	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
	}

	if ( isset( $_POST['disable_license'] ) && 'on' === $_POST['disable_license'] ) {
		  update_post_meta( $post_id, 'disable_license', 'on' );
	} else {
		  update_post_meta( $post_id, 'disable_license', 'off' );
	}
}

function openattribute_disable_menu() {
	wp_nonce_field( plugin_basename( __FILE__ ), 'openattribute_noncename' );

	$disable_license = get_post_meta( $_GET['post'], 'disable_license', true );

	if ( 'on' === $disable_license ) {
		$checked = 'checked';
	} else {
		$checked = '';
	}

	if ( ( 1 == get_option( 'openattribute_disable' ) ) || ( 'on' === $disable_license ) ) {
		echo "To disable attribution for this post please tick this box <input type=\"checkbox\" name=\"disable_license\" $checked />";
	}
}

function openattribute_add_disable_menu( $output ) {
	if ( get_option( 'openattribute_disable' ) == 1 ) {
		add_meta_box( 'openattribute_id', 'OpenAttribute', 'openattribute_disable_menu', 'post', 'normal', 'high' );
	}

	$disable_license = get_post_meta( $_GET['post'], 'disable_license', true );

	if ( 'on' === $disable_license ) {
		add_meta_box( 'openattribute_id', 'OpenAttribute', 'openattribute_disable_menu', 'post', 'normal', 'high' );
	}
}

function openattribute_add_license_content( $output ) {
	global $wp_query, $post;
	global $wp_query,$post;

	$indexposts  = get_option( 'openattribute_index' );
	$indexsingle = get_option( 'openattribute_indexsingle' );
	$postsonly   = get_option( 'openattribute_postsonly' );

    $site_license_url = '';

	$display_first = false;

	if ( is_home() && $indexposts ) {
		if ( is_single() ) {
			$display_first = true;
		} elseif ( $indexsingle ) {
			$display_first = true;
		}
	} elseif ( is_page() && $postsonly ) {
		$display_first = true;
	} elseif ( is_single() ) {
		$display_first = true;
	}

	if ( $display_first ) {
		if ( get_option( 'openattribute_append_content' ) == 1 ) {
			$disable = get_post_meta( $wp_query->posts[0]->ID, 'disable_license' );

			if ( $disable[0] == 'off' || $disable[0] == '' ) {
				$display = true;

				if ( get_option( 'openattribute_blogoverride' ) == 1 ) {
					$author      = explode( 'oaauthor', $output );
					$title       = explode( 'oatitle', $output );
					$oashorthand = explode( 'oalicense', $output );

					if ( count( $author ) != 1 ) {
						$display = false;
					}

					if ( count( $title ) != 1 ) {
						$display = false;
					}

					if ( count( $oashorthand ) != 1 ) {
						$display = false;
					}
				}

				if ( $display_first ) {
					$author               = get_option( 'openattribute_site_author' );
					$site_license         = get_option( 'openattribute_site_license' );
					$site_attribution_url = get_option( 'openattribute_site_attribution_url' );
					$licenses             = get_option( 'openattribute_licenses' );

					if ( get_option( 'openattribute_authoroverride' ) == 1 ) {
						$author               = get_the_author_meta( 'display_name' );
						$site_attribution_url = get_the_author_meta( 'user_url' );
					}

					$data_licenses = explode( "\n", $licenses );

					while ( $license = array_shift( $data_licenses ) ) {
						$pair = explode( ',', $license );

						if ( trim( $pair[1] ) == trim( $site_license ) ) {
							$site_license_url = $pair[0];
						}
					}

					$license_data = stripslashes( get_option( 'openattribute_pre_license_html' ) );

					if ( get_option( 'openattribute_buttonset' ) == 1 ) {
						$license_data .= '<div onclick="attribute_button(event)" class="open_attribute_button">';

						if ( get_option( 'openattribute_altlink' ) != '' ) {
							$license_data .= '<img src="' . get_option( 'openattribute_altlink' ) . '" />';
						} else {
							$license_data .= '<img src="' . WP_PLUGIN_URL . '/openattribute/attrib_button.png" />';
						}

						$license_data .= '</DIV>';
					}

					$license_data .= '<span xmlns:dct="http://purl.org/dc/terms/" property="dct:title"><a href="' . $post->guid . '">' . the_title( '', '', 0 ) . '</a> / <a href="' . home_url() . '">' . get_bloginfo( 'name' ) . '</a></span>';
					$license_data .= ' by <a xmlns:cc="http://creativecommons.org/ns#" href="' . $site_attribution_url . '" property="cc:attributionName" rel="cc:attributionURL" >' . $author . '</a>';
					$license_data .= ' is licensed under a <a rel="license" href="' . $site_license_url . '">' . $site_license . '</a>';
					$license_data .= get_option( 'openattribute_post_license_html' );

					$output .= $license_data;
				}
			}
		}
	}

	return $output;

}

function openattribute_add_license_footer( $content ) {

	global $wp_query,$post;

	$indexposts  = get_option( 'openattribute_index' );
	$indexsingle = get_option( 'openattribute_indexsingle' );
	$postsonly   = get_option( 'openattribute_postsonly' );

	$display_first = false;

	if ( is_home() && $indexposts ) {

		if ( is_single() ) {

			$display_first = true;

		} elseif ( $indexsingle ) {

			$display_first = true;

		}
	} elseif ( is_page() && $postsonly ) {

		$display_first = true;

	} elseif ( is_single() ) {

		$display_first = true;

	}

	if ( $display_first ) {

		if ( get_option( 'openattribute_append_footer' ) == 1 ) {

			$disable = get_post_meta( $wp_query->posts[0]->ID, 'disable_license' );

			if ( $disable[0] == 'off' || $disable[0] == '' ) {

				$display = true;

				if ( get_option( 'openattribute_blogoverride' ) == 1 ) {

					$content = $wp_query->posts[0]->post_content;

					$author      = explode( 'oaauthor', $content );
					$title       = explode( 'oatitle', $content );
					$oashorthand = explode( 'oashorthand', $content );

					if ( count( $author ) != 1 ) {

						$display = false;

					}

					if ( count( $title ) != 1 ) {

						$display = false;

					}

					if ( count( $oashorthand ) != 1 ) {

						$display = false;

					}
				}

				if ( $display ) {

					get_option( 'openattribute_buttonset' );
					$author               = get_option( 'openattribute_site_author' );
					$site_license         = get_option( 'openattribute_site_license' );
					$site_attribution_url = get_option( 'openattribute_site_attribution_url' );
					$licenses             = get_option( 'openattribute_licenses' );

					if ( get_option( 'openattribute_authoroverride' ) == 1 ) {

						$author               = get_the_author_meta( 'display_name' );
						$site_attribution_url = get_the_author_meta( 'user_url' );

					}

					$data_licenses = explode( "\n", $licenses );

					while ( $license = array_shift( $data_licenses ) ) {

						$pair = explode( ',', $license );

						if ( trim( $pair[1] ) == trim( $site_license ) ) {

							$site_license_url = $pair[0];

						}
					}

					if ( $display_first ) {

						$license_data .= stripslashes( get_option( 'openattribute_pre_license_html' ) );

						if ( get_option( 'openattribute_buttonset' ) == 1 ) {

							$license_data .= '<div onclick="attribute_button(event)" class="open_attribute_button">';

							if ( get_option( 'openattribute_altlink' ) != '' ) {
								$license_data .= '<img src="' . get_option( 'openattribute_altlink' ) . '" />';
							} else {
								$license_data .= '<img src="' . WP_PLUGIN_URL . '/openattribute/attrib_button.png" />';
							}
							$license_data .= '</DIV>';

						}

						$license_data .= '<span xmlns:dct="http://purl.org/dc/terms/" property="dct:title"><a href="' . $post->guid . '">' . the_title( '', '', 0 ) . '</a> / <a href="' . home_url() . '">' . get_bloginfo( 'name' ) . '</a></span>';
						$license_data .= ' by <a xmlns:cc="http://creativecommons.org/ns#" href="' . $site_attribution_url . '" property="cc:attributionName" rel="cc:attributionURL" >' . $author . '</a>';
						$license_data .= ' is licensed under a <a rel="license" href="' . $site_license_url . '">' . $site_license . '</a>';
						$license_data .= get_option( 'openattribute_post_license_html' );

						$output .= $license_data;

						echo $output;

					}
				}
			}
		}
	}

}

function openattribute_add_license_header() {
	global $post;

	$disable = null;

	$indexposts  = get_option( 'openattribute_index' );
	$indexsingle = get_option( 'openattribute_indexsingle' );
	$postsonly   = get_option( 'openattribute_postsonly' );

	$display_first = false;

	if ( is_home() && $indexposts ) {
		if ( is_single() ) {
			$display_first = true;
		} elseif ( $indexsingle ) {
			$display_first = true;
		}
	} elseif ( is_page() && $postsonly ) {
		$display_first = true;
	} elseif ( is_single() ) {
		$display_first = true;
	}

	if ( $display_first ) {
		if ( ( get_option( 'openattribute_append_footer' ) == 1 ) || ( get_option( 'openattribute_append_content' ) == 1 ) || ( get_option( 'openattribute_widgetset' ) == 1 ) ) {
			if ( isset( $_GET['page_id'] ) ) {
				$disable = get_post_meta( $_GET['page_id'], 'disable_license' );
			}

			if ( $disable[0] == 'off' || $disable[0] == '' ) {
				$display = true;

				if ( $display ) {
					if ( ( get_option( 'openattribute_buttonset' ) == 1 ) || ( get_option( 'openattribute_linkset' ) == 1 ) || ( get_option( 'openattribute_widgetset' ) == 1 ) ) {
						$author               = get_option( 'openattribute_site_author' );
						$site_license         = get_option( 'openattribute_site_license' );
						$site_attribution_url = get_option( 'openattribute_site_attribution_url' );
						$licenses             = get_option( 'openattribute_licenses' );

						$data_licenses = explode( "\n", $licenses );

						while ( $license = array_shift( $data_licenses ) ) {
							$pair = explode( ',', $license );

							if ( trim( $pair[1] ) == trim( $site_license ) ) {
								$site_license_url = $pair[0];
							}
						}

						if ( $display_first ) {
							echo '<script type="text/javascript"> function attribute_button(event){ ';
							echo ' document.getElementById("openattribute_license_holder").style.position = "absolute";';
							echo ' if(document.documentElement.scrollTop!=0){';
							echo ' 		scroll_top = document.documentElement.scrollTop;';
							echo ' }else{';
							echo ' 		scroll_top = window.pageYOffset;';
							echo ' }';
							echo ' document.getElementById("openattribute_license_holder").style.top = (event.clientY/2) + "px";';

							echo ' document.getElementById("openattribute_license_holder").style.left = ((document.documentElement.clientWidth/2)-350) + "px";';
							echo ' document.getElementById("openattribute_license_holder").style.zIndex = 2;';
							echo ' document.getElementById("openattribute_license_holder").style.display = "block";';
							echo ' }</script>';

							if ( ! isset( $site_attribution_url ) ) {
								$site_attribution_url = site_url();
							}

							if ( ! isset( $site_license_url ) ) {
								$site_license_url = $site_license;
							}

							$license_data  = '<div id="openattribute_license_holder" style="float:left; border:3px solid #1F3350; width:850px; padding:20px; display:none;"><div style="float:left; position:relative;"><img src="' . WP_PLUGIN_URL . '/' . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) . 'openAttrLogo.jpg" /><p style="margin:0px; padding:0px">HTML Text<br><textarea rows="5" cols="80" style="margin:0px; padding:0px;"><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title"><a href="' . $post->guid . '">' . the_title( '', '', 0 ) . '</a> / <a href="' . home_url() . '">' . get_bloginfo( 'name' ) . '</a></span>';
							$license_data .= ' by <a xmlns:cc="http://creativecommons.org/ns#" href="' . $site_attribution_url . '" property="cc:attributionName" rel="cc:attributionURL" >' . $author . '</a>';
							$license_data .= ' is licensed under a <a rel="license" href="' . $site_license_url . '">' . $site_license . '</a></textarea></p>';

							$license_data .= '<p style="margin:0px; padding:0px">Plain text<br /><textarea rows="5" cols="80" style="float:left; position:relative; clear:left; left:0px;">' . the_title( '', '', 0 ) . ' by ' . $author;

							if ( $site_attribution_url != '' ) {
								$license_data .= ' @ ' . $site_attribution_url;
							}

							$license_data .= ' is licensed under a <a rel="license" href="' . $site_license_url . '">' . $site_license . '</a></textarea></p><p style="text-decoration:underline;cursor:hand;cursor:pointer; margin:0px; padding:0px;" onclick="this.parentNode.parentNode.style.display=\'none\';">Close</p></div></div>';

							echo $license_data;
						}
					}
				}
			}
		}
	}
}

function openattribute_rdf_ns() {

	if ( get_option( 'openattribute_site_license' ) != '' ) {

		echo 'xmlns:cc="http://creativecommons.org/ns#" ';

	}

}

function openattribute_rdf_head() {

	if ( get_option( 'openattribute_site_license' ) != '' ) {

		echo '<cc:license rdf:resource="' . get_option( 'openattribute_site_license' ) . '" />';

	}
}

function openattribute_rss2_head() {

	if ( get_option( 'openattribute_site_license' ) != '' ) {

		echo '<cc:license ';

		if ( $_GET['feed'] == 'rss' ) {

			echo ' xmlns:cc="http://creativecommons.org/ns#" ';

		}

		echo '>' . get_option( 'openattribute_site_license' ) . '</cc:license>';
		echo '<dc:rights ';

		if ( $_GET['feed'] == 'rss' ) {

			echo ' xmlns:dc="http://purl.org/dc/elements/1.1/" ';

		}

		echo ' >' . get_option( 'openattribute_site_license' ) . '</dc:rights>';

	}

}

function openattribute_atom_head() {

	if ( get_option( 'openattribute_site_license' ) != '' ) {

		echo '<link rel="license" type="text/html" href="' . get_option( 'openattribute_site_license' ) . '" />';

	}

}

function openattribute_augment_feed( $content ) {

	if ( get_option( 'openattribute_site_license' ) != '' ) {

		if ( get_option( 'openattribute_blogoverride' ) == 0 ) {

			echo '<cc:license>' . get_option( 'openattribute_site_license' ) . '</cc:license>';
			echo '<dc:rights>' . get_option( 'openattribute_site_license' ) . '</dc:rights>';

		} else {

			$display = true;

			$content = $wp_query->post->post_content;

			if ( get_option( 'openattribute_blogoverride' ) == 1 ) {

				$author      = explode( 'oaauthor', $content );
				$title       = explode( 'oatitle', $content );
				$oashorthand = explode( 'oashorthand', $content );

				if ( count( $author ) != 1 ) {

					$display = false;

				}

				if ( count( $title ) != 1 ) {

					$display = false;

				}

				if ( count( $oashorthand ) != 1 ) {

					$display = false;

				}

				if ( $display ) {

					$data = explode( 'oalicenseurl="', $content );

					if ( count( $data ) != 1 ) {

						$license = explode( '"', $data[0] );

						echo '<creativeCommons:license>' . $license[0] . '</creativeCommons:license>';
						echo '<dc:rights>' . $license[0] . '</dc:rights>';

					}
				}
			}
		}
	} else {

		$content = $wp_query->post->post_content;
		$display = true;

		$author      = explode( 'oaauthor', $content );
		$title       = explode( 'oatitle', $content );
		$oashorthand = explode( 'oashorthand', $content );

		if ( count( $author ) != 1 ) {

			$display = false;

		}

		if ( count( $title ) != 1 ) {

			$display = false;

		}

		if ( count( $oashorthand ) != 1 ) {

			$display = false;

		}

		if ( $display ) {

			$data = explode( 'oalicenseurl="', $content );

			if ( count( $data ) != 1 ) {

				$license = explode( '"', $data[0] );

				echo '<creativeCommons:license>' . $license[0] . '</creativeCommons:license>';
				echo '<dc:rights>' . $license[0] . '</dc:rights>';

			}
		}
	}

}

function openattribute_stylesheet() {

	echo '<link rel="stylesheet" href="' . WP_PLUGIN_URL . '/openattribute/' . 'openattribute_popup.css" type="text/css" media="screen,projection" /> ';

}

function openattribute_widget() {
	register_widget( 'Open_Attribute_Widget' );
};

// Modifications to feeds

add_action( 'rss_head', 'openattribute_rss2_head' );
add_action( 'rss2_head', 'openattribute_rss2_head' );
add_action( 'atom_head', 'openattribute_atom_head' );
add_action( 'rss2_ns', 'openattribute_rdf_ns' );
add_action( 'rdf_ns', 'openattribute_rdf_ns' );
add_action( 'rdf_header', 'openattribute_rdf_head' );
add_action( 'atom_entry', 'openattribute_augment_feed' );
add_action( 'rdf_item', 'openattribute_augment_feed' );
add_action( 'rss2_item', 'openattribute_augment_feed' );
add_action( 'rss_item', 'openattribute_augment_feed' );

// Admin options on wp-admin side of things

add_action( 'admin_init', 'openattribute_register' );
add_action( 'admin_menu', 'openattribute_menu_option' );
add_action( 'admin_head', 'openattribute_postform' );
add_action( 'admin_notices', 'openattribute_firstrun' );

// Code for the insert into blog function for non-site licenses.

add_filter( 'media_buttons_context', 'openattribute_button' );
add_filter( 'media_upload_openattribute', 'add_openattribute_action' );

// Code to handle blog specific licensing

add_action( 'add_meta_boxes', 'openattribute_add_disable_menu' );
add_action( 'save_post', 'openattribute_save_post' );

// Code to display site licenses

add_action( 'the_content', 'openattribute_add_license_content' );
add_action( 'get_footer', 'openattribute_add_license_footer' );

//
// The footer attribution may appear neater if you use wp_footer over get_footer
//
// comment out the get footer line above and remove the commenting from the line below to do this
//
//add_action('wp_footer', 'openattribute_add_license_footer');
//

add_action( 'loop_start', 'openattribute_add_license_header' );

// Load pop up for style sheet

add_action( 'wp_head', 'openattribute_stylesheet' );

// Load the Widget code
require 'class-open-attribute-widget.php';

// Widget register
add_action( 'widgets_init', 'openattribute_widget' );
