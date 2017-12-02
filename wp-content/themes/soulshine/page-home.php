<?php
/*
Template Name: Home Page
*/
?>

<?php get_header(); ?>

  <div id="content">

    <div class="container_inner-content">
      <div id="inner-content" class="cf inner-content">
        <div id="main" class="cf" role="main">
          <section class="main-banner" style="background: url('<?php echo get_stylesheet_directory_uri() ?>/library/images/pexels-photo-357501.jpeg') no-repeat 50% 50%; background-size: 100% auto;">
            <div class="main-banner__overlay">
              <h1 class="page-title"><?php echo __('The greatest challenge of the day is: how to bring about a revolution of the heart, a revolution which has to start with each one of us?') ?>
                <div class="author"><?php echo __('- Dorothy Day') ?></div>
              </h1>
            </div>
          </section>
        </div>
      </div>
    </div>

    <section class="home-section__about home-section">
      <div class="container_inner-content">
        <div class="inner-content about wrap cf">
          <h2 class="section-title"><?php echo __('About Soul Shine') ?></h2>
          <p><?php echo __('Wouldn’t it be incredible if everyone took a small step to initiate change in their community? Just imagine the ripple effects of positivity, service, and conscious giving a movement like that would do for the world. Are you ready? The world needs your impact! It’s time to let your Soul Shine!') ?></p>
        </div>
      </div>
    </section>

    <section class="home-section__form home-section__form-subscribe home-section">
      <div class="container_inner-content">
        <div class="inner-content wrap cf">
          <h2 class="section-title">
            <?php echo __('Get updates from Soul Shine!') ?>
            <small><?php echo __('Want to be notified when we release our podcasts and updates? Sign up here!') ?></small>
          </h2>
          <?php echo do_shortcode('[wpforms id="205" title="false" description="false"]'); ?>
        </div>
      </div>
    </section>

    <section class="home-section__about home-section__about-rachael home-section">
      <div class="wrap cf">
        <div class="container_inner-content">
          <div class="inner-content about">
            <h2 class="section-title">About Rachael</h2>
            <p>Well hello there! I’m Rachael MacMurray, think of me as your soul sister and that little voice in your ear whispering "you can do it". My mission is to empower the next generation of leaders to step into their greatness and in return find their calling to make the world a better place. I am an entrepreneur, author, activist and all now a podcaster for Soul Shine where we bring you game changers from around the globe to educate, inspire and ignite your soul! Thanks for joining us, let the revolution begin!</p>
          </div>
        </div>
        <img src="<?php echo get_stylesheet_directory_uri() ?>/library/images/rachael2.jpg" />
      </div>
    </section>

    <section class="home-section__form home-section__form-suggestions home-section">
      <div class="container_inner-content">
        <div class="inner-content wrap cf">
          <h2 class="section-title">
            <?php echo __('Podcast Suggestions') ?>
            <small><?php echo __('We are looking for guests to interview for future podcasts.') ?></small>
          </h2>
          <?php echo do_shortcode('[wpforms id="204" title="false" description="false"]'); ?>
        </div>
      </div>
    </section>

  </div>

<?php get_footer(); ?>