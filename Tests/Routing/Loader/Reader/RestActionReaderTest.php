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

/**
 * RestActionReader test.
 *
 */
class RestActionReaderTest extends \PHPUnit_Framework_TestCase
{

    public function setup()
    {
        $this->annotationReader = $this->getMockBuilder('Doctrine\Common\Annotations\Reader')
            ->disableOriginalConstructor()
            ->getMock();

        $this->paramReader = $this->getMockBuilder('FOS\RestBundle\Request\ParamReader')
            ->disableOriginalConstructor()
            ->getMock();

        $this->inflectorInterface = $this->getMockBuilder('FOS\RestBundle\Util\Inflector\InflectorInterface')
            ->disableOriginalConstructor()
            ->getMock();

    }

    protected function callGetMethodArguments($actionReader)
    {
        $reflectionClass = new \ReflectionClass(get_class($actionReader));
        $getMethodArguments = $reflectionClass->getMethod('getMethodArguments');
        $getMethodArguments->setAccessible(true);

        $method = new \ReflectionMethod('FOS\RestBundle\Tests\Fixtures\Controller\TypehintedController', 'parametersAction');

        return $getMethodArguments->invokeArgs($actionReader, array($method));

    }

    public function testGetMethodArguments()
    {
        $this->paramReader
            ->expects($this->once())
            ->method('getParamsFromMethod')
            ->will($this->returnValue(array()));

        $actionReader = new RestActionReader(
            $this->annotationReader, $this->paramReader, $this->inflectorInterface, ''
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
            $this->annotationReader, $this->paramReader, $this->inflectorInterface, ''
        );

        $this->assertCount(1, $this->callGetMethodArguments($actionReader));
    }

    public function testGetMethodArgumentsWithoutTypehint()
    {
        $this->paramReader
            ->expects($this->once())
            ->method('getParamsFromMethod')
            ->will($this->returnValue(array()));

        $actionReader = new RestActionReader(
            $this->annotationReader, $this->paramReader, $this->inflectorInterface, '', array(), true
        );

        $this->assertCount(1, $this->callGetMethodArguments($actionReader));
    }


}