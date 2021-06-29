### Тригонометрическая форма комплексного числа

Метод `polarForm` преобразовывает параметры конструктора `ComplexCalculator` 
из алгебраической формы в тригонометрическую.

```php
$c = new ComplexCalculator(5, 2);
$c = $c->polarForm();
```

Результат:

```php
object(Candidate\Calculator\ComplexCalculator)#594 (2) {
  ["real"]=>
  float(49.9)
  ["imaginary"]=>
  float(25.42)
}
```