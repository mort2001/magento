<?php

declare(strict_types=1);

namespace Laminas\Feed\Writer\Renderer\Entry;

use DateTime;
use DOMDocument;
use DOMElement;
use Laminas\Feed\Uri;
use Laminas\Feed\Writer;
use Laminas\Feed\Writer\Renderer;

use function array_key_exists;
use function ctype_digit;

class Rss extends Renderer\AbstractRenderer implements Renderer\RendererInterface
{
    public function __construct(Writer\Entry $container)
    {
        parent::__construct($container);
    }

    /**
     * Render RSS entry
     *
     * @return $this
     */
    public function render()
    {
        $this->dom                     = new DOMDocument('1.0', $this->container->getEncoding());
        $this->dom->formatOutput       = true;
        $this->dom->substituteEntities = false;
        $entry                         = $this->dom->createElement('item');
        $this->dom->appendChild($entry);

        $this->_setTitle($this->dom, $entry);
        $this->_setDescription($this->dom, $entry);
        $this->_setDateCreated($this->dom, $entry);
        $this->_setDateModified($this->dom, $entry);
        $this->_setLink($this->dom, $entry);
        $this->_setId($this->dom, $entry);
        $this->_setAuthors($this->dom, $entry);
        $this->_setEnclosure($this->dom, $entry);
        $this->_setCommentLink($this->dom, $entry);
        $this->_setCategories($this->dom, $entry);
        foreach ($this->extensions as $ext) {
            $ext->setType($this->getType());
            $ext->setRootElement($this->getRootElement());
            $ext->setDomDocument($this->getDomDocument(), $entry);
            $ext->render();
        }

        return $this;
    }

    // phpcs:disable PSR2.Methods.MethodDeclaration.Underscore

    /**
     * Set entry title
     *
     * @return void
     * @throws Writer\Exception\InvalidArgumentException
     */
    protected function _setTitle(DOMDocument $dom, DOMElement $root)
    {
        if (
            ! $this->getDataContainer()->getDescription()
            && ! $this->getDataContainer()->getTitle()
        ) {
            $message   = 'RSS 2.0 entry elements SHOULD contain exactly one'
                . ' title element but a title has not been set. In addition, there'
                . ' is no description as required in the absence of a title.';
            $exception = new Writer\Exception\InvalidArgumentException($message);
            if (! $this->ignoreExceptions) {
                throw $exception;
            } else {
                $this->exceptions[] = $exception;
                return;
            }
        }
        $title = $dom->createElement('title');
        $root->appendChild($title);
        $text = $dom->createTextNode($this->getDataContainer()->getTitle());
        $title->appendChild($text);
    }

    /**
     * Set entry description
     *
     * @return void
     * @throws Writer\Exception\InvalidArgumentException
     */
    protected function _setDescription(DOMDocument $dom, DOMElement $root)
    {
        if (
            ! $this->getDataContainer()->getDescription()
            && ! $this->getDataContainer()->getTitle()
        ) {
            $message   = 'RSS 2.0 entry elements SHOULD contain exactly one'
                . ' description element but a description has not been set. In'
                . ' addition, there is no title element as required in the absence'
                . ' of a description.';
            $exception = new Writer\Exception\InvalidArgumentException($message);
            if (! $this->ignoreExceptions) {
                throw $exception;
            } else {
                $this->exceptions[] = $exception;
                return;
            }
        }
        if (! $this->getDataContainer()->getDescription()) {
            return;
        }
        $subtitle = $dom->createElement('description');
        $root->appendChild($subtitle);
        $text = $dom->createCDATASection($this->getDataContainer()->getDescription());
        $subtitle->appendChild($text);
    }

    /**
     * Set date entry was last modified
     *
     * @return void
     */
    protected function _setDateModified(DOMDocument $dom, DOMElement $root)
    {
        if (! $this->getDataContainer()->getDateModified()) {
            return;
        }

        $updated = $dom->createElement('pubDate');
        $root->appendChild($updated);
        $text = $dom->createTextNode(
            $this->getDataContainer()->getDateModified()->format(DateTime::RSS)
        );
        $updated->appendChild($text);
    }

    /**
     * Set date entry was created
     *
     * @return void
     */
    protected function _setDateCreated(DOMDocument $dom, DOMElement $root)
    {
        if (! $this->getDataContainer()->getDateCreated()) {
            return;
        }
        if (! $this->getDataContainer()->getDateModified()) {
            $this->getDataContainer()->setDateModified(
                $this->getDataContainer()->getDateCreated()
            );
        }
    }

