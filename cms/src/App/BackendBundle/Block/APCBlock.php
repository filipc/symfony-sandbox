<?php

/**
 * APCBlock class
 *
 *
 */
namespace App\BackendBundle\Block;

use App\GeneralBundle\Services\Stats\StatsInterface;
use Symfony\Component\Templating\EngineInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;

/**
 * Class for displaying admin dashboard block
 * with APC stats
 *
 * @package App\Backend
 */
class APCBlock extends BaseBlockService
{
    /**
     * APCStats service
     *
     * @var ApcStats
     */
    private $apcStats;

    /**
     * Constructor
     *
     * @param string          $name
     * @param EngineInterface $templating
     * @param StatsInterface  $apcStats
     */
    public function __construct($name, EngineInterface $templating, StatsInterface $apcStats)
    {
        parent::__construct($name, $templating);
        $this->apcStats = $apcStats;
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     * @param ErrorElement   $errorElement
     * @param BlockInterface $block
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     * @param  BlockContextInterface $block
     * @param  Response              $response
     * @return Response
     */
    public function execute(BlockContextInterface $block, Response $response = null)
    {
        $template = 'AppBackendBundle:Block:apc.block.html.twig';

        $response = $this->renderResponse($template, array('service' => $this->apcStats), $response);
        $response->setTtl($block->getSetting('ttl'));

        return $response;
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     * @param FormMapper     $formMapper
     * @param BlockInterface $block
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     * @return string
     */
    public function getName()
    {
        return 'APC Block';
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function getCacheKeys(BlockInterface $block)
    {
        return array(__CLASS__);
    }
}
