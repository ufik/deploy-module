<?php

namespace AdminModule\DeployModule;

/**
 * Description of
 *
 * @author Tomas Voslar <tomas.voslar@webcook.cz>
 */
class DeployPresenter extends BasePresenter
{
    /**
     * 
     * @var \WebCMS\DeployModule\Entity\Application
     */
    private $application;

    private $repository;

    protected function startup()
    {
	   parent::startup();

       $this->repository = $this->em->getRepository('\WebCMS\DeployModule\Entity\Application');
    }

    protected function beforeRender()
    {
	   parent::beforeRender();
    }

    public function renderDefault($idPage)
    {
    	$this->reloadContent();
    	$this->template->idPage = $idPage;
    }
    
    protected function createComponentApplicationsGrid($name)
    {
        $grid = $this->createGrid($this, $name, '\WebCMS\DeployModule\Entity\Application');
        
        $grid->addColumnText('name', 'Name')->setSortable()->setFilterText();
        $grid->addColumnText('path', 'Path')->setSortable()->setFilterText();
        $grid->addColumnText('database', 'Database')->setSortable()->setFilterText();
        
        $grid->addActionHref("addApplication", 'Edit', 'addApplication', array('idPage' => $this->actualPage->getId()))->getElementPrototype()->addAttributes(array('class' => 'btn btn-primary ajax'));
        $grid->addActionHref("deleteApplication", 'Delete', 'deleteApplication', array('idPage' => $this->actualPage->getId()))->getElementPrototype()->addAttributes(array('class' => 'btn btn-primary btn-danger'));
        
        return $grid;
    }

    public function actionAddApplication($id, $idPage)
    {
        if (is_numeric($id)) {
            $this->application = $this->repository->find($id);
        } else {
            $this->application = new \WebCMS\DeployModule\Entity\Application;
        }   
    }

    public function renderAddApplication($idPage)
    {
        $this->reloadContent();
        $this->template->idPage = $idPage;
    }

    public function createComponentApplicationForm($form)
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
        $form->addSelect('server', 'Production server', $serversArray)->setAttribute('class', 'form-control');

        $form->addSubmit('send', 'Save')->setAttribute('class', 'btn btn-success');
        $form->onSuccess[] = callback($this, 'applicationFormSubmitted');

        $form->setDefaults($this->application->toArray());

        return $form;
    }

    public function applicationFormSubmitted($form)
    {
        $values = $form->getValues();

        $server = $this->em->getRepository('\WebCMS\DeployModule\Entity\Server')->find($values->server);
        
        $this->application->setName($values->name);
        $this->application->setPath($values->path);
        $this->application->setDatabase($values->database);
        $this->application->addServer($server);

        $this->em->persist($this->application);
        $this->em->flush();

        $this->flashMessage('Application has been added.', 'success');
        $this->forward('default', array(
                'idPage' => $this->actualPage->getId()
            ));
    }

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
