<?php
/*
==================================================
//Display functions for outputting information
==================================================
*/
function smbw_add_content($content) {

	global $smbw_options;
	ob_start();
	?>
    <style type="text/css">
<?php if($smbw_options['fblayout'] == 'standard'): ?>  .fb-like span {
overflow:visible !important;
width:450px !important;
margin-right:-200px;
}
 <?php elseif($smbw_options['fblayout'] == 'box_count'): ?>  .fb-like span {
overflow:visible !important;
width:450px !important;
margin-right:-403px;
}
 <?php elseif($smbw_options['fblayout'] == 'button_count'): ?>  .fb-like span {
overflow:visible !important;
width:450px !important;
margin-right:-375px;
}
 <?php elseif($smbw_options['fblayout'] == 'button'): ?>  .fb-like span {
overflow:visible !important;
width:450px !important;
margin-right:-403px;
}
 <?php endif;
?>
</style>
    <?php
	echo ob_get_clean();
	$meta_value = get_post_meta( get_the_ID(), 'meta-checkbox', true );
	if(is_singular(array('post', 'page')) && $smbw_options['enable'] == true && $meta_value == '') {
// Retrieves the stored value from the database
			$extra_content = '<div class="fb-like" data-href="'.get_permalink().'" data-width="400px" data-layout="'.$smbw_options['fblayout'].'" data-action="like" data-show-faces="false" data-share="false"></div>
			
			<a href="'.get_permalink().'" style="height: 20px; width: 75px;" class="twitter-share-button" data-count ="'.$smbw_options['twlayout'].'" data-lang="en"></a>
			
			<div class="g-plusone" data-size="'.$smbw_options['gplus'].'" data-annotation="'.$smbw_options['ganotate'].'"></div>
			
			<a class="pinit_width" href="//www.pinterest.com/pin/create/button/" data-pin-config="'.$smbw_options['pinlayout'].'" data-pin-do="buttonBookmark"  data-pin-color="'.$smbw_options['pincolor'].'" data-pin-height="20"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png" /></a>
			';
			$content .= $extra_content;
		
	}
		return $content;
}
add_filter('the_content', 'smbw_add_content');


// This will be the widget

function smbw_register_widgets()
{
register_widget('smbw_social_media');
register_widget('smbw_facebook');
register_widget( 'smbw_twitter_timeline' );
register_widget( 'smbw_google_badge' );
}

add_action( 'widgets_init', 'smbw_register_widgets' );


