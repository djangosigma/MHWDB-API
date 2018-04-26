<?php
	namespace App\Controller;

	use App\Entity\Charm;
	use App\Entity\CharmRank;
	use App\Entity\SkillRank;
	use DaybreakStudios\DozeBundle\ResponderService;
	use DaybreakStudios\Utility\DoctrineEntities\EntityInterface;
	use Symfony\Bridge\Doctrine\RegistryInterface;
	use Symfony\Component\Routing\RouterInterface;

	class CharmsDataController extends AbstractDataController {
		/**
		 * CharmsDataController constructor.
		 *
		 * @param RegistryInterface $doctrine
		 * @param ResponderService  $responder
		 * @param RouterInterface   $router
		 */
		public function __construct(RegistryInterface $doctrine, ResponderService $responder, RouterInterface $router) {
			parent::__construct($doctrine, $responder, $router, Charm::class);
		}

		/**
		 * @param EntityInterface|Charm|null $charm
		 *
		 * @return array|null
		 */
		protected function normalizeOne(?EntityInterface $charm): ?array {
			if (!$charm)
				return null;

			return [
				'id' => $charm->getId(),
				'slug' => $charm->getSlug(),
				'name' => $charm->getName(),
				'ranks' => array_map(function(CharmRank $rank): array {
					return [
						'name' => $rank->getName(),
						'level' => $rank->getLevel(),
						'skills' => array_map(function(SkillRank $skillRank): array {
							return [
								'id' => $skillRank->getId(),
								'slug' => $skillRank->getSlug(),
								'level' => $skillRank->getLevel(),
								'description' => $skillRank->getDescription(),
								'skill' => $skillRank->getSkill()->getId(),
								'skillName' => $skillRank->getSkill()->getName(),
								'modifiers' => $skillRank->getModifiers(),
							];
						}, $rank->getSkills()->toArray()),
					];
				}, $charm->getRanks()->toArray()),
			];
		}
	}