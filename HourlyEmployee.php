<?php

require_once 'Employee.php';

class HourlyEmployee extends Employee {
    private float $hoursWorked;
    private float $rate;

    public function __construct(string $name, string $address, int $age, string $companyName, float $hoursWorked, float $rate) {
        parent::__construct($name, $address, $age, $companyName);
        $this->hoursWorked = $hoursWorked;
        $this->rate = $rate;
    }

    public function calculatePay(): float {
        return $this->hoursWorked * $this->rate;
    }

    public function getDetails(): string {
        return parent::getDetails() . "\nType     : Hourly Employee";
    }
}

?>
