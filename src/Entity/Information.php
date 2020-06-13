<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InformationRepository")
 */
class Information
{
    /**
    * @ORM\OneToOne(targetEntity=User::class, cascade={"persist"}, inversedBy="information")
    * @ORM\JoinColumn(nullable=true)
    */
    protected $user;
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_famille;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $second_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_naiss;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu_naiss;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identification_type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numero_identite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nationalite;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_referred;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pays_residence;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code_postale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status_emploi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $revenue_annuel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $economie_investissement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $depot_estime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $source_fond;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nb_transaction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qte_echange_semaine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $trading_plateforme;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_compte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $devise;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cgu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identite_doc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $residence_doc;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_complete;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_create;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stape;

    public function __construct()
    {
        $this->cgu = false;
        $this->is_referred = false;
        $this->is_complete = false;
        $this->is_create = false;
        $this->stape = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->second_name;
    }

    public function setSecondName(string $second_name): self
    {
        $this->second_name = $second_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->date_naiss;
    }

    public function setDateNaiss(\DateTimeInterface $date_naiss): self
    {
        $this->date_naiss = $date_naiss;

        return $this;
    }

    public function getLieuNaiss(): ?string
    {
        return $this->lieu_naiss;
    }

    public function setLieuNaiss(string $lieu_naiss): self
    {
        $this->lieu_naiss = $lieu_naiss;

        return $this;
    }

    public function getIdentificationType(): ?string
    {
        return $this->identification_type;
    }

    public function setIdentificationType(string $identification_type): self
    {
        $this->identification_type = $identification_type;

        return $this;
    }

    public function getNumeroIdentite(): ?string
    {
        return $this->numero_identite;
    }

    public function setNumeroIdentite(string $numero_identite): self
    {
        $this->numero_identite = $numero_identite;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getIsReferred(): ?bool
    {
        return $this->is_referred;
    }

    public function setIsReferred(bool $is_referred): self
    {
        $this->is_referred = $is_referred;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCodePostale(): ?string
    {
        return $this->code_postale;
    }

    public function setCodePostale(string $code_postale): self
    {
        $this->code_postale = $code_postale;

        return $this;
    }

    public function getStatusEmploi(): ?string
    {
        return $this->status_emploi;
    }

    public function setStatusEmploi(string $status_emploi): self
    {
        $this->status_emploi = $status_emploi;

        return $this;
    }

    public function getRevenueAnnuel(): ?string
    {
        return $this->revenue_annuel;
    }

    public function setRevenueAnnuel(string $revenue_annuel): self
    {
        $this->revenue_annuel = $revenue_annuel;

        return $this;
    }

    public function getEconomieInvestissement(): ?string
    {
        return $this->economie_investissement;
    }

    public function setEconomieInvestissement(string $economie_investissement): self
    {
        $this->economie_investissement = $economie_investissement;

        return $this;
    }

    public function getDepotEstime(): ?string
    {
        return $this->depot_estime;
    }

    public function setDepotEstime(string $depot_estime): self
    {
        $this->depot_estime = $depot_estime;

        return $this;
    }

    public function getSourceFond(): ?string
    {
        return $this->source_fond;
    }

    public function setSourceFond(string $source_fond): self
    {
        $this->source_fond = $source_fond;

        return $this;
    }

    public function getNbTransaction(): ?string
    {
        return $this->nb_transaction;
    }

    public function setNbTransaction(string $nb_transaction): self
    {
        $this->nb_transaction = $nb_transaction;

        return $this;
    }

    public function getQteEchangeSemaine(): ?string
    {
        return $this->qte_echange_semaine;
    }

    public function setQteEchangeSemaine(string $qte_echange_semaine): self
    {
        $this->qte_echange_semaine = $qte_echange_semaine;

        return $this;
    }

    public function getTradingPlateforme(): ?string
    {
        return $this->trading_plateforme;
    }

    public function setTradingPlateforme(string $trading_plateforme): self
    {
        $this->trading_plateforme = $trading_plateforme;

        return $this;
    }

    public function getTypeCompte(): ?string
    {
        return $this->type_compte;
    }

    public function setTypeCompte(string $type_compte): self
    {
        $this->type_compte = $type_compte;

        return $this;
    }

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(string $devise): self
    {
        $this->devise = $devise;

        return $this;
    }

    public function getCgu(): ?bool
    {
        return $this->cgu;
    }

    public function setCgu(bool $cgu): self
    {
        $this->cgu = $cgu;

        return $this;
    }

    public function getIdentiteDoc(): ?string
    {
        return $this->identite_doc;
    }

    public function setIdentiteDoc(string $identite_doc): self
    {
        $this->identite_doc = $identite_doc;

        return $this;
    }

    public function getResidenceDoc(): ?string
    {
        return $this->residence_doc;
    }

    public function setResidenceDoc(string $residence_doc): self
    {
        $this->residence_doc = $residence_doc;

        return $this;
    }

    public function getNomFamille(): ?string
    {
        return $this->nom_famille;
    }

    public function setNomFamille(?string $nom_famille): self
    {
        $this->nom_famille = $nom_famille;

        return $this;
    }

    public function getPaysResidence(): ?string
    {
        return $this->pays_residence;
    }

    public function setPaysResidence(?string $pays_residence): self
    {
        $this->pays_residence = $pays_residence;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIsComplete(): ?bool
    {
        return $this->is_complete;
    }

    public function setIsComplete(?bool $is_complete): self
    {
        $this->is_complete = $is_complete;

        return $this;
    }

    public function getIsCreate(): ?bool
    {
        return $this->is_create;
    }

    public function setIsCreate(?bool $is_create): self
    {
        $this->is_create = $is_create;

        return $this;
    }

    public function getStape(): ?int
    {
        return $this->stape;
    }

    public function setStape(?int $stape): self
    {
        $this->stape = $stape;

        return $this;
    }
}
