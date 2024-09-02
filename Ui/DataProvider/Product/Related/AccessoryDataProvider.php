<?php
/**
 * Copyright © Mageplugins LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.mageplugins.com | support@mageplugins.com
 */

namespace Mageplugins\RelatedProducts\Ui\DataProvider\Product\Related;

use Magento\Catalog\Ui\DataProvider\Product\Related\AbstractDataProvider;

class AccessoryDataProvider extends AbstractDataProvider
{
    /**
     * {@inheritdoc
     */
    protected function getLinkType()
    {
        return 'accessory';
    }
}
