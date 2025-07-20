<?php get_header(); ?>
<?php if ( have_posts() ): while ( have_posts() ): the_post(); global $post; ?>
<div class="container container-pad blog">
  <div class="format">
    <h1 class="h1 title">
      <?php the_title(); ?>
    </h1>
	 <div class="blog-row-wrapper"><?php
            $post_tags = get_the_tags();
            if ( !empty( $post_tags ) ) {
              echo '<ul class="tagyBlog">';
              foreach ( $post_tags as $post_tag ) {
                echo '<li><a href="' . get_tag_link( $post_tag ) . '">' . $post_tag->name . '</a></li>';
              }
              echo '</ul>';
            }
            ?>
		 </div>
  </div>
  <?php edit_post_link( null, '<div class="format mb">', '</div>' ); ?>
  <?php the_content(); ?>
</div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
