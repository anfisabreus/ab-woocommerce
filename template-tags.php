<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package abinspiration
 */
 

if ( ! function_exists( 'abinspiration_product_categories' ) ) {
	/**
	 * Display Product Categories
	 * Hooked into the `homepage` action in the homepage template
	 * @since  1.0.0
	 * @return void
	 */
	function abinspiration_product_categories( $args ) {
	global $ab_woocommerce;

		if ( is_woocommerce_activated() ) {
		

		$cat1 = $ab_woocommerce['hp_category1'];
		$cat2 = $ab_woocommerce['hp_category2'];
		$cat3 = $ab_woocommerce['hp_category3'];
		$catall = $cat1.','.$cat2.','.$cat3;

			$args = apply_filters( 'abinspiration_product_categories_args', array(
				'limit' 			=> 3,
				'columns' 			=> 3,
				'child_categories' 	=> 0,
				'title'				=> '',
				'orderby' => 'ID',
				'ids' => $catall
				
				) );

			echo '<div class="home-level2"><section class="abinspiration-product-section abinspiration-product-categories">';

				do_action( 'abinspiration_homepage_before_product_categories' );

				

				do_action( 'abinspiration_homepage_after_product_categories_title' ); ?>
				

          
          <div class="woocommerce columns-3">
          
          <ul class="products">
          
          
          

			<li class="product-category product first">
	<div class="img-wrap"><?php
	
	
	

	
	
	 $get_featured_cats = array(
	'taxonomy'     => 'product_cat',
	'orderby'      => 'name',
	'hide_empty'   => '0',
	'include'      => $cat1
);
$all_categories = get_categories( $get_featured_cats );
$j = 1;
foreach ($all_categories as $cat) {
	$cat_id   = $cat->term_id;
	$cat_desc = $cat->description;
	$cat_link = get_category_link( $cat_id );
	
	echo '<a href="'. $cat_link .'" class="tm_banners_grid_widget_banner_link">';
	
	$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); // Get Category Thumbnail
	$image = wp_get_attachment_url( $thumbnail_id ); 
	if ( $image ) {
		echo '<div class="category-bg" style="background:url(' . $image . ') center center no-repeat; background-size:cover;"></div>';
		}	
		echo '<div class="cat-title-homepage">';
		
		echo '<span class="cat-title-bg">
			'. $cat->name .' </span>';
		if ( $cat_desc ) {	
		echo '<div class="shop_cat_desc"><span class="cat-desc-bg">'. $cat->description .'</span></div>'; }
echo '</div>';



		echo '</a>';
		
	$j++;
}
// Reset Post Data
wp_reset_query();    ?>    	


	</div></li>

		
		
		
			<li class="product-category product">
	<div class="img-wrap"><?php
	
	
	 $get_featured_cats = array(
	'taxonomy'     => 'product_cat',
	'orderby'      => 'name',
	'hide_empty'   => '0',
	'include'      => $cat2
);
$all_categories = get_categories( $get_featured_cats );
$j = 1;
foreach ($all_categories as $cat) {
	$cat_id   = $cat->term_id;
	$cat_desc = $cat->description;
	$cat_link = get_category_link( $cat_id );
	
	
	echo '<a href="'. $cat_link .'" class="tm_banners_grid_widget_banner_link">';
	
	$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); // Get Category Thumbnail
	$image = wp_get_attachment_url( $thumbnail_id ); 
	if ( $image ) {
		echo '<div class="category-bg" style="background:url(' . $image . ') center center no-repeat; background-size:cover;"></div>';
		}	
		echo '<div class="cat-title-homepage">';
		
		echo '<span class="cat-title-bg">
			'. $cat->name .' </span>';
		if ( $cat_desc ) {	
		echo '<div class="shop_cat_desc"><span class="cat-desc-bg">'. $cat->description .'</span></div>'; }
echo '</div>';

		echo '</a>';
		
	$j++;
}
// Reset Post Data
wp_reset_query();    ?>    	


	</div></li>
	
			<li class="product-category product last">
	<div class="img-wrap"><?php
	
	
	 $get_featured_cats = array(
	'taxonomy'     => 'product_cat',
	'orderby'      => 'name',
	'hide_empty'   => '0',
	'include'      => $cat3
);
$all_categories = get_categories( $get_featured_cats );
$j = 1;
foreach ($all_categories as $cat) {
	$cat_id   = $cat->term_id;
	$cat_desc = $cat->description;
	$cat_link = get_category_link( $cat_id );
	
	echo '<a href="'. $cat_link .'" class="tm_banners_grid_widget_banner_link">';
	
	$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); // Get Category Thumbnail
	$image = wp_get_attachment_url( $thumbnail_id ); 
	if ( $image ) {
		echo '<div class="category-bg" style="background:url(' . $image . ') center center no-repeat; background-size:cover;"></div>';
		}	
		echo '<div class="cat-title-homepage">';
		
		echo '<span class="cat-title-bg">
			'. $cat->name .' </span>';
		if ( $cat_desc ) {	
		echo '<div class="shop_cat_desc"><span class="cat-desc-bg">'. $cat->description .'</span></div>'; }
echo '</div>';

		echo '</a>';
		
	$j++;
}
// Reset Post Data
wp_reset_query();    ?>    	


	</div></li>
	
