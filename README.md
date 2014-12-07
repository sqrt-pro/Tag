SQRT\Tag
========

Класс `Tag` позволяет генерировать HTML-теги и задавать атрибуты к ним. Кроме непосредственно класса `Tag` имеется набор
классов-наследников, для быстрого создания основных часто используемых тегов `<a>`, `<img>`, `<input>`.

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

Полный набор примеров находится в тестах.

### Объединение атрибутов

Предусмотрен метод `Tag::MergeAttr($attr, $_ = null)`, позволяющий объединять несколько групп атрибутов в одну.
Массивы объединяются по ключам, значения разделяются пробелами.

    Tag::MergeAttr('one', array('id' => 'two')); // array('class' => 'one', 'id' => 'two');
    
    Tag::MergeAttr('one', 'two'); // array('class' => 'one two');
    
    Tag::MergeAttr(array('style' => 'border: red;'), array('class' => 'red', 'style' => 'color: green;'));
    // array('style' => 'border: red; color: green;', 'class' => 'red');