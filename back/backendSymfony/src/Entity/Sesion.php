<?php

namespace App\Entity;

use App\Repository\SesionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SesionRepository::class)]
class Sesion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id   ;

    #[ORM\Column(type: 'date', nullable: true)]
    private $fecha;

    #[ORM\Column(type: 'time', nullable: true)]
    private $hora;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $vip;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $diaEspectador;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $butacasOcupadas;

    #[ORM\Column(type: 'string', length: 30)]
    private $idPeli;

    #[ORM\Column(type: 'string', length: 255)]
    private $nombrePeli;

    #[ORM\Column(type: 'date', nullable: true)]
    private $anoPeli;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imgPeli;

    #[ORM\OneToMany(mappedBy: 'sesion', targetEntity: Entrada::class)]
    private $entradas;

    public function __construct()
    {
        $this->entradas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(?\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }

    public function getVip(): ?bool
    {
        return $this->vip;
    }

    public function setVip(?bool $vip): self
    {
        $this->vip = $vip;

        return $this;
    }

    public function getDiaEspectador(): ?bool
    {
        return $this->diaEspectador;
    }

    public function setDiaEspectador(?bool $diaEspectador): self
    {
        $this->diaEspectador = $diaEspectador;

        return $this;
    }

    public function getButacasOcupadas(): ?string
    {
        return $this->butacasOcupadas;
    }

    public function setButacasOcupadas(?string $butacasOcupadas): self
    {
        $this->butacasOcupadas = $butacasOcupadas;

        return $this;
    }

    public function getIdPeli(): ?string
    {
        return $this->idPeli;
    }

    public function setIdPeli(string $idPeli): self
    {
        $this->idPeli = $idPeli;

        return $this;
    }

    public function getNombrePeli(): ?string
    {
        return $this->nombrePeli;
    }

    public function setNombrePeli(string $nombrePeli): self
    {
        $this->nombrePeli = $nombrePeli;

        return $this;
    }

    public function getAnoPeli(): ?\DateTimeInterface
    {
        return $this->anoPeli;
    }

    public function setAnoPeli(?\DateTimeInterface $anoPeli): self
    {
        $this->anoPeli = $anoPeli;

        return $this;
    }

    public function getImgPeli(): ?string
    {
        return $this->imgPeli;
    }

    public function setImgPeli(?string $imgPeli): self
    {
        $this->imgPeli = $imgPeli;

        return $this;
    }

    /**
     * @return Collection<int, Entrada>
     */
    public function getEntradas(): Collection
    {
        return $this->entradas;
    }

    public function addEntrada(Entrada $entrada): self
    {
        if (!$this->entradas->contains($entrada)) {
            $this->entradas[] = $entrada;
            $entrada->setSesion($this);
        }

        return $this;
    }

    public function removeEntrada(Entrada $entrada): self
    {
        if ($this->entradas->removeElement($entrada)) {
            // set the owning side to null (unless already changed)
            if ($entrada->getSesion() === $this) {
                $entrada->setSesion(null);
            }
        }

        return $this;
    }
}
