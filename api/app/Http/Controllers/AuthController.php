<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Interface\Service\AccountServiceInterface;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Interface\Service\AdministratorServiceInterface;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Interface\Service\CustomerServiceInterface;
use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Interface\Service\SupplierServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{   
    private AccountServiceInterface $accountService;
    private AdministratorServiceInterface $adminService;
    private CustomerServiceInterface $customerService;
    private SupplierServiceInterface $supplierService;

    public function __construct(AccountServiceInterface $accountService, AdministratorServiceInterface $adminService, CustomerServiceInterface $customerService, SupplierServiceInterface $supplierService)
    {
        $this->accountService = $accountService;
        $this->adminService = $adminService;
        $this->customerService = $customerService;
        $this->supplierService = $supplierService;
    }
    
    public function register(Request $request): JsonResponse
    {   
        $result = new \stdClass();
        // Decode the request content as JSON
        $requestJSON = $request->json()->all();
        // Create a record in the account table
        $resultAccount = $this->accountService->createAccount($request);
        
        // Append the account id to the result object
        $result->accountID = $resultAccount->accountID;
        // Merge request data into the result object
        foreach ($requestJSON as $key => $value) {
            $result->$key = $value;
        }

        // Check if the account type is administrator
        if ($request->input('accTypeID') == 1) {
        
            // Create administrator record
            $resultAdmin = $this->adminService->createAdmin($result);

            // Add adminId on the result
            $result->adminID = $resultAdmin->adminID;

            // Return the result as a JSON response
            return response()->json($result, 200);
        } elseif ($request->input('accTypeID') == 2) {
            $result->cstrStatus = 'active';

            $resultCustomer = $this->customerService->createCustomer($result);

            $result->customerID = $resultCustomer->customerID;

            return response()->json($result, 200);

        } elseif ($request->input('accTypeID') == 3) {
           
            $result->supplierStatus = 'active';
            $resultSupplier =  $this->supplierService->createSupplier($result);

            $result->supplierID = $resultSupplier->supplierID;

            return response()->json($result, 200);

        } else {
            // Handle cases where account type ID is invalid or missing
            return response()->json(['error' => 'Invalid account type'], 400);
        }
    }
}
