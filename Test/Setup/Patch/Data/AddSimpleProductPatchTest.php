<?php

namespace Scandiweb\Test\Setup\Patch\Data;

use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\App\State;

class AddSimpleProductPatchTest implements DataPatchInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ProductInterfaceFactory $productFactory
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryFactory $categoryFactory
     * @param CategoryRepositoryInterface $categoryRepository
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ProductInterfaceFactory $productFactory,
        ProductRepositoryInterface $productRepository,
        CategoryFactory $categoryFactory,
        CategoryRepositoryInterface $categoryRepository,
        StoreManagerInterface $storeManager,
        State $state
    )
    {
        $this->moduleDataSetup    = $moduleDataSetup;
        $this->productFactory     = $productFactory;
        $this->productRepository  = $productRepository;
        $this->categoryFactory    = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
        $this->storeManager       = $storeManager;
        $state->setAreaCode('adminhtml');
    }

    /**
     * @return string
     */
    public function apply()
    {
        $product = $this->productFactory->create();

        $product->setSku('123456789')
            ->setName('Test Product')
            ->setAttributeSetId('4')
            ->setStatus(1)
            ->setWeight(2)
            ->setPrice(0)
            ->setVisibility(1)
            ->setTypeId('simple')
            ->setStockData(
                array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'is_in_stock' => 1,
                    'qty' => 1
                )
            );
        $product = $this->productRepository->save($product);

        $product->save();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

}
