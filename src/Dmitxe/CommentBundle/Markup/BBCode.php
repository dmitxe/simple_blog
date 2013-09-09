<?php

namespace Dmutxe\CommentBundle\Markup;

use FOS\CommentBundle\Markup\ParserInterface;
use HTMLPurifier;
require_once 'StringParser_BBCode/StringParser/BBCode.php';
//use Dmutxe\CommentBundle\Markup\StringParser_BBCode;

class BBCode implements ParserInterface
{
    private $parser;
    private $purifier;

    public function __construct(HtmlPurifier $purifier)
    {
        $this->purifier = $purifier;
    }

    /**
     * @return \StringParser_BBCode
     */
    protected function getParser()
    {
        if (null === $this->parser) {
            $parser = new \StringParser_BBCode();
            $parser->setRootParagraphHandling(true);

            /**
             * Bold
             *
             * [b][/b] -> <b></b>
             */
            $parser->addCode('b', 'simple_replace', null, array(
                'start_tag' => '<b>',
                'end_tag' => '</b>'
            ), 'inline', array('listitem', 'block', 'inline', 'link'), array());

            /**
             * Italics
             *
             * [i][/i] -> <i></i>
             */
            $parser->addCode('i', 'simple_replace', null, array(
                'start_tag' => '<i>',
                'end_tag' => '</i>'
            ), 'inline', array('listitem', 'block', 'inline', 'link'), array());

            $this->parser = $parser;
        }

        return $this->parser;
    }

    /**
     * Takes a markup string and returns raw html.
     *
     * @param string $raw
     *
     * @return string
     */
    public function parse($raw)
    {
        $raw = $this->purifier->purify($raw);

        return $this->getParser()->parse($raw);
    }
}