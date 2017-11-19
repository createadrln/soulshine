<div id="sidebar1" class="sidebar m-all t-1of3 d-2of7 last cf" role="complementary">

    <?php if ( is_active_sidebar( 'sidebar-posts' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-posts' ); ?>
    <?php endif; ?>

    <div class="widget">
        <h4 class="widgettitle">Contact Me</h4>
        <?php if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 1 ); } ?>
    </div>

</div>
