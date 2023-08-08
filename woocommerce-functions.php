<?php add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
 
 
add_filter( 'woocommerce_locate_template', 'ab_woo_adon_plugin_template', 1, 3 );
   function ab_woo_adon_plugin_template( $template, $template_name, $template_path ) {
     global $woocommerce;
     $_template = $template;
     if ( ! $template_path ) 
        $template_path = $woocommerce->template_url;
 
     $plugin_path  = untrailingslashit( plugin_dir_path( __FILE__ ) )  . '/woocommerce/';
 
    // Look within passed path within the theme - this is priority
    $template = locate_template(
    array(
      $template_path . $template_name,
      $template_name
    )
   );
 
   if( ! $template && file_exists( $plugin_path . $template_name ) )
    $template = $plugin_path . $template_name;
 
   if ( ! $template )
    $template = $_template;

   return $template;
}



add_filter('woocommerce_sale_flash', 'avia_change_sale_content', 10, 3);
function avia_change_sale_content($content, $post, $product){
$content = '<span class="onsale">'.__( 'Скидка', 'abwoocommerce' ).'</span>';
return $content;
}

 

// Display 24 products per page. Goes in functions.php


add_filter('loop_shop_per_page', function($cols) {return 24;});



add_filter( 'woocommerce_show_page_title' , 'woo_hide_page_title' );

function woo_hide_page_title() {
	
	return false;
	
}


/*-------------------------------
 Override woocommerce product categories widgets
---------------------------------*/

add_action( 'widgets_init', 'override_woocommerce_widgets', 15 );

function override_woocommerce_widgets() {
  // Ensure our parent class exists to avoid fatal error

    if ( class_exists( 'WC_Widget_Price_Filter' ) ) {
    unregister_widget( 'WC_Widget_Price_Filter' );

    include_once( 'woocommerce/custom-widgets/ab-class-wc-widget-price-filter.php' ); 
//or 
//include get_template_directory() . '/inc/custom-widgets/fengo-class-wc-widget-price-filter.php';

    register_widget( 'AB_WC_Widget_Price_Filter' );
  }    

}

add_filter( 'get_product_search_form' , 'woo_custom_product_searchform' );

/**
 * woo_custom_product_searchform
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
function woo_custom_product_searchform( $form ) {
	
	$form = '<form role="search" method="get" class="woocommerce-product-search form-search" action="'. esc_url( home_url( '/'  ) ).'">
	
	<div class="input-group">

	<input type="search" id="woocommerce-product-search-field" class="search-field form-control search-query input1" placeholder="' . __( 'Поиск товаров', 'abwoocommerce' ) . '" value="' . get_search_query() . '" name="s" title="Search for" />
	<span class="input-group-btn">
	<button type="submit" class="btn btn-default" id="searchsubmit" value="'. esc_attr__( 'Найти', 'abwoocommerce' ) .'" /><i class="fa fa-search"></i></button></span>
	<input type="hidden" name="post_type" value="product" />
	</div>
</form>';
	
return $form;
	}



function abwoocommerce_template_loop_category_link_open( $category ) {
	echo '<a href="'. get_term_link( $category, 'product_cat' ) .'" class="tm_banners_grid_widget_banner_link">';
}
add_filter( 'abwoocommerce_before_subcategory', 'abwoocommerce_template_loop_category_link_open', 10 );




function abinspiration_shop_loop_subcategory_title( $category ) {

	if (is_page_template('template-homepage.php')) {	?>
	
		
		<div class="cat-title-homepage">
		<span class="cat-title-bg">
			<?php
				echo $category->name; ?> </span>

<?php 				
$cat_id=$category->term_id;
$prod_term=get_term($cat_id,'product_cat');
$description=$prod_term->description;
if ($description !=='') {
echo '<div class="shop_cat_desc"><span class="cat-desc-bg">'.$description.'</span></div>'; }?>
</div><div class="button-homepage"> <?php _e('Магазин', 'abwoocommerce'); ?></div>
		
		<?php
		}

	}
	
	add_action('abinspiration_shop_loop_subcategory_title', 'abinspiration_shop_loop_subcategory_title', 10);
	
	
	//Display product category descriptions under category image/title on woocommerce shop page */


