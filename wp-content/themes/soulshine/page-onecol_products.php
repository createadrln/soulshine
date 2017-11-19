<?php
/*
Template Name: One Column Product Page
*/
?>

<?php get_header(); ?>

<div id="content">

    <div id="inner-content" class="cf page-products">

        <div id="main" class="cf" role="main">

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/ContactPage">

                <header class="article-header wrap cf">

	                <div class="m-all t-1of3 d-1of3 article-header_callout">
		                <h1 class="page-title" itemprop="headline">Ready to learn more about Isagenix products?</h1>

		                <div class="article-header_callout-links">
			                <a href="#contact" class="contact">Contact Me</a>
		                </div>

	                </div>

	                <div class="m-all t-2of3 d-2of3 article-header_video last">

		                <div class="wrapper video">

			                <iframe id="video" width="1280" height="720" src="//www.youtube.com/embed/AGuVoE8NbMM?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

		                </div>

	                </div>

                </header> <?php // end article header ?>

            </article>

	        <section class="block_why cf wrap">

		        <div class="block_why__statement">

			        <h2>Why I Use Isagenix</h2>

			        <p>Isagenix are products that I use daily and recommend to clients, family and friends. I have have enjoyed many benefits from using these products and I am certain that you will to. So...Why Isagenix?</p>

				        <h3>Quality Ingredients</h3>
				        <p>I choose Isagenix because they use undenatured protein sourced from from grass-fed cows from New Zeland.  What does that mean for you? Undenatured whey protein is technically more "pure" in reality, taking the literal meaning of the word. The cold processing is less brutal and many people report better digestion and absorption with indentured protein because it is concentrated whole proteins.</p>
				        <p>In addition, ALL of their products are soy free, and void of artificial flavors and colors. Also, the majority of the products are gluten free as well!</p>

				        <h3>Cellular Cleansing</h3>
				        <p>Isagenix Cleanse for Life is unlitke any other cleanse on the market! Our cleansing system is developed to remove toxins stored in your fat cells. Clinical studies have shown a direct link for environmental toxins in the body and obesity. What does that mean for you? Riding your body of harmful environmental toxins allows it to function more optimally, Giving our consumers better weight loss results and leaving them with a surge of increased energy!</p>

				        <h3>Business Opportunity</h3>
				        <p>I love health and fitness and by becoming a part of this rapidly growing company I get to work alongside people with the same interest and help others in the process! Who doesn't want to share great weight loss stories with their friends and family? Best of all you can build a residual income and earn a weekly payout…  Now that is a WIN, WIN, WIN!</p>

				        <h3>Quick Facts:</h3>
				        <ul>
					        <li>Inc. Magazine Fastest Growing Company for 7 consecutive years!</li>
					        <li>27 American Business Awards!</li>
				            <li>Unlimited FREE Coaching and Support available for program usage as well as business building!</li>
				        </ul>

				</div>

	        </section>

	        <section class="block_using cf wrap">

		        <h2>Celebrities Using Isagenix</h2>

		        <div class="block_using__person m-all t-1of2 d-1of2 first">

			        <div class="m-all t-1of2 d-1of2">

				        <img src="<?php echo get_stylesheet_directory_uri() ?>/library/images/ray-l-image-01.jpg" class="profile-image" />

			        </div>

			        <div class="m-all t-1of2 d-1of2 last">

				        <h3><a href="http://www.isagenix.com/people/Team-Isagenix/Profiles/Professional-Athletes/team-isagenix-professional-athletes-ray-l">Ray Lewis</a></h3>

				        <p>Many consider Ray Lewis the greatest linebacker in NFL history. He’s known for his invigorating presence on the field, devastating hits, and constant drive to win. He retired after winning the Super Bowl in 2013 and is a lock for the Hall of Fame.</p>

				        <div class="divider"></div>

				        <h4>WHY ISAGENIX?</h4>
				        <p>Ray lives life at full speed, so he needs nutrition that won’t slow him down. Whether it’s the broadcasting booth or just a good workout, Isagenix helps keep him in linebacker shape.</p>

			        </div>

		        </div>

		        <div class="block_using__person m-all t-1of2 d-1of2 last">

			        <div class="m-all t-1of2 d-1of2">

				        <img src="<?php echo get_stylesheet_directory_uri() ?>/library/images/lori-h-image-01.jpg" class="profile-image" />

			        </div>

			        <div class="m-all t-1of2 d-1of2 last">

				        <h3><a href="http://www.isagenix.com/people/Team-Isagenix/Profiles/Fitness-Competitors/team-isagenix-fitness-competitors-lori-h">Lori Harder</a></h3>

				        <p>Competitive fitness is nothing new to Lori, but it was 2010 when she really hit the ground running. Lori won titles in Ms. Bikini Universe, Ms. Bikini America and Ms. Figure America.</p>

				        <div class="divider"></div>

				        <h4>WHY ISAGENIX?</h4>
				        <p>Lori believes Isagenix is the only way to get her body exactly what it needs to respond and become its best in a natural, easy and realistic way.</p>

			        </div>

		        </div>

	        </section>

	        <section id="contact" class="block_contact cf wrap">

		        <div class="m-all">
			        <h2>Contact me today to get started on your path to health and wellness success!</h2>
		        </div>

		        <div class="m-all">
			        <?php if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 2 ); } ?>
		        </div>

	        </section>

        </div>

    </div>

</div>

<?php get_footer(); ?>
