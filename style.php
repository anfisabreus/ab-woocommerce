<?php function ab_woocommerce_css_style() { 
global $ab_woocommerce, $post;
$color = $ab_woocommerce['bg_text_cat'];
$rgbaul = hex2rgba($color, $ab_woocommerce['bg_text_cat_opacily']);
$ab_woocommerce = get_option('ab_woocommerce');?>
<style type="text/css"> 
<?php  if (is_page_template('template-homepage.php'))  { ?>#content-main { -moz-border-radius:<?php echo $ab_woocommerce['homepage_border_round'];?>px !important; -webkit-border-radius:<?php echo $ab_woocommerce['homepage_border_round'];?>px !important; border-radius:<?php echo $ab_woocommerce['homepage_border_round'];?>px !important;
<?php if ($ab_woocommerce['homepage_border'] == 1) { ?> border:1px solid <?php echo $ab_woocommerce['homepage_border_color'];?> !important;
<?php } else { ?> border:none !important; <? } ?> overflow:hidden;margin-top: <?php echo $ab_woocommerce['margin_top'];?>px !important; margin-bottom: <?php echo $ab_woocommerce['margin_bottom'];?>px !important; width:<?php echo $ab_woocommerce['homepage_width']; ?>!important;} #main {width: 100% !important;margin: 0 auto !important;padding-top: 0px !important;
}

<?php } ?>

.cbp-l-caption-buttonLeft.buy,  .cbp-s-caption-buttonLeft.buy,  .cbp-m-caption-buttonLeft.buy, .cbp-l-caption-buttonRight {
background-color:<?php echo $ab_woocommerce['katalog_button_color']; ?>!important;
}
a.cbp-l-caption-buttonRight {text-decoration:none;}

