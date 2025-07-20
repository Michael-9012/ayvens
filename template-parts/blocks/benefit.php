<?php if (have_rows('benefit')) : ?>
  <div class="benefit">
    <div class="container posr">
      <div class="tc mb+ mwidth">
        <p><strong>Ste fanúšik elektromobility a zdravého životného štýlu?</strong><br>Staňte sa zelenou firmou, podporte ochranu klímy aj udržateľný rozvoj a zároveň podporte svojich zamestnancov v starostlivosti o ich zdravú kondíciu vďaka nášmu projektu AyvensBike.sk</p>
      </div>
      <div class="benefit-wheel">
        <h3>Pri nákupe na operatívny lízing <span>získate množstvo výhod.</span></h3>
      </div>
      <div class="benefit-items">
        <?php while (have_rows('benefit')) : the_row(); ?>
          <div class="benefit-item">
            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25.36 25.06">
              <defs>
                <style>
                  .cls-1 {
                    fill: #12364a;
                  }
                </style>
              </defs>
              <path class="cls-1" d="m12.6,13.35l-5.07-5-1.67,1.69s3.85,3.8,5.14,5.06c.87.89,2.54.95,3.37,0,2.04-2.48,10.85-13.19,10.85-13.19l-1.84-1.51-10.64,12.94s-.11.05-.15,0m11.65-5.92h0s-.2.25-.2.25l-1.52,1.85h0c.31.97.46,1.98.46,3,0,5.6-4.62,10.15-10.31,10.15S2.38,18.13,2.38,12.53,7,2.38,12.68,2.38c1.61,0,3.17.37,4.62,1.09l1.54-1.87c-1.89-1.04-4.02-1.59-6.16-1.59C5.69,0,0,5.62,0,12.53s5.69,12.53,12.68,12.53,12.68-5.62,12.68-12.53c0-1.76-.37-3.47-1.11-5.1" />
            </svg>

            <h4>
              <?php the_sub_field('title'); ?>
            </h4>
            <div>
              <?php the_sub_field('content'); ?>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
<?php endif; ?>