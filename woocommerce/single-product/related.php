<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( is_singular('product') ) {
global $post;
// get categories
$terms = wp_get_post_terms( $post->ID, 'product_cat' );
foreach ( $terms as $term ) $cats_array[] = $term->term_id;
$query_args = array( 'orderby' => 'rand', 'post__not_in' => array( $post->ID ), 'posts_per_page' => 4, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product', 'tax_query' => array(
array(
'taxonomy' => 'product_cat',
'field' => 'id',
'terms' => $cats_array
)));
$r = new WP_Query($query_args);
if ($r->have_posts()) { ?>



    <div class="related products">
        <h2><?php _e( 'Related Products', 'woocommerce' ); ?></h2>

        <?php woocommerce_product_loop_start(); ?>

            <?php while ($r->have_posts()) : $r->the_post(); global $product; ?>

                <?php wc_get_template_part( 'content', 'product' ); ?>

            <?php endwhile; // end of the loop. ?>

        <?php woocommerce_product_loop_end(); ?>

    </div>

<?php

wp_reset_query();
}
}