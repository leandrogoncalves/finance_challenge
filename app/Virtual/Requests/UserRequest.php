<?php


namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Store User request",
 *      description="Store User request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class UserRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new User",
     *      example="A nice User"
     * )
     *
     * @var string
     */
    public $fullname;

    /**
     * @OA\Property(
     *      title="type",
     *      description="Type of User",
     *      example="10"
     * )
     *
     * @var string
     */
    public $type;
}
