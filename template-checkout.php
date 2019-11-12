<?php
/**
 * Template Name: Шаблон для страниц магазина
 * @package WordPress
 * @subpackage Inspiration
 * @since Inspiration 1.0
 */
get_header(); ?>
		<div id="container-full" class="one-column">

			<div id="content" role="main">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<div class="entry-box ab-inspiration-woocommerce-entry">				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<h1 class="entry-title"><?php the_title(); ?></h1>
					

					<div class="entry-content">
					<div class="post-font">

						<?php the_content(); ?>
					</div>

						
				

					</div><!-- .entry-content -->
					
					

				</div><!-- #post-## -->

				
<?php endwhile; ?>

			</div><!-- #content --> </div>
		</div><!-- #container -->
<?php get_footer(); ?>