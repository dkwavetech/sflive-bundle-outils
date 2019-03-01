<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *    itemOperations={
 *        "get"={"method"="GET"},
 *        "put"={"method"="PUT"},
 *        "delete"={"method"="DELETE"},
 *        "get_infos"={
 *            "route_name"="app_speaker_wiki"
 *         },
 *        "get_secured"={
 *            "route_name"="app_speaker_secured"
 *         }
 *    }
 * )
 * @ORM\Entity
 */
class Speaker
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

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
}
