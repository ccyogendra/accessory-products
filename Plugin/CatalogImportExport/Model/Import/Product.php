<?php
namespace Mageplugins\RelatedProducts\Plugin\CatalogImportExport\Model\Import;

use Magento\CatalogImportExport\Model\Import\Product as ProductImportExport;
use Mageplugins\RelatedProducts\Model\Product\Link;

class Product
{
    /**
     * REMARK: needs core patch
     * https://github.com/magento/magento2/pull/21230/commits/0846e9aed7040659e7ce3e109eb91df3f5fdfb7e.patch
     *
     * @param  ProductImportExport  $subject
     * @param $result
     * @return mixed
     */
    public function afterGetLinkNameToId(ProductImportExport $subject, $result)
    {
        $result['_accessory_'] = Link::LINK_TYPE_ACCESSORY;
        return $result;
    }
}