/*-------------------------------------------------------------------
Social widget START
--------------------------------------------------------------------*/
if(!class_exists('smbw_social_media'))
{
	class smbw_social_media extends WP_Widget
	{
		function smbw_social_media()
		{
			//Constructor
			$widget_ops = array('classname'  => 'widget social_media','description'=> apply_filters('smbw_social_media_description',__('Add icons and links to your social media accounts. Works in header, footer, main content and sidebar widget areas.', 'smbw_domain')) );
			$this->WP_Widget('social_media', __('SMBW Social Media', 'smbw_domain'), $widget_ops);
		}
		function widget($args, $instance)
		{
			// prints the widget
			extract($args, EXTR_SKIP);
			echo $args['before_widget'];
			echo '<div class="social_media" >';
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$social_description = empty($instance['social_description']) ? '' : apply_filters('widget_title', $instance['social_description']);
			$social_link = empty($instance['social_link']) ? '' : apply_filters('widget_social_link', $instance['social_link']);
			$social_icon = empty($instance['social_icon']) ? '' : apply_filters('widget_social_icon', $instance['social_icon']);
			$social_text = empty($instance['social_text']) ? '' : apply_filters('widget_social_text', $instance['social_text']);
			if(function_exists('smbw_register_string'))
			{
				smbw_register_string(SMBW_DOMAIN,'social_media_title',$title);
				$title              = smbw_t(SMBW_DOMAIN,'social_media_title',$title);
				smbw_register_string(SMBW_DOMAIN,'social_description',$social_description);
				$social_description = smbw_t(SMBW_DOMAIN,'social_description',$social_description);
			}
			if($title != "")
			{
				echo $args['before_title'];
				echo $title;
				echo $args['after_title'];
			}
			if($social_description != ""): ?>
<p class="social_description"> <?php echo stripcslashes($social_description);?> </p>
<?php endif;?>
<div class="social_media">
  <ul class="social_media_list">
    <?php
					for($c = 0; $c < count($social_icon); $c++)
					{
						if(function_exists('smbw_register_string'))
						{
							smbw_register_string(SMBW_DOMAIN,@$social_text[$c],@$social_text[$c]);
							$social_text[$c] = smbw_t(SMBW_DOMAIN,@$social_text[$c],@$social_text[$c]);
						}
						?>
    <li> <a href="<?php echo @$social_link[$c]; ?>" target="_blank" >
      <?php
								if( @$social_icon[$c] != ''):?>
      <span class="social_icon"> <img src="<?php echo @$social_icon[$c];?>" alt="<?php echo sprintf(__('%s',SMBW_DOMAIN), @$social_text[$c]);?>" /> </span>
      <?php endif;?>
      <?php echo (isset($social_text[$c]))? sprintf(__('%s',SMBW_DOMAIN), @$social_text[$c]):'';?> </a> </li>
    <?php
					}
					?>
  </ul>
</div>
<?php
			echo '</div>';
			echo $args['after_widget'];
		}
		function update($new_instance, $old_instance)
		{
			//save the widget
			return $new_instance;
		}
		function form($instance)
		{
			//widgetform in backend
			$instance = wp_parse_args((array) $instance, array('title' => 'Connect To Us','social_description'=> 'Find Us On Social Sites','social_link'=> '','social_text'=>''));
			$title              = strip_tags($instance['title']);
			$social_description = strip_tags($instance['social_description']);
			$social_link1       = ($instance['social_link']);
			$social_icon1       = ($instance['social_icon']);
			$social_text1       = ($instance['social_text']);
			global $social_link,$social_icon,$social_text;
			$text_social_link = $this->get_field_name('social_link');
			$text_social_icon = $this->get_field_name('social_icon');
			$text_social_text = $this->get_field_name('social_text');
			?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"> <?php echo __('Title', 'smbw_domain');?> :
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('social_description'); ?>"> <?php echo __('Description', 'smbw_domain');?> :
    <input class="widefat" id="<?php echo $this->get_field_id('social_description'); ?>" name="<?php echo $this->get_field_name('social_description'); ?>" type="text" value="<?php echo esc_attr($social_description); ?>" />
  </label>
</p>
<p> <i> Please enter full URL to your profiles. </i> </p>
<p>
  <label for="<?php echo $this->get_field_id('social_link'); ?>"> <?php echo __('Social Link', 'smbw_domain');?> :
    <input class="widefat" id="<?php echo $this->get_field_id('social_link'); ?>" name="<?php echo $text_social_link; ?>[]" type="text" value="<?php echo esc_attr( @$social_link1[0]); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('social_icon'); ?>"> <?php echo __('Social Icon', 'smbw_domain');?> :
    <input class="widefat" id="<?php echo $this->get_field_id('social_icon'); ?>" name="<?php echo $text_social_icon; ?>[]" type="text" value="<?php echo esc_attr( @$social_icon1[0]); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('social_text1'); ?>"> <?php echo __('Social Text', 'smbw_domain');?> :
    <input class="widefat" id="<?php echo $this->get_field_id('social_text1'); ?>" name="<?php echo $text_social_text; ?>[]" type="text" value="<?php echo esc_attr( @$social_text1[0]); ?>" />
  </label>
</p>
<div id="social_tGroup" class="social_tGroup">
  <?php
				for($i = 1;$i < count($social_link1);$i++)
				{
					if($social_link1[$i] != "")
					{
						$j = $i + 1;
						echo '<div  class="SocialTextDiv'.$j.'">';
						echo '<p>';
						echo '<label>Social Link '.$j;
						echo '<input class="widefat" name="'.$text_social_link.'[]" type="text" value="'.esc_attr($social_link1[$i]).'" />';
						echo '</label>';
						echo '</p>';
						echo '<p>';
						echo '<label>Social Icon '.$j;
						echo ' <input type="text" class="widefat"  name="'.$text_social_icon.'[]" value="'.esc_attr($social_icon1[$i]).'">';
						echo '</label>';
						echo '</p>';
						echo '<p>';
						echo '<label>Social Text '.$j;
						echo ' <input type="text" class="widefat"  name="'.$text_social_text.'[]" value="'.esc_attr($social_text1[$i]).'">';
						echo '</label>';
						echo '</p>';
						echo '</div>';
					}
				}
				
				?>
</div>
<script type="text/javascript">
	var social_counter = <?php echo $j+1;?>;
	</script> 
<a
				href="javascript:void(0);" id="addtButton" class="addButton" onclick="social_add_tfields('<?php echo $text_social_link; ?>','<?php echo $text_social_icon; ?>','<?php echo $text_social_text; ?>');"> + Add more </a> &nbsp; | &nbsp; <a
				href="javascript:void(0);" id="removetButton" class="removeButton" onclick="social_remove_tfields();">- Remove </a>
<?php
		}
	}
	add_action('admin_head','smbw_add_script_addnew_1');
	if(!function_exists('smbw_add_script_addnew_1'))
	{
		function smbw_add_script_addnew_1()
		{
			global $social_link,$social_icon,$social_text;
			?>
<script type="application/javascript">
		function social_add_tfields(name,ilname,sname)
		{
			var SocialTextDiv = jQuery(document.createElement('div')).attr("class", 'SocialTextDiv' + social_counter);
			SocialTextDiv.html('<p><label>Social Link '+ social_counter+': </label>'+'<input type="text" class="widefat" name="'+name+'[]" id="textbox' + social_counter + '" value="" /></p>');
			SocialTextDiv.append('<p><label>Social Icon '+ social_counter+': </label>'+'<input type="text" class="widefat" name="'+ilname+'[]" id="textbox' + social_counter + '" value="" ></p>');
			SocialTextDiv.append('<p><label>Social Text '+ social_counter+': </label>'+'<input type="text" class="widefat" name="'+sname+'[]" id="textbox' + social_counter + '" value="" ></p>');
			SocialTextDiv.appendTo(".social_tGroup");
			social_counter++;
		}
		function social_remove_tfields()
		{
			if(social_counter-1==1)
			{
				alert("you need one textbox required.");
				return false;
			}
			social_counter--;
			jQuery(".SocialTextDiv" + social_counter).remove();
		}
		</script>
<?php
		}
	}
}