.img-wrap h3, h2.woocommerce-loop-product__title {font-weight:normal !important;}
.woocommerce ul.products li.product h3, .cart_totals.calculated_shipping h2, .woocommerce-billing-fields h3, h3#order_review_heading, .woocommerce-shipping-fields h3, h2.woocommerce-loop-product__title {font-family: <?php echo of_get_option('fonts_blog');?> !important}
.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button {font-weight:normal !important; padding:6.3px 25px;}
.woocommerce .widget_price_filter .ui-slider-horizontal {    height: .3em;}
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle {width: .5em}
.woocommerce ul.cart_list li a, .woocommerce ul.product_list_widget li a {font-weight:normal !important;}
.widget_price_filter .price_slider_wrapper .ui-widget-content {background: rgba(0,0,0,.1) !important;border-radius: 1em;}
.woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle {background: <?php echo of_get_option('button_color'); ?> !important;}
.woocommerce .woocommerce-info {color: #333!important; border-top-color:<?php echo  of_get_option('button_color'); ?>!important;}
.woocommerce .woocommerce-info:before {color: <?php echo  of_get_option('button_color'); ?>;}
.woocommerce .woocommerce-info a {color: #333!important; border-top-color:<?php echo  of_get_option('button_color'); ?>;}

.woocommerce #content table.cart td.actions .input-text, .woocommerce table.cart td.actions .input-text, .woocommerce-page #content table.cart td.actions .input-text, .woocommerce-page table.cart td.actions .input-text {width: 150px;height: 41px;}
    
h1.product_title.entry-title {color: <?php echo of_get_option('title_single'); ?> }
.woocommerce div.product .stock {color: <?php echo of_get_option('linkslink_colorpicker'); ?> } 
#tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli a:hover, #tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli a:after { color:<?php echo of_get_option('linkshover_colorpicker'); ?> }
#tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli.ui-tabs-active a  {color:<?php echo of_get_option('linkshover_colorpicker'); ?>}


#content .woocommerce div.product .woocommerce-tabs ul.tabs li.active a {background:<?php echo of_get_option('button_color'); ?>!important; color:<?php echo of_get_option('button_color_text'); ?> !important; font-weight:normal; }

#tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli {background:#fff!important; }
#tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli a {color:#333 !important; }
#tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli.ui-tabs-active {background:<?php echo of_get_option('button_color'); ?>!important;}
#tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli.ui-tabs-active a { color:<?php echo of_get_option('button_color_text'); ?> !important;}
#content.ab-inspiration-woocommerce-content, .ab-inspiration-woocommerce-entry {width:100% !important}
#container.ab-inspiration-woocommerce-container{ width: <?php if ( $ab_woocommerce['sidebar'] == '1') { echo '770px !important'; } else { echo '100% !important'; } ?>; }

.shop-widget
{
<?php if ( $ab_woocommerce['sidebar'] == '1') { echo 'width:270px !important; float:left;'; } else { ''; } ?>

}


.woocommerce .woocommerce-error {border-top-color: <?php echo of_get_option('bullets_color3'); ?> }
.woocommerce .woocommerce-error:before{color: <?php echo of_get_option('bullets_color3'); ?> }
.woocommerce .woocommerce-message {border-top-color: <?php echo of_get_option('bullets_color2'); ?>}
.woocommerce .woocommerce-message:before{color: <?php echo of_get_option('bullets_color2'); ?>}

.woocommerce .woocommerce-info {border-top-color: <?php echo of_get_option('bullets_color'); ?> !important}
.woocommerce .woocommerce-info:before{color: <?php echo of_get_option('bullets_color'); ?> }


.product-tabs {width:68%; float:right}


.woocommerce .post-font ul.products li.product, .woocommerce-page .post-font ul.products li.product {margin-bottom:2.5em !important}

.woocommerce ul.products li.product h3, h2.woocommerce-loop-product__title {font-size:1.1em !important; padding-left: 20px !important; padding-right:20px !important;}
tr.cart_item td.product-price, tr.cart_item td.product-subtotal, tr.cart_item td.product-total, tr.cart-subtotal td, tr.order-total td {min-width:100px; padding:0px !important; text-align: center;}


 tr.cart_item td.product-name {font-size:14px}
 table.shop_table tr.cart_item td {padding-top: 20px !important; padding-bottom: 20px !important}
 table.shop_table tr.cart-subtotal td {padding-top: 10px !important; padding-bottom: 10px !important; border-top:none !important}
 table.shop_table tr.order-total td,  table.shop_table tr.order-total th, table.shop_table tr.cart-subtotal th  {padding-top: 10px !important; padding-bottom: 10px !important;}
 th.product-total,  th.product-subtotal, th.product-price {text-align: center;}
 
 form.woocommerce-checkout input {padding:5px 10px;}
 .select2-container .select2-choice {padding:7px 10px 6px  10px; border-radius:0px;}
 form.woocommerce-checkout textarea {padding:10px;}
 

#container-full.woocommerce .entry-content.post-font  {padding-top: 0px; }

<?php if ($ab_woocommerce['bg_level2'] !=='') { ?> .home-level2 {  background:<?php echo $ab_woocommerce['bg_level2']; ?>} <?php } ?>
<?php if ($ab_woocommerce['bg_level3'] !=='') { ?> .home-level3 {background:<?php echo $ab_woocommerce['bg_level3']; ?>}<?php } ?>

 
.homepage-image2-img:before {    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: -1;
    opacity: 0;
    -webkit-transition: .3s;
    transition: .3s; 
    }
    .homepage-image2-img:before:hover {
     background: -moz-linear-gradient(top,rgba(141,198,63,1),rgba(141,198,63,0.1) 0%,rgba(141,198,63,0.1) 100%);
    background: -webkit-linear-gradient(top,rgba(141,198,63,0.1) 0%,rgba(141,198,63,1)100%);
    background: linear-gradient(to bottom, rgba(141,198,63,0.1) 0%,rgba(141,198,63,1)100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1abadf25', endColorstr='#badf25',GradientType=0 );
    }


.abinspiration-product-ads, .abinspiration-product-categories, .abinspiration-recent-section, .abinspiration-on-sale-section, .abinspiration-best-selling-section, .abinspiration-popular-section, .abinspiration-featured-section, .abinspiration-product-form, .abinspiration-posts{max-width:1200px; margin:0 auto} 
.homepageitemstabs {width:1060px; display:table; padding:0px; margin:0 auto}
#otzyvy-magasin {margin: 30px 0;}

.cbp-l-grid-slider-testimonials-body {max-width:1060px}
  
.home-level2 .abinspiration-product-categories {<?php if ($ab_woocommerce['padding'] == '1') { ?>padding:25px;<?php } else { ?> padding:0px;<?php } ?> 
} 

.home-level2
 {padding:<?php echo $ab_woocommerce['padding_top1']; ?>px 0 <?php echo $ab_woocommerce['padding_bottom1']; ?>px  0;}
 
.home-level3
 {margin:<?php echo $ab_woocommerce['padding_top3']; ?>px 0 <?php echo $ab_woocommerce['padding_bottom3']; ?>px  0;}
 
.home-level3 .abinspiration-product-ads {display:table; padding:<?php if  ($ab_woocommerce['padding_level3'] == '1') { echo '25px';} else { echo '0px 0px';} ?>;}

.home-level-featured
{margin:<?php echo $ab_woocommerce['padding_top_featured']; ?>px 0 <?php echo $ab_woocommerce['padding_bottom_featured']; ?>px  0;
<?php if ($ab_woocommerce['custom_bg1'] !== '') { ?> background: url(<?php echo $ab_woocommerce['custom_bg1'];?>) <?php echo $ab_woocommerce['hp_repeat_bg1'];?> <?php echo $ab_woocommerce['hp_repeat_position1'];?>; <?php } ?> background-color: <?php echo $ab_woocommerce['hp_fon_color1'];?>; background-size:<?php echo $ab_woocommerce['background_size'];?>}

.home-level-posts
{margin:<?php echo $ab_woocommerce['padding_top_posts']; ?>px 0 <?php echo $ab_woocommerce['padding_bottom_posts']; ?>px  0;
<?php if ($ab_woocommerce['custom_bg6'] !== '') { ?> background: url(<?php echo $ab_woocommerce['custom_bg6'];?>) <?php echo $ab_woocommerce['hp_repeat_bg6'];?> <?php echo $ab_woocommerce['hp_repeat_position6'];?>; <?php } ?>background-color: <?php echo $ab_woocommerce['hp_fon_color6'];?>; background-size:<?php echo $ab_woocommerce['background_size6'];?>}


.home-level5
 {padding:<?php echo $ab_woocommerce['padding_top5']; ?>px 0 <?php echo $ab_woocommerce['padding_bottom5']; ?>px  0;
<?php if ($ab_woocommerce['custom_bg6'] !== '') { ?>background: url(<?php echo $ab_woocommerce['custom_bg5'];?>) <?php echo $ab_woocommerce['hp_repeat_bg5'];?> <?php echo $ab_woocommerce['hp_repeat_position5'];?> ; <?php } ?>background-color:<?php echo $ab_woocommerce['bg_level5'];?>; background-size:<?php echo $ab_woocommerce['background_size5'];?>}

.abinspiration-testimonials-section {display:table; <?php if  ($ab_woocommerce['padding_level_testimonials'] == '1') { echo 'width:1060px;';} else { echo 'padding:0px 0px; width:1200px;';} ?>;  margin:0 auto}


.abinspiration-featured-section {display:table; padding:<?php if  ($ab_woocommerce['padding_level_featured'] == '1') { echo '25px';} else { echo '0px 0px';} ?>;}

.abinspiration-posts {width:100%;display:table; padding:<?php if  ($ab_woocommerce['padding_level_posts'] == '1') { echo '25px';} else { echo '0px 0px';} ?>;}



.woocommerce ul.products {margin-bottom:0px !important}
 
.woocommerce ul.products li.product:hover, .woocommerce-page ul.products li.product:hover,.post-homepage-shop:hover {padding:0px; }
.woocommerce ul.products li.product .img-wrap .star-rating{margin:0px 20px;}
 .woocommerce ul.products li.product,  .woocommerce ul.products li.product:hover {padding-bottom:20px;}
.woocommerce ul.products li.product .img-wrap .add_to_cart_button, .woocommerce ul.products li.product .img-wrap .product_type_grouped, .woocommerce ul.products li.product .img-wrap .ajax_add_to_cart   {margin-bottom:20px;}
.woocommerce ul.products li.product .img-wrap h3, h2.woocommerce-loop-product__title {font-size:<?php echo $ab_woocommerce['font_size_items']; ?>px !important;margin:0px !important;}
.woocommerce ul.products li.product .img-wrap .star-rating {margin:0px auto 10px auto}
  
  
.woocommerce ul.products li.product .price del {display:inline;}

.woocommerce div.img-wrap h3, h2.woocommerce-loop-product__title {position:relative;z-index:3; cursor: pointer;}


.home-level3 .abinspiration-product-ads a.ads-homepage  {margin-top:30px;display:table !important;  background:<?php echo $ab_woocommerce['shop_button_homepage_ads']; ?>; color:<?php echo $ab_woocommerce['shop_button_homepage_text_ads']; ?> !important; padding:20px 20px; font-size:18px; text-transform:uppercase;  -webkit-transition: all 0.5s; transition: all 0.5s; text-decoration:none}
 
 .home-level3 .abinspiration-product-ads a.ads-homepage:hover { background:<?php echo $ab_woocommerce['shop_button_homepage_hover_ads']; ?>; color: <?php echo $ab_woocommerce['shop_button_homepage_text_hover_ads']; ?>;  -webkit-transition: all 1s;
    transition: all 1s;}
    
 .home-level3 .abinspiration-product-ads a.ads-homepage { <?php if  ($ab_woocommerce['button_align'] == '1') { echo 'float:left';} elseif ($ab_woocommerce['button_align'] == '2') { echo 'float:right';}  else { echo 'margin:0 auto';} ?> }    
    
    

 .woocommerce ul.products li.product h3, h2.woocommerce-loop-product__title {color: <?php echo of_get_option('post_headings'); ?> !important;}

.home-level6 .abinspiration-product-form form {text-align:right;}  
 .home-level6 .abinspiration-product-form input.show-form-button, .home-level6 .abinspiration-product-form div.show-form-button {

   background:<?php echo $ab_woocommerce['shop_button_homepage_form']; ?>; color: <?php echo $ab_woocommerce['shop_button_homepage_text_form']; ?> !important;
    padding: 13px 20px;
    font-size: 18px;
    text-transform: uppercase;
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
    text-decoration: none; margin-left:2px;
       
       border:none;
    box-sizing: border-box !important;
    font-size:18px !important;
    <?php if ($ab_woocommerce['ab_sub_form_smart'] == '3'){ ?> width: 100%;<?php } else { ?>  width:225px;<?php } ?>
    }
   

.shopform-title {line-height:0}
 
.home-level6 .abinspiration-product-form input.show-form-button:hover { background:<?php echo $ab_woocommerce['shop_button_homepage_hover_form']; ?>; color: <?php echo $ab_woocommerce['shop_button_homepage_text_hover_form']; ?>;  -webkit-transition: all 1s; transition: all 1s;}
    
.home-level6 .abinspiration-product-form input.shop-form-input {font-size:18px !important;height:55px; border:1px solid #eaeaea; width:318px; padding:20px 10px;}

.home-level6
 {margin:<?php echo $ab_woocommerce['padding_top6']; ?>px 0 <?php echo $ab_woocommerce['padding_bottom6']; ?>px  0;
<?php if ($ab_woocommerce['custom_bg6'] !== '') { ?> background: url(<?php echo $ab_woocommerce['custom_bg6'];?>) <?php echo $ab_woocommerce['hp_repeat_bg6'];?> <?php echo $ab_woocommerce['hp_repeat_position6'];?>; <?php } ?> background-color:<?php echo $ab_woocommerce['bg_level6'];?>; background-size:<?php echo $ab_woocommerce['background_size6'];?>; border-top:5px solid <?php echo $ab_woocommerce['border_top_form']; ?>;}

.home-level6 .abinspiration-product-form {padding:25px 25px; margin:0 auto; max-width:1060px; display:table;}

#content .home-level6 p {margin-bottom:0px !important; line-height:1.2 !important}

<?php if ($ab_woocommerce['cat_layout'] == '1') { ?>


.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.first{float:left; width:55.8% !important; background:#fff; margin-right:30px;}
.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.first div.category-bg{height:630px;}
.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.last, .home-level2 .woocommerce.columns-3 ul.products li.product-category.product {background:#fff; padding:0px;  margin-right:0px; margin-bottom:0px; display:block;width:41.2%; max-heightheight:300px; border:none !important; box-shadow:none; margin-bottom: 0px !important;  float:right }
.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.last  div.category-bg, .home-level2 .woocommerce.columns-3 ul.products li.product-category.product  div.category-bg{height:300px;}

.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.last div.category-bg{margin-top:30px;}

<?php } else { ?>


.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.first, .home-level2 .woocommerce.columns-3 ul.products li.product-category.product.last, .home-level2 .woocommerce.columns-3 ul.products li.product-category.product {background:#fff; padding:0px;  margin-right:0px; margin-bottom:0px; display:block;width:31.4% !important; height:300px !important;border:none !important; box-shadow:none; margin-bottom: 0px !important;  float:left; margin-right:30px; }
.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.first div.category-bg, .home-level2 .woocommerce.columns-3 ul.products li.product-category.product.last div.category-bg, .home-level2 .woocommerce.columns-3 ul.products li.product-category.product div.category-bg {padding-top:300px !important;}
.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.last div.category-bg {margin-right:0px;margin-top:0px;}
<?php } ?>



.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.last img, .home-level2 .woocommerce.columns-3 ul.products li.product-category.product img, .home-level2 .woocommerce.columns-3 ul.products li.product-category.product.first img {margin-bottom:0px !important;  margin-right:0px;}

#content .home-level2 .woocommerce.columns-3 ul.products li.product-category.product.first img {max-width:800px !important}

<?php if ($ab_woocommerce['cat_layout'] == '1') { ?>

.home-level2 .cat-title-homepage {z-index:3;text-align:left; position:absolute; top:30px; font-family:<?php echo $ab_woocommerce['category_headline_font']; ?>; font-size:<?php echo $ab_woocommerce['category_headline_size']; ?>px !important;  padding:0px  <?php echo $ab_woocommerce['image_border']; ?>; left:1px; color: <?php echo $ab_woocommerce['category_headline_color']; ?>;height: 70%; width:100%;
font-weight:<?php if ($ab_woocommerce['category_headline_strong'] ==  1)  {echo 'bold';} else {echo 'normal';}?>;
font-style:<?php if ($ab_woocommerce['category_headline_italic'] ==  1)  {echo 'italic';} else {echo 'normal';}?>;  }

.home-level2 .cat-title-homepage span.cat-title-bg {display:table; background:<?php echo $rgbaul; ?>; padding:5px 20px;-webkit-transition: all 1s;
    transition: all 1s;}

.home-level2 .shop_cat_desc {display:table; margin-top:5px; text-align:left; font-family:<?php echo $ab_woocommerce['category_desc_font']; ?>; font-size:<?php echo $ab_woocommerce['category_desc_size']; ?>px !important; color: <?php echo $ab_woocommerce['category_desc_color']; ?>;font-weight:<?php if ($ab_woocommerce['category_desc_strong'] ==  1)  {echo 'bold';} else {echo 'normal';}?>;font-style:<?php if ($ab_woocommerce['category_desc_italic'] ==  1)  {echo 'italic';} else {echo 'normal';}?>; background:<?php echo $rgbaul; ?>; padding:5px 20px;}

<?php } else { ?>

.home-level2 .cat-title-homepage {z-index:3;text-align:center; padding:20px 0; position:absolute; bottom:0px; font-family:<?php echo $ab_woocommerce['category_headline_font']; ?>; font-size:<?php echo $ab_woocommerce['category_headline_size']; ?>px !important;  padding:0px  <?php echo $ab_woocommerce['image_border']; ?>; left:0px; color: <?php echo $ab_woocommerce['category_headline_color']; ?>;width:100%; display:grid; 
font-weight:<?php if ($ab_woocommerce['category_headline_strong'] ==  1)  {echo 'bold';} else {echo 'normal';}?>;
font-style:<?php if ($ab_woocommerce['category_headline_italic'] ==  1)  {echo 'italic';} else {echo 'normal';}?>;  }

.home-level2 .cat-title-homepage span.cat-title-bg {display:table; background:<?php echo $rgbaul; ?>; padding:10px 0px;-webkit-transition: all 1s;
    transition: all 1s;}

.home-level2 .shop_cat_desc {display:table; margin-top:5px; text-align:left; font-family:<?php echo $ab_woocommerce['category_desc_font']; ?>; font-size:<?php echo $ab_woocommerce['category_desc_size']; ?>px !important; color: <?php echo $ab_woocommerce['category_desc_color']; ?>;font-weight:<?php if ($ab_woocommerce['category_desc_strong'] ==  1)  {echo 'bold';} else {echo 'normal';}?>;font-style:<?php if ($ab_woocommerce['category_desc_italic'] ==  1)  {echo 'italic';} else {echo 'normal';}?>; background:<?php echo $rgbaul; ?>; padding:5px 20px;}

<?php } ?>

.home-level2 .tm_banners_grid_widget_banner_link {position: relative;overflow: hidden;display: block;}

.home-level2 .tm_banners_grid_widget_banner_link:before {content:"";position: absolute;opacity: 0;-webkit-transition: all 3s;transition: all 3s;width:100%;height:100%;display:block;}
   
.home-level2 .tm_banners_grid_widget_banner_link:hover:before {top: 0px; opacity: <?php echo $ab_woocommerce['border_opacity']; ?>;
<?php if  ($ab_woocommerce['border_static'] == '2') { ?> border: <?php echo $ab_woocommerce['image_border']; ?> solid <?php echo $ab_woocommerce['image_border_color']; ?><? }  ?> ;-webkit-transition:  1s all ease;transition:  1s all ease;}

.home-level2 .tm_banners_grid_widget_banner_link:before {top: 0px; opacity: <?php echo $ab_woocommerce['border_opacity']; ?>;
 <?php if  ($ab_woocommerce['border_static'] == '1') { ?> border: <?php echo $ab_woocommerce['image_border']; ?> solid <?php echo $ab_woocommerce['image_border_color']; ?><? }  ?>;z-index:1}
 .home-level2 .tm_banners_grid_widget_banner_link:before {top: 0px; opacity: <?php echo $ab_woocommerce['border_opacity']; ?>;
 <?php if  ($ab_woocommerce['border_static'] == '0') { ?> border:0px<? }  ?>;z-index:1}
 
#content .home-level2 .woocommerce.columns-3 ul.products li.product-category.product .img-wrap:before {content: "";position: absolute;top: 0;right: 0;left: 0;bottom: 0;opacity:0;-webkit-transition:  1s all ease;transition:  1s all ease;z-index: 1;}

#content .home-level2 .woocommerce.columns-3 ul.products li.product-category.product .img-wrap:hover:before {top: 0px; opacity: <?php echo $ab_woocommerce['bg_cat_opacity']; ?>;<?php if  ($ab_woocommerce['bg_static'] == '2') { ?> background: linear-gradient(to right,<?php echo $ab_woocommerce['image_bg_color_hoverone']; ?>,<?php echo $ab_woocommerce['image_bg_color_hover']; ?>); opacity: <?php echo $ab_woocommerce['bg_cat_opacity']; ?>; <?php } else { echo 'transparent';} ?>;}

#content .home-level2 .woocommerce.columns-3 ul.products li.product-category.product .img-wrap:before{ top: 0px; <?php if  ($ab_woocommerce['bg_static'] == '1') { ?>background: linear-gradient(to right,<?php echo $ab_woocommerce['image_bg_color_hoverone']; ?>,<?php echo $ab_woocommerce['image_bg_color_hover']; ?>);  opacity:<?php echo $ab_woocommerce['bg_cat_opacity']; ?>;<?php } else { echo 'transparent';} ?>; z-index:1;}

#content .home-level2 .woocommerce.columns-3 ul.products li.product-category.product .img-wrap:before{ top: 0px; <?php if  ($ab_woocommerce['bg_static'] == '0') { ?>background: transparent; z-index:1;} <?php } ?> }
     
     


.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.last .button-homepage, .home-level2 .woocommerce.columns-3 ul.products li.product-category.product .button-homepage {display:none}

.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.first .button-homepage {display:block; position:absolute; bottom:30px; left:30px; background:<?php echo $ab_woocommerce['shop_button_homepage']; ?>; color:<?php echo $ab_woocommerce['shop_button_homepage_text']; ?>; padding:20px; font-size:20px; text-transform:uppercase;  -webkit-transition: all 0.5s; transition: all 0.5s; z-index:3}

.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.first .button-homepage:hover { background:<?php echo $ab_woocommerce['shop_button_homepage_hover']; ?>; color: <?php echo $ab_woocommerce['shop_button_homepage_text_hover']; ?>;  -webkit-transition: all 1s;
    transition: all 1s;}
    

.cbp-item.testimonials-animation  .avatar {margin:0px; padding:0px;}
 
.cbp-item.testimonials-animation img.avatar-comment-homepage {border-radius:50%; position: relative; top:-50px; z-index:999; padding:0px !important; border: <?php echo $ab_woocommerce['otzyvy_border']; ?> solid <?php echo $ab_woocommerce['otzyvy_border_color']; ?> !important; }
 .shop-otzyv-home {text-align:center; margin-top:10px;  margin-bottom:10px;}
 .shop-otzyv-image:before{
 
 
   font-size: 60px;
    font-weight: 700;
    width: 100%;
    text-align: center;
    position: absolute;
    top: 55px;
    left: 0;
    content: '\201C';
    font-family: "Times New Roman", Georgia, Serif;
    z-index: 11;
    height: 50px;
    }
  .shop-otzyv-image  {clear:both; width:105px; margin:0 auto; overflow: visible;}
  
.home-level5 .cbp-item-wrapper {overflow: visible; margin-top: 50px; border: <?php echo $ab_woocommerce['otzyvy_border']; ?> solid <?php echo $ab_woocommerce['otzyvy_border_color']; ?>; background:#fff;}
  
.star-rating span:before {content: "\f005\f005\f005\f005\f005"; top: 0;position: absolute;left: 0; color:  <?php echo $ab_woocommerce['rating_color']; ?>!important;}
.woocommerce p.stars a {color:  <?php echo $ab_woocommerce['rating_color']; ?>!important;} 
.woocommerce span.onsale, span.onsale, span.onsale:after { font-weight:normal;background-color: <?php echo $ab_woocommerce['rating_color']; ?> !important}


.cbp-slider-edge .cbp-nav-next, .cbp-slider-edge .cbp-nav-prev {top:50px;}

.cbp-slider-edge .cbp-nav-prev {left:20px}
.cbp-slider-edge .cbp-nav-next {right:20px}
  
  
  
ul.wc_payment_methods,td.product-price .woocommerce-Price-amount, td.product-subtotal .woocommerce-Price-amount, .woocommerce-info, .woocommerce-page #content div.product div.summary, div.description, .woocommerce-MyAccount-navigation, .woocommerce-MyAccount-content, .shop_table.woocommerce-checkout-review-order-table {font-size:16px}
    
    #customer_details input, #customer_details textarea, #customer_details select, .country_select, .select2-chosen {font-size:16px}
    
 .storefront-featured-products.homepageitemstabs {margin-top:20px;border:1px solid #eaeaea; padding:0px }
.storefront-featured-products.homepageitemstabs .section-title {color:#fff;background: #000000; margin:0px; padding:10px 20px}
.storefront-featured-products.homepageitemstabs  ul.products { margin:20px}   
    



 
 .woocommerce-Tabs-panel.woocommerce-Tabs-panel--description.panel.entry-content .contet-tab, .woocommerce ul.products li.product, .woocommerce-page ul.products li.product, .woocommerce ul.products li.last, .woocommerce-page ul.products li.last, .woocommerce span.onsale, span.onsale, .woocommerce #reviews #comments ol.commentlist li, .woocommerce .quantity .qty, .woocommerce #content div.product div.images img, .woocommerce div.product div.images img, .woocommerce-page #content div.product div.images img, .woocommerce-page div.product div.images img, a.ads-homepage, div.button-homepage, .home-level2 .cat-title-homepage span.cat-title-bg, .home-level2 .shop_cat_desc, div.show-form-button, input.show-form-button,.shop-form-input {<?php if ( of_get_option('buttons_shape') == '3px'){ echo 'border-radius: 3px; -moz-border-radius: 3px;-webkit-border-radius: 3px;';} else { echo 'border-radius: 0px; -moz-border-radius: 0px;-webkit-border-radius: 0px;' ?>;  <?php } ?> }
 
.abinspiration-product-ads-img {display:table-cell; vertical-align:middle; width:45%}

.abinspiration-product-ads-text { width:55%;display:table-cell; vertical-align:middle; padding-left:30px; }
.abinspiration-product-form-img { <?php if ($ab_woocommerce['ab_sub_form_smart'] == '3'){ ?> width:60%;<?php } else { ?>  width:43%;<?php } ?>     display: table-cell;vertical-align: middle !important; }
.abinspiration-product-form-input{width:100%; padding-left:25px;display: table-cell;vertical-align: middle !important;}

@media only screen and (max-width: 690px) {
.home-level1,.home-level2,.home-level3,.home-level4,.home-level5, .homepageitemstabs, .post-homepage-shop, li.product-category, #content .woocommerce div.product .woocommerce-tabs ul.tabs li.active a, #tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli.ui-tabs-active a , #tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli a:hover, #tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli a:after, .woocommerce div.product .woocommerce-tabs ul.tabs li  {width:100% !important}
 .post-homepage-shop {margin-bottom:10px;}
 .entry-box.ab-inspiration-woocommerce-entry {padding:20px; border:none; border: none !important}
 
 .woocommerce div.product .woocommerce-tabs ul.tabs li a  {font-size:1.2em}

table.shop_table tr.cart_item td, #add_payment_method .cart-collaterals .cart_totals table td, #add_payment_method .cart-collaterals .cart_totals table th, .woocommerce-cart .cart-collaterals .cart_totals table td, .woocommerce-cart .cart-collaterals .cart_totals table th, .woocommerce-checkout .cart-collaterals .cart_totals table td, .woocommerce-checkout .cart-collaterals .cart_totals table th {padding:20px !important}

.woocommerce #content table.cart td.actions .coupon .button.alt, .woocommerce #content table.cart td.actions .coupon .input-text+.button, .woocommerce table.cart td.actions .coupon .button.alt, .woocommerce table.cart td.actions .coupon .input-text+.button, .woocommerce-page #content table.cart td.actions .coupon .button.alt, .woocommerce-page #content table.cart td.actions .coupon .input-text+.button, .woocommerce-page table.cart td.actions .coupon .button.alt, .woocommerce-page table.cart td.actions .coupon .input-text+.button

{font-size: .6em !important;
    padding-left: 0px;
    padding-right: 0px;
}

#customer_details {width:100%}
 .one-column .entry-box {padding-left:20px; padding-right:20px}




#order_review_heading, #order_review {width:100%}


     #tabs.homepageitemstabs {clear:both; padding-top:30px;}
    #tabs.homepageitemstabs ul.homepageitemstabsul {text-align:left;  width:100%; display:inline}
#tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli {width:47%;margin-right:5px;float:left; font-size:16px; height:45px; padding:0px

    }
#tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli a:active:after {content: " \2022";
    font-size: 1.3em;
    line-height: 1;
    opacity: 0.5;
    vertical-align: middle;
    margin-left: 0.5em; margin-right: 0.5em;  }
    #tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli:last-child a:after {content: none;}
    #tabs.homepageitemstabs ul.homepageitemstabsul li.homepageitemstabsli a {text-decoration:none !important; font-weight:normal; color:#333; padding:10px 5px; display:block;}
    .woocommerce ul.products li.product, .woocommerce-page ul.products li.product, .woocommerce-page[class*=columns-] ul.products li.product, .woocommerce[class*=columns-] ul.products li.product, .related.products ul.products li, .up-sells.upsells.products ul.products li {margin-right:10px !important;}
.woocommerce ul.products li.product:nth-child(2n), .woocommerce-page ul.products li.product:nth-child(2n) {margin-right: 0px  !important;}
.woocommerce div.related.products  ul.products li.product, .woocommerce div.up-sells.upsells.products ul.products li.product  {margin-bottom:20px;}
.product-tabs {width:100%;}
<?php if (is_page_template('template-homepage.php') ) { ?> #content-main {padding:0 20px !important} <?php } ?> 
.woocommerce ul.products li.product:nth-child(2n), .woocommerce-page ul.products li.product:nth-child(2n), .woocommerce-page[class*=columns-] ul.products li.product:nth-child(2n), .woocommerce[class*=columns-] ul.products li.product:nth-child(2n){float:left}

.home-level2 .woocommerce.columns-3 ul.products li.product-category.product.first {width:100% !important; margin-bottom:30px !important;}

.woocommerce[class*=columns-] ul.products li.product, .up-sells.upsells.products ul.products li {width:100% !important; }


.abinspiration-product-ads-img, .abinspiration-product-ads-text {width:100%; display:block; padding-left:0px}
.abinspiration-product-ads-img {margin-bottom:30px;}
.home-level6 .abinspiration-product-form {width:100%; display:block}
.abinspiration-product-form-img {  width:100%;display: block;}
.home-level6 .abinspiration-product-form input.show-form-button, .home-level6 .abinspiration-product-form div.show-form-button, .home-level6 .abinspiration-product-form input.shop-form-input {width:100%; margin-left:0px}
.abinspiration-product-form-input{padding-left:0px;display: block;}
.abinspiration-testimonials-section {width:100%} 
.abinspiration-product-form-input {margin-top:20px;}

}
.related.products ul.products li, .up-sells.upsells.products ul.products li {width:23.49% !important}

@media only screen and (max-width: 600px) {
#container.ab-inspiration-woocommerce-container {width:100% !important}
.related.products ul.products li, .up-sells.upsells.products ul.products li {width:100% !important}
}



.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt {padding: 13px 10px;margin-left: 0px;}

.woocommerce-cart .wc-proceed-to-checkout a.checkout-button {padding:20px;}




.woocommerce .widget_shopping_cart .cart_list li, .woocommerce.widget_shopping_cart .cart_list li {padding-left:0px;}  .woocommerce.widget_recently_viewed_products .product_list_widget, .woocommerce.widget_products .product_list_widget, .woocommerce.widget_top_rated_products .product_list_widget {margin-left: 0 !important;}
.woocommerce .widget_shopping_cart ul.cart_list li.mini_cart_item a.remove {    position: absolute;top: 0; left:90%;right: 0 !important; padding-top:0px;}
.woocommerce a.remove:hover  {background:transparent; color:red !important; text-decoration:none}
    .woocommerce ul.cart_list li img, .woocommerce ul.product_list_widget li img, .woocommerce-page ul.cart_list li img, .woocommerce-page ul.product_list_widget li img {float:left; margin-right:20px;}
div.widget_shopping_cart_content p.buttons a.button {width:100%}
.woocommerce ul.cart_list li img, .woocommerce ul.product_list_widget li img {width:50px;}
.woocommerce ul.cart_list li a:link, .woocommerce ul.product_list_widget li a:link, .woocommerce ul.cart_list li a:visited, .woocommerce ul.product_list_widget li a:visited, .woocommerce ul.cart_list li span {color:#333 !important; font-size:16px}

.woocommerce ul.cart_list li a:link {font-size:12px}

.woocommerce tr th {
    color: #333 !important;
    font-size: 16px !important;
    font-weight: bold;
    line-height: 18px;
    padding: 9px 24px;
    background: #eaeaea;
    width: 50px !important;
    border: 1px solid #ccc;
    text-align:left !important
    
}

.woocommerce tr td
{border:1px solid #eaeaea !important}
.woocommerce ul#shipping_method label {font-size: 16px !important; font-weight:normal}
.woocommerce-Price-currencySymbol .fa {display:inline}
 #content .woocommerce div.product .woocommerce-tabs ul.tabs li a, span.color-link.color_and_text_link a {color:#333 !important;}   
#content .woocommerce a.woocommerce-LoopProduct-link, #content .woocommerce .woocommerce-breadcrumb a, #content .woocommerce .woocommerce-breadcrumb {color:#777  !important; font-size:15px} 
.rcorners {border-radius:0px; margin:0px;}
 .woocommerce ul.product_list_widget li {padding-bottom:10px !important; border-bottom:1px solid #eaeaea}
.otzyv-tovar-magazin { clear:right; text-align:center; margin-bottom:10px;color: #141414;font-size: 18px;line-height: 30px;font-style: italic; padding:0 60px;}

.entry-box.ab-inspiration-woocommerce-entry .woocommerce ul.products li.product-category.product h3 {font-size:16px !important; padding-bottom:20px;}
mark {background:#fff}


.woocommerce div.product form.cart table tr td {border:none !important; padding-left:0px !important; }
.woocommerce div.product form.cart table.group_table tr td.label label {font-weight:normal !important;}
#content .woocommerce div.product form.cart table.variations  tr td.label label {padding-top:0px !important;}
#content tr td.label { font-weight:normal !important; vertical-align:middle !important}
#content tr td.price { padding-left:20px !important; vertical-align:middle !important}
.woocommerce div.product form.cart table {margin-bottom:10px !important}
.stock.available-on-backorder, .stock.out-of-stock {font-weight:normal}
#content .woocommerce table.shop_table td {font-weight:normal !important}
.entry-content label {font-size:14px !important}
span.woocommerce-Price-amount.amount {font-weight:bold !important}

.woocommerce ul.products li.product .img-wrap .yith-wcqv-button {margin-top:10px; margin-bottom:0px}
#content .woocommerce .single .hentry, .page .hentry {margin-bottom:0px !important}
.woocommerce .quantity .qty, .woocommerce  .quantity .qty, .woocommerce table.shop_table tr.cart_item td.product-quantity  div.quantity{width:100px; height: 45px;border:1px solid #eaeaea;}
.woocommerce div.product form.cart div.quantity, .woocommerce table.shop_table tr.cart_item td.product-quantity  div.quantity {margin-right:10px;}
.woocommerce .product  div.quantity .tm-qty-plus:before,  .woocommerce table.shop_table tr.cart_item td.product-quantity  div.quantity .tm-qty-plus:before{
    position: absolute;
    top: 15px;
    font-family: 'FontAwesome';
    font-size: 11px;
    transition: .3s all ease;
}
.woocommerce .product  div.quantity .tm-qty-plus:before,  .woocommerce table.shop_table tr.cart_item td.product-quantity  div.quantity .tm-qty-plus:before {
    content: "\f067";
    right: 10px;
}

.woocommerce .product  div.quantity .tm-qty-minus, .woocommerce table.shop_table tr.cart_item td.product-quantity  div.quantity .tm-qty-minus {    width: 30px; 
    height: 100%; 
     border-right:1px solid #eaeaea;
    position: absolute; 
   }
  .woocommerce .product  div.quantity .tm-qty-minus:hover,  .woocommerce .product  div.quantity .tm-qty-plus:hover, .woocommerce table.shop_table tr.cart_item td.product-quantity  div.quantity .tm-qty-minus:hover, .woocommerce table.shop_table tr.cart_item td.product-quantity  div.quantity .tm-qty-plus:hover{ background: #eaeaea; }
.woocommerce .product  div.quantity .tm-qty-plus, .woocommerce table.shop_table tr.cart_item td.product-quantity  div.quantity .tm-qty-plus {    width: 30px; 
    height: 100%; 
    border-left:1px solid #eaeaea;
    position: absolute; 
    right:0;
    top:0
   }
   
  .woocommerce .product  div.quantity .tm-qty-minus:before, .woocommerce table.shop_table tr.cart_item td.product-quantity  div.quantity .tm-qty-minus:before {
    position: absolute;
    top: 15px;
    font-family: 'FontAwesome';
    font-size: 11px;
    transition: .3s all ease;
}
.woocommerce .product  div.quantity .tm-qty-minus:before, .woocommerce table.shop_table tr.cart_item td.product-quantity  div.quantity .tm-qty-minus:before {
    content: "\f068";
    left: 10px;
}
 
   
#content .quantity input {font-size:16px}


.woocommerce-review-link {display:none}
.qty {font-size:20px;}
.woocommerce .quantity {position:relative}
.entry-content label[for=payment_method_kassa]  {width:80%}
.woocommerce form .form-row textarea {height: 5em;}
.woocommerce-variation-price  {margin-bottom:20px}
.woocommerce-variation-price span {font-size:30px; margin-bottom:20px}
.woocommerce-variation-price ins {text-decoration:none !important}
table.group_table td.label {display:table-cell}

.shopswatchinput {display:table;text-align:center; margin:0 auto; margin-bottom:10px}
.shopswatchinput .img-wrap{display:table-cell;}
.wcvashopswatchlabel.wcvaround, .wcvaswatchinput {width:20px !important; height:20px !important}

.woocommerce div.product form.cart table.group_table td.label {text-align: left !important;
    white-space: normal;}
.woocommerce-Price-amount.amount{
    white-space: nowrap;}
    
mark {padding:0px}
.woocommerce .widget_price_filter .price_slider_amount .button   {padding:6px 10px 7px 10px}

.radio input[type="radio"], .radio-inline input[type="radio"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"] {position: relative; margin-left:0px}
    
<?php if ($ab_woocommerce['show_cat_title'] == '1') { ?> .cat-title-homepage {display:none;}<?php }  ?> 
<?php if ($ab_woocommerce['show_cat_desc'] == '1'){ ?> .shop_cat_desc { display:none !important;}<?php } ?>

</style><?php }
add_action( 'wp_head', 'ab_woocommerce_css_style' );