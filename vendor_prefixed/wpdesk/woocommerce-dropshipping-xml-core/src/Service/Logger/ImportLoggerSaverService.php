<?php

namespace DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Service\Logger;

use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\Entity\Import;
use DropshippingXmlFreeVendor\WPDesk\Library\DropshippingXmlCore\File\FileObject;
/**
 * Class ImportLoggerSaverService.
 *
 * @package WPDesk\Library\DropshippingXmlCore\Service\Logger
 */
class ImportLoggerSaverService
{
    public function save(ImportLoggerService $logger, FileObject $file): void
    {
        $formated_messages = $logger->get_formated_messages();
        file_put_contents($file->getRealPath(), $formated_messages, \FILE_APPEND | \LOCK_EX);
    }
    public function clean(FileObject $file): void
    {
        file_put_contents($file->getRealPath(), '');
    }
}
