<?php

/**
 * This file is part of the Deploy module for webcms2.
 * Copyright (c) @see LICENSE
 */

namespace AdminModule\DeployModule;

/**
 * Settings presenter of the deploy module.
 * 
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class SettingsPresenter extends BasePresenter
{
    /**
     * {@inheritdoc}
     */
    protected function startup() 
    {
		parent::startup();
    }

    /**
     * {@inheritdoc}
     */
    protected function beforeRender() 
    {
		parent::beforeRender();	
    }
	
    /**
     * Creates settings form component.
     * 
     * @return  Nette\Application\UI\Control
     */
    public function createComponentSettingsForm()
    {
		$settings = array();

		return $this->createSettingsForm($settings);
    }
	
    /**
     * Renders default template.
     * 
     * @param  int $idPage Id of the page.
     * 
     * @return void
     */
    public function renderDefault($idPage)
    {
		$this->reloadContent();

		$this->template->idPage = $idPage;
    }
}