<?php

namespace SQRT\Tag;

use SQRT\Tag;

class Option extends Tag
{
  function __construct($value, $real_value = null, $selected = null)
  {
    $this->tag = 'option';
    $this->setValue($value);

    if (!is_null($real_value)) {
      $this->setRealValue($real_value);
    }

    if ($selected) {
      $this->setSelected($selected);
    }
  }

  protected function preProcessAttr($attr)
  {
    if ($this->getSelected()) {
      $attr['selected'] = 'selected';
    }

    return $attr;
  }

  /** Значение в атрибуте value */
  public function getRealValue()
  {
    return $this->get('value');
  }

  /** Значение в атрибуте value */
  public function setRealValue($real_value)
  {
    return $this->set('value', $real_value);
  }
}