<?php

namespace Quip\Tests;

use PHPUnit_Framework_TestCase;
use Quip\Entities\Sort;
use Quip\Expressions\Expression;
use Quip\Quip;

class QuipTest extends PHPUnit_Framework_TestCase
{
    public function testParseRaw()
    {
        $query = 'q=age<19,gender=male&embeds=snags.offers&includes=age,gender&excludes=whatever&sort=%2bupdated_at,-count';

        $quip = (new Quip($query))->parse();

        // Check that embeds were parsed properly

        $embeds = $quip->getEmbeds();
        $embedChain = $embeds[0]->getChain();

        $this->assertEquals(['snags', 'offers'], $embedChain);

        /** @var Sort[] $sorts */
        $sorts = $quip->getSorts();

        $primarySort = $sorts[0];
        $secondarySort = $sorts[1];

        $this->assertEquals(Sort::TYPE_ASC, $primarySort->getType());
        $this->assertEquals(Sort::TYPE_DESC, $secondarySort->getType());

        $this->assertEquals('updated_at', $primarySort->getField());
        $this->assertEquals('count', $secondarySort->getField());


        /** @var Expression[] $expressions */
        $expressions = $quip->getExpressions();

        $ageExpression = $expressions[0];
        $genderExpression = $expressions[1];

        $this->assertEquals(Expression::OPERATOR_LT, $ageExpression->getOperator());
        $this->assertEquals(Expression::OPERATOR_EQ, $genderExpression->getOperator());

        $this->assertEquals('age', $ageExpression->getLhs());
        $this->assertEquals('gender', $genderExpression->getLhs());

        $this->assertEquals('19', $ageExpression->getRhs());
        $this->assertEquals('male', $genderExpression->getRhs());

        $includes = $quip->getIncludes();

        $this->assertEquals(['age', 'gender'], $includes);

        $excludes = $quip->getExcludes();

        $this->assertEquals(['whatever'], $excludes);
    }
}
