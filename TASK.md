# បញ្ជីតាមដានវឌ្ឍនភាពការងារ (Task List) - Mini Loan Project

## ចំណុចទី ១៖ ប្រព័ន្ធបញ្ជាក់អត្តសញ្ញាណ និងតួនាទី (Authentication & Authorization)
- [x] បង្កើត Migration ដើម្បីបន្ថែមជួរឈរ `role` ទៅកាន់តារាង `users`
- [x] កែប្រែម៉ូដែល `User.php` (បន្ថែម fillable `role` និងមុខងារ isAdmin/isLoanOfficer/isCashier/isCustomer)
- [x] កែប្រែ `RegisteredUserController.php` កំណត់សិទ្ធិលំនាំដើមជា `customer`
- [x] បង្កើត Middleware `CheckRole.php` (**app/Http/Middleware/CheckRole.php**)
- [x] ចុះឈ្មោះ middleware alias `role` នៅក្នុង `bootstrap/app.php`
- [x] បង្កើត `LoanPolicy.php` (**app/Policies/LoanPolicy.php**)
- [x] Update `DatabaseSeeder.php` ជាមួយ admin/officer/cashier/customer users
- [x] ធ្វើ migrate:fresh --seed (ត្រូវ fix ឈ្មោះ database ជាមុន)
- [x] កែសម្រួល sidebar (**Layout/incloudes/sidebar.blade.php**) ដើម្បីបង្ហាញ/លាក់ Links តាម Role និងរៀបចំឱ្យស្អាត
- [x] Feature Test: ពិនិត្យថា Customer មិនអាចចូល route admin/loan_officer

## ចំណុចទី ២៖ ការស្នើសុំ និងការអនុម័តប្រាក់កម្ចី (Loan Application & Approval)
- [x] បង្កើត Migration `create_loans_table`
- [x] បង្កើតម៉ូដែល `Loan.php` (**app/Models/Loan.php**) ជាមួយ relations
- [x] Form ស្នើសុំកម្ចី `loans/apply.blade.php` + Route GET/POST
- [x] បង្កើតទំព័រ `loans/pending.blade.php` (Loan Officer/Admin)
- [x] បង្កើតទំព័រ `loans/index.blade.php` សម្រាប់មើលកម្ចីទាំងអស់ (All Loans)
- [x] Route PUT `/loans/{id}/approve` + action ផ្លាស់ប្តូរ status ទៅ `Approved`
- [x] **LoanController.php** — methods: applyForm, apply, pendingList, approve, disburse, schedule, repayForm, repay, show, overdueDashboard
- [x] **routes/web.php** — Loan routes ទាំងអស់ ជាមួយ role middleware

## ចំណុចទី ៣៖ ការបើកប្រាក់កម្ចី និងកាលវិភាគសង (Disbursement & Schedule)
- [x] បង្កើត Migration `create_loan_schedules_table`
- [x] បង្កើតម៉ូដែល `LoanSchedule.php` (**app/Models/LoanSchedule.php**) ជាមួយ relations
- [x] បង្កើត `AmortizationService.php` (**app/Services/AmortizationService.php**) - Reducing Balance
- [x] Route POST `/loans/{id}/disburse` + generate schedules
- [x] ទំព័រ `loans/schedule.blade.php` (ជួរ Overdue = ពណ៌ក្រហម)
- [x] Scheduler command ប្តូរ status `Pending` → `Overdue` ប្រចាំថ្ងៃ
- [x] Unit Test: ផ្ទៀងផ្ទាត់ AmortizationService

## ចំណុចទី ៤៖ ការសងប្រាក់ (Repayment)
- [x] បង្កើត Migration `create_repayments_table`
- [x] បង្កើតម៉ូដែល `Repayment.php` (**app/Models/Repayment.php**) ជាមួយ relations
- [x] Form `loans/repay.blade.php` (Cashier) + Route POST
- [x] DB::transaction() + Overpayment logic
- [x] ទំព័រ `loans/show.blade.php` (remaining balance + repayment history)
- [x] ផ្ទាំង Admin `/dashboard/overdue` + Pagination

---

## ឯកសារដែលបានបង្កើត/កែប្រែ រួចរាល់ហើយ
| File | Status |
|------|--------|
| `database/migrations/2026_08_28_..._add_role_to_users_table.php` | ✅ Done |
| `database/migrations/2026_08_28_..._create_loans_table.php` | ✅ Done |
| `database/migrations/2026_08_28_..._create_loan_schedules_table.php` | ✅ Done |
| `database/migrations/2026_08_28_..._create_repayments_table.php` | ✅ Done |
| `app/Models/User.php` | ✅ Done |
| `app/Models/Loan.php` | ✅ Done |
| `app/Models/LoanSchedule.php` | ✅ Done |
| `app/Models/Repayment.php` | ✅ Done |
| `app/Services/AmortizationService.php` | ✅ Done |
| `app/Http/Middleware/CheckRole.php` | ✅ Done |
| `app/Policies/LoanPolicy.php` | ✅ Done |
| `bootstrap/app.php` | ✅ Done |
| `app/Http/Controllers/Auth/RegisteredUserController.php` | ✅ Done |
| `database/seeders/DatabaseSeeder.php` | ✅ Done |
| `app/Http/Controllers/LoanController.php` | ✅ Done |
| `routes/web.php` | ✅ Done |
| `resources/views/loans/*.blade.php` | ✅ Done |
| `resources/views/Layout/incloudes/sidebar.blade.php` | ✅ Done |
