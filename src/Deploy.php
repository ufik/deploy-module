<?php

namespace WebCMS\DeployModule;

/**
 * Description of deploy
 *
 * @author Tomas Voslar <tomas.voslar@webcook.cz>
 */
class Deploy extends \WebCMS\Module
{
	/**
	 * [$name description]
	 * @var string
	 */
    protected $name = 'Deploy';
    
    /**
     * [$author description]
     * @var string
     */
    protected $author = 'Tomas Voslar';
    
    /**
     * [$presenters description]
     * @var array
     */
    protected $presenters = array(
		array(
		    'name' => 'Deploy',
		    'frontend' => false,
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

    /**
     * [$params description]
     * @var array
     */
    protected $params = array();

    /**
     * [$cloneable description]
     * @var boolean
     */
    protected $cloneable = false;

    /**
     * [$translatable description]
     * @var boolean
     */
    protected $translatable = false;

    /**
     * [$searchable description]
     * @var boolean
     */
    protected $searchable = false;

    public function __construct() 
    {
	
    }
}
