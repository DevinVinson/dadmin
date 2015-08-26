<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    Dadmin
 * @subpackage Dadmin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dadmin
 * @subpackage Dadmin/admin
 * @author     Devin Vinson <devinvinson@gmail.com>
 */
class Dadmin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dadmin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dadmin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dadmin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dadmin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dadmin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dadmin-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Remove the default Admin bar content.
	 *
	 * No more W logo to direct anyone offsite and only direct user back to admin when on the front end,
	 *
	 * @param $wp_admin_bar
	 */
	public function remove_default_admin_bar( $wp_admin_bar ){

		$ids = array(
			'wp-logo',
			'updates',
			'comments',
			'new-content',
			'customize',
			//'my-account'

		);
		foreach( $ids as $id) {
			$wp_admin_bar->remove_node( $id );
		}

	}

	/**
	 * Get rid of all default dashboard panels.
	 *
	 * Removes the welcome panel, dashboard widgets.
	 *
	 */
	public function remove_dashboard_defaults() {

		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8

		/**
		 * Remove the default Welcome Panel
		 */
		remove_action( 'welcome_panel', 'wp_welcome_panel' );

	}

	/**
	 * Add the WPHost Welcome Panel
	 *
	 * @since 1.0.0
	 */
	public function dadmin_welcome_panel() {
		include_once 'partials/dadmin-dashboard-welcome.php';
	}

	/**
	 * Add the "My Account" item.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Admin_Bar $wp_admin_bar
	 */
	function dadmin_admin_bar_my_account_item( $wp_admin_bar ) {

		global $wp_admin_bar;

		$user_id      = get_current_user_id();
		$current_user = wp_get_current_user();
		$profile_url  = get_edit_profile_url( $user_id );

		if ( ! $user_id )
			return;

		$avatar = get_avatar( $user_id, 26 );
		$howdy  = sprintf( __('%1$s'), $current_user->display_name );
		$class  = empty( $avatar ) ? '' : 'with-avatar';

		$wp_admin_bar->add_menu( array(
			'id'        => 'my-account',
			'parent'    => 'top-secondary',
			'title'     => $howdy . $avatar,
			'href'      => $profile_url,
			'meta'      => array(
				'class'     => $class,
			),
		) );
	}


	/**
	 * Add the "Site Name" menu.
	 *
	 * @since 3.3.0
	 *
	 * @param WP_Admin_Bar $wp_admin_bar
	 */
	function dadmin_admin_bar_site_menu( $wp_admin_bar ) {

		global $wp_admin_bar;

		// Don't show for logged out users.
		if ( ! is_user_logged_in() )
			return;

		// Show only when the user is a member of this site, or they're a super admin.
		if ( ! is_user_member_of_blog() && ! is_super_admin() )
			return;

		$blogname = get_bloginfo('name');

		if ( ! $blogname ) {
			$blogname = preg_replace( '#^(https?://)?(www.)?#', '', get_home_url() );
		}

		if ( is_network_admin() ) {
			$blogname = sprintf( __('Network Admin: %s'), esc_html( get_current_site()->site_name ) );
		} elseif ( is_user_admin() ) {
			$blogname = sprintf( __('User Dashboard: %s'), esc_html( get_current_site()->site_name ) );
		}

		$title = wp_html_excerpt( $blogname, 40, '&hellip;' );
		if ( !is_admin() ) {
			$title = 'Return to your site Admin';
		}
		$wp_admin_bar->add_menu( array(
			'id'    => 'site-name',
			'title' => $title,
			'href'  => is_admin() ? home_url( '/' ) : admin_url(),
		) );



		// Create submenu items.

		if ( is_admin() ) {
			// Add an option to visit the site.
			$wp_admin_bar->add_menu( array(
				'parent' => 'site-name',
				'id'     => 'view-site',
				'title'  => __( 'Visit Site' ),
				'href'   => home_url( '/' ),
			) );

			if ( is_blog_admin() && is_multisite() && current_user_can( 'manage_sites' ) ) {
				$wp_admin_bar->add_menu( array(
					'parent' => 'site-name',
					'id'     => 'edit-site',
					'title'  => __( 'Edit Site' ),
					'href'   => network_admin_url( 'site-info.php?id=' . get_current_blog_id() ),
				) );
			}

		} else {

			// Add the appearance submenu items.
			wp_admin_bar_appearance_menu( $wp_admin_bar );
		}
	}

}
