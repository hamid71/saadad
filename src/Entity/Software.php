<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SoftwareRepository")
 */
class Software
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $version;

    /**
     * @ORM\Column(type="float")
     */
    private $cost;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    

    /**
     * @ORM\Column(type="text")
     */
    private $requiredby;

    /**
     * @ORM\Column(type="text")
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Discipline", inversedBy="software")
     * @ORM\JoinColumn(nullable=false)
     */
    private $discipline;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invoice", mappedBy="software")
     */
    private $invoices;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Types", inversedBy="software")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Type;

    

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $free;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $scemlab;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $scemlic;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $floating;

    /**
     * @ORM\Column(type="text")
     */
    private $vendor;

    /**
     * @ORM\Column(type="integer")
     */
    private $costcentre;

    /**
     * @ORM\Column(type="text")
     */
    private $remark;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $invoice;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $quatation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $purchesorder;

    /**
     * @ORM\Column(type="date")
     */
    private $expiredate;

    /**
     * @ORM\Column(type="date")
     */
    private $datepurchase;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
    }

    public function getId()
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

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getRequiredby(): ?string
    {
        return $this->requiredby;
    }

    public function setRequiredby(string $requiredby): self
    {
        $this->requiredby = $requiredby;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): self
    {
        $this->discipline = $discipline;

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setSoftware($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->contains($invoice)) {
            $this->invoices->removeElement($invoice);
            // set the owning side to null (unless already changed)
            if ($invoice->getSoftware() === $this) {
                $invoice->setSoftware(null);
            }
        }

        return $this;
    }
    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
        // to show the id of the Category in the select
        // return $this->id;
    }

    public function getType(): ?Types
    {
        return $this->Type;
    }

    public function setType(?Types $Type): self
    {
        $this->Type = $Type;

        return $this;
    }


    public function getFree(): ?string
    {
        return $this->free;
    }

    public function setFree(string $free): self
    {
        $this->free = $free;

        return $this;
    }

    public function getScemLab(): ?string
    {
        return $this->scemlab;
    }

    public function setScemLab(string $scemlab): self
    {
        $this->scemlab = $scemlab;

        return $this;
    }

    public function getScemLic(): ?string
    {
        return $this->scemlic;
    }

    public function setScemLic(string $scemlic): self
    {
        $this->scemlic = $scemlic;

        return $this;
    }

    public function getFloating(): ?string
    {
        return $this->floating;
    }

    public function setFloating(string $floating): self
    {
        $this->floating = $floating;

        return $this;
    }

    public function getVendor(): ?string
    {
        return $this->vendor;
    }

    public function setVendor(string $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getCostCentre(): ?int
    {
        return $this->costcentre;
    }

    public function setCostCentre(int $costcentre): self
    {
        $this->costcentre = $costcentre;

        return $this;
    }

    public function getRemark(): ?string
    {
        return $this->remark;
    }

    public function setRemark(string $remark): self
    {
        $this->remark = $remark;

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

    public function getExpiredate(): ?\DateTimeInterface
    {
        return $this->expiredate;
    }

    public function setExpiredate(\DateTimeInterface $expiredate): self
    {
        $this->expiredate = $expiredate;

        return $this;
    }

    public function getDatepurchase(): ?\DateTimeInterface
    {
        return $this->datepurchase;
    }

    public function setDatepurchase(\DateTimeInterface $datepurchase): self
    {
        $this->datepurchase = $datepurchase;

        return $this;
    }

    
}
