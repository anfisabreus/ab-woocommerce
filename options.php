<?php
/***************Plugin Functions****************/
function ab_woocommerce_menu() {
$my_page = 	add_menu_page( 'AB-Woocommerce', 'AB-Woocommerce', 'manage_options', 'ab-woocommerce-option', 'ab_woocommerce_plugin_options' );
add_submenu_page( 'ab-woocommerce-option', 'Лицензия', 'Лицензия', 'manage_options', EDD_WOOCOMMERCE_PLUGIN_LICENSE_PAGE, 'ab_licence_woocommerce_page');


add_action('load-' . $my_page, 'ab_load_admin_woocommerce_js' );
add_action('load-' . $my_page, 'wppagescriptremover_woocommerce');

}
function ab_load_admin_woocommerce_js(){
add_action( 'admin_enqueue_scripts', 'ab_enqueue_admin_woocommerce_js' );
}
function ab_enqueue_admin_woocommerce_js(){
       wp_enqueue_script('jquery-hp', plugins_url('js/jquery-1.10.2.js', __FILE__ )); 
        wp_enqueue_script('jquery-ui-hp', plugins_url('js/jquery-ui.min.js', __FILE__ )); 
        wp_enqueue_script('jquery-custom', plugins_url('js/custom-jquery.js', __FILE__ )); 
        wp_enqueue_script('color-picker', plugins_url('js/color-picker.min.js', __FILE__ ), array( 'wp-color-picker' ), false, true);
		wp_enqueue_script('cookies', plugins_url('js/jquery.cookie.js', __FILE__ ));
		wp_enqueue_style('style-accordion', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css?ver=4.6.1');
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style('fonе1', '//fonts.googleapis.com/css?family=Marck+Script&subset=cyrillic');
	    wp_enqueue_style('font2', '//fonts.googleapis.com/css?family=Neucha&subset=cyrillic');
	    wp_enqueue_style('font3', '//fonts.googleapis.com/css?family=Poiret+One&subset=cyrillic');
	    wp_enqueue_style('font4', '//fonts.googleapis.com/css?family=Open+Sans&subset=cyrillic');
	    wp_enqueue_style('font5', '//fonts.googleapis.com/css?family=Open+Sans|Open+Sans+Condensed:300&subset=cyrillic');
	    wp_enqueue_style('font6', '//fonts.googleapis.com/css?family=Lobster&subset=cyrillic');
	    wp_enqueue_style('font7', '//fonts.googleapis.com/css?family=PT+Sans+Narrow&subset=cyrillic');
        wp_enqueue_style('font8', '//fonts.googleapis.com/css?family=Comfortaa&subset=cyrillic');
        wp_enqueue_style('font9', '//fonts.googleapis.com/css?family=Didact+Gothic&subset=cyrillic');
        wp_enqueue_media();
}

function wppagescriptremover_woocommerce() {
remove_action('admin_footer','wppage_shortcode_settings_admin_js');
}
add_action( 'admin_menu', 'ab_woocommerce_menu' );


add_action( 'admin_print_scripts-post-new.php', 'woocommerce_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'woocommerce_admin_script', 11 );

function woocommerce_admin_script() {
    global $post;
    if( 'woocommerce' === $post->post_type ) {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery-main', plugins_url('js/jquery-1.10.2.js', __FILE__ ));
    wp_enqueue_script( 'jquery-main' );
    wp_enqueue_script('jquery-ui', plugins_url('js/jquery-ui.min.js', __FILE__ )); 
    wp_enqueue_style('jquery-ui-css', plugins_url('css/jquery-ui.css', __FILE__ ));		   
    wp_enqueue_script( 'portfolio-admin-script', plugins_url('js/catalog.js', __FILE__ )); 
    remove_action('admin_footer','wppage_shortcode_settings_admin_js');
}
}


// Licence begin
function edd_woocommerce_register_option() {
	// creates our settings in the options table
	register_setting('edd_woocommerce_license', 'edd_woocommerce_license_key', 'edd_woocommerce_sanitize_license' );
}
add_action('admin_init', 'edd_woocommerce_register_option');

function edd_woocommerce_sanitize_license( $new ) {
	$old = get_option( 'edd_woocommerce_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'edd_woocommerce_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}




/************************************
* this illustrates how to activate 
* a license key
*************************************/

function edd_woocommerce_activate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_woo_license_activate'] ) ) {

		// run a quick security check 
	 	if( ! check_admin_referer( 'edd_woocommerce_nonce', 'edd_woocommerce_nonce' ) ) 	
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'edd_woocommerce_license_key' ) );
			

		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'activate_license', 
			'license' 	=> $license, 
			'item_id' => EDD_WOOCOMMERCE_ITEM_ID,
			'url'        => home_url()
		);
		
		// Call the custom API.
		
		$response = wp_remote_post( EDD_WOOCOMMERCE_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$message =  ( is_wp_error( $response ) && ! empty( $response->get_error_message() ) ) ? $response->get_error_message() : __( 'An error occurred, please try again.' );
		} else {
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			if ( false === $license_data->success ) {
				switch( $license_data->error ) {
					case 'expired' :
						$message = sprintf(
							__( 'Your license key expired on %s.' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;
					case 'revoked' :
						$message = __( 'Your license key has been disabled.' );
						break;
					case 'missing' :
						$message = __( 'Invalid license.' );
						break;
					case 'invalid' :
					case 'site_inactive' :
						$message = __( 'Your license is not active for this URL.' );
						break;
					case 'item_name_mismatch' :
						$message = sprintf( __( 'This appears to be an invalid license key for %s.' ), EDD_WOOCOMMERCE_ITEM_NAME );
						break;
					case 'no_activations_left':
						$message = __( 'Your license key has reached its activation limit.' );
						break;
					default :
						$message = __( 'An error occurred, please try again.' );
						break;
				}
			}
		}
		// Check if anything passed on a message constituting a failure
		if ( ! empty( $message ) ) {
			$base_url = admin_url( 'admin.php?page=' . EDD_WOOCOMMERCE_PLUGIN_LICENSE_PAGE );
			$redirect = add_query_arg( array( 'form_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );
			wp_redirect( $redirect );
			exit();
		}
		// $license_data->license will be either "valid" or "invalid"
		update_option( 'edd_woocommerce_license_status', $license_data->license );
		wp_redirect( admin_url( 'admin.php?page=' . EDD_WOOCOMMERCE_PLUGIN_LICENSE_PAGE ) );
		exit();
	}
}
add_action('admin_init', 'edd_woocommerce_activate_license');


/***********************************************
* Illustrates how to deactivate a license key.
* This will descrease the site count
***********************************************/

function edd_woocommerce_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_woo_license_deactivate'] ) ) {

		// run a quick security check 
	 	if( ! check_admin_referer( 'edd_woocommerce_nonce', 'edd_woocommerce_nonce' ) ) 	
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'edd_woocommerce_license_key' ) );
			

		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'deactivate_license', 
			'license' 	=> $license, 
			'item_name'  => urlencode( EDD_WOOCOMMERCE_ITEM_NAME ), // the name of our product in EDD
			'url'        => home_url()
		);
		
		// Call the custom API.
		
		$response = wp_remote_post( EDD_WOOCOMMERCE_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay

		
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.' );
			}

			$base_url = admin_url( 'admin.php?page=' . EDD_WOOCOMMERCE_PLUGIN_LICENSE_PAGE );
			$redirect = add_query_arg( array( 'form_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}

		
		
		
		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' ) {
			delete_option( 'edd_woocommerce_license_status' );
			}
			
			wp_redirect( admin_url( 'admin.php?page=' . EDD_WOOCOMMERCE_PLUGIN_LICENSE_PAGE ) );
		exit();

	}
}
add_action('admin_init', 'edd_woocommerce_deactivate_license');

/************************************
* this illustrates how to check if 
* a license key is still valid
* the updater does this for you,
* so this is only needed if you
* want to do something custom
*************************************/

function edd_woocommerce_check_license() {

	global $wp_version;

	$license = trim( get_option( 'edd_woocommerce_license_key' ) );
		

	$api_params = array( 
		'edd_action' => 'check_license', 
		'license' => $license, 
		'item_name' => urlencode( $item_name ),
		'url' => home_url()
	);

	// Call the custom API.

	$response = wp_remote_post( EDD_WOOCOMMERCE_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );



if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}


/**
 * This is a means of catching errors from the activation method above and displaying it to the customer
 */
function edd_woocommerce_admin_notices() {
	if ( isset( $_GET['form_activation'] ) && ! empty( $_GET['message'] ) ) {

		switch( $_GET['form_activation'] ) {

			case 'false':
				$message = urldecode( $_GET['message'] );
				?>
				<div class="error">
					<p><?php echo $message; ?></p>
				</div>
				<?php
				break;

			case 'true':
			default:
				// Developers can put a custom success message here for when activation is successful if they way.
				break;

		}
	}
}
add_action( 'admin_notices', 'edd_woocommerce_admin_notices' );


	
// Licence end

function ab_licence_woocommerce_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
$license = get_option( 'edd_woocommerce_license_key' );
$status = get_option( 'edd_woocommerce_license_status' ); ?>


