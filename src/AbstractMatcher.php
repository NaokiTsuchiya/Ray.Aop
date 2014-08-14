<?php
/**
 * This file is part of the Ray.Aop package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Ray\Aop;

abstract class AbstractMatcher
{
    /**
     * Match CLASS
     *
     * @var bool
     */
    const TARGET_CLASS = true;

    /**
     * Match Method
     *
     * @var bool
     */
    const TARGET_METHOD = false;

    /**
     * Lazy match method
     *
     * @var string
     */
    protected $method;

    /**
     * Lazy match args
     *
     * @var array
     */
    protected $args;


    /**
     * @param string $method
     * @param array  $args
     *
     * @return AbstractMatcher
     */
    protected function createMatcher($method, array $args)
    {
        $this->method = $method;
        $this->args = $args;

        return clone $this;
    }

    /**
     * Return match result
     *
     * @param string $class
     * @param bool   $target self::TARGET_CLASS | self::TARGET_METHOD
     *
     * @return bool | array [$matcher, method]
     */
    public function __invoke($class, $target)
    {
        $args = array_merge([$class, $target], $this->args);
        $method = 'is' . $this->method;
        $match = method_exists($this, $method) ? $this : new Match;
        $matched = call_user_func_array([$match, $method], $args);

        return $matched;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $result = $this->method . ':' . json_encode($this->args);

        return $result;
    }
}
