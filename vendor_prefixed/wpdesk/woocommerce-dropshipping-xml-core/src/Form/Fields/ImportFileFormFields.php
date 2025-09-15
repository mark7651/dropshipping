<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields;

use DropshippingXmlFreeVendor\WPDesk\Forms\Field\HiddenField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\InputTextField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\NoOnceField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\SubmitField;
use DropshippingXmlFreeVendor\WPDesk\Forms\Field\ButtonField;
use DropshippingXmlFreeVendor\WPDesk\Forms\FieldProvider;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Form\Fields\Field\InputUrlField;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Action\Loader\Notification\FileLimitNotificationAction;
/**
 * Class ImportFileFormFields, import file form fields.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Form\Fields
 */
class ImportFileFormFields implements FieldProvider
{
    const FILE_URL = 'file_url';
    const ORIGINAL_FILE_FORMAT = 'original_file_format';
    const ORIGINAL_FILE_NAME = 'original_file_name';
    const IMPORT = 'import';
    const NEXT_STEP = 'next_step';
    const NONCE_ACTION = 'import_connector_action';
    const NONCE_NAME = 'import_connector_nonce';
    const UID = 'uid';
    const CLIENT = 'client';
    const CLIENT_CURL = 'curl_http';
    /**
     *
     * @var FileLimitNotificationAction
     */
    private $file_limit_notification;
    public function __construct(FileLimitNotificationAction $file_limit_notification)
    {
        $this->file_limit_notification = $file_limit_notification;
    }
    /**
     * @see FieldProvider::get_fields()
     */
    public function get_fields()
    {
        $input = (new InputUrlField())->set_placeholder(esc_attr__('Add file url', 'dropshipping-xml-for-woocommerce'))->set_description(esc_html__('Complete the link to the CSV or XML file provided by your supplier and click the import button.', 'dropshipping-xml-for-woocommerce'))->add_class('input-text regular-input width-100 padding-sm hs-beacon-search')->set_attribute('data-beacon_search', __('Step 1/4 - File import', 'dropshipping-xml-for-woocommerce'))->set_name(self::FILE_URL);
        $button = (new ButtonField())->set_name(self::IMPORT)->set_label(esc_html__('Import file', 'dropshipping-xml-for-woocommerce'))->add_class('button button-secondary button-hero to-right')->set_attribute('id', self::IMPORT);
        if ($this->file_limit_notification->is_file_limit_reached()) {
            $input->set_disabled();
            $button->set_disabled();
        }
        return [$input, $button, (new SubmitField())->set_name(self::NEXT_STEP)->set_label(esc_html__('Go to the next step &rarr;', 'dropshipping-xml-for-woocommerce'))->add_class('button button-primary button-hero')->set_attribute('id', self::NEXT_STEP)->set_disabled(), (new HiddenField())->set_name(self::CLIENT)->set_default_value(self::CLIENT_CURL), (new HiddenField())->set_name(self::UID)->set_default_value($this->get_uid()), (new HiddenField())->set_name(self::ORIGINAL_FILE_FORMAT), (new HiddenField())->set_name(self::ORIGINAL_FILE_NAME), (new NoOnceField(self::NONCE_ACTION))->set_name(self::NONCE_NAME)];
    }
    private function get_uid(): string
    {
        return \uniqid();
    }
}
