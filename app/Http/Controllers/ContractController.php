<?php

namespace App\Http\Controllers;
use Model\Customer\CustomerRepository;

class ContractController extends Controller
{
    public function index($customer_id,$contract_id, CustomerRepository $customerRepository)
    {
        $customer = $customerRepository->get($customer_id,$contract_id);
        return view('contract.show', compact('customer'));
    }
}
