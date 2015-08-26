<?php

/**
 * Custom Welcome Panel for Dadmin.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    Dadmin
 * @subpackage Dadmin/admin/partials
 */
?>

	<div class="welcome-panel-content">
		<h3><?php _e( 'Welcome to WordPress!' ); ?></h3>
		<p class="about-description"><?php _e( 'We&#8217;ve assembled some links to get you started:' ); ?></p>
		<div class="welcome-panel-column-container">
			<div class="welcome-panel-column">
				<?php if ( current_user_can( 'customize' ) ): ?>
					<h4><?php _e( 'Get Started' ); ?></h4>
					<a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?php echo wp_customize_url(); ?>"><?php _e( 'Customize Your Site' ); ?></a>
				<?php endif; ?>
				<a class="button button-primary button-hero hide-if-customize" href="<?php echo admin_url( 'themes.php' ); ?>"><?php _e( 'Customize Your Site' ); ?></a>
				<?php if ( current_user_can( 'install_themes' ) || ( current_user_can( 'switch_themes' ) && count( wp_get_themes( array( 'allowed' => true ) ) ) > 1 ) ) : ?>
					<p class="hide-if-no-customize"><?php printf( __( 'or, <a href="%s">change your theme completely</a>' ), admin_url( 'themes.php' ) ); ?></p>
				<?php endif; ?>
			</div>
			<div class="welcome-panel-column">
				<h4><?php _e( 'Next Steps' ); ?></h4>
				<ul>
					<?php if ( 'page' == get_option( 'show_on_front' ) && ! get_option( 'page_for_posts' ) ) : ?>
						<li><?php printf( '<a href="%s" class="welcome-icon welcome-edit-page">' . __( 'Edit your front page' ) . '</a>', get_edit_post_link( get_option( 'page_on_front' ) ) ); ?></li>
						<li><?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Add additional pages' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?></li>
					<?php elseif ( 'page' == get_option( 'show_on_front' ) ) : ?>
						<li><?php printf( '<a href="%s" class="welcome-icon welcome-edit-page">' . __( 'Edit your front page' ) . '</a>', get_edit_post_link( get_option( 'page_on_front' ) ) ); ?></li>
						<li><?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Add additional pages' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?></li>
						<li><?php printf( '<a href="%s" class="welcome-icon welcome-write-blog">' . __( 'Add a blog post' ) . '</a>', admin_url( 'post-new.php' ) ); ?></li>
					<?php else : ?>
						<li><?php printf( '<a href="%s" class="welcome-icon welcome-write-blog">' . __( 'Write your first blog post' ) . '</a>', admin_url( 'post-new.php' ) ); ?></li>
						<li><?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Add an About page' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?></li>
					<?php endif; ?>
					<li><?php printf( '<a href="%s" class="welcome-icon welcome-view-site">' . __( 'View your site' ) . '</a>', home_url( '/' ) ); ?></li>
				</ul>
			</div>
			<div class="welcome-panel-column welcome-panel-last">
				<h4><?php _e( 'More Actions' ); ?></h4>
				<ul>
					<?php if ( current_theme_supports( 'widgets' ) || current_theme_supports( 'menus' ) ) : ?>
						<li><div class="welcome-icon welcome-widgets-menus"><?php
								if ( current_theme_supports( 'widgets' ) && current_theme_supports( 'menus' ) ) {
									printf( __( 'Manage <a href="%1$s">widgets</a> or <a href="%2$s">menus</a>' ),
										admin_url( 'widgets.php' ), admin_url( 'nav-menus.php' ) );
								} elseif ( current_theme_supports( 'widgets' ) ) {
									echo '<a href="' . admin_url( 'widgets.php' ) . '">' . __( 'Manage widgets' ) . '</a>';
								} else {
									echo '<a href="' . admin_url( 'nav-menus.php' ) . '">' . __( 'Manage menus' ) . '</a>';
								}
								?></div></li>
					<?php endif; ?>
					<?php if ( current_user_can( 'manage_options' ) ) : ?>
						<li><?php printf( '<a href="%s" class="welcome-icon welcome-comments">' . __( 'Turn comments on or off' ) . '</a>', admin_url( 'options-discussion.php' ) ); ?></li>
					<?php endif; ?>
					<li><?php printf( '<a href="%s" class="welcome-icon welcome-learn-more">' . __( 'Learn more about getting started' ) . '</a>', __( 'https://codex.wordpress.org/First_Steps_With_WordPress' ) ); ?></li>
				</ul>
			</div>
		</div>
	</div>