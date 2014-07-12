<?php

namespace WebCMS\DeployModule\Tests;

class ApplicationTest extends EntityTestCase
{
    protected $application;

    public function testCreateModule()
    {
        $this->initApplication();

        $this->em->persist($this->application);
        $this->em->flush();

        $applications = $this->em->getRepository('WebCMS\DeployModule\Entity\Application')->findAll();

        // test application entity
        $this->assertEquals(1, count($applications));
        $this->assertEquals('Test', $applications[0]->getName());
        $this->assertEquals('testdb', $applications[0]->getDatabaseName());
        $this->assertEquals('/var/www/test/application/', $applications[0]->getPathName());

        // test server entity
        $this->assertEquals('Server 1', $applications[0]->getServers()[0]->getName());
        $this->assertEquals('/var/www/production/', $applications[0]->getServers()[0]->getPath());
        $this->assertEquals('192.168.1.1', $applications[0]->getServers()[0]->getIp());
        $this->assertCount(1, $applications[0]->getServers());

        $this->assertEquals('Test', $applications[0]->getServers()[0]->getApplications()[0]->getName());
    }

    private function initApplication()
    {
        $this->application = new \WebCMS\DeployModule\Entity\Application;
        $this->application->setName('Test');
        $this->application->setPathName('/var/www/test/application/');
        $this->application->setDatabaseName('testdb');
        
        $server = new \WebCMS\DeployModule\Entity\Server;
        $server->setName('Server 1');
        $server->setIp('192.168.1.1');
        $server->setPath('/var/www/production/');

        $this->application->addServer($server);
    }
}
