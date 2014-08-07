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
        $this->createData();

        $this->createPresenter('Admin:Deploy:Deploy');

        $response = $this->makeRequest('default', 'GET', array('idPage' => 2));

        $this->assertInstanceOf('Nette\Application\Responses\TextResponse', $response);

        $this->getResponse($response);
    }

    public function testFormNew()
    {
        $this->createPresenter('Admin:Deploy:Deploy');

        $response = $this->makeRequest('addApplication', 'GET', array('idPage' => 2));

        $this->assertInstanceOf('Nette\Application\Responses\TextResponse', $response);

        $this->getResponse($response);
    }

    public function testFormEdit()
    {
        $this->createData();

        $this->createPresenter('Admin:Deploy:Deploy');

        $response = $this->makeRequest('addApplication', 'GET', array('idPage' => 2, 'id' => 1));

        $this->assertInstanceOf('Nette\Application\Responses\TextResponse', $response);

        $this->getResponse($response);
    }

    public function testFormSubmitNew()
    {
        $this->createPresenter('Admin:Deploy:Deploy');

        $response = $this->makeRequest('addApplication', 'POST', 
            array('idPage' => 2),
            array(
                'name' => 'test app',
                'path' => 'path/to/app',
                'database' => 'db-name',
                'apacheConfig' => '<virtualhost>',
                'servers[]' => 1,
                'send' => 'Save'
                ),
            'applicationForm-submit'
        );

        $this->assertInstanceOf('Nette\Application\Responses\ForwardResponse', $response);

        // test saved item
        $application = $this->em->getRepository('\WebCMS\DeployModule\Entity\Application')->find(1);
        $this->assertEquals('test app', $application->getName());
    }

    public function testFormSubmitEdit()
    {
        $this->createData();

        $application = $this->em->getRepository('\WebCMS\DeployModule\Entity\Application')->find(1);
        $this->assertEquals('test', $application->getName());

        $this->createPresenter('Admin:Deploy:Deploy');

        $response = $this->makeRequest('addApplication', 'POST', 
            array('idPage' => 2, 'id' => 1),
            array(
                'name' => 'test app',
                'path' => 'path/to/app',
                'database' => 'db-name',
                'apacheConfig' => '<virtualhost>',
                'servers[]' => 1,
                'send' => 'Save'
                ),
            'applicationForm-submit'
        );

        $this->assertInstanceOf('Nette\Application\Responses\ForwardResponse', $response);

        // test saved item
        $application = $this->em->getRepository('\WebCMS\DeployModule\Entity\Application')->find(1);
        $this->assertEquals('test app', $application->getName());
    }

    public function testDelete()
    {
        $this->createData();

        $this->createPresenter('Admin:Deploy:Deploy');

        $response = $this->makeRequest('deleteApplication', 'GET', array('idPage' => 2, 'id' => 1));

        $this->assertInstanceOf('Nette\Application\Responses\ForwardResponse', $response);

        $applications = $this->em->getRepository('\WebCMS\DeployModule\Entity\Application')->findAll();
        $this->assertCount(0, $applications);
    }

    private function createData()
    {
        $server = new \WebCMS\DeployModule\Entity\Server;
        $server->setName('web')
               ->setPath('/var/www/')
               ->setIp('asd');

        $this->em->persist($server);

        $application = new \WebCMS\DeployModule\Entity\Application;
        $application->setName('test')
                    ->setPath('path/to/app')
                    ->setDatabase('db-name')
                    ->setApacheConfig('<virtualhost>');
        $application->addServer($server);

        $this->em->persist($application);
        $this->em->flush();
    }
}
