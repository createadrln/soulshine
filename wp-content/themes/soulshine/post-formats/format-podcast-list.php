<?php global $query_string;
$posts = query_posts($query_string.'&cat=22'); ?>

  <div class="cf">
    <?php $i=0; foreach ($posts as $post): ?>
      <?php $i++; ?>
      <div class="t-1of2 d-1of4 podcast-grid-item">
        <?php the_post_thumbnail('bones-thumb-500x500'); ?>
        <div class="post-title">
          <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

<?php wp_reset_query(); ?>