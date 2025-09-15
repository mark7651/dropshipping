<?php

namespace DropshippingXmlFreeVendor;

use RuntimeException;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Component\GPSRComponent;
/**
 * @var GPSRComponent $field
 * @var \WPDesk\View\Renderer\Renderer $renderer
 * @var string $name_prefix
 * @var array $value
 *
 * @var string $template_name Real field template.
 */
$name_prefix = $name_prefix . '[gpsr_fields]';
$get_item = function (string $field_name) use ($field) {
    foreach ($field->get_items() as $item) {
        if ($field_name === $item->get_id() || $field_name === $item->get_name()) {
            return $item;
        }
    }
    return null;
};
$get_value = function (string $field_name) use ($value) {
    if (\is_array($value) && isset($value[$field_name])) {
        return $value[$field_name];
    }
    return null;
};
?>

<div id="woocommerce-gpsr" class="postbox group-switch">
	<h2 class="group-switcher"><span><?php 
echo \esc_html__('GPSR', 'dropshipping-xml-for-woocommerce');
?></span> <span class="group-arrow dashicons dashicons-arrow-down"></span></h2>
		<div class="inside" style="padding: 10px">
			<h3><?php 
echo \esc_html__('Manufacturer Details', 'dropshipping-xml-for-woocommerce');
?></h3>
			<?php 
$item = $get_item('manufacturer_name');
?>
			<p class="form-field">
				<label>
					<?php 
echo \esc_html($item->get_label());
?>
				</label>
			<p class="form-field">
			<?php 
$renderer->output_render($item->get_template_name(), ['field' => $item, 'renderer' => $renderer, 'name_prefix' => $name_prefix, 'value' => $get_value($item->get_name())]);
?>
			</p>

			<?php 
$item = $get_item('manufacturer_address');
?>
			<p class="form-field">
				<label>
					<?php 
echo \esc_html($item->get_label());
?>
				</label>
			<p class="form-field">
			<?php 
$renderer->output_render($item->get_template_name(), ['field' => $item, 'renderer' => $renderer, 'name_prefix' => $name_prefix, 'value' => $get_value($item->get_name())]);
?>
			</p>

			<?php 
$item = $get_item('manufacturer_email');
?>
			<p class="form-field">
				<label>
					<?php 
echo \esc_html($item->get_label());
?>
				</label>
			<p class="form-field">
			<?php 
$renderer->output_render($item->get_template_name(), ['field' => $item, 'renderer' => $renderer, 'name_prefix' => $name_prefix, 'value' => $get_value($item->get_name())]);
?>
			</p>

			<h3><?php 
echo \esc_html__('Importer Details', 'dropshipping-xml-for-woocommerce');
?></h3>
			<?php 
$item = $get_item('importer_name');
?>
			<p class="form-field">
				<label>
					<?php 
echo \esc_html($item->get_label());
?>
				</label>
			<p class="form-field">
			<?php 
$renderer->output_render($item->get_template_name(), ['field' => $item, 'renderer' => $renderer, 'name_prefix' => $name_prefix, 'value' => $get_value($item->get_name())]);
?>
			</p>

			<?php 
$item = $get_item('importer_address');
?>
			<p class="form-field">
				<label>
					<?php 
echo \esc_html($item->get_label());
?>
				</label>
			<p class="form-field">
			<?php 
$renderer->output_render($item->get_template_name(), ['field' => $item, 'renderer' => $renderer, 'name_prefix' => $name_prefix, 'value' => $get_value($item->get_name())]);
?>
			</p>

			<?php 
$item = $get_item('importer_email');
?>
			<p class="form-field">
				<label>
					<?php 
echo \esc_html($item->get_label());
?>
				</label>
			<p class="form-field">
			<?php 
$renderer->output_render($item->get_template_name(), ['field' => $item, 'renderer' => $renderer, 'name_prefix' => $name_prefix, 'value' => $get_value($item->get_name())]);
?>
			</p>

			<h3><?php 
echo \esc_html__('Other Details', 'dropshipping-xml-for-woocommerce');
?></h3>
			<?php 
$item = $get_item('details_trademark');
?>
			<p class="form-field">
				<label>
					<?php 
echo \esc_html($item->get_label());
?>
				</label>
			<p class="form-field">
			<?php 
$renderer->output_render($item->get_template_name(), ['field' => $item, 'renderer' => $renderer, 'name_prefix' => $name_prefix, 'value' => $get_value($item->get_name())]);
?>
			</p>
			<?php 
$item = $get_item('details_certificates');
?>
			<p class="form-field">
				<label>
					<?php 
echo \esc_html($item->get_label());
?>
				</label>
			<p class="form-field">
			<?php 
$renderer->output_render($item->get_template_name(), ['field' => $item, 'renderer' => $renderer, 'name_prefix' => $name_prefix, 'value' => $get_value($item->get_name())]);
?>
			</p>

			<h3><?php 
echo \esc_html__('Usage Instructions', 'dropshipping-xml-for-woocommerce');
?></h3>
			<?php 
$item = $get_item('usage_instructions_text');
?>
			<p class="form-field">
				<label>
					<?php 
echo \esc_html($item->get_label());
?>
				</label>
			<p class="form-field">
			<?php 
$renderer->output_render($item->get_template_name(), ['field' => $item, 'renderer' => $renderer, 'name_prefix' => $name_prefix, 'value' => $get_value($item->get_name())]);
?>
			</p>	
	</div>
</div>
<?php 
