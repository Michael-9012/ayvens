<div class="newsletter has-svg alignfull">
    <div class="newsletter-back has-gradient-background">
        <div class="container">
            <div class="row row-gutter">
                <div class="col-md-12 tc">
                    <h2 class="section-title has-blue-color has-text-align-center">
                        <?php _e('Nenechajte si ujsť novinky a bestsellery vo Vašom e-maile.', 'kno'); ?>
                    </h2>
                    <form action="/<?php echo rest_get_url_prefix(); ?>/newsletter/v1/add" method="POST" class="form-newsletter form-data form-validate">
                        <?php if ($privacy_page = get_option('wp_page_for_privacy_policy')): ?>
                            <p class="newsletter-p"> <?php printf(__('Prihlásením sa na odber súhlasíte s %spodmienkami%s spracovania osobných údajov.', 'kno'), '<a href="' . get_permalink(get_page_language_by_id($privacy_page)) . '" target="_blank" class="no-typography">', '</a>'); ?> </p>
                        <?php endif; ?>
                        <div class="form-info"></div>
                        <div class="form-hide">
                            <div class="form-loading">
                                <div class="form-group required">
                                    <?php $uniq = uniqid(); ?>
                                    <input type="email" name="email" id="email-<?php echo $uniq; ?>" data-validate-required-message="<?php _e('E-mail je povinný.', 'kno'); ?>" data-validate-email-message="<?php _e('E-mail je chybne zadaný.', 'kno'); ?>" required aria-label="<?php _e('Zadejte e-mail pro odběr newsletteru', 'kno'); ?>">
                                    <label for="email-<?php echo $uniq; ?>" class="control-label">
                                        <?php _e('zadajte@email.sk', 'kno'); ?>
                                    </label>
                                    <i class="bar"></i>
                                    <button type="submit" class="form-newsletter-btn btn btn-input btn-gray btn-full">
                                        <?php _e('Prihlásiť sa k odberu', 'kno'); ?>
                                    </button>
                                </div>
                                <?php if (false /*$privacy_page = get_option( 'wp_page_for_privacy_policy' ) */): ?>
                                    <div class="form-group ns">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="newsletter-terms" data-validate-required-message="<?php _e('Musíte súhlasiť s podmienkami.', 'kno'); ?>" required>
                                                <i class="helper"></i><?php printf(__('Prihlásením sa na odber súhlasíte s %spodmienkami%s spracovania osobných údajov.', 'kno'), '<a href="' . get_permalink(get_page_language_by_id($privacy_page)) . '" target="_blank" class="no-typography">', '</a>'); ?> </label>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
                <!--div class="col-md-4 posr"> <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 442 237'%3E%3C/svg%3E" data-srcset="<?php echo get_template_directory_uri(); ?>/img/bike.png 1x, <?php echo get_template_directory_uri(); ?>/img/bike.png 2x" width="442" height="237" alt="<?php _e('Bicykel', 'kno'); ?>" class="lazyload"> </div-->
            </div>
        </div>
    </div>
</div>