<?php

namespace Ray\Aop;

class NamedArgsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NamedArgs
     */
    protected $args;

    protected function setUp()
    {
        $this->args = new NamedArgs;
    }

    public function testNew()
    {
        $this->assertInstanceOf('Ray\Aop\NamedArgs', $this->args);
    }

    public function testGet()
    {
        $invocation = new ReflectiveMethodInvocation([new MockMethod, 'getSub'], [1, 2]);
        $namedArgs = $this->args->get($invocation);
        $this->assertSame(1, $namedArgs['a']);
    }

    /**
     * @expectedException \Ray\Aop\Exception\DuplicatedNamedParam
     */
    public function testDuplicatedParamName()
    {
        $invocation = new ReflectiveMethodInvocation([new MockMethod, 'duplicatedParamName'], [1, 2]);
        $this->args->get($invocation);
    }
}
