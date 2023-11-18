<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <img style="width: 35px;" src="{{ asset('logo.png') }}" alt="">
            <span class="demo menu-text fw-bolder ms-2" style="font-size: 20px;">{{ __('messages.panel_name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        @can('user_management_access')
            <li
                class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') || request()->is('admin/roles') || request()->is('admin/roles/*') || request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-user-circle'></i>
                    <div data-i18n="Layouts">User Management</div>
                </a>

                <ul class="menu-sub">
                    @can('permission_access')
                        <li
                            class="menu-item {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Permission</div>
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li
                            class="menu-item {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Roles</div>
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li
                            class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Users</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Products Management</span>
        </li>

        {{-- category  --}}
        @can('category_access')
            <li
                class="menu-item {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}">
                <a href="{{ route('admin.categories.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-menu-alt-right'></i>
                    <div data-i18n="Analytics">{{ __('messages.category.title') }}</div>
                </a>
            </li>
        @endcan

        @can('product_access')
            <li
                class="menu-item {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active' : '' }}">
                <a href="{{ route('admin.products.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-server'></i>
                    <div data-i18n="Analytics">{{ __('messages.product.title') }}</div>
                </a>
            </li>
        @endcan

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Contact Management</span>
        </li>


        @can('customer_access')
            <li
                class="menu-item {{ request()->is('admin/customers') || request()->is('admin/customers/*') ? 'active' : '' }}">
                <a href="{{ route('admin.customers.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-group'></i>
                    <div data-i18n="Analytics">{{ __('messages.customer.title') }}</div>
                </a>
            </li>
        @endcan

        @can('supplier_access')
            <li
                class="menu-item {{ request()->is('admin/suppliers') || request()->is('admin/suppliers/*') ? 'active' : '' }}">
                <a href="{{ route('admin.suppliers.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-truck'></i>
                    <div data-i18n="Analytics">{{ __('messages.supplier.title') }}</div>
                </a>
            </li>
        @endcan

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Purchase Management</span>
        </li>

        @can('purchase_access')
            <li
                class="menu-item {{ request()->is('admin/purchases') || request()->is('admin/purchases/*') ? 'active' : '' }}">
                <a href="{{ route('admin.purchases.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-cart-alt'></i>
                    <div data-i18n="Analytics">{{ __('messages.purchase.title') }}</div>
                </a>
            </li>
        @endcan
    </ul>
</aside>
