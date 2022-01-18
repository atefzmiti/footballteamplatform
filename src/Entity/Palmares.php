<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PalmaresRepository;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PalmaresRepository::class)
 *@ORM\Table(
 *      name="Palmares",
 *      uniqueConstraints={@ORM\UniqueConstraint(columns={"titlename",})}
 * )
 * @UniqueEntity(
 *      fields={"titlename"},
 *      message="title name is already existed in database."
 * )
 */
class Palmares
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180 )
     */
    private $titlename;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_of_titles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title_photo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitlename(): ?string
    {
        return $this->titlename;
    }

    public function setTitlename(string $titlename): self
    {
        $this->titlename = $titlename;

        return $this;
    }

    public function getNumberOfTitles(): ?int
    {
        return $this->number_of_titles;
    }

    public function setNumberOfTitles(int $number_of_titles): self
    {
        $this->number_of_titles = $number_of_titles;

        return $this;
    }

    public function getTitlePhoto(): ?string
    {
        return $this->title_photo;
    }

    public function setTitlePhoto(string $title_photo): self
    {
        $this->title_photo = $title_photo;

        return $this;
    }
}
