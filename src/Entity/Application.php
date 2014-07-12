<?php

namespace WebCMS\DeployModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Application entity.
 * 
 * @ORM\Entity
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class Application extends \WebCMS\Entity\Entity
{
    /**
     * @ORM\Column(name="`name`",unique=true)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column()
     * @var string
     */
    private $path;

    /**
     * @ORM\Column(name="`database`")
     * @var string
     */
    private $database;

    /**
     * @orm\ManyToMany(targetEntity="Server", mappedBy="applications")
     * @var \Doctrine\Common\Collections\ArrayCollection<Server>
     */
    private $servers;

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
        $this->servers->add($server);
    }
}
