<?php get_header(); ?>

<?php if( have_posts() ): while ( have_posts() ): the_post(); global $post; ?>

<div class="hch alignfull">

	
</div>

<?php the_content(); ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>