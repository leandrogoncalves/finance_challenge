<?php


namespace App\Virtual\collections;


/**
 * @OA\Schema(
 *     title="AccountCollection",
 *     description="Account collection",
 *     @OA\Xml(
 *         name="AccountCollection"
 *     )
 * )
 */
class AccountCollection
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Account[]
     */
    private $data;
}
