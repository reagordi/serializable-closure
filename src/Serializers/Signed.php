<?php

namespace Reagordi\Component\SerializableClosure\Serializers;

use Reagordi\Contracts\SerializableClosure\MissingSecretKeyException;
use Reagordi\Contracts\SerializableClosure\InvalidSignatureException;
use Reagordi\Contracts\SerializableClosure\Serializable;
use Closure;
use Reagordi\Contracts\SerializableClosure\Signer;

class Signed implements Serializable
{
    /**
     * The signer that will sign and verify the closure's signature.
     *
     * @var Signer|null
     */
    public static ?Signer $signer;

    /**
     * The closure to be serialized/unserialized.
     *
     * @var Closure
     */
    protected Closure $closure;

    /**
     * Creates a new serializable closure instance.
     *
     * @param  Closure  $closure
     * @return void
     */
    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * Resolve the closure with the given arguments.
     *
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return call_user_func_array($this->closure, func_get_args());
    }

    /**
     * Gets the closure.
     *
     * @return Closure
     */
    public function getClosure(): Closure
    {
        return $this->closure;
    }

    /**
     * Get the serializable representation of the closure.
     *
     * @return array
     * @throws MissingSecretKeyException
     */
    public function __serialize()
    {
        if (! static::$signer) {
            throw new MissingSecretKeyException();
        }

        return static::$signer->sign(
            serialize(new Native($this->closure))
        );
    }

    /**
     * Restore the closure after serialization.
     *
     * @param array $signature
     * @return void
     *
     * @throws InvalidSignatureException
     */
    public function __unserialize(array $signature)
    {
        if (static::$signer && ! static::$signer->verify($signature)) {
            throw new InvalidSignatureException();
        }

        /** @var Serializable $serializable */
        $serializable = unserialize($signature['serializable']);

        $this->closure = $serializable->getClosure();
    }
}
