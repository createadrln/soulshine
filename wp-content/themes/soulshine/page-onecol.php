<?php
/*
Template Name: One Column Default Page
*/
?>

<?php get_header(); ?>

<div id="content">

    <div id="inner-content" class="wrap cf">

        <div id="main" class="cf" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/ContactPage">

                    <header class="article-header">

	                    <h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>

                    </header> <?php // end article header ?>

	                <section class="entry-content cf" itemprop="articleBody">

		                <?php the_content(); ?>

	                </section>

                </article>

            <?php endwhile; endif; ?>

        </div>

    </div>

</div>

<?php get_footer(); ?>
