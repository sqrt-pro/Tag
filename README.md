# Tag

[![Build Status](https://travis-ci.org/sqrt-pro/Tag.svg?branch=v.0.1.0)](https://travis-ci.org/sqrt-pro/Tag)
[![Coverage Status](https://coveralls.io/repos/sqrt-pro/Tag/badge.svg)](https://coveralls.io/r/sqrt-pro/Tag)
[![Latest Stable Version](https://poser.pugx.org/sqrt-pro/tag/version.svg)](https://packagist.org/packages/sqrt-pro/tag)
[![License](https://poser.pugx.org/sqrt-pro/tag/license.svg)](https://packagist.org/packages/sqrt-pro/tag)

Класс `Tag` позволяет генерировать HTML-теги и задавать атрибуты к ним. Кроме непосредственно класса `Tag` имеется набор
классов-наследников, для быстрого создания основных часто используемых тегов 
`<a>`, `<img>`, `<input>`, `<select>`, `<textarea>`, `<form>`.

~~~ php

use SQRT\Tag;

echo new Tag\A('#', 'hello');
// <a href="#">hello</a>

echo new Tag\A('/one/', 'Hello', 'two', '_blank'); 
// <a class="two" href="/one/" target="_blank">Hello</a>

echo new Tag('b', 'hello', array('style' => array('width' => '15px;', 'height' => '200px'))); 
// <b style="width: 15px; height: 200px;">hello</b>

echo new Tag\Input('two', 123, 'one', 'email');
// <input class="one" name="two" type="email" value="123" />

$t = new Tag('input', '123', array('type' => 'text'), true);
$t->setId('one');
$t->setClass('two');
$t->setName('one[two]');
$t->setStyle('width: 100px;');
echo $t->toHTML();
// <input class="two" id="one" name="one[two]" style="width: 100px;" type="text" value="123" />

~~~

Для генерации списков опций `input[type=checkbox]` и `input[type=radio]` предусмотрены классы `CheckboxListing` и `RadioListing`.

~~~ php

$t = new Tag\CheckboxListing('age', array(10 => '10 лет', 20 => '20 лет', 30 => '30 лет'));
$t->setSelected(array(10, 20));

// <label><input checked="checked" name="age" type="checkbox" value="10" /> 10 лет</label>
// <label><input checked="checked" name="age" type="checkbox" value="20" /> 20 лет</label>
// <label><input name="age" type="checkbox" value="30" /> 30 лет</label>

~~~ 

Полный набор примеров находится в тестах.

## Объединение атрибутов

Предусмотрен метод `Tag::MergeAttr($attr, $_ = null)`, позволяющий объединять несколько групп атрибутов в одну.
Массивы объединяются по ключам, значения разделяются пробелами.

~~~ php

Tag::MergeAttr('one', array('id' => 'two')); // array('class' => 'one', 'id' => 'two');

Tag::MergeAttr('one', 'two'); // array('class' => 'one two');

Tag::MergeAttr(array('style' => 'border: red;'), array('class' => 'red', 'style' => 'color: green;'));
// array('style' => 'border: red; color: green;', 'class' => 'red');

~~~