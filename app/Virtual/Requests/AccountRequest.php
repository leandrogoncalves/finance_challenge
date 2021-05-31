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
     *      title="Name",
     *      description="Name of the new Account",
     *      example="A nice Account"
     * )
     *
     * @var string
     */
    public $fullname;


    /**
     * @OA\Property(
     *      title="CPF",
     *      description="Users CPF",
     *      example="common or shop"
     * )
     *
     * @var string
     */
    public $cpf;

    /**
     * @OA\Property(
     *      title="CNPJ",
     *      description="Shops CNPJ",
     *      example="common or shop"
     * )
     *
     * @var string
     */
    public $cnpj;

    /**
     * @OA\Property(
     *      title="shop name",
     *      description="shop name",
     * )
     *
     * @var string
     */
    public $shop_name;

    /**
     * @OA\Property(
     *      title="Email",
     *      description="Email of the Account",
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="Password",
     *      description="Password of the Account",
     * )
     *
     * @var string
     */
    public $password;
}
