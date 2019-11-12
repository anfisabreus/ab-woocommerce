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
$content = '<span class="onsale">'.__( 'Скидка', 'woocommerce' ).'</span>';
return $content;
}

 

// Display 24 products per page. Goes in functions.php
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 24;' ), 20 );



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

	<input type="search" id="woocommerce-product-search-field" class="search-field form-control search-query input1" placeholder="' . __( 'Поиск товаров', 'woocommerce' ) . '" value="' . get_search_query() . '" name="s" title="Search for" />
	<span class="input-group-btn">
	<button type="submit" class="btn btn-default" id="searchsubmit" value="'. esc_attr__( 'Найти', 'woocommerce' ) .'" /><i class="fa fa-search"></i></button></span>
	<input type="hidden" name="post_type" value="product" />
	</div>
</form>';
	
return $form;
	}



function abwoocommerce_template_loop_category_link_open( $category ) {
	echo '<a href="'. get_term_link( $category, 'product_cat' ) .'" class="tm_banners_grid_widget_banner_link">';
}
add_filter( 'abwoocommerce_before_subcategory', 'abwoocommerce_template_loop_category_link_open', 10 );



$terms = get_the_terms( $post->ID, 'product_tag' );
if ($terms && ! is_wp_error($terms)): ?>
    <?php foreach($terms as $term): ?>
        <a href="<?php echo get_term_link( $term->slug, 'product_tag'); ?>" rel="tag" class="<?php echo $term->slug; ?>"><?php echo $term->name; ?></a>
    <?php endforeach; ?>
<?php endif; 


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
</div><div class="button-homepage">Магазин</div>
		
		<?php
		}

	}
	
	add_action('abinspiration_shop_loop_subcategory_title', 'abinspiration_shop_loop_subcategory_title', 10);
	
	
	//Display product category descriptions under category image/title on woocommerce shop page */


