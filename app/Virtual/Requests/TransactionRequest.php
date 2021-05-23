<?php


namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Store Transaction request",
 *      description="Store Transaction request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class TransactionRequest
{
    /**
     * @OA\Property(
     *      title="payer",
     *      description="payer of the transaction",
     *      example="2"
     * )
     *
     * @var string
     */
    public $payer;

    /**
     * @OA\Property(
     *      title="payee",
     *      description="payee of the transaction",
     *      example="2"
     * )
     *
     * @var string
     */
    public $payee;

    /**
     * @OA\Property(
     *      title="value",
     *      description="Value of the Transaction",
     *      example="100.50"
     * )
     *
     * @var string
     */
    public $value;
}
