# Quip
A query string parser for PHP

### Touch & Go Example

Say you have the following query:

`q=age<19,gender=male&embeds=bags.offers&includes=age,gender&excludes=whatever&sort=%2bupdated_at,-count`

That's quite a doozy! Quip makes parsing this type of query painfully simple:

```
$query = 'q=age<19,gender=male&embeds=snags.offers&includes=age,gender&excludes=whatever&sort=%2bupdated_at,-count'

$quip = (new Quip($query))->parse();

$quip->getIncludes();
// ['age', 'gender']

$quip->getExcludes();
// ['whatever']

$quip->getSorts();
// Array of sort objects, with type (ascending/descending) and field to sort on 

$quip->getEmbeds();
// Array of EmbedChain objects, which house sorted arrays of parsed `x.y` strings

$quip->getExpressions();
// Returns expressions (left-hand-side, right-hand-side and operator) from the `q` parameter
```

This is still a major work in progress, but I hope it will be useful!