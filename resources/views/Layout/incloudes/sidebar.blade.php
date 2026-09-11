<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/images/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" onerror="this.style.display='none'" />
            <span class="brand-text fw-light">Build Bright University</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2" aria-label="Main navigation">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" data-accordion="false" id="navigation">
                
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @auth
                    {{-- Master Data Management (Admin only) --}}
                    @if(auth()->user()->isAdmin())
                        <li class="nav-header">MANAGEMENT</li>
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-tags"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customers.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Customers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('employees.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-person-badge"></i>
                                <p>Employees</p>
                            </a>
                        </li>
                    @endif

                    {{-- Customer specific options --}}
                    @if(auth()->user()->isCustomer())
                        <li class="nav-header">MY LOANS</li>
                        <li class="nav-item">
                            <a href="{{ route('loans.my_loans') }}" class="nav-link">
                                <i class="nav-icon bi bi-wallet2"></i>
                                <p>My Loans</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('loans.apply') }}" class="nav-link">
                                <i class="nav-icon bi bi-file-earmark-plus"></i>
                                <p>Apply for Loan</p>
                            </a>
                        </li>
                    @endif

                    {{-- Loan Officer & Admin options --}}
                    @if(auth()->user()->isAdmin() || auth()->user()->isLoanOfficer() || auth()->user()->isCashier())
                        <li class="nav-header">LOAN PROCESSES</li>
                        <li class="nav-item">
                            <a href="{{ route('loans.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-wallet-fill text-info"></i>
                                <p>All Loans</p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->isAdmin() || auth()->user()->isLoanOfficer())
                        <li class="nav-item">
                            <a href="{{ route('loans.pending') }}" class="nav-link">
                                <i class="nav-icon bi bi-hourglass-split text-warning"></i>
                                <p>Pending Loans</p>
                            </a>
                        </li>
                    @endif

                    {{-- Admin + Loan Officer + Cashier: Overdue Loans --}}
                    @if(auth()->user()->isAdmin() || auth()->user()->isLoanOfficer() || auth()->user()->isCashier())
                        <li class="nav-item">
                            <a href="{{ route('dashboard.overdue') }}" class="nav-link">
                                <i class="nav-icon bi bi-exclamation-triangle text-danger"></i>
                                <p>Overdue Loans</p>
                            </a>
                        </li>
                    @endif

                    {{-- Admin + Loan Officer: Loan Settings --}}
                    @if(auth()->user()->isAdmin() || auth()->user()->isLoanOfficer())
                        <li class="nav-item">
                            <a href="{{ route('loans.settings.edit') }}" class="nav-link">
                                <i class="nav-icon bi bi-sliders text-warning"></i>
                                <p>Loan Settings</p>
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            {{-- Logout Button --}}
            <div class="p-3 mt-3 border-top border-secondary border-opacity-25">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="btn btn-sm btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-lock" aria-hidden="true"></i>
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </div>
</aside>