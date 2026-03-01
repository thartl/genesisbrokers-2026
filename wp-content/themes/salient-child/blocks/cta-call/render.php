<?php
/**
 * Image Array block template
 *
 * @param array $block The block settings and attributes.
 **/


// Support custom id values.
$block_id = '';
if ( ! empty( $block['anchor'] ) ) {
	$block_id = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className".
$class_name = 'block-cta-call';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

$style                = get_field( 'style' );
$cta_line             = get_field( 'cta_line' ) ? esc_html( get_field( 'cta_line' ) ) : '';
$phone_number         = get_field( 'phone_number' ) ? esc_html( get_field( 'phone_number' ) ) : '';
$scroll_button_text   = get_field( 'scroll_button_text' ) ? esc_html( get_field( 'scroll_button_text' ) ) : '';
$scroll_button_anchor = get_field( 'scroll_button_anchor' ) ? esc_html( get_field( 'scroll_button_anchor' ) ) : '';

$phone_number_url = preg_replace( '/[^0-9]/', '', $phone_number );
$phone_number_url = $phone_number_url ? 'tel:+' . $phone_number_url : '';

// Header style if true
$style_class = $style ? ' style-header' : '';


if ( ! $is_preview ) {

	// Wrap on front end
	$block_attributes = wp_kses_data(
		get_block_wrapper_attributes(
			array(
				'id'    => $block_id,
				'class' => esc_attr( $class_name ),
			)
		)
	);

	echo '<div ' . $block_attributes . '>';
}

if ( $is_preview && empty( $cta_line ) ) {

	// No events - Back end
	echo '<p style="padding: 1rem; margin:1rem 0; border:1px solid #345"><span style="display: inline-block; margin-right: 2rem;">Add content in the sidebar.</span></p>';

} elseif ( empty( $cta_line ) ) {

	// No events - Front end
	echo '';

} else {

	?>
	<div class="call-cta-inner<?php echo $style_class; ?>">
		<div class="wp-block-button button_scroll"><a href="#<?php echo $scroll_button_anchor; ?>"
		                                              class="wp-block-button__link wp-element-button"><?php echo $scroll_button_text; ?></a></div>
		<div class="contacts">
			<p class="cta-text"><?php echo $cta_line; ?></p>
			<div class="wp-block-button button_phone"><a href="<?php echo $phone_number_url; ?>"
			                                              class="wp-block-button__link wp-element-button"><?php echo $phone_number; ?></a>
			</div>
		</div>
	</div>
	<?php
}

if ( ! $is_preview ) {

	echo '</div>';
}