    /**
     * Set entry authors
     *
     * @return void
     */
    protected function _setAuthors(DOMDocument $dom, DOMElement $root)
    {
        $authors = $this->container->getAuthors();
        if (! $authors || empty($authors)) {
            return;
        }
        foreach ($authors as $data) {
            $author = $this->dom->createElement('author');
            $name   = $data['name'];
            if (array_key_exists('email', $data)) {
                $name = $data['email'] . ' (' . $data['name'] . ')';
            }
            $text = $dom->createTextNode($name);
            $author->appendChild($text);
            $root->appendChild($author);
        }
    }

    /**
     * Set entry enclosure
     *
     * @return void
     * @throws Writer\Exception\InvalidArgumentException
     */
    protected function _setEnclosure(DOMDocument $dom, DOMElement $root)
    {
        $data = $this->container->getEnclosure();
        if (! $data || empty($data)) {
            return;
        }
        if (! isset($data['type'])) {
            $exception = new Writer\Exception\InvalidArgumentException('Enclosure "type" is not set');
            if (! $this->ignoreExceptions) {
                throw $exception;
            } else {
                $this->exceptions[] = $exception;
                return;
            }
        }
        if (! isset($data['length'])) {
            $exception = new Writer\Exception\InvalidArgumentException('Enclosure "length" is not set');
            if (! $this->ignoreExceptions) {
                throw $exception;
            } else {
                $this->exceptions[] = $exception;
                return;
            }
        }
        if ((int) $data['length'] < 0 || ! ctype_digit((string) $data['length'])) {
            $exception = new Writer\Exception\InvalidArgumentException(
                'Enclosure "length" must be an integer indicating the content\'s length in bytes'
            );
            if (! $this->ignoreExceptions) {
                throw $exception;
            }

            $this->exceptions[] = $exception;
            return;
        }
        $enclosure = $this->dom->createElement('enclosure');
        $enclosure->setAttribute('type', $data['type']);
        $enclosure->setAttribute('length', (string) $data['length']);
        $enclosure->setAttribute('url', $data['uri']);
        $root->appendChild($enclosure);
    }

    /**
     * Set link to entry
     *
     * @return void
     */
    protected function _setLink(DOMDocument $dom, DOMElement $root)
    {
        if (! $this->getDataContainer()->getLink()) {
            return;
        }
        $link = $dom->createElement('link');
        $root->appendChild($link);
        $text = $dom->createTextNode($this->getDataContainer()->getLink());
        $link->appendChild($text);
    }

    /**
     * Set entry identifier
     *
     * @return void
     */
    protected function _setId(DOMDocument $dom, DOMElement $root)
    {
        if (
            ! $this->getDataContainer()->getId()
            && ! $this->getDataContainer()->getLink()
        ) {
            return;
        }

        $id = $dom->createElement('guid');
        $root->appendChild($id);
        if (! $this->getDataContainer()->getId()) {
            $this->getDataContainer()->setId(
                $this->getDataContainer()->getLink()
            );
        }
        $text = $dom->createTextNode($this->getDataContainer()->getId());
        $id->appendChild($text);

        $uri = Uri::factory($this->getDataContainer()->getId());
        if (! $uri->isValid() || ! $uri->isAbsolute()) {
            /** @see http://www.rssboard.org/rss-profile#element-channel-item-guid */
            $id->setAttribute('isPermaLink', 'false');
        }
    }

    /**
     * Set link to entry comments
     *
     * @return void
     */
    protected function _setCommentLink(DOMDocument $dom, DOMElement $root)
    {
        $link = $this->getDataContainer()->getCommentLink();
        if (! $link) {
            return;
        }
        $clink = $this->dom->createElement('comments');
        $text  = $dom->createTextNode($link);
        $clink->appendChild($text);
        $root->appendChild($clink);
    }

    /**
     * Set entry categories
     *
     * @return void
     */
    protected function _setCategories(DOMDocument $dom, DOMElement $root)
    {
        $categories = $this->getDataContainer()->getCategories();
        if (! $categories) {
            return;
        }
        foreach ($categories as $cat) {
            $category = $dom->createElement('category');
            if (isset($cat['scheme'])) {
                $category->setAttribute('domain', $cat['scheme']);
            }
            $text = $dom->createCDATASection($cat['term']);
            $category->appendChild($text);
            $root->appendChild($category);
        }
    }

    // phpcs:enable PSR2.Methods.MethodDeclaration.Underscore
}
