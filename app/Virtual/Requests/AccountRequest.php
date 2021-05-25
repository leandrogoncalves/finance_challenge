<?php


namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Store Account request",
 *      description="Store Account request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class AccountRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new Account",
     *      example="A nice Account"
     * )
     *
     * @var string
     */
    public $fullname;

    /**
     * @OA\Property(
     *      title="type",
     *      description="Type of Account",
     *      example="10"
     * )
     *
     * @var string
     */
    public $type;
}
