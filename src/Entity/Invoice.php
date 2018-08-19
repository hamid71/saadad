<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 */
class Invoice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Software", inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $software;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $quatation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $purchesorder;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $invoice;

    public function getId()
    {
        return $this->id;
    }

    public function getSoftware(): ?Software
    {
        return $this->software;
    }

    public function setSoftware(?Software $software): self
    {
        $this->software = $software;

        return $this;
    }

    public function getQuatation(): ?string
    {
        return $this->quatation;
    }

    public function setQuatation(?string $quatation): self
    {
        $this->quatation = $quatation;

        return $this;
    }

    public function getPurchesorder(): ?string
    {
        return $this->purchesorder;
    }

    public function setPurchesorder(?string $purchesorder): self
    {
        $this->purchesorder = $purchesorder;

        return $this;
    }

    public function getInvoice(): ?string
    {
        return $this->invoice;
    }

    public function setInvoice(?string $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }
    
}
