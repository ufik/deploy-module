<?php

/**
 * This file is part of the Deploy module for webcms2.
 * Copyright (c) @see LICENSE
 */

namespace WebCMS\DeployModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application entity holds information about deployed app.
 * 
 * @ORM\Entity
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class Application extends \WebCMS\Entity\Entity
{
    /**
     * Name of the application.
     * 
     * @ORM\Column(name="`name`",unique=true)
     * @var string
     */
    private $name;

    /**
     * Application's path.
     * 
     * @ORM\Column()
     * @var string
     */
    private $path;

    /**
     * Name of the application database.
     * 
     * @ORM\Column(name="`database`")
     * @var string
     */
    private $database;

    /**
     * Prouction servers associated to application.
     * 
     * @orm\ManyToMany(targetEntity="Server", inversedBy="servers")
     * @var \Doctrine\Common\Collections\ArrayCollection<Server>
     */
    private $servers;

    /**
     * Apache config for virtual host.
     * 
     * @ORM\Column(type="text")
     * @var text
     */
    private $apacheConfig;

    /**
     * Constructs entity class with init of servers array collection.
     */
    public function __construct()
    {
        $this->servers = new \Doctrine\Common\Collections\ArrayCollection;
    }

    /**
     * Gets the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of Path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the value of Path.
     *
     * @param string $path the path name
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Gets the value of Database.
     *
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * Sets the value of Database.
     *
     * @param string $database the database name
     *
     * @return self
     */
    public function setDatabase($database)
    {
        $this->database = $database;

        return $this;
    }

    /**
     * Gets the value of servers.
     *
     * @return Server
     */
    public function getServers()
    {
        return $this->servers;
    }


    /**
     * Sets the value of server.
     *
     * @param Server $server the server
     *
     * @return void
     */
    public function addServer(Server $server)
    {
        $server->addApplication($this);
        $this->servers->add($server);
    }

    /**
     * Removes single element from collection.
     * 
     * @param  Server $server serve to remove
     * 
     * @return void
     */
    public function removeServer(Server $server)
    {
        $this->servers->removeElement($server);
    }

    /**
     * Clears servers collection.
     * 
     * @return void
     */
    public function removeServers()
    {
        $this->servers->clear();
    }

    /**
     * Gets the value of apacheConfig.
     *
     * @return text
     */
    public function getApacheConfig()
    {
        return $this->apacheConfig;
    }

    /**
     * Sets the value of apacheConfig.
     *
     * @param text $apacheConfig the apache config
     *
     * @return self
     */
    public function setApacheConfig($apacheConfig)
    {
        $this->apacheConfig = $apacheConfig;

        return $this;
    }
}
