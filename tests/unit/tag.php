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

  function testForm()
  {
    $t = new Tag\Form('/hello/', '<p>Form Contents</p>');
    $t->setEnctype('multipart/form-data');

    $exp = '<form action="/hello/" enctype="multipart/form-data" method="POST"><p>Form Contents</p></form>';
    $this->assertEquals($exp, $t->toHTML(), 'Форма');
  }

  function testInput()
  {
    $t = new Tag\Input('one');
    $this->assertEquals('<input name="one" type="text" />', $t->toHTML(), 'Пустой тег INPUT');

    $t = new Tag\Input('two', 123, 'one', 'email');
    $this->assertEquals('<input class="one" name="two" type="email" value="123" />', $t->toHTML(), 'Указаны свойства');

    $t = new Tag\Input('one', 'Ололо """');
    $this->assertEquals('<input name="one" type="text" value="Ололо &quot;&quot;&quot;" />', $t->toHTML(), 'Экранирование символов');
  }

  function testTextarea()
  {
    $t   = new Tag\Textarea('text', 'Привет, <a href="#">мир</a>!', 'editor');
    $exp = '<textarea class="editor" name="text">Привет, &lt;a href=&quot;#&quot;&gt;мир&lt;/a&gt;!</textarea>';
    $this->assertEquals($exp, $t->toHTML(), 'Содержимое тега экранируется');
  }

  function testRadio()
  {
    $t = new Tag\Radio('one', 'two');
    $t->setSelected(true);

    $this->assertEquals('<input checked="checked" name="one" type="radio" value="two" />', $t->toHTML(), 'input[type=radio]');
    $this->assertEquals('two', $t->getDisplayValue(), 'Значение для отображения');
    $this->assertEquals('two', $t->getValue(), 'Значение для инпута');

    $t = new Tag\Radio('one', 'two', 'three', true);
    $this->assertEquals(
      '<input checked="checked" name="one" type="radio" value="two" />',
      $t->toHTML(),
      'input[type=radio]'
    );
    $this->assertEquals('three', $t->getDisplayValue(), 'Значение для отображения');
    $this->assertEquals('two', $t->getValue(), 'Значение для инпута');
  }

  function testRadioListing()
  {
    $t   = new Tag\RadioListing('dinner', array(12 => 'Рано', 14 => 'Нормально', 16 => 'Поздно'), 14);
    $exp = '<label><input name="dinner" type="radio" value="12" /> Рано</label>' . "\n"
      . '<label><input checked="checked" name="dinner" type="radio" value="14" /> Нормально</label>' . "\n"
      . '<label><input name="dinner" type="radio" value="16" /> Поздно</label>' . "\n";
    $this->assertEquals($exp, $t->toHTML(), 'Рендер списка опций');
  }

  function testCheckboxListing()
  {
    $t = new Tag\CheckboxListing('age', array(10 => '10 лет', 20 => '20 лет', 30 => '30 лет'), 20);

    $exp = '<label><input name="age" type="checkbox" value="10" /> 10 лет</label>' . "\n"
      . '<label><input checked="checked" name="age" type="checkbox" value="20" /> 20 лет</label>' . "\n"
      . '<label><input name="age" type="checkbox" value="30" /> 30 лет</label>' . "\n";
    $this->assertEquals($exp, $t->toHTML(), 'Выбрана одна опция');

    $t->setSelected(array(10, 20));

    $exp = '<label><input checked="checked" name="age" type="checkbox" value="10" /> 10 лет</label>' . "\n"
      . '<label><input checked="checked" name="age" type="checkbox" value="20" /> 20 лет</label>' . "\n"
      . '<label><input name="age" type="checkbox" value="30" /> 30 лет</label>' . "\n";
    $this->assertEquals($exp, $t->toHTML(), 'Выбрано несколько опций');
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

  function testOption()
  {
    $t = new Tag\Option('One');
    $this->assertEquals('<option>One</option>', $t->toHTML(), 'Значение');

    $t = new Tag\Option('Choose', false, true);
    $this->assertEquals('<option selected="selected" value="">Choose</option>', $t->toHTML(), 'Заголовок без значения');

    $t = new Tag\Option('Two', 2);
    $this->assertEquals('<option value="2">Two</option>', $t->toHTML(), 'Заголовок и значение');

    $t->setSelected(true);
    $this->assertEquals('<option selected="selected" value="2">Two</option>', $t->toHTML(), 'Выбранный пункт');
  }

  function testSelect()
  {
    $t = new Tag\Select('type', array(1 => 'one', 2 => 'two'), 2, 'one');
    $exp = '<select class="one" name="type">'
      . '<option value="1">one</option>' . "\n"
      . '<option selected="selected" value="2">two</option>' . "\n"
      . '</select>';

    $this->assertEquals($exp, $t->toHTML(), 'Стандартный рендер');

    $t->setIgnoreOptionsKeys(true);
    $t->setSelected('one');

    $exp = '<select class="one" name="type">'
      . '<option selected="selected" value="one">one</option>' . "\n"
      . '<option value="two">two</option>' . "\n"
      . '</select>';
    $this->assertEquals($exp, $t->toHTML(), 'Стандартный рендер');
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