/*-------------------------------------------------------------------
Create the SMBW facebook post widget
--------------------------------------------------------------------*/
	
class smbw_facebook extends WP_Widget {
	function smbw_facebook() {
		//Constructor
		$widget_ops = array('classname' => 'widget smbw_facebook_fans', 'description' => __('Display a like box for your Facebook page. Works best in sidebar areas.', 'smbw_domain') );
		$this->WP_Widget('smbw_facebook', __('SMBW Facebook Like Box', 'smbw_domain'), $widget_ops);
	}
	
	function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			echo $before_widget;
			$facebook_page_url = empty($instance['facebook_page_url']) ? 'https://www.facebook.com/lafline' : apply_filters('widget_facebook_page_url', $instance['facebook_page_url']);
			$width = empty($instance['width']) ? 300 : apply_filters('widget_width', $instance['width']);
			$show_faces = empty($instance['show_faces']) ? 0 : apply_filters('widget_show_faces', $instance['show_faces']);
			$show_stream = empty($instance['show_stream']) ? 0 : apply_filters('widget_show_stream', $instance['show_stream']);
			$show_header = empty($instance['show_header']) ? 0 : apply_filters('widget_show_header', $instance['show_header']);
			
			$face=($show_faces == 1)? 'true':'false';
			$stream=($show_stream == 1)? 'true':'false';
			$header=($show_header == 1)? 'true':'false';
			
