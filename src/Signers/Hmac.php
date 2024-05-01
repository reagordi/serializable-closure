<?php
/**
 * Reagordi Component
 *
 * @link https://reagordi.com/
 * @copyright Copyright (c) 2023 Sergej Rufov
 * @license https://dev.reagordi.com/license
 */

declare(strict_types=1);

namespace Reagordi\Component\SerializableClosure\Signers;

use Reagordi\Contracts\SerializableClosure\Signer;

class Hmac implements Signer
{
    /**
     * The secret key.
     *
     * @var string
     */
    protected string $secret;

    /**
     * Creates a new signer instance.
     *
     * @param string $secret
     * @return void
     */
    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * Sign the given serializable.
     *
     * @param string $serializable
     * @return array
     */
    public function sign(string $serializable): array
    {
        return [
            'serializable' => $serializable,
            'hash' => base64_encode(hash_hmac('sha256', $serializable, $this->secret, true)),
        ];
    }

    /**
     * Verify the given signature.
     *
     * @param array $signature
     * @return bool
     */
    public function verify(array $signature): bool
    {
        return hash_equals(base64_encode(
            hash_hmac('sha256', $signature['serializable'], $this->secret, true)
        ), $signature['hash']);
    }
}
