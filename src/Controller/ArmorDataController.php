<?php
	namespace App\Controller;

	use App\Entity\Armor;
	use App\Entity\Asset;
	use App\Entity\CraftingMaterialCost;
	use App\Entity\SkillRank;
	use App\Entity\Slot;
	use App\QueryDocument\Projection;
	use DaybreakStudios\DozeBundle\ResponderService;
	use DaybreakStudios\Utility\DoctrineEntities\EntityInterface;
	use Symfony\Bridge\Doctrine\RegistryInterface;
	use Symfony\Component\Routing\RouterInterface;

	class ArmorDataController extends AbstractDataController {
		/**
		 * ArmorDataController constructor.
		 *
		 * @param RegistryInterface $doctrine
		 * @param ResponderService  $responder
		 * @param RouterInterface   $router
		 */
		public function __construct(RegistryInterface $doctrine, ResponderService $responder, RouterInterface $router) {
			parent::__construct($doctrine, $responder, $router, Armor::class);
		}

		/**
		 * @param EntityInterface|Armor|null $entity
		 * @param Projection                 $projection
		 *
		 * @return array|null
		 */
		protected function normalizeOne(?EntityInterface $entity, Projection $projection): ?array {
			if (!$entity)
				return null;

			$defense = $entity->getDefense();
			$resists = $entity->getResistances();

			$output = [
				'id' => $entity->getId(),
				'slug' => $entity->getSlug(),
				'name' => $entity->getName(),
				'type' => $entity->getType(),
				'rank' => $entity->getRank(),
				'rarity' => $entity->getRarity(),
				'defense' => [
					'base' => $defense->getBase(),
					'max' => $defense->getMax(),
					'augmented' => $defense->getAugmented(),
				],
				'resistances' => [
					'fire' => $resists->getFire(),
					'water' => $resists->getWater(),
					'ice' => $resists->getIce(),
					'thunder' => $resists->getThunder(),
					'dragon' => $resists->getDragon(),
				],
				// default to \stdClass to fix an empty array being returned instead of an empty object
				'attributes' => $entity->getAttributes() ?: new \stdClass(),
			];

			// region Slots Fields
			if ($projection->isAllowed('slots')) {
				$output['slots'] = array_map(function(Slot $slot): array {
					return [
						'rank' => $slot->getRank(),
					];
				}, $entity->getSlots()->toArray());
			}
			// endregion

			// region Skills Fields
			if ($projection->isAllowed('skills')) {
				$output['skills'] = array_map(function(SkillRank $rank) use ($projection): array {
					$output = [
						'id' => $rank->getId(),
						'slug' => $rank->getSlug(),
						'level' => $rank->getLevel(),
						'description' => $rank->getDescription(),
						'modifiers' => $rank->getModifiers() ?: new \stdClass(),
						'skill' => $rank->getSkill()->getId(),
						'skillName' => $rank->getSkill()->getName(),
					];

					if ($projection->isAllowed('skills.skill'))
						$output['skill'] = $rank->getSkill()->getId();

					if ($projection->isAllowed('skills.skillName'))
						$output['skillName'] = $rank->getSkill()->getName();

					return $output;
				}, $entity->getSkills()->toArray());
			}
			// endregion

			// region ArmorSet Fields
			if ($projection->isAllowed('armorSet')) {
				$armorSet = $entity->getArmorSet();

				if ($armorSet) {
					$output['armorSet'] = [
						'id' => $armorSet->getId(),
						'name' => $armorSet->getName(),
						'rank' => $armorSet->getRank(),
					];

					if ($projection->isAllowed('armorSet.pieces'))
						$output['armorSet']['pieces'] = array_map(function(Armor $armor): int {
							return $armor->getId();
						}, $armorSet->getPieces()->toArray());
				} else
					$output['armorSet'] = null;
			}
			// endregion

			// region Assets Fields
			if ($projection->isAllowed('assets')) {
				$assets = $entity->getAssets();

				if ($assets) {
					$output['assets'] = [];

					$transformer = function(?Asset $asset): ?string {
						return $asset ? $asset->getUri() : null;
					};

					if ($projection->isAllowed('assets.imageMale'))
						$output['assets']['imageMale'] = call_user_func($transformer, $assets->getImageMale());

					if ($projection->isAllowed('assets.imageFemale'))
						$output['assets']['imageFemale'] = call_user_func($transformer, $assets->getImageFemale());
				} else
					$output['assets'] = null;
			}
			// endregion

			// region Crafting Fields
			if ($projection->isAllowed('crafting')) {
				$crafting = $entity->getCrafting();

				if ($crafting) {
					$output['crafting'] = [];

					// region CraftingMaterialCost Fields
					if ($projection->isAllowed('crafting.materials')) {
						$output['crafting']['materials'] = array_map(
							function(CraftingMaterialCost $cost) use ($projection): array {
								$output = [
									'quantity' => $cost->getQuantity(),
								];

								// region Item Fields
								if ($projection->isAllowed('crafting.materials.item')) {
									$item = $cost->getItem();

									$output['item'] = [
										'id' => $item->getId(),
										'name' => $item->getName(),
										'description' => $item->getDescription(),
										'rarity' => $item->getRarity(),
										'carryLimit' => $item->getCarryLimit(),
										'value' => $item->getValue(),
									];
								}

								// endregion

								return $output;
							}, $crafting->getMaterials()->toArray()
						);
					}
					// endregion
				} else
					$output['crafting'] = null;
			}
			// endregion

			return $output;
		}
	}