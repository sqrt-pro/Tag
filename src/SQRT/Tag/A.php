<?php

namespace SQRT\Tag;

use SQRT\Tag;

class A extends Tag
{
  function __construct($href, $value = null, $attr = null, $target = null)
  {
    $this->tag = 'a';
    $this->setValue($value);
    $this->setAttr($attr);
    $this->setHref($href);
    if ($target) {
      $this->setTarget($target);
    }
  }

  public function setHref($href)
  {
    return $this->set('href', $href);
  }

  public function getHref()
  {
    return $this->get('href');
  }

  public function setTarget($target)
  {
    return $this->set('target', $target);
  }

  public function getTarget()
  {
    return $this->get('target');
  }
}