			?>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<fb:like-box href="<?php echo $facebook_page_url; ?>" width="<?php echo $width; ?>" show_faces="<?php echo $face; ?>" border_color="" stream="<?php echo $stream; ?>" header="<?php echo $header; ?>"></fb:like-box>
<?php
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		//save the widget		
		return $new_instance;
	}
	function form($instance) {
		//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array('width'=>300, 'facebook_page_url'=>'https://www.facebook.com/lafline', 'show_faces'=>1, 'show_stream'=>1, 'show_header'=>1 ) );
			$facebook_page_url = strip_tags($instance['facebook_page_url']);
			$width = strip_tags($instance['width']);
			$show_faces = strip_tags($instance['show_faces']);
			$show_stream = strip_tags($instance['show_stream']);
			$show_header = strip_tags($instance['show_header']);
			
	?>
<script type="text/javascript">
	function show_facebook_header(str,id){
		var value=jQuery('#'+id).val();		
		if(str.value==1 || value==1){			
			 jQuery('p#facebook_show_header').fadeIn('slow');
		}else{
			jQuery('p#facebook_show_header').fadeOut("slow");
		}
	}
	</script>
<p>
  <label for="<?php echo $this->get_field_id('facebook_page_url'); ?>">
    <?php  echo __('Facebook Page Full URL', 'smbw_domain')?>
    :
    <input class="widefat" id="<?php echo $this->get_field_id('facebook_page_url'); ?>" name="<?php echo $this->get_field_name('facebook_page_url'); ?>" type="text" value="<?php echo esc_attr($facebook_page_url); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('width'); ?>">
    <?php  echo __('Width', 'smbw_domain')?>
    :
    <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($width); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('show_faces'); ?>">
    <?php  echo __('Show Faces', 'smbw_domain')?>
    :
    <select id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" style="width:50%;" onchange="show_facebook_header(this,'<?php echo $this->get_field_id('show_stream'); ?>');">
      <option value="1" <?php if(esc_attr($show_faces)=='1'){ echo 'selected="selected"';}?>> <?php echo __('Yes', 'smbw_domain'); ?> </option>
      <option value="0" <?php if(esc_attr($show_faces)=='0'){ echo 'selected="selected"';}?>> <?php echo __('No', 'smbw_domain'); ?> </option>
    </select>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('show_stream'); ?>">
    <?php  echo __('Show Stream', 'smbw_domain')?>
    :
    <select id="<?php echo $this->get_field_id('show_stream'); ?>" name="<?php echo $this->get_field_name('show_stream'); ?>" style="width:50%;" onchange="show_facebook_header(this,'<?php echo $this->get_field_id('show_faces'); ?>');">
      <option value="1" <?php if(esc_attr($show_stream)=='1'){ echo 'selected="selected"';}?>> <?php echo __('Yes', 'smbw_domain'); ?> </option>
      <option value="0" <?php if(esc_attr($show_stream)=='0'){ echo 'selected="selected"';}?>> <?php echo __('No', 'smbw_domain'); ?> </option>
    </select>
  </label>
</p>
<p id="facebook_show_header" <?php if(esc_attr($show_stream)=='1' || esc_attr($show_faces)=='1'){echo "style='display:block;'";}else{echo "style='display:none;'";}?>>
  <label for="<?php echo $this->get_field_id('show_header'); ?>">
    <?php  echo __('Show Header', 'smbw_domain')?>
    :
    <select id="<?php echo $this->get_field_id('show_header'); ?>" name="<?php echo $this->get_field_name('show_header'); ?>" style="width:50%;">
      <option value="1" <?php if(esc_attr($show_header)=='1'){ echo 'selected="selected"';}?>> <?php echo __('Yes', 'smbw_domain'); ?> </option>
      <option value="0" <?php if(esc_attr($show_header)=='0'){ echo 'selected="selected"';}?>> <?php echo __('No', 'smbw_domain'); ?> </option>
    </select>
  </label>
</p>
<?php
	}
	
}

