<?php
	namespace App\Game;

	final class Attribute {
		// -- General Attributes --
		const DEFENSE = 'defense';
		const HEALTH = 'health';
		const REQUIRED_GENDER = 'requiredGender';
		const STAMINA = 'stamina';

		// -- Skill Attribute Modifiers --
		const SHARP_BONUS = 'sharpnessBonus';
		const RES_ALL = 'resistAll';
		const DAM_FIRE = 'damageFire';
		const DAM_WATER = 'damageWater';
		const DAM_ICE = 'damageIce';
		const DAM_THUNDER = 'damageThunder';
		const DAM_DRAGON = 'damageDragon';

		// -- Weapon Attributes --
		const ATTACK = 'attack';
		const AFFINITY = 'affinity';
		const DAMAGE_TYPE = 'damageType';

		const ELDERSEAL = 'elderseal';

		// -- Insect Glaive Attributes --
		const IG_BOOST_TYPE = 'boostType';

		// -- Gunlance Attributes --
		const GL_SHELLING_TYPE = 'shellingType';

		// -- Switch Axe / Charge Blade Attributes --
		const PHIAL_TYPE = 'phialType';

		// -- Bow Attributes --
		const COATINGS = 'coatings';

		// -- Bowgun Attributes --
		const AMMO_CAPACITIES = 'ammoCapacities';
		const DEVIATION = 'deviation';
		const SPECIAL_AMMO = 'specialAmmo';

		// -- Armor Attributes --
		const RES_FIRE = 'resistFire';
		const RES_WATER = 'resistWater';
		const RES_THUNDER = 'resistThunder';
		const RES_ICE = 'resistIce';
		const RES_DRAGON = 'resistDragon';

		/**
		 * Attribute constructor.
		 */
		private function __construct() {
		}
	}