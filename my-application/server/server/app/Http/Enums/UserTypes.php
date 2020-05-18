<?php
namespace App\Http\Enums;

class UserType
{
    private $name = null;
    public function __construct($n = null)
    {
        $this->name = $n;
    }



    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
