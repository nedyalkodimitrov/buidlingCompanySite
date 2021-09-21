<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $senderName;

    /**
     * @ORM\Column(type="string")
     */
    private $senderEmail;

    /**
     * @ORM\Column(type="string")
     */
    private $senderPhone;

    /**
     * @ORM\Column(type="string")
     */
    private $senderMessage;

    /**
     * @ORM\Column(type="string")
     */
    private $sendedDate;




    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * @param mixed $senderName
     */
    public function setSenderName($senderName): void
    {
        $this->senderName = $senderName;
    }

    /**
     * @return mixed
     */
    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    /**
     * @param mixed $senderEmail
     */
    public function setSenderEmail($senderEmail): void
    {
        $this->senderEmail = $senderEmail;
    }

    /**
     * @return mixed
     */
    public function getSenderPhone()
    {
        return $this->senderPhone;
    }

    /**
     * @param mixed $senderPhone
     */
    public function setSenderPhone($senderPhone): void
    {
        $this->senderPhone = $senderPhone;
    }

    /**
     * @return mixed
     */
    public function getSenderMessage()
    {
        return $this->senderMessage;
    }

    /**
     * @param mixed $senderMessage
     */
    public function setSenderMessage($senderMessage): void
    {
        $this->senderMessage = $senderMessage;
    }

    /**
     * @return mixed
     */
    public function getSendedDate()
    {
        return $this->sendedDate;
    }

    /**
     * @param mixed $sendedDate
     */
    public function setSendedDate($sendedDate): void
    {
        $this->sendedDate = $sendedDate;
    }



}
