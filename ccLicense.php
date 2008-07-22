<?php
/****************************************************************************
Plugin Name: creative commons license widget
Contributors: lcflores, Gyo (italian translation, some formatting - http://gyo.ilbello.com)
Donate link: http://www.xperimentos.com/2007/05/11/creative-commons-license-widget-for-wordpress/
Author URI: http://www.xperimentos.com/2007/05/11/creative-commons-license-widget-for-wordpress/
Tags: license, creative commons
Requires at least: 2.0.2
Tested up to: 2.5
Stable tag: 0.6
Version: 0.6
Creation time: 12/5/2007
Last updated: 21/7/2008
Description: Adds a sidebar widget to display creative commons license (supports all 3.0 licenses)
****************************************************************************/

// This gets called at the plugins_loaded action
function widget_ccLicense_init() {
	
	// check for sidebar existance
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	// This saves options and prints the widget's config form.
	function widget_ccLicense_control() {
		$options = $newoptions = get_option('widget_ccLicense');
		if ( $_POST['ccLicense-submit'] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST['ccLicense-title']));
			$newoptions['language'] = strip_tags(stripslashes($_POST['ccLicense-language']));			
			$newoptions['type'] = strip_tags(stripslashes($_POST['ccLicense-type']));	
			$newoptions['image'] = strip_tags(stripslashes($_POST['ccLicense-image']));				
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_ccLicense', $options);
		}
	?>
				<p style="text-align:left;">
					<label for="ccLicense-title" style="line-height:25px;display:block;"><?php _e('Title:', 'widgets'); ?> 
						<input type="text" id="ccLicense-title" name="ccLicense-title" value="<?php echo wp_specialchars($options['title'], true); ?>" />
					</label>
					<label for="ccLicense-language" style="line-height:25px;display:block;"><?php _e('Language:', 'widgets'); ?> 
						<select id="ccLicense-language" name="ccLicense-language">
							<option value="English" <?php if ($options['language']=='English') {echo "selected=\"selected\""; }?> >English</option>						
							<option value="Spanish" <?php if ($options['language']=='Spanish') {echo "selected=\"selected\""; }?> >Spanish</option>
							<option value="Italian" <?php if ($options['language']=='Italian') {echo "selected=\"selected\""; }?> >Italian</option>
						</select>
					</label>
					<label for="ccLicense-type" style="line-height:25px;display:block;"><?php _e('License:', 'widgets'); ?> 
						<select id="ccLicense-type" name="ccLicense-type">
							<option value="Attribution" <?php if ($options['type']=='Attribution') {echo "selected=\"selected\""; }?> >Attribution</option>
							<option value="Attribution-NoDerivs" <?php if ($options['type']=='Attribution-NoDerivs') {echo "selected=\"selected\""; }?> >Attribution-NoDerivs</option>
							<option value="Attribution-NonCommercial-NoDerivs" <?php if ($options['type']=='Attribution-NonCommercial-NoDerivs') {echo "selected=\"selected\""; }?> >Attribution-NonCommercial-NoDerivs</option>
							<option value="Attribution-NonCommercial" <?php if ($options['type']=="Attribution-NonCommercial") {echo "selected=\"selected\""; }?> >Attribution-NonCommercial</option>
							<option value="Attribution-NonCommercial-ShareAlike" <?php if ($options['type']=='Attribution-NonCommercial-ShareAlike') {echo "selected=\"selected\""; }?> >Attribution-NonCommercial-ShareAlike</option>
							<option value="Attribution-ShareAlike" <?php if ($options['type']=='Attribution-ShareAlike') {echo "selected=\"selected\""; }?> >Attribution-ShareAlike</option>					 
						</select>					
					</label>
					<label for="ccLicense-image" style="line-height:25px;display:block;"><?php _e('Image:', 'widgets'); ?> 
						<select id="ccLicense-image" name="ccLicense-image">
							<option value="somerights20" <?php if ($options['image']=='somerights20') {echo "selected=\"selected\""; }?> >somerights20</option>
							<option value="80x15" <?php if ($options['image']=='80x15') {echo "selected=\"selected\""; }?> >80x15</option>
							<option value="88x31" <?php if ($options['image']=='88x31') {echo "selected=\"selected\""; }?> >88x31</option>							
						</select>
					</label>					
				<input type="hidden" name="ccLicense-submit" id="ccLicense-submit" value="1" />				
				</p>
	<?php
	}		
	
		// This prints the widget
	function widget_ccLicense($args) {
		extract($args);
		$options = get_option('widget_ccLicense');
		$title = $options['title'];
		$language = $options['language'];
		$type = $options['type'];
		$image = $options['image'];	
		
		// Creates widget configuration
		$text = '';
		$licenseText = '';
		$imageUrl = '';
		$licenseUrl = '';
		$url = '';
				
		$licenseText = 'Creative Commons ' . $type . ' 3.0 License';
				
		switch ($language) {
			case 'Spanish':
					$text = 'Blog bajo licencia';
					$licenseUrl = 'deed.es_CL';
					break;
			case 'Italian':
					$text = 'Blog sotto licenza';
					$licenseUrl = 'deed.it';
					break;
			case 'English':
					$text = 'Blog under the';
					$licenseUrl = '';
					break;
			default:
					$text = 'Blog under the';
					$licenseUrl = '';
					break;
		}
		
		switch ($type) {
			case 'Attribution':
					$url = 'by';
					break;
			case 'Attribution-NoDerivs':
					$url = 'by-nd';
					break;
			case 'Attribution-NonCommercial-NoDerivs':
					$url = 'by-nc-nd';
					break;
			case 'Attribution-NonCommercial':
					$url = 'by-nc';
					break;
			case 'Attribution-NonCommercial-ShareAlike':
					$url = 'by-nc-sa';
					break;
			case 'Attribution-ShareAlike':
					$url = 'by-sa';
					break;
			default:
					$url = 'by';
					break;
		}
		$licenseUrl = 'http://creativecommons.org/licenses/' . $url . '/3.0/' . $licenseUrl;
		
		switch ($image) {
			case 'somerights20':
					$imageUrl = 'http://creativecommons.org/images/public/somerights20.png';
					break;
			case '80x15':
					$imageUrl = 'http://i.creativecommons.org/l/' . $url . '/3.0/80x15.png';
					break;
			case '88x31':
					$imageUrl = 'http://i.creativecommons.org/l/' . $url . '/3.0/88x31.png';
					break;					
			default:
					$imageUrl = 'http://creativecommons.org/images/public/somerights20.png';
					break;
		}

		// prints the widget.
		echo $before_widget . $before_title . $title . $after_title;
		?>
			<!--Creative Commons License-->
				<div style="text-align: center; font-size: xx-small;">
                                <?php echo $text; ?> 
                                <a rel="license" target="_blank" href="<?php echo $licenseUrl; ?>"> <?php echo $licenseText; ?><br/>
				<img alt="Creative Commons License" border="0" src="<?php echo $imageUrl; ?>"/></a>
				</div>
			<!--/Creative Commons License-->
		<?php	 
			
		echo $after_widget;
	}
	
	// Tell Dynamic Sidebar about our new widget and its control
	register_sidebar_widget(array('creativecommons License', 'widgets'), 'widget_ccLicense');
	register_widget_control(array('creativecommons License', 'widgets'), 'widget_ccLicense_control');
}

// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('widgets_init', 'widget_ccLicense_init');
?>
