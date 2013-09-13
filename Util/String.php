<?php
namespace Tz\BlogBundle\Util;

class String
{

    /**
     * Normalizes string.
     *
     * @param string $tag Tagname.
     *
     * @return string
     */
    public static function normalize($tag)
    {
        $upperCases = array(
            'Ä',
            'Ü',
            'Ö'
        );
        $lowerCases = array(
            'ä',
            'ü',
            'ö'
        );
        $lower = str_replace($upperCases, $lowerCases, $tag);
        $newTag = preg_replace('/[^a-zA-Z0-9üöäßÜÖÄ-]/', '', $lower);
        return trim(mb_strtolower($newTag, 'UTF-8'));
    }

    /**
     * Cleans for url.
     *
     * @param string $url Url part.
     *
     * @return string
     */
    public static function cleanForUrl($url)
    {
        $specialChar = array(
            ' ', // 1
            '"', // 2
            'ü', // 3
            'Á', // 4
            'Ä', // 5
            'ä', // 6
            'â', // 7
            'ó', // 8
            'é', // 9
            'è', // 10
            'ä', // 11
            'â', // 12
            'ß', // 13
            'Ö', // 14
            'ö', // 15
            'ê'
        ); // 17
        $newChar = array(
            '-', // 1
            '', // 2
            'ue', // 3
            'a', // 4
            'ae', // 5
            'ae', // 6
            'a', // 7
            'o', // 8
            'e', // 9
            'e', // 10
            'ae', // 11
            'ae', // 12
            'ss', // 13
            'oe', // 14
            'oe', // 15
            'e'
        ); // 17


        $url = str_replace($specialChar, $newChar, $url);
        return strtolower(self::normalize($url));
    }
}


