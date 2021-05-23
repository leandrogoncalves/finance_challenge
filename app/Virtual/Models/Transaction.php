<?php


namespace App\Virtual\Models;


/**
 * @OA\Schema(
 *     title="Transaction",
 *     description="Transaction model",
 *     @OA\Xml(
 *         name="Transaction"
 *     )
 * )
 */
class Transaction
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Payee",
     *      description="Payee of the  Transaction",
     *      example="2"
     * )
     *
     * @var string
     */
    public $payee;


    /**
     * @OA\Property(
     *      title="payer",
     *      description="Payer the Transaction",
     *      example="1"
     * )
     *
     * @var string
     */
    public $payer;

    /**
     * @OA\Property(
     *      title="Value",
     *      description="value of the Transaction",
     * )
     *
     * @var string
     */
    public $value;

    /**
     * @OA\Property(
     *      title="Status",
     *      description="Status of the Transaction",
     * )
     *
     * @var string
     */
    public $status;


    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

}
