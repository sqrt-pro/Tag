<?php

require_once __DIR__ . '/../init.php';

use SQRT\Tag;

class tagTest extends PHPUnit_Framework_TestCase
{
  function testStyle()
  {
    $st = array('width' => '15px;', 'height' => '200px');

    $style = 'width: 15px; height: 200px;';
    $tag   = '<b style="width: 15px; height: 200px;">hello</b>';

    $t1 = new Tag('b', 'hello', array('style' => $st));
    $this->assertEquals($style, $t1->getStyle(), 'Стили #1 через геттер доступны в виде строки');
    $this->assertEquals($tag, $t1->toHTML(), 'Стили #1 заданы через конструктор');

    $t2 = new Tag('b', 'hello');
    $t2->setStyle($st);
    $this->assertEquals($style, $t2->getStyle(), 'Стили #2 через геттер доступны в виде строки');
    $this->assertEquals($tag, $t2->toHTML(), 'Стили #2 заданы через сеттер');

    $t3 = new Tag('b', 'hello');
    $t3->setStyle(array('width: 15px', 'height: 200px;'));
    $this->assertEquals($style, $t3->getStyle(), 'Стили #3 через геттер доступны в виде строки');
    $this->assertEquals($tag, $t3->toHTML(), 'Стили #3 заданы через сеттер в виде массива без ключей');
  }

  function testSetAttr()
  {
    $t = new Tag('b', 'hello', 'one');
    $this->assertEquals('<b class="one">hello</b>', $t->toHTML(), 'Установлен class');

    $t->setAttr(false);

    $this->assertEquals('<b>hello</b>', $t->toHTML(), 'Атрибуты стерты');

    $t->setAttr(array('style' => 'width: 100px;'));
    $this->assertEquals('<b style="width: 100px;">hello</b>', $t->toHTML(), 'Установлен style');

    $t->setAttr('two');
    $this->assertEquals('<b class="two">hello</b>', $t->toHTML(), 'Установлен class=two');

    $t = new Tag('input', '123', array('type' => 'text'), true);
    $t->setId('one');
    $t->setClass('two');
    $t->setName('one[two]');
    $t->setStyle('width: 100px;');

    $this->assertEquals(
      '<input class="two" id="one" name="one[two]" style="width: 100px;" type="text" value="123" />',
      $t->toHTML(),
      'Типовые атрибуты заданы через сеттеры'
    );
  }

  function testToString()
  {
    $t = new Tag('b');

    $this->assertEquals($t->toHTML(), (string)$t, 'Приведение к строке');
  }

  /**
   * @dataProvider dataTag
   */
  function testTag($exp, $tag, $value, $attr = null, $short = null)
  {
    $t = new Tag($tag, $value, $attr, $short);

    $this->assertEquals($exp, $t->toHTML());
  }

  function dataTag()
  {
    return array(
      array('<b>Hello</b>', 'b', 'Hello'),
      array('<b class="one">Hello</b>', 'B', 'Hello', 'one'),
      array('<b class="two" id="one">Hello</b>', 'b', 'Hello', array('class' => 'two', 'id' => 'one')),
      array('<br />', 'br', null, null, true),
      array('<input type="input" value="" />', 'input', '', array('type' => 'input'), true),
      array('<input type="input" value="Hello" />', 'input', 'Hello', array('type' => 'input'), true),
    );
  }

  function testA()
  {
    $t = new Tag\A('#');
    $this->assertEquals('<a href="#"></a>', $t->toHTML(), 'Пустой тег A');

    $t = new Tag\A('/one/', 'Hello', 'two', '_blank');
    $this->assertEquals('<a class="two" href="/one/" target="_blank">Hello</a>', $t->toHTML(), 'Указаны свойства');
  }

  function testInput()
  {
    $t = new Tag\Input('one');
    $this->assertEquals('<input name="one" type="text" />', $t->toHTML(), 'Пустой тег INPUT');

    $t = new Tag\Input('two', 123, 'one', 'email');
    $this->assertEquals('<input class="one" name="two" type="email" value="123" />', $t->toHTML(), 'Указаны свойства');
  }

  function testImg()
  {
    $t = new Tag\Img('ololo.jpg');
    $this->assertEquals('<img alt="" src="ololo.jpg" />', $t->toHTML(), 'Пустой тег Img');

    $t = new Tag\Img('ololo.jpg', 100, 50, 'Ололо', 'one');
    $this->assertEquals(
      '<img alt="Ололо" class="one" height="50" src="ololo.jpg" width="100" />',
      $t->toHTML(),
      'Указаны свойства'
    );
  }

  function testMergeAttr()
  {
    $res = Tag::MergeAttr('one', 'two');
    $exp = array('class' => 'one two');
    $this->assertEquals($exp, $res, 'Вариант 1');

    $res = Tag::MergeAttr('one', array('id' => 'two'));
    $exp = array('class' => 'one', 'id' => 'two');
    $this->assertEquals($exp, $res, 'Вариант 2');

    $res = Tag::MergeAttr(array('style' => 'border: red;'), array('class' => 'red', 'style' => 'color: green;'));
    $exp = array('style' => 'border: red; color: green;', 'class' => 'red');
    $this->assertEquals($exp, $res, 'Вариант 3');

    $res = Tag::MergeAttr(array('style' => array('width' => '15px;', 'height' => '200px')), 'red');
    $exp = array('style' => 'width: 15px; height: 200px;', 'class' => 'red');
    $this->assertEquals($exp, $res, 'Вариант 4');
  }
}