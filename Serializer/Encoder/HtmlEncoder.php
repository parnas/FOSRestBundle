<?php

namespace FOS\RestBundle\Serializer\Encoder;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface,
    Symfony\Component\Serializer\Encoder\AbstractEncoder;

/*
 * This file is part of the FOS/RestBundle
 *
 * (c) Lukas Kahwe Smith <smith@pooteeweet.org>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Encodes HTML data
 *
 * @author Lukas Smith <smith@pooteeweet.org>
 */
class HtmlEncoder extends AbstractEncoder implements TemplatingAwareEncoderInterface
{
    protected $templating;
    protected $template;

    /**
     * {@inheritdoc}
     */
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplating()
    {
        return $this->templating;
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * {@inheritdoc}
     */
    public function encode($data, $format)
    {
        $template = $this->getTemplate();
        if (null === $template) {
            throw new \UnexpectedValueException('A template must be provided to encode to HTML');
        }

        return $this->templating->render($template, (array)$data);
    }

    /**
     * {@inheritdoc}
     * 
     * Remove when https://github.com/symfony/symfony/pull/576 is merged
     */
    public function decode($data, $format)
    {
        throw new \Exception('Decode is not implemented');
    }
}
