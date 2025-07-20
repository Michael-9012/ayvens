<?php

/**

 * Block template file: template-parts/blocks/store.php

 *

 * Store Block Template.

 *

 * @param   array $block The block settings and attributes.

 * @param   string $content The block inner HTML (empty).

 * @param   bool $is_preview True during AJAX preview.

 * @param   (int|string) $post_id The post ID this block is saved to.

 */


// Create id attribute allowing for custom "anchor" value.

$id = 'store-' . $block['id'];

if (!empty($block['anchor'])) {

  $id = $block['anchor'];
}


// Create class attribute allowing for custom "className" and "align" values.

$classes = 'store alignfull';

if (!empty($block['className'])) {

  $classes .= ' ' . $block['className'];
}

if (!empty($block['align'])) {

  $classes .= ' align' . $block['align'];
}


$show_background = true;


if (is_page('kontakt'))

  $show_background = false;


if ($show_background)

  $classes .= ' store-has-background has-svg';


?>
<div class="<?php echo esc_attr($classes); ?>">
  <?php if ($show_background) : ?>
  <?php endif; ?>
  <div class="store-back">
    <div class="container">
      <div class="row row-gutter+">
        <div class="col-md-6 mb flex middle-xs">
          <div class="container-max">

            <!--div class="store-icon"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 99 54'%3E%3C/svg%3E" data-src="<?php echo get_template_directory_uri(); ?>/img/wheel.svg" width="99" height="54" alt="<?php _e('Bicykel', 'kno'); ?>" class="lazyload">

                        </div-->

            <h2 class="md-mb">
              <?php _e('Ako sa k nám dostanete?', 'kno'); ?>
            </h2>
            <div class="row row-gutter++">
              <?php /*<div class="col-sm-6 mb">
                <?php the_field( 'text' ); ?>
                <?php if ( !is_page( 'kontakt') ): ?>
                <a href="<?php echo get_the_permalink( 22 ); ?>" class="has-black-color">
                <?php _e( 'Kontaktujte nás', 'kno' ); ?>
                </a>
                <?php endif; ?>
              </div> */ ?>
              <div class="col-sm-6 mb">
                <?php if ($address = get_field('address')) : ?>
                  <div class="icon-left">
                    <svg class="icon icon-pin lazyload" aria-hidden="true" role="img">
                      <use xlink:href="#icon-pin"></use>
                    </svg>
                    <?php echo $address; ?>
                  </div>
                <?php endif; ?>
                <?php if ($link = get_field('link')) : ?>
                  <a href="<?php echo $link; ?>" target="_blank" class="btn btn-gray">
                    <?php _e('Zobraziť na mape', 'kno'); ?>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb">
          <?php if ($image = get_field('image')) : ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php if ($show_background) : ?>
  <?php endif; ?>
</div>