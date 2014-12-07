<?php

namespace SQRT\Tag;

use SQRT\Tag;

class Checkbox extends Tag
{
  protected $display_value;
  protected $is_array_value;

  function __construct($name, $value, $display_value = null, $selected = null)
  {
    $this->tag   = 'input';
    $this->short = true;

    $this->setName($name);
    $this->setValue($value);
    $this->display_value = $display_value;
    if ($selected) {
      $this->setSelected(true);
    }
    $this->set('type', 'checkbox');
  }

  protected function preProcessAttr($attr)
  {
    if ($this->getSelected()) {
      $attr['checked'] = 'checked';
    }

    if ($this->getIsArrayValue()) {
      $attr['name'] = $attr['name'] . '[]';
    }

    return $attr;
  }

  public function getDisplayValue()
  {
    return $this->display_value ?: $this->getValue();
  }

  public function setDisplayValue($display_value)
  {
    $this->display_value = $display_value;

    return $this;
  }

  /** Значение указывается в массиве */
  public function getIsArrayValue()
  {
    return $this->is_array_value;
  }

  /** Значение указывается в массиве */
  public function setIsArrayValue($is_array_value)
  {
    $this->is_array_value = $is_array_value;

    return $this;
  }
}