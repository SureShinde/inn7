<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Oc\Theme\Block\Html;
class Topmenu extends \Magento\Theme\Block\Html\Topmenu
{
    /**
     * Get top menu html
     *
     * @param string $outermostClass
     * @param string $childrenWrapClass
     * @param int $limit
     * @return string
     */
    public function getHtml($outermostClass = '', $childrenWrapClass = '', $limit = 0)
    {
        $this->_eventManager->dispatch(
            'page_block_html_topmenu_gethtml_before',
            ['menu' => $this->getMenu(), 'block' => $this, 'request' => $this->getRequest()]
        );

        $this->getMenu()->setOutermostClass($outermostClass);
        $this->getMenu()->setChildrenWrapClass($childrenWrapClass);

        $html = $this->_getHtml($this->getMenu(), $childrenWrapClass, $limit);

        $transportObject = new \Magento\Framework\DataObject(['html' => $html]);
        $this->_eventManager->dispatch(
            'page_block_html_topmenu_gethtml_after',
            ['menu' => $this->getMenu(), 'transportObject' => $transportObject]
        );
        $html = $transportObject->getHtml();
        return $html;
    }

    protected function _getHtml(
        \Magento\Framework\Data\Tree\Node $menuTree,
        $childrenWrapClass,
        $limit,
        array $colBrakes = []
    ) {
        $html = '';

        $children = $menuTree->getChildren();
        $parentLevel = $menuTree->getLevel();
        $childLevel = $parentLevel === null ? 0 : $parentLevel + 1;
        //$menu_display_icons = $this->helper('Oc\Theme\Helper\Data')->getConfig('header_oc/main_menu/menu_display_icons');
        $counter = 1;
        $itemPosition = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

        /** @var \Magento\Framework\Data\Tree\Node $child */
        foreach ($children as $child) {
            if ($childLevel === 0 && $child->getData('is_parent_active') === false) {
                continue;
            }
            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);
            $childId = substr($child->getId(), strrpos($child->getId(), '-' )+1)."\n";
            $blockIdMain = sprintf('cat_%d_menu', $childId);
            $blockIdMainHtml = $this->getLayout()->createBlock('Magento\Cms\Block\Block')->setBlockId($blockIdMain)->toHtml();
            $isParent = "";
            $isRelative = "";
            if($blockIdMainHtml || $child->hasChildren())
                $isParent = "isparent = 'isparent'";
            if(!$blockIdMainHtml && $child->hasChildren())
                $isRelative = "relative = 'relative'";
            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();
            if ($childLevel == 0 && $outermostClass) {
                $outermostClassCode = ' class="' . $outermostClass . '" ';
                $currentClass = $child->getClass();

                if (empty($currentClass)) {
                    $child->setClass($outermostClass);
                } else {
                    $child->setClass($currentClass . ' ' . $outermostClass);
                }
            }

            if (is_array($colBrakes) && count($colBrakes) && $colBrakes[$counter]['colbrake']) {
                $html .= '</ul></li><li class="column"><ul>';
            }

            $html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . $isParent . $isRelative .'>';
            $html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode .'><span>' . $this->escapeHtml(
                    $child->getName()
                ) . '</span></a>' . $this->_addSubMenu(
                    $child,
                    $childLevel,
                    $childrenWrapClass,
                    $limit
                ) . '</li>';
            $itemPosition++;
            $counter++;
        }

        if (is_array($colBrakes) && count($colBrakes) && $limit) {
            $html = '<li class="column"><ul>' . $html . '</ul></li>';
        }

        return $html;
    }

    /**
     * Add sub menu HTML code for current menu item
     *
     * @param \Magento\Framework\Data\Tree\Node $child
     * @param string $childLevel
     * @param string $childrenWrapClass
     * @param int $limit
     * @return string HTML code
     */
    protected function _addSubMenu($child, $childLevel, $childrenWrapClass, $limit)
    {
        $html = '';
        $childId = substr($child->getId(), strrpos($child->getId(), '-' )+1)."\n";
        $blockIdMain = sprintf('cat_%d_menu', $childId);
        $blockIdMainHtml = $this->getLayout()->createBlock('Magento\Cms\Block\Block')->setBlockId($blockIdMain)->toHtml();
        if (!$child->hasChildren() && !$blockIdMainHtml) {
            return $html;
        }
        $blockIdRight = sprintf('cat_%d_banner', $childId);
        $blockIdRightHtml = $this->getLayout()->createBlock('Magento\Cms\Block\Block')->setBlockId($blockIdRight)->toHtml();
        $blockAdditional = $this->getLayout()->createBlock('Magento\Cms\Block\Block')->setBlockId('menu_bottom_links')->toHtml();
        $colStops = [];
        if ($childLevel == 0 && $limit) {
            $colStops = $this->_columnBrake($child->getChildren(), $limit);
        }
        $additionalClass = '';
        if($blockIdRightHtml){
            $additionalClass .= 'with-banner';
        }
        $html .= '<ul class="column-right">';
        $html .= '<li class="ui-menu-item all-category-theme"><a href="'.$child->getUrl().'" class="show-all">'.__('לצפייה בכל המוצרים').' ></a></li>';
        if($blockIdMainHtml){
            $html .= '<ul class="sub-menu">';
            $html .= $blockIdMainHtml;
            $html .= '</ul>';
        }else{
            $html .= '<ul class="sub-menu">';
            $html .= $this->_getHtml($child, $childrenWrapClass, $limit, $colStops);
            $html .= '</ul>';
        }
        $html .= '<ul class="sub-menu bottom-links">';
        $html .= $blockAdditional;
        $html .= '</ul>';
        if($blockIdRightHtml){
            $html .= '<li class="banner-nav">';
            $html .= $blockIdRightHtml;
            $html .= '</li>';
        }
        $html .= '</ul>';

        return $html;
    }
}
