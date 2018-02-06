<!doctype html>

<!--[if lt IE 7]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]>
<html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<head>
  <meta charset="utf-8">

  <?php // Google Chrome Frame for IE ?>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php wp_title(''); ?></title>

  <?php // mobile meta (hooray!) ?>
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(
  ); ?>/library/images/apple-icon-touch.png">
  <link rel="icon" href="<?php echo get_template_directory_uri(
  ); ?>/favicon.png">
  <!--[if IE]>
  <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
  <![endif]-->
  <?php // or, set /favicon.ico for IE10 win ?>
  <meta name="msapplication-TileColor" content="#f01d4f">
  <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(
  ); ?>/library/images/win8-tile-icon.png">

  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Bitter:400,700' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Contrail+One' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Yellowtail' rel='stylesheet' type='text/css'>

  <?php // wordpress head functions ?>
  <?php wp_head(); ?>
  <?php // end of wordpress head ?>

  <?php // drop Google Analytics Here ?>
  <?php // end analytics ?>

</head>

<body <?php body_class(); ?>>

<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = '//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=198690313533923&version=v2.0';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113624729-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-113624729-1');
</script>

<div id="container">

  <header class="header" role="banner">

    <div id="inner-header" class="wrap cf">

      <a href="<?php echo home_url(); ?>" rel="nofollow" class="header__logo">
        <img src="<?php echo get_stylesheet_directory_uri() ?>/library/images/Soul-Shine-Logo.png" alt="Soul Shine"/>
      </a>

    </div>

  </header>
