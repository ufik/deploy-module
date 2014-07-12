<?php

namespace WebCMS\DeployModule\Tests;

class ApplicationTest extends EntityTestCase
{
    public function testPersistEntities()
    {
        $this->initData();

        $applications = $this->em->getRepository('WebCMS\DeployModule\Entity\Application')->findAll();

        // test application entity
        $this->assertCount(2, $applications);
        $this->assertEquals('Test', $applications[0]->getName());
        $this->assertEquals('testdb', $applications[0]->getDatabaseName());
        $this->assertEquals('/var/www/test/application/', $applications[0]->getPathName());

        $this->assertEquals('Test2', $applications[1]->getName());
        $this->assertEquals('test2db', $applications[1]->getDatabaseName());
        $this->assertEquals('/var/www/test/application2/', $applications[1]->getPathName());

        // test server entity
        $this->assertEquals('Server 1', $applications[0]->getServer()->getName());
        $this->assertEquals('/var/www/production/', $applications[0]->getServer()->getPath());
        $this->assertEquals('192.168.1.1', $applications[0]->getServer()->getIp());

        $server = $this->em->getRepository('WebCMS\DeployModule\Entity\Server')->find(1);
        $applications = $server->getApplications();

        $this->assertCount(2, $applications);
    }

    private function initData()
    {
        $server = new \WebCMS\DeployModule\Entity\Server;
        $server->setName('Server 1');
        $server->setIp('192.168.1.1');
        $server->setPath('/var/www/production/');

        $application = new \WebCMS\DeployModule\Entity\Application;
        $application->setName('Test');
        $application->setPathName('/var/www/test/application/');
        $application->setDatabaseName('testdb');
        
        $application2 = new \WebCMS\DeployModule\Entity\Application;
        $application2->setName('Test2');
        $application2->setPathName('/var/www/test/application2/');
        $application2->setDatabaseName('test2db');

        $server->addApplication($application);
        $server->addApplication($application2);

        $this->em->persist($application);
        $this->em->persist($application2);
        $this->em->persist($server);

        $this->em->flush();
    }
}
