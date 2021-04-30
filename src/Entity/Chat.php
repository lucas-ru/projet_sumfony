<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 */
class Chat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $idPostAuthor;

    /**
     * @ORM\Column(type="integer")
     */
    private $idCommentAuthor;

    /**
     * @ORM\OneToMany(targetEntity=MessageChat::class, mappedBy="chat")
     */
    private $messages;

    /**
     * @ORM\Column(type="integer")
     */
    private $idPost;

    /**
     * @ORM\Column(type="integer")
     */
    private $idComment;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIdPostAuthor(): ?int
    {
        return $this->idPostAuthor;
    }

    public function setIdPostAuthor(int $idPostAuthor): self
    {
        $this->idPostAuthor = $idPostAuthor;

        return $this;
    }

    public function getIdCommentAuthor(): ?int
    {
        return $this->idCommentAuthor;
    }

    public function setIdCommentAuthor(int $idCommentAuthor): self
    {
        $this->idCommentAuthor = $idCommentAuthor;

        return $this;
    }

    /**
     * @return Collection|MessageChat[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(MessageChat $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setChat($this);
        }

        return $this;
    }

    public function removeMessage(MessageChat $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getChat() === $this) {
                $message->setChat(null);
            }
        }

        return $this;
    }

    public function getIdPost(): ?int
    {
        return $this->idPost;
    }

    public function setIdPost(int $idPost): self
    {
        $this->idPost = $idPost;

        return $this;
    }

    public function getIdComment(): ?int
    {
        return $this->idComment;
    }

    public function setIdComment(int $idComment): self
    {
        $this->idComment = $idComment;

        return $this;
    }
}