add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'RUB': $currency_symbol = '&#x20bd;'; break;
          case 'UAH': $currency_symbol = '&#8372;'; break;
          
          
     }
     return $currency_symbol;
}





function custom_override_checkout_fields( $fields ) {
global $ab_woocommerce;
if ($ab_woocommerce['checkout_address_show'] == '2' ): 
unset($fields['billing']['billing_company']);
unset($fields['billing']['billing_address_1']);
unset($fields['billing']['billing_address_2']);
unset($fields['billing']['billing_city']);
unset($fields['billing']['billing_postcode']);
unset($fields['billing']['billing_country']);
unset($fields['billing']['billing_state']);
return $fields;
else:
return $fields;


endif;

}
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields_shipping( $fields ) {
unset($fields['company']['shipping_company']);
return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );








add_action( 'woocommerce_after_shop_loop_item_title', 'avia_add_product_cat', 1);

function avia_add_product_cat()
{
global $ab_woocommerce;
if ($ab_woocommerce['show_cat_product'] == '1' ):  

    global $product;
    $product_cats = wp_get_post_terms($product->id, 'product_cat');
    $count = count($product_cats); ?> 
    <div style="padding:0 20px;"> <?php
    foreach($product_cats as $key => $cat)
    { 
        echo $cat->name;
        if($key < ($count-1))
        {
        
            echo ', ';
            
        }
        else
        {
            echo '<br/><br/>';
        } 
    } ?> </div><?php
    endif;
}





if (  ! function_exists( 'ab_template_loop_category_title' ) ) {

	/**
	 * Show the subcategory title in the product loop.
	 */
	function ab_template_loop_category_title( $category ) {
		?>
		<h3>
			<?php
				echo $category->name;

				if ( $category->count > 0 )
					echo apply_filters( 'ab_template_loop_category_title', ' <mark class="count">(' . $category->count . ')</mark>', $category );
			?>
		</h3>
		<?php
	}
}


