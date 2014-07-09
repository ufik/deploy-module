<?php

namespace FrontendModule\DeployModule;

/**
 * Description of DeployPresenter
 *
 * @author Tomas Voslar <tomas.voslar@webcook.cz>
 */
class DeployPresenter extends \FrontendModule\BasePresenter
{
    /**
     * Assigned page.
     * @var WebCMS\Entity\Page
     */
	private $page;
	
	protected function startup() 
    {
		parent::startup();
	}

	protected function beforeRender()
    {
		parent::beforeRender();	
	}
	
	public function actionDefault($id)
    {	
		
	}
	
	public function renderDefault($id)
    {	
		$this->template->page = $this->page;
		$this->template->id = $id;
	}
}