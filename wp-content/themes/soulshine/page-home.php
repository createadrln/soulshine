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
          <article id="post-<?php the_ID(); ?>">
            <section class="main-banner">
              <div class="main-banner__overlay">
                <h1 class="page-title">Say something interesting</h1>
              </div>
              <img src="<?php echo get_stylesheet_directory_uri() ?>/library/images/42HBC4OR23.jpg" ?>
            </section>
          </article>
        </div>
      </div>
    </div>

    <section class="home-section__about home-section">
      <div class="container_inner-content">
        <div class="inner-content about m-all wrap cf">
          <h2 class="section-title">About Soul Shine</h2>
          <p>It's about breaking free of the working class mentality. It's about living your life for yourself and the people you care most about. It's about finding your own time and space.</p>
          <p>We help you define and take the steps to get you there.</p>
        </div>
      </div>
    </section>

  </div>

  <section class="home-section__signup home-section">
    <div class="container_inner-content">
      <div class="inner-content about m-all wrap cf">
        <h2 class="section-title">You are almost there!</h2>
        <!-- Begin MailChimp Signup Form -->
        <div id="mc_embed_signup">
          <form action="//rachaelmariefitness.us8.list-manage.com/subscribe/post?u=3ee05c588b003cf445b258d15&amp;id=b388511a70" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
            <p><label for="mce-EMAIL">Just enter your email below and I will send you my 7 Day Guide to Clean Eating.</label></p>
            <div class="input-box">
              <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter Email Address" required>
            </div>
            <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
            <div style="position: absolute; left: -5000px;">
              <input type="text" name="b_3ee05c588b003cf445b258d15_b388511a70" tabindex="-1" value="">
            </div>
            <div class="actions">
              <button type="submit" name="subscribe" id="mc-embedded-subscribe" class="button">
                Submit
              </button>
            </div>
            <p class="note">By sending us your email address you are agreeing to receive occasional updates from RachaelMarieFitness.com</p>
          </form>
        </div>
        <!--End mc_embed_signup-->
      </div>
    </div>
    </div>
  </section>

<?php get_footer(); ?>