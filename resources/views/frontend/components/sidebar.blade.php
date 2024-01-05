<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link bg-primary text-center">

    <span class="brand-text font-weight-light font-weight-normal">Gescom App</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMT3-A3BoHLW3BEGarYVhSG3ha0VvGsLbHIw&usqp=CAU" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column mb" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item ">
          <a href="{{ route('home') }}" class="nav-link {{ Route::is('home')  ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Accueil
            </p>
          </a>
        </li>
        @can('view-user')
        <li class="nav-item">
          <a href="{{ route('users.index') }}" class="nav-link {{ Route::is('users.index')  || Route::is('users.edit') || Route::is('users.show') || Route::is('users.update') || Route::is('users.delete') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Utilisateurs
            </p>
          </a>
        </li>
        @endcan
        @can('view-role')
        <li class="nav-item ">
          <a href="{{ route('roles.index') }}" class="nav-link {{ Route::is('roles.index')  || Route::is('roles.edit') || Route::is('roles.create') || Route::is('roles.update') || Route::is('roles.delete') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-lock"></i>
            <p>
              Roles & Permissions
            </p>
          </a>
        </li>
        @endcan

        @can('view-category')
        <li class="nav-item {{ Route::is('categories*')  ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Route::is('categories.index')  || Route::is('categories.edit') || Route::is('categories.create') || Route::is('categories.update') || Route::is('categories.delete') ? 'active' : '' }}">
            <i class="nav-icon fas fa-blog"></i>
            <p>
              Categories
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('categories.index') }}" class="nav-link {{ Route::is('categories.index')  || Route::is('categories.edit') || Route::is('categories.update') || Route::is('categories.delete') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Voir Categories </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('categories.create') }}" class="nav-link {{ Route::is('categories.create')  ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Ajouter une categorie</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan
        @can('view-article')
        <li class="nav-item {{ Route::is('products*')  ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Route::is('products.index')  || Route::is('products.edit') || Route::is('products.create') || Route::is('products.update') || Route::is('products.delete') ? 'active' : '' }}">
            {{-- <i class="nav-icon fas fa-th-large"></i> --}}
            <i class="nav-icon fas fa-shopping-basket"></i>
            <p>
              Articles
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('products.index') }}" class="nav-link {{ Route::is('products.index')  || Route::is('products.edit') || Route::is('products.update') || Route::is('products.delete') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Voir les articles</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('products.create') }}" class="nav-link {{ Route::is('products.create')  ? 'active' : '' }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Creer un article</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan
        <!-- <li class="nav-item {{ Route::is('customer')  ? 'menu-open' : '' }}"> -->
        <li class="nav-item {{ Route::is('customers.index')  || Route::is('customers.edit') || Route::is('customers.create') || Route::is('customers.update') || Route::is('customers.delete')  || Route::is('customers.disponible.status') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Route::is('customers.index')  || Route::is('customers.edit') || Route::is('customers.create') || Route::is('customers.update') || Route::is('customers.delete')  || Route::is('customers.disponible.status') ? 'active' : '' }}">
            <i class="nav-icon fas fa-people-arrows"></i>
            <p>
              Clients
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="{{ route('customers.create') }}" class="nav-link {{ Route::is('customers.create')  ? 'active' : '' }}">
                <i class="fas fa-arrow-right mr-2"></i>
                <p>Ajouter Client</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('customers.index') }}" class="nav-link {{ Route::is('customers.index')  ? 'active' : '' }}">
                <i class="fas fa-arrow-right mr-2"></i>
                <p>Voir Clients</p>
              </a>
            </li>

          </ul>
        </li>



        <li class="nav-item {{  Route::is('invoices.index')  || Route::is('invoices.pendind.list.index') || Route::is('invoices.create') || Route::is('invoices.edit') || Route::is('invoices.print.list') || Route::is('invoices.delete')   ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Route::is('invoices.index')  || Route::is('invoices.pendind.list.index') || Route::is('invoices.create') || Route::is('invoices.edit') || Route::is('invoices.print.list') || Route::is('invoices.delete')  ? 'active' : '' }}">

            <i class="nav-icon fas fa-balance-scale"></i>
            <p>
              Gestion Factures
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('invoices.create') }}" class="nav-link {{ Route::is('invoices.create')  ? 'active' : '' }}">
                <!-- <i class="far fa-circle nav-icon"></i> -->
                <i class="fas fa-arrow-right mr-2"></i>
                <p>Creer une Facture</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('invoices.index') }}" class="nav-link {{ Route::is('invoices.index')  ? 'active' : '' }}">
                <!-- <i class="far fa-circle nav-icon"></i> -->
                <i class="fas fa-arrow-right mr-2"></i>
                <p>Suivi des Factures</p>
              </a>
            </li>
            <!-- <li class="nav-item">
                      <a href="{{ route('invoices.index') }}" class="nav-link {{ Route::is('invoices.index')  ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Listes des Factures</p>
                      </a>
                    </li> -->
            <li class="nav-item">
              <a href="{{ route('invoices.pendind.list.index') }}" class="nav-link {{ Route::is('invoices.pendind.list.index')  ? 'active' : '' }}">
                <!-- <i class="far fa-circle nav-icon"></i> -->
                <i class="fas fa-arrow-right mr-2"></i>
                <p>Facture en attente</p>
              </a>
            </li>


          </ul>
        </li>

        <!-- <li class="nav-item {{ Route::is('customer')  ? 'menu-open' : '' }}"> -->
        <li class="nav-item {{   Route::is('customers.credit') || Route::is('customers.paid') || Route::is('customers.wise.report') || Route::is('invoices.report')  ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{   Route::is('customers.credit') || Route::is('customers.paid') || Route::is('customers.wise.report')|| Route::is('invoices.report')  ? 'active' : '' }}">
            <i class="nav-icon fas fa-people-arrows"></i>
            <p>
              Rapport quotidien
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="{{ route('customers.credit') }}" class="nav-link {{ Route::is('customers.credit')  ? 'active' : '' }}">
                <i class="fas fa-arrow-right mr-2"></i>
                <p>Credit des Clients</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('customers.paid') }}" class="nav-link {{ Route::is('customers.paid')  ? 'active' : '' }}">
                <i class="fas fa-arrow-right mr-2"></i>
                <p>Paiement des Clients</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('customers.wise.report') }}" class="nav-link {{ Route::is('customers.wise.report')  ? 'active' : '' }}">
                <i class="fas fa-arrow-right mr-2"></i>
                <p>État financier client</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('invoices.report') }}" class="nav-link {{ Route::is('invoices.report')  ? 'active' : '' }}">
                <!-- <i class="far fa-circle nav-icon"></i> -->
                <i class="fas fa-arrow-right mr-2"></i>
                <p>Analyse selective </p>
              </a>
            </li>
          </ul>
        </li>


        <li class="nav-item ">
          <a href="#" class="nav-link" onclick="document.getElementById('logout-form').submit()" title=" se deconnecter !">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Se déconnecter
            </p>
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
              @csrf
            </form>
          </a>
        </li>
      </ul>

    </nav>

  </div>

</aside>