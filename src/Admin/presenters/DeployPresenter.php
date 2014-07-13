<?php

/**
 * This file is part of the Deploy module for webcms2.
 * Copyright (c) @see LICENSE
 */

namespace AdminModule\DeployModule;

/**
 * Deploy presenter takes care about deployment of applications as well as management of application.
 *
 * @author Tomas Voslar <tomas.voslar@webcook.cz>
 */
class DeployPresenter extends BasePresenter
{
    /**
     * Application's instance holder.
     * 
     * @var \WebCMS\DeployModule\Entity\Application
     */
    private $application;

    /**
     * Application entity repository.
     * 
     * @var Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * {@inheritdoc}
     */
    protected function startup()
    {
	   parent::startup();

       $this->repository = $this->em->getRepository('\WebCMS\DeployModule\Entity\Application');
    }

    /**
     * {@inheritdoc}
     */
    protected function beforeRender()
    {
	   parent::beforeRender();
    }

    /**
     * {@inheritdoc}
     */
    public function renderDefault($idPage)
    {
    	$this->reloadContent();
    	$this->template->idPage = $idPage;
    }
    
    /**
     * Creates datagrid with applications.
     * 
     * @param  string $name                   Name of the datagrid.
     * 
     * @return Nette\Application\UI\Control   Datagrid object.
     */
    protected function createComponentApplicationsGrid($name)
    {
        $grid = $this->createGrid($this, $name, '\WebCMS\DeployModule\Entity\Application');
        
        $grid->addColumnText('name', 'Name')->setSortable()->setFilterText();
        $grid->addColumnText('path', 'Path')->setSortable()->setFilterText();
        $grid->addColumnText('database', 'Database')->setSortable()->setFilterText();
        $grid->addColumnText('servers', 'Servers')->setCustomRender(function($item) {
            $servers = '';
            foreach ($item->getServers()->getIterator() as $server) {
                $servers .= $server->getName() . ', ';
            }

            return substr($servers, 0, -2);
        });

        $grid->addActionHref("addApplication", 'Edit', 'addApplication', array('idPage' => $this->actualPage->getId()))->getElementPrototype()->addAttributes(array('class' => 'btn btn-primary ajax'));
        $grid->addActionHref("deleteApplication", 'Delete', 'deleteApplication', array('idPage' => $this->actualPage->getId()))->getElementPrototype()->addAttributes(array('class' => 'btn btn-primary btn-danger'));
        
        return $grid;
    }

    /**
     * Display application form action. 
     *
     * @param  int  $id      Application's id.
     * @param  int  $idPage  Id of the page.
     * 
     * @return void
     */
    public function actionAddApplication($id, $idPage)
    {
        if (is_numeric($id)) {
            $this->application = $this->repository->find($id);
        } else {
            $this->application = new \WebCMS\DeployModule\Entity\Application;
        }   
    }

    /**
     * Render method for application form.
     * 
     * @param  int $idPage 
     * 
     * @return void
     */
    public function renderAddApplication($idPage)
    {
        $this->reloadContent();
        $this->template->idPage = $idPage;
    }

    /**
     * Creates application form component.
     * 
     * @return  Nette\Application\UI\Control
     */
    public function createComponentApplicationForm()
    {
        $form = $this->createForm();

        $servers = $this->em->getRepository('\WebCMS\DeployModule\Entity\Server')->findAll();

        $serversArray = array();
        foreach ($servers as $server) {
            $serversArray[$server->getId()] = $server->getName();
        }

        $form->addText('name', 'Name')->setRequired()->setAttribute('class', 'form-control');
        $form->addText('path', 'Path')->setRequired()->setAttribute('class', 'form-control');
        $form->addText('database', 'Database')->setRequired()->setAttribute('class', 'form-control');
        $form->addTextArea('apacheConfig', 'Apache config')
                ->setRequired()
                ->setAttribute('class', 'form-control')
                ->setDefaultValue('<VirtualHost *:80>
DocumentRoot /var/www/production/appname.cz
ServerName www.appname.cz
ServerAlias appname.cz
ErrorLog /var/log/appname.log
TransferLog /var/log/appname.log

<IfModule php5_module>
    php_value newrelic.appname "appname.cz"
</IfModule>

<Directory />
        Options FollowSymLinks
        AllowOverride All
</Directory>
</VirtualHost>');
        $form->addMultiSelect('servers', 'Production server', $serversArray)->setAttribute('class', 'form-control');

        $form->addSubmit('send', 'Save')->setAttribute('class', 'btn btn-success');
        $form->onSuccess[] = callback($this, 'applicationFormSubmitted');

        $form->setDefaults($this->application->toArray());

        return $form;
    }

    /**
     * Method executed after form is submitted.
     * 
     * @param  Nette\Forms\Form $form Application form.
     * 
     * @return void
     */
    public function applicationFormSubmitted($form)
    {
        $values = $form->getValues();

        $this->application->removeServers();
        $this->em->flush();

        $this->application->setName($values->name)
                          ->setPath($values->path)
                          ->setDatabase($values->database)
                          ->setApacheConfig($values->apacheConfig);
        
        foreach($values->servers as $s) {
            $server = $this->em->getRepository('\WebCMS\DeployModule\Entity\Server')->find($s);
            $this->application->addServer($server);
        }

        $this->em->persist($this->application);
        $this->em->flush();

        $this->flashMessage('Application has been added.', 'success');
        $this->forward('default', array(
                'idPage' => $this->actualPage->getId()
            ));
    }

    /**
     * Method for deleting of application.
     * 
     * @param  int $id Id of the application to remove.
     * 
     * @return void
     */
    public function actionDeleteApplication($id)
    {
        $this->application = $this->repository->find($id);

        $this->em->remove($this->application);
        $this->em->flush();

        $this->flashMessage('Application has been removed', 'success');
        $this->forward('default', array(
                'idPage' => $this->actualPage->getId()
            ));
    }
}
