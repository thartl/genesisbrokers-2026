<?php
/**
 * Template Name: Landing page
 */

$phone_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50" height="50"><path d="M39.031 47h-.047c-7.515-.246-16.32-7.531-22.386-13.602-6.075-6.07-13.36-14.878-13.594-22.359-.086-2.625 6.355-7.293 6.422-7.34 1.672-1.164 3.527-.75 4.289.305.515.715 5.398 8.113 5.93 8.953.55.871.468 2.168-.22 3.469-.378.722-1.636 2.933-2.226 3.965.637.906 2.32 3.129 5.797 6.605 3.48 3.477 5.7 5.164 6.61 5.8 1.03-.589 3.242-1.847 3.964-2.226 1.282-.68 2.57-.765 3.45-.226.898.55 8.277 5.457 8.957 5.93.57.402.937 1.09 1.011 1.89.07.809-.18 1.664-.699 2.41-.043.063-4.656 6.426-7.258 6.426Z"/></svg>';

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php

	$nectar_options = get_nectar_theme_options();
	if ( ! empty( $nectar_options['favicon'] ) && ! empty( $nectar_options['favicon']['url'] ) ) { ?>
		<link rel="shortcut icon" href="<?php echo nectar_options_img( $nectar_options['favicon'] ); ?>" />
	<?php }

	wp_head();
	?>
</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div class="site-container">
	<div class="site-inner">
		<div class="content-area">
			<main class="site-main" role="main">
				<article class="type-page">
					<div class="entry-content">
						<?php
						while ( have_posts() ) : the_post();
							the_content();
						endwhile;
						?>
					</div>
				</article>
			</main>
		</div>
	</div>
</div>

<footer class="site-footer" role="contentinfo">
    <div class="wrap">
        <div class="copyright">© 2025 Genesis Reverse Mortgages.</div>
        <div class="agency-info">Genesis Associates Ltd, Licensed in Ont: 10295,  BC: MBX611010</div>
        <div class="agent-info">Lucas Munn - Mortgage Agent Level 1:  M24000987</div>
        <div class="broker-info">Rob Munn - Broker, Licensed in Ont: M08002081,  BC: MB611118</div>
    </div>
</footer>
<a class="footer-call-cta-wrap" href="tel:+18664104740">
    <div class="footer-call-cta">
        <div class="inner">
            <span class="icon"><?php echo $phone_icon; ?></span>
        </div>
        <span class="cta-text">call now</span>
    </div>
</a>


<?php wp_footer(); ?>
</body>
</html>
