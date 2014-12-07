<?php

namespace SQRT\Tag;

use SQRT\Tag;

class Form extends Tag
{
  function __construct($action = null, $value = null, $method = 'POST', $attr = null)
  {
    $this->tag = 'form';

    $this->setAttr($attr);
    $this->setValue($value);
    $this->setAction($action);
    $this->setMethod($method);
  }

  public function setEnctype($enctype)
  {
    return $this->set('enctype', $enctype);
  }

  public function getEnctype()
  {
    return $this->get('enctype');
  }

  public function setAction($action)
  {
    return $this->set('action', $action);
  }

  public function getAction()
  {
    return $this->get('action');
  }

  public function setMethod($method)
  {
    return $this->set('method', $method);
  }

  public function getMethod()
  {
    return $this->get('method');
  }
}