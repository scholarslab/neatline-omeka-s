<?php
namespace Neatline\Site\BlockLayout;

use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Entity\SitePageBlock;
use Omeka\Api\Exception\NotFoundException;
use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Omeka\Stdlib\ErrorStore;
use Laminas\Form\Element;
use Laminas\View\Renderer\PhpRenderer;

class NeatlineExhibit extends AbstractBlockLayout
{
    public function getLabel()
    {
        return 'Neatline Exhibit'; // @translate
    }

    public function form(PhpRenderer $view, SiteRepresentation $site,
    SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null)
    {
        $neatlineExhibits = $view->api()
            ->search('neatline_exhibits')
            ->getContent();
        $formElements = new Element\Select('o:block[__blockIndex__][o:data][neatline_exhibit]');
        $valueOptions = [];
        foreach ($neatlineExhibits as $neatlineExhibit) {
            $valueOptions[$neatlineExhibit->id()] = $neatlineExhibit->title();
        }
        $formSelectedValue = $block ? $block->dataValue('neatline_exhibit') : '';
        $formElements->setEmptyOption('Select exhibit');
        $formElements->setValueOptions($valueOptions)->setValue($formSelectedValue);

        return $view->partial('common/block-layout/neatline-exhibit-form', [
            'formElements' => $formElements,
        ]);

        // return $view->formSelect($formElements);

    }

    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
        return $view->partial('common/block-layout/neatline-exhibit', [
          'block' => $block,
          'exhibit_id' => $block->dataValue('neatline_exhibit')
        ]);
    }
}
