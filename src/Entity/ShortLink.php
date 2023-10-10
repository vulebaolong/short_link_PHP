<?php

namespace App\Entity;

use App\Repository\ShortLinkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShortLinkRepository::class)]
class ShortLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $link_init = null;

    #[ORM\Column(length: 255)]
    private ?string $link_short = null;

    public function getAllValues(): ?array
    {
        return [
            "id" => $this->id,
            "link_init" => $this->link_init,
            "link_short" => $this->link_short,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLinkInit(): ?string
    {
        return $this->link_init;
    }

    public function setLinkInit(string $link_init): static
    {
        $this->link_init = $link_init;

        return $this;
    }

    public function getLinkShort(): ?string
    {
        return $this->link_short;
    }

    public function setLinkShort(string $link_short): static
    {
        $this->link_short = $link_short;

        return $this;
    }
}
