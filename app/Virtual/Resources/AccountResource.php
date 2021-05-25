<?php


namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="AccountResource",
 *     description="Account resource",
 *     @OA\Xml(
 *         name="AccountResource"
 *     )
 * )
 */
class AccountResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Account
     */
    private $data;
}
