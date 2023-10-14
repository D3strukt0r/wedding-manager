<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\TableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableRepository::class)]
#[ORM\Table(name: '`table`')]
class Table
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $seats;

    #[ORM\OneToMany(mappedBy: 'tableToSit', targetEntity: Invitee::class)]
    private Collection $invitees;

    public function __construct(int $seats)
    {
        $this->invitees = new ArrayCollection();

        $this->seats = $seats;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeats(): int
    {
        return $this->seats;
    }

    /**
     * @return Collection<int, Invitee>
     */
    public function getInvitees(): Collection
    {
        return $this->invitees;
    }

    public function addInvitee(Invitee $invitee): static
    {
        if (!$this->invitees->contains($invitee)) {
            $this->invitees->add($invitee);
            $invitee->setTableToSit($this);
        }

        return $this;
    }

    public function removeInvitee(Invitee $invitee): static
    {
        if ($this->invitees->removeElement($invitee)) {
            // set the owning side to null (unless already changed)
            if ($invitee->getTableToSit() === $this) {
                $invitee->setTableToSit(null);
            }
        }

        return $this;
    }
}
