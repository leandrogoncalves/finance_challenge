<?php


namespace App\Virtual\Models;


/**
 * @OA\Schema(
 *     title="Account",
 *     description="Account model",
 *     @OA\Xml(
 *         name="Account"
 *     )
 * )
 */
class Account
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
     *      title="Type",
     *      description="Type of the Account",
     *      example="common or shop"
     * )
     *
     * @var string
     */
    public $type;

    /**
     * @OA\Property(
     *      title="Document",
     *      description="document of the Account",
     * )
     *
     * @var string
     */
    public $document;

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

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Deleted at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $deleted_at;
}