/*-------------------------------------------------------------------
Create the SMBW Twitter post widget
--------------------------------------------------------------------*/

class smbw_twitter_timeline extends WP_Widget {
	/**
	* Register widget with WordPress.
	*/
	public function __construct() {
		parent::__construct(
			'twitter_timeline',
			apply_filters( 'smbw_widget_name', esc_html__( 'SMBW Twitter Feed ', 'smbw_domain' ) ),
			array(
				'classname' => 'widget_twitter_timeline',
				'description' => __( 'Display an official Twitter Embedded Timeline widget.', 'smbw_domain' )
			)
		);

		if ( is_active_widget( false, false, $this->id_base ) || is_active_widget( false, false, 'monster' ) ) {
			wp_enqueue_script( 'twitter-widgets', '//platform.twitter.com/widgets.js', '', '', true );
		}
	}

	public function widget( $args, $instance ) {
		$instance['lang']  = substr( strtoupper( get_locale() ), 0, 2 );

		echo $args['before_widget'];

		if ( $instance['title'] )
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];

		$data_attribs = array( 'widget-id', 'theme', 'link-color', 'border-color', 'chrome', 'tweet-limit' );
		$attribs      = array( 'width', 'height', 'lang' );

		// Start tag output
		echo '<a class="twitter-timeline"';

		foreach ( $data_attribs as $att ) {
			if ( !empty( $instance[$att] ) ) {
				if ( 'tweet-limit' == $att && 0 === $instance[$att] )
					continue;

				if ( is_array( $instance[$att] ) )
					echo ' data-' . esc_attr( $att ) . '="' . esc_attr( join( ' ', $instance['chrome'] ) ) . '"';
				else
					echo ' data-' . esc_attr( $att ) . '="' . esc_attr( $instance[$att] ) . '"';
			}
		}

		foreach ( $attribs as $att ) {
			if ( !empty( $instance[$att] ) )
				echo ' ' . esc_attr( $att ) . '="' . esc_attr( $instance[$att] ) . '"';
		}

		echo '>' . esc_html__( 'Tweets', 'smbw_domain' ) . '</a>';
		// End tag output

		echo $args['after_widget'];

