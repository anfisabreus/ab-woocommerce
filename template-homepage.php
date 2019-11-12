<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Витрина магазина
 *
 * @package abinspiration
 */

get_header(); ?>

<div id="container-full" class="one-column woocommerce">


			<div id="content" role="main" style="width:100%">
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content post-font" style="width:100%">
					
					 
<script> jQuery(function($) {
    $( "#tabs" ).tabs();
  });
  </script>
			<?php
			/**
			 * @hooked abinspiration_homepage_content - 10
			 * @hooked abinspiration_product_categories - 20
			 * @hooked abinspiration_recent_products - 30
			 * @hooked abinspiration_featured_products - 40
			 * @hooked abinspiration_popular_products - 50
			 * @hooked abinspiration_on_sale_products - 60
			 */
			do_action( 'homepage' ); 
			
			?>
			</div></div>

		</div><!-- #main -->
	</div><!-- #primary -->
</div>
<?php get_footer(); ?>
