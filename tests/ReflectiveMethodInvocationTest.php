<?php

namespace Ray\Aop;

use Ray\Aop\Annotation\Marker;

class ReflectiveMethodInvocationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ReflectiveMethodInvocation
     */
    protected $invocation;

    /**
     * @var MockMethod
     */
    protected $mock;

    protected function setUp()
    {
        parent::setUp();
        $this->mock = new MockMethod;
        // this is same as $this->mock->add(1);
        $callable = [$this->mock, 'add'];
        $args = [1];
        $this->invocation = new ReflectiveMethodInvocation($callable, $args);
    }

    public function testNew()
    {
        $actual = $this->invocation;
        $this->assertInstanceOf('\Ray\Aop\ReflectiveMethodInvocation', $actual);
    }

    public function testGetMethod()
    {
        $methodReflection = $this->invocation->getMethod();
        $this->assertInstanceOf('\ReflectionMethod', $methodReflection);
    }

    public function testGetMethodMethodName()
    {
        $methodReflection = $this->invocation->getMethod();
        $this->assertSame('Ray\Aop\MockMethod', $methodReflection->class);
        $this->assertSame('add', $methodReflection->name);
    }

    public function testGetArguments()
    {
        $args = $this->invocation->getArguments();
        $this->assertSame((array)$args, [1]);
    }

    public function testProceed()
    {
        $this->invocation->proceed();
        $this->assertSame(1, $this->mock->a);
    }

    public function testProceedTwoTimes()
    {
        $this->invocation->proceed();
        $this->invocation->proceed();
        $this->assertSame(2, $this->mock->a);
    }

    public function testGetThis()
    {
        $actual = $this->invocation->getThis();
        $this->assertSame($this->mock, $actual);
    }

    public function testGetAnnotation()
    {
        $mock = new MockMethod;
        $callable = [$mock, 'add'];
        $invocation = new ReflectiveMethodInvocation($callable, [], [], [new Marker]);
        /** @noinspection PhpDeprecationInspection */
        $annotations = $invocation->getAnnotation();
        $this->assertInstanceOf('Ray\Aop\Annotation\Marker', $annotations[0]);
    }
}
