<?php

namespace Reagordi\Component\SerializableClosure;

use Reagordi\Component\SerializableClosure\Serializers\Signed;
use Reagordi\Component\SerializableClosure\Signers\Hmac;
use Reagordi\Contracts\SerializableClosure\InvalidSignatureException;
use Reagordi\Contracts\SerializableClosure\Serializable;
use Closure;

class SerializableClosure implements Serializable
{
    /**
     * The closure's serializable.
     *
     * @var ?Serializable
     */
    protected ?Serializable $serializable;

    /**
     * Creates a new serializable closure instance.
     *
     * @param  \Closure  $closure
     * @return void
     */
    public function __construct(Closure $closure)
    {
        $this->serializable = Serializers\Signed::$signer
            ? new Serializers\Signed($closure)
            : new Serializers\Native($closure);
    }

    /**
     * Resolve the closure with the given arguments.
     *
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return call_user_func_array($this->serializable, func_get_args());
    }

    /**
     * Gets the closure.
     *
     * @return Closure
     */
    public function getClosure(): Closure
    {
        return $this->serializable->getClosure();
    }

    /**
     * Create a new unsigned serializable closure instance.
     *
     * @param  Closure  $closure
     * @return UnsignedSerializableClosure
     */
    public static function unsigned(Closure $closure): UnsignedSerializableClosure
    {
        return new UnsignedSerializableClosure($closure);
    }

    /**
     * Sets the serializable closure secret key.
     *
     * @param string|null $secret
     * @return void
     */
    public static function setSecretKey(?string $secret): void
    {
        Serializers\Signed::$signer = $secret
            ? new Hmac($secret)
            : null;
    }

    /**
     * Sets the serializable closure secret key.
     *
     * @param \Closure|null $transformer
     * @return void
     */
    public static function transformUseVariablesUsing(?Closure $transformer): void
    {
        Serializers\Native::$transformUseVariables = $transformer;
    }

    /**
     * Sets the serializable closure secret key.
     *
     * @param \Closure|null $resolver
     * @return void
     */
    public static function resolveUseVariablesUsing(?Closure $resolver): void
    {
        Serializers\Native::$resolveUseVariables = $resolver;
    }

    /**
     * Get the serializable representation of the closure.
     *
     * @return array
     */
    public function __serialize()
    {
        return [
            'serializable' => $this->serializable,
        ];
    }

    /**
     * Restore the closure after serialization.
     *
     * @param array $data
     * @return void
     *
     * @throws InvalidSignatureException
     */
    public function __unserialize(array $data)
    {
        if (Signed::$signer && ! $data['serializable'] instanceof Signed) {
            throw new InvalidSignatureException();
        }

        $this->serializable = $data['serializable'];
    }
}
