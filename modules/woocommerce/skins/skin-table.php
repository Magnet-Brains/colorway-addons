<?php
namespace CwAddons\Modules\Woocommerce\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Table extends Elementor_Skin_Base {
	public function get_id() {
		return 'ink-table';
	}

	public function get_title() {
		return __( 'Table', 'colorway-addons' );
	}

	public function render_loop_item() {
		$settings = $this->parent->get_settings();
		$id = 'ink-wc-products-skin-table-' . $this->parent->get_id();
		global $post;

		$wp_query = $this->parent->render_query();

		if($wp_query->have_posts()) {

			$this->parent->add_render_attribute('wc-product-table', 'class', ['ink-table-middle', 'ink-wc-product']);

			$this->parent->add_render_attribute('wc-product-table', 'id', esc_attr( $id ));

			if ($settings['cell_border']) {
				$this->parent->add_render_attribute('wc-product-table', 'class', 'cell-border');
			}

			if ($settings['stripe']) {
				$this->parent->add_render_attribute('wc-product-table', 'class', 'stripe');
			}

			if ($settings['hover_effect']) {
				$this->parent->add_render_attribute('wc-product-table', 'class', 'hover');
			}

			?>
			<table <?php echo $this->parent->get_render_attribute_string( 'wc-product-table' ); ?>>
				<thead>
					<tr>

						<th>Image</th>

						<?php if ( 'yes' == $settings['show_title']) : ?>
							<th>Title</th>
						<?php endif; ?>

						<?php if ( 'yes' == $settings['show_excerpt']) : ?>
							<th>Description</th>
						<?php endif; ?>

						<?php if ( 'yes' == $settings['show_price']) : ?>
							<th class="ink-ep-align">Price</th>
						<?php endif; ?>

						<?php if ( 'yes' == $settings['show_rating']) : ?>
							<th class="ink-ep-align">Rating</th>
						<?php endif; ?>

						<?php if ( 'yes' == $settings['show_cart']) : ?>
							<th class="ink-ep-align">Cart</th>
						<?php endif; ?>

					</tr>
				</thead>
  				<tbody>
			<?php
			while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
					<tr>
						<td>
							 <?php $this->render_image(); ?>
						</td>


						<?php if ( 'yes' == $settings['show_title']) : ?>
							<td>
								<h4 class="ink-wc-product-title">
									<a href="<?php the_permalink(); ?>" class="ink-link-reset">
						               <?php the_title(); ?>
						           </a>
						       </h4>
							</td>
					    <?php endif; ?>

					    <?php if ( 'yes' == $settings['show_excerpt']) : ?>
							<td>
								<div class="ink-wc-product-excerpt">
									<?php echo wp_kses_post(\colorway_addons_helper::custom_excerpt($settings['excerpt_limit'])); ?>
								</div>
							</td>
					    <?php endif; ?>


						<?php if ( 'yes' == $settings['show_price']) : ?>
							<td class="ink-ep-align">
								<span class="ink-wc-product-price">
									<?php woocommerce_template_single_price(); ?>
								</span>
							</td>
					    <?php endif; ?>


						 <?php if ('yes' == $settings['show_rating']) : ?>
							<td class="ink-ep-align">
								<div class="ink-wc-rating">
						   			<?php woocommerce_template_loop_rating(); ?>
								</div>
							</td>
					    <?php endif; ?>


						 <?php if ('yes' == $settings['show_cart']) : ?>
							<td class="ink-ep-align">
								<div class="ink-wc-add-to-cart">
									<?php woocommerce_template_loop_add_to_cart();?>
								</div>
							</td>
					    <?php endif; ?>
					</tr>

			<?php endwhile;
			wp_reset_postdata(); ?>

				</tbody>
			</table>
			<?php

		} else {
			echo '<div class="ink-alert-warning" ink-alert>Sorry!! There is no product<div>';
		}
	}

	public function render_image() {
		?>
		<div class="ink-wc-product-image ink-display-inline-block">
			<a href="<?php the_permalink(); ?>">
				<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), 'thumbnail'); ?>">
			</a>
		</div>
		<?php
	}

	public function render() {
		$settings = $this->parent->get_settings();
		$id = 'ink-wc-products-skin-table-' . $this->parent->get_id();

		$this->parent->render_header("table");
		$this->render_loop_item();
		$this->parent->render_footer();

		?>

		<script>
			jQuery(document).ready(function($) {
			    jQuery('#<?php echo esc_attr($id); ?>').DataTable({
		    		'paging'    : <?php echo ($settings['show_pagination']) ? 'true' : 'false' ?>,
		    		'info'      : <?php echo ($settings['show_info']) ? 'true' : 'false' ?>,
		    		'searching' : <?php echo ($settings['show_searching']) ? 'true' : 'false' ?>,
		    		'ordering'  : <?php echo ($settings['show_ordering']) ? 'true' : 'false' ?>,
		    	});
			});
		</script>

		<?php
	}
}

