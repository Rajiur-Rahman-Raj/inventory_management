<?php

$arr = [
    "Company_Dashboard" => [
        "Dashboard" => [
            'permission' => [
                'view' => ['user.home'],
                'add' => [],
                'edit' => [],
                'delete' => [],
            ],
        ],
    ],

//	"Manage_Companies" => [
//		"Companies" => [
//			'permission' => [
//				'view' => ['user.companyList'],
//				'add' => ['user.createCompany', 'user.companyStore'],
//				'edit' => ['user.companyEdit', 'user.companyUpdate'],
//				'delete' => ['user.deleteCompany'],
//				'switch' => ['user.activeCompany', 'user.inactiveCompany', 'user.companyActive'],
//			],
//		],
//	],

    "Manage_Employees" => [
        "Employee_List" => [
            'permission' => [
                'view' => ['user.employeeList', 'user.employeeDetails'],
                'add' => ['user.createEmployee', 'user.employeeStore'],
                'edit' => ['user.employeeEdit', 'user.employeeUpdate'],
                'delete' => ['user.employeeDelete'],
            ],
        ],
        "Salary_List" => [
            'permission' => [
                'view' => ['user.employeeSalaryList'],
                'add' => ['user.addEmployeeSalary'],
                'edit' => ['user.employeeSalaryEdit'],
                'delete' => ['user.employeeSalaryDelete'],
            ],
        ],
    ],
    "Manage_Suppliers" => [
        "Suppliers" => [
            'permission' => [
                'view' => ['user.suppliers', 'user.supplierDetails'],
                'add' => ['user.createSupplier', 'user.supplierStore'],
                'edit' => ['user.supplierEdit', 'user.supplierUpdate'],
                'delete' => ['user.deleteSupplier'],
            ],
        ],
    ],
    "Manage_Sales_Center" => [
        "Sales_Center" => [
            'permission' => [
                'view' => ['user.salesCenterList', 'user.salesCenterDetails'],
                'add' => ['user.createSalesCenter', 'user.storeSalesCenter'],
                'edit' => ['user.salesCenterEdit', 'user.updateSalesCenter'],
                'delete' => ['user.deleteSalesCenter'],
            ],
        ],
    ],
//	"Manage_Customers" => [
//		"Customers" => [
//			'permission' => [
//				'view' => ['user.customerList', 'user.customerDetails'],
//				'edit' => ['user.customerEdit', 'user.customerUpdate'],
//				'add' => ['user.createCustomer', 'user.customerStore'],
//				'delete' => ['user.deleteCustomer'],
//			],
//		],
//	],
    "Manage_Raw_Items" => [
        "Item_List" => [
            'permission' => [
                'view' => ['user.rawItemList'],
                'add' => ['user.rawItemStore'],
                'edit' => ['user.updateRawItem'],
                'delete' => ['user.deleteRawItem'],
            ],
        ],
        "Purchase" => [
            'permission' => [
                'add' => ['user.purchaseRawItem', 'user.storePurchaseItem'],
            ],
        ],
        "Purchase_History" => [
            'permission' => [
                'view' => ['user.purchaseRawItemList', 'user.rawItemPurchaseDetails'],
            ],
        ],
        "Stock_List" => [
            'permission' => [
                'view' => ['user.purchaseRawItemStocks'],
            ],
        ],
    ],
    "Manage_Items" => [
        "Items" => [
            'permission' => [
                'view' => ['user.itemList'],
                'add' => ['user.itemStore'],
                'edit' => ['user.updateItem'],
                'delete' => ['user.deleteItem'],
            ],
        ],
    ],

    "Manage_Stocks" => [
        "Stock_List" => [
            'permission' => [
                'view' => ['user.stockList', 'user.stockDetails'],
            ],
        ],
        "Stock_In" => [
            'permission' => [
                'add' => ['user.addStock', 'user.stockStore'],
            ],
        ],
        "Stock_Transfer" => [
            'permission' => [
                'add' => ['user.stockTransfer', 'user.storeStockTransfer'],
            ],
        ],
        "Stock_Transfer_List" => [
            'permission' => [
                'view' => ['user.stockTransferList', 'user.stockTransferDetails'],
            ],
        ],
    ],

    "Manage_Sales" => [
        "Sales_List" => [
            'permission' => [
                'view' => ['user.salesList', 'user.salesDetails', 'user.salesInvoice'],
//				'return' => ['user.returnSales', 'user.returnSalesOrder', 'user.salesInvoiceUpdate', 'user.salesOrderUpdate'],
            ],
        ],
//		"Sales_Item" => [
//			'permission' => [
//				'view' => ['user.salesItem'],
//				'add' => ['user.salesOrderStore'],
//			],
//		],
    ],

    'Manage_Wastage' => [
        "Wastage" => [
            'permission' => [
                'view' => ['user.wastageList'],
                'add' => ['user.wastageStore'],
                'delete' => ['user.deleteWastage'],
            ],
        ],
    ],

    'Manage_Stock_Missing' => [
        "Stock_Missing" => [
            'permission' => [
                'view' => ['user.stockMissingList'],
                'add' => ['user.stockMissingStore'],
                'delete' => ['user.stockMissingDelete'],
            ],
        ],
    ],

    'Manage_Affiliate' => [
        "Affiliate" => [
            'permission' => [
                'view' => ['user.affiliateMemberList', 'user.affiliateMemberDetails'],
                'add' => ['user.createAffiliateMember', 'user.affiliateMemberStore'],
                'edit' => ['user.affiliateMemberEdit', 'user.affiliateMemberUpdate'],
                'delete' => ['user.affiliateMemberDelete'],
            ],
        ],
    ],

    'Manage_Expense' => [
        "Expense_Category" => [
            'permission' => [
                'view' => ['user.expenseCategory'],
                'add' => ['user.expenseCategoryStore'],
                'edit' => ['user.updateExpenseCategory'],
                'delete' => ['user.deleteExpenseCategory'],
            ],
        ],
        "Expense_List" => [
            'permission' => [
                'view' => ['user.expenseList'],
                'add' => ['user.expenseListStore'],
                'edit' => ['user.updateExpenseList'],
                'delete' => ['user.deleteExpenseList'],
            ],
        ],
    ],

    'Manage_Reports' => [
        "Purchase_Report" => [
            'permission' => [
                'view' => ['user.purchaseReports'],
                'export' => ['user.export.purchaseReports'],
            ],
        ],
        "Purchase_Payment_Report" => [
            'permission' => [
                'view' => ['user.purchasePaymentReports'],
                'export' => ['user.export.purchasePaymentReports'],
            ],
        ],
        "Stock_Report" => [
            'permission' => [
                'view' => ['user.stockReports'],
                'export' => ['user.export.stockReports'],
            ],
        ],
        "Sales_Report" => [
            'permission' => [
                'view' => ['user.salesReports'],
                'export' => ['user.export.salesReports'],
            ],
        ],
        "Sales_Payment_Report" => [
            'permission' => [
                'view' => ['user.salesPaymentReports'],
                'export' => ['user.export.salesPaymentReports'],
            ],
        ],
        "Wastage_Report" => [
            'permission' => [
                'view' => ['user.wastageReports'],
                'export' => ['user.export.wastageReports'],
            ],
        ],
        "Stock_Missing_Report" => [
            'permission' => [
                'view' => ['user.wastageReports'],
                'export' => ['user.export.wastageReports'],
            ],
        ],
        "Affiliation_Report" => [
            'permission' => [
                'view' => ['user.affiliateReports'],
                'export' => ['user.export.affiliateReports'],
            ],
        ],
        "Expense_Report" => [
            'permission' => [
                'view' => ['user.expenseReports'],
                'export' => ['user.export.expenseReports'],
            ],
        ],
        "Salary_Report" => [
            'permission' => [
                'view' => ['user.expenseReports'],
                'export' => ['user.export.expenseReports'],
            ],
        ],
        "Profit_And_Loss_Report" => [
            'permission' => [
                'view' => ['user.profitLossReports'],
                'export' => ['user.export.profitLossReports'],
            ],
        ],
    ],

    'Manage_Role_And_Permissions' => [
        "Available_Roles" => [
            'permission' => [
                'view' => ['user.role'],
                'add' => ['user.createRole', 'user.roleStore'],
                'edit' => ['user.editRole', 'user.roleUpdate'],
                'delete' => ['user.deleteRole'],
            ],
        ],
        "Manage_Staff" => [
            'permission' => [
                'view' => ['user.role.staff'],
                'add' => ['user.role.usersCreate'],
                'edit' => ['user.role.usersEdit', 'user.role.statusChange'],
                'delete' => [],
            ],
        ],
    ],
];

return $arr;
