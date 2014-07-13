<?php

/**
 * This file is part of the Deploy module for webcms2.
 * Copyright (c) @see LICENSE
 */

namespace AdminModule\DeployModule;

/**
 * Servers presenter takes care of managing production servers.
 *
 * @author Tomas Voslar <tomas.voslar@webcook.cz>
 */
class ServersPresenter extends BasePresenter
{
    /**
     * Server instance holder.
     * 
     * @var \WebCMS\DeployModule\Entity\Server
     */
    private $server;

    /**
     * Server entity repository.
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

       $this->repository = $this->em->getRepository('\WebCMS\DeployModule\Entity\Server');
    }

    /**
     * {@inheritdoc}
     */
    protected function beforeRender()
    {
	   parent::beforeRender();
    }

    /**
     * Renders default template with datagrid.
     * 
     * @param  int    $idPage Id of the page.
     * 
     * @return void
     */
    public function renderDefault($idPage)
    {
    	$this->reloadContent();
    	$this->template->idPage = $idPage;
    }
    
    /**
     * Creates datagrid with servers.
     * 
     * @param  string $name                   Name of the datagrid.
     * 
     * @return \Grido\Grid   Datagrid object.
     */
    protected function createComponentServersGrid($name)
    {
        $grid = $this->createGrid($this, $name, '\WebCMS\DeployModule\Entity\Server');
        
        $grid->addColumnText('name', 'Name')->setSortable()->setFilterText();
        $grid->addColumnText('path', 'Path')->setSortable()->setFilterText();
        $grid->addColumnText('ip', 'Ip address')->setSortable()->setFilterText();
        
        $grid->addActionHref("addServer", 'Edit', 'addServer', array('idPage' => $this->actualPage->getId()))->getElementPrototype()->addAttributes(array('class' => 'btn btn-primary ajax'));
        $grid->addActionHref("deleteServer", 'Delete', 'deleteServer', array('idPage' => $this->actualPage->getId()))->getElementPrototype()->addAttributes(array('class' => 'btn btn-primary btn-danger'));
        
        return $grid;
    }

    /**
     * Display server form action. 
     *
     * @param  int  $id      Application's id.
     * @param  int  $idPage  Id of the page.
     * 
     * @return void
     */
    public function actionAddServer($id, $idPage)
    {
        if (is_numeric($id)) {
            $this->server = $this->repository->find($id);    
        } else {
            $this->server = new \WebCMS\DeployModule\Entity\Server;
        }
    }

    /**
     * Render method for server form.
     * 
     * @param  int $idPage 
     * 
     * @return void
     */
    public function renderAddServer($idPage)
    {
        $this->reloadContent();
        $this->template->idPage = $idPage;
    }

    /**
     * Creates server form component.
     * 
     * @return  \Nette\Application\UI\Form
     */
    public function createComponentServerForm($form)
    {
        $form = $this->createForm();

        $form->addText('name', 'Name')->setRequired()->setAttribute('class', 'form-control');
        $form->addText('path', 'Path')->setRequired()->setAttribute('class', 'form-control');
        $form->addText('ip', 'Ip address')->setRequired()->setAttribute('class', 'form-control');

        $form->addSubmit('send', 'Save')->setAttribute('class', 'btn btn-success');
        $form->onSuccess[] = callback($this, 'serverFormSubmitted');

        $form->setDefaults($this->server->toArray());

        return $form;
    }

    /**
     * Saves form data into database.
     * 
     * @param  Nette\Forms\Form $form Server form.
     * 
     * @return void
     */
    public function serverFormSubmitted($form)
    {
        $values = $form->getValues();

        $this->server->setName($values->name);
        $this->server->setPath($values->path);
        $this->server->setIp($values->ip);

        $this->em->persist($this->server);
        $this->em->flush();

        $this->flashMessage('Server has been added.', 'success');
        $this->forward('default', array(
                'idPage' => $this->actualPage->getId()
            ));
    }

    /**
     * Deletes server.
     * 
     * @param  int $id Server's id to remove.
     * 
     * @return void
     */
    public function actionDeleteServer($id)
    {
        $this->server = $this->repository->find($id);

        $this->em->remove($this->server);
        $this->em->flush();

        $this->flashMessage('Server has been removed.', 'success');
        $this->forward('default', array(
                'idPage' => $this->actualPage->getId()
            ));
    }
}
