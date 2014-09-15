<?php

namespace HCLabs\Bills\Command\Handler;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommandValidationHandler implements CommandHandler
{
    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function handle($command)
    {
        $this->validator->validate($command);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($class)
    {
        return $this->validator->hasMetadataFor($class);
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return 255;
    }
}