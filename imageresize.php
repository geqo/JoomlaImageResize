<?php
/*
 *
 * Copyright © 2018 Alex White geqo.ru
 * Author: Alex White <dev@geqo.ru>
 * All rights reserved
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;

defined('_JEXEC') or die;

require __DIR__ . '/vendor/autoload.php';

/**
 * @package     ImageResize
 * @author      Alex White
 * @author      dev@geqo.ru
 */
class PlgContentImageResize extends CMSPlugin
{
	/**
	 * @var bool
	 */
	protected $autoloadLanguage = true;
	/**
	 * @var \Joomla\CMS\Application\CMSApplication
	 */
	protected $app;

	/**
	 * PlgContentImageResize constructor.
	 *
	 * @param   object  &$subject  The object to observe
	 * @param   array   $config    An optional associative array of configuration settings.
	 *                             Recognized key values include 'name', 'group', 'params', 'language'
	 *                             (this list is not meant to be comprehensive).
	 *
	 * @throws Exception
	 */
	public function __construct($subject, array $config = array())
	{
		$this->app = Factory::getApplication();
		parent::__construct($subject, $config);
	}

	/**
	 * @param $context
	 * @param $file object FileInfo from POST
	 * @param $isNew
	 *
	 * @return bool
	 */
	public function onContentAfterSave($context, $file, $isNew)
	{

		if ($context !== 'com_media.file') {
			return true;
		}

		if ($file->type !== 'image/png' && $file->type !== 'image/jpg') {
			return true;
		}

		$path = JPATH_SITE . '/images/';

		if ($this->params->get('make_thumbnail') == '1') {
			$small = $this->makeImage(
				$path,
				$file->filepath,
				$file->name,
				$this->params->get('thumbnail_width', 100)
			);
			if ($small) {
				$this->app->enqueueMessage(
					Text::_('PLG_CONTENT_IMAGERESIZE_SAVED_IN') . ' ' . $small
				);
			}
		}

		if ($this->params->get('make_medium') == '1') {
			$medium = $this->makeImage(
				$path,
				$file->filepath,
				$file->name,
				$this->params->get('medium_width', 300)
			);
			if ($medium) {
				$this->app->enqueueMessage(
					Text::_('PLG_CONTENT_IMAGERESIZE_SAVED_IN') . ' ' . $medium
				);
			}
		}

		if ($this->params->get('make_medium_large') == '1') {
			$mediumLarge = $this->makeImage(
				$path,
				$file->filepath,
				$file->name,
				$this->params->get('medium_large_width', 600)
			);
			if ($mediumLarge) {
				$this->app->enqueueMessage(
					Text::_('PLG_CONTENT_IMAGERESIZE_SAVED_IN') . ' ' . $mediumLarge
				);
			}
		}

		if ($this->params->get('make_large') == '1') {
			$large = $this->makeImage(
				$path,
				$file->filepath,
				$file->name,
				$this->params->get('large_width', 900)
			);
			if ($large) {
				$this->app->enqueueMessage(
					Text::_('PLG_CONTENT_IMAGERESIZE_SAVED_IN') . ' ' . $large
				);
			}
		}

		if ($this->params->get('drag_and_drop_enable') == '1') {
			$image = $this->makeImage(
				$path,
				$file->filepath,
				$file->name,
				$this->params->get('drag_and_drop_width', 900)
			);
			if ($image) {
				$file->filepath = $image;
			}
		}

		return true;
	}

	/**
	 * @param $path     string Path for images
	 * @param $filepath string Path to image
	 * @param $filename string Image name
	 * @param $width    string|int Image width
	 *
	 * @return bool|string
	 *
	 * @since version
	 */
	protected function makeImage($path, $filepath, $filename, $width)
	{
		$path = $this->createDir($path, 'resized/' . $width);
		$filename = $width . '_' . $filename;
		$imagick = new \PHPixie\Image();
		/** @var PHPixie\Image\Drivers\Driver\Resource $image */
		$image = $imagick->read($filepath);

		if ($this->params->get('ignore_sizes', '0') == 0) {
			if ($image->width() < $width) {
				return false;
			}
		}

		try {
			$image->resize((int)$width);
		} catch (Exception $e) {
			$this->app->enqueueMessage(Text::sprintf('PLG_CONTENT_IMAGERESIZE_WIDTH_ERROR', $width), 'error');
			return false;
		}

		$image->save($path . '/' . $filename);

		return $path . '/' . $filename;
	}

	/**
	 * @param $path
	 * @param $dir
	 *
	 * @return string
	 *
	 * @since version
	 */
	protected function createDir($path, $dir)
	{
		$path = rtrim($path, '/');
		$dir = trim($dir, '/');

		$fullPath = $path . '/' . $dir;

		if (file_exists($fullPath)) {
			return $fullPath . '/';
		}

		$dir = mkdir($fullPath, 0755, true);

		if (! $dir) {
			$fullPath = JPATH_SITE . '/images/';
		}

		return $fullPath;
	}
}