<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace Tests\Feature;

use Tests\TestCase;

abstract class BaseFeatureTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->disableExceptionHandling();
    }
}
