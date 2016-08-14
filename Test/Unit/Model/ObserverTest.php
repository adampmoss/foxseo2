<?php

namespace Fox\Seo\Test\Unit\Model;

use Fox\Seo\Model\Observer;

class ObserverTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Fox\Seo\Model\Observer
     */
    protected $observer;

    /**
     * @var \Magento\Framework\Event
     */
    protected $_categoryMock;

    public function setUp()
    {

        $this->helperAddress = $this->getMockBuilder('Fox\Seo\Helper\Data')
            ->disableOriginalConstructor()
            ->getMock();

        $this->productRepository = $this->getMockBuilder('Magento\Catalog\Api\ProductRepositoryInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->categoryRepository = $this->getMockBuilder('Magento\Catalog\Api\CategoryRepositoryInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->messageManager = $this->getMockBuilder('Magento\Framework\Message\ManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeManager = $this->getMockBuilder('Magento\Store\Model\StoreManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->responseInterface = $this->getMockBuilder('Magento\Framework\App\ResponseInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->url = $this->getMockBuilder('Magento\Framework\Url')
            ->disableOriginalConstructor()
            ->getMock();

        $this->config = $this->getMockBuilder('Magento\Framework\View\Page\Config')
            ->disableOriginalConstructor()
            ->getMock();

        $this->title = $this->getMockBuilder('Magento\Framework\View\Page\Title')
            ->disableOriginalConstructor()
            ->getMock();

        $this->registry = $this->getMockBuilder('Magento\Framework\Registry')
            ->disableOriginalConstructor()
            ->getMock();

        $this->observer = new Observer(
            $this->helperAddress,
            $this->productRepository,
            $this->categoryRepository,
            $this->messageManager,
            $this->storeManager,
            $this->responseInterface,
            $this->url,
            $this->config,
            $this->title,
            $this->registry
        );

        $this->categoryMock = $this->getMock(
            '\Magento\Catalog\Model\Category',
            ['getName', 'getData', 'getFoxseoHeading'],
            [],
            '',
            false
        );
    }

    /**
     * Get clean mock by class name
     *
     * @param string $className
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function _getCleanMock($className)
    {
        return $this->getMock($className, [], [], '', false);
    }

    protected function _preparationData()
    {
        $eventMock = $this
            ->getMockBuilder('Magento\Framework\Event')
            ->setMethods(
                [
                    'getCategory'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $eventMock->expects($this->once())
            ->method('getCategory')
            ->will($this->returnValue($this->categoryMock));

        $observerMock = $this->getMock('\Magento\Framework\Event\Observer', ['getEvent'], [], '', false);
        $observerMock->expects($this->once())
            ->method('getEvent')
            ->will($this->returnValue($eventMock));

        return $observerMock;

    }

	public function testCategorySeoHeadingReturnsSomethingWhenSet()
    {
        $this->categoryMock->expects($this->any())
            ->method('getFoxseoHeading')
            ->will($this->returnValue("Something"));

        $this->categoryMock->expects($this->any())
            ->method('getData')
            ->will($this->returnValue("Something Else"));

        $this->helperAddress->expects($this->once())
            ->method('getConfig')
            ->will($this->returnValue(true));

        $observer = $this->_preparationData();
        $this->assertEquals($this->observer->categorySeoHeading($observer), "Something");
    }
}