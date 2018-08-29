<?php
/*
    This file is part of ImageResize plugin

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.
    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

*/

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

defined('_JEXEC') or die;

class JFormFieldMessage extends FormField
{
	protected $type = 'message';

	public function getInput()
	{
		$plugin = PluginHelper::getPlugin('content', 'imageresize');
		$params = new Registry($plugin->params);
		$enabled = $params->get('messages', 1);

		if (1 !== (int) $enabled) {
			return Text::_('PLG_CONTENT_IMAGERESIZE_MESSAGE');
		}

		return $this->getMessage();
	}

	protected function getMessage()
	{
		$message = Text::_('PLG_CONTENT_IMAGERESIZE_MESSAGE');
		$lang    = Factory::getLanguage();
		$tag     = $lang->getTag();
		$url     = 'http://geqo.ru/joomla/plg_content_imageresize/messages.php?lang=' . $tag;

		if (extension_loaded('curl')) {
			return $this->getMessageByCURL($url);
		}

		$remote = $this->getMessageByFileGetContents($url);

		if ($remote) {
			return $remote;
		}

		return $message;
	}

	protected function getMessageByCURL($url)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}

	protected function getMessageByFileGetContents($url)
	{
		$message = file_get_contents($url);
		return $message;
	}
}