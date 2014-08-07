<?php

namespace AdminModule\DeployModule;

/**
 * Description of
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class SettingsPresenter extends BasePresenter
{
    protected function startup() 
    {
		parent::startup();
    }

    protected function beforeRender() 
    {
		parent::beforeRender();	
    }
	
    public function createComponentSettingsForm()
    {
		$settings = array();

        $settings[] = $this->settings->get('Deploy script', 'deployModule', 'text', array());
        $settings[] = $this->settings->get('Deploy database script', 'deployModule', 'text', array());

		return $this->createSettingsForm($settings);
    }
	
    public function renderDefault($idPage)
    {
		$this->reloadContent();

		$this->template->idPage = $idPage;
    }
}