<?php

/*
 * This file is part of the FOSRestBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\RestBundle\Tests\Routing\Loader\Reader;

use FOS\RestBundle\Routing\Loader\Reader\RestActionReader;
use FOS\RestBundle\Request\ParamReaderInterface;
use Doctrine\Common\Annotations\Reader;
use FOS\RestBundle\Inflector\InflectorInterface;


/**
 * RestActionReader test.
 *
 */
class RestActionReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * @var ParamReaderInterface
     */
    private $paramReader;

    /**
     * @var InflectorInterface
     */
    private $inflector;


    public function setup()
    {
        $this->annotationReader = $this->getMockBuilder(Reader::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->paramReader = $this->getMockBuilder(ParamReaderInterface::class)->getMock();


        $this->inflector = $this->getMockBuilder(InflectorInterface::class)->getMock();

    }

    protected function callGetMethodArguments($actionReader)
    {
        $reflectionClass = new \ReflectionClass(get_class($actionReader));
        $getMethodArguments = $reflectionClass->getMethod('getMethodArguments');
        $getMethodArguments->setAccessible(true);

        $method = new \ReflectionMethod('FOS\RestBundle\Tests\Fixtures\Controller\TypeHintedController', 'parametersAction');

        return $getMethodArguments->invokeArgs($actionReader, array($method));

    }

    public function testGetMethodArguments()
    {
        $this->paramReader
            ->expects($this->once())
            ->method('getParamsFromMethod')
            ->will($this->returnValue(array()));

        $actionReader = new RestActionReader(
            $this->annotationReader, $this->paramReader, $this->inflector, ''
        );

        $this->assertCount(2, $this->callGetMethodArguments($actionReader));
    }

    public function testGetMethodArgumentsWithParameters()
    {
        $this->paramReader
            ->expects($this->once())
            ->method('getParamsFromMethod')
            ->will($this->returnValue(array('parameter' => 1)));

        $actionReader = new RestActionReader(
            $this->annotationReader, $this->paramReader, $this->inflector, ''
        );

        $this->assertCount(1, $this->callGetMethodArguments($actionReader));
    }

    public function testGetMethodArgumentsWithoutTypeHint()
    {
        $this->paramReader
            ->expects($this->once())
            ->method('getParamsFromMethod')
            ->will($this->returnValue(array()));

        $actionReader = new RestActionReader(
            $this->annotationReader, $this->paramReader, $this->inflector, '', array(), true
        );

        $this->assertCount(1, $this->callGetMethodArguments($actionReader));
    }


}
