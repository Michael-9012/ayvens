<div class="modal modal-slide ns" id="modal-inquiry" aria-hidden="true">
	<div class="modal-overlay" tabindex="-1" data-modal-close>
		<div class="modal-container" role="dialog" aria-modal="true" aria-labelledby="modal-inquiry-title">

			<button class="modal-close" aria-label="<?php _e( 'Zavrieť formulár', 'kno' ); ?>" data-modal-close=""></button>

			<div class="modal-container-scroll">

				<div class="modal-title" id="modal-inquiry-title"><?php _e( 'Dopytový formulár', 'kno' ); ?></div>

				<div class="modal-content" id="modal-inquiry-content">

					<?php

					$uniq = uniqid();

					?>
					<form action="<?php echo ( empty( $_SERVER['REQUEST_URI'] ) ) ? '/' : $_SERVER['REQUEST_URI']; ?>" class="form-inquiry form-data form-validate" method="POST">

					    <input type="hidden" name="action" value="inquiry" />
					    <input type="hidden" name="secure" value="<?php echo wp_create_nonce( 'request' ); ?>" />
					    <input type="hidden" name="locale" value="<?php echo get_locale(); ?>">
					    <input type="hidden" name="captcha" value="" />

					    <div class="form-info"></div>
					    <div class="form-hide">
					        <div class="form-loading">
					            <fieldset>
					                <div class="row row-gutter">

					                    <div class="col-md-12">
					                        <div class="form-group form-checkbox">
					                            <label><?php _e( 'Mám záujem o bicykel', 'kno' ); ?>:</label>
					                            <div class="flex mt middle-xs between-xs">
						                            <div class="checkbox">
						                                <label>
						                                    <input type="checkbox" name="bike" value="horske" aria-label="<?php _e( 'Horské', 'kno' ); ?>" /><i class="helper"></i><?php _e( 'Horské', 'kno' ); ?>
						                                </label>
						                            </div>
						                            <div class="checkbox">
						                                <label>
						                                    <input type="checkbox" name="bike" value="silnicni" aria-label="<?php _e( 'Cestné', 'kno' ); ?>" /><i class="helper"></i><?php _e( 'Cestné', 'kno' ); ?>
						                                </label>
						                            </div>
						                            <div class="checkbox">
						                                <label>
						                                    <input type="checkbox" name="bike" value="mestske" aria-label="<?php _e( 'Mestské', 'kno' ); ?>" /><i class="helper"></i><?php _e( 'Mestské', 'kno' ); ?>
						                                </label>
						                            </div>
						                            <div class="checkbox">
						                                <label>
						                                    <input type="checkbox" name="bike" value="skladaci" aria-label="<?php _e( 'Skladacie', 'kno' ); ?>" /><i class="helper"></i><?php _e( 'Skladacie', 'kno' ); ?>
						                                </label>
						                            </div>
						                            <div class="checkbox">
						                                <label>
						                                    <input type="checkbox" name="bike" value="specialni" aria-label="<?php _e( 'Špeciálne', 'kno' ); ?>" /><i class="helper"></i><?php _e( 'Špeciálne', 'kno' ); ?>
						                                </label>
						                            </div>
						                        </div>
					                        </div>
					                    </div>
							            <div class="col-md-6 mb">
					                        <div class="form-group">
							            		<label for="type-<?php echo $uniq; ?>"><?php _e( 'Typ dopytu', 'kno' ); ?>:</label>
					                        	<div class="form-select">
						                            <select name="type" id="type-<?php echo $uniq; ?>" aria-label="<?php _e( 'Typ dopytu', 'kno' ); ?>">
						                                <option value="business"><?php _e( 'Firma alebo podnikateľ', 'kno' ); ?></option>
						                                <option value="fleet"><?php _e( 'Flotila / požičovňa, hotel atď.', 'kno' ); ?></option>
						                                <option value="company"><?php _e( 'Firemné bicykle', 'kno' ); ?></option>
						                            </select>
						                            <i class="bar"></i>
						                        </div>
					                        </div>
							            </div>
							            <div class="col-md-6 mb">
					                        <div class="form-group">
					                        	<label for="brand-<?php echo $uniq; ?>"><?php _e( 'Preferovaná značka', 'kno' ); ?>:</label>
					                        	<div class="form-select">
						                            <select name="brand" id="brand-<?php echo $uniq; ?>" aria-label="<?php _e( 'Preferovaná značka', 'kno' ); ?>">
						                                <option value=""><?php _e( 'Vyberte', 'kno' ); ?></option>
														<?php
														$brands = get_terms( array(
														    'taxonomy' => 'product_brand',
														    'hide_empty' => false,
														) );
														if ( $brands && ! is_wp_error( $brands ) ) : foreach( $brands as $brand ): ?>
						                                <option value="<?php echo $brand->slug; ?>"><?php echo $brand->name; ?></option>
						                            	<?php endforeach; endif; ?>
						                            </select>
						                            <i class="bar"></i>
					                        	</div>
					                        </div>
							            </div>
							            <div class="col-md-12">
					                        <div class="form-group">
					                        	<label><?php _e( 'Výška mesačnej splátky', 'kno' ); ?>:</label>
							            		<div class="inquiry-range"></div>
							            	</div>
							            </div>
							            <div class="col-md-6 mb">
					                        <div class="form-group required">
					                        	<label for="fullname-<?php echo $uniq; ?>"><?php _e( 'Meno a priezvisko', 'kno' ); ?>:</label>
					                            <input type="text" name="fullname" id="fullname-<?php echo $uniq; ?>" data-validate-required-message="<?php _e( 'Meno a priezvisko je povinné.', 'kno' ); ?>" required aria-label="<?php _e( 'Meno a priezvisko', 'kno' ); ?>">
					                        </div>
					                    </div>
					                    <div class="col-md-6 mb">
					                        <div class="form-group">
					                            <label for="city-<?php echo $uniq; ?>"><?php _e( 'Mesto', 'kno' ); ?>:</label><i class="bar"></i>
					                            <input type="text" name="city" id="city-<?php echo $uniq; ?>" aria-label="<?php _e( 'Mesto', 'kno' ); ?>" value="" onkeyup="this.setAttribute('value', this.value);">
					                        </div>
					                    </div>
					                    <div class="col-md-6 mb">
					                        <div class="form-group required">
					                            <label for="email-<?php echo $uniq; ?>"><?php _e( 'E-mail', 'kno' ); ?>:</label><i class="bar"></i>
					                            <input type="email" name="email" id="email-<?php echo $uniq; ?>" value="@" data-validate-required-message="<?php _e( 'E-mail je povinný.', 'kno' ); ?>" required data-validate-email-message="<?php _e( 'E-mail je povinný.', 'kno' ); ?>" aria-label="<?php _e( 'E-mail', 'kno' ); ?>">
					                        </div>
					                    </div>
					                    <div class="col-md-6 mb">
					                        <div class="form-group required">
					                            <label for="phone-<?php echo $uniq; ?>"><?php _e( 'Telefón', 'kno' ); ?>:</label><i class="bar"></i>
					                            <input type="text" name="phone" id="phone-<?php echo $uniq; ?>" data-validate-required-message="<?php _e( 'Telefón je povinný.', 'kno' ); ?>" required aria-label="<?php _e( 'Telefón', 'kno' ); ?>">
					                        </div>
					                    </div>

					                    <div class="col-md-12">
						                    <?php if ( $privacy_page = get_option( 'wp_page_for_privacy_policy' ) ): ?>
				                            <div class="flex mt middle-xs between-xs">
					                            <div class="checkbox required">
					                                <label>
					                                    <input type="checkbox" name="terms" required data-validate-required-message="<?php _e( 'Podmienky sú povinné.', 'kno' ); ?>"/><i class="helper"></i><?php _e( 'Súhlasím so spracovaním osobných údajov', 'kno'); ?>
					                                </label>
					                            </div>
					                        </div>
						                	<?php endif; ?>
						                    <div class="form-group tc">
						                        <button type="submit" class="btn btn-inline btn-gradient"><?php _e( 'Odoslať požiadavku', 'kno'); ?></button>
						                    </div>
						                </div>
						            </div>
				            	</fieldset>

					        </div>
					    </div>
					</form>
	    		</div>
			</div>
		</div>
	</div>
</div>