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

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

class JFormFieldTest extends FormField
{
	protected $type = 'test';

	public function getInput()
	{
		$gmagick = $imagick = $gd = false;

		if (extension_loaded('imagick')) {
			$imagick = Text::_('PLG_CONTENT_TEST_PASS');
		}

		if (extension_loaded('gd')) {
			$gd = Text::_('PLG_CONTENT_TEST_PASS');
		}

		if (extension_loaded('gmagick')) {
			$gmagick = Text::_('PLG_CONTENT_TEST_PASS');
		}

		$html  = '<div class="span6">';
		$html .= '<div class="row"><div class="span3">GD: </div><div class="span3'. ($gd?' text-success':' text-error') .'">' . ($gd?:Text::_('PLG_CONTENT_TEST_FAIL')) . '</div></div>';
		$html .= '<div class="row"><div class="span3">Imagick: </div><div class="span3'. ($imagick?' text-success':' text-error') .'">' . ($imagick?:Text::_('PLG_CONTENT_TEST_FAIL')) . '</div></div>';
		$html .= '<div class="row"><div class="span3">Gmagick: </div><div class="span3'. ($gmagick?' text-success':' text-error') .'">' . ($gmagick?:Text::_('PLG_CONTENT_TEST_FAIL')) . '</div></div>';
		$html .= '</div>';

		return $html;
	}
}