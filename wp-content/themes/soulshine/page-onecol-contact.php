<?php
/*
Template Name: One Column Contact Form
*/
?>

<?php get_header(); ?>

<div id="content">

    <div id="inner-content" class="wrap cf page-contact">

        <div id="main" class="m-all t-3of3 d-7of7 cf" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/ContactPage">

                    <header class="article-header">

                        <h1 class="page-title"><?php the_title(); ?></h1>

                    </header>

                    <section class="entry-content cf" itemprop="description">
                        <?php the_content(); ?>
                    </section>

                    <section class="cf">
                        <?php if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 1 ); } ?>
                    </section>

                </article>

            <?php endwhile; endif; ?>

        </div>

    </div>

</div>


<?php get_footer(); ?>