<h3>Лицензия</h3>
		<form method="post" action="options.php">
		
			<?php settings_fields('edd_woocommerce_license'); ?>
			
			
			
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Код лицензии'); ?>
						</th>
						<td>
							<input id="edd_woocommerce_license_key" name="edd_woocommerce_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="edd_woocommerce_license_key"><?php _e('Введите Ваш код лицензии'); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Активировать Лицензию'); ?>
							</th>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span style="color:green;"><?php _e('активная'); ?></span>
									<?php wp_nonce_field( 'edd_woocommerce_nonce', 'edd_woocommerce_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_woo_license_deactivate" value="<?php _e('Деактивировать Лицензию'); ?>"/>
									
	<?php
} else {
									wp_nonce_field( 'edd_woocommerce_nonce', 'edd_woocommerce_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_woo_license_activate" value="<?php _e('Активировать Лицензию'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>	
			<?php submit_button(); ?>
		
		</form>
								
</div>
<?php ;}


function woocommerce_option_name() {
$catalog_settings = get_option('ab_woocommerce');
update_option('ab_woocommerce', $catalog_settings);
}


function ab_woocommerce_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
global $ab_woocommerce;
$imageurl =  get_bloginfo('url') .'/wp-content/plugins/ab-woocommerce/images/';

if(isset($_POST["submit"])){ 
$ab_woocommerce['items_number'] = $_POST['items_number'];
$ab_woocommerce['sidebar'] = $_POST['sidebar'];
$ab_woocommerce['testimonials_title'] = $_POST['testimonials_title'];
$ab_woocommerce['homepage_border_round'] = $_POST['homepage_border_round'];
$ab_woocommerce['menu'] = $_POST['menu'];
$ab_woocommerce['homepage_border'] = $_POST['homepage_border'];
$ab_woocommerce['homepage_border_color'] = $_POST['homepage_border_color'];
$ab_woocommerce['margin_top'] = $_POST['margin_top'];
$ab_woocommerce['margin_bottom'] = $_POST['margin_bottom'];
$ab_woocommerce['homepage_width'] = $_POST['homepage_width'];
$ab_woocommerce['bg_level3'] = $_POST['bg_level3'];
$ab_woocommerce['bg_level5'] = $_POST['bg_level5'];
$ab_woocommerce['padding_bottom5'] = $_POST['padding_bottom5'];
$ab_woocommerce['padding_top5'] = $_POST['padding_top5'];
$ab_woocommerce['hp_category1'] = $_POST['hp_category1'];
$ab_woocommerce['hp_category2'] = $_POST['hp_category2'];
$ab_woocommerce['hp_category3'] = $_POST['hp_category3'];
$ab_woocommerce['padding'] = $_POST['padding'];
$ab_woocommerce['bg_level2'] = $_POST['bg_level2'];
$ab_woocommerce['shop_button_homepage_text'] = $_POST['shop_button_homepage_text'];
$ab_woocommerce['image_border'] = $_POST['image_border'];
$ab_woocommerce['image_border_color'] = $_POST['image_border_color'];
$ab_woocommerce['border_static'] = $_POST['border_static'];
$ab_woocommerce['border_opacity'] = $_POST['border_opacity'];
$ab_woocommerce['image_bg_color_hover'] = $_POST['image_bg_color_hover'];
$ab_woocommerce['category_headline_color'] = $_POST['category_headline_color'];
$ab_woocommerce['category_headline_size'] = $_POST['category_headline_size'];
$ab_woocommerce['category_headline_font'] = $_POST['category_headline_font'];
$ab_woocommerce['category_headline_strong'] = $_POST['category_headline_strong'];
$ab_woocommerce['category_headline_italic'] = $_POST['category_headline_italic'];
$ab_woocommerce['bg_static'] = $_POST['bg_static'];
$ab_woocommerce['bg_cat_opacity'] = $_POST['bg_cat_opacity'];
$ab_woocommerce['image_bg_color_hoverone'] = $_POST['image_bg_color_hoverone'];
$ab_woocommerce['category_desc_font'] = $_POST['category_desc_font'];
$ab_woocommerce['category_desc_size'] = $_POST['category_desc_size'];
$ab_woocommerce['category_desc_strong'] = $_POST['category_desc_strong'];
$ab_woocommerce['category_desc_italic'] = $_POST['category_desc_italic'];
$ab_woocommerce['category_desc_color'] = $_POST['category_desc_color'];
$ab_woocommerce['padding_top1'] = $_POST['padding_top1'];
$ab_woocommerce['padding_bottom1'] = $_POST['padding_bottom1'];
$ab_woocommerce['bg_text_cat'] = $_POST['bg_text_cat'];
$ab_woocommerce['bg_text_cat_opacily'] = $_POST['bg_text_cat_opacily'];
$ab_woocommerce['bg_level3'] = $_POST['bg_level3'];
$ab_woocommerce['padding_bottom3'] = $_POST['padding_bottom3'];
$ab_woocommerce['padding_top3'] = $_POST['padding_top3'];
$ab_woocommerce['padding_level3'] = $_POST['padding_level3'];
$ab_woocommerce['hp_heading_level3'] = $_POST['hp_heading_level3'];
$ab_woocommerce['shop_button_homepage_ads'] = $_POST['shop_button_homepage_ads'];
$ab_woocommerce['shop_button_homepage_hover_ads'] = $_POST['shop_button_homepage_hover_ads'];
$ab_woocommerce['shop_button_homepage_text_ads'] = $_POST['shop_button_homepage_text_ads'];
$ab_woocommerce['shop_button_homepage_text_hover_ads'] = $_POST['shop_button_homepage_text_hover_ads'];
$ab_woocommerce['image_ads'] = $_POST['image_ads'];
$ab_woocommerce['link_ads'] = $_POST['link_ads'];
$ab_woocommerce['text_ads'] = $_POST['text_ads'];
$ab_woocommerce['featured_items_title'] = $_POST['featured_items_title'];
$ab_woocommerce['padding_level_featured'] = $_POST['padding_level_featured'];
$ab_woocommerce['padding_top_featured'] = $_POST['padding_top_featured'];
$ab_woocommerce['padding_bottom_featured'] = $_POST['padding_bottom_featured'];
$ab_woocommerce['background_size'] = $_POST['background_size'];
$ab_woocommerce['custom_bg1'] = $_POST['custom_bg1'];
$ab_woocommerce['hp_repeat_bg1'] = $_POST['hp_repeat_bg1'];
$ab_woocommerce['hp_repeat_position1'] = $_POST['hp_repeat_position1'];
$ab_woocommerce['hp_fon_color1'] = $_POST['hp_fon_color1'];
$ab_woocommerce['background_size5'] = $_POST['background_size5'];
$ab_woocommerce['custom_bg5'] = $_POST['custom_bg5'];
$ab_woocommerce['hp_repeat_bg5'] = $_POST['hp_repeat_bg5'];
$ab_woocommerce['hp_repeat_position5'] = $_POST['hp_repeat_position5'];
$ab_woocommerce['border_top_form'] = $_POST['border_top_form'];
$ab_woocommerce['bg_level6'] = $_POST['bg_level6'];
$ab_woocommerce['items_number_featured'] = $_POST['items_number_featured'];
$ab_woocommerce['cols_number_featured'] = $_POST['cols_number_featured'];
$ab_woocommerce['form_title'] = $_POST['form_title'];
$ab_woocommerce['shop_button_homepage_text_hover_form'] = $_POST['shop_button_homepage_text_hover_form'];
$ab_woocommerce['shop_button_homepage_hover_form'] = $_POST['shop_button_homepage_hover_form'];
$ab_woocommerce['shop_button_homepage_form'] = $_POST['shop_button_homepage_form'];
$ab_woocommerce['shop_button_homepage_text_form'] = $_POST['shop_button_homepage_text_form'];
$ab_woocommerce['padding_top6'] = $_POST['padding_top6'];
$ab_woocommerce['padding_bottom6'] = $_POST['padding_bottom6'];
$ab_woocommerce['ab_sub_form_smart'] = $_POST['ab_sub_form_smart'];
$ab_woocommerce['ab_jc_login'] = $_POST['ab_jc_login'];
$ab_woocommerce['ab_jc_marker'] = $_POST['ab_jc_marker'];
$ab_woocommerce['ab_jc_group'] = $_POST['ab_jc_group'];
$ab_woocommerce['ab_jc_link_1'] = $_POST['ab_jc_link_1'];
$ab_woocommerce['ab_jc_link_2'] = $_POST['ab_jc_link_2'];
$ab_woocommerce['ab_form_old_form'] = $_POST['ab_form_old_form'];
$ab_woocommerce['ab_formid'] = $_POST['ab_formid'];
$ab_woocommerce['thankyou_page'] = $_POST['thankyou_page'];
$ab_woocommerce['ab_link_sub'] = $_POST['ab_link_sub'];
$ab_woocommerce['ab_mc_login'] = $_POST['ab_mc_login'];
$ab_woocommerce['ab_mc_idprofile'] = $_POST['ab_mc_idprofile'];
$ab_woocommerce['ab_mc_idlist'] = $_POST['ab_mc_idlist'];
$ab_woocommerce['unisenderhash'] = $_POST['unisenderhash'];
$ab_woocommerce['unisenderid'] = $_POST['unisenderid'];
$ab_woocommerce['loginautoweboffice'] = $_POST['loginautoweboffice'];
$ab_woocommerce['idautoweboffice'] = $_POST['idautoweboffice'];
$ab_woocommerce['idautowebofficepassylki'] = $_POST['idautowebofficepassylki'];
$ab_woocommerce['idformmailerlite'] = $_POST['idformmailerlite'];
$ab_woocommerce['idlandingmailerlite'] = $_POST['idlandingmailerlite'];
$ab_woocommerce['idstatistic'] = $_POST['idstatistic'];
$ab_woocommerce['idformsendpulse'] = $_POST['idformsendpulse'];
$ab_woocommerce['hashformsednpulse'] = $_POST['hashformsednpulse'];
$ab_woocommerce['idscriptsendpulse'] = $_POST['idscriptsendpulse'];
$ab_woocommerce['thankyoumailerlite'] = $_POST['thankyoumailerlite'];
$ab_woocommerce['otzyvy_border_color'] = $_POST['otzyvy_border_color'];
$ab_woocommerce['otzyvy_border'] = $_POST['otzyvy_border'];
$ab_woocommerce['rating_color'] = $_POST['rating_color'];
$ab_woocommerce['font_size_items'] = $_POST['font_size_items'];

$ab_woocommerce['posts_items_title'] = $_POST['posts_items_title'];
$ab_woocommerce['hp_fon_color6'] = $_POST['hp_fon_color6'];
$ab_woocommerce['hp_repeat_position6'] = $_POST['hp_repeat_position6'];
$ab_woocommerce['hp_repeat_bg6'] = $_POST['hp_repeat_bg6'];
$ab_woocommerce['custom_bg6'] = $_POST['custom_bg6'];
$ab_woocommerce['padding_bottom_posts'] = $_POST['padding_bottom_posts'];
$ab_woocommerce['padding_top_posts'] = $_POST['padding_top_posts'];
$ab_woocommerce['padding_level_posts'] = $_POST['padding_level_posts'];
$ab_woocommerce['padding_level_testimonials'] = $_POST['padding_level_testimonials'];
$ab_woocommerce['cat_layout'] = $_POST['cat_layout'];
$ab_woocommerce['button_align'] = $_POST['button_align'];
$ab_woocommerce['checkout_free_shipping'] = $_POST['checkout_free_shipping'];
$ab_woocommerce['show_cat_product'] = $_POST['show_cat_product'];
$ab_woocommerce['related_product_text'] = $_POST['related_product_text'];
$ab_woocommerce['ab_swatches_check'] = $_POST['ab_swatches_check'];

$ab_woocommerce['show_cat_title'] = $_POST['show_cat_title'];
$ab_woocommerce['show_cat_desc'] = $_POST['show_cat_desc'];

$ab_woocommerce['text_form_button'] = $_POST['text_form_button'];


update_option('ab_woocommerce',$ab_woocommerce);
                     echo '<div id="message" class="updated fade"><p>Настройки сохранены</p></div>';
                    }
              
$curve_array = array("0" => "0px","1" => "1px","2" => "2px","3" => "3px","4" => "4px","5" => "5px","6" => "6px","7" => "7px","8" => "8px","9" => "9px","10" => "10px","11" => "11px","12" => "12px","13" => "13px","14" => "14px","15" => "15px","16" => "16px");
$items_number = array( '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6');
$cols_number = array( '2' => '2','3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12');
$sidebar = array( '1' => 'С боковой колонкой', '2' => 'Без боковой колонки');
		$ab_border_round = array( '0' => 'Нет', '1' => '1px', '2' => '2px', '3' => '3px', '4' => '4px', '5' => '5px', '6' => '6px', '7' => '7px', '8' => '8px', '9' => '9px', '10' => '10px', '11' => '11px', '12' => '12px', '13' => '13px', '14' => '14px', '15' => '15px');
$ab_woocommerce_width = array( '1200px' => '1200px', '100%' => '100%'); 

$checkout_address_show = array( '1' => 'Да', '2' => 'Нет');
$menu = array( '1' => 'Главное меню', '2' => 'Меню в шапке', '3' => 'Исключить меню из шапки');
	$background_size = 	array('cover' => __('Фон покрывает все поле', 'inspiration'), 'contain' => __('Фон покрывает поле сохраняя пропорции изображения', 'inspiration'), 'initial' => __('Исходный размер изображения', 'inspiration') );
	
	
$repeat_bg = array('no-repeat' =>  'Не повторять','repeat-x'  => 'Повторять по горизонтали','repeat-y'  => 'Повторять по вертикали','repeat'    =>  'Повторять все');

$repeat_position = array('top left'      => 'Сверху Слева','top center'    =>  'Сверху По Центру','top right'     =>  'Сверху Справа','center left'   =>  'Посередине Слева','center center' =>  'Посередине По Центру','center right'  =>  'Посередине Справа','bottom left'   => 'Внизу Слева','bottom center' =>  'Внизу По Центру','bottom right'  =>  'Внизу Справа');

$padding = array( '1' => 'Да', '2' => 'Нет');
$image_border = array( '0px' => 'Нет','1px' => '1px', '2px' => '2px', '3px' => '3px', '4px' => '4px', '5px' => '5px', '6px' => '6px', '7px' => '7px', '8px' => '8px', '9px' => '9px', '10px' => '10px');
$border_static = array( '0' => 'Нет','1' => 'Статическая граница', '2' => 'При наведении мышки');
$border_opacity = array( '1' => 'Не прозрачная', '.5' => 'средне прозрачная' , '.1' => 'сильно прозрачная');
$bg_static = array( '0' => 'Без затемнения', '1' => 'Статическая затемнение', '2' => 'При наведении мышки');
$border_opacity_bg = array('.5' => 'средне прозрачная' , '.1' => 'сильно прозрачная');
$border_opacity_text = array( '1' => 'Не прозрачная', '.5' => 'средне прозрачная');
$font_size = array( '12' => '12px', '14' => '14px', '16' => '16px', '18' => '18px', '20' => '20px', '22' => '22px', '24' => '24px', '26' => '26px', '28' => '28px', '30' => '30px', '32' => '32px', '34' => '34px', '36' => '36px', '38' => '38px', '40' => '40px', '42' => '42px', '44' => '44px', '46' => '46px', '48' => '48px', '50' => '50px', '52' => '52px', '54' => '54px', '56' => '56px', '58' => '58px', '60' => '60px');
$font_family = array( 'arial'     => 'Arial','verdana'   => 'Verdana, Geneva','helvetica' => 'Helvetica','tahoma'    => 'Tahoma, Geneva','Lucida Console, Monaco, monospace' => 'Lucida Console','Open Sans'    => 'Open Sans','Open Sans Condensed'  => 'Open Sans Condensed','PT Sans Narrow'  => 'PT Sans Narrow',	'Trebuchet' => 'Trebuchet','georgia'   => 'Georgia','times'     => 'Times New Roman','palatino'  => 'Palatino','Comic Sans MS, cursive' => 'Comic Sans MS','Courier New, monospace' => 'Courier New','Impact, Charcoal, sans-serif' => 'Impact', 'Marck Script'  => 'Marck Script','Neucha'  => 'Neucha','Poiret One'  => 'Poiret One','Lobster'  => 'Lobster','Comfortaa'  => 'Comfortaa','Didact Gothic'  => 'Didact Gothic', 'Roboto'  => 'Roboto', 'Willamette SF'  => 'Willamette SF');

$cat_layout = array('1' =>  'Одна большая, две маленьких','2'  => '3 одинаковых в ряд');
$button_align = array('1' =>  'Слева','2'  => 'Справа','3'  => 'По центру');


?>

<div class="wrap">
<script>$("#message").show().delay(2000).fadeOut();</script>

<div style="padding-left:28px; padding-bottom:20px;">

</div>
<?php $license 	= get_option( 'edd_woocommerce_license_key' );
$status 	= get_option( 'edd_woocommerce_license_status' );
if ($status !== false && $status == 'valid' ) { ?>
 
<form method="post" action=""> 
        
  <?php settings_fields( 'update-options' ); ?>
 
 <div>
 
 
<div id="tabs">
<ul>

<li><a href="#fragment-2">Главная магазина</a></li>
<li><a href="#fragment-1">Витрина/Товары</a></li>
<li><a href="#fragment-4">Страница оплаты/Корзина</a></li>

</ul>

<!-- Вкладка №1 - Старница с товарами (боковая колонка/количество товаров) -->
<div id="fragment-1">
<table class="form-table">	
<tr valign="top">
<th scope="row">Страница с товарами с боковой колонкой или без:</th>
<td colspan="2">

<select name="sidebar" class="font_select">
<?php foreach ( $sidebar as $a => $b ) : ?>
<option value="<?php echo $a; ?>" <?php if ( $ab_woocommerce['sidebar'] == $a ) echo 'selected'; ?>><?php echo $b; ?></option>
<?php endforeach; ?>		
</select>
</td>
</tr>
					
<tr valign="top">
<th scope="row">Количество товаров на странице с товарами:</th>
<td colspan="2">
<select name="items_number" class="font_select">
<?php foreach ( $items_number as $a => $b ) : ?>
<option value="<?php echo $a; ?>" <?php if ( $ab_woocommerce['items_number'] == $a ) echo 'selected'; ?>><?php echo $b; ?></option>
<?php endforeach; ?>		
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Отображать категории в товарах?</th>
<td colspan="2">

<div style="margin-right:20px; float:left">
<input type="checkbox" name="show_cat_product" value="1" <?php if ( $ab_woocommerce['show_cat_product']) echo 'checked="checked"'; ?>>
<strong>Да/нет </strong><br><br>


</div>
</td>
</tr>







<tr valign="top">
<th scope="row">Текст для заголовка Похожие товары</th>
<td colspan="2">


<input type="text" size="50" name="related_product_text" value="<?php if ( isset( $ab_woocommerce['related_product_text'] ) ) echo $ab_woocommerce['related_product_text']; ?>" />
</td>
</tr>
<tr valign="top">
<th scope="row">Размер шрифта заголовков товаров:</th>
<td colspan="2">

<select name="font_size_items" class="font_select">
<?php foreach ( $font_size as $a => $b ) : ?>
<option value="<?php echo $a; ?>" <?php if ( $ab_woocommerce['font_size_items'] == $a ) echo 'selected'; ?>><?php echo $b; ?></option>
<?php endforeach; ?>		
</select>
</td>
</tr>




<tr valign="top">
<th scope="row">Цвет скидки и рейтинга:</th>
<td colspan="2">

<div style="float:left">
<strong>Цвет скидки и рейтина</strong><br>
<input type="text" value="<?php if ( isset( $ab_woocommerce['rating_color'] ) ) echo $ab_woocommerce['rating_color']; ?>" class="my-color-field" name="rating_color"/>  
</div>

</td>
</tr>




</table>
</div>

<!-- Конец вкладки №1-->

<!-- Вкладки №2 - Витрина магазина - Общие настройки -->

<div id="fragment-2">
<style>table.table-border, table.table-border tr, table.table-border td {border:1px solid #ccc;} table.table-border td, table.table-border th {padding:20px;}.form-table, .form-table td, .form-table td p, .form-table th {border:1px solid #ccc; padding:20px;} .ui-checkboxradio-label .ui-icon-background {display:none}</style>


<!-- Вкладки №2 - Витрина магазина - Общие настройки -->

<table class="form-table" style="border:1px solid #ccc; width: 100%; padding:20px;">
<tr><td colspan="2" style="text-align:left"><h1><strong>Внешний вид Главной магазина</strong></h1></td></tr>

<tr><th style="width:20%"> Ширина/отступы</th>
<td style="width:80%;">

<div style="margin-right:20px; float:left">
<strong>Ширина уровней</strong><br><select name="homepage_width">
<?php foreach ( $ab_woocommerce_width as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['homepage_width'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>

<div style="float:left; margin-right:15px;">
<strong>Отступ сверху</strong><br>
<input type="text" size="7" name="margin_top" value="<?php if ( isset( $ab_woocommerce['margin_top'] ) ) echo $ab_woocommerce['margin_top']; ?>" /> 	
</div>

<div style="float:left;">
<strong>Отступ снизу</strong><br>
<input type="text" size="7" name="margin_bottom" value="<?php if ( isset( $ab_woocommerce['margin_bottom'] ) ) echo $ab_woocommerce['margin_bottom']; ?>" /> 	
</div>

<div style="clear:both"></div>
<br>
</td></tr>







<tr><th style="width:20%">Граница страницы</th>
<td style="width:80%">

<div style="margin-right:20px; float:left">
<input type="checkbox" name="homepage_border" value="1" <?php if ( $ab_woocommerce['homepage_border']) echo 'checked="checked"'; ?>>
<strong>Граница </strong><br><br>
</div>

<div style="float:left">
<strong>Цвет границы</strong><br>
<input type="text" value="<?php if ( isset( $ab_woocommerce['homepage_border_color'] ) ) echo $ab_woocommerce['homepage_border_color']; ?>" class="my-color-field" name="homepage_border_color"/>  
</div>	

<div style="float:left;">	
<strong>Закругления границы</strong><br>
<select name="homepage_border_round">
<?php foreach ( $ab_border_round as $border_r => $round_border ) : ?>
<option value="<?php echo $border_r; ?>" <?php if ( $ab_woocommerce['homepage_border_round'] == $border_r ) echo 'selected'; ?>><?php echo $round_border; ?></option>
<?php endforeach; ?>		
</select></div>	

</td></tr>

</table>

<!-- Конец вкладки №2 - Витрина магазина Общие настройки -->


<!-- Вкладка №2 - Витрина магазина - Аккордион -->
<div id="accordion">

<!-- Вкладка №2 - Витрина магазина - Рубрики -->
 
<h3>Рубрики товаров</h3>
<div>
<table class="form-table" style="background:#fff;width:100%; margin:0 auto; margin-bottom:20px; height:10px !important;">
<tr>
<th scope="row">Вид отображения</th>
<td>

<div>
<select name="cat_layout">
<?php foreach ( $cat_layout as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['cat_layout'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>
</td></tr>



	
<tr>
<th scope="row">Рубрики</th>
<td>

<div style="padding:10px 0; font-weight:bold">Рубрики (выберите 3 рубрики, которые будут отображаться на главной)</div>
<div style="float:left; margin-right:10px;">
<?php $categories_args = array('taxonomy' => 'product_cat', 'name' => 'hp_category1', 'selected' => $ab_woocommerce['hp_category1'], 'orderby' => 'Name', 'hierarchical' => 1, 'hide_empty' => '0', 'show_count' => 1); wp_dropdown_categories( $categories_args ); ?>
</div>

<div style="float:left; margin-right:10px;">
<?php $categories_args = array('taxonomy' => 'product_cat', 'name'  => 'hp_category2', 'selected' => $ab_woocommerce['hp_category2'], 'orderby' => 'Name', 'hierarchical' => 1, 'hide_empty' => '0', 'show_count' => 1); wp_dropdown_categories( $categories_args ); ?>
</div>

<div>
<?php $categories_args = array('taxonomy' => 'product_cat', 'name' => 'hp_category3', 'selected' => $ab_woocommerce['hp_category3'], 'orderby' => 'Name', 'hierarchical' => 1, 'hide_empty' => '0', 'show_count' => 1); wp_dropdown_categories( $categories_args ); ?>
</div>
</td></tr>
<tr>


<tr><th scope="row">Уровень</th>
<td>








<div><h4>Отступы внутри?</h4>
<select name="padding">
<?php foreach ( $padding as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['padding'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>

<div><h4>Отстуты снаружи сверху и снизу</h4>
<input type="text" size="5" name="padding_top1" value="<?php if ( isset( $ab_woocommerce['padding_top1'] ) ) echo $ab_woocommerce['padding_top1']; ?>" />

<input type="text" size="5" name="padding_bottom1" value="<?php if ( isset( $ab_woocommerce['padding_bottom1'] ) ) echo $ab_woocommerce['padding_bottom1']; ?>" />
</div>



<div><h4>Фон уровня</h4>

<input type="text" value="<?php if ( isset( $ab_woocommerce['bg_level2'] ) ) echo $ab_woocommerce['bg_level2']; ?>" class="my-color-field" name="bg_level2"/>  
</div>	
</td></tr>

<tr><td colspan="2"><h2>Изображение</h2></td></tr>


<tr><th scope="row">Граница</th>
<td>


<div style="float:left">
<h4>Отображение</h4>
<select name="border_static">
<?php foreach ( $border_static as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['border_static'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>

<div style="float:left; margin-left:10px;">
<h4>Прозрачность</h4>
<select name="border_opacity">
<?php foreach ( $border_opacity as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['border_opacity'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>


<div style="float:left; margin-right:10px;">
<h4>Толщина</h4>


<select name="image_border">
<?php foreach ( $image_border as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['image_border'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>



<div>
<h4>Цвет</h4>
<input type="text" value="<?php if ( isset( $ab_woocommerce['image_border_color'] ) ) echo $ab_woocommerce['image_border_color']; ?>" class="my-color-field" name="image_border_color"/>  
</div>

</td></tr>

<tr><th scope="row">Затемнение изображения</th>
<td>


<div style="float:left">
<h4>Отображение</h4>
<select name="bg_static">
<?php foreach ( $bg_static as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['bg_static'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>

<div style="float:left; margin-left:10px;">
<h4>Прозрачность</h4>
<select name="bg_cat_opacity">
<?php foreach ( $border_opacity_bg as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['bg_cat_opacity'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>

<div style="float:left; margin-left:10px;">
<h4>Цвет 1</h4>
<input type="text" value="<?php if ( isset( $ab_woocommerce['image_bg_color_hoverone'] ) ) echo $ab_woocommerce['image_bg_color_hoverone']; ?>" class="my-color-field" name="image_bg_color_hoverone"/>  
</div>

<div>
<h4>Цвет 2</h4>
<input type="text" value="<?php if ( isset( $ab_woocommerce['image_bg_color_hover'] ) ) echo $ab_woocommerce['image_bg_color_hover']; ?>" class="my-color-field" name="image_bg_color_hover"/>  
</div>
</td></tr>

<tr><td colspan="2"><h2>Текст</h2></td></tr>


<tr><th scope="row">Заголовок</th>
<td>

<div style="margin-right:20px;">
<input type="checkbox" name="show_cat_title" value="1" <?php if ( $ab_woocommerce['show_cat_title']) echo 'checked="checked"'; ?>>
<strong>Отключить показ заголовока (Да/нет)? </strong><br><br>
</div>






<div  style="float:left;">
<h4>Шрифт </h4>
<select name="category_headline_font">
<?php foreach ( $font_family as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['category_headline_font'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>


<div  style="float:left; margin-left:10px;">
<h4>Размер </h4>
<select name="category_headline_size">
<?php foreach ( $font_size as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['category_headline_size'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>


<div  style="float:left; margin-left:10px;">
<h4>Цвет </h4>
<input type="text" value="<?php if ( isset( $ab_woocommerce['category_headline_color'] ) ) echo $ab_woocommerce['category_headline_color']; ?>" class="my-color-field" name="category_headline_color"/>  
</div>

<div id="style-headline" style="float:left; margin-left:10px;">
<h4>Стиль </h4>
 <input type="checkbox" name="category_headline_strong" value="1" <?php if ( $ab_woocommerce['category_headline_strong']) echo 'checked="checked"'; ?> id="styletext-headline1"><label for="styletext-headline1"><strong>B</strong></label>
 <input type="checkbox" name="category_headline_italic" value="1" <?php if ( $ab_woocommerce['category_headline_italic']) echo 'checked="checked"'; ?> id="styletext-headline2"><label for="styletext-headline2"><i>I</i></label>
    
</div>
   <script>
  $( "#styletext-headline" ).button();
$( "#style-headline" ).buttonset();
</script> 


<div  style="float:left;margin-left:10px;">
<h4>Фон текста </h4>
<input type="text" value="<?php if ( isset( $ab_woocommerce['bg_text_cat'] ) ) echo $ab_woocommerce['bg_text_cat']; ?>" class="my-color-field" name="bg_text_cat"/>  
</div>

<div >
<h4>Прозрачность</h4>
<select name="bg_text_cat_opacily">
<?php foreach ( $border_opacity_text as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['bg_text_cat_opacily'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>

</td></tr>
	
<tr><th scope="row">Описание</th>
<td>
	
	<div style="margin-right:20px;">
<input type="checkbox" name="show_cat_desc" value="1" <?php if ( $ab_woocommerce['show_cat_desc']) echo 'checked="checked"'; ?>>
<strong>Отключить показ описания (Да/нет)? </strong><br><br>
</div>
<div  style="float:left">
<h4>Шрифт</h4>
<select name="category_desc_font">
<?php foreach ( $font_family as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['category_desc_font'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>

<div  style="float:left; margin-left:10px;">
<h4>Размер</h4>
<select name="category_desc_size">
<?php foreach ( $font_size as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['category_desc_size'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>

<div  style="float:left; margin-left:10px;">
<h4>Цвет</h4>
<input type="text" value="<?php if ( isset( $ab_woocommerce['category_desc_color'] ) ) echo $ab_woocommerce['category_desc_color']; ?>" class="my-color-field" name="category_desc_color"/>  
</div>

  <div id="style-headline2" style="float:left;margin-left:10px;">
<h4>Стиль </h4>
  <input type="checkbox" name="category_desc_strong" value="1" <?php if ( $ab_woocommerce['category_desc_strong']) echo 'checked="checked"'; ?> id="styletext-headline21"><label for="styletext-headline21"><strong>B</strong></label>
  <input type="checkbox" name="category_desc_italic" value="1" <?php if ( $ab_woocommerce['category_desc_italic']) echo 'checked="checked"'; ?> id="styletext-headline22"><label for="styletext-headline22"><i>I</i></label>  </div>
  
<script>
$( "#styletext-headline2" ).button();
$( "#style-headline2" ).buttonset();
</script>

</td></tr>
</table>
</div>


<!-- Вкладка №2 - Витрина магазина - Реклама -->


<h3>Реклама</h3>
<div>
<table class="form-table" style="background:#fff;width:100%; margin:0 auto; margin-bottom:20px; height:10px !important;">
<tr><th scope="row">Уровень</th>
<td>

<div><h4>Отступы внутри?</h4>
<select name="padding_level3">
<?php foreach ( $padding as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['padding_level3'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>

<div><h4>Отстуты снаружи сверху и снизу</h4>
<input type="text" size="5" name="padding_top3" value="<?php if ( isset( $ab_woocommerce['padding_top3'] ) ) echo $ab_woocommerce['padding_top3']; ?>" />

<input type="text" size="5" name="padding_bottom3" value="<?php if ( isset( $ab_woocommerce['padding_bottom3'] ) ) echo $ab_woocommerce['padding_bottom3']; ?>" />
</div>



<div><h4>Фон уровня</h4>

<input type="text" value="<?php if ( isset( $ab_woocommerce['bg_level3'] ) ) echo $ab_woocommerce['bg_level3']; ?>" class="my-color-field" name="bg_level3"/>  
</div>	

 
</td></tr>




<tr><th scope="row">Изображение</th>

<td>


<style>
.remove-slide-1
{background:url(<?php echo $imageurl; ?>ico-delete.png) no-repeat;
  width:16px;
   bottom:4px;
   display:block;
	float:left;
	padding:0;
	position:absolute;
	left:-4px;
	text-indent:-9999px;}
	
	
div.screen_slide_1
{float:left;
	margin-left:1px;
	position:relative;
	width:200px;
	margin-top:3px;
	}
	
div.screen_slide_1 img
{	
	background:#FAFAFA;
	border-color:#ccc #eee #eee #ccc;
	border-style:solid;
	border-width:1px;
	float:left;
	max-width:200px;
	padding:4px;
	margin-bottom:10px;
	}</style>
<script>
jQuery(document).ready(function($){
var custom_uploader;
$('.upload_bg_button_1').click(function(e) {
e.preventDefault();
if (custom_uploader) {
custom_uploader.open();
return;}
custom_uploader = wp.media.frames.file_frame = wp.media({
title: 'Choose Image',
button: {
text: 'Choose Image'
},
multiple: false
});
custom_uploader.on('select', function() {
attachment = custom_uploader.state().get('selection').first().toJSON();
$('.upload_bg_1').val(attachment.url);
$(".slide_1").after("<div class='screen_slide_1'><img src=" +attachment.url+" style='width:200px;'> <a class='remove-slide-1'>Remove</a></div>   ");
});
custom_uploader.open();
});
$( ".remove-slide-1" ).click(function() {
  $( ".screen_slide_1" ).hide("blind", { direction: "up" }, "slow");
  $(".upload_bg_1").val("");
});
});
</script>


<input id="image_ads" class="upload_bg_1" type="text" size="48" name="image_ads" value="<?php if ( isset( $ab_woocommerce['image_ads'] ) ) echo $ab_woocommerce['image_ads']; ?>" /> 
    <input id="custom_bg_upload" class="upload_bg_button_1" type="button" value="Загрузить" />
    <br> 
    
    
     <div class="slide_1"></div>
   
  <?php if ( $ab_woocommerce['image_ads'] != '' ) { echo '
		 <div class="screen_slide_1"><img src="'. $ab_woocommerce['image_ads'].'"><a class="remove-slide-1">Remove</a></div>';
		}?>
		
		

		
		
	<div style="clear:both;"></div>
</td></tr>

<tr><th scope="row">Текст</th>

<td>
<?php
// Enable font size & font family selects in the editor

if ( ! function_exists( 'wpex_mce_buttons' ) ) {
	function wpex_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'wpex_mce_buttons' );

// Customize mce editor font sizes
if ( ! function_exists( 'wpex_mce_text_sizes' ) ) {
	function wpex_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px 38px 40px 42px 44px 46px 48px 50px 52px 54px 56px 58px 60px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_text_sizes' );

// Add custom Fonts to the Fonts list
if ( ! function_exists( 'wpex_mce_google_fonts_array' ) ) {
	function wpex_mce_google_fonts_array( $initArray ) {
	    $initArray['font_formats'] = 'Arial=arial,helvetica,sans-serif;Verdana=verdana,geneva;Helvetica=helvetica;Tahoma=tahoma,arial,helvetica,sans-serif;Lucida Console=Lucida Console, Monaco, monospace;Open Sans=Open Sans;Open Sans Condensed=Open Sans Condensed;PT Sans Narrow=PT Sans Narrow;Trebuchet=Trebuchet;Georgia=georgia;Times New Roman=times;Palatino=palatino;Comic Sans MS=Comic Sans MS, cursive;Courier New=Courier New, monospace;Impact=Impact, Charcoal, sans-serif;Marck Script=Marck Script;Neucha=Neucha;Poiret One=Poiret One;Lobster=Lobster;Comfortaa=Comfortaa;Didact Gothic=Didact Gothic;Roboto=Roboto;Willamette SF=Willamette SF';
            return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_google_fonts_array' );

$content = $ab_woocommerce['hp_heading_level3'];
$editor_id = 'hp_heading_level3';
$settings = array(
'wpautop' => 1,
'media_buttons' => true,
'textarea_rows' => 5,

'tinymce' => array( 'toolbar1',
'toolbar2'

),
'quicktags' => array(
'buttons' => 'em,strong,close'
)
);


wp_editor( stripslashes($content), $editor_id, $settings);

?>

</td></tr>


<tr><th scope="row">Кнопка "Магазин"</th>
<td>


<div style="float:left"><h4>Цвет кнопки</h4>


<input type="text" value="<?php if ( isset( $ab_woocommerce['shop_button_homepage_ads'] ) ) echo $ab_woocommerce['shop_button_homepage_ads']; ?>" class="my-color-field" name="shop_button_homepage_ads"/> 
</div>

<div><h4>При наведении мышки</h4>

<input type="text" value="<?php if ( isset( $ab_woocommerce['shop_button_homepage_hover_ads'] ) ) echo $ab_woocommerce['shop_button_homepage_hover_ads']; ?>" class="my-color-field" name="shop_button_homepage_hover_ads"/>   
</div>




<div style="float:left"><h4>Цвет Текста</h4>
<input type="text" value="<?php if ( isset( $ab_woocommerce['shop_button_homepage_text_ads'] ) ) echo $ab_woocommerce['shop_button_homepage_text_ads']; ?>" class="my-color-field" name="shop_button_homepage_text_ads"/> 
</div>


<div><h4>При наведении мышки</h4>

<input type="text" value="<?php if ( isset( $ab_woocommerce['shop_button_homepage_text_hover_ads'] ) ) echo $ab_woocommerce['shop_button_homepage_text_hover_ads']; ?>" class="my-color-field" name="shop_button_homepage_text_hover_ads"/>   
</div>


<div style="float:left"><h4>Текст на кнопке</h4>

<input type="text" size="25" name="text_ads" value="<?php if ( isset( $ab_woocommerce['text_ads'] ) ) echo $ab_woocommerce['text_ads']; ?>" />   
</div>

<div><h4>Ссылка</h4>

<input type="text" size="25" name="link_ads" value="<?php if ( isset( $ab_woocommerce['link_ads'] ) ) echo $ab_woocommerce['link_ads']; ?>" />   
</div>


<div><strong>Расположение кнопки</strong><br>
<select name="button_align">
<?php foreach ( $button_align as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['button_align'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>



</td></tr>

</table>
</div>



<!-- Вкладка №2 - Витрина магазина - Товары -->

<h3>Уровнь с товарами</h3>

<div>
<table class="form-table">	

<tr><th scope="row">Отступы внутри</th>
<td>

<div><strong>Отстуты внутри</strong><br>
<select name="padding_level_featured">
<?php foreach ( $padding as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['padding_level_featured'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>




<div><h4>Отстуты снаружи сверху и снизу</h4>
<input type="text" size="5" name="padding_top_featured" value="<?php if ( isset( $ab_woocommerce['padding_top_featured'] ) ) echo $ab_woocommerce['padding_top_featured']; ?>" />

<input type="text" size="5" name="padding_bottom_featured" value="<?php if ( isset( $ab_woocommerce['padding_bottom_featured'] ) ) echo $ab_woocommerce['padding_bottom_featured']; ?>" />
</div>
</td></tr>


<tr><th>Фон уровня</th>
<td  colspan="3">
<div style="float:left; margin-right:20px;">
<strong>Фон уровня</strong><br><br>
<style>
.remove-slide-2
{background:url(<?php echo $imageurl; ?>ico-delete.png) no-repeat;
  width:16px;
   bottom:4px;
   display:block;
	float:left;
	padding:0;
	position:absolute;
	left:-4px;
	text-indent:-9999px;}
	
	
div.screen_slide_2
{float:left;
	margin-left:1px;
	position:relative;
	width:200px;
	margin-top:3px;
	}
	
div.screen_slide_2 img
{	
	background:#FAFAFA;
	border-color:#ccc #eee #eee #ccc;
	border-style:solid;
	border-width:1px;
	float:left;
	max-width:200px;
	padding:4px;
	margin-bottom:10px;
	}</style>
<script>
jQuery(document).ready(function($){
var custom_uploader;
$('.upload_bg_button_2').click(function(e) {
e.preventDefault();
if (custom_uploader) {
custom_uploader.open();
return;}
custom_uploader = wp.media.frames.file_frame = wp.media({
title: 'Choose Image',
button: {
text: 'Choose Image'
},
multiple: false
});
custom_uploader.on('select', function() {
attachment = custom_uploader.state().get('selection').first().toJSON();
$('.upload_bg_2').val(attachment.url);
$(".slide_2").after("<div class='screen_slide_2'><img src=" +attachment.url+" style='width:200px;'> <a class='remove-slide-2'>Remove</a></div>   ");
});
custom_uploader.open();
});
$( ".remove-slide-2" ).click(function() {
  $( ".screen_slide_2" ).hide("blind", { direction: "up" }, "slow");
  $(".upload_bg_2").val("");
});
});
</script>


<input id="custom_bg1" class="upload_bg_2" type="text" size="48" name="custom_bg1" value="<?php if ( isset( $ab_woocommerce['custom_bg1'] ) ) echo $ab_woocommerce['custom_bg1']; ?>" /> 
    <input id="custom_bg_upload" class="upload_bg_button_2" type="button" value="Загрузить" />
    <br> 
    
    
     <div class="slide_2"></div>
   
  <?php if ( $ab_woocommerce['custom_bg1'] != '' ) { echo '
		 <div class="screen_slide_2"><img src="'. $ab_woocommerce['custom_bg1'].'"><a class="remove-slide-2">Remove</a></div>';
		}?>
	

		
		
	<div style="clear:both;"></div>

	  <div style="margin-top:0px; float:left;">	
				<select name="hp_repeat_bg1">
				<?php foreach ( $repeat_bg as $repeat => $repear_r ) : ?>
				<option value="<?php echo $repeat; ?>" <?php if ( $ab_woocommerce['hp_repeat_bg1'] == $repeat ) echo 'selected'; ?>><?php echo $repear_r; ?></option>
			<?php endforeach; ?>		
					
					</select></div>	
					
					
					<div style="margin-top:0px; float:left;">	
				<select name="hp_repeat_position1">
				<?php foreach ( $repeat_position as $pos => $pos_rep ) : ?>
				<option value="<?php echo $pos; ?>" <?php if ( $ab_woocommerce['hp_repeat_position1'] == $pos ) echo 'selected'; ?>><?php echo $pos_rep; ?></option>
			<?php endforeach; ?>		
					
					</select></div>	
					
					
						<div style="margin-top:0px;">	
				<select name="background_size">
				<?php foreach ( $background_size as $pos => $pos_rep ) : ?>
				<option value="<?php echo $pos; ?>" <?php if ( $ab_woocommerce['background_size'] == $pos ) echo 'selected'; ?>><?php echo $pos_rep; ?></option>
			<?php endforeach; ?>		
					
					</select></div>	<br>


					
					
		<div style="float:left">
		<strong>Цвет фона</strong><br><br>
<input type="text" value="<?php if ( isset( $ab_woocommerce['hp_fon_color1'] ) ) echo $ab_woocommerce['hp_fon_color1']; ?>" class="my-color-field" name="hp_fon_color1"/>  </div></div></td></tr>





<tr><th scope="row">Текст</th>

<td>
<?php
// Enable font size & font family selects in the editor

if ( ! function_exists( 'wpex_mce_buttons' ) ) {
	function wpex_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'wpex_mce_buttons' );

// Customize mce editor font sizes
if ( ! function_exists( 'wpex_mce_text_sizes' ) ) {
	function wpex_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px 38px 40px 42px 44px 46px 48px 50px 52px 54px 56px 58px 60px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_text_sizes' );

// Add custom Fonts to the Fonts list
if ( ! function_exists( 'wpex_mce_google_fonts_array' ) ) {
	function wpex_mce_google_fonts_array( $initArray ) {
	    $initArray['font_formats'] = 'Arial=arial,helvetica,sans-serif;Verdana=verdana,geneva;Helvetica=helvetica;Tahoma=tahoma,arial,helvetica,sans-serif;Lucida Console=Lucida Console, Monaco, monospace;Open Sans=Open Sans;Open Sans Condensed=Open Sans Condensed;PT Sans Narrow=PT Sans Narrow;Trebuchet=Trebuchet;Georgia=georgia;Times New Roman=times;Palatino=palatino;Comic Sans MS=Comic Sans MS, cursive;Courier New=Courier New, monospace;Impact=Impact, Charcoal, sans-serif;Marck Script=Marck Script;Neucha=Neucha;Poiret One=Poiret One;Lobster=Lobster;Comfortaa=Comfortaa;Didact Gothic=Didact Gothic;Roboto=Roboto;Willamette SF=Willamette SF';
            return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_google_fonts_array' );

$content = $ab_woocommerce['featured_items_title'];
$editor_id = 'featured_items_title';
$settings = array(
'wpautop' => 1,
'media_buttons' => true,
'textarea_rows' => 5,

'tinymce' => array( 'toolbar1',
'toolbar2'

),
'quicktags' => array(
'buttons' => 'em,strong,close'
)
);


wp_editor( stripslashes($content), $editor_id, $settings);

?>

</td></tr>

<tr><th>Количество товаров</th>
<td>

<div style="margin-top:0px;">Количество товаров в ряд	
				<select name="items_number_featured">
				<?php foreach ( $items_number as $pos => $pos_rep ) : ?>
				<option value="<?php echo $pos; ?>" <?php if ( $ab_woocommerce['items_number_featured'] == $pos ) echo 'selected'; ?>><?php echo $pos_rep; ?></option>
			<?php endforeach; ?>		
					
					</select></div>	<br>
					
					<div style="margin-top:0px;">	Общее количество товаров
				<select name="cols_number_featured">
				<?php foreach ( $cols_number as $pos => $pos_rep ) : ?>
				<option value="<?php echo $pos; ?>" <?php if ( $ab_woocommerce['cols_number_featured'] == $pos ) echo 'selected'; ?>><?php echo $pos_rep; ?></option>
			<?php endforeach; ?>		
					
					</select></div>	

       
       
       </td></tr>


</table>
</div>




<!-- Вкладка №2 - Витрина магазина - Форма подписки -->

 <h3>Блок с формой подписки</h3>

<div>
<table class="form-table">	


<tr><th scope="row">Отступы снаружи</th>
<td>

<div><h4>Отстуты снаружи сверху и снизу</h4>
<input type="text" size="5" name="padding_top6" value="<?php if ( isset( $ab_woocommerce['padding_top6'] ) ) echo $ab_woocommerce['padding_top6']; ?>" />

<input type="text" size="5" name="padding_bottom6" value="<?php if ( isset( $ab_woocommerce['padding_bottom6'] ) ) echo $ab_woocommerce['padding_bottom6']; ?>" />
</div>
</td></tr>



<tr><th>Фон уровня</th>
<td  colspan="3">


		<div style="float:left">
		<strong>Цвет границы сверху</strong><br><br>
<input type="text" value="<?php if ( isset( $ab_woocommerce['border_top_form'] ) ) echo $ab_woocommerce['border_top_form']; ?>" class="my-color-field" name="border_top_form"/>  </div>
					
					
		<div style="float:left">
		<strong>Цвет фона</strong><br><br>
<input type="text" value="<?php if ( isset( $ab_woocommerce['bg_level6'] ) ) echo $ab_woocommerce['bg_level6']; ?>" class="my-color-field" name="bg_level6"/>  </div></td></tr>


<tr><td colspan="2" style="font-weight:bold; font-size:18px"> Настройка Автореспондера
</td></tr>


<tr><th scope="row">Автреспондер</th>
<td>



<?php if ( $ab_woocommerce['ab_sub_form_smart'] != '' ) {
				
					if ( $ab_woocommerce['ab_sub_form_smart'] == 1 ) {
						$selected1 = 'checkresponder';
						
				    }
				    
				    elseif ( $ab_woocommerce['ab_sub_form_smart'] == 2 ) {
						$selected2 = 'checkresponder';
						
				    }
				    
				    
				elseif   ( $ab_woocommerce['ab_sub_form_smart'] == 3 )  {
						$selected3 = 'checkresponder';
						
					
				}
				
				elseif   ( $ab_woocommerce['ab_sub_form_smart'] == 4 )  {
						$selected4 = 'checkresponder';
						
					
				}
				
				elseif   ( $ab_woocommerce['ab_sub_form_smart'] == 5 )  {
						$selected5 = 'checkresponder';
						
					
				}
				
				elseif   ( $ab_woocommerce['ab_sub_form_smart'] == 6 )  {
						$selected6 = 'checkresponder';
						
					
				}
				
					elseif   ( $ab_woocommerce['ab_sub_form_smart'] == 7 )  {
						$selected7 = 'checkresponder';
						
					
				}
				
				else  {
						$selected8 = 'checkresponder';
						
				    }


				} ?>
						 
						 
						 
						 
						 <input type="radio" id="responder1" name="ab_sub_form_smart" value="1" <?php if ( $ab_woocommerce['ab_sub_form_smart'] ==  '1' ) echo 'checked="checked"'; ?> /> <label>JustClick</label> <br>
						 <input type="radio" id="responder2" name="ab_sub_form_smart" value="2" <?php if ( $ab_woocommerce['ab_sub_form_smart'] ==  '2' ) echo 'checked="checked"'; ?> /> <label>GetResponse</label> <br>						 
						 
						 
						 <input type="radio" id="responder3" name="ab_sub_form_smart" value="3" <?php if ( $ab_woocommerce['ab_sub_form_smart'] ==  '3' ) echo 'checked="checked"'; ?> /> <label>Ссылка</label> <br>
						 
						 <input type="radio" id="responder4" name="ab_sub_form_smart" value="4" <?php if ( $ab_woocommerce['ab_sub_form_smart'] ==  '4' ) echo 'checked="checked"'; ?> /> <label>MailChimp</label> <br>

						 
						 <input type="radio" id="responder5" name="ab_sub_form_smart" value="5" <?php if ( $ab_woocommerce['ab_sub_form_smart'] ==  '5' ) echo 'checked="checked"'; ?> /> <label>UniSender</label> <br>
						 
						 <input type="radio" id="responder6" name="ab_sub_form_smart" value="6" <?php if ( $ab_woocommerce['ab_sub_form_smart'] ==  '6' ) echo 'checked="checked"'; ?> /> <label>AutoWebiOffice</label> <br>
						 
						 <input type="radio" id="responder7" name="ab_sub_form_smart" value="7" <?php if ( $ab_woocommerce['ab_sub_form_smart'] ==  '7' ) echo 'checked="checked"'; ?> /> <label>MailerLite</label> 
						 <br>	
						 
						  <input type="radio" id="responder8" name="ab_sub_form_smart" value="8" <?php if ( $ab_woocommerce['ab_sub_form_smart'] ==  '8' ) echo 'checked="checked"'; ?> /> <label>SendPulse</label> 


						
	</td></tr>	
						
						
						<tr valign="top">
						<th scope="row">Данные формы подписки или ссылки: </th>
						<td> 
						
		



<div id="div_name1" class="<?php echo $selected1; ?>" style="width:400px;display:none;">
						
						<div style="font-size:18px; float:left; width:108px; ">Логин </div><div style="font-size:18px; float:left; width:108px;">Маркер</div>  <div style="font-size:18px; float:left; width:108px;">Группа</div><br>
							<input type="text" name="ab_jc_login" value="<?php esc_attr_e($ab_woocommerce['ab_jc_login']); ?>" size="10"/>
							
							<input type="text" name="ab_jc_marker" value="<?php esc_attr_e($ab_woocommerce['ab_jc_marker']); ?>" size="10"/> 
							
							<input type="text" name="ab_jc_group" value="<?php esc_attr_e($ab_woocommerce['ab_jc_group']); ?>" size="10"/>
							<div style="margin-top:20px;">URL ПОСЛЕ ПОДПИСКИ</div>
							<input type="text" name="ab_jc_link_1" value="<?php esc_attr_e($ab_woocommerce['ab_jc_link_1']); ?>" size="40"/>
							<div style="margin-top:20px;">URL ПОСЛЕ АКТИВАЦИИ</div>
							<input type="text" name="ab_jc_link_2" value="<?php esc_attr_e($ab_woocommerce['ab_jc_link_2']); ?>" size="40"/>
							</div> 
							
							
							
							
							<div id="div_name2" class="<?php echo $selected2; ?>" style="width:400px; display:none;">
							
							<div style="font-size:14px; width:508px; ">
							
							<input type="checkbox" name="ab_form_old_form" value="1" <?php if ( $ab_woocommerce['ab_form_old_form'] ) echo 'checked="checked"'; ?> /><label> Поставьте галочку, если вы используете Новую форму</label> </div>
							<br><br>

						
						<div style="font-size:14px; width:208px; ">ID Формы (если форма старая), Токен кампании (если форма новая)  </div>
						
																				
							<input type="text" name="ab_formid" value="<?php esc_attr_e($ab_woocommerce['ab_formid']); ?>" size="30"/>
							
								<div style="font-size:14px; width:208px; ">Ссылка на страницу Спасибо (по-желанию)  </div>
							
							<input type="text" name="thankyou_page" value="<?php esc_attr_e($ab_woocommerce['thankyou_page']); ?>" size="30"/></div>
							
							

							
							
							<div id="div_name3" class="<?php echo $selected3; ?>" style="width:500px;display:none;">
						
						<div style="font-size:18px; width:208px; ">Ссылка на ресурс </div>
														
							<input type="text" name="ab_link_sub" value="<?php esc_attr_e($ab_woocommerce['ab_link_sub']); ?>" size="30"/>
							
							</div>
							
							
							<div id="div_name4" class="<?php echo $selected4; ?>" style="width:700px;display:none;">
						
						<div style="font-size:14px; float:left; width:145px; ">Логин</div><div style="font-size:14px; float:left; width:265px;">ID Профиля</div>  <div style="font-size:14px; float:left; width:108px;">ID Списка</div><br>
							<input type="text" name="ab_mc_login" value="<?php esc_attr_e($ab_woocommerce['ab_mc_login']); ?>" size="15"/>
							
							<input type="text" name="ab_mc_idprofile" value="<?php esc_attr_e($ab_woocommerce['ab_mc_idprofile']); ?>" size="30"/> 
							
							<input type="text" name="ab_mc_idlist" value="<?php esc_attr_e($ab_woocommerce['ab_mc_idlist']); ?>" size="15"/>
							</div>
							
							
							
							<div id="div_name5" class="<?php echo $selected5; ?>" style="width:700px;display:none;">
						
						<div style="font-size:14px; float:left; width:265px; ">Hash формы </div><div style="font-size:14px; float:left; width:145px;">ID списка</div><br>
							
							
							<input type="text" name="unisenderhash" value="<?php esc_attr_e($ab_woocommerce['unisenderhash']); ?>" size="30"/> 
							<input type="text" name="unisenderid" value="<?php esc_attr_e($ab_woocommerce['unisenderid']); ?>" size="15"/>
							
							
							</div>
							
							
							

							
							
							<div id="div_name6" class="<?php echo $selected6; ?>" style="width:700px;display:none;">
						
						<div style="font-size:14px; width:265px; ">Идентификатор  </div>
						
						<input type="text" name="loginautoweboffice" value="<?php esc_attr_e($ab_woocommerce['loginautoweboffice']); ?>" size="30"/><br><br>

						
						
						<div style="font-size:14px;  width:265px; ">ID Магазина  </div> 
						<input type="text" name="idautoweboffice" value="<?php esc_attr_e($ab_woocommerce['idautoweboffice']); ?>" size="30"/> <br><br>

						
						<div style="font-size:14px;  width:265px; ">ID Рассылки  </div>							
								
							<input type="text" name="idautowebofficepassylki" value="<?php esc_attr_e($ab_woocommerce['idautowebofficepassylki']); ?>" size="30"/> 
							
							</div>

							
							
							<div id="div_name7" class="<?php echo $selected7; ?>" style="width:700px;display:none;">
						
						<div style="font-size:14px; float:left; width:145px; ">ID формы </div><div style="font-size:14px; float:left; width:145px;">ID страницы</div> <div style="font-size:14px; float:left; width:265px;">Hash Статистики</div><br>
						
							
							
							<input type="text" name="idformmailerlite" value="<?php esc_attr_e($ab_woocommerce['idformmailerlite']); ?>" size="15"/> 
							<input type="text" name="idlandingmailerlite" value="<?php esc_attr_e($ab_woocommerce['idlandingmailerlite']); ?>" size="15"/>
							<input type="text" name="idstatistic" value="<?php esc_attr_e($ab_woocommerce['idstatistic']); ?>" size="30"/>
							<br><br>
							
							<div style="font-size:14px; float:left; width:400px;">Адрес страницы "Спасибо за подписку" (с http:// )</div><br>
							<input type="text" name="thankyoumailerlite" value="<?php esc_attr_e($ab_woocommerce['thankyoumailerlite']); ?>" size="50"/>

							
							</div>
							
							
							
							<div id="div_name8" class="<?php echo $selected8; ?>" style="width:700px;display:none;">
						
						<div style="font-size:14px; float:left; width:145px; ">ID формы </div><div style="font-size:14px; float:left; width:145px;">ID страницы</div> <div style="font-size:14px; float:left; width:265px;">Hash Статистики</div><br>
						
							
							
							<input type="text" name="idformsendpulse" value="<?php esc_attr_e($ab_woocommerce['idformsendpulse']); ?>" size="15"/> 
							<input type="text" name="idscriptsendpulse" value="<?php esc_attr_e($ab_woocommerce['idscriptsendpulse']); ?>" size="30"/>
							<input type="text" name="hashformsednpulse" value="<?php esc_attr_e($ab_woocommerce['hashformsednpulse']); ?>" size="15"/>
							
						

							
							</div>
							
							
							
	
	
							
							
							
						
</td>
</tr>


<tr><td colspan="2" style="font-weight:bold; font-size:18px"> Стиль кнопки
</td></tr>

<tr><th scope="row">Кнопка в форме подписки</th>
<td>


<div style="float:left"><h4>Цвет кнопки</h4>


<input type="text" value="<?php if ( isset( $ab_woocommerce['shop_button_homepage_form'] ) ) echo $ab_woocommerce['shop_button_homepage_form']; ?>" class="my-color-field" name="shop_button_homepage_form"/> 
</div>

<div><h4>При наведении мышки</h4>

<input type="text" value="<?php if ( isset( $ab_woocommerce['shop_button_homepage_hover_form'] ) ) echo $ab_woocommerce['shop_button_homepage_hover_form']; ?>" class="my-color-field" name="shop_button_homepage_hover_form"/>   
</div>





<div style="float:left"><h4>Цвет Текста</h4>
<input type="text" value="<?php if ( isset( $ab_woocommerce['shop_button_homepage_text_form'] ) ) echo $ab_woocommerce['shop_button_homepage_text_form']; ?>" class="my-color-field" name="shop_button_homepage_text_form"/> 
</div>


<div><h4>При наведении мышки</h4>

<input type="text" value="<?php if ( isset( $ab_woocommerce['shop_button_homepage_text_hover_form'] ) ) echo $ab_woocommerce['shop_button_homepage_text_hover_form']; ?>" class="my-color-field" name="shop_button_homepage_text_hover_form"/>   
</div>


<div style="float:left"><h4>Текст на кнопке</h4>

<input type="text" size="25" name="text_form_button" value="<?php if ( isset( $ab_woocommerce['text_form_button'] ) ) echo $ab_woocommerce['text_form_button']; ?>" />   
</div>


</td></tr>


<tr><td colspan="2" style="font-weight:bold; font-size:18px"> Стиль текста
</td></tr>


<tr><th scope="row">Текст</th>

<td>
<?php
// Enable font size & font family selects in the editor

if ( ! function_exists( 'wpex_mce_buttons' ) ) {
	function wpex_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'wpex_mce_buttons' );

// Customize mce editor font sizes
if ( ! function_exists( 'wpex_mce_text_sizes' ) ) {
	function wpex_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px 38px 40px 42px 44px 46px 48px 50px 52px 54px 56px 58px 60px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_text_sizes' );

// Add custom Fonts to the Fonts list
if ( ! function_exists( 'wpex_mce_google_fonts_array' ) ) {
	function wpex_mce_google_fonts_array( $initArray ) {
	    $initArray['font_formats'] = 'Arial=arial,helvetica,sans-serif;Verdana=verdana,geneva;Helvetica=helvetica;Tahoma=tahoma,arial,helvetica,sans-serif;Lucida Console=Lucida Console, Monaco, monospace;Open Sans=Open Sans;Open Sans Condensed=Open Sans Condensed;PT Sans Narrow=PT Sans Narrow;Trebuchet=Trebuchet;Georgia=georgia;Times New Roman=times;Palatino=palatino;Comic Sans MS=Comic Sans MS, cursive;Courier New=Courier New, monospace;Impact=Impact, Charcoal, sans-serif;Marck Script=Marck Script;Neucha=Neucha;Poiret One=Poiret One;Lobster=Lobster;Comfortaa=Comfortaa;Didact Gothic=Didact Gothic;Roboto=Roboto;Willamette SF=Willamette SF';
            return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_google_fonts_array' );

$content = $ab_woocommerce['form_title'];
$editor_id = 'form_title';
$settings = array(
'wpautop' => 1,
'media_buttons' => true,
'textarea_rows' => 5,

'tinymce' => array( 'toolbar1',
'toolbar2'

),
'quicktags' => array(
'buttons' => 'em,strong,close'
)
);


wp_editor( stripslashes($content), $editor_id, $settings);

?>

</td></tr>

	
	

	
</table>
</div>



<!-- Вкладка №2 - Витрина магазина - Отзывы -->

<h3>Отзывы</h3>
<div>
<table class="form-table">	

	<tr><th scope="row">Отступы </th>
<td>

<div><strong>Отстуты внутри</strong><br>
<select name="padding_level_testimonials">
<?php foreach ( $padding as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['padding_level_testimonials'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>



<div><h4>Отстуты снаружи сверху и снизу</h4>
<input type="text" size="5" name="padding_top5" value="<?php if ( isset( $ab_woocommerce['padding_top5'] ) ) echo $ab_woocommerce['padding_top5']; ?>" />

<input type="text" size="5" name="padding_bottom5" value="<?php if ( isset( $ab_woocommerce['padding_bottom5'] ) ) echo $ab_woocommerce['padding_bottom5']; ?>" />
</div>

</td></tr>


<tr><th>Фон уровня</th>
<td  colspan="3">
<div style="float:left; margin-right:20px;">
<strong>Фон уровня</strong><br><br>
<style>
.remove-slide-5
{background:url(<?php echo $imageurl; ?>ico-delete.png) no-repeat;
  width:16px;
   bottom:4px;
   display:block;
	float:left;
	padding:0;
	position:absolute;
	left:-4px;
	text-indent:-9999px;}
	
	
div.screen_slide_5
{float:left;
	margin-left:1px;
	position:relative;
	width:200px;
	margin-top:3px;
	}
	
div.screen_slide_5 img
{	
	background:#FAFAFA;
	border-color:#ccc #eee #eee #ccc;
	border-style:solid;
	border-width:1px;
	float:left;
	max-width:200px;
	padding:4px;
	margin-bottom:10px;
	}</style>
<script>
jQuery(document).ready(function($){
var custom_uploader;
$('.upload_bg_button_5').click(function(e) {
e.preventDefault();
if (custom_uploader) {
custom_uploader.open();
return;}
custom_uploader = wp.media.frames.file_frame = wp.media({
title: 'Choose Image',
button: {
text: 'Choose Image'
},
multiple: false
});
custom_uploader.on('select', function() {
attachment = custom_uploader.state().get('selection').first().toJSON();
$('.upload_bg_5').val(attachment.url);
$(".slide_5").after("<div class='screen_slide_5'><img src=" +attachment.url+" style='width:200px;'> <a class='remove-slide-5'>Remove</a></div>   ");
});
custom_uploader.open();
});
$( ".remove-slide-5" ).click(function() {
  $( ".screen_slide_5" ).hide("blind", { direction: "up" }, "slow");
  $(".upload_bg_5").val("");
});
});
</script>


<input id="custom_bg5" class="upload_bg_5" type="text" size="48" name="custom_bg5" value="<?php if ( isset( $ab_woocommerce['custom_bg5'] ) ) echo $ab_woocommerce['custom_bg5']; ?>" /> 
    <input id="custom_bg_upload" class="upload_bg_button_5" type="button" value="Загрузить" />
    <br> 
    
    
     <div class="slide_5"></div>
   
  <?php if ( $ab_woocommerce['custom_bg5'] != '' ) { echo '
		 <div class="screen_slide_5"><img src="'. $ab_woocommerce['custom_bg5'].'"><a class="remove-slide-5">Remove</a></div>';
		}?>
	

		
		
	<div style="clear:both;"></div>

	  <div style="margin-top:0px; float:left;">	
				<select name="hp_repeat_bg5">
				<?php foreach ( $repeat_bg as $repeat => $repear_r ) : ?>
				<option value="<?php echo $repeat; ?>" <?php if ( $ab_woocommerce['hp_repeat_bg5'] == $repeat ) echo 'selected'; ?>><?php echo $repear_r; ?></option>
			<?php endforeach; ?>		
					
					</select></div>	
					
					
					<div style="margin-top:0px; float:left;">	
				<select name="hp_repeat_position5">
				<?php foreach ( $repeat_position as $pos => $pos_rep ) : ?>
				<option value="<?php echo $pos; ?>" <?php if ( $ab_woocommerce['hp_repeat_position5'] == $pos ) echo 'selected'; ?>><?php echo $pos_rep; ?></option>
			<?php endforeach; ?>		
					
					</select></div>	
					
					
						<div style="margin-top:0px;">	
				<select name="background_size5">
				<?php foreach ( $background_size as $pos => $pos_rep ) : ?>
				<option value="<?php echo $pos; ?>" <?php if ( $ab_woocommerce['background_size5'] == $pos ) echo 'selected'; ?>><?php echo $pos_rep; ?></option>
			<?php endforeach; ?>		
					
					</select></div>	<br>


					
					
		<div style="float:left">
		<strong>Цвет фона</strong><br><br>
<input type="text" value="<?php if ( isset( $ab_woocommerce['bg_level5'] ) ) echo $ab_woocommerce['bg_level5']; ?>" class="my-color-field" name="bg_level5"/>  </div></div></td></tr>





<tr><th scope="row">Граница</th>
<td>



<div style="float:left; margin-right:10px;">
<h4>Толщина</h4>


<select name="otzyvy_border">
<?php foreach ( $image_border as $hp => $hpl) : ?>
<option value="<?php echo $hp; ?>" <?php if ( $ab_woocommerce['otzyvy_border'] == $hp ) echo 'selected'; ?>><?php echo $hpl; ?></option>
<?php endforeach; ?>		
</select>
</div>



<div>
<h4>Цвет</h4>
<input type="text" value="<?php if ( isset( $ab_woocommerce['otzyvy_border_color'] ) ) echo $ab_woocommerce['otzyvy_border_color']; ?>" class="my-color-field" name="otzyvy_border_color"/>  
</div>

</td></tr>



<tr><th scope="row">Текст</th>

<td>
<?php
// Enable font size & font family selects in the editor

if ( ! function_exists( 'wpex_mce_buttons' ) ) {
	function wpex_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'wpex_mce_buttons' );

// Customize mce editor font sizes
if ( ! function_exists( 'wpex_mce_text_sizes' ) ) {
	function wpex_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px 38px 40px 42px 44px 46px 48px 50px 52px 54px 56px 58px 60px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_text_sizes' );

// Add custom Fonts to the Fonts list
if ( ! function_exists( 'wpex_mce_google_fonts_array' ) ) {
	function wpex_mce_google_fonts_array( $initArray ) {
	    $initArray['font_formats'] = 'Arial=arial,helvetica,sans-serif;Verdana=verdana,geneva;Helvetica=helvetica;Tahoma=tahoma,arial,helvetica,sans-serif;Lucida Console=Lucida Console, Monaco, monospace;Open Sans=Open Sans;Open Sans Condensed=Open Sans Condensed;PT Sans Narrow=PT Sans Narrow;Trebuchet=Trebuchet;Georgia=georgia;Times New Roman=times;Palatino=palatino;Comic Sans MS=Comic Sans MS, cursive;Courier New=Courier New, monospace;Impact=Impact, Charcoal, sans-serif;Marck Script=Marck Script;Neucha=Neucha;Poiret One=Poiret One;Lobster=Lobster;Comfortaa=Comfortaa;Didact Gothic=Didact Gothic;Roboto=Roboto;Willamette SF=Willamette SF';
            return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_google_fonts_array' );

$content = $ab_woocommerce['testimonials_title'];
$editor_id = 'testimonials_title';
$settings = array(
'wpautop' => 1,
'media_buttons' => true,
'textarea_rows' => 5,

'tinymce' => array( 'toolbar1',
'toolbar2'

),
'quicktags' => array(
'buttons' => 'em,strong,close'
)
);


wp_editor( stripslashes($content), $editor_id, $settings);

?>





 
	 
</td></tr></table>
</div>










</div></div>

     
 

 
<div id="fragment-4">
<table class="form-table">	



<tr valign="top">
<th scope="row">Бесплатная доставка:</th>
<td colspan="2">
Поставьте галочку, если есть бесплатная доставка, другие варианты доставок не отображались.  
<div style="margin-right:20px; float:left">
<input type="checkbox" name="checkout_free_shipping" value="1" <?php if ( $ab_woocommerce['checkout_free_shipping']) echo 'checked="checked"'; ?>>

</div>





</td></tr>




  <tr valign="top">
<th scope="row">Где отображать корзину:</th>
<td colspan="2">

 <select name="menu" class="font_select">
<?php foreach ( $menu as $a => $b ) : ?>
<option value="<?php echo $a; ?>" <?php if ( $ab_woocommerce['menu'] == $a ) echo 'selected'; ?>><?php echo $b; ?></option>
<?php endforeach; ?>		
</select>





</td></tr>




</table></div>



 
 

 </div>
	
	<div style="padding-top:20px;">
					

<div style="float:right"><input type="submit" value="Сохранить настройки" class="button1 button-primary" name="submit" /></div>
</div>
						         						   
        </form>
        
        <form method="post" action="">
		<div style="text-align:left;paddingp-top:10px;">
			<input type="submit" name="update" id="reset" onClick="return confirmDefaults();" class="button-secondary" value="Сбросить настройки" />
			<input type="hidden" name="action" value="reset" />
		</div>
	</form>
        
        
     </div>

<?php
}
}