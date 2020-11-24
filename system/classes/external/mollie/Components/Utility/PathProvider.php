<?php


namespace Mollie\Gambio\Utility;

/**
 * Class PathProvider
 *
 * @package Mollie\Gambio\Utility
 */
class PathProvider
{
    /**
     * Return template to the given filename
     *
     * @param string $fileName
     * @param string $subDir
     *
     * @return \ExistingFile
     */
    public static function getAdminTemplate($fileName, $subDir = null)
    {
        return new \ExistingFile(new \NonEmptyStringType(static::getAdminTemplatePath($fileName, $subDir)));
    }

    /**
     * Return path to the given filename name
     *
     * @param string $fileName
     * @param string $subDir
     *
     * @return string
     */
    public static function getAdminTemplatePath($fileName, $subDir = null)
    {
        $relativePath = static::getRelativePath($fileName, $subDir);

        return static::getAdminDir() . "html/content/mollie/$relativePath";
    }

    /**
     * Return path to the given filename name
     *
     * @param string $fileName
     * @param string $subDir
     *
     * @return string
     */
    public static function getShopTemplatePath($fileName, $subDir = null)
    {
        $relativePath = static::getRelativePath($fileName, $subDir);

        return static::getShopDir() . "Html/$relativePath";
    }

    /**
     * Return plugin admin directory
     *
     * @return string
     */
    public static function getAdminDir()
    {
        return DIR_FS_CATALOG . 'admin/';
    }

    /**
     * @param string $fileName
     * @param string|null $subDir
     *
     * @return string
     */
    private static function getRelativePath($fileName, $subDir)
    {
        return $subDir ? trim($subDir, '/') . '/' . $fileName : $fileName;
    }
}