<?php

class Open_Attribute_Widget extends WP_Widget {

	public function __construct() {
        parent::__construct(
			'openattribute_widget',
			'OpenAttribute Widget',
			[
				'classname'   => 'OpenAttribute Widget',
				'description' => 'Display a a license for your blog post or entire site in a widget',
			],
			''
		);
	}

	/**
	 * Echoes the widget content
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		if ( ( $instance['openattribute_link'] ) || $instance['openattribute_image'] ) {
			global $wp_query;

			if ( is_single() ) {
				if ( get_option( 'openattribute_widgetset' ) === '1' ) {
					$disable = get_post_meta( $wp_query->posts[0]->ID, 'disable_license' );

					if ( 'off' === $disable[0] || '' === $disable[0] ) {
						$display = true;

						if ( get_option( 'openattribute_blogoverride' ) === '1' ) {
							$content     = $wp_query->posts[0]->post_content;
							$author      = explode( 'oaauthor', $content );
							$title       = explode( 'oatitle', $content );
							$oashorthand = explode( 'oashorthand', $content );

							if ( count( $author ) !== 1 ) {
								$display = false;
							}

							if ( count( $title ) !== 1 ) {
								$display = false;
							}

							if ( count( $oashorthand ) !== 1 ) {
								$display = false;
							}
						}

						if ( $display ) {
							echo esc_html( $args['before_widget'] );
							echo esc_html( $args['before_title'] );
							echo 'Attribute me';
							echo esc_html( $args['after_title'] );

							if ( $instance['openattribute_image'] ) {
								echo '<a onclick="attribute_button(event)" style="cursor:hand; cursor:pointer"><img src="' . esc_url( WP_PLUGIN_URL . '/' . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) . 'attrib_button.png' ) . '" /></a>';
							}

							if ( $instance['openattribute_link'] ) {
								echo '<a onclick="attribute_button(event)" style="cursor:hand; cursor:pointer">Attribute this resource</a>';
							}

							echo esc_html( $args['after_widget'] );
						}
					}
				}
			}
		}
	}

	/**
	 * Updates a particular instance of a widget
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['openattribute_link']  = strip_tags( $new_instance['openattribute_link'] );
		$instance['openattribute_image'] = strip_tags( $new_instance['openattribute_image'] );

		return $instance;
	}

	/**
	 * Outputs the settings update form
	 *
	 * @return void
	 */
	public function form( $instance ) {
		?>
		<p>Tick the respective box if you wish the following to appear in this widget:</p>
		<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'openattribute_link' ) ); ?>"
		<?php
		if ( isset( $instance['openattribute_link'] ) && 'on' === $instance['openattribute_link'] ) {
			echo ' checked />';
		} else {
			echo ' />';
		}
		?>
		<label>"Attribute this resource"</label> <br />
		<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'openattribute_image' ) ); ?>"
		<?php
		if ( isset( $instance['openattribute_link'] ) && 'on' === $instance['openattribute_image'] ) {
			echo ' checked />';
		} else {
			echo ' />';
		}
		?>
		<label>OpenAttribute image</label>
		<?php
	}
}
