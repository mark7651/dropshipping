<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Validator\DataFormat;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\File\FileObject;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Infrastructure\Data\DataFormat;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Validator\DataFormat\DataFormatValidator;
use RuntimeException;
/**
 * Class CsvDataFormatValidator, csv data format validator.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Validator\DataFormat
 */
class CsvDataFormatValidator implements DataFormatValidator
{
    public function is_content_valid(string $content): bool
    {
        return \true;
    }
    public function is_file_valid(FileObject $file): bool
    {
        if (!self::is_mime_type_supported($file->getMimeType())) {
            throw new RuntimeException('Mime type ' . $file->getMimeType() . ' is not supported by Csv validator');
        }
        return \true;
    }
    public static function is_mime_type_supported(string $mime_type): bool
    {
        return (new DataFormat())->is_csv($mime_type);
    }
}
