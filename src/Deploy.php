<?php

/**
 * This file is part of the Deploy module for webcms2.
 * Copyright (c) @see LICENSE
 */

namespace WebCMS\DeployModule;

/**
 * Deploy module for WebCMS2 system.
 * 
 * Deploys applications to the production servers. One application can be assigned
 * to many production servers and vice versa.
 *
 * @author Tomas Voslar <tomas.voslar@webcook.cz>
 */
class Deploy extends \WebCMS\Module
{
	/**
     * Name of the module.
     * 
	 * @var string
	 */
    protected $name = 'Deploy';
    
    /**
     * Author's name.
     * 
     * @var string
     */
    protected $author = 'Tomas Voslar';
    
    /**
     * Module presenters and their settings.
     * 
     * @var array
     */
    protected $presenters = array(
		array(
		    'name' => 'Deploy',
		    'frontend' => true,
		    'parameters' => false
		),
        array(
            'name' => 'Servers',
            'frontend' => false,
            'parameters' => false
        ),
		array(
		    'name' => 'Settings',
		    'frontend' => false
		)
    );
}