include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// check for plugin using plugin name
if ( !is_plugin_active( 'wc-edostavka/wc-edostavka.php' )) {
  //plugin is activated



add_filter( 'woocommerce_states', 'ab_custom_woocommerce_states' );
 function ab_custom_woocommerce_states( $states ) {
  $states['RU'] = array(
    'MSK' => __('Москва', 'abwoocommerce'),
    'SPB' => __('Санкт-Петербург', 'abwoocommerce'),
    'NOV' => __('Новосибирск', 'abwoocommerce'),
    'EKB' => __('Екатеринбург', 'abwoocommerce'),
    'NN' => __('Нижний Новгород', 'abwoocommerce'),
    'KZN' => __('Казань', 'abwoocommerce'),
    'CHL' => __('Челябинск', 'abwoocommerce'),
    'OMSK' => __('Омск', 'abwoocommerce'),
    'SMR' => __('Самара', 'abwoocommerce'),
    'RND' => __('Ростов-на-Дону', 'abwoocommerce'),
    'UFA' => __('Уфа', 'abwoocommerce'),
    'PRM' => __('Пермь', 'abwoocommerce'),
    'KRN' => __('Красноярск', 'abwoocommerce'),
    'VRZH' => __('Воронеж', 'abwoocommerce'),
    'VLG' => __('Волгоград', 'abwoocommerce'),
    'SIMF' => __('Симферополь', 'abwoocommerce'),
    'ABAO' => __('Агинский Бурятский авт.окр.', 'abwoocommerce'),
    'AR' => __('Адыгея Республика', 'abwoocommerce'),
    'ALR' => __('Алтай Республика', 'abwoocommerce'),
    'AK' => __('Алтайский край', 'abwoocommerce'),
    'AMO' => __('Амурская область', 'abwoocommerce'),
    'ARO' => __('Архангельская область', 'abwoocommerce'),
    'ACO' => __('Астраханская область', 'abwoocommerce'),
    'BR' => __('Башкортостан республика', 'abwoocommerce'),
    'BEO' => __('Белгородская область', 'abwoocommerce'),
    'BRO' => __('Брянская область', 'abwoocommerce'),
    'BUR' => __('Бурятия республика', 'abwoocommerce'),
    'VLO' => __('Владимирская область', 'abwoocommerce'),
    'VOO' => __('Волгоградская область', 'abwoocommerce'),
    'VOLGO' => __('Вологодская область', 'abwoocommerce'),
    'VORO' => __('Воронежская область', 'abwoocommerce'),
    'DR' => __('Дагестан республика', 'abwoocommerce'),
    'EVRAO' => __('Еврейская авт. область', 'abwoocommerce'),
    'IO' => __('Ивановская область', 'abwoocommerce'),
    'IR' => __('Ингушетия республика', 'abwoocommerce'),
    'IRO' => __('Иркутская область', 'abwoocommerce'),
    'KBR' => __('Кабардино-Балкарская республика', 'abwoocommerce'),
    'KNO' => __('Калининградская область', 'abwoocommerce'),
    'KMR' => __('Калмыкия республика', 'abwoocommerce'),
    'KLO' => __('Калужская область', 'abwoocommerce'),
    'KMO' => __('Камчатская область', 'abwoocommerce'),
    'KCHR' => __('Карачаево-Черкесская республика', 'abwoocommerce'),
    'KR' => __('Карелия республика', 'abwoocommerce'),
    'KEMO' => __('Кемеровская область', 'abwoocommerce'),
    'KIRO' => __('Кировская область', 'abwoocommerce'),
    'KOMI' => __('Коми республика', 'abwoocommerce'),
    'KPAO' => __('Коми-Пермяцкий авт. окр.', 'abwoocommerce'),
    'KRAO' => __('Корякский авт.окр.', 'abwoocommerce'),
    'KOSO' => __('Костромская область', 'abwoocommerce'),
    'KRSO' => __('Краснодарский край', 'abwoocommerce'),
    'KRNO' => __('Красноярский край', 'abwoocommerce'),
    'KRYM' => __('Крым Республика', 'abwoocommerce'),
    'KURGO' => __('Курганская область', 'abwoocommerce'),
    'KURO' => __('Курская область', 'abwoocommerce'),
    'LENO' => __('Ленинградская область', 'abwoocommerce'),
    'LPO' => __('Липецкая область', 'abwoocommerce'),
    'MAGO' => __('Магаданская область', 'abwoocommerce'),
    'MER' => __('Марий Эл республика', 'abwoocommerce'),
    'MOR' => __('Мордовия республика', 'abwoocommerce'),
    'MSKO' => __('Московская область', 'abwoocommerce'),
    'MURO' => __('Мурманская область', 'abwoocommerce'),
    'NAO' => __('Ненецкий авт.окр.', 'abwoocommerce'),
    'NZHO' => __('Нижегородская область', 'abwoocommerce'),
    'NVGO' => __('Новгородская область', 'abwoocommerce'),
    'NVO' => __('Новосибирская область', 'abwoocommerce'),
    'OMO' => __('Омская область', 'abwoocommerce'),
    'OPENO' => __('Оренбургская область', 'abwoocommerce'),
    'OPLO' => __('Орловская область', 'abwoocommerce'),
    'PENO' => __('Пензенская область', 'abwoocommerce'),
    'PERO' => __('Пермский край', 'abwoocommerce'),
    'PRO' => __('Приморский край', 'abwoocommerce'),
    'PSO' => __('Псковская область', 'abwoocommerce'),
    'RSO' => __('Ростовская область', 'abwoocommerce'),
    'RZO' => __('Рязанская область', 'abwoocommerce'),
    'SMRO' => __('Самарская область', 'abwoocommerce'),
    'SRP' => __('Саратовская область', 'abwoocommerce'),
    'SYAR' => __('Саха(Якутия) республика', 'abwoocommerce'),
    'SKHO' => __('Сахалинская область', 'abwoocommerce'),
    'SVO' => __('Свердловская область', 'abwoocommerce'),
    'SOAR' => __('Северная Осетия - Алания республика', 'abwoocommerce'),
    'SMO' => __('Смоленская область', 'abwoocommerce'),
    'STK' => __('Ставропольский край', 'abwoocommerce'),
    'TRAO' => __('Таймырский (Долгано-Ненецкий) авт. окр.', 'abwoocommerce'),
    'TMBO' => __('Тамбовская область', 'abwoocommerce'),
    'TTR' => __('Татарстан республика', 'abwoocommerce'),
    'TVO' => __('Тверская область', 'abwoocommerce'),
    'TMO' => __('Томская область', 'abwoocommerce'),
    'TVR' => __('Тыва республика', 'abwoocommerce'),
    'TULO' => __('Тульская область', 'abwoocommerce'),
    'TUMO' => __('Тюменская область', 'abwoocommerce'),
    'UDO' => __('Удмуртская республика', 'abwoocommerce'),
    'ULO' => __('Ульяновская область', 'abwoocommerce'),
    'UOBAO' => __('Усть-Ордынский Бурятский авт.окр.', 'abwoocommerce'),
    'KHBK' => __('Хабаровский край', 'abwoocommerce'),
    'KHKR' => __('Хакасия республика', 'abwoocommerce'),
    'KHMAO' => __('Ханты-Мансийский авт.окр.', 'abwoocommerce'),
    'CHLO' => __('Челябинская область', 'abwoocommerce'),
    'CHCHR' => __('Чеченская республика', 'abwoocommerce'),
    'CHTO' => __('Читинская область', 'abwoocommerce'),
    'CHVR' => __('Чувашская республика', 'abwoocommerce'),
    'CHKAO' => __('Чукотский авт.окр.', 'abwoocommerce'),
    'EVAO' => __('Эвенкийский авт.окр.', 'abwoocommerce'),
    'YANO' => __('Ямало-Ненецкий авт.окр.', 'abwoocommerce'),
    'YAO' => __('Ярославская область', 'abwoocommerce')
  
  );
 
  return $states;
}

add_filter( 'woocommerce_checkout_fields','reorder_woo_billing_fields' );
function reorder_woo_billing_fields( $fields ) {
    
     $fields2['billing']['billing_first_name'] = $fields['billing']['billing_first_name'];
     $fields2['billing']['billing_last_name'] = $fields['billing']['billing_last_name'];
     $fields2['billing']['billing_email'] = $fields['billing']['billing_email'];
     $fields2['billing']['billing_phone'] = $fields['billing']['billing_phone'];
      $fields2['billing']['billing_country'] = $fields['billing']['billing_country'];
      $fields2['billing']['billing_address_1'] = $fields['billing']['billing_address_1'];
      $fields2['billing']['billing_address_2'] = $fields['billing']['billing_address_2'];
      $fields2['billing']['billing_city'] = $fields['billing']['billing_city'];
      $fields2['billing']['billing_state'] = $fields['billing']['billing_state'];
      $fields2['billing']['billing_postcode'] = $fields['billing']['billing_postcode'];



    $fields2['shipping'] = $fields['shipping'];
    $fields2['account'] = $fields['account'];
    $fields2['order'] = $fields['order'];
unset($fields2['shipping']['shipping_company']);
unset($fields2['billing']['billing_address_2']);
 unset($fields2['shipping']['shipping_address_2']);   

     return $fields2;
}

} 


