<!--sidebar wrapper -->
<div class="sidebar-wrapper sidebar" data-simplebar="true">
    <div class="sidebar-header" style="background-color: #076633">
        <div class="px-3">
            <img src="{{ asset('root/images/logoYnovWhite.png')}}" style="height: 60px; width:150px;" class="logo-icon img-fluid" alt="logo icon">
        </div>
        <div class="toggle-icon ms-auto text-warning"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <div class="bg-light" style="min-height: 15vh">
            @php
                $codePartenaire = Auth::user()->codepartenaire;
                $partner = \App\Models\Partner::where(['code' => $codePartenaire])->first();
            @endphp

            @if ($partner != null && $partner->logo != null)
                <a href="{{ route('shared.home')}}">
                    <img src="{{ asset('logos/'. $codePartenaire . '.png') }}"
                    style="min-height: 100%; min-width: 100%; background-color: #fff' : 'height: 100%; width: 100%;" 
                    class="logo-icon img-fluid"
                    alt="logo partenaire">
                </a>
            @else
                <a href="{{ route('shared.home')}}">
                    <img src="{{ asset('root/images/logo_yako.jpg') }}"
                    style="min-height: 100%; min-width: 100%; background-color: #fff' : 'height: 100%; width: 100%;" 
                    class="logo-icon img-fluid"
                    alt="logo default">
                </a>
            @endif
        </div>

        <div class="overflow-auto " style="height: calc(90vh - 180px)">
            @can('Voir e-validation')
            <strong><li class="menu-label">E-VALIDATION</li></strong>
            <li>
                <a href="{{ route('prod.validation.index')}}">
                    <div class="parent-icon">
                        <i class='bx bx-home-alt'></i>
                    </div>
                    <div class="menu-title">Validation</div>
                </a>
            </li>
            @endcan

            @can('Voir e-souscription')
            <strong><li class="menu-label">E-Souscription</li></strong>
            <li>
                <a href="{{ route('prod.stepProduct')}}">
                    <div class="parent-icon">
                        <i class='bx bx-home-alt'></i>
                    </div>
                    <div class="menu-title">Nouvelle Proposition</div>
                </a>
            </li>
            <li>
                <a href="{{ route('prod.index')}}">
                    <div class="parent-icon"><i class="fadeIn animated bx bx-clipboard"></i>
                    </div>
                    <div class="menu-title">Mes Propositions</div>
                </a>
            </li>
            @endcan
            
            
                
            @can('Voir e-pret')
            <li class="menu-label ">E-Prêt</li>
            <li>
                <a href="{{ route('epret.simulateur')}}">
                {{-- <a href="{{ route('epret.create')}}"> --}}
                    <div class="parent-icon"><i class="bx bx-dollar-circle fs-5"></i>
                    </div>
                    <div class="menu-title">Simulateur</div>
                </a>
            </li>
            <li>
                <a href="{{ route('epret.index')}}">
                    <div class="parent-icon"><i class="fadeIn animated bx bx-archive-in"></i>
                    </div>
                    <div class="menu-title">Mes demandes</div>
                </a>
            </li>
            @endcan

            @can('Voir e-prestation')
                <li class="menu-label">E-Prestation</li>

                @can('Demarrer une prestation')
                    <li>
                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="parent-icon"><i class="bx bx-dollar-circle fs-5"></i>
                            </div>
                            <div class="menu-title">Nouvelle demande</div>
                        </a>
                    </li>
                
                @endcan
                <li>
                    <a href="{{ route('prestation.mesPrestations')}}">
                        <div class="parent-icon"><i class="fadeIn animated bx bx-archive-in"></i>
                        </div>
                        <div class="menu-title">Mes demandes</div>
                    </a>
                </li>
                
            @endcan

            

            @can('Voir le rapport des activites')
                <li class="menu-label">Rapport d'activité</li>
                @can('Voir le rapport de validation')
                    <li>
                        <a href="{{ route('report.eValidation')}}">
                            <div class="parent-icon"><i class="bx bx-line-chart"></i>
                            </div>
                            <div class="menu-title">Validation</div>
                        </a>
                    </li>
                @endcan

                @can('Voir le rapport de souscription')
                    <li>
                        <a href="{{ route('report.eSouscription')}}">
                            <div class="parent-icon"><i class="bx bx-line-chart"></i>
                            </div>
                            <div class="menu-title">Souscription</div>
                        </a>
                    </li>
                @endcan
                
                <li>
                    <a href="{{ route('report.ePrestation')}}">
                        <div class="parent-icon"><i class="bx bx-line-chart"></i>
                        </div>
                        <div class="menu-title">Prestation</div>
                    </a>
                </li>
                
                @can('Voir le rapport des pret')
                    <li>
                        <a href="{{ route('report.ePret')}}">
                            <div class="parent-icon"><i class="bx bx-map-alt"></i>
                            </div>
                            <div class="menu-title">Pret</div>
                        </a>
                    </li>
                @endcan
                
            @endcan

            
            {{-- @endcan

            @can(' 	Voir e-prestation') --}}
                
            
            
            {{-- @endcan

            @can('Voir les paramettre') --}}
                
           @can('Voir les paramettres')
            <li class="menu-label">Paramètre</li>
            <li>
                <a href="{{ route('setting.reseau.index')}}">
                    <div class="parent-icon"><i class='bx bx-network-chart'></i>
                    </div>
                    <div class="menu-title">Reseaux</div>
                </a>
            </li>
            <li>
                <a href="{{ route('setting.zone.index')}}">
                    <div class="parent-icon"><i class="fadeIn animated bx bx-grid"></i>
                    </div>
                    <div class="menu-title">Zone</div>
                </a>
            </li>
            <li>
                <a href="{{ route('setting.equipe.index')}}">
                    <div class="parent-icon"><i class='bx bxl-microsoft-teams'></i>
                    </div>
                    <div class="menu-title">Equipe</div>
                </a>
            </li>
            <li>
                <a href="{{ route('setting.user.index')}}">
                    <div class="parent-icon"><i class="bx bx-user-circle"></i>
                    </div>
                    <div class="menu-title">Utilisateur</div>
                </a>
            </li>
            <li>
                <a href="{{ route('setting.role')}}">
                    <div class="parent-icon"><i class="fadeIn animated bx bx-user-check"></i>
                    </div>
                    <div class="menu-title">Role</div>
                </a>
            </li>
            <li>
                <a href="{{ route('setting.partner.index')}}">
                    <div class="parent-icon"><i class="fadeIn animated bx bx-book-content"></i>
                    </div>
                    <div class="menu-title">Partenaire</div>
                </a>
            </li>
            <li>
                <a href="{{ route('setting.motifRejet.index')}}">
                    <div class="parent-icon"><i class="lni lni-anchor"></i>
                    </div>
                    <div class="menu-title">Motif de rejet</div>
                </a>
            </li> 
            <li>
                <a href="{{ route('setting.prestation_product.index')}}">
                    <div class="parent-icon"><i class='bx bx-network-chart'></i>
                    </div>
                    <div class="menu-title">Produit</div>
                </a>
            </li>
            @endcan
        </div>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
