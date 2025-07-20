</main>
<footer class="footer has-svg" role="contentinfo">
  <div class="footer-back">
    <div class="container">
      <div class="row">
        <div class="col-md-3 mb"> <a href="<?php echo home_url(); ?>" class="footer-logo flex middle-xs"> <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 253 45'%3E%3C/svg%3E" data-src="<?php echo get_template_directory_uri(); ?>/img/logo-ayvens-wh.png" width="198" height="40" alt="<?php echo get_bloginfo( 'name' ); ?>" class="lazyload"> </a> </div>
        <div class="col-md-6 mb">
          <nav class="footer-menu print-hidden ns" role="navigation">
            <ul class="list-bare footer-menu-content flex middle-xs between-xs">
              <?php
              wp_nav_menu( array(
                'container' => false,
                'menu_class' => true,
                'menu_class_add' => 'footer',
                'depth' => 0,
                'menu_id' => '',
                'theme_location' => 'primary',
                'items_wrap' => '%3$s',
                'walker' => new KNO_Walker_Nav_Menu()
              ) );
              ?>
            </ul>
          </nav>
        </div>
        <div class="col-md-3 mb md-tr">
          <button class="arrow">
          <?php _e( 'Späť hore', 'kno' ); ?>
          </button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 mb">
          <div class="footer-title">
            <?php _e( 'Dôležité informácie', 'kno' ); ?>
          </div>
          <nav class="footer-menu-link print-hidden ns flex" role="navigation">
            <ul class="list-bare footer-menu-content">
              <?php
              wp_nav_menu( array(
                'container' => false,
                'menu_class' => true,
                'menu_class_add' => 'footer-link',
                'depth' => 0,
                'menu_id' => '',
                'theme_location' => 'footer',
                'items_wrap' => '%3$s',
                'walker' => new KNO_Walker_Nav_Menu()
              ) );
              ?>
                <li><a href="javascript:Didomi.preferences.show()">Nastavenia Cookies</a></li>
            </ul>
          </nav>
        </div>
        <div class="col-md-3 mb">
          <div class="footer-title">
            <?php _e( 'Rýchle odkazy', 'kno' ); ?>
          </div>
          <nav class="footer-menu-link print-hidden ns flex" role="navigation">
            <ul class="list-bare footer-menu-content">
              <?php
              wp_nav_menu( array(
                'container' => false,
                'menu_class' => true,
                'menu_class_add' => 'footer-link',
                'depth' => 0,
                'menu_id' => '',
                'theme_location' => 'footer-link',
                'items_wrap' => '%3$s',
                'walker' => new KNO_Walker_Nav_Menu()
              ) );
              ?>
            </ul>
          </nav>
        </div>
        <div class="col-md-3 mb">
          <div class="footer-title">
            <?php _e( 'ALD Automotive Slovakia s.r.o.', 'kno' ); ?>
          </div>
          <?php the_field( 'footer', 'option' ); ?>
        </div>
        <div class="col-md-3 mb md-tr flex end-xs bottom-xs">
          <div class="footer-copyright"> &copy; <?php echo date_i18n( 'Y' ); ?>
            <?php _e( 'Všetky práva vyhradené.', 'kno' ); ?>
            <br>
            <span class="has-white-color">ayvensbike.sk</span> </div>
        </div>
      </div>
    </div>
  </div>
</footer>
</div>
</div>
</div>


<?php wp_footer(); ?>


</body></html>