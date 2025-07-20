<div class="asistent has-svg alignfull">
    <div class="asistent-back">
        <div class="container">
            <h2 class="section-title has-text-align-left">
                <?php _e( 'Rýchly asistent výberu', 'kno' ); ?>
            </h2>
            <div class="filter">
                <div class="filter-inner flex">
                    <div class="filter-category">
                        <label>
                            <?php _e( 'Typ bicyklu', 'kno' ); ?>
                        </label>
                        <?php echo facetwp_display( 'facet', 'category' ); ?> </div>
                    <div class="filter-brand">
                        <label>
                            <?php _e( 'Značka', 'kno' ); ?>
                        </label>
                        <?php echo facetwp_display( 'facet', 'brand' ); ?> </div>
                    <div class="filter-year">
                        <label>
                            <?php _e( 'Rok výroby', 'kno' ); ?>
                        </label>
                        <?php echo facetwp_display( 'facet', 'year' ); ?> </div>
                    <div class="filter-price">
                        <label>
                            <?php _e( 'Výška mesačnej splátky', 'kno' ); ?>
                        </label>
                        <?php echo facetwp_display( 'facet', 'price' ); ?> </div>
                    <div class="filter-button flex middle-xs">
                        <button class="btn btn-gradient btn-asistent">
                        <?php _e( 'Zobraziť výsledok', 'kno' ); ?>
                        </button>
                    </div>
                </div>
            </div>
            <div style="display:none"><?php echo facetwp_display( 'template', 'asistent' ); ?></div>
        </div>
    </div>
</div>
