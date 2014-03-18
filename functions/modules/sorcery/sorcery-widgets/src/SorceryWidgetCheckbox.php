<?php

/**
 * Checkbox widget for Sorcery Widgets
 * 
 * @package Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class SorceryWidgetCheckbox extends SorceryWidgetRadio
{
    protected $template = 'sorcery-widgets:labeled-input';

    protected function prepareData()
    {
        parent::prepareData();
        $this->data['attributes']['type'] = 'checkbox';
        $this->data['container_attributes']['class'][] = 'checkbox';

        $key = array_search('radio', $this->data['container_attributes']['class']);
        if ($key !== false) {
            unset($this->data['container_attributes']['class'][$key]);
        }
    }
}
