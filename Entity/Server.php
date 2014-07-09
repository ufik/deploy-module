<?php

namespace WebCMS\DeployModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Server entity.
 * @ORM\Entity
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class Server extends Entity
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
     * Gets the value of permissions.
     *
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Sets the value of permissions.
     *
     * @param mixed $permissions the permissions
     *
     * @return self
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }
}