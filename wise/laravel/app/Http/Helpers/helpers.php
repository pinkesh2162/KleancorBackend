<?php


function leftMenu()
{

  $arr = [

    [
      'text' => 'Dashboard',
      'url' => route('dashboard'),
    ],
    [
      'text' => 'Invoice',
      'url' => '#',
      'icon' => 'reply',
      'submenu' => [
        [
          'text' => 'Invoice',
          'url' => route('invoice.index'),
        ],
        [
          'text' => 'New Invoice',
          'url' => route('invoice.new'),
        ],
        [
          'text' => 'Due Invoice',
          'url' => route('invoice.due'),
        ],
        [
          'text' => 'Print Invoice Report',
          'url' => route('invoice.partial'),
        ],
        [
          'text' => 'New Top Sheet',
          'url' => route('invoice.top_sheet'),
        ],
        [
          'text' => 'New Custom Top Sheet',
          'url' => route('invoice.custom_top_sheet'),
        ],
        [
          'text' => 'All Top Sheet',
          'url' => route('invoice.top_sheet_all'),
        ],
        /*
    [
      'text' => 'Project Invoice',
      'url' => route('invoice-pro'),
    ],
    [
      'text' => 'New Project Invoice',
      'url' => route('invoice-pro.new'),
    ],
    [
      'text' => 'Due Project Invoice',
      'url' => route('invoice-pro.due'),
    ],
    */
      ],
    ],
    [
      'text' => 'Transactions',
      'url' => '#',
      'icon' => 'reply',
      'submenu' => [
        [
          'text' => 'New Credit',
          'url' => route('transaction.new-deposit'),

        ],
        [
          'text' => 'New Debit',
          'url' => route('transaction.new-expense'),
        ],
        [
          'text' => 'Transfer',
          'url' => route('transaction.transfer'),
        ],
        [
          'text' => 'Employee Cash Receive',
          'url' => route('transaction.employee-credit'),

        ],
        [
          'text' => 'Employee Expenses',
          'url' => route('transaction.employee-debit'),
        ],
        [
          'text' => 'Employee Balance Sheet',
          'url' => route('transaction.employee-balance-sheet'),
        ],
        [
          'text' => 'Balance Sheet',
          'url' => route('transaction.balancesheet'),
        ],
      ],
    ],
    [
      'text' => 'Additional Products',
      'url' => '#',
      'icon' => 'reply',
      'submenu' => [
        [
          'text' => 'Add Products',
          'url' => route('addproduct.index'),

        ],
        [
          'text' => 'View Product',
          'url' => route('addproduct.view'),
        ],

        [
          'text' => 'Add Stock Out',
          'url' => route('stockout.index'),

        ],
        [
          'text' => 'View Stock Out',
          'url' => route('stockout.view'),
        ],

      ],
    ],
    [
      'text' => 'Products',
      'url' => '#',
      'icon' => 'reply',
      'submenu' => [
        [
          'text' => 'Add Products',
          'url' => route('product.index'),
        ],
        [
          'text' => 'Active Product',
          'url' => route('product.view'),
        ],

      ],
    ],
    [
      'text' => 'Damages',
      'url' => '#',
      'icon' => 'reply',
      'submenu' => [
        [
          'text' => 'Add Damages',
          'url' => route('damage.index'),
        ],
        [
          'text' => 'View Damages',
          'url' => route('damage.view'),
        ],

      ],
    ],
    [
      'text' => 'Users',
      'url' => '#',
      'icon' => 'reply',
      'can' => [2],
      'submenu' => [
        [
          'text' => 'Add  User',
          'url' => route('adminregister'),

        ],
        [
          'text' => 'Active Users',
          'url' => route('allusers'),
        ],
        [
          'text' => 'Frozen Users',
          'url' => route('frozenuser'),
        ],
      ],
    ],
    [
      'text' => 'Personal Expenses',
      'url' => '#',
      'icon' => 'reply',
      'can' => [2],
      'submenu' => [
        [
          'text' => 'Add  Expenses',
          'url' => route('insertexpenses'),

        ],
        [
          'text' => 'View Expenses',
          'url' => route('viewexpenses'),
        ],
      ],
    ],
    [
      'text' => 'Daily Attendance',
      'url' => '#',
      'icon' => 'reply',
      'submenu' => [
        [
          'text' => 'Add  Attendance',
          'url' => route('attendance.index'),

        ],
        [
          'text' => 'Add  Overtime',
          'url' => route('attendance.overtime'),

        ],
        [
          'text' => 'Search Attendance',
          'url' => route('attendance.view'),
        ],
      ],
    ],
    [
      'text' => 'Employees',
      'url' => '#',
      'icon' => 'reply',
      'submenu' => [
        [
          'text' => 'Add  Employee',
          'url' => route('employee.index'),

        ],
        [
          'text' => 'Active Employees',
          'url' => route('allemployee'),
        ],
        [
          'text' => 'Frozen Employees',
          'url' => route('frozonemployee'),
        ],
      ],
    ],

    [
      'text' => 'Bank',
      'url' => '#',
      'icon' => 'reply',
      'can' => [2],
      'submenu' => [
        [
          'text' => 'Add Bank Account',
          'url' => route('createbank'),

        ],
        [
          'text' => 'Active Bank Account',
          'url' => route('allviewbank'),
        ],
        [
          'text' => 'Frozen Bank Account',
          'url' => route('frozenviewbank'),
        ],
      ],
    ],
    [
      'text' => 'Customers',
      'url' => '#',
      'icon' => 'reply',
      'submenu' => [
        [
          'text' => 'Add Customer',
          'url' => route('customers.create'),

        ],
        [
          'text' => 'Active Customer',
          'url' => route('customers.view'),
        ],
        [
          'text' => 'Frozen Customer',
          'url' => route('customers.all-frozen'),
        ],

      ],
    ],
    /*
[
  'text' => 'Projects',
  'url' => '#',
  'icon' => 'reply',
  'submenu' => [
    [
      'text' => 'Add Project',
      'url' => route('createprojects'),

    ],
    [
      'text' => 'Active Projects',
      'url' => route('viewprojects'),
    ],
    [
      'text' => 'Frozen Projects',
      'url' => route('viewfrozenprojects'),
    ],
  ],
],
*/
    [
      'text' => 'Salary',
      'url' => '#',
      'icon' => 'reply',
      'submenu' => [
        [
          'text' => 'Add Salary',
          'url' => route('salary.add'),
        ],
        [
          'text' => 'Active Salary',
          'url' => route('salary.view'),
        ],
        [
          'text' => 'Frozen Salary',
          'url' => route('salary.viewfrozen'),
        ],
      ],
    ],
    [
      'text' => 'Advance',
      'url' => '#',
      'icon' => 'reply',
      'submenu' => [
        [
          'text' => 'Add Advance',
          'url' => route('advance.index'),
        ],
        [
          'text' => 'View Advance',
          'url' => route('advance.view'),
        ]
      ],
    ],
    [
      'text' => 'Units',
      'url' => '#',
      'icon' => 'reply',
      'submenu' => [
        [
          'text' => 'Insert Units',
          'url' => route('units.create'),

        ],
        [
          'text' => 'Units View',
          'url' => route('units.all'),
        ],


      ],
    ],

  ];
  return $arr;
}


function convertNumberToWord($num = false)
{
  $num = str_replace(array(',', ' '), '', trim($num));
  if (!$num) {
    return false;
  }
  $num = (int) $num;
  $words = array();
  $list1 = array(
    '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
    'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
  );
  $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
  $list3 = array(
    '', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
    'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
    'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
  );
  $num_length = strlen($num);
  $levels = (int) (($num_length + 2) / 3);
  $max_length = $levels * 3;
  $num = substr('00' . $num, -$max_length);
  $num_levels = str_split($num, 3);
  for ($i = 0; $i < count($num_levels); $i++) {
    $levels--;
    $hundreds = (int) ($num_levels[$i] / 100);
    $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
    $tens = (int) ($num_levels[$i] % 100);
    $singles = '';
    if ($tens < 20) {
      $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
    } else {
      $tens = (int)($tens / 10);
      $tens = ' ' . $list2[$tens] . ' ';
      $singles = (int) ($num_levels[$i] % 10);
      $singles = ' ' . $list1[$singles] . ' ';
    }
    $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
  } //end for loop
  $commas = count($words);
  if ($commas > 1) {
    $commas = $commas - 1;
  }
  return implode(' ', $words);
}

//echo '<pre>';
//print_r(leftMenu());
//echo '</pre>';
