<?php
namespace AppBundle\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Doctrine\Common\Cache\Cache;

class MarkdownTransformer {
  private $markdownParser;
  private $cache;
  
  public function __construct(MarkdownParserInterface $markdownParser,Cache $cache) {
    $this->markdownParser = $markdownParser;
    $this->cache = $cache;
  }

  public function parse($str){
    $cache = $this->cache;
    $key = md5($str);
    if ($cache->contains($key)) {
      return $cache->fetch($key);
    }
    
    $str = $this->markdownParser
      ->transformMarkdown($str);
    $cache->save($key, $str);
    return $str;
    
  }
}
