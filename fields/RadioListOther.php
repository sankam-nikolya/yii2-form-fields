<?php

namespace fgh151\fields\fields;

use yii\web\View;

class RadioListOther extends BaseField
{
    public $variants;
    public $htmlType = 'radio';
    public $otherText = 'other';

    private $_radioId;
    private $_textId;

    /**
     * Initialize ids
     */
    public function init()
    {
        $this->_radioId = $this->id.'-other';
        $this->_textId = $this->_radioId.'-text';
        parent::init();
    }

    /**
     * Render elements
     */
    public function render()
    {

        foreach ($this->variants as $variant) {
            echo BaseField::create('BinaryRadio', [
                'label' => $variant['label'],
                'value' => $variant['value'],
                'name' => $this->name,
                'id' => $this->options['id'].'-'.time()
            ])->render();
        }

        $otherCheckbox = BaseField::create('BinaryRadio', [
            'label' => $this->otherText,
            'value' => false,
            'name' => $this->name,
            'id' => $this->_radioId
        ]);
        echo $otherCheckbox->render();

        $otherText = BaseField::create('text', [
            'label' => $this->otherText,
            'value' => $this->otherText,
            'name' => $this->name,
            'id' => $this->_textId,
            'style' => 'display: none;'
        ]);
        echo $otherText->render();
    }

    /**
     * Register js handlers
     * @param View $view
     */
    public function registerAssets($view)
    {
        $view->registerJs(
            '$("#'.$this->_radioId.'").click(function(){$("#'.$this->_textId.'").parent().toggle()})'
        );
        parent::registerAssets($view);
    }
}