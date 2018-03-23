<?php
	namespace App\Entity;

	use DaybreakStudios\Utility\DoctrineEntities\EntityInterface;
	use DaybreakStudios\Utility\DoctrineEntities\EntityTrait;
	use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\Common\Collections\Collection;
	use Doctrine\Common\Collections\Selectable;

	class WeaponCraftingInfo implements EntityInterface {
		use EntityTrait;

		/**
		 * @var bool
		 */
		private $craftable;

		/**
		 * @var Weapon|null
		 */
		private $previous;

		/**
		 * @var Collection|Selectable|Weapon[]
		 */
		private $branches;

		/**
		 * @var Collection|Selectable|CraftingMaterialCost[]
		 */
		private $craftingMaterials;

		/**
		 * @var Collection|Selectable|CraftingMaterialCost[]
		 */
		private $upgradeMaterials;

		/**
		 * WeaponCraftingInfo constructor.
		 *
		 * @param bool        $craftable
		 * @param Weapon|null $previous
		 */
		public function __construct(bool $craftable, ?Weapon $previous = null) {
			$this->craftable = $craftable;
			$this->previous = $previous;

			$this->branches = new ArrayCollection();
			$this->craftingMaterials = new ArrayCollection();
			$this->upgradeMaterials = new ArrayCollection();
		}

		/**
		 * @return bool
		 */
		public function isCraftable(): bool {
			return $this->craftable;
		}

		/**
		 * @param bool $craftable
		 *
		 * @return $this
		 */
		public function setCraftable(bool $craftable) {
			$this->craftable = $craftable;
			return $this;
		}

		/**
		 * @return Weapon|null
		 */
		public function getPrevious() {
			return $this->previous;
		}

		/**
		 * @param Weapon|null $previous
		 *
		 * @return $this
		 */
		public function setPrevious(?Weapon $previous) {
			$this->previous = $previous;
			return $this;
		}

		/**
		 * @return Weapon[]|Collection|Selectable
		 */
		public function getBranches() {
			return $this->branches;
		}

		/**
		 * @return CraftingMaterialCost[]|Collection|Selectable
		 */
		public function getCraftingMaterials() {
			return $this->craftingMaterials;
		}

		/**
		 * @return CraftingMaterialCost[]|Collection|Selectable
		 */
		public function getUpgradeMaterials() {
			return $this->upgradeMaterials;
		}
	}