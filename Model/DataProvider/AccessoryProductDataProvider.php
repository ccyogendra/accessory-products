<?php
declare(strict_types=1);

namespace Mageplugin\RelatedProducts\Model\DataProvider;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Link;
use Magento\Catalog\Model\Product\LinkFactory;
use Magento\Framework\EntityManager\HydratorPool;
use Magento\Framework\EntityManager\MetadataPool;

/**
 * Accessory Products Data Provider
 */
class AccessoryProductDataProvider
{
    /**
     * @var LinkFactory
     */
    private $linkFactory;

    /**
     * @var MetadataPool
     */
    private $metadataPool;

    /**
     * @var HydratorPool
     */
    private $hydratorPool;

    /**
     * @param LinkFactory $linkFactory
     * @param MetadataPool|null $metadataPool
     * @param HydratorPool|null $hydratorPool
     */
    public function __construct(
        LinkFactory $linkFactory,
        ?MetadataPool $metadataPool = null,
        ?HydratorPool $hydratorPool = null
    ) {
        $this->linkFactory = $linkFactory;
        $this->metadataPool = $metadataPool
            ?? \Magento\Framework\App\ObjectManager::getInstance()->get(MetadataPool::class);
        $this->hydratorPool = $hydratorPool
            ?? \Magento\Framework\App\ObjectManager::getInstance()->get(HydratorPool::class);
    }

    /**
     * Accessory Products Data
     *
     * @param Product $product
     * @param array $fields
     * @param int $linkType
     * @return array
     */
    public function getData(Product $product, array $fields, int $linkType): array
    {
        $accessoryProducts = $this->getAccessoryProducts($product, $fields, $linkType);

        $productsData = [];
        foreach ($accessoryProducts as $accessoryProduct) {
            $productData = $accessoryProduct->getData();
            $productData['model'] = $accessoryProduct;
            $productsData[] = $productData;
        }
        return $productsData;
    }

    /**
     * Get Accessory Products
     *
     * @param Product $product
     * @param array $fields
     * @param int $linkType
     * @return Product[]
     */
    private function getAccessoryProducts(Product $product, array $fields, int $linkType): array
    {
        /** @var Link $link */
        $link = $this->linkFactory->create(['data' => ['link_type_id' => $linkType]]);

        $collection = $link->getProductCollection();
        $collection->setIsStrongMode();
        foreach ($fields as $field) {
            $collection->addAttributeToSelect($field);
        }
        $collection->setProduct($product);

        return $collection->getItems();
    }

    /**
     * Get accessory product IDs for given products.
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface[] $products
     * @param int $linkType
     * @return string[][] keys - IDs, values - list of linked product IDs.
     */
    public function getRelations(array $products, int $linkType): array
    {
        //Links use real IDs for root products, we need to get them
        $actualIdField = $this->metadataPool->getMetadata(ProductInterface::class)->getLinkField();
        $hydrator = $this->hydratorPool->getHydrator(ProductInterface::class);
        /** @var ProductInterface[] $productsByActualIds */
        $productsByActualIds = [];
        foreach ($products as $product) {
            $productsByActualIds[$hydrator->extract($product)[$actualIdField]] = $product;
        }
        //Load all links
        /** @var Link $link */
        $link = $this->linkFactory->create(['data' => ['link_type_id' => $linkType]]);
        $collection = $link->getLinkCollection();
        $collection->addFieldToFilter('product_id', ['in' => array_keys($productsByActualIds)]);
        $collection->addLinkTypeIdFilter();

        //Prepare map
        $map = [];
        /** @var Link $item */
        foreach ($collection as $item) {
            $productId = $productsByActualIds[$item->getProductId()]->getId();
            if (!array_key_exists($productId, $map)) {
                $map[$productId] = [];
            }
            $map[$productId][] = $item->getLinkedProductId();
        }

        return $map;
    }
}
