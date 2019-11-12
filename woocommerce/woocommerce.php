<?php
/**
 * The template for displaying all pages.
 * @package WordPress
 * @subpackage Inspiration
 * @since Inspiration 1.0
 */


 


global $license, $status;
$license 	= get_option( 'edd_woocommerce_license_key' );
$status 	= get_option( 'edd_woocommerce_license_status' );
if ($status !== false && $status == 'valid' ) {  
 
get_header(); ?>
		<div id="container" style="float:right !important; width:770px;">
			<div id="content" role="main" style="width:770px; ">
	<div  class="entry-box" style="width:770px">
	
	<?php
	$args = array(
			'delimiter' => ' / ',
			
	);
 woocommerce_breadcrumb( $args ); 
 woocommerce_content(); ?>

	</div>
			</div><!-- #content --> 
		</div><!-- #container -->
<?php if (!is_singular('product')) { get_sidebar('shop'); } ?>
<?php get_footer();  } else { echo 'Пожалуйста, загрузите и активируйте лицензию плагина AB-Inspiration Woocommerce'; }  ?>