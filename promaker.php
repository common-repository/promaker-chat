<?php
/*
Plugin Name:  Promaker Chat
Description:  Inserta un botón de contacto por WhatsApp en tu web.
Version:      1.0
Author:       Jonathan Peralta | Promaker
Author URI:   https://promaker.com.ar
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/
if ( ! defined( 'ABSPATH' ) ) exit;
/*===== Assets button =====*/
function promaker_chat_assets() {
    wp_enqueue_style( 'promaker_chat', plugin_dir_url( __FILE__ ) . 'css/promaker_chat.min.css', 1.0, false );
}
add_action( 'wp_enqueue_scripts', 'promaker_chat_assets' );
/*===== Options panel =====*/
if ( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> '<span class="dashicons dashicons-whatsapp" style="font-size: 28px;margin-right: 0.5rem;"></span>&nbsp;Promaker Chat <b>v1.0</b>',
		'menu_title'	=> 'Promaker Chat',
		'menu_slug' 	=> 'promaker-chat',
		'icon_url'		=>  'dashicons-whatsapp',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'update_button'		=> 'Actualizar', 'acf',
		'updated_message'		=> "Los cambios se han guardado con éxito!", 'acf'
	));
};
/*===== Add button after footer content =====*/
function promaker_chat_html() { ?>
	<?php if ( get_field( 'ocultar', 'option' ) == 0 ): ?>
		<?php $numero = get_field( 'numero', 'option' ); ?>
		<?php $posicion = get_field( 'posicion', 'option' ); ?>
		<?php $sombra = get_field( 'sombra', 'option' ); ?>
		<?php $mensaje = get_field( 'mensaje', 'option' ); ?>
		<a href="https://wa.me/+549<?php echo esc_html( $numero ); ?><?php if ( $mensaje ): ?>?text=<?php echo esc_html( $mensaje ); ?><?php endif; ?>" target="_blank" rel="nofollow noopener" class="promaker-whatsapp<?php if ( $sombra == 1 ): ?> shadow<?php endif; ?><?php if ( $posicion == "Derecha" ): ?> right<?php else: ?> left<?php endif; ?>">
			<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>/img/whatsapp.svg" alt="whatsapp" width="34" />
		</a>
	<?php endif; ?>
<?php }
add_action('wp_footer', 'promaker_chat_html');
/*===== Config slider =====*/
add_action( 'wp_print_footer_scripts', function () { ?>
	<?php $conversion_google_ads = get_field( 'conversion_google_ads', 'option' ); ?>
	<?php $conversiones_personalizadas = get_field( 'conversiones_personalizadas', 'option' ); ?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('.promaker-whatsapp').click(function() {
				gtag('event', 'conversion', {'send_to': '<?php echo esc_js( $conversion_google_ads ); ?>'});
				<?php if ( $conversiones_personalizadas ): ?>
					<?php echo esc_js( $conversiones_personalizadas ); ?>
				<?php endif; ?>
			});
		});
	</script>
<?php } );
/*===== ACF Fields =====*/
if ( function_exists('acf_add_local_field_group') ):
	acf_add_local_field_group(array(
		'key' => 'group_659eea89bdc7f',
		'title' => 'Ajustes Promaker Chat',
		'fields' => array(
			array(
				'key' => 'field_659eeabf9648d',
				'label' => '<span class="dashicons dashicons-share-alt2"></span> Botón',
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_659eeb9c317ca',
				'label' => 'Número de celular',
				'name' => 'numero',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '25',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_659eebcf317cb',
				'label' => 'Posición en pantalla',
				'name' => 'posicion',
				'type' => 'select',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '25',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'Izquierda' => 'Izquierda',
					'Derecha' => 'Derecha',
				),
				'default_value' => array(
				),
				'allow_null' => 0,
				'multiple' => 0,
				'ui' => 1,
				'ajax' => 0,
				'return_format' => 'value',
				'placeholder' => '',
			),
			array(
				'key' => 'field_659eec21317cc',
				'label' => 'Activar sombra',
				'name' => 'activar_sombra',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '25',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => '',
				'ui_off_text' => '',
			),
			array(
				'key' => 'field_659eec772b3f6',
				'label' => 'Ocultar',
				'name' => 'ocultar',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '25',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => '',
				'ui_off_text' => '',
			),
			array(
				'key' => 'field_659eec862b3f7',
				'label' => 'Mensaje',
				'name' => 'mensaje',
				'type' => 'textarea',
				'instructions' => 'Texto opcional predefinido para el primer mensaje que te enviará el usuario',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => 3,
				'new_lines' => '',
			),
			array(
				'key' => 'field_659eed34aa49d',
				'label' => '<span class="dashicons dashicons-google"></span> Marketing',
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'left',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_659efaf062235',
				'label' => 'Activar trackeo',
				'name' => 'activar_trackeo',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => '',
				'ui_off_text' => '',
			),
			array(
				'key' => 'field_659eed9eaa49e',
				'label' => 'Conversión de Google Ads',
				'name' => 'conversion_google_ads',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_659efaf062235',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => 'AW-XXXXXXXXX/XXXXXXXXXXXXXXXXXXX',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_659eedd4aa49f',
				'label' => 'Conversiones personalizadas',
				'name' => 'conversiones_personalizadas',
				'type' => 'textarea',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_659efaf062235',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => 4,
				'new_lines' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'promaker-chat',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	));
endif;