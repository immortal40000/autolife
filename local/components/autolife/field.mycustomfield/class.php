<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Component\BaseUfComponent;
use Autolife\Crm\UserFields\MyCustomFieldType;

class MyCustomFieldTypeUfComponent extends BaseUfComponent
{
	protected static function getUserTypeId(): string
	{
		return MyCustomFieldType::USER_TYPE_ID;
	}
}