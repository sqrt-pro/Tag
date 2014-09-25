<?php

namespace SQRT\Tag;

use SQRT\Tag;

class Img extends Tag
{
  function __construct($src, $width = null, $height = null, $alt = null, $attr = null)
  {
    $this->tag   = 'img';
    $this->short = true;
    $this->setAttr($attr);
    $this->setSrc($src);
    $this->setAlt($alt);
    if ($width) {
      $this->setWidth($width);
    }
    if ($height) {
      $this->setHeight($height);
    }
  }

  public function setSrc($src)
  {
    return $this->set('src', $src);
  }

  public function getSrc()
  {
    return $this->get('src');
  }

  public function setWidth($width)
  {
    return $this->set('width', $width);
  }

  public function getWidth()
  {
    return $this->get('width');
  }

  public function setHeight($height)
  {
    return $this->set('height', $height);
  }

  public function getHeight()
  {
    return $this->get('height');
  }

  public function setAlt($alt)
  {
    return $this->set('alt', $alt);
  }

  public function getAlt()
  {
    return $this->get('alt');
  }
}