		do_action( 'smbw_bump_stats_extras', 'widget', 'twitter_timeline' );
	}


	public function update( $new_instance, $old_instance ) {
		$non_hex_regex             = '/[^a-f0-9]/';
		$instance                  = array();
		$instance['title']         = sanitize_text_field( $new_instance['title'] );
		$instance['width']         = (int) $new_instance['width'];
		$instance['height']        = (int) $new_instance['height'];
		$instance['width']         = ( 0 !== (int) $new_instance['width'] )  ? (int) $new_instance['width']  : 225;
		$instance['height']        = ( 0 !== (int) $new_instance['height'] ) ? (int) $new_instance['height'] : 400;
		$instance['tweet-limit']   = ( 0 !== (int) $new_instance['tweet-limit'] ) ? (int) $new_instance['tweet-limit'] : null;

		// If they entered something that might be a full URL, try to parse it out
		if ( is_string( $new_instance['widget-id'] ) ) {
			if ( preg_match( '#https?://twitter\.com/settings/widgets/(\d+)#s', $new_instance['widget-id'], $matches ) ) {
				$new_instance['widget-id'] = $matches[1];
			}
		}

		$instance['widget-id'] = sanitize_text_field( $new_instance['widget-id'] );
		$instance['widget-id'] = is_numeric( $instance['widget-id'] ) ? $instance['widget-id'] : '';

		foreach ( array( 'link-color', 'border-color' ) as $color ) {
			$clean = preg_replace( $non_hex_regex, '', sanitize_text_field( $new_instance[$color] ) );
			if ( $clean )
				$instance[$color] = '#' . $clean;
		}

		$instance['theme'] = 'light';
		if ( in_array( $new_instance['theme'], array( 'light', 'dark' ) ) )
			$instance['theme'] = $new_instance['theme'];

		$instance['chrome'] = array();
		if ( isset( $new_instance['chrome'] ) ) {
			foreach ( $new_instance['chrome'] as $chrome ) {
				if ( in_array( $chrome, array( 'noheader', 'nofooter', 'noborders', 'noscrollbar', 'transparent' ) ) ) {
					$instance['chrome'][] = $chrome;
				}
			}
		}

		return $instance;
	}


	public function form( $instance ) {
		$defaults = array(
			'title'        => esc_html__( 'Follow me on Twitter', 'smbw_domain' ),
			'width'        => '',
			'height'       => '400',
			'widget-id'    => '',
			'link-color'   => '#f96e5b',
			'border-color' => '#e8e8e8',
			'theme'        => 'light',
			'chrome'       => array(),
			'tweet-limit'  => null,
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>">
    <?php esc_html_e( 'Title:', 'smbw_domain' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'width' ); ?>">
    <?php esc_html_e( 'Width (px):', 'smbw_domain' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $instance['width'] ); ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'height' ); ?>">
    <?php esc_html_e( 'Height (px):', 'smbw_domain' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo esc_attr( $instance['height'] ); ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'tweet-limit' ); ?>">
    <?php esc_html_e( '# of Tweets Shown:', 'smbw_domain' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'tweet-limit' ); ?>" name="<?php echo $this->get_field_name( 'tweet-limit' ); ?>" type="number" min="1" max="20" value="<?php echo esc_attr( $instance['tweet-limit'] ); ?>" />
</p>
<p><small>
  <?php
			echo wp_kses_post(
				sprintf(
					__( 'You need to <a href="%1$s" target="_blank">create a widget at Twitter.com</a>, and then enter your widget id (the long number found in the URL of your widget\'s config page) in the field below. <a href="%2$s" target="_blank">Read more</a>.', 'smbw_domain' ),
					'https://twitter.com/settings/widgets/new/user',
					'http://support.wordpress.com/widgets/twitter-timeline-widget/'
				)
			);
			?>
  </small></p>
<p>
  <label for="<?php echo $this->get_field_id( 'widget-id' ); ?>">
    <?php esc_html_e( 'Widget ID:', 'smbw_domain' ); ?>
    <a href="http://support.wordpress.com/widgets/twitter-timeline-widget/#widget-id" target="_blank">( ? )</a></label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'widget-id' ); ?>" name="<?php echo $this->get_field_name( 'widget-id' ); ?>" type="text" value="<?php echo esc_attr( $instance['widget-id'] ); ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'chrome-noheader' ); ?>">
    <?php esc_html_e( 'Layout Options:', 'smbw_domain' ); ?>
  </label>
  <br />
  <input type="checkbox"<?php checked( in_array( 'noheader', $instance['chrome'] ) ); ?> id="<?php echo $this->get_field_id( 'chrome-noheader' ); ?>" name="<?php echo $this->get_field_name( 'chrome' ); ?>[]" value="noheader" />
  <label for="<?php echo $this->get_field_id( 'chrome-noheader' ); ?>">
    <?php esc_html_e( 'No Header', 'smbw_domain' ); ?>
  </label>
  <br />
  <input type="checkbox"<?php checked( in_array( 'nofooter', $instance['chrome'] ) ); ?> id="<?php echo $this->get_field_id( 'chrome-nofooter' ); ?>" name="<?php echo $this->get_field_name( 'chrome' ); ?>[]" value="nofooter" />
  <label for="<?php echo $this->get_field_id( 'chrome-nofooter' ); ?>">
    <?php esc_html_e( 'No Footer', 'smbw_domain' ); ?>
  </label>
  <br />
  <input type="checkbox"<?php checked( in_array( 'noborders', $instance['chrome'] ) ); ?> id="<?php echo $this->get_field_id( 'chrome-noborders' ); ?>" name="<?php echo $this->get_field_name( 'chrome' ); ?>[]" value="noborders" />
  <label for="<?php echo $this->get_field_id( 'chrome-noborders' ); ?>">
    <?php esc_html_e( 'No Borders', 'smbw_domain' ); ?>
  </label>
  <br />
  <input type="checkbox"<?php checked( in_array( 'noscrollbar', $instance['chrome'] ) ); ?> id="<?php echo $this->get_field_id( 'chrome-noscrollbar' ); ?>" name="<?php echo $this->get_field_name( 'chrome' ); ?>[]" value="noscrollbar" />
  <label for="<?php echo $this->get_field_id( 'chrome-noscrollbar' ); ?>">
    <?php esc_html_e( 'No Scrollbar', 'smbw_domain' ); ?>
  </label>
  <br />
  <input type="checkbox"<?php checked( in_array( 'transparent', $instance['chrome'] ) ); ?> id="<?php echo $this->get_field_id( 'chrome-transparent' ); ?>" name="<?php echo $this->get_field_name( 'chrome' ); ?>[]" value="transparent" />
  <label for="<?php echo $this->get_field_id( 'chrome-transparent' ); ?>">
    <?php esc_html_e( 'Transparent Background', 'smbw_domain' ); ?>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'link-color' ); ?>">
    <?php _e( 'Link Color (hex):', 'smbw_domain' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'link-color' ); ?>" name="<?php echo $this->get_field_name( 'link-color' ); ?>" type="text" value="<?php echo esc_attr( $instance['link-color'] ); ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'border-color' ); ?>">
    <?php _e( 'Border Color (hex):', 'smbw_domain' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'border-color' ); ?>" name="<?php echo $this->get_field_name( 'border-color' ); ?>" type="text" value="<?php echo esc_attr( $instance['border-color'] ); ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'theme' ); ?>">
    <?php _e( 'Timeline Theme:', 'smbw_domain' ); ?>
  </label>
  <select name="<?php echo $this->get_field_name( 'theme' ); ?>" id="<?php echo $this->get_field_id( 'theme' ); ?>" class="widefat">
    <option value="light"<?php selected( $instance['theme'], 'light' ); ?>>
    <?php esc_html_e( 'Light', 'smbw_domain' ); ?>
    </option>
    <option value="dark"<?php selected( $instance['theme'], 'dark' ); ?>>
    <?php esc_html_e( 'Dark', 'smbw_domain' ); ?>
    </option>
  </select>
