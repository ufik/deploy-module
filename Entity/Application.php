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
     * @ORM\Column(unique=true)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column()
     * @var string
     */
    private $pathName;

    /**
     * @ORM\Column()
     * @var string
     */
    private $databaseName;

    /**
     * @orm\ManyToMany(targetEntity="Server", cascade={"persist"})
     * @orm\JoinColumn(name="server_id", referencedColumnName="id", onDelete="CASCADE")
     * @var \Doctrine\Common\Collections\ArrayCollection\ArrayCollection
     */
    private $servers;

    /**
     * Constructor method, initialize empty servers collection.
     */
    public function __construct()
    {
        $this->servers = new \Doctrine\Common\Collections\ArrayCollection\ArrayCollection();
    }

    /**
     * Add server into array collection.
     * 
     * @param Server $server Server object to insert.
     */
    public function addServer($server)
    {
        $this->servers->add($server);
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
     * Gets the value of pathName.
     *
     * @return string
     */
    public function getPathName()
    {
        return $this->pathName;
    }

    /**
     * Sets the value of pathName.
     *
     * @param string $pathName the path name
     *
     * @return self
     */
    public function setPathName($pathName)
    {
        $this->pathName = $pathName;

        return $this;
    }

    /**
     * Gets the value of databaseName.
     *
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * Sets the value of databaseName.
     *
     * @param string $databaseName the database name
     *
     * @return self
     */
    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;

        return $this;
    }

    /**
     * Gets the value of servers.
     *
     * @return mixed
     */
    public function getServers()
    {
        return $this->servers;
    }

    /**
     * Sets the value of servers.
     *
     * @param mixed $servers the servers
     *
     * @return self
     */
    public function setServers($servers)
    {
        $this->servers = $servers;

        return $this;
    }
}
