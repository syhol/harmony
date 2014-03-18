<?php

/**
 * Base class for Sorcery Widgets
 * 
 * @package Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class SorceryWidget
{
    protected $id;

    protected $template = false;

    protected $data = array();

    /**
     * Setup the widget
     * 
     * @param string    $id         name of widget
     * @param string    $value      value of widget
     * @param array     $data       widget data and config
     */
    public function __construct($id, $value, $data = array())
    {
        $this->id = $id;
        $this->data = $data;
        $this->data['value'] = (string)$value;
        $this->data['widget'] = $this;
    }

    /**
     * Get the widget id
     * 
     * @param string $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = (string)$id;
        return $this;
    }

    /**
     * Get the widget id
     * 
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the widget template
     * 
     * @param string $template
     * @return self
     */
    public function setTemplate($template)
    {
        $this->template = (string)$template;
        return $this;
    }

    /**
     * Get the widget template
     * 
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set the widget data
     * 
     * @param array $data
     * @return self
     */
    public function setData($data)
    {
        $this->data = (array)$data;
        return $this;
    }

    /**
     * Get the widget data
     * 
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the widget id
     * 
     * @return string
     */
    public function render()
    {
        $this->prePrepareData();
        $this->prepareData();
        $this->postPrepareData();
        if ($this->template) {
            render_template($this->template, $this->data);
        } else {
            throw new ErrorException('No template set for widget "' . get_class($this) . '"');
        }
    }

    /**
     * Pre Prepare the data for the template to render
     * 
     * @return void
     */
    protected function prePrepareData()
    {
        if ( 
            ! isset($this->data['attributes']) || 
            ! is_array($this->data['attributes'])
        ) {
            $this->data['attributes'] = array();
        }

        if ( 
            ! isset($this->data['attributes']['class']) || 
            ! is_array($this->data['attributes']['class'])
        ) {
            $this->data['attributes']['class'] = array();
        }
    }

    /**
     * Prepare the data for the template to render
     * 
     * @return void
     */
    protected function prepareData(){}

    /**
     * Post Prepare the data for the template to render
     * 
     * @return void
     */
    protected function postPrepareData()
    {
        $classes = $this->data['attributes']['class'];
        $this->data['attributes']['class'] = implode(' ', $classes);

        $attributes = array();
        foreach ($this->data['attributes'] as $key => $value) {
            $attributes[] = $key . '="' . $value . '"';
        }
        $this->data['attributes'] = implode(' ', $attributes);
    }
}
