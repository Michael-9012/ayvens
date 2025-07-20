<?php
/**
 * Block template file: template-parts/blocks/slider.php
 *
 * Slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'slider-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'block-slider slider lazyload ns alignfull';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}

$slide_c = count( get_field('slider') );

if ( have_rows( 'slider' ) ) : ?>

<div class="<?php echo esc_attr( $classes ); ?>" data-slider='{ "type": "fade", "speed": 500, "autoplay": <?php echo ( $slide_c > 1 ) ? 'true' : 'false'; ?>, "interval": 5000, "lazyLoad": "nearby", "rewind": true, "arrows": <?php echo ( $slide_c > 1 ) ? 'true' : 'false'; ?>, "drag": false, "pagination": false }'>


    <div class="slider__track">
        <div class="slider__list">

        <?php while ( have_rows( 'slider' ) ) : the_row();

            $title    = get_sub_field( 'title' );

            $title_explode = explode( "\r\n", $title );
            $title_1 = ( count( $title_explode ) > 1 ) ? $title_explode[0] : false;
            $title_2 = ( count( $title_explode ) > 1 ) ? $title_explode[1] : $title_explode[0];

            $desc = get_sub_field( 'desc' );

            $link  = get_sub_field( 'link' );
            $image = get_sub_field( 'image' );

            if ( $image ): ?>
            <div class="slider__slide">

                <div class="block-slider-wrapper">

                    <?php if ( $image ) : ?>
                    <div class="slider__img">
                        <svg viewBox="0 0 1920 700" width="100%" xmlns="http://www.w3.org/2000/svg">
                            <image height="100%" mask="url(#image-mask)" preserveAspectRatio="xMidYMid slice" width="100%" xlink:href="<?php echo $image['url']; ?>"></image>
                        </svg>
                    </div>
                    <?php endif; ?>

                    <div class="container">

                        <?php if ( $link ) : ?>
                        <a href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ); ?>" class="block-slider-box">
                        <?php else: ?>
                        <div class="block-slider-box">
                        <?php endif; ?>

                            <div class="has-corner">
                                <span></span>

                                <?php if ( !empty( $title ) ): ?>
                                <h2 class="banner-title">
                                    <?php if ( $title_1 ) : ?><span><?php echo $title_1; ?><?php endif; ?></span><?php echo $title_2; ?>
                                </h2>
                                <?php endif; ?>

                                <?php if ( !empty( $desc ) ): ?>
                                <p><?php echo $desc; ?></p>
                                <?php endif; ?>

                                <?php if ( $link ) : ?>
                                <div class="btn btn-purple"><?php echo esc_attr( $link['title'] ); ?></div>
                                <?php endif; ?>
                            </div>

                        <?php if ( $link ) : ?>
                        </a>
                        <?php else: ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php endif; endwhile; ?>

        </div>
    </div>
</div>
<?php endif; ?>