</p>
<?php
	}
}

/*-------------------------------------------------------------------
Create the SMBW Google Badge widget
--------------------------------------------------------------------*/

class smbw_google_badge extends WP_Widget {
	function smbw_google_badge() {
		//Constructor
		$widget_ops = array('classname' => 'widget smbw_google_badge', 'description' => __('Display google badge to your page. Works best in sidebar areas.', 'smbw_domain') );
		$this->WP_Widget('smbw_google_badge', __('SMBW Google Badge', 'smbw_domain'), $widget_ops);
	}
	
	function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			echo $before_widget;
			$google_badge_url = empty($instance['google_badge_url']) ? 'https://plus.google.com/u/0/109668518626165451650' : apply_filters('widget_google_badge_url', $instance['google_badge_url']);
			$data_width = empty($instance['data_width']) ? 300 : apply_filters('widget_data_width', $instance['data_width']);
			$data_layout = empty($instance['data_layout']) ? 0 : apply_filters('widget_data_layout', $instance['data_layout']);
			$data_theme = empty($instance['data_theme']) ? 0 : apply_filters('widget_data_theme', $instance['data_theme']);
			$badge_type = empty($instance['badge_type']) ? 0 : apply_filters('widget_data_theme', $instance['badge_type']);
			
			$layout=($data_layout == 1)? 'portrait':'landscape';
			$theme=($data_theme == 1)? 'light':'dark';
			
