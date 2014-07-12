<?php

namespace AdminModule\DeployModule;

/**
 * Description of
 *
 * @author Tomas Voslar <tomas.voslar@webcook.cz>
 */
class DeployPresenter extends BasePresenter
{
    protected function startup()
    {
	   parent::startup();
    }

    protected function beforeRender()
    {
	   parent::beforeRender();
    }

    public function actionDefault($idPage)
    {

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
        $grid->addColumnText('pathName', 'Path')->setSortable()->setFilterText();
        $grid->addColumnText('databaseName', 'Database')->setSortable()->setFilterText();
        
        $grid->addActionHref("editApplication", 'Edit', 'editApplication', array('idPage' => $this->actualPage->getId()))->getElementPrototype()->addAttributes(array('class' => 'btn btn-primary ajax'));
        $grid->addActionHref("deleteApplication", 'Delete', 'deleteApplication', array('idPage' => $this->actualPage->getId()))->getElementPrototype()->addAttributes(array('class' => 'btn btn-primary btn-danger'));
        
        return $grid;
    }
}
