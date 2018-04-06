<?php
	namespace App\Scraping\Scrapers\Helpers;

	class SpriteMap {
		/**
		 * @var resource
		 */
		protected $image;

		/**
		 * @var int
		 */
		protected $imageWidth;

		/**
		 * @var int
		 */
		protected $imageHeight;

		/**
		 * SpriteMap constructor.
		 *
		 * @param string $filename
		 */
		public function __construct(string $filename) {
			$this->image = imagecreatefrompng($filename);

			$this->imageWidth = imagesx($this->image);
			$this->imageHeight = imagesy($this->image);
		}

		/**
		 * @param int $x
		 * @param int $y
		 * @param int $width
		 * @param int $height
		 *
		 * @return resource
		 */
		public function get(int $x, int $y, int $width, int $height) {
			return imagecrop($this->image, [
				'x' => abs($x),
				'y' => abs($y),
				'width' => $width,
				'height' => $height,
			]);
		}
	}