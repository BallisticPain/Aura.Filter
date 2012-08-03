<?php
namespace Aura\Filter\Rule;

abstract class AbstractRuleTest extends \PHPUnit_Framework_TestCase
{
    protected $expect_message;
    
    protected function newRule($data, $field)
    {
        $class = substr(get_class($this), 0, -4);
        $rule = new $class();
        $rule->prep((object) $data, $field);
        return $rule;
    }
    
    public function testGetMessage()
    {
        $rule = $this->newRule(['foo' => 'bar'], 'foo');
        $actual = $rule->getMessage();
        $this->assertSame($this->expect_message, $actual);
    }
    
    public function testGetAndSetValue()
    {
        $data = [
            'foo' => 'bar',
            'baz' => 'dib',
            'zim' => 'gir',
        ];
        
        // get the field
        $rule = $this->newRule($data, 'foo');
        $expect = 'bar';
        $actual = $rule->getValue();
        $this->assertSame($expect, $actual);
        
        // set the field
        $rule = $this->newRule($data, 'foo');
        $expect = 'doom';
        $rule->setValue($expect);
        $actual = $rule->getValue();
        $this->assertSame($expect, $actual);
        
        // get a nonexistent field
        $rule = $this->newRule($data, 'no_such_field');
        $actual = $rule->getValue();
        $this->assertNull($actual);
    }
    
    
    /**
     * @dataProvider providerIs
     */
    public function testIs($value)
    {
        $rule = $this->newRule(['field' => $value], 'field');
        $this->assertTrue($this->ruleIs($rule));
    }
    
    public function ruleIs($rule)
    {
        return $rule->is();
    }
    
    abstract public function providerIs();
    
    /**
     * @dataProvider providerIsNot
     */
    public function testIsNot($value)
    {
        $rule = $this->newRule(['field' => $value], 'field');
        $this->assertTrue($this->ruleIsNot($rule));
    }
    
    public function ruleIsNot($rule)
    {
        return $rule->isNot();
    }
    
    abstract public function providerIsNot();
    
    /**
     * @dataProvider providerIsBlankOr
     */
    public function testIsBlankOr($value)
    {
        $rule = $this->newRule(['field' => $value], 'field');
        $this->assertTrue($this->ruleIsBlankOr($rule));
    }
    
    public function ruleIsBlankOr($rule)
    {
        return $rule->isBlankOr();
    }
    
    public function providerIsBlankOr()
    {
        return array_merge($this->providerIs(), [
            [null],
            [''],
            ["\r \t \n"],
        ]);
    }
    
    /**
     * @dataProvider providerFix
     */
    public function testFix($value, $expect)
    {
        $rule = $this->newRule(['field' => $value], 'field');
        $this->ruleFix($rule);
        $actual = $rule->getValue();
        $this->assertSame($expect, $actual);
    }
    
    public function ruleFix($rule)
    {
        return $rule->fix();
    }
    
    /**
     * @dataProvider providerFixBlankOr
     */
    public function testFixBlankOr($value, $expect)
    {
        $rule = $this->newRule(['field' => $value], 'field');
        $this->ruleFixBlankOr($rule);
        $actual = $rule->getValue();
        $this->assertSame($expect, $actual);
    }
    
    public function ruleFixBlankOr($rule)
    {
        return $rule->fixBlankOr();
    }
    
    public function providerFixBlankOr()
    {
        return array_merge($this->providerFix(), [
            [null, null],
            ['', null],
            ["\r \t \n", null],
        ]);
    }
}
