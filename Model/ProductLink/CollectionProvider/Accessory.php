<?php
namespace Mageplugins\RelatedProducts\Model\ProductLink\CollectionProvider;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductLink\CollectionProviderInterface;

class Accessory implements CollectionProviderInterface
{
    /** @var \Mageplugins\RelatedProducts\Model\Accessory */
    protected $accessoryModel;

    /**
     * Accessory constructor.
     * @param \Mageplugins\RelatedProducts\Model\Accessory $accessoryModel
     */
    public function __construct(
        \Mageplugins\RelatedProducts\Model\Accessory $accessoryModel
    ) {
        $this->accessoryModel = $accessoryModel;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkedProducts(Product $product)
    {
        return (array) $this->accessoryModel->getAccessoryProducts($product);
    }
}