			?>
<div class="g-<?php echo $badge_type; ?>" data-width="<?php echo $data_width; ?>" data-layout="<?php echo $layout; ?>" data-theme="<?php echo $theme; ?>"   data-href="<?php echo $google_badge_url; ?>" data-rel="publisher"></div>

<!-- Place this tag after the last widget tag. --> 
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<?php
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		//save the widget		
		return $new_instance;
	}
	function form($instance) {
		//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array('data_width'=>300, 'google_badge_url'=>'https://plus.google.com/u/0/109668518626165451650', 'data_layout'=>1, 'data_theme'=>1, 'badge_type'=> 'page' ) );
			$google_badge_url = strip_tags($instance['google_badge_url']);
			$data_width = strip_tags($instance['data_width']);
			$data_layout = strip_tags($instance['data_layout']);
			$data_theme = strip_tags($instance['data_theme']);
			$badge_type = strip_tags($instance['badge_type']);
			
	?>
<script type="text/javascript">
	function show_google_badge_header(str,id){
		var value=jQuery('#'+id).val();		
		if(str.value==1 || value==1){			
			 jQuery('p#google_badge_show_header').fadeIn('slow');
		}else{
			jQuery('p#google_badge_show_header').fadeOut("slow");
		}
	}
	</script>
<p>
  <label for="<?php echo $this->get_field_id('google_badge_url'); ?>">
    <?php  echo __('Google badge url', 'smbw_domain')?>
    :
    <input class="widefat" id="<?php echo $this->get_field_id('google_badge_url'); ?>" name="<?php echo $this->get_field_name('google_badge_url'); ?>" type="text" value="<?php echo esc_attr($google_badge_url); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('badge_type'); ?>">
    <?php  echo __('Badge Type', 'smbw_domain')?>
    :
    <select id="<?php echo $this->get_field_id('badge_type'); ?>" name="<?php echo $this->get_field_name('badge_type'); ?>" class="widefat" onchange="show_google_badge_header(this,'<?php echo $this->get_field_id('badge_type'); ?>');">
      <option value="person" <?php if(esc_attr($badge_type)=='person'){ echo 'selected="selected"';}?>> <?php echo __('Profile', 'smbw_domain'); ?> </option>
      <option value="page" <?php if(esc_attr($badge_type)=='page'){ echo 'selected="selected"';}?>> <?php echo __('Page', 'smbw_domain'); ?> </option>
      <option value="community" <?php if(esc_attr($badge_type)=='community'){ echo 'selected="selected"';}?>> <?php echo __('Community', 'smbw_domain'); ?> </option>
    </select>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('data_width'); ?>">
    <?php  echo __('Width', 'smbw_domain')?>
    :
    <input class="widefat" id="<?php echo $this->get_field_id('data_width'); ?>" name="<?php echo $this->get_field_name('data_width'); ?>" type="text" value="<?php echo esc_attr($data_width); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('data_layout'); ?>">
    <?php  echo __('Layout', 'smbw_domain')?>
    :
    <select id="<?php echo $this->get_field_id('data_layout'); ?>" name="<?php echo $this->get_field_name('data_layout'); ?>" class="widefat" onchange="show_google_badge_header(this,'<?php echo $this->get_field_id('data_layout'); ?>');">
      <option value="1" <?php if(esc_attr($data_layout)=='1'){ echo 'selected="selected"';}?>> <?php echo __('portrait', 'smbw_domain'); ?> </option>
      <option value="0" <?php if(esc_attr($data_layout)=='0'){ echo 'selected="selected"';}?>> <?php echo __('landscape', 'smbw_domain'); ?> </option>
    </select>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('data_theme'); ?>">
    <?php  echo __('Theme', 'smbw_domain')?>
    :
    <select id="<?php echo $this->get_field_id('data_theme'); ?>" name="<?php echo $this->get_field_name('data_theme'); ?>" class="widefat" onchange="show_google_badge_header(this,'<?php echo $this->get_field_id('data_theme'); ?>');">
      <option value="1" <?php if(esc_attr($data_theme)=='1'){ echo 'selected="selected"';}?>> <?php echo __('light', 'smbw_domain'); ?> </option>
      <option value="0" <?php if(esc_attr($data_theme)=='0'){ echo 'selected="selected"';}?>> <?php echo __('dark', 'smbw_domain'); ?> </option>
    </select>
  </label>
</p>
<?php
	}
	
}
