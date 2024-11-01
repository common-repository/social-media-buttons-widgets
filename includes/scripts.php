<?php
/*
==================================================
// script control
==================================================
*/

function smbw_load_scripts() {

		wp_enqueue_style('smbw-styles', plugin_dir_url( __FILE__ ) . 'css/smbw_styles.css');
		wp_enqueue_script('smbw-scripts', plugin_dir_url( __FILE__ ) . 'js/smbw_script.js');
		wp_enqueue_script('smbw-pinit', 'http://assets.pinterest.com/js/pinit.js');

}
add_action('wp_enqueue_scripts', 'smbw_load_scripts');

	if(!function_exists('smbw_inline_script'))
	{
		function smbw_inline_script()
		{
			global $smbw_options;
			?>
<script type="text/javascript">
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=<?php echo $smbw_options['fb_app_id']; ?>&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<?php
		}
	}
add_action('wp_footer','smbw_inline_script');