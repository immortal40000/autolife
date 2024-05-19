<?php

namespace Autolife\Crm\UserFields;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Text\HtmlFilter;
use Bitrix\Main\UserField\Types\BaseType;
use CUserTypeManager;

Loc::loadLanguageFile(__FILE__);

class MyCustomFieldType extends BaseType
{
    public const
        USER_TYPE_ID = 'mycustomfield',
        DB_SEPARATOR = '|',
        RENDER_COMPONENT = 'autolife:field.mycustomfield';

    private const STRICT_FIELD_FORMAT = '/^\-?[0-9]+\.?[0-9]*\|[A-Z]{3}$/';
    private const LIGHT_FIELD_FORMAT = '/^\-?[0-9]+\.?[0-9]*(\|[A-Z]{3})?$/';

    public static function getDescription(): array
    {
        return [
            'DESCRIPTION' => 'Мой тип поля',
            'BASE_TYPE' => CUserTypeManager::BASE_TYPE_STRING,
        ];
    }

    /**
     * @return string
     */
    public static function getDbColumnType(): string
    {
        return 'MEDIUMTEXT';
    }

    public static function checkFields(array $userField, $value): array
    {
        $fieldName = HtmlFilter::encode(
            $userField['EDIT_FORM_LABEL'] ?: $userField['FIELD_NAME']
        );

        $result = [];
        return $result;
    }

    /**
     * @param array $userField
     * @param $value
     * @return string
     */
    public static function onBeforeSave(array $userField, $value): string
    {
        if ($value === '' || $value === null) {
            return '';
        }

        return strval($value);
    }

    /**
     * @param array $userField
     * @return array
     */
    public static function prepareSettings(array $userField): array
    {
        [$value, $currency] = static::unFormatFromDb($userField['SETTINGS']['DEFAULT_VALUE'] ?? null);
        if ($value !== '') {
            if ($currency === '') {
                $currency = CurrencyManager::getBaseCurrency();
            }
            $value = static::formatToDB($value, $currency);
        }

        return [
            'DEFAULT_VALUE' => $value,
        ];
    }

    /**
     * @param string $value
     * @param string|null $currency
     * @return string
     */
    public static function formatToDb(string $value, ?string $currency): string
    {
        if ($value === '') {
            return '';
        }

        $value = (string)((float)$value);
        $currency = trim((string)$currency);

        return $value . static::DB_SEPARATOR . $currency;
    }

    /**
     * @param string|null $value
     * @return array
     */
    public static function unFormatFromDb(?string $value): array
    {
        if ($value === null || $value === '') {
            return [
                '',
                '',
            ];
        }

        $result = explode(static::DB_SEPARATOR, $value);
        if (count($result) === 1) {
            $result[] = '';
        }

        return $result;
    }
}