</ul>
</div>
          
          
          
          
          
    <?php	

				do_action( 'abinspiration_homepage_after_product_categories' );
				
				
			echo '</section></div>';
		
			
			
			

		}
	}
}

if ( ! function_exists( 'abinspiration_homepage_ads' ) ) {
	/**
	 * Display the post content with a link to the single post
	 * @since 1.0.0
	 */
	function abinspiration_homepage_ads() {
global $ab_woocommerce;
		?>
		
		
		
		<div class="home-level3"><div class="abinspiration-product-ads" style="display:table">
		
			
			
			<div class="abinspiration-product-ads-img"> 
				
				<img src="<?php echo $ab_woocommerce['image_ads']; ?>" width="100%" style="vertical-align:middle">
				
			</div>
			
			<div class="abinspiration-product-ads-text">
			
			<div><?php echo  do_shortcode(stripslashes($ab_woocommerce['hp_heading_level3'])); ?></div>
				
				
				
				<a href="<?php echo $ab_woocommerce['link_ads']; ?>" class="ads-homepage"><?php echo $ab_woocommerce['text_ads']; ?></a>
				
				
			</div>
			
			
			
			
		</div></div><!-- .entry-content -->
		<?php
	}
}



if ( ! function_exists( 'abinspiration_featured_products' ) ) {
	/**
	 * Display Featured Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function abinspiration_featured_products( $args ) {
	global $ab_woocommerce;

		if ( is_woocommerce_activated() ) {

			$args = apply_filters( 'abinspiration_featured_products_args', array(
				'limit'   => $ab_woocommerce['cols_number_featured'],
				'columns' => $ab_woocommerce['items_number_featured'],
				'orderby' => 'date',
				'order'   => 'desc',
				'title'   =>  $ab_woocommerce['featured_items_title'],
			) );
			 

			echo ' <div class="home-level-featured"><section class="abinspiration-featured-section" aria-label="Featured Products">';
			
?><div class="abinspiration-featured-products"><?php
			do_action( 'abinspiration_homepage_before_featured_products' );
	

			if ($args['title'] == !'') echo '<div class="section-title">' . wp_kses_post( $args['title'] ) . '</div>';
			
			
		

			do_action( 'abinspiration_homepage_after_featured_products_title' );
			
				
				
				
				

			echo abinspiration_do_shortcode( 'featured_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
				'orderby'  => esc_attr( $args['orderby'] ),
				'order'    => esc_attr( $args['order'] ),
			) );
			

			do_action( 'abinspiration_homepage_after_featured_products' );
?></div><?php
			echo '</section></div>';
		}
	}
}





if ( ! function_exists( 'abinspiration_homepage_form' ) ) {
	/**
	 * Display the post content with a link to the single post
	 * @since 1.0.0
	 */
	function abinspiration_homepage_form() {
global $ab_woocommerce;
		?>
		
		
		
		<div class="home-level6"><div class="abinspiration-product-form">
		
			
			
			<div class="abinspiration-product-form-img"> 
				
				<div class="shopform-title"> <?php echo  do_shortcode(stripslashes($ab_woocommerce['form_title'])); ?></div>
				
			</div>
			
			<div class="abinspiration-product-form-input">
			
			<style>.garantiya {margin:5px 0px 0 !important;}form {padding-top:20px;} .garantiya a {text-decoration:none; font-size:14px !important;}.garantiya a:hover{text-decoration:underline;}
				 
			</style>
			
			
			<?php if (of_get_option('obrabotka_dannyh_text', '') != '') $obrabotka =  '
<div class="garantiya"><a class="fancybox" href="#inline" title="Согласие на обработку персональных данных">Нажимая на кнопку, я соглашаюсь с политикой обработки персональных данных</a></div>'
. konf_personal();
 
			
			 


if ($ab_woocommerce['ab_sub_form_smart'] == '1'){ echo '<form method="POST" action="//'.$ab_woocommerce['ab_jc_login'].'.justclick.ru/subscribe/process" method="post" target="_blank">
 
 <input type="hidden" name="rid[0]" value="'.$ab_woocommerce['ab_jc_group'].'">
	    <input type="hidden" name="tag" value="'.$ab_woocommerce['ab_jc_marker'].'">
	    <input type="hidden" name="orderData[tag]" value="">

<input name="lead_email" type="text" placeholder="Введите ваш Email..." class="shop-form-input" />


<div><button type="submit" class="show-form-button"> '.$ab_woocommerce['text_form_button'].' </button></div>

'. $obrabotka.'

<input name="doneurl2" type="hidden" value="'.urlencode($ab_woocommerce['ab_jc_link_2']).'" /></form>
<script type="text/javascript" src="http://'.$ab_woocommerce['ab_jc_login'].'.justclick.ru/constructor/editor/scripts/common-forms.js"></script>';}


if ( $ab_woocommerce['ab_form_old_form'] == '1')   $getresp_link = "https://app.getresponse.com/add_subscriber.html";  else $getresp_link = "https://app.getresponse.com/add_contact_webform.html";


if ( $ab_woocommerce['ab_form_old_form'] == '1')   $getresp_id = '<input type="hidden" name="campaign_token" value="'.$ab_woocommerce['ab_formid'].'" />
<input type="hidden" name="start_day" value="0" />
<input type="hidden" name="thankyou_url" value="'.$ab_woocommerce['thankyou_page'].'"/>
 ';  else $getresp_id = '<input type="hidden" name="webform_id" value="'.$ab_woocommerce['ab_formid'].'" />';


if ($ab_woocommerce['ab_sub_form_smart'] == '2'){ echo '<form accept-charset="utf-8" target="_blank" action="'. $getresp_link .'" method="post">

<input name="email" type="text" placeholder="Введите ваш Email..." class="shop-form-input">
<input type="submit"  value="'.$ab_woocommerce['text_form_button'].'" class="show-form-button" />'. $obrabotka.''. $getresp_id .'</form>';}



if ($ab_woocommerce['ab_sub_form_smart'] == '3'){echo '<a href="'. $ab_woocommerce['ab_link_sub'].'" target="_blank" style="text-decoration:none;"><div style="display:table;" class="show-form-button"><div style="vertical-align:middle; display:table-cell; width:100%; text-align:center" >'. $ab_woocommerce['text_form_button'].'</div></div></a>';} 




if ($ab_woocommerce['ab_sub_form_smart'] == '4'){ echo '

<form action="//'.$ab_woocommerce['ab_mc_login'].'.us12.list-manage.com/subscribe/post?u='.$ab_woocommerce['ab_mc_idprofile'].'&amp;id='.$ab_woocommerce['ab_mc_idlist'].'" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>

<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_'.$ab_woocommerce['ab_mc_idprofile'].'_'.$ab_woocommerce['ab_mc_idlist'].'" tabindex="-1" value=""></div>
    
	
	<input type="email" name="EMAIL" placeholder="Введите ваш Email..." class="shop-form-input">

	
    
   <input type="submit" name="subscribe" value="'.$ab_woocommerce['text_form_button'].'" class="show-form-button">
   
   '. $obrabotka.'
   
</form>


';}


if ($ab_woocommerce['ab_sub_form_smart'] == '5') { echo '



<form method="POST" action="https://cp.unisender.com/ru/subscribe?hash='.$ab_woocommerce['unisenderhash'].'" 
name="subscribtion_form" target="_blank">
    

	<input type="email" name="email" placeholder="Введите ваш Email..." class="shop-form-input">

	
    
   <input type="submit" value="'.$ab_woocommerce['text_form_button'].'" class="show-form-button">
   '. $obrabotka.'
   
   <input type="hidden" name="charset" value="UTF-8">
    <input type="hidden" name="default_list_id" value="'.$ab_woocommerce['unisenderid'].'">
    <input type="hidden" name="overwrite" value="2">
    <input type="hidden" name="is_v5" value="1">
   
</form>';}






if ($ab_woocommerce['ab_sub_form_smart'] == '6') { echo '

<script type="text/javascript" src="https://autoweboffice.ru/js/jquery.mask.js"></script>
<script type="text/javascript">$(function() {$("body").on("submit", ".form_newsletter", function() {var message = "Укажите значения всех обязательных для заполнения полей!"; });});</script> 



<form action="https://'.$ab_woocommerce['loginautoweboffice'].'.autoweboffice.ru/?r=personal/newsletter/sub/add&amp;id='.$ab_woocommerce['idautoweboffice'].'&amp;lg=ru" method="post" enctype="application/x-www-form-urlencoded" accept-charset="UTF-8"  target="_blank" >
    

	<input type="email" name="Contact[email]" placeholder="Введите ваш Email..." class="shop-form-input">

	
    
  <input type="submit" value="'.$ab_woocommerce['text_form_button'].'" class="show-form-button">
  '. $obrabotka.'
   
   <input type="hidden" value="'.$ab_woocommerce['idautowebofficepassylki'].'" name="Contact[id_newsletter]">
<input type="hidden" value="0" name="Contact[id_advertising_channel_page]"> 
   
</form>';}



if ($ab_woocommerce['ab_sub_form_smart'] == '7') { echo '

<form action="//app.mailerlite.com/webforms/submit/'.$ab_woocommerce['idlandingmailerlite'].'" data-id="'.$ab_woocommerce['idformmailerlite'].'" data-code="'.$ab_woocommerce['idlandingmailerlite'].'" method="POST" target="_blank">
    
	
	<input type="email" name="fields[email]" placeholder="' . __( 'Введите ваш Email...', 'abwoocommerce' ) . '" class="shop-form-input">

	<input type="hidden" name="ml-submit" value="1" />
    
    <input type="submit" value="'.$ab_woocommerce['text_form_button'].'" class="show-form-button">
   
   '. $obrabotka.'
   
  <script>
            function ml_webform_success() {
                try {
                    window.top.location.href = \''.$ab_woocommerce['thankyoumailerlite'].'\';
                } catch (e) {
                    window.location.href = \''.$ab_woocommerce['thankyoumailerlite'].'\';
                }
            };
        </script>   
</form>
<script type="text/javascript" src="//static.mailerlite.com/js/w/webforms.min.js?'.$ab_woocommerce['idstatistic'].'"></script>';}





if ($ab_woocommerce['ab_sub_form_smart'] == '8') { echo '

<div id="sp-form-'.$ab_woocommerce['idformsendpulse'].'" sp-id="'.$ab_woocommerce['idformsendpulse'].'" sp-hash="'.$ab_woocommerce['hashformsednpulse'].'" sp-lang="ru" class="sp-form sp-form-regular sp-form-embed" sp-show-options="" style="padding:0px !important; width:auto !important;border: none;"> 

<div class="sp-message"> <div></div> </div> 
<form novalidate="" class="sp-element-container ui-sortable ui-droppable ">

<input type="email" sp-type="email" name="sform[email]"  required="required" size="27" class="sp-form-control shop-form-input" placeholder="' . __( 'Введите ваш Email...', 'abwoocommerce' ) . '">
 
<div class="button-align"> <button class="sp-button show-form-button"> '.$ab_woocommerce['text_form_button'].' </button></div></form> </div> 
 

<script type="text/javascript" src="//static-login.sendpulse.com/apps/fc3/build/default-handler.js?'.$ab_woocommerce['idscriptsendpulse'].'"></script>

';}

?>

			
	

				
				
				
								
				
			</div>
			<div style="clear:both"> </div>
			
			
			
		</div></div><!-- .entry-content -->
		<?php
	}
}








if ( ! function_exists( 'abinspiration_recent_products' ) ) {
	/**
	 * Display Recent Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function abinspiration_recent_products( $args ) {
	global $ab_woocommerce;

		if ( is_woocommerce_activated() ) {

			$args = apply_filters( 'abinspiration_recent_products_args', array(
				'limit' 			=> 4,
				'columns' 			=> 4,
				'orderby' => 'date',
				'order'   => 'desc',
				'title'   =>  'Новые товары',
			) );

			echo '<div class="home-level-new"><section class="abinspiration-recent-section" aria-label="Recent Products">';
			



?><div class="abinspiration-recent-products"><?php
if ($args['title'] == !'')  echo '	<div class="section-title"> Новые товары </div> ';

			do_action( 'abinspiration_homepage_before_recent_products' );

			

			do_action( 'abinspiration_homepage_after_recent_products_title' );

			echo abinspiration_do_shortcode( 'recent_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
				'orderby'  => esc_attr( $args['orderby'] ),
				'order'    => esc_attr( $args['order'] ),
			) );

			do_action( 'abinspiration_homepage_after_recent_products' );
			?></div><?php

			echo '</section></div>';
		}
	}
}


if ( ! function_exists( 'abinspiration_popular_products' ) ) {
	/**
	 * Display Popular Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function abinspiration_popular_products( $args ) {
	global $ab_woocommerce;

		if ( is_woocommerce_activated() ) {

			$args = apply_filters( 'abinspiration_popular_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'   => 'Популярные товары',
			) );

			echo '<div class="home-level-popular"><section class="abinspiration-popular-section" aria-label="Popular Products">';
			
			?><div class="abinspiration-popular-products"><?php

			do_action( 'abinspiration_homepage_before_popular_products' );

			if ($args['title'] == !'') echo '<div class="section-title">Популярные товары</div>';

			do_action( 'abinspiration_homepage_after_popular_products_title' );

			echo abinspiration_do_shortcode( 'top_rated_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'abinspiration_homepage_after_popular_products' );
?></div><?php
			echo '</section></div>';
		}
	}
}

if ( ! function_exists( 'abinspiration_on_sale_products' ) ) {
	/**
	 * Display On Sale Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @param array $args the product section args.
	 * @since  1.0.0
	 * @return void
	 */
	function abinspiration_on_sale_products( $args ) {
	global $ab_woocommerce;

		if ( is_woocommerce_activated() ) {

			$args = apply_filters( 'abinspiration_on_sale_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'   => 'Распродажа',
			) );

			echo '<div class="home-level-onsale"><section class="abinspiration-on-sale-section" aria-label="On Sale Products">';
			
			?><div class="abinspiration-on-sale-products"><?php

			do_action( 'abinspiration_homepage_before_on_sale_products' );

			if ($args['title'] == !'') echo '<div class="section-title">Распродажа</div>';

			do_action( 'abinspiration_homepage_after_on_sale_products_title' );

			echo abinspiration_do_shortcode( 'sale_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'abinspiration_homepage_after_on_sale_products' );
?></div><?php
			echo '</section></div>';
		}
	}
}

if ( ! function_exists( 'abinspiration_best_selling_products' ) ) {
	/**
	 * Display Best Selling Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since 2.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function abinspiration_best_selling_products( $args ) {
		if ( is_woocommerce_activated() ) {
			$args = apply_filters( 'abinspiration_best_selling_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'	  => 'Популярные товары',
			) );
			echo '<div class="home-level-onsale"><section class="abinspiration-best-selling-section" aria-label="Best Selling Products">';
			?><div class="abinspiration-best-selling-products"><?php
			do_action( 'abinspiration_homepage_before_best_selling_products' );
			if ($args['title'] == !'') echo '<div class="section-title">'  . wp_kses_post( $args['title'] ) . '</div>';
			do_action( 'abinspiration_homepage_after_best_selling_products_title' );
			echo abinspiration_do_shortcode( 'best_selling_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );
			do_action( 'abinspiration_homepage_after_best_selling_products' );
			?></div><?php
			echo '</section></div>';
		}
	}
}


if ( ! function_exists( 'abinspiration_homepage_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 * @since 1.0.0
	 */
	function abinspiration_homepage_content() {
global $ab_woocommerce;
		?>
		
		
		
		<div class="home-level1"><div class="homepageitemstabs" itemprop="mainContentOfPage">
		
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
					'after'  => '</div>',
				) );
			?>
		</div></div><!-- .entry-content -->
		<?php
	}
}

/*

if ( ! function_exists( 'abinspiration_homepage_posts' ) ) {
	/**
	 * Display the post content with a link to the single post
	 * @since 1.0.0
	 */
/* function abinspiration_homepage_posts() {
global $ab_woocommerce;
		?>
<div class="home-level-posts"><div class="abinspiration-posts">

<div class="section-title"><?php echo  do_shortcode(stripslashes($ab_woocommerce['posts_items_title']));?> </div> 

<div class="row">

	<?php
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 2
			);
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post(); ?><div class="col-md-6" style="padding:0px 20px 0px 0px;">
		
		

		

			
		<div style="margin:0 auto; margin-bottom:20px; margin-right:0px;">

			
		
			<?php if( has_post_thumbnail( $post_id )) { ?>
<a href="<?php the_permalink();?>"><div class="homepage-image2" style="background-image: url(<?=wp_get_attachment_url( get_post_thumbnail_id() ); ?>); height: 300px;  background-size:cover">
</div></a><?php } else { ?><img style="width:100%; height:300px;" src="<?php echo get_bloginfo('url'); ?>/wp-content/themes/ab-inspiration/images/default.png"> <?php } ?><div class="homepage-image2-img"></div>
		<h2 class="entry-title" itemprop="name headline" style="position:absolute; bottom:40px; left:40px"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>		
			
</div>
			
		
	
				
					
				</div><?php
			endwhile;
		} else {
			echo __( 'No products found' );
		}
		wp_reset_postdata();
	?>
	<div style="clear:both"></div>
</div></div><!--/.products-->

		<?php
	}
}

*/


if ( ! function_exists( 'abinspiration_homepage_reviews' ) ) {
	/**
	 * Display social icons
	 * If the subscribe and connect plugin is active, display the icons.
	 * @link http://wordpress.org/plugins/subscribe-and-connect/
	 * @since 1.0.0
	 */
	function abinspiration_homepage_reviews() { global $ab_woocommerce, $comments, $comment; ?>
	<div class="home-level5"><div class="abinspiration-testimonials-section">
<div class="section-title"><?php echo  do_shortcode(stripslashes($ab_woocommerce['testimonials_title'])); ?> </div> 

 <div id="otzyvy-magasin" class="cbp cbp-slider-edge">

<?php

			


		$comments = get_comments( array( 'number' => 10, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'product' ) );
		if ( $comments ) {

foreach ( (array) $comments as $comment ) {

				$_product = wc_get_product( $comment->comment_post_ID );

				$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

				$rating_html = $_product->get_rating_html( $rating );

				echo '<div class="cbp-item  testimonials-animation">	
<div class="cbp-l-grid-slider-testimonials-body" style="line-height:26px;overflow: visible; padding-bottom:60px;"><div class="product-comments-homepage" style="width:100%;overflow: visible;">';


 $argsavatar = array(
                            
                            'class'     => array('avatar-comment-homepage')
                        );
				
				echo  '<div class="shop-otzyv-image"><a target="_blank" 
rel="nofollow" href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">' .get_avatar($comment->comment_author_email, 95, "//www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536", $alt = '', $argsavatar).'</a></div>';




					echo '<a style="color:#333 !important; text-decoration:none; font-weight:bold;" href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '"><div class="shop-otzyv-home">';

				echo $_product->get_title() . '</div></a> <div class="otzyv-tovar-magazin">' . wp_trim_words($comment->comment_content, 30, '...' ).'</div><div style="clear:both"></div>';
				
				printf( '<div style="text-align:center;margin-top:20px; font-size: 16px;" class="reviewer"> - ' . _x( ' %1$s', ' comment author', 'woocommerce' ) . '</div>', get_comment_author() );

		

				

				echo '</div></div></div>';
			} }

 ?></div></div></div> <?php

}}


if ( ! function_exists( 'abinspiration_social_icons' ) ) {
	/**
	 * Display social icons
	 * If the subscribe and connect plugin is active, display the icons.
	 * @link http://wordpress.org/plugins/subscribe-and-connect/
	 * @since 1.0.0
	 */
	function abinspiration_social_icons() { ?>
	<div style="padding-bottom:20px">
	
	
	
	
	 <div style="padding-top:15px;">
	 
	 <style>
		 .social-likes .shop {border-radius:50% !important;}
		 .shop.social-likes__widget{height:40px; width:40px;}
		 .social-likes .shop .social-likes__button {color:#babbbc}

.social-likes .shop.social-likes__widget_facebook, .social-likes .shop.social-likes__widget_twitter,.social-likes .shop.social-likes__widget_plusone,  .social-likes .shop.social-likes__widget_vkontakte, .social-likes .shop.social-likes__widget_odnoklassniki, .social-likes .shop.social-likes__widget_telegram, .social-likes .shop.social-likes__widget_pinterest  {position:relative; top:5px; left:5px}
		
.social-likes.shoplikes{font-size:20px !important; font-weight:normal}

.social-likes.shoplikes .shop .social-likes__icon_facebook:before {font-family: FontAwesome ;content: "\f09a" !important; left: 45%;position: relative;top: 3px;}
.social-likes.shoplikes .shop .social-likes__icon_twitter:before {font-family: FontAwesome ;content: "\f099" !important; left: 20%;position: relative;top: 2px;}
.social-likes.shoplikes .shop .social-likes__icon_plusone:before {font-family: 'social-likes' ;content: "\f106" !important; left: 30%;position: relative;top: 1px; font-size:16px}
.social-likes.shoplikes .shop .social-likes__icon_vkontakte:before {font-family:  FontAwesome ;content: "\f189" !important; left: 0px;position: relative;bottom: 2px;}

.social-likes.shoplikes .shop .social-likes__icon_odnoklassniki:before {   left: 3px;position: relative;top: 2px;}
.social-likes.shoplikes .shop .social-likes__icon_telegram:before {   left: 3px;position: relative;top: 3px;}
.social-likes.shoplikes .shop .social-likes__icon_pinterest:before {   left: 3px;position: relative;top: 3px;}


		 .social-likes.shoplikes .social-likes__widget {margin-left:0px}
		 .social-likes__widget_notext .social-likes__icon {

    margin: .48em;
}




 

		 
	 </style>


	    
	    
	    <div  class="social-likes shoplikes" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>">
	    		    	
	    	
<div data-service="facebook" class="facebook shop" title="Поделиться в Facebook"></div>
<div data-service="twitter" class="twitter shop" title="Поделиться в Twitter"  data-via="<?php echo of_get_option('twitter') ?>"></div>
<div data-service="plusone" class="plusone shop" title="Поделиться в Google+"></div>
<div data-service="vkontakte" class="vkontakte shop" title="Поделиться в Vkontakte"></div>
<div data-service="odnoklassniki" class="odnoklassniki shop" title="Поделиться в Odnoklassniki"></div>
<div data-service="telegram" class="telegram shop" title="Поделиться в Telegram"></div>
<div data-service="pinterest" class="pinterest shop" title="Поделиться в Pinterest"></div>


</div></div>
	
	
	
	
	 </div>
	<?php }
}

if ( ! function_exists( 'abinspiration_get_sidebar' ) ) {
	/**
	 * Display abinspiration sidebar
	 * @uses get_sidebar()
	 * @since 1.0.0
	 */
	function abinspiration_get_sidebar() {
		get_sidebar();
	}
}

if ( ! function_exists( 'abinspiration_post_thumbnail' ) ) {
	/**
	 * Display post thumbnail
	 * @var $size thumbnail size. thumbnail|medium|large|full|$custom
	 * @uses has_post_thumbnail()
	 * @uses the_post_thumbnail
	 * @param string $size
	 * @since 1.5.0
	 */
	function abinspiration_post_thumbnail( $size ) {
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( $size, array( 'itemprop' => 'image' ) );
		}
	}
}







add_filter( 'woocommerce_add_to_cart_fragments', 'abinspiration_cart_link_fragment' );
if ( ! function_exists( 'abinspiration_cart_link_fragment' ) ) {
	function abinspiration_cart_link_fragment( $fragments ) {
		

		ob_start();

		abinspiration_cart_link();

		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}




if (! is_admin()  ) { add_filter('wp_nav_menu_items','abinspiration_header_cart', 10, 2); }
if ( ! function_exists( 'abinspiration_header_cart' )) {
	function abinspiration_header_cart( $nav, $args) {
	global $ab_woocommerce;
	 if ( is_woocommerce_activated() ) {
			if ( is_cart()  ) {
				$class = 'current-menu-item';
			} else {
				$class = '';
			}
			
if ( $ab_woocommerce['menu'] == '1')   $menu = "primary"; if ( $ab_woocommerce['menu'] == '2') $menu = "headermenu"; 
		 
 if ( $args->theme_location == ''.$menu.'' && $ab_woocommerce['menu'] !== '3')
    return $nav.'
   
			<li style="float:right" class="cart-in-menu current-menu-item">
				 <a class="cart-contents" href="'. wc_get_cart_url() .'" title="">
							
								 <span class="amount">'. WC()->cart->get_cart_subtotal() .'</span> 
<span class="count">'. wp_kses_data( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'storefront' ), WC()->cart->get_cart_contents_count() ) ).'</span>

</a>

</li>



';
				
		return $nav;
		
		}
	}
}




add_filter( 'woocommerce_get_price_html', 'ab_price_free_zero_empty', 100, 2 );
  
function ab_price_free_zero_empty( $price, $product ){
 
if ( '' === $product->get_price() || 0 == $product->get_price() ) {
    $price = '<span class="woocommerce-Price-amount amount">БЕСПЛАТНО</span>';
} 
 
return $price;
}

