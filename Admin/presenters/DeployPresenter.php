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
}