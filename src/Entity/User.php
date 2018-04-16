<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $uf;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $cidade;

    /**
     * @ORM\Column(type="integer")
     */
    private $cep;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $logradouro;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $bairro;

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getUf(): ?string
    {
        return $this->uf;
    }

    public function setUf(string $uf): self
    {
        $this->uf = $uf;

        return $this;
    }

    public function getCidade(): ?string
    {
        return $this->cidade;
    }

    public function setCidade(string $cidade): self
    {
        $this->cidade = $cidade;

        return $this;
    }

    public function getCep(): ?int
    {
        return $this->cep;
    }

    public function setCep(int $cep): self
    {
        $this->cep = $cep;

        return $this;
    }

    public function getLogradouro(): ?string
    {
        return $this->logradouro;
    }

    public function setLogradouro(?string $logradouro): self
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    public function getBairro(): ?string
    {
        return $this->bairro;
    }

    public function setBairro(?string $bairro): self
    {
        $this->bairro = $bairro;

        return $this;
    }
}
