<?php
namespace Magento\SIDashboard\Block;

use Magento\Framework\View\Element\Template;

class Sidebar extends Template
{
    // Custom logic for the Sidebar block, if needed

    /**
     * Retrieve menu items for the sidebar
     *
     * @return array
     */
    public function getMenuItems()
    {
        return [
            ['label' => __('Menu Page 1'), 'url' => $this->getUrl('menu/page1')],
            ['label' => __('Menu Page 2'), 'url' => $this->getUrl('menu/page2')],
            ['label' => __('Menu Page 3'), 'url' => $this->getUrl('menu/page3')],
            ['label' => __('Menu Page 4'), 'url' => $this->getUrl('menu/page4')],
            // Add more menu items as needed
        ];
    }
}
