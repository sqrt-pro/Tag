<?php

namespace SQRT;

class Tag
{
  protected $tag;
  protected $attr;
  protected $short;
  protected $value;

  function __construct($tag, $value = null, $attr = null, $short = null)
  {
    $this->tag   = $tag;
    $this->value = $value;
    $this->short = $short;

    $this->setAttr($attr);
  }

  function __toString()
  {
    return $this->toHTML();
  }

  public function toHTML()
  {
    $tag = strtolower($this->tag);

    if ($this->short) {
      if (!is_null($this->value)) {
        $this->set('value', $this->value);
      }

      return '<' . $tag . $this->processAttr() . ' />';
    } else {
      return '<' . $tag . $this->processAttr() . '>' . $this->getValue() . '</' . $tag . '>';
    }
  }

  /** Содержимое тега */
  public function getValue()
  {
    return $this->value;
  }

  /** Содержимое тега */
  public function setValue($value)
  {
    $this->value = $value;

    return $this;
  }

  /** Установка значения атрибута */
  public function set($key, $value)
  {
    $this->attr[$key] = $value;

    return $this;
  }

  /** Получение значения атрибута */
  public function get($key)
  {
    return isset($this->attr[$key]) ? $this->attr[$key] : false;
  }

  public function setId($id)
  {
    return $this->set('id', $id);
  }

  public function getId()
  {
    return $this->get('id');
  }

  public function setClass($class)
  {
    return $this->set('class', $class);
  }

  public function getClass()
  {
    return $this->get('class');
  }

  public function setStyle($style)
  {
    return $this->set('style', $style);
  }

  public function getStyle()
  {
    return static::ProcessStyle($this->get('style'));
  }

  public function setName($name)
  {
    return $this->set('name', $name);
  }

  public function getName()
  {
    return $this->get('name');
  }

  public function setAttr($attr)
  {
    $this->attr = null;

    if (is_array($attr)) {
      $this->attr = $attr;
    } elseif (!empty($attr)) {
      $this->set('class', $attr);
    }

    return $this;
  }

  /** Объединение нескольких атрибутов */
  public static function MergeAttr($attr, $_ = null)
  {
    $out = false;
    $arr = func_get_args();
    foreach ($arr as $v) {
      if (is_string($v)) {
        $v = array('class' => $v);
      }

      if (is_array($v)) {
        foreach ($v as $key => $val) {
          if ($key == 'style') {
            $val = static::ProcessStyle($val);
          }

          $val_arr = array();
          if (isset($out[$key])) {
            $val_arr[] = $out[$key];
          }
          $val_arr[] = $val;

          $out[$key] = join(' ', $val_arr);
        }
      }
    }

    return $out;
  }

  protected static function ProcessStyle($style)
  {
    if (is_array($style)) {
      $style_arr = array();
      foreach ($style as $k => $v) {
        if (is_numeric($k)) {
          $style_arr[] = trim($v, ';') . ';';
        } else {
          $style_arr[] = $k . ': ' . trim($v, ';') . ';';
        }
      }

      $style = join(' ', $style_arr);
    }

    return $style;
  }

  protected function processAttr()
  {
    if (!$this->attr) {
      return false;
    }

    ksort($this->attr);

    $str = '';
    foreach ($this->attr as $key => $val) {
      if ($key == 'style') {
        $val = $this->getStyle();
      }

      $str .= ' ' . $key . '="' . $val . '"';
    }

    return $str;
  }
}