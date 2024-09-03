<?php
namespace Mageplugins\RelatedProducts\Model\Product;

class Link extends \Magento\Catalog\Model\Product\Link
{
    public const LINK_TYPE_ACCESSORY = 7;

    /**
     * Set the link type to accessory links.
     *
     * @return $this
     */
    public function useAccessoryLinks(): self
    {
        $this->setLinkTypeId(self::LINK_TYPE_ACCESSORY);
        return $this;
    }
}
