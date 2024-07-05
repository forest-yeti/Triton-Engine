# Triton Engine
Данное решение реализуют базовую игру в покер (В частном случае Техасский холдем)

# Быстрый старт
Для начала необходимо создать колодку и перемешать её
```php
$gameCardsDeck = (new GameCardDeckFactory())->factoryClassicDeck()
$gameCardsDeck->shuffle();
```
После чего мы можем начать игру, мы можем раздать карманные карты и карты на столе таким образом:
```php
$pockerCards = [
    $gameCardsDeck->pop(),
    $gameCardsDeck->pop(),
];

$boardCards = [
    $gameCardsDeck->pop(),
    $gameCardsDeck->pop(),
    $gameCardsDeck->pop(),
    $gameCardsDeck->pop(),
    $gameCardsDeck->pop(),
];
```
После чего можем найти самую сильную комбинацию с помощью GameResolver
```php
$gameResolver = new GameResolver();
$resolverResut = $gameResolver->resolve($pockerCards, $boardCards);
```
Данный класс содержит в себе метод для получению приоритета комбинации - это число от 1 до 10 (Где 1 - это старшая карта, 10 - это роял). Также мы можем получить название комбинации
```php
echo $resolverResut->getCombinationName();
echo $resolverResut->getPriority();
```
А также получить кикер с помощью метода getKicker
```php
$resolverResult->getKicker()
```
В некоторых случаях он может быть null, например в случае построения комбинации роял (В данной комбинации кикер всегда туз)

# Тестирование
Вы можете запустить тесты следующим образом
```
vendor\bin\phpunit tests
```
