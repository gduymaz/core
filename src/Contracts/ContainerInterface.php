<?php

namespace Dawnstar\Contracts;

use Dawnstar\Models\Container;
use Dawnstar\Models\Structure;

interface ContainerInterface extends BaseInterface
{
    public function store(Structure $structure): Container;

    public function update(Structure $structure, Container $container);
}
