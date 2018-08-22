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

defined('_JEXEC') or die;

class JFormFieldTest extends JFormField
{
	protected $type = 'test';

	public function getInput()
	{
		$gmagick = $imagick = $gd = false;
		$html = '';

		if (extension_loaded('imagick')) {
			$imagick = JText::_('PLG_CONTENT_TEST_PASS');
		}

		if (extension_loaded('gd')) {
			$gd = JText::_('PLG_CONTENT_TEST_PASS');
		}

		if (extension_loaded('gmagick')) {
			$gmagick = JText::_('PLG_CONTENT_TEST_PASS');
		}

		if ($gmagick === false && $imagick === false && $gd === false) {
			$html .= '<div class="alert alert-error">' . JText::_('PLG_CONTENT_IMAGERESIZE_FULLTEST_FAIL') . '</div>';
		}

		$html .= '<div class="span6">';
		$html .= '<div class="row"><div class="span3">GD: </div><div class="span3'. ($gd?' text-success':' text-error') .'">' . ($gd?:JText::_('PLG_CONTENT_TEST_FAIL')) . '</div></div>';
		$html .= '<div class="row"><div class="span3">Imagick: </div><div class="span3'. ($imagick?' text-success':' text-error') .'">' . ($imagick?:JText::_('PLG_CONTENT_TEST_FAIL')) . '</div></div>';
		$html .= '<div class="row"><div class="span3">Gmagick: </div><div class="span3'. ($gmagick?' text-success':' text-error') .'">' . ($gmagick?:JText::_('PLG_CONTENT_TEST_FAIL')) . '</div></div>';
		$html .= '</div>';

		return $html;
	}
}