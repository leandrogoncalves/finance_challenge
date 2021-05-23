<?php


namespace App\Virtual\collections;


/**
 * @OA\Schema(
 *     title="UserCollection",
 *     description="User collection",
 *     @OA\Xml(
 *         name="UserCollection"
 *     )
 * )
 */
class UserCollection
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\User[]
     */
    private $data;
}
