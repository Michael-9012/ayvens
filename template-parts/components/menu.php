<?php

extract( $args );

$term_query = new WP_Term_Query( array(
    'taxonomy' => 'product_cat',
    'orderby'  => 'menu_order',
    //'hide_empty' => false,
    'exclude'  => array( 15 )
) );

if ( ! empty( $term_query ) && ! is_wp_error( $term_query ) ) :
    $query = get_queried_object();

    if( is_a( $query, 'WP_Term') )
        $current_term = $query->term_id;

    if ( is_singular( 'product' ) ) {

        $category = get_post_meta( get_the_ID(), '_primary_term_product_cat', true );
        if ( $category )
            $current_term = $category;
    }

    $terms = array();

    foreach ( $term_query->terms as $term ) {
        if ( $term->parent == 0 ) {
            $terms[$term->term_id] = $term;
        }
    }
    foreach ( $term_query->terms as $term ) {
        if ( $term->parent !== 0 ) {
            if ( !isset( $terms[$term->parent]->children ) ) {
                $terms[$term->parent]->children = array();
            }
            $terms[$term->parent]->children[] = $term;
        }
    }

    foreach ( $terms as $term ) :

        $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );

        ?>
        <li class="<?php echo $class; ?>-item<?php echo ( ( isset( $current_term ) && ( $current_term == $term->term_id || $query->parent == $term->term_id ) ) ? ' current' : '' ); ?>">

        <?php if ( true ) : //!isset( $term->children ) ?>
            <a href="<?php echo get_term_link( $term->term_id ); ?>" class="flex middle-xs">

        <?php else : ?>
            <button class="flex middle-xs" aria-haspopup="true" aria-expanded="false" aria-controls="<?php echo $class; ?>-<?php echo $term->term_id; ?>">
        <?php endif; ?>
                <?php if ( $thumbnail_id ): ?>
                    <?php echo wp_get_attachment_image( $thumbnail_id, 'thumbnail', false, array( 'class' => 'lazyload' ) ); ?>
                <?php endif; ?>
                <?php echo $term->name; ?>
                <?php if ( isset( $term->children ) ) : ?>

                <?php if ( $toggle ): ?>
                <button type="button" aria-label="<?php _e( 'Rozbaliť menu', 'ibd' ); ?>" aria-haspopup="true" aria-expanded="<?php ( ( in_array( 'current', $classes ) || in_array( 'current-ancestor', $classes ) ) ? 'true' : 'false' ); ?>" data-toggle="#<?php echo $class; ?>-sub-menu-<?php echo $term->term_id; ?>" class="toggle"><svg class="icon icon-arrow-down lazyload" aria-hidden="false" focusable="false"><use xlink:href="#icon-arrow-down"></use></svg></button>
                <?php else: ?>
                <svg class="icon icon-arrow-down lazyload" aria-hidden="false" focusable="false"><use xlink:href="#icon-arrow-down"></use></svg>
                <?php endif; ?>

                <?php endif; ?>
        <?php echo ( !isset( $term->children ) ) ? '</a>' : '</button>'; ?>

        <?php
        if ( isset( $term->children ) ) : ?>
            <ul class="sub-menu-children list-bare<?php
            if ( $toggle ) {
                echo ' toggle-content';
                if ( isset( $current_term ) && ( $current_term == $term->term_id ) )
                    echo ' is-visible';
            } ?>" id="<?php echo $class; ?>-sub-menu-<?php echo $term->term_id; ?>" role="menu">
            <?php foreach ( $term->children as $term_child ) : ?>
                <li<?php echo ( ( isset( $current_term ) && $current_term == $term_child->term_id ) ? ' class="current"' : '' ); ?>><a href="<?php echo get_term_link( $term_child->term_id ); ?>"><?php echo $term_child->name; ?></a></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        </li>
    <?php endforeach; ?>
<?php endif; ?>