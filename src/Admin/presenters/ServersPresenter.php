<?php

namespace AdminModule\DeployModule;

/**
 * Description of
 *
 * @author Tomas Voslar <tomas.voslar@webcook.cz>
 */
class ServersPresenter extends BasePresenter
{
    /**
     * 
     * @var \WebCMS\DeployModule\Entity\Server
     */
    private $server;

    private $repository;

    protected function startup()
    {
	   parent::startup();

       $this->repository = $this->em->getRepository('\WebCMS\DeployModule\Entity\Server');
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

    public function actionAddServer($id, $idPage)
    {
        if (is_numeric($id)) {
            $this->server = $this->repository->find($id);    
        } else {
            $this->server = new \WebCMS\DeployModule\Entity\Server;
        }
    }

    public function renderAddServer($idPage)
    {
        $this->reloadContent();
        $this->template->idPage = $idPage;
    }

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
