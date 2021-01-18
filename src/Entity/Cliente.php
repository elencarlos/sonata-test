<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClienteRepository::class)
 * @ORM\Table(name="cliente")
 */
class Cliente
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
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity=Compra::class, mappedBy="cliente")
     */
    private $compras;

    /**
     * @ORM\OneToOne(targetEntity=Endereco::class, mappedBy="cliente")
     */
    private $endereco;

    public function __construct()
    {
        $this->compras = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return Collection|Compra[]
     */
    public function getCompras(): Collection
    {
        return $this->compras;
    }

    public function addCompra(Compra $compra): self
    {
        if (!$this->compras->contains($compra)) {
            $this->compras[] = $compra;
            $compra->setCliente($this);
        }

        return $this;
    }

    public function removeCompra(Compra $compra): self
    {
        if ($this->compras->removeElement($compra)) {
            // set the owning side to null (unless already changed)
            if ($compra->getCliente() === $this) {
                $compra->setCliente(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nome;
    }

    public function getEndereco(): ?Endereco
    {
        return $this->endereco;
    }

    public function setEndereco(?Endereco $endereco): self
    {
        // unset the owning side of the relation if necessary
        if ($endereco === null && $this->endereco !== null) {
            $this->endereco->setCliente(null);
        }

        // set the owning side of the relation if necessary
        if ($endereco !== null && $endereco->getCliente() !== $this) {
            $endereco->setCliente($this);
        }

        $this->endereco = $endereco;

        return $this;
    }
}
