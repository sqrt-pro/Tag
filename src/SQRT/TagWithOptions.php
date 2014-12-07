<?php

namespace SQRT;

abstract class TagWithOptions extends Tag
{
  protected $options;
  protected $ignore_options_keys;
  protected $options_tmpl = "%s\n";

  function __construct($tag, array $options, $selected = null, $attr = null)
  {
    $this->tag      = $tag;
    $this->options  = $options;
    $this->selected = $selected;

    $this->setAttr($attr);
  }

  /** @return Tag[] */
  public function getOptionsTags()
  {
    $out = array();

    foreach ($this->getOptions() as $key => $val) {
      $real_value = $this->getIgnoreOptionsKeys() ? $val : $key;
      $out[] = $this->makeOptionTag($val, $real_value);
    }

    return $out;
  }

  public function getValue()
  {
    $out = false;
    $arr = $this->getOptionsTags();
    foreach ($arr as $t) {
      $out .= $this->renderOptionsTmpl($t);
    }

    return $out;
  }

  /** Список опций */
  public function getOptions()
  {
    return $this->options;
  }

  /** Список опций */
  public function setOptions($options)
  {
    $this->options = $options;

    return $this;
  }

  /** Использовать только значения в списке опций */
  public function getIgnoreOptionsKeys()
  {
    return (bool)$this->ignore_options_keys;
  }

  /** Использовать только значения в списке опций */
  public function setIgnoreOptionsKeys($ignore_options_keys)
  {
    $this->ignore_options_keys = $ignore_options_keys;

    return $this;
  }

  /** SPRINTF шаблон для отображения опций */
  public function getOptionsTmpl()
  {
    return $this->options_tmpl;
  }

  /** SPRINTF шаблон для отображения опций, передается рендер поля и значение */
  public function setOptionsTmpl($options_tmpl)
  {
    $this->options_tmpl = $options_tmpl;

    return $this;
  }

  /** Рендер шаблона для опции */
  protected function renderOptionsTmpl(Tag $tag)
  {
    return sprintf($this->getOptionsTmpl(), $tag->toHTML());
  }

  /** Создание тега для вложенных опций */
  abstract protected function makeOptionTag($value, $real_value);
}