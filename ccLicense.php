<?php
/****************************************************************************
* Plugin Name: creative commons license widget
* File: ccLicense.php
* Description: Adds a sidebar widget to display creative commons license (Spanish / English)
* Author: Lcflores
* Date: 11/5/2007
* Lenguage: php - widget  for wordpress 2.0 or higer.
* Version: 0.4
* Author URI: http://www.xperimentos.com
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
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_ccLicense', $options);
		}
	?>
				<p style="text-align:left;">
				<label for="ccLicense-title" style="line-height:25px;display:block;"><?php _e('Widget title:', 'widgets'); ?> 
          <input type="text" id="ccLicense-title" name="ccLicense-title" value="<?php echo wp_specialchars($options['title'], true); ?>" />
				<label for="ccLicense-language" style="line-height:25px;display:block;"><?php _e('Widget Language:', 'widgets'); ?> 
          <select id="ccLicense-language" name="ccLicense-lenguage">
            <option><?php echo wp_specialchars($options['language'], true); ?></option>
            <option value="Spanish">Spanish</option>
            <option value="English">English</option>
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
    
		echo $before_widget . $before_title . $title . $after_title;
    if ($language == "Spanish") {
  		?>
        <!--Creative Commons License-->
          <a rel="license" href="http://creativecommons.org/licenses/by/3.0/deed.es_CL">
          <img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.png"/></a>
          <br/>
          Blog bajo licencia <a rel="license" href="http://creativecommons.org/licenses/by/3.0/deed.es_CL">Creative Commons Attribution 3.0 License</a>. 
        <!--/Creative Commons License-->
  		<?php
    }
    else {
      ?>
      <!--Creative Commons License-->
        <a rel="license" href="http://creativecommons.org/licenses/by/3.0/">
        <img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.png"/></a>
        <br/>
        Blog under the <a rel="license" href="http://creativecommons.org/licenses/by/3.0/">Creative Commons Attribution 3.0 License</a>. 
      <!--/Creative Commons License-->
      <?php    
    }
		echo $after_widget;
	}
  
	// Tell Dynamic Sidebar about our new widget and its control
	register_sidebar_widget(array('creativecommons License', 'widgets'), 'widget_ccLicense');
	register_widget_control(array('creativecommons License', 'widgets'), 'widget_ccLicense_control');
}

// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('widgets_init', 'widget_ccLicense_init');
?>
