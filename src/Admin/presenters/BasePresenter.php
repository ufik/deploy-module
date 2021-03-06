<?php

/**
 * This file is part of the Deploy module for webcms2.
 * Copyright (c) @see LICENSE
 */

namespace AdminModule\DeployModule;

/**
 * Base presenter for admin part of module.
 *
 * @author Tomas Voslar <tomas.voslar@webcook.cz>
 */
class BasePresenter extends \AdminModule\BasePresenter
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
}