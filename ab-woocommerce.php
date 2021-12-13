<?php
/*
Plugin Name: AB WooCommerce
Version: 2.17
Plugin URI: http://anfisabreus.ru/
Description: Плагин интеграции интернет магазина "WooCommerce" 
Author: Анфиса Бреус
Author URI: http://anfisabreus.ru/
Text Domain: abwoocommerce
Domain Path: /languages
*/


function an_woocommerce_translation() {
    load_plugin_textdomain( 'abwoocommerce', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'an_woocommerce_translation' );

function script_woocommerce_top()  {
global $ab_woocommerce;

}

add_action( 'wp_enqueue_scripts', 'script_woocommerce_top' );


function ab_woocomerce_js(){
       wp_enqueue_script('jquery-ui-hp', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.min.js', array('jquery'), true); 
        }


add_action( 'wp_enqueue_scripts', 'ab_woocomerce_js' );




require_once dirname( __FILE__ ) .'/woocommerce-functions.php';
require_once dirname( __FILE__ ) .'/options.php';
require_once dirname( __FILE__ ) .  '/template-tags.php';



/**
 * Homepage
 * @see  abinspiration_homepage_content()
 * @see  abinspiration_product_categories()
 * @see  abinspiration_recent_products()
 * @see  abinspiration_featured_products()
 * @see  abinspiration_popular_products()
 * @see  abinspiration_on_sale_products()
 */

add_action( 'homepage', 'abinspiration_product_categories',	10 );
add_action( 'homepage', 'abinspiration_homepage_ads',	20 );
add_action( 'homepage', 'abinspiration_featured_products',	30 );
add_action( 'homepage', 'abinspiration_homepage_form',	40 );

add_action( 'homepage', 'abinspiration_homepage_reviews',	50 );
add_action( 'homepage', 'abinspiration_homepage_content',	60 );
/* add_action( 'homepage', 'abinspiration_homepage_posts',	60 ); */



add_action( 'woocommerce_single_product_summary', 'abinspiration_social_icons', 50 );


function script_ab_woocommerce()  {
wp_enqueue_style( 'ab-woocommerce-shop', plugins_url('woocommerce.css' , __FILE__ ), array( 'woocommerce-general', 'woocommerce-layout' )); 
} 



add_action( 'wp_enqueue_scripts', 'script_ab_woocommerce' );

function woocommerce_default_settings(){
$imageurl =  get_bloginfo('url') .'/wp-content/plugins/ab-woocommerce/images/';
$defaults = array(
'menu' => '2',
'items_number' => '3',
'sidebar' => '1',
'testimonials_title'   => '<p style="text-align: center;"><span style="font-size: 32px; font-family: arial; color: #000000;">'.  __( 'Отзывы покупателей', 'abwoocommerce' ) .' </span></p>', 
'homepage_border_round' => '0',
'homepage_border' => '0',
'homepage_border_color' => '#f7f9f9',
'margin_top' => '0',
'margin_bottom' => '0',
'homepage_width' => '1200px',
'bg_level2' => '#ffffff',
'bg_level3' => '#FFCB03',
'bg_level5' => '',
'bg_level6' => '#0399CD',
'featured_items_title' => '<p style="font-size: 32px; text-align: center;"><span style="color: #333333; font-family: arial;">'.  __( 'Наши товары', 'abwoocommerce' ) .'</span></p>',
'padding_bottom1' => '30', 
'padding_top1' => '30', 
'padding' => '2',     
'shop_button_homepage_hover' => '#0399CD',       
'shop_button_homepage_text' => '#ffffff',   
'shop_button_homepage_text_hover' => '#ffffff',
'border_static' => '2',
'border_opacity' => '.1',
'image_border' => '10px',
'image_border_color' => '#0399CD',
'bg_static' => '0',
'bg_cat_opacity' => '.1',
'image_bg_color_hoverone' => '#000000',
'image_bg_color_hover' => '#0399CD',
'category_headline_font' => 'arial',
'category_headline_size' => '50',
'category_headline_color' => '#ffffff',
'category_headline_strong' => 0,
'category_headline_italic' => 0,
'bg_text_cat' => '#000000',
'bg_text_cat_opacily' => '.5',
'category_desc_font' => 'arial',
'category_desc_size' => '18',
'category_desc_color' => '#ffffff',
'category_desc_strong' => 0,
'category_desc_italic' => 0,
'padding_level3' => '1',
'padding_top3' => '20',
'padding_bottom3' => '0',
'image_ads' => $imageurl.'shop2017.gif',
'hp_heading_level3' => '<p style="font-size: 32px;"><span style="color: #ffffff; font-family: arial;">'.  __( 'Мега Распродажа', 'abwoocommerce' ) .'</span></p>
<p style="font-size: 20px;"><span style="color: #ffffff; font-family: arial;">'.  __( 'отличное предложение скидка 50% со всех товаров в магазине', 'abwoocommerce' ) .'</span></p>',
'shop_button_homepage_ads' => '#0399CD',
'shop_button_homepage_hover_ads' => '#000000',
'shop_button_homepage_text_ads' => '#ffffff',
'shop_button_homepage_text_hover_ads' => '#ffffff',
'text_ads' => 'Перейти в магазин',
'link_ads' => '',
'padding_level_featured' => '2',
'padding_top_featured' => '30',
'padding_bottom_featured' => '0',
'background_size' => 'initial',
'custom_bg1' => '',
'hp_repeat_bg1' => 'repeat-x',
'hp_repeat_position1' => 'top center',
'hp_fon_color1' => '#ffffff',
'background_size5' => 'initial',
'custom_bg5' => '',
'hp_repeat_bg5' => 'repeat-x',
'hp_repeat_position5' => 'top center',
'items_number_featured' => '4',
'cols_number_featured' => '4',
'padding_bottom5' => '30',
'padding_top5' => '0',
'padding_bottom6' => '30',
'padding_top6' => '30',
'border_top_form' => '#000000',
'form_title' => '<p style="font-size: 32px;"><span style="color: #ffffff; font-family: arial;">'.  __( 'Получите скидку!', 'abwoocommerce' ) .'</span></p>
<p style="font-size: 18px;"><span style="color: #ffffff; font-family: arial;">'.  __( 'Введите ваш Email и вы получите купон на скидку', 'abwoocommerce' ) .'</span></p>',
'shop_button_homepage_form' => '#FFCB03',
'shop_button_homepage_hover_form' => '#000000',
'shop_button_homepage_text_form' => '#ffffff',
'shop_button_homepage_text_hover_form' => '#ffffff',
'text_form_button' =>   __( 'Получить скидку!', 'abwoocommerce' ),
'otzyvy_border_color' => '#0399CD',
'otzyvy_border' => '3px',
'ab_sub_form_smart' => '7',
'rating_color' => '#0399cd',
'font_size_items' => '20',
'cat_layout' => '1',
'button_align' => '1',
'checkout_free_shipping' => '0',
'show_cat_product' => '1',
'related_product_text' =>  __( 'Похожие товары', 'abwoocommerce' ),
'show_cat_desc' => 0,
'show_cat_title' => 0



);
return $defaults;
}
$defaults = woocommerce_default_settings();
add_option( 'ab_woocommerce', $defaults );
$ab_woocommerce = wp_parse_args(get_option('ab_woocommerce'), $defaults);

function update_woocommerce_options() {

	$ab_woocommerce = get_option( 'ab_woocommerce' );

	if ( isset($_GET['page']) && $_GET['page'] == 'ab-woocommerce-option' ) {

	if ( isset($_REQUEST['action']) && 'reset' == $_REQUEST['action'] ) {

			$defaults = woocommerce_default_settings(); // Store defaults in an array
			update_option( 'ab_woocommerce', $defaults ); // Write defaults to database
			wp_safe_redirect( add_query_arg('reset', 'true') );
			die;

		}
	}

	register_setting( 'update-options', 'ab_woocommerce' );

}
add_action( 'admin_init', 'update_woocommerce_options' );



/**
 * Query WooCommerce activation
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		return class_exists( 'woocommerce' ) ? true : false;
	}
}


/**
 * Call a shortcode function by tag name.
 *
 * @since  1.4.6
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function abinspiration_do_shortcode( $tag, array $atts = array(), $content = null ) {

	global $shortcode_tags;

	if ( ! isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	}

	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}



// Updates the unique option id in the database if it has changed
	if ( function_exists( 'woocommerce_option_name' ) ) {
		woocommerce_option_name();
	}
	elseif ( has_action( 'woocommerce_option_name' ) ) {
		do_action( 'woocommerce_option_name' );
	}
/*************Licence****************/


define( 'EDD_WOOCOMMERCE_STORE_URL', 'https://ab-inspiration.com' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file
define( 'EDD_WOOCOMMERCE_PLUGIN_LICENSE_PAGE', 'ab-licence-woocommerce-page' );
define( 'EDD_WOOCOMMERCE_ITEM_ID', 559 );
define( 'EDD_WOOCOMMERCE_ITEM_NAME', 'AB Woocommerce' );

if( !class_exists( 'EDD_WOOCOMMERCE_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/EDD_WOOCOMMERCE_Plugin_Updater.php' );
}

// retrieve our license key from the DB

function edd_woocommerce_plugin_updater() {

	// retrieve our license key from the DB
	$license_key = trim( get_option( 'edd_woocommerce_license_key' ) );

	// setup the updater
	$edd_updater = new EDD_WOOCOMMERCE_Plugin_Updater( EDD_WOOCOMMERCE_STORE_URL, __FILE__,
		array(
			'version' => '2.17',                    // current version number
			'license' => $license_key,             // license key (used get_option above to retrieve from DB)
			'item_id' => EDD_WOOCOMMERCE_ITEM_ID,       // ID of the product
			'author'  => 'Anfisa Breus', // author of this plugin
			'url'           => home_url()
		)
	);

}
add_action( 'admin_init', 'edd_woocommerce_plugin_updater', 0 );
