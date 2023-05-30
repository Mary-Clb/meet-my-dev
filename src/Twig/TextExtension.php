<?php 

namespace App\Twig;

use Twig\TwigFilter;
use App\Entity\Company;
use App\Entity\Developer;
use Twig\Extension\AbstractExtension;

class TextExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('truncate_words', [$this, 'truncateWords']),
            new TwigFilter('truncate', [$this, 'truncate']),
            new TwigFilter('instanceof', [$this, 'isInstanceOf']),
        ];
    }

    public function truncateWords($text, $limit)
    {
        $words = explode(' ', $text);
        $truncatedText = implode(' ', array_slice($words, 0, $limit));
        return $truncatedText ? $truncatedText  . "..." : "";
    }

    public function truncate($text, $limit){
        return $text ? substr($text, 0, $limit)  . "..." : "";
    }

    public function isInstanceOf($var, string $class){
        $class = "App\Entity\\$class";
        return $var instanceof $class;
    }
}