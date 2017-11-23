<?php
/*
Template Name: Home Page
*/
?>

<?php get_header(); ?>

  <div id="content">

    <div class="container_inner-content">
      <div id="inner-content" class="cf inner-content">
        <div id="main" class="m-all cf" role="main">
          <section class="main-banner" style="background: url('<?php echo get_stylesheet_directory_uri() ?>/library/images/pexels-photo-357501') no-repeat 50% 50%; background-size: 100% auto;">
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
        <div class="inner-content about m-all wrap cf">
          <h2 class="section-title"><?php echo __('About Soul Shine') ?></h2>
          <p><?php echo __('Wouldn’t it be incredible if everyone took a small step to initiate change in their community? Just imagine the ripple effects of positivity, service, and conscious giving a movement like that would do for the world? Are you ready? The world needs your impact, It’s time to let your Soul Shine!') ?></p>
        </div>
      </div>
    </section>

    <section class="home-section__form home-section__form-suggestions home-section">
      <div class="container_inner-content">
        <div class="inner-content about m-all wrap cf">
          <h2 class="section-title"><?php echo __('Get updates from Soul Shine!') ?></h2>
          <!-- Begin MailChimp Signup Form -->
          <div id="mc_embed_signup">
            <form action="//rachaelmariefitness.us8.list-manage.com/subscribe/post?u=3ee05c588b003cf445b258d15&amp;id=b388511a70" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
              <p><label for="mce-EMAIL"><?php echo __('Just enter your email below get email notifications when new podcasts and articles are available!') ?></label></p>
              <div class="input-box">
                <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="<?php echo __('Enter Email Address') ?>" required>
              </div>
              <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
              <div style="position: absolute; left: -5000px;">
                <input type="text" name="b_3ee05c588b003cf445b258d15_b388511a70" tabindex="-1" value="">
              </div>
              <div class="actions">
                <button type="submit" name="subscribe" id="mc-embedded-subscribe" class="button"><?php echo __('Submit') ?></button>
              </div>
              <p class="note"><?php echo __('By sending us your email address you are agreeing to receive occasional updates from soulshinerevolution.com') ?></p>
            </form>
          </div>
          <!--End mc_embed_signup-->
        </div>
      </div>
    </section>

    <section class="home-section__form home-section__form-signup home-section">
      <div class="container_inner-content">
        <div class="inner-content about m-all wrap cf">
          <h2 class="section-title"><?php echo __('Podcast Suggestions') ?></h2>
          <!-- Begin MailChimp Signup Form -->
          <div id="mc_embed_signup">
            <form action="//rachaelmariefitness.us8.list-manage.com/subscribe/post?u=3ee05c588b003cf445b258d15&amp;id=b388511a70" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
              <p><label for="mce-EMAIL"><?php echo __('Do you know someone that is making a difference? Please leave a note with some details and contact information.') ?></label></p>
              <div class="input-box">
                <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter Email Address" required>
              </div>
              <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
              <div style="position: absolute; left: -5000px;">
                <input type="text" name="b_3ee05c588b003cf445b258d15_b388511a70" tabindex="-1" value="">
              </div>
              <div class="actions">
                <button type="submit" name="subscribe" id="mc-embedded-subscribe" class="button"><?php echo __('Submit') ?></button>
              </div>
            </form>
          </div>
          <!--End mc_embed_signup-->
        </div>
      </div>
    </section>

    <section class="home-section__about home-section__about-rachael home-section">
      <div class="m-all wrap cf">
        <div class="container_inner-content">
          <div class="inner-content about">
            <h2 class="section-title">About Rachael</h2>
            <p>Well hello there! I’m Rachael MacMurray, think of me as your soul sister and that little voice in your ear whispering "you can do it". My mission is to empower the next generation of leaders to step into their greatness and in return find their calling to make the world a better place. I am an entrepreneur, author, activist and all now a podcaster for Soul Shine where we bring you game changers from around the globe to educate, inspire and ignite your soul! Thanks for joining us, let the revolution begin!</p>
          </div>
        </div>
        <img src="<?php echo get_stylesheet_directory_uri() ?>/library/images/rachael2.jpg" />
      </div>
    </section>

  </div>

<?php get_footer(); ?>