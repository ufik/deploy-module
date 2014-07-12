<?php

namespace WebCMS\DeployModule\Tests;

class DeployPresenterTest extends \WebCMS\Tests\PresenterTestCase
{

    public function __construct()
    {
        parent::__construct();
        
    }

    public function setUp()
    {
        parent::setUp();

        $this->tool->createSchema($this->getClassesMetadata(__DIR__ . '/../../../src/Entity', 'WebCMS\\DeployModule\\Entity'));
        $this->createPage('Deploy');
    }

    public function testDefault()
    {
        $this->createPresenter('Admin:Deploy:Deploy');

        $response = $this->makeRequest('default', 'GET', array('idPage' => 2));

        $this->assertInstanceOf('Nette\Application\Responses\TextResponse', $response);

        $this->getResponse($response);
    }
}
