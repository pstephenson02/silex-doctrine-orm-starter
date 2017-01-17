<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserHistory
 * @package App\Model
 * @ORM\Entity
 * @ORM\Table(name="user_history")
 * @ORM\HasLifecycleCallbacks
 */
class UserHistory
{
    /**
     * @var int $id
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User $user
     * @ORM\ManyToOne(targetEntity="App\Model\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @var string $email
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * UserHistory constructor.
     * @param User $user
     * @param string $email
     */
    public function __construct(User $user, string $email)
    {
        $this->user = $user;
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * @ORM\PrePersist
     */
    public function setTimestamp()
    {
        $this->timestamp = new \DateTime();
    }
}
