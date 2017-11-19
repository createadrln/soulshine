<?php
/*
Template Name: Two Column Training Guide Home
*/
?>

<?php get_header(); ?>

<div id="content" class="page-training-guides">

    <div id="inner-content" class="wrap cf">

        <div id="main" class="m-all t-2of3 d-5of7 first cf" role="main">

            <header>
                <h1 class="page-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">

                <?php
                $temp = $wp_query;
                $wp_query = null;
                $wp_query = new WP_Query();
                $wp_query->query('showposts=5&post_type=be-fit-blog'.'&paged='.$paged);

                echo '<section class="ulist"><ul class="post-listing">';

                while ($wp_query->have_posts()) : $wp_query->the_post();

                    echo '<li class="post-item cf">';
                    echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
	                echo '<div class="post-entry d-5of7 first">' . get_the_excerpt() . '</div>';
	                echo '<div class="d-2of7 last">' . get_the_post_thumbnail() . '</div>';
	                echo '</li>';

                endwhile; echo '</ul></section>'?>

                <nav>
                    <?php previous_posts_link('&laquo; Newer') ?>
                    <?php next_posts_link('Older &raquo;') ?>
                </nav>

                <?php
                $loop = null;
                $loop = $temp;  // Reset
                ?>

            </div>

        </div>

        <?php get_sidebar('posts'); ?>

    </div>

</div>

<div class="md-modal md-effect-5" id="modal-5">

    <div class="md-content">

        <h3>Sign Up For Free!</h3>

        <div>

            <!-- Begin MailChimp Signup Form -->
            <div id="mc_embed_signup">

                <form action="//rachaelmariefitness.us8.list-manage.com/subscribe/post?u=3ee05c588b003cf445b258d15&amp;id=ca8d5cf192" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>

                    <p><label for="mce-EMAIL">You are almost there! Just enter your email below and I will send you my 7 Day Guide to Clean Eating.</label></p>

                    <div class="input-box">
                        <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter Email Address" required>
                    </div>

                    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;"><input type="text" name="b_3ee05c588b003cf445b258d15_ca8d5cf192" tabindex="-1" value=""></div>

                    <div class="actions">
                        <button type="submit" name="subscribe" id="mc-embedded-subscribe" class="button">Submit</button>
                    </div>

                    <p class="note">By sending us your email address you are agreeing to receive occasional updates from RachaelMarieFitness.com</p>

                </form>

            </div>
            <!--End mc_embed_signup-->

            <button class="md-close">

                <svg version="1.1" class="close-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="20px" height="20px" viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
                    <path style="fill-rule:evenodd;clip-rule:evenodd;fill:#929487;" d="M13.187,9.953l5.498,5.498c0.357,0.357,0.357,0.936,0,1.294
                        l-1.94,1.94c-0.357,0.357-0.936,0.357-1.294,0l-5.498-5.498l-5.498,5.498c-0.357,0.357-0.936,0.357-1.294,0l-1.94-1.94
                        c-0.357-0.357-0.357-0.936,0-1.294l5.498-5.498L1.22,4.455c-0.357-0.357-0.357-0.936,0-1.294l1.94-1.94
                        c0.357-0.357,0.936-0.357,1.294,0l5.498,5.498l5.498-5.498c0.357-0.357,0.936-0.357,1.294,0l1.94,1.94
                        c0.357,0.357,0.357,0.936,0,1.294L13.187,9.953z"/>
                </svg>

            </button>

        </div>

    </div>

</div>

<!-- the modal overlay -->
<div class="md-overlay"></div>

<script>
    jQuery(document).ready(function(){
        jQuery('.main-banner').click(function(evt){
            evt.preventDefault;
        });
    });
</script>

<?php get_footer(); ?>
