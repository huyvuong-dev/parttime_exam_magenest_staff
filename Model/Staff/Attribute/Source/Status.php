<?php
namespace Magenest\Staff\Model\Staff\Attribute\Source;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Retrieve options array.
     *
     * @return array
     */
    public function toOptionArray($addEmpty = true)
    {
        $result = [];
        if ($addEmpty) {
            $result[] = ['label' => __('-- Please Select a Status --'), 'value' => ''];
        }
        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    /**
     * Retrieve option array
     *
     * @return string[]
     */
    public static function getOptionArray()
    {
        return [1 => __('Pending'),
            2 => __('Approved')
        ];
    }

    /**
     * Retrieve option array with empty value
     *
     * @return string[]
     */
    public function getAllOptions()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    /**
     * Retrieve option text by option value
     *
     * @param string $optionId
     * @return string
     */
    public function getOptionText($optionId)
    {
        $options = self::getOptionArray();

        return isset($options[$optionId]) ? $options[$optionId] : null;
    }
}