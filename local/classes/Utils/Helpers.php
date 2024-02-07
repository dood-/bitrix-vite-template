<?php

declare(strict_types=1);

namespace Local\Utils;

use Bitrix\Main\Application;
use CBitrixComponentTemplate;
use CIBlock;

final class Helpers
{
    private function __construct()
    {
    }

    public static function renderSvgSprite(
        string $name,
        string $width = '24',
        string $height = '24',
        string $class = '',
        string $path = '/local/assets/icons.svg'
    ): string {
        $fullPath = Application::getDocumentRoot() . $path;

        if (file_exists($fullPath) && ($lastChanged = filemtime($fullPath))) {
            $url = "$path?$lastChanged#$name";
        } else {
            $url = "$path#$name";
        }

        return '<i class="svg-icon' . " $class" . '" aria-hidden="true">'
            . '<svg width="' . $width . '" height="' . $height . '">'
            . '<use xlink:href="' . $url . '"></use>'
            . '</svg>'
            . '</i>';
    }

    public static function addActionButtons(CBitrixComponentTemplate $template, array $item): void
    {
        $template->AddEditAction(
            $item['ID'],
            $item['EDIT_LINK'],
            CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_EDIT')
        );
        $template->AddDeleteAction(
            $item['ID'],
            $item['DELETE_LINK'],
            CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_DELETE'),
            ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]
        );
    }

    public static function renderPreviewImage(array $item, string $class = ''): ?string
    {
        if (is_array($item['PREVIEW_PICTURE'])) {
            $picture = $item['PREVIEW_PICTURE'];
        } elseif (is_array($item['DETAIL_PICTURE'])) {
            $picture = $item['DETAIL_PICTURE'];
        } else {
            return null;
        }

        $title = $picture['TITLE'] ?: $item['NAME'];
        $alt = $picture['ALT'] ?: $item['NAME'];
        $src = $picture['SRC'];

        return '<img class="' . $class . '" src="' . $src . '" alt="' . $alt . '" title="' . $title . '" loading="lazy"/>';
    }
}
