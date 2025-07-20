<?php get_header(); ?>

<?php if( have_posts() ): while ( have_posts() ): the_post(); global $post; ?>

<?php core_get_breadcrumb(); ?>

<?php edit_post_link( __( 'Upraviť stránku', 'kno' ), '<p>', '</p>', null, 'btn btn-sm' ); ?>

<h1 class="page-title"><?php the_title(); ?></h1>

<?php the_content(); ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>