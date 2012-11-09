<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2012
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


class ConditionalForms extends Frontend
{

	/**
	 * Do not check input on fields inside a non-enabled FormCondition group
	 *
	 * @param	Widget
	 * @param	int
	 * @param	array
	 * @return	Widget
	 * @link	http://www.contao.org/hooks.html#loadFormField
	 */
	public function loadFormField($objWidget, $formId, $arrForm)
	{
		// Activate field validation excemption
		if ($objWidget instanceof FormCondition && $objWidget->conditionType == 'start' && $this->Input->post($objWidget->name) == '')
		{
			$GLOBALS['FORM_CONDITION'] = true;
		}
		
		// Deactivate field validation exception
		elseif ($objWidget instanceof FormCondition && $objWidget->conditionType == 'stop')
		{
			$GLOBALS['FORM_CONDITION'] = false;
		}
		
		// Disable field validation inside FormCondition
		elseif (!($objWidget instanceof FormCondition) && $GLOBALS['FORM_CONDITION'] && $this->Input->post('FORM_SUBMIT') == $formId)
		{
			$objWidget->mandatory = false;
			$objWidget->rgxp = '';
		}
		
		return $objWidget;
	}
}