<!--start header -->
<header class="top-header">
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>


              <div class="top-menu ms-auto ">
                <ul class="navbar-nav align-items-center gap-1">

                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="dropdown"><span class="alert-count">0</span>
                            <i class='bx bx-bell text-white'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;" >
                                <div class="msg-header" style="background-color: #fff">
                                    <p class="msg-header-title">Notifications</p>
                                    <p class="msg-header-badge">0</p>
                                </div>
                            </a>
                            <div class="header-notifications-list header-message-list app-container">
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        {{-- <div class="user-online">
                                            <img src="{{ asset('root/images/default.png')}}" class="msg-avatar" alt="user avatar">
                                        </div> --}}
                                        {{-- <div class="flex-grow-1">
                                            <h6 class="msg-name">Daisy Anderson<span class="msg-time float-end">5 sec
                                        ago</span></h6>
                                            <p class="msg-info">The standard chunk of lorem</p>
                                        </div> --}}
                                    </div>
                                </a>
                            </div>
                            {{-- <a href="javascript:;">
                                <div class="text-center msg-footer">
                                    <button class="btn btn-primary w-100">View All Notifications</button>
                                </div>
                            </a> --}}
                        </div>
                    </li>
                </ul>
            </div>
            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" 
                   href="#" 
                   role="button" 
                   data-bs-toggle="dropdown" 
                   aria-expanded="false">
                    <!-- User Avatar -->
                    {{-- <img src="{{ asset('root/images/login-images/default.png') }}" 
                         class="user-img rounded-circle" 
                         alt="User Avatar"> --}}
                    @if(Auth::user()->membre->photo != null && Auth::user()->membre->photo != '')
                        <img src="{{ asset('images/userProfile/' . Auth::user()->membre->photo) }}" class="user-img" alt="user avatar">
                    @else
                        <img src="{{ asset('root/images/login-images/default.png')}}" class="user-img" alt="user avatar">
                    @endif
                  
                    <!-- User Info -->
                    <div class="user-info text-white">
                        <p class="user-name mb-0 text-white fw-bold">
                            {{ Auth::user()->membre->nom ?? '' }} {{ Auth::user()->membre->prenom ?? '' }}
                        </p>
                        <p class="designation mb-0 text-white fst-italic">
                            {{ Auth::user()->membre->role ?? 'Role Indéfini' }}
                        </p>
                    </div>
                </a>
            
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <!-- Profile Link -->
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('setting.user.profile')}}">
                            <i class="bx bx-user fs-5 me-2"></i> 
                            <span>Profil</span>
                        </a>
                    </li>
                    
                    <!-- Divider -->
                    <li>
                        <div class="dropdown-divider my-2"></div>
                    </li>
            
                    <!-- Logout -->
                    <li>
                        <a class="dropdown-item d-flex align-items-center text-danger" 
                           href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-exit fs-5 me-2"></i> 
                            <span>Se Déconnecter</span>
                        </a>
                        <!-- Hidden Logout Form -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            
        </nav>
    </div>
</header>

@include('prestations.components.modals.getCustomerModal')
<!--end header -->

{{-- <li>
                <a href="{{ route('prod.index')}}">
                    <div class="parent-icon"><i class="fadeIn animated bx bx-clipboard"></i>
                    </div>
                    <div class="menu-title">Mes Propositions</div>
                </a>
            </li> --}}
            {{-- @can('Voir e-pret') --}}


            {{-- <li>
                <a href="{{ route('epret.demoSimulateur')}}">
                    <div class="parent-icon"><i class="bx bx-dollar-circle fs-5"></i>
                    </div>
                    <div class="menu-title">Demo</div>
                </a>
            </li> --}}
            
            
            {{-- @endcan

            @can('Voir le rapport') --}}