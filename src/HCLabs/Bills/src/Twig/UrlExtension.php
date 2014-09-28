<?php

namespace HCLabs\Bills\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UrlExtension extends \Twig_Extension
{
    /** @var UrlGeneratorInterface */
    private $generator;

    /**
     * @param UrlGeneratorInterface $generator
     */
    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('path', [$this, 'getPath'])
        ];
    }

    /**
     * @param  string $route
     * @param  array  $parameters
     * @param  bool   $relative
     * @return string
     */
    public function getPath($route, array $parameters = [], $relative = false)
    {
        return $this->generator->generate(
            $route,
            $parameters,
            $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'url_helpers';
    }
}