<?php

require_once 'EmployeeRoster.php';

class InvalidOptionException extends Exception {}

class Main {
    private EmployeeRoster $roster;
    private int $size;
    private bool $repeat;

    public function start() {
        $this->clear();
        $this->repeat = true;

        echo "*** Welcome to Employee Roster System ***\n";
        $this->size = (int)readline("Please enter the size of the roster: ");
        
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
    
        
            if (!ctype_digit($choice)) {
                echo "Invalid input. Please enter a number.\n";
                readline("Press \"Enter\" key to continue...");
                continue; 
            }
    
            try {
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
                        echo "System Exit...\n";
                        exit;
                        break;
                    default:
                        throw new InvalidOptionException("Invalid input. Please try again.");
                }
            } catch (InvalidOptionException $e) {
                echo $e->getMessage() . "\n";
                readline("Press \"Enter\" key to continue...");
            }
        }
    
        echo "System Exit...\n";
        exit;
    }
    


    private function menu() {
        $this->clear();
        echo "Available Space: " . $this->roster->availableSpace() . "\n";
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    private function addMenu() {
        $this->clear();
        echo "--- Employee Detail ---\n";
        $name = readline("Enter name: ");
        $address = readline("Enter address: ");
        
    
        while (true) {
            $ageInput = readline("Enter age: ");
            if (ctype_digit($ageInput) && (int)$ageInput >= 18) {
                $age = (int)$ageInput;
                break; 
            } else {
                echo "Invalid age. Please enter a positive number and a legal age.\n";
            }
        }
    
        $companyName = readline("Enter company name: ");
        $this->empType($name, $address, $age, $companyName);
    }
    

    

    private function empType($name, $address, $age, $companyName) {
        echo "--- Employee Type ---\n";
        echo "[1] Commission Employee\n";
        echo "[2] Hourly Employee\n";
        echo "[3] Piece Worker\n";
        $type = (int)readline("Select type of Employee: ");

        try {
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
                    throw new InvalidOptionException("Invalid input. Please try again.");
            }
        } catch (InvalidOptionException $e) {
            echo $e->getMessage() . "\n";
            readline("Press \"Enter\" key to continue...");
            $this->empType($name, $address, $age, $companyName);
        }
    }

    private function addOnsCE($name, $address, $age, $companyName) {
        
        while (true) {
            $salaryInput = readline("Enter regular salary: ");
            if (is_numeric($salaryInput) && (float)$salaryInput > 0) {
                $regularSalary = (float)$salaryInput;
                break;
            } else {
                echo "Invalid input. Please enter a positive number for regular salary.\n";
            }
        }
    
        while (true) {
            $itemsSoldInput = readline("Enter items sold: ");
            if (ctype_digit($itemsSoldInput) && (int)$itemsSoldInput >= 0) {
                $itemSold = (int)$itemsSoldInput;
                break;
            } else {
                echo "Invalid input. Please enter a non-negative integer for items sold.\n";
            }
        }
    
        while (true) {
            $commissionRateInput = readline("Enter commission rate (e.g., 0.1 for 10%): ");
        if (is_numeric($commissionRateInput) && (float)$commissionRateInput >= 0 && (float)$commissionRateInput <= 1) {
            $commissionRate = (float)$commissionRateInput;
            break;
        } else {
            echo "Invalid input. Please enter a number between 0 and 1 for the commission rate.\n";
        }
        }
    
        $employee = new CommissionEmployee($name, $address, $age, $companyName, $regularSalary, $itemSold, $commissionRate);
        $this->roster->add($employee);
        $this->repeat();
    }
    



    private function addOnsHE($name, $address, $age, $companyName) {
    
        while (true) {
            $hoursWorkedInput = readline("Enter hours worked: ");
            if (is_numeric($hoursWorkedInput) && (float)$hoursWorkedInput > 0) {
                $hoursWorked = (float)$hoursWorkedInput;
                break;
            } else {
                echo "Invalid input. Please enter a positive number for hours worked.\n";
            }
        }
    
    
        while (true) {
            $rateInput = readline("Enter rate per hour: ");
            if (is_numeric($rateInput) && (float)$rateInput > 0) {
                $rate = (float)$rateInput;
                break;
            } else {
                echo "Invalid input. Please enter a positive number for the rate per hour.\n";
            }
        }
    
        $employee = new HourlyEmployee($name, $address, $age, $companyName, $hoursWorked, $rate);
        $this->roster->add($employee);
        $this->repeat();
    }
    

    

    private function addOnsPE($name, $address, $age, $companyName) {
    
        while (true) {
            $numberItemsInput = readline("Enter number of items: ");
            if (is_numeric($numberItemsInput) && (float)$numberItemsInput > 0) {
                $numberItems = (float)$numberItemsInput;
                break;
            } else {
                echo "Invalid input. Please enter a positive number for number items.\n";
            }
        }
    
    
        while (true) {
            $wagePerItemInput = readline("Enter number of wage per item: ");
            if (is_numeric(  $wagePerItemInput) && (float)  $wagePerItemInput > 0) {
                $wagePerItem = (float)  $wagePerItemInput;
                break;
            } else {
                echo "Invalid input. Please enter a positive number for the rate per hour.\n";
            }
        }
    
        $employee = new PieceWorker($name, $address, $age, $companyName, $numberItems, $wagePerItem);
        $this->roster->add($employee);
        $this->repeat();
    }

    
    private function deleteMenu() {
        $this->clear();
        echo "*** List of Employees on the current Roster ***\n";
        $this->roster->display();
    
        try {
            $employeeNumber = (int)readline("\n Enter the employee number to delete (or 0 to return): ");
    
            if ($employeeNumber !== 0) {
                if (!$this->roster->exists($employeeNumber - 1)) {
                    throw new Exception("Error: Employee does not exist.");
                }
    
                $this->roster->remove($employeeNumber - 1);
                echo "\nEmployee successfully removed.\n";
    
                if ($this->roster->count() === 0) {
                    echo "No more employees left.\n";
                    readline("Press \"Enter\" key to return to the main menu.");
                    $this->entrance();
                    return;
                }
    
                $confirm = strtolower(readline("Press \"y\" key to continue removing or any other key to return to the main menu: "));
                if ($confirm === 'y') {
                    $this->deleteMenu(); 
                } else {
                    $this->entrance(); 
                }
            } else {
                $this->entrance(); 
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            readline("Press \"Enter\" key to continue...");
            $this->deleteMenu();
        }
    }
    

    private function otherMenu() {
        $this->clear();
        echo "[1] Display Employees\n";
        echo "[2] Count Employees\n";
        echo "[3] Payroll\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        try {
            switch ($choice) {
                case 1:
                    $this->displayMenu();
                    break;
                case 2:
                    $this->countMenu();
                    break;
                case 3:
                    $this->roster->payroll();
                    break;
                case 0:
                    $this->entrance();
                    break;
                default:
                    throw new InvalidOptionException("Invalid input. Please try again.");
            }
        } catch (InvalidOptionException $e) {
            echo $e->getMessage() . "\n";
            readline("Press \"Enter\" key to continue...");
            $this->otherMenu();
        }
        readline("Press \"Enter\" key to continue...");
        $this->otherMenu();
    }

    private function displayMenu() {
        $this->clear();
        echo "[1] Display All Employees\n";
        echo "[2] Display Commission Employees\n";
        echo "[3] Display Hourly Employees\n";
        echo "[4] Display Piece Workers\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        try {
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
                    return $this->otherMenu();
                default:
                    throw new InvalidOptionException("Invalid input. Please try again.");
            }
        } catch (InvalidOptionException $e) {
            echo $e->getMessage() . "\n";
            readline("Press \"Enter\" key to continue...");
            $this->displayMenu();
        }
        readline("Press \"Enter\" key to continue...");
        $this->displayMenu();
    }

    private function countMenu() {
        $this->clear();
        echo "[1] Count All Employees\n";
        echo "[2] Count Commission Employees\n";
        echo "[3] Count Hourly Employees\n";
        echo "[4] Count Piece Workers\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        try {
            switch ($choice) {
                case 1:
                    echo $this->roster->count() . "\n";
                    break;
                case 2:
                    echo  $this->roster->countCE() . "\n";
                    break;
                case 3:
                    echo  $this->roster->countHE() . "\n";
                    break;
                case 4:
                    echo  $this->roster->countPE() . "\n";
                    break;
                case 0:
                    return $this->otherMenu();
                default:
                    throw new InvalidOptionException("Invalid input. Please try again.");
            }
        } catch (InvalidOptionException $e) {
            echo $e->getMessage() . "\n";
            readline("Press \"Enter\" key to continue...");
            $this->countMenu();
        }
        readline("Press \"Enter\" key to continue...");
        $this->countMenu();
    }

    private function clear() {
        echo "\033[2J\033[;H";
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
