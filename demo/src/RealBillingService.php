<?php

declare(strict_types=1);

namespace Ray\Aop\Demo;

use const PHP_EOL;

class RealBillingService implements BillingService
{
    public function chargeOrder()
    {
        return 'Charged.' . PHP_EOL;
    }
}
