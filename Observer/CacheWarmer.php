<?php
namespace Negeka\PageCacheWarm\Observer;

use Negeka\PageCacheWarm\Model\PageCacheWarmer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class CacheWarmer implements ObserverInterface
{
    protected LoggerInterface $logger;
    protected PageCacheWarmer $pageCacheWarmer;
    public function __construct(
        PageCacheWarmer $pageCacheWarmer,
        LoggerInterface $logger
    ) {
        $this->pageCacheWarmer = $pageCacheWarmer;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $warmResult = $this->pageCacheWarmer->warmPageCache();
        $isAllSucceeded = true;
        $errorList = [];
        foreach ($warmResult as $item) {
            if ($item['success'] === false) {
                $isAllSucceeded = false;
            } else {
                $errorList[] = $item;
            }
        }
        if ($isAllSucceeded) {
            $this->logger->info('Cache warmer observer successfully completed.', ['observer_data' => $observer->getData()]);
        } else {
            $this->logger->info('Cache warmer observer can not completed.', ['observer_data' => $observer->getData(), 'error_list' => $errorList]);
        }
    }
}
