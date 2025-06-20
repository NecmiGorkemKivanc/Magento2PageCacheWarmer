<?php

namespace Negeka\PageCacheWarm\Controller\Adminhtml\WarmCache;

use Negeka\PageCacheWarm\Model\PageCacheWarmer;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    protected PageCacheWarmer $pageCacheWarmer;

    public function __construct(
        Context         $context,
        PageCacheWarmer $pageCacheWarmer
    ) {
        parent::__construct($context);
        $this->pageCacheWarmer = $pageCacheWarmer;
    }

    public function execute()
    {
        try {
            $errorList = [];
            $isAllSucceeded = true;
            $pageResult =$this->pageCacheWarmer->warmPageCache();
            if (is_array($pageResult)) {
                foreach ($pageResult as $item) {

                    if ($item['success'] === false) {
                        $errorList[] = $item['url'];
                        $isAllSucceeded = false;
                    }
                }
            }if ($isAllSucceeded === true) {
                $this->messageManager->addSuccessMessage(__('All page caches have been warmed successfully.'));
            } elseif ($isAllSucceeded === false) {
                $this->messageManager->addSuccessMessage(__('Some page caches have been warmed successfully.'));
                $this->messageManager->addWarningMessage(__('Some page caches have not been warmed.'));
                $this->messageManager->addWarningMessage(__('Failed URLs: %1', implode(', ', $errorList)));
            }

        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong, try again later.'));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('adminhtml/system_config/edit', ['section' => 'page_cache_warm']);
    }
}
