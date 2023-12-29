{{-- ---------------------------------------- brand name and brand logo----------------------------------------- --}}
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">MONOGANIS</span>
    </a>

    <!------------------------------------- Sidebar username and photo-------------------------------------------- -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-2 pb-2 mb-2 d-flex">
            <div class="image">
                <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- ---------------------------------------------Sidebar content---------------------------------------- -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                {{-- ---------------------------------------------الضبط العام-------------------------------------- --}}
                <li {{--  to open the menu when you use any child in it --}}
                    class="nav-item has-treeview {{ request()->is('admin/adminpanelsetting*') || request()->is('admin/treasuries*') ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الضبط العام
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{ route('admin.adminpanelsetting.index') }}" {{-- to activate the choosen item when you use it --}}
                                class="nav-link {{ request()->is('admin/adminpanelsetting/index') || request()->is('admin/adminpanelsetting/edit') ? 'active' : '' }}">
                                <p>الضبط العام</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- --------------------------------------------- الاصناف -------------------------------------- --}}
                <li {{-- in order to open the menu when you use any child in it --}}
                    class="nav-item has-treeview {{ request()->is('admin/sales_matrial_types*') ||
                    request()->is('admin/units*') ||
                    request()->is('admin/inv_categories*') ||
                    request()->is('admin/items*')
                        ? 'menu-open'
                        : '' }} ">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الاصناف
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('admin.units.index') }}" {{-- to activate the choosen item when you use it --}}
                                class="nav-link {{ request()->is('admin/units/index') || request()->is('admin/units/create') ? 'active' : '' }}">
                                <p>
                                    واحدات القياس
                                </p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('admin.items.index') }}" {{-- to activate the choosen item when you use it --}}
                                class="nav-link {{ request()->is('admin/items*') ? 'active' : '' }}">
                                <p>
                                    الاصناف
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- --------------------------------------------- العملاء والموردين-------------------------------------- --}}
                <li {{--  to open the menu when you use any child in it --}}
                    class="nav-item has-treeview  {{ request()->is('admin/account_types*') ||
                    request()->is('admin/accounts*') ||
                    request()->is('admin/customers*') ||
                    request()->is('admin/supplier_types*') ||
                    // request()->is('admin/employees*') ||
                    request()->is('admin/suppliers*')
                        ? 'menu-open'
                        : '' }}">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            العملاء والموردين
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('admin.customers.index') }}" {{-- to activate the choosen item when you use it --}}
                                class="nav-link {{ request()->is('admin/customers/index') || request()->is('admin/customers/create') ? 'active' : '' }}">
                                <p>
                                    حسابات العملاء
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.suppliers.index') }}" {{-- to activate the choosen item when you use it --}}
                                class="nav-link {{ request()->is('admin/suppliers*') ? 'active' : '' }}">
                                <p>
                                    حسابات الموردين
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.supplier_types.index') }}" {{-- to activate the choosen item when you use it --}}
                                class="nav-link {{ request()->is('admin/supplier_types*') ? 'active' : '' }}">
                                <p>
                                    انواع الموردين
                                </p>
                            </a>
                        </li>



                    </ul>
                </li>
                {{-- -------------------------------------------- حركات الفواتير----------------------------------- --}}
                <li {{--  to open the menu when you use any child in it --}}
                    class="nav-item has-treeview  {{ request()->is('admin/supplier_orders*') || request()->is('admin/salesInvoice*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الفواتير
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.salesInvoice.index') }}" {{-- to activate the choosen item when you use it --}}
                                class="nav-link {{ request()->is('admin/salesInvoice*') ? 'active' : '' }}">
                                <p>
                                    فواتير البيع لعميل
                                </p>
                            </a>
                        </li>
                    </ul>
                    {{-- id '1' is the admin id can access everything --}}
                    @if (auth()->user()->username == 'admin')
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.supplier_orders.index') }}" {{-- to activate the choosen item when you use it --}}
                                    class="nav-link {{ request()->is('admin/supplier_orders*') ? 'active' : '' }}">
                                    <p>
                                        فواتير الشراء من مورد
                                    </p>
                                </a>
                            </li>
                        </ul>
                    @endif

                </li>
                {{-- --------------------------------------------  المخزن----------------------------------- --}}
                <li {{--  to open the menu when you use any child in it --}}
                    class="nav-item has-treeview  {{ request()->is('admin/stores*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            المخازن
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.stores.index') }}" {{-- to activate the choosen item when you use it --}}
                                class="nav-link {{ request()->is('admin/stores*') ? 'active' : '' }}">
                                <p>
                                    المخزن
                                </p>
                            </a>
                        </li>
                    </ul>

                </li>
                {{-- --------------------------------------------  الموظفين ----------------------------------- --}}
                <li {{--  to open the menu when you use any child in it --}}
                    class="nav-item has-treeview  {{ request()->is('admin/employees*') || request()->is('admin/exchange_transactions*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الموظفين
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.employees.index') }}" {{-- to activate the choosen item when you use it --}}
                                class="nav-link {{ request()->is('admin/employees*') ? 'active' : '' }}">
                                <p>
                                    الموظفين
                                </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.exchange_transactions.index') }}" {{-- to activate the choosen item when you use it --}}
                                class="nav-link {{ request()->is('admin/exchange_transactions*') ? 'active' : '' }}">
                                <p>
                                    صرف نقدية لموظف
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
