<?php
namespace Negeka\PageCacheWarm\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Button extends Field
{
    /**
     * @param  AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * @param  AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $url = $this->_urlBuilder->getUrl('pagecachewarm/warmcache/index');
        $html = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Button')
            ->setType('button')
            ->setClass('primary')
            ->setLabel(__('Warm Cache'))
            ->setOnClick("setLocation('{$url}')")
            ->toHtml();
        $html .= '<input type="hidden" name="form_key" value="' . $this->getFormKey() . '" />';
        return $html;
    }

    /** @return string */
    public function getButtonUrl()
    {
        return $this->getUrl('warmcache/index');
    }
}
