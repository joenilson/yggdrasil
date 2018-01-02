<?php
namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Roles
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity
 */
class Role
{
    /**
     * @var string
     *
     * @ORM\Column(name="role_name", type="string", length=20, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="roles_role_name_seq", allocationSize=1, initialValue=1)
     */
    private $roleName;

    /**
     * @var string
     *
     * @ORM\Column(name="role_text", type="string", length=80, nullable=false)
     */
    private $roleText;

    /**
     * @var boolean
     *
     * @ORM\Column(name="role_default", type="boolean", nullable=false)
     */
    private $roleDefault;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=false)
     */
    private $status;


}

