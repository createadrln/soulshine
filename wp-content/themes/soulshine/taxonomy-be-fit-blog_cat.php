<?php get_header(); ?>

<div id="content" class="page-training-guides">

	<div id="inner-content" class="wrap cf">

		<?php if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb('<p id="breadcrumbs">','</p>');
		} ?>

		<div id="main" class="m-all t-2of3 d-5of7 first cf" role="main">

			<h1 class="archive-title"><span><?php _e( 'Be Fit Blog Posts:', 'bonestheme' ); ?></span> <?php single_cat_title(); ?></h1>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" class="post-listing">

					<header class="article-header">

						<h3 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
						<p class="byline vcard"><?php
							printf(__( 'Posted', 'bonestheme' ) . ' <time class="updated" datetime="%1$s" pubdate>%2$s</time> ' . __('by', 'bonestheme' ) . ' <span class="author">%3$s</span> <span class="amp">&</span> ' . __('filed under', 'bonestheme') .  ' %4$s.', get_the_time('Y-m-j'), get_the_time(__( 'F jS, Y', 'bonestheme' )), get_the_author_link( get_the_author_meta( 'ID' ) ), get_the_category_list(', '));
							?></p>

					</header>

					<section class="entry-content cf">

						<div class="post-item cf">
							<div class="post-entry d-5of7 first">
								<?php the_excerpt(); ?>
							</div>
							<div class="d-2of7 last">
								<?php get_the_post_thumbnail(); ?>
							</div>
						</div>

					</section>

					<footer class="article-footer">

					</footer>

				</article>

			<?php endwhile; ?>

				<?php bones_page_navi(); ?>

			<?php else : ?>

				<article id="post-not-found" class="hentry cf">
					<header class="article-header">
						<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
					</section>
					<footer class="article-footer">
						<p><?php _e( 'This is the error message in the archive.php template.', 'bonestheme' ); ?></p>
					</footer>
				</article>

			<?php endif; ?>

		</div>

		<?php get_sidebar('posts'); ?>

	</div>

</div>

<?php get_footer(); ?>
