<?php

require_once 'EmployeeRoster.php';

class Main {
    private EmployeeRoster $roster;
    private int $size;
    private bool $repeat;

    public function start() {
        $this->clear();
        $this->repeat = true;

        $this->size = (int)readline("Enter the size of the roster: ");
        
        if ($this->size < 1) {
            echo "Invalid input. Please try again.\n";
            readline("Press \"Enter\" key to continue...");
            $this->start();
        } else {
            $this->roster = new EmployeeRoster($this->size);
            $this->entrance();
        }
    }

    private function entrance() {
        while ($this->repeat) {
            $this->clear();
            $this->menu();
            $choice = readline("Select option: ");
            
            switch ((int)$choice) {
                case 1:
                    $this->addMenu();
                    break;
                case 2:
                    $this->deleteMenu();
                    break;
                case 3:
                    $this->otherMenu();
                    break;
                case 0:
                    $this->repeat = false;
                    break;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" key to continue...");
            }
        }
        echo "Process terminated.\n";
    }

    private function menu() {
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    private function addMenu() {
        $name = readline("Enter name: ");
        $address = readline("Enter address: ");
        $age = (int)readline("Enter age: ");
        $companyName = readline("Enter company name: ");

        $this->empType($name, $address, $age, $companyName);
    }

    private function empType($name, $address, $age, $companyName) {
        $this->clear();
        echo "--- Employee Type ---\n";
        echo "[1] Commission Employee\n";
        echo "[2] Hourly Employee\n";
        echo "[3] Piece Worker\n";
        $type = (int)readline("Select type of Employee: ");

        switch ($type) {
            case 1:
                $this->addOnsCE($name, $address, $age, $companyName);
                break;
            case 2:
                $this->addOnsHE($name, $address, $age, $companyName);
                break;
            case 3:
                $this->addOnsPE($name, $address, $age, $companyName);
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                $this->empType($name, $address, $age, $companyName);
        }
    }

    private function addOnsCE($name, $address, $age, $companyName) {
        $regularSalary = (float)readline("Enter regular salary: ");
        $itemSold = (int)readline("Enter items sold: ");
        $commissionRate = (float)readline("Enter commission rate: ");

        $employee = new CommissionEmployee($name, $address, $age, $companyName, $regularSalary, $itemSold, $commissionRate);
        $this->roster->add($employee);
        $this->repeat();
    }

    private function addOnsHE($name, $address, $age, $companyName) {
        $hoursWorked = (float)readline("Enter hours worked: ");
        $rate = (float)readline("Enter rate per hour: ");

        $employee = new HourlyEmployee($name, $address, $age, $companyName, $hoursWorked, $rate);
        $this->roster->add($employee);
        $this->repeat();
    }

    private function addOnsPE($name, $address, $age, $companyName) {
        $numberItems = (int)readline("Enter number of items: ");
        $wagePerItem = (float)readline("Enter wage per item: ");

        $employee = new PieceWorker($name, $address, $age, $companyName, $numberItems, $wagePerItem);
        $this->roster->add($employee);
        $this->repeat();
    }

    private function deleteMenu() {
        $this->clear();
        echo "*** List of Employees on the current Roster ***\n";
        $this->roster->display();
        
        $employeeNumber = (int)readline("\nEnter the employee number to delete (or 0 to return): ");
        if ($employeeNumber > 0) {
            $this->roster->remove($employeeNumber - 1); // assuming 1-indexed for user
            echo "Employee removed.\n";
        }
        readline("Press \"Enter\" key to continue...");
    }

    private function otherMenu() {
        $this->clear();
        echo "[1] Display Employees\n";
        echo "[2] Count Employees\n";
        echo "[3] Payroll\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->displayMenu();
                break;
            case 2:
                $this->countMenu();
                break;
            case 3:
                $this->roster->payroll();
                readline("Press \"Enter\" key to continue...");
                break;
            case 0:
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                $this->otherMenu();
        }
    }

    private function displayMenu() {
        $this->clear();
        echo "[1] Display All Employees\n";
        echo "[2] Display Commission Employees\n";
        echo "[3] Display Hourly Employees\n";
        echo "[4] Display Piece Workers\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->roster->display();
                break;
            case 2:
                $this->roster->displayCE();
                break;
            case 3:
                $this->roster->displayHE();
                break;
            case 4:
                $this->roster->displayPE();
                break;
            case 0:
                return;
            default:
                echo "Invalid Input!";
        }
        readline("Press \"Enter\" key to continue...");
    }

    private function countMenu() {
        $this->clear();
        echo "[1] Count All Employees\n";
        echo "[2] Count Commission Employees\n";
        echo "[3] Count Hourly Employees\n";
        echo "[4] Count Piece Workers\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                echo "Total Employees: " . $this->roster->count() . "\n";
                break;
            case 2:
                echo "Commission Employees: " . $this->roster->countCE() . "\n";
                break;
            case 3:
                echo "Hourly Employees: " . $this->roster->countHE() . "\n";
                break;
            case 4:
                echo "Piece Workers: " . $this->roster->countPE() . "\n";
                break;
            case 0:
                return;
            default:
                echo "Invalid Input!";
        }
        readline("Press \"Enter\" key to continue...");
    }

    private function clear() {
        // Change 'cls' to 'clear' on UNIX/Linux
        system('cls');
    }

    private function repeat() {
        echo "Employee Added!\n";
        if ($this->roster->count() < $this->size) {
            $c = readline("Add more? (y to continue): ");
            if (strtolower($c) == 'y') {
                $this->addMenu();
            } else {
                $this->entrance();
            }
        } else {
            echo "Roster is Full\n";
            readline("Press \"Enter\" key to continue...");
        }
    }
}

$entry = new Main();
$entry->start();

?>
