<?php

namespace Magenest\Staff\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Type extends Column
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$items) {
                // $items['instock'] is column value
                if ($items['type'] == 1) {
                    $items['type'] = 'lv1';
                }elseif ($items['type'] == 2){
                    $items['type'] = 'lv2';
                }else $items['type'] = 'others';
            }
        }
        return $dataSource;
    }
}