function my_hide_shipping_when_free_is_available( $rates ) {
global $ab_woocommerce;
if ($ab_woocommerce['checkout_free_shipping'] == '1' ): 

	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	endif;
	return ! empty( $free ) ? $free : $rates;
	
}

add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );









/*

$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
if ( in_array( 'woocommerce/woocommerce.php', $active_plugins) ) {

 add_filter( 'woocommerce_shipping_methods', 'add_fast_delivery_shipping_method' );
 function add_fast_delivery_shipping_method( $methods ) {
   $methods['fast_delivery_shipping_method'] = 'WC_Fast_Delivery_Shipping_Method';
   return $methods;
 }

 add_action( 'woocommerce_shipping_init', 'fast_delivery_shipping_method_init' );
 function fast_delivery_shipping_method_init(){
   require_once 'class-fast-delivery-shipping-method.php';
 }

}
*/






add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_one_woocommerce_product_add_to_cart_text' );

function custom_one_woocommerce_product_add_to_cart_text() {

 global $product;
	
	$product_type = $product->product_type;
	
	switch ( $product_type ) {
		case 'external':
			return __( 'Купить', 'abwoocommerce' );
		break;
		case 'grouped':
			return __( 'Посмотреть', 'abwoocommerce' );
		break;
		case 'simple':
			return __( 'В корзину', 'abwoocommerce' );
		break;
		case 'variable':
			return __( 'Выбрать', 'abwoocommerce' );
		break;
		default:
			return __( 'Читать далее', 'abwoocommerce' );
	
}


}



