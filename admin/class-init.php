<?php

namespace SPSP\Admin;

use SPSP\Includes\Functions;

class Init {

	private static $instance = null;

	private function __construct() {
		$this->init();
	}

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new Init();
		}

		return self::$instance;
	}

	public function init() {
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
	}

	public function assets( $hook ) {
		if ( 'toplevel_page_super-reactions' === $hook ) {
			wp_enqueue_style( 'SPSP-admin' );
			wp_enqueue_script( 'SPSP-admin' );
		}
	}

	public function add_menu_page() {
		add_menu_page(
			__( 'Super Reactions', 'super-reactions' ),
			__( 'Reactions', 'super-reactions' ),
			'manage_options',
			'super-reactions',
			array( $this, 'renbder_settings_page' ),
			'dashicons-smiley',
			28
		);
	}

	public function renbder_settings_page() {
		?>
		<div class="SPSP-admin-wrapper">
			<div class="SPSP-admin-header">
				<div class="SPSP-logo">
					<?php SPSP_logo( 100, 100 ); ?>
				</div>
				<div class="SPSP-admin-title">
					<h1><?php esc_html_e( 'Super Reactions', 'super-reactions' ); ?></h1>
				</div>
			</div>
			<div class="SPSP-admin-main">
				<section class="SPSP-settings">
					<h2><?php esc_html_e( 'Templates:', 'super-reactions' ); ?></h2>
				<?php $this->template_selector(); ?>
				<?php wp_nonce_field('SPSP_save_settings'); ?>
				</section>
			</div>
		</div>
		<?php
	}

	public function template_selector() {
		?>
		<div class="SPSP-settings-wrapper">
		<?php
		$args = array(
			'public' => true,
		);

		$post_types = get_post_types( $args );

		// remove attachment from the list
		unset( $post_types['attachment'] );

		foreach ( $post_types as $post_type ) {
			$this->render_setting_row( $post_type );
		}

		?>
		</div>
		<?php
	}

	private function render_setting_row( $post_type ) {
		$reactions = SPSP_reactions();
		?>
			<div class="SPSP-template-selector">
				<label for="SPSP-template-selector-<?php echo esc_attr( $post_type ); ?>"><?php echo ucfirst( $post_type ) . ':'; ?></label>
				<select name="<?php echo esc_attr( $post_type ); ?>" id="SPSP-template-selector-<?php echo esc_attr( $post_type ); ?>">
					<option value="0"><?php esc_html_e( 'Disable', 'super-reactions' ); ?></option>
					<?php foreach ( $reactions as $slug => $reaction ) : ?>
						<?php $selected = SPSP_get_active_template_slug( $post_type ) === $slug ? 'selected' : ''; ?>
						<option value="<?php echo esc_attr( $slug ); ?>" <?php echo esc_attr( $selected ); ?> ><?php echo esc_html( $reaction['name'] ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>

		<?php
	}

}
