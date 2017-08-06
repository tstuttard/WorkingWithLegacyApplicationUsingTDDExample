<?php
/**
 * Created by PhpStorm.
 * User: thomasstuttard
 * Date: 06/08/2017
 * Time: 19:31
 */

namespace App\Acme;

class Customer
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $countryCode;
    /**
     * @var string
     */
    private $currencyCode;

    public function __construct(int $id, string $name, string $countryCode, string $currencyCode)
    {
        $this->id = $id;
        $this->name = $name;
        $this->countryCode = $countryCode;
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }
}
