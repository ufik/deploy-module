<?php

class ApplicationTest extends \WebCMS\Tests\EntityTestCase
{
    protected $application;

    public function testCreateModule()
    {
        $this->initModule();

        $this->em->persist($this->application);
        $this->em->flush();

        $applications = $this->em->getRepository('WebCMS\DeployModule\Entity\Application')->findAll();

        // test application entity
        $this->assertEquals(1, count($applications));
        $this->assertEquals('Test', $applications[0]->getName());
        $this->assertEquals('/var/www/test/application/', $applications[0]->getPathName());

        // test server entity
        $this->assertEquals('Server 1', $applications[0]->getServers()[0]->getName());
        $this->assertEquals('/var/www/production/', $applications[0]->getServers()[0]->getPath());
        $this->assertEquals('192.168.1.1', $applications[0]->getServers()[0]->getIp());
        $this->assertCount(1, count($applications[0]->getServers()));
    }

    private function initApplication()
    {
        $this->application = new \WebCMS\Entity\Application;
        $this->application->setName('Test');
        $this->application->setPathName('/var/www/test/application/');
        
        $server = new \WebCMS\Entity\Server;
        $server->setName('Server 1');
        $server->setIp('192.168.1.1');
        $server->setPath('/var/www/production/');

        $this->application->addServer($server);
    }
}
