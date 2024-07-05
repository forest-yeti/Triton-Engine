# Triton Engine
Данное решение реализуют базовую игру в покер (В частном случае Техасский холдем)

# Быстрый старт
Для начала необходимо создать колодку и перемешать её
```php
$gameCardsDeck = (new GameCardDeckFactory())->factoryClassicDeck()
$gameCardsDeck->shuffle();
```
После чего мы можем начать игру