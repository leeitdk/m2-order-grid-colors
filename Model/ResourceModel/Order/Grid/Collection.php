<?php

namespace Leeit\OrderGridColors\Model\ResourceModel\Order\Grid;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Sales\Model\ResourceModel\Order;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as OriginalCollection;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface as Logger;

/**
 * @package Leeit\OrderGridColors\Model\ResourceModel\Order\Grid
 */
class Collection extends OriginalCollection
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public $scopeConfig;

    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        ScopeConfigInterface $scopeConfig,
        $mainTable = 'sales_order_grid',
        $resourceModel = Order::class
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
        $this->scopeConfig = $scopeConfig;
    }

    protected function _renderFiltersBefore()
    {
        $enabled = (bool) $this->scopeConfig->getValue(
            'leeit_ordergridcolors/grid/enabled',
            ScopeInterface::SCOPE_STORE
        );

        if ($enabled) {
            $joinTable = $this->getTable('sales_order');
            $this->getSelect()->joinLeft($joinTable, 'main_table.entity_id = sales_order.entity_id', ['state']);
        }
        parent::_renderFiltersBefore();
    }
}
