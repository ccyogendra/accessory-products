<?php
namespace Mageplugin\RelatedProducts\Model\ProductLink\CollectionProvider;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductLink\CollectionProviderInterface;

class Accessory implements CollectionProviderInterface
{
    /** @var \Mageplugin\RelatedProducts\Model\Accessory */
    protected $accessoryModel;

    /**
     * Accessory constructor.
     * @param \Mageplugin\RelatedProducts\Model\Accessory $accessoryModel
     */
    public function __construct(
        \Mageplugin\RelatedProducts\Model\Accessory $accessoryModel
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
