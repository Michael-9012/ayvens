<?php get_header(); ?>
<div class="alignfull">
  <div class="container">
    <div class="row blogger">
      <h1>
        <?php _e( 'Blog', 'kno' ); ?>
      </h1>
    </div>
  </div>
  <?php if( have_posts() ): while ( have_posts() ): the_post(); global $post; ?>
  <div class="blog-row">
    <div class="container">
      <div class="row row-gutter+">
        <div class="col-md-4"> <a href="<?php the_permalink(); ?>">
          <?php if ( has_post_thumbnail() ): ?>
          <div class="blog-row-image" style="background-image: url('<?php echo get_the_post_thumbnail_url( null, 'medium_large' ); ?>');"></div>
          <?php else: ?>
          <div class="blog-row-image" style="background-image: url('<?php echo get_template_directory_uri() ?>/img/placeholder.svg');"></div>
          <?php endif; ?>
          </a> </div>
        <div class="col-md-8">
          <div class="blog-row-wrapper">
            <h2 class="blog-row-title"> <a href="<?php the_permalink(); ?>">
              <?php the_title(); ?>
              </a> </h2>
            <?php
            $post_tags = get_the_tags();
            if ( !empty( $post_tags ) ) {
              echo '<ul class="tagyBlog">';
              foreach ( $post_tags as $post_tag ) {
                echo '<li><a href="' . get_tag_link( $post_tag ) . '">' . $post_tag->name . '</a></li>';
              }
              echo '</ul>';
            }
            ?>
            <div class="blog-row-excerpt post-format">
              <?php the_excerpt(); ?>
            </div>
            <a href="<?php the_permalink(); ?>" class="btn new-row-btn"><span>
            <?php _e( 'čítať viac', 'kno' ); ?>
            </span></a> </div>
        </div>
      </div>
    </div>
  </div>
  <?php endwhile; endif; ?>
  <div class="alignwide">
    <?php if ( function_exists( 'pagination' ) ) pagination(); ?>
  </div>
</div>
<?php get_footer(); ?>
