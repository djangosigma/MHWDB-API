<?php
	namespace App\Entity;

	use App\Entity\Strings\ArmorSetBonusStrings;
	use App\Localization\TranslatableEntityInterface;
	use DaybreakStudios\Utility\DoctrineEntities\EntityInterface;
	use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\Common\Collections\Collection;
	use Doctrine\Common\Collections\Criteria;
	use Doctrine\Common\Collections\Selectable;
	use Doctrine\ORM\Mapping as ORM;
	use Symfony\Component\Validator\Constraints as Assert;

	/**
	 * @ORM\Entity()
	 * @ORM\Table(name="armor_set_bonuses")
	 *
	 * Class ArmorSetBonus
	 *
	 * @package App\Entity
	 */
	class ArmorSetBonus implements EntityInterface, TranslatableEntityInterface {
		use EntityTrait;

		/**
		 * @Assert\Valid()
		 *
		 * @ORM\OneToMany(
		 *     targetEntity="App\Entity\ArmorSetBonusRank",
		 *     mappedBy="bonus",
		 *     orphanRemoval=true,
		 *     cascade={"all"}
		 * )
		 *
		 * @var ArmorSetBonusRank[]|Collection|Selectable
		 */
		private $ranks;

		/**
		 * @Assert\Valid()
		 *
		 * @ORM\OneToMany(
		 *     targetEntity="App\Entity\Strings\ArmorSetBonusStrings",
		 *     mappedBy="armorSetBonus",
		 *     orphanRemoval=true,
		 *     cascade={"all"},
		 *     fetch="EAGER"
		 * )
		 *
		 * @var Collection|Selectable|ArmorSetBonusStrings[]
		 */
		private $strings;

		/**
		 * ArmorSetBonus constructor.
		 */
		public function __construct() {
			$this->ranks = new ArrayCollection();
			$this->strings = new ArrayCollection();
		}

		/**
		 * @return ArmorSetBonusRank[]|Collection|Selectable
		 */
		public function getRanks() {
			return $this->ranks;
		}

		/**
		 * @param int $pieces
		 *
		 * @return ArmorSetBonusRank|null
		 */
		public function getRank(int $pieces): ?ArmorSetBonusRank {
			$criteria = Criteria::create()
				->where(Criteria::expr()->eq('pieces', $pieces))
				->setMaxResults(1);

			$matching = $this->getRanks()->matching($criteria);

			if (!$matching->count())
				return null;

			return $matching->first();
		}

		/**
		 * @return ArmorSetBonusStrings[]|Collection|Selectable
		 */
		public function getStrings(): Collection {
			return $this->strings;
		}

		/**
		 * @param string $language
		 *
		 * @return ArmorSetBonusStrings
		 */
		public function addStrings(string $language): EntityInterface {
			$this->getStrings()->add($strings = new ArmorSetBonusStrings($this, $language));

			return $strings;
		}
	}