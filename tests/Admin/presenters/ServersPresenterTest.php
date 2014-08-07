<?php

namespace WebCMS\DeployModule\Tests;

class ServersPresenterTest extends \WebCMS\Tests\PresenterTestCase
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
        $this->createPresenter('Admin:Deploy:Servers');

        $response = $this->makeRequest('default', 'GET', array('idPage' => 2));

        $this->assertInstanceOf('Nette\Application\Responses\TextResponse', $response);

        $this->getResponse($response);
    }

    public function testFormNew()
    {
        $this->createPresenter('Admin:Deploy:Servers');

        $response = $this->makeRequest('addServer', 'GET', array('idPage' => 2));

        $this->assertInstanceOf('Nette\Application\Responses\TextResponse', $response);

        $this->getResponse($response);
    }

    public function testFormEdit()
    {
        $this->createData();

        $this->createPresenter('Admin:Deploy:Servers');

        $response = $this->makeRequest('addServer', 'GET', array('idPage' => 2, 'id' => 1));

        $this->assertInstanceOf('Nette\Application\Responses\TextResponse', $response);

        $this->getResponse($response);
    }

    public function testFormSubmitNew()
    {
        $this->createPresenter('Admin:Deploy:Servers');

        $response = $this->makeRequest('addServer', 'POST', 
            array('idPage' => 2),
            array(
                'name' => 'test server',
                'path' => 'path/to/app',
                'ip' => 'ip',
                'send' => 'Save'
                ),
            'serverForm-submit'
        );

        $this->assertInstanceOf('Nette\Application\Responses\ForwardResponse', $response);

        // test saved item
        $application = $this->em->getRepository('\WebCMS\DeployModule\Entity\Server')->find(1);
        $this->assertEquals('test server', $application->getName());
    }

    public function testFormSubmitEdit()
    {
        $this->createData();

        $server = $this->em->getRepository('\WebCMS\DeployModule\Entity\Server')->find(1);
        $this->assertEquals('web', $server->getName());

        $this->createPresenter('Admin:Deploy:Servers');

        $response = $this->makeRequest('addServer', 'POST', 
            array('idPage' => 2, 'id' => 1),
            array(
                'name' => 'test server',
                'path' => 'path/to/app',
                'ip' => 'ip',
                'send' => 'Save'
                ),
            'serverForm-submit'
        );

        $this->assertInstanceOf('Nette\Application\Responses\ForwardResponse', $response);

        // test saved item
        $server = $this->em->getRepository('\WebCMS\DeployModule\Entity\Server')->find(1);
        $this->assertEquals('test server', $server->getName());
    }

    public function testDelete()
    {
        $this->createData();

        $this->createPresenter('Admin:Deploy:Servers');

        $response = $this->makeRequest('deleteServer', 'GET', array('idPage' => 2, 'id' => 1));

        $this->assertInstanceOf('Nette\Application\Responses\ForwardResponse', $response);

        $servers = $this->em->getRepository('\WebCMS\DeployModule\Entity\Server')->findAll();
        $this->assertCount(0, $servers);
    }

    private function createData()
    {
        $server = new \WebCMS\DeployModule\Entity\Server;
        $server->setName('web')
               ->setPath('/var/www/')
               ->setIp('asd');

        $this->em->persist($server);
        $this->em->flush();
    }
}
