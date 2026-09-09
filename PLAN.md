# ផែនការអនុវត្ត - គម្រោងគ្រប់គ្រងប្រាក់កម្ចីខ្នាតតូច (Mini Loan Project Management)

គម្រោងការងារនេះត្រូវបានសម្រេចជោគជ័យ និងផ្ទៀងផ្ទាត់ ១០០% រួចរាល់ហើយ!

---

## ✅ ដែលបានធ្វើរួចហើយ (Completed)

### ១. ប្រព័ន្ធ Authentication & Authorization
- **Migration `add_role_to_users_table`**: enum role (`admin`, `loan_officer`, `cashier`, `customer`), default = `customer`
- **`User.php`**: បន្ថែម `role` ក្នុង fillable + helper methods `isAdmin()`, `isLoanOfficer()`, `isCashier()`, `isCustomer()`
- **`RegisteredUserController.php`**: users ថ្មី ទទួល `role = customer` ដោយស្វ័យប្រវត្តិ
- **`CheckRole.php` Middleware**: ពិនិត្យ `$user->role` ផ្ទៀងផ្ទាត់ ហើយ `abort(403)` ប្រសិនបើគ្មានសិទ្ធិ
- **`bootstrap/app.php`**: ចុះឈ្មោះ alias `'role' => CheckRole::class`
- **`LoanPolicy.php`**: rules សម្រាប់ `view`, `approve`, `disburse`, `repay`
- **`DatabaseSeeder.php`**: seed users ៤ (admin/officer/cashier/customer), password = `12345678`

### ២. Database Tables
- **`loans`**: customer_id, principal_amount, interest_rate, term_months, status, disbursement_date, created_by
- **`loan_schedules`**: loan_id, installment_no, due_date, principal_due, interest_due, total_due, status
- **`repayments`**: loan_id, schedule_id, amount_paid, payment_date, payment_method, received_by

### ៣. Models
- **`Loan.php`**: customer(), creator(), schedules(), repayments(), getRemainingBalanceAttribute()
- **`LoanSchedule.php`**: loan(), repayments()
- **`Repayment.php`**: loan(), schedule(), receiver()

### ៤. AmortizationService
- **`app/Services/AmortizationService.php`**: រូបមន្ត Reducing Balance
  - `EMI = P × r × (1+r)^n / ((1+r)^n - 1)`
  - ការបង់ប្រាក់ខែចុងក្រោយ = Balance ដែលនៅសល់ (ជៀសវាង rounding drift)

### ៥. LoanController (`app/Http/Controllers/LoanController.php`)
Methods:
- `applyForm()` + `apply()` — Customer ដាក់ពាក្យ
- `pendingList()` — Admin/Officer មើលបញ្ជី Pending
- `approve(Loan $loan)` — ផ្លាស់ status → Approved
- `disburse(Loan $loan)` — ផ្លាស់ status → Disbursed + generate schedule ដោយ AmortizationService
- `schedule(Loan $loan)` — បង្ហាញ amortization table
- `repayForm(Loan $loan)` + `repay(Request, Loan)` — Cashier កត់ payment + DB::transaction() + Overpayment
- `show(Loan $loan)` — ព័ត៌មានលម្អិត + remaining balance
- `overdueDashboard()` — Admin: បញ្ជី Overdue ជាមួយ Pagination

### ៦. Routes (`routes/web.php`)
- Loan routes ទាំងអស់ត្រូវបានបន្ថែមជាមួយ role middleware ត្រឹមត្រូវ

### ៧. Blade Views (`resources/views/loans/` & `dashboard/`)
- `apply.blade.php` — Form ស្នើសុំ (principal, rate, term)
- `pending.blade.php` — Table + "Approve" button
- `schedule.blade.php` — Amortization table (Overdue = bg-danger-subtle)
- `repay.blade.php` — Form Cashier
- `show.blade.php` — ព័ត៌មានលម្អិត + repayment log
- `resources/views/dashboard/overdue.blade.php` — Paginated overdue list

### ៨. Sidebar Update
- `Layout/incloudes/sidebar.blade.php`: បង្ហាញ Loan links ផ្អែកលើ `auth()->user()->role`

### ៩. Scheduler (Overdue auto-update)
- `routes/console.php`: command ដំណើរការប្រចាំថ្ងៃ ប្តូរ `Pending` → `Overdue` ប្រសិនបើ due_date ហួស

### ១០. Tests (Passed 100% ✅)
- Unit Test: `AmortizationCalculationTest` — ផ្ទៀងផ្ទាត់ sum(principal_due) == principal_amount (Passed)
- Feature Test: `LoanAuthorizationTest` — Customer មិនអាច POST /disburse (Passed)
- `CustomerTest` and `ExampleTest` fixed and fully passing.

---

## គណនីសម្រាប់ Login (ពាក្យសម្ងាត់ទាំងអស់: `12345678`)
| Role | Email |
|------|-------|
| Admin | admin@example.com |
| Loan Officer | officer@example.com |
| Cashier | cashier@example.com |
| Customer | customer@example.com |
