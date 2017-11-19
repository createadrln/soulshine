<?php
/*
Template Name: One Column Training Page
*/
?>

<?php get_header(); ?>

<div id="content">

    <div id="inner-content" class="wrap cf page-training">

        <div id="main" class="cf" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/ContactPage">

                    <header class="article-header">

	                    <h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>

                    </header> <?php // end article header ?>

                </article>

            <?php endwhile; endif; ?>

	        <ul class="products-grid cf">

		        <?php
		        $args = array( 'post_type' => 'product', 'posts_per_page' => 10, 'product_cat' => 'online-training', 'orderby' => 'desc' );
		        $loop = new WP_Query( $args );

		        while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

			        <li class="item m-all t-1of2 d-1of2 cf">

				        <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

					        <?php woocommerce_show_product_sale_flash( $post, $product ); ?>

					        <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>

					        <h3><?php the_title(); ?></h3>

					        <p><?php the_excerpt(); ?></p>

				        </a>

				        <div class="price-box">
					        <span class="price"><?php echo $product->get_price_html(); ?></span>
				        </div>

				        <div class="actions">
					        <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
				        </div>

			        </li>

		        <?php endwhile; ?>

		        <?php wp_reset_query(); ?>

	        </ul><!--/.products-->

        </div>

    </div>

</div>

<?php get_footer(); ?>
