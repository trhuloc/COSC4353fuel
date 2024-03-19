# Installing PHPUnit in WSL using `sudo apt`

This guide will walk you through the steps to install PHPUnit in Windows Subsystem for Linux (WSL) using the `sudo apt` command.

## Prerequisites

Before you begin, make sure you have the following prerequisites installed:

- WSL: Follow the official documentation to install WSL on your Windows machine.
- PHP: Install PHP in your WSL environment. You can use the package manager of your Linux distribution to install PHP.

## Step 1: Update Package Lists

Open your terminal in WSL and run the following command to update the package lists:
sudo apt update
## Step 2: Install PHPUnit

Once the package lists are updated, you can proceed to install PHPUnit. Run the following command to install PHPUnit:

sudo apt install phpunit

## Step 3: Verify PHPUnit Installation

After the installation is complete, you can verify that PHPUnit is installed correctly. Run the following command to check the PHPUnit version:

phpunit --version

If PHPUnit is installed successfully, you should see the version number displayed in the terminal.

## Step 4: Run UnitTest

phpunit ./tests

## Step 5: Install Xdebug to run Code Coverage

After the installation is complete you could run this command to generate the report

phpunit --coverage-html ./coverage ./tests

