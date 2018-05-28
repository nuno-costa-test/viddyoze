Viddyoze Acme Widget Co test
============================

TL; DR
===========
* run ```script/test``` for unit tests
* check ```test/integration/ResultsTest.php``` to see how to instantiate and run
the code


Assumptions
===========
I'm assuming the test will be assessed on a Unix type of system, like Linux or
OSX as such all the utilitarian scripts are based on that Assumptions but the
tests and application can be executed on any environment that supports PHP.

As a rule, I employ gihub's [STRTA](https://github.com/github/scripts-to-rule-them-all)
pattern and provided a set of universal scripts so that any developer familiar
with the pattern can "hit the ground running".

For simplicity all test reports are printed on screen instead of report files
and no code coverage report is generated


Design decisions
================
Regarding the Rules types I've opted for a simple model, consideration was given
to having rules that apply to the cart items and Rules that apply to cart total price.

I've opted out for the simple model, where we have a single rule type that applies
to all items in chart, the drawback is that shipping cost rules will have to
compute the total themselves.

I had the iterative approach in mind while deciding and tried build the simplest
possible model to achieve the end goal.

I believe this to be acceptable as a shopping cart will have a low amount of
iterations, so the performance impact will be negligible, furthermore the system
 is structured enough to easily accommodate different rule types that will act
 on different elements of the cart, if the need arises new rule types can be
 introduced easily.


Run it
=================
_As usual unit tests provide the best form of interface documentation. The file ```test\integration\ResultsTest``` provides a good example of how to instantiate
 and execute the different elements of the codebase._

To compute a price the code expects 3 things:
1. Catalogue of products.
2. List of price modifiers rules.
3. A list of products to be bought.

As such before being able to compute a total price the products catalogue must
be present.


```php
use AcmeWidget\Cart;
use AcmeWidget\Product\Widget;

$cart = new Cart();

$cart->addCatalogItem(new Widget('Red Widget', 'R01', 3295));
$cart->addCatalogItem(new Widget('Green Widget', 'G01', 2495));
$cart->addCatalogItem(new Widget('Blue Widget', 'B01', 795));
```

After having the catalogue are going to add some Promotions

```php
use AcmeWidget\Rules\Product\NthItemDiscount;
use AcmeWidget\Product\GenericProduct;

$halfPriceOnSecondItem = new NthItemDiscount('2 half price', '50OFF', GenericProduct::class);
$halfPriceOnSecondItem->setItemQuantity(2);
$halfPriceOnSecondItem->setDiscount(.5);
$halfPriceOnSecondItem->setProduct($cart->getProduct('R01'));

$cart->addRule($halfPriceOnSecondItem);

```

Rules are somewhat special as they will allow us to define the business logic.
To provide accountability the final price is not increased/reduced automatically.
Instead, if a rule applies to a specific chart then the rule will return a new
product.

For example a shipping rule will not increase the price automatically, it will
return a "shipping product entry" that will be used to compute the total price.

Because they define business logic, some Rule Executors/Iterators implement
simple logic, like for example only one rule of the set will apply. This is used
for computing the shipping costs.

Finally, it is time to compute the total price

```php
$cart->addToCart('B01');
$cart->addToCart('B01');
$cart->addToCart('R01');
$cart->addToCart('R01');
$cart->addToCart('R01');

$result = $cart->computeTotal();
```

Tests
==========
For convenience this test is bundled in a docker container.
Unit tests can be executed by running ```script/test``` from the command line.

This will run linting tests as well as unit tests.

The file ```test/integration/ResultsTest.php``` implements tests to assert the
expected results mentioned in the test.

If not making use of STRTA scripts, then running ```./vendor/bin/phpunit  -c ./test/phpunit.xml ./test``` from the project root should do the trick.
