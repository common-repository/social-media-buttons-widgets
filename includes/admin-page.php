<?php
/*
==================================================
// Display functions for outputting option in the
// admin
==================================================
*/

function smbw_options_page() {

	global $smbw_options;

	ob_start(); ?>

<div class="wrap" style="width:40%; float:left;">
  <h2>
    <?php _e('Social Media Links Options', 'smbw_domain'); ?>
  </h2>
  <form method="post" action="options.php">
    <table class="form-table" cellpadding="10" cellspacing="10">
      <?php settings_fields('smbw_settings_group'); ?>
      <tr>
        <th scope="row"> <?php _e('Enable', 'smbw_domain'); ?>
        </th>
        <td colspan="3"><input id="smbw_settings[enable]" name="smbw_settings[enable]" type="checkbox" value="1" <?php checked(1, $smbw_options['enable']); ?> />
          <label class="description" for="smbw_settings[enable]">
            <?php _e('Display button', 'smbw_domain'); ?>
          </label></td>
      </tr>
      <tr>
        <th scope="row"> <?php _e('Facebook', 'smbw_domain'); ?>
        </th>
        <td><?php $fb_layout = array('standard', 'box_count', 'button_count', 'button'); ?>
          <select name="smbw_settings[fblayout]" id="smbw_settings[fblayout]">
            <?php foreach($fb_layout as $display_layout) { ?>
            <?php if($smbw_options['fblayout'] == $display_layout) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
            <option value="<?php echo $display_layout; ?>" <?php echo $selected; ?>><?php echo $display_layout; ?></option>
            <?php } ?>
          </select></td>
                   <td colspan="2">
       <input id="smbw_settings[fb_app_id]" name="smbw_settings[fb_app_id]" type="text" placeholder="Facebook App Id" value="<?php echo $smbw_options['fb_app_id']; ?>"/>
        </td>
      </tr>
      <tr>
        <th scope="row"><?php _e('Twitter', 'smbw_domain'); ?>
        </th>
        <td colspan="3"><?php $tw_layout = array('none', 'horizontal', 'vertical'); ?>
          <select name="smbw_settings[twlayout]" id="smbw_settings[twlayout]">
            <?php foreach($tw_layout as $twitter_layout) { ?>
            <?php if($smbw_options['twlayout'] == $twitter_layout) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
            <option value="<?php echo $twitter_layout; ?>" <?php echo $selected; ?>><?php echo $twitter_layout; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <th scope="row"> <?php _e('Google', 'smbw_domain'); ?>
        </th>
        <td><?php $g_plus = array('small', 'medium' , 'standard', 'tall'); ?>
          <select name="smbw_settings[gplus]" id="smbw_settings[gplus]">
            <?php foreach($g_plus as $gplus_display) { ?>
            <?php if($smbw_options['gplus'] == $gplus_display) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
            <option value="<?php echo $gplus_display; ?>" <?php echo $selected; ?>><?php echo $gplus_display; ?></option>
            <?php } ?>
          </select>
        <td>
        <td><?php _e('Anotation', 'smbw_domain'); ?>
        </td>
        <td><?php $g_anotate = array('none', 'bubble' , 'inline'); ?>
          <select name="smbw_settings[ganotate]" id="smbw_settings[ganotate]">
            <?php foreach($g_anotate as $ganotate_display) { ?>
            <?php if($smbw_options['ganotate'] == $ganotate_display) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
            <option value="<?php echo $ganotate_display; ?>" <?php echo $selected; ?>><?php echo $ganotate_display; ?></option>
            <?php } ?>
          </select>
        <td>
      </tr>
      <tr>
        <th scope="row"> <?php _e('Pinterest', 'smbw_domain'); ?>
        </th>
        <td><?php $pin_layout = array('none', 'beside', 'above'); ?>
          <select name="smbw_settings[pinlayout]" id="smbw_settings[pinlayout]">
            <?php foreach($pin_layout as $pinit_layout) { ?>
            <?php if($smbw_options['pinlayout'] == $pinit_layout) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
            <option value="<?php echo $pinit_layout; ?>" <?php echo $selected; ?>><?php echo $pinit_layout; ?></option>
            <?php } ?>
          </select>
        <td>
         <td> <?php _e('color', 'smbw_domain'); ?>
        </td>
        <td><?php $pin_color = array('red', 'white'); ?>
          <select name="smbw_settings[pincolor]" id="smbw_settings[pincolor]">
            <?php foreach($pin_color as $pinit_color) { ?>
            <?php if($smbw_options['pincolor'] == $pinit_color) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
            <option value="<?php echo $pinit_color; ?>" <?php echo $selected; ?>><?php echo $pinit_color; ?></option>
            <?php } ?>
          </select>
        <td>
      </tr>
      
    </table>
    <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Options', 'smbw_domain'); ?>" />
    </p>

  </form>

</div>
<style type="text/css">
.profile-wrapper {
    background: none repeat scroll 0 0 #ffffff;
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
	overflow:auto;
    padding: 3px;
	width:206px;
}
.profile {
	float:left;
	width:200px;
	margin-right:10px;
	}
.descriptions {

	}
.descriptions h3 {
	text-align:center;
	padding:0;
	margin:0;
	line-height:2;
}
.descriptions h3 a {
	text-decoration:none;
	}
</style>
<div class="wrap" style="width:400px;float:right;">
  <h2>
    <?php _e('About the Author', 'smbw_domain'); ?>
  </h2>
  <div class="profile-wrapper">
  <div class="profile">
  <img src="http://www.gravatar.com/avatar/6e131ead37a7d2311b317f1a3c61a167?s=200" width="200" height="200" /> 
  </div>
  <div class="descriptions"><h3><a href="https://www.odesk.com/users/~0193715ab70df6654a" target="_blank">Hire Me</a></h3></div>
  </div>
<h4>If asking for donations is to much <a href="https://www.odesk.com/users/~0193715ab70df6654a" target="_blank">Hire me</a> instead.</h4>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="GHXEE3NCQ7KTQ">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
  <h2>
    <?php _e('Other Plugin Done by this Author', 'smbw_domain'); ?>
  </h2>
<ul>
<li><a href="http://codecanyon.net/item/woocommerce-phone-verification-by-ringcaptcha/7808948" title="WooCommerce Phone Verification by RingCaptcha with SMS notifications." target="_blank">WooCommerce Phone Verification by RingCaptcha with SMS notifications.</a></li>
</ul>
</div>
<?php
	echo ob_get_clean();
}

function smbw_add_options_link() {
	add_options_page('Social Media Links Options', 'SM Buttons &amp; Widgets', 'manage_options', 'smbw-options', 'smbw_options_page');
}
add_action('admin_menu', 'smbw_add_options_link');

function smbw_register_settings() {
	// creates our settings in the options table
	register_setting('smbw_settings_group', 'smbw_settings');
}
add_action('admin_init', 'smbw_register_settings');

// Meta Box

// Register the Metabox
function smbw_add_meta_box() {
	add_meta_box( 'smbw-meta-box', __( 'Social Media Button Function', 'smbw_domain' ), 'smbw_meta_box_output', 'post', 'side', 'high' );
	add_meta_box( 'smbw-meta-box', __( 'Social Media Button Function', 'smbw_domain' ), 'smbw_meta_box_output', 'page', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'smbw_add_meta_box' );

/**
 * Outputs the content of the meta box
 */
function smbw_meta_box_output( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'smbw_nonce' );
    $smbw_stored_meta = get_post_meta( $post->ID );
    ?>
 
<p>
    <div class="smbw-row-content">
        <label for="meta-checkbox">
            <input type="checkbox" name="meta-checkbox" id="meta-checkbox" value="yes" <?php if ( isset ( $smbw_stored_meta['meta-checkbox'] ) ) checked( $smbw_stored_meta['meta-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Turn<strong> Off</strong> the social Media Button', 'smbw_textdomain' )?>
        </label>
    </div>
</p>
 
    <?php
}

/**
 * Saves the custom meta input
 */
function smbw_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'smbw_nonce' ] ) && wp_verify_nonce( $_POST[ 'smbw_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
	  // Checks for input and saves
	if( isset( $_POST[ 'meta-checkbox' ] ) ) {
		update_post_meta( $post_id, 'meta-checkbox', 'yes' );
	} else {
		update_post_meta( $post_id, 'meta-checkbox', '' );
	}
 
}
add_action( 'save_post', 'smbw_meta_save' );