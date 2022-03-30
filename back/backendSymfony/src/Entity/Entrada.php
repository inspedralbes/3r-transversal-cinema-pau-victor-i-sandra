<?php

namespace App\Entity;

use App\Repository\EntradaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntradaRepository::class)]
class Entrada
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $butaca;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $precio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getButaca(): ?string
    {
        return $this->butaca;
    }

    public function setButaca(?string $butaca): self
    {
        $this->butaca = $butaca;

        return $this;
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(?int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }
}
