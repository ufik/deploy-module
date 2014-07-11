<?php

namespace WebCMS\DeployModule\Tests;

abstract class EntityTestCase extends \WebCMS\Tests\EntityTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->tool->createSchema($this->getClassesMetadata(__DIR__ . '/../src/Entity', 'WebCMS\\DeployModule\\Entity'));
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
