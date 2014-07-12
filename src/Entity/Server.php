<?php

namespace WebCMS\DeployModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Server entity.
 * @ORM\Entity
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class Server extends \WebCMS\Entity\Entity
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
    private $ip;

    /**
     * @ORM\Column()
     * @var string
     */
    private $path;

    /**
     * @orm\ManyToMany(targetEntity="Application", cascade={"persist"})
     * @orm\JoinColumn(name="application_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $applications;

    public function __construct()
    {
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection;
    }

    /**
     * Add application instance into collection.
     * 
     * @param Application $application Application instance.
     */
    public function addApplication(Application $application)
    {
        $this->applications->add($application);
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
     * Gets the value of ip.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Sets the value of ip.
     *
     * @param string $ip the ip
     *
     * @return self
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Gets the value of path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the value of path.
     *
     * @param string $path the path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Gets the value of applications.
     *
     * @return mixed
     */
    public function getApplications()
    {
        return $this->applications;
    }
}
