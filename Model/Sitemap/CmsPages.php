<?php

namespace Fox\Seo\Model\Sitemap;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Raw;


class CmsPages
{
    /**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var \Magento\Cms\Api\Data\PageInterface
     */
    private $page;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @param PageRepositoryInterface $pageRepositoryInterface
     * @param PageInterface $pageInterface
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     */
    public function __construct(
        PageRepositoryInterface $pageRepositoryInterface,
        PageInterface $pageInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder
    )
    {
        $this->pageRepository = $pageRepositoryInterface;
        $this->page = $pageInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * @return \Magento\Cms\Api\Data\PageInterface[]
     */
    public function getCmsPages()
    {
        $this->searchCriteriaBuilder->addFilters(
            [
                $this->filterBuilder
                    ->setField('identifier')
                    ->setValue('no-route')
                    ->setConditionType('neq')
                    ->create()
            ]
        );

        return $this->pageRepository->getList($this->searchCriteriaBuilder->create())->getItems();
    }
}