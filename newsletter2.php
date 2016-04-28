<?php
/*
Plugin Name: GV Newsletter 2
Plugin URI: http://GaneshVeer.com
Description: Allows visitors to subscribe for the website updates.
Version: 0.1
Author: Ganesh Veer
Author URI: http://GaneshVeer.com
*/

//Global
$gv_options = get_option('gv_newsletter_settings');

//holding variable
$gv_title = $gv_options[title];
$gv_display = $gv_options[display];
$gv_privacy = $gv_options[privacy];

//admin tab
add_action('admin_menu', 'gv_newsletter_tab');
function gv_newsletter_tab(){
	add_options_page('gv newsletter', 'GV Newsletter', 'manage_options', 'gv_newsletter', 'gv_newsletter_page');
}
//Admin page
function gv_newsletter_page(){
	global $gv_options;
	ob_start();
?>
	<div class="wrap">
			<h1>GV Newsletter 2</h1>
		<form action="options.php" method="post">
			<?php settings_fields('gvnewsletter-group');?>
			<?php //@do_settings_fields('gvnewsletter-group');?>
			<table class="form-table">
			<tr valign="top">
				<th><label>Title Newsletter</label></th>
				<td><input type="text"  name="gv_newsletter_settings[title]" value="<?php echo $gv_options[title]; ?>" /><br/></td>
			</tr>
			<tr valign="top">
				<th><label>Display Newsletter</label></th>
				<td><input type="checkbox"  name="gv_newsletter_settings[display]" value="<?php echo $gv_options[display]; ?>" /><br/></td>
			</tr>		
<tr valign="top">		
			<th><label>Display Privacy Statement</label></th>
			<td><input type="checkbox"  name="gv_newsletter_settings[privacy]" value="<?php echo $get_options[privacy]; ?>" /><br/></td>
</tr>		
</table>			
		<?php @submit_button(); ?>
		</form>
	</div>
<?php
echo ob_get_clean();
}

//register settings
//Add plugin admin settins
function gv_admin_init(){
	register_setting('gvnewsletter-group', 'gv_newsletter_settings');
}
//register input fields
add_action('admin_init', 'gv_admin_init');


/***
*
* Widget Creations
*
**/

//register widget
add_action('widgets_init', 'gvnewsletter_widget_init');

//initiate widget
function gvnewsletter_widget_init(){
	register_widget(gvnewsletter_Widget);	
}

// Widget Class
class gvnewsletter_Widget extends WP_Widget{
	function gvnewsletter_Widget(){
		$widget_options = array(
			'classname' => 'gvnewsletter_class', //for css
			'description' => 'Add Newsletter Widget'
			);
		
		//id for DOM Element
		$this->WP_Widget('gvnewsletter_id', 'GV Newsletter ', $widget_options);
	}

	//show widget form in appearance -widgets
		function form($instance){
			$instance = wp_parse_args( (array) $instance, $defaults );
			$title = esc_attr($instance['title']);
			echo '<p> Widget Title <input class="widefat" name="'.$this->get_field_name('title').'"  value="'.$instance['title'].'" type="text" /></p>';
			
		}
		//save widget form
		function update($new_instance, $old_instance){
			//process widget options to save
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);	
			return $instance;
		}


		//show show
		function widget($args, $instance){
				global $gv_title;
			extract( $args );
			$title = apply_filters('widget_title', $instance['title'] );
					echo $before_widget;
					echo $before_title.$gv_title.$after_title;
					echo 'You are inside GV Newsletter';
					echo '';
					echo $after_widget;
		}
	}
?>