/*
* change read more buttons for out of stock items to read contact us
**/
if (!function_exists('woocommerce_template_loop_add_to_cart')) {
function woocommerce_template_loop_add_to_cart() {
global $product;
if ('' === $product->get_price() ) {
	echo '<a href="'. get_permalink() .'" class="button">'. __('Подробнее', 'abwoocommerce') .'</a> ';
} 
else 
{ 
	wc_get_template('loop/add-to-cart.php');
}
}
}


call_user_func(function()
{
    define('AB_OPTION_ID', 'ab_no_shipping_message');

    if ($message = get_option(AB_OPTION_ID)) {
        foreach (array('woocommerce_cart_no_shipping_available_html', 'woocommerce_no_shipping_available_html') as $hook) {
            add_filter($hook, function() use($message) {
                return __($message, 'wc-no-shipping-methods');
            });
        }
    }

    if (is_admin()) {
        add_filter('woocommerce_shipping_settings', function ($settings) {
            $noShippingMessageField = array(
                'id' => AB_OPTION_ID,
                'type' => 'textarea',
                'title' => __('Текст когда нет методов доставки', 'abwoocommerce'),
                'desc' => __('Это сообщение показывается когда нет методов доставки', 'abwoocommerce'),
                'default' => '',
                'css' => 'width:350px; height: 65px;',
            );

            $maybeSectionEnd = end($settings);
            $newFieldPosition = @$maybeSectionEnd['type'] == 'sectionend' ? -1 : count($settings);
            array_splice($settings, $newFieldPosition, 0, array($noShippingMessageField));

            return $settings;
        });

        add_filter('plugin_action_links_' . plugin_basename(wp_normalize_path(__FILE__)), function($links) {
            $settingsUrl = admin_url('admin.php?page=wc-settings&tab=shipping&section=options#' . urlencode(AB_OPTION_ID));
            array_unshift($links, '<a href="'.esc_html($settingsUrl).'">'. __('Изменить текст', 'abwoocommerce') .'</a>');
            return $links;
        });
    }
});





   add_filter('loop_shop_columns', 'wc_product_columns_frontend');
            function wc_product_columns_frontend() {
                global $woocommerce, $ab_woocommerce, $item_number;

	if ( $ab_woocommerce['items_number'] == '2')   $item_number = "2"; if ( $ab_woocommerce['items_number'] == '3') $item_number = "3"; if ( $ab_woocommerce['items_number'] == '4') $item_number = "4"; if ( $ab_woocommerce['items_number'] == '5') $item_number = '5'; if ( $ab_woocommerce['items_number'] == '6') $item_number = '6';
                // Default Value also used for categories and sub_categories
                $columns = $item_number;

                // Product List
                if ( is_product_category() ) :
                    global $woocommerce, $ab_woocommerce, $item_number;
                   

	if ( $ab_woocommerce['items_number'] == '2')   $item_number = "2"; if ( $ab_woocommerce['items_number'] == '3') $item_number = "3"; if ( $ab_woocommerce['items_number'] == '4') $item_number = "4"; if ( $ab_woocommerce['items_number'] == '5') $item_number = '5'; if ( $ab_woocommerce['items_number'] == '6') $item_number = '6';
                // Default Value also used for categories and sub_categories
                $columns = $item_number;
                endif;

                //Related Products
                if ( is_product() ) :
                    $columns = 4;
                endif;

                //Cross Sells
                if ( is_checkout() ) :
                    $columns = 4;
                endif;

		return $columns;


            }
            

/*
add_action( 'woocommerce_flat_rate_shipping_add_rate', 'add_another_custom_flat_rate', 10, 2 );		
function add_another_custom_flat_rate( $method, $rate ) {			$new_rate          = $rate;			$new_rate['id']    .= ':' . 'custom_rate_name'; 
// Append a custom ID			
$new_rate['label'] = 'Rushed Shipping'; 
// Rename to 'Rushed Shipping'			
$new_rate['cost']  += 2; 
// Add $2 to the cost						
// Add it to WC			
$method->add_rate( $new_rate );		}
*/