add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'RUB': $currency_symbol = '<i class="fa fa-rub"></i>'; break;
          case 'UAH': $currency_symbol = 'грн.'; break;
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
    'MSK' => 'Москва',
    'SPB' => 'Санкт-Петербург',
    'NOV' => 'Новосибирск',
    'EKB' => 'Екатеринбург',
    'NN' => 'Нижний Новгород',
    'KZN' => 'Казань',
    'CHL' => 'Челябинск',
    'OMSK' => 'Омск',
    'SMR' => 'Самара',
    'RND' => 'Ростов-на-Дону',
    'UFA' => 'Уфа',
    'PRM' => 'Пермь',
    'KRN' => 'Красноярск',
    'VRZH' => 'Воронеж',
    'VLG' => 'Волгоград',
    'SIMF' => 'Симферополь',
    'ABAO' => 'Агинский Бурятский авт.окр.',
    'AR' => 'Адыгея Республика',
    'ALR' => 'Алтай Республика',
    'AK' => 'Алтайский край',
    'AMO' => 'Амурская область',
    'ARO' => 'Архангельская область',
    'ACO' => 'Астраханская область',
    'BR' => 'Башкортостан республика',
    'BEO' => 'Белгородская область',
    'BRO' => 'Брянская область',
    'BUR' => 'Бурятия республика',
    'VLO' => 'Владимирская область',
    'VOO' => 'Волгоградская область',
    'VOLGO' => 'Вологодская область',
    'VORO' => 'Воронежская область',
    'DR' => 'Дагестан республика',
    'EVRAO' => 'Еврейская авт. область',
    'IO' => 'Ивановская область',
    'IR' => 'Ингушетия республика',
    'IRO' => 'Иркутская область',
    'KBR' => 'Кабардино-Балкарская республика',
    'KNO' => 'Калининградская область',
    'KMR' => 'Калмыкия республика',
    'KLO' => 'Калужская область',
    'KMO' => 'Камчатская область',
    'KCHR' => 'Карачаево-Черкесская республика',
    'KR' => 'Карелия республика',
    'KEMO' => 'Кемеровская область',
    'KIRO' => 'Кировская область',
    'KOMI' => 'Коми республика',
    'KPAO' => 'Коми-Пермяцкий авт. окр.',
    'KRAO' => 'Корякский авт.окр.',
    'KOSO' => 'Костромская область',
    'KRSO' => 'Краснодарский край',
    'KRNO' => 'Красноярский край',
    'KRYM' => 'Крым Республика',
    'KURGO' => 'Курганская область',
    'KURO' => 'Курская область',
    'LENO' => 'Ленинградская область',
    'LPO' => 'Липецкая область',
    'MAGO' => 'Магаданская область',
    'MER' => 'Марий Эл республика',
    'MOR' => 'Мордовия республика',
    'MSKO' => 'Московская область',
    'MURO' => 'Мурманская область',
    'NAO' => 'Ненецкий авт.окр.',
    'NZHO' => 'Нижегородская область',
    'NVGO' => 'Новгородская область',
    'NVO' => 'Новосибирская область',
    'OMO' => 'Омская область',
    'OPENO' => 'Оренбургская область',
    'OPLO' => 'Орловская область',
    'PENO' => 'Пензенская область',
    'PERO' => 'Пермский край',
    'PRO' => 'Приморский край',
    'PSO' => 'Псковская область',
    'RSO' => 'Ростовская область',
    'RZO' => 'Рязанская область',
    'SMRO' => 'Самарская область',
    'SRP' => 'Саратовская область',
    'SYAR' => 'Саха(Якутия) республика',
    'SKHO' => 'Сахалинская область',
    'SVO' => 'Свердловская область',
    'SOAR' => 'Северная Осетия - Алания республика',
    'SMO' => 'Смоленская область',
    'STK' => 'Ставропольский край',
    'TRAO' => 'Таймырский (Долгано-Ненецкий) авт. окр.',
    'TMBO' => 'Тамбовская область',
    'TTR' => 'Татарстан республика',
    'TVO' => 'Тверская область',
    'TMO' => 'Томская область',
    'TVR' => 'Тыва республика',
    'TULO' => 'Тульская область',
    'TUMO' => 'Тюменская область',
    'UDO' => 'Удмуртская республика',
    'ULO' => 'Ульяновская область',
    'UOBAO' => 'Усть-Ордынский Бурятский авт.окр.',
    'KHBK' => 'Хабаровский край',
    'KHKR' => 'Хакасия республика',
    'KHMAO' => 'Ханты-Мансийский авт.окр.',
    'CHLO' => 'Челябинская область',
    'CHCHR' => 'Чеченская республика',
    'CHTO' => 'Читинская область',
    'CHVR' => 'Чувашская республика',
    'CHKAO' => 'Чукотский авт.окр.',
    'EVAO' => 'Эвенкийский авт.окр.',
    'YANO' => 'Ямало-Ненецкий авт.окр.',
    'YAO' => 'Ярославская область'
  
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
			return __( 'Купить', 'woocommerce' );
		break;
		case 'grouped':
			return __( 'Посмотреть', 'woocommerce' );
		break;
		case 'simple':
			return __( 'В корзину', 'woocommerce' );
		break;
		case 'variable':
			return __( 'Выбрать', 'woocommerce' );
		break;
		default:
			return __( 'Читать далее', 'woocommerce' );
	
}


}



/*
* change read more buttons for out of stock items to read contact us
**/
if (!function_exists('woocommerce_template_loop_add_to_cart')) {
function woocommerce_template_loop_add_to_cart() {
global $product;
if ('' === $product->get_price() ) {
	echo '<a href="'. get_permalink() .'" class="button">Подробнее</a> ';
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
                'title' => __('Текст когда нет методов доставки', 'inspiration'),
                'desc' => __('Это сообщение показывается когда нет методов доставки', 'inspiration'),
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
            array_unshift($links, '<a href="'.esc_html($settingsUrl).'">'.__('Изменить текст', 'inspiration').'</a>');
            return $links;
        });
    }
});

/**
 * Change text strings
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
 */
function my_text_strings( $translated_text, $text, $domain ) {
global $ab_woocommerce;
	switch ( $translated_text ) {
		case 'Похожие товары' :
			$translated_text = $ab_woocommerce['related_product_text'];
			break;
	}
	return $translated_text;
}
add_filter( 'gettext', 'my_text_strings', 20, 3 );




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