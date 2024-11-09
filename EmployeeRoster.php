<?php

require_once 'Employee.php';
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class EmployeeRoster {
    private array $roster;
    private int $size;

    public function __construct(int $size) {
        $this->size = $size;
        $this->roster = [];
    }

    public function add(Employee $employee) {
        if (count($this->roster) < $this->size) {
            $this->roster[] = $employee;
            echo "Employee added successfully.\n";
        } else {
            echo "Roster is full. Cannot add more employees.\n";
        }
    }

    public function remove(int $index) {
        if (isset($this->roster[$index])) {
            unset($this->roster[$index]);
            $this->roster = array_values($this->roster); // Re-index the array
            echo "Employee removed successfully.\n";
        } else {
            echo "Invalid employee index.\n";
        }
    }

    public function display() {
        foreach ($this->roster as $index => $employee) {
            echo "[" . ($index + 1) . "] " . $employee->getDetails() . "\n";
        }
    }

    public function displayCE() {
        $this->displayByType(CommissionEmployee::class);
    }

    public function displayHE() {
        $this->displayByType(HourlyEmployee::class);
    }

    public function displayPE() {
        $this->displayByType(PieceWorker::class);
    }

    private function displayByType(string $type) {
        foreach ($this->roster as $index => $employee) {
            if ($employee instanceof $type) {
                echo "[" . ($index + 1) . "] " . $employee->getDetails() . "\n";
            }
        }
    }

    public function count() {
        return count($this->roster);
    }

    public function countCE() {
        return $this->countByType(CommissionEmployee::class);
    }

    public function countHE() {
        return $this->countByType(HourlyEmployee::class);
    }

    public function countPE() {
        return $this->countByType(PieceWorker::class);
    }

    private function countByType(string $type) {
        return count(array_filter($this->roster, fn($e) => $e instanceof $type));
    }

    public function payroll() {
        foreach ($this->roster as $employee) {
            echo $employee->getDetails() . " - Pay: " . $employee->calculatePay() . "\n";
        }
    }
}

?>
