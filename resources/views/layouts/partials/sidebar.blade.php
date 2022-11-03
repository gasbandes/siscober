<header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="{{ url('/') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-bandes-mini.png') }}" alt="" height="32">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-bandes-img.png') }}" alt="" height="20">
                        </span>
                    </a>

                    <a href="{{ url('/') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-bandes-mini.png') }}" alt="" height="32">
                        </span>
                        <span class="logo-lg">
                             <img src="{{ asset('assets/images/logo-bandes-img.png') }}" alt="" height="40">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                    <i class="mdi mdi-menu"></i>
                </button>

                <div class="d-none d-sm-block ms-2">
                    <h4 class="page-title font-size-18">Bandes</h4>
                </div>

            </div>

            <!-- Search input -->
            <div class="search-wrap" id="search-wrap">
                <div class="search-bar">
                    <input class="search-input form-control" placeholder="Search" />
                    <a href="#" class="close-search toggle-search" data-bs-target="#search-wrap">
                        <i class="mdi mdi-close-circle"></i>
                    </a>
                </div>
            </div>

            <div class="d-flex">

                {{-- <div class="dropdown d-none d-lg-inline-block">
                    <button type="button" class="btn header-item toggle-search noti-icon waves-effect"
                        data-bs-target="#search-wrap">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                </div>

                <div class="dropdown d-none d-md-block ms-2">
                    <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img class="me-2" src="assets/images/flags/us_flag.jpg" alt="Header Language" height="16"> English
                        <span class="mdi mdi-chevron-down"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="assets/images/flags/germany_flag.jpg" alt="user-image" class="me-1" height="12"> <span
                                class="align-middle"> German </span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="assets/images/flags/italy_flag.jpg" alt="user-image" class="me-1" height="12"> <span
                                class="align-middle"> Italian </span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="assets/images/flags/french_flag.jpg" alt="user-image" class="me-1" height="12"> <span
                                class="align-middle"> French </span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="assets/images/flags/spain_flag.jpg" alt="user-image" class="me-1" height="12"> <span
                                class="align-middle"> Spanish </span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="assets/images/flags/russia_flag.jpg" alt="user-image" class="me-1" height="12"> <span
                                class="align-middle"> Russian </span>
                        </a>
                    </div>
                </div> --}}

                <div class="dropdown d-none d-lg-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                        <i class="mdi mdi-fullscreen"></i>
                    </button>
                </div>

                <div class="dropdown d-inline-block ms-2">
                    @if (\Auth::user()->hasRole('Seguridad') || \Auth::user()->hasRole('Tecnologia') || \Auth::user()->hasRole('Verificador'))
                        <button type="button" class="btn header-item noti-icon waves-effect"
                       href="#" class="btn" data-bs-toggle="modal" data-bs-target="#NotificacionesStock"
                        aria-expanded="false">
                        <i class="ion ion-md-notifications"></i>
                        @if(session('notificaciones'))
                        <span class="badge bg-danger rounded-pill">{{session('notificaciones')->count()}}</span>
                        @endif
                    </button>
                    @endif
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    @if(session('notificaciones'))
                                            <label id="total_notificaciones">
                                                {{session('notificaciones')->count()}}
                                                @if(session('notificaciones')->count() > 0)
                                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                                @else
                                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                                @endif
                                            </label>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            <a href="#" class="text-reset notification-item">
                                <div class="media d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-success rounded-circle font-size-16">
                                            <i class="mdi mdi-cart-outline"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <h6 class="mt-0 font-size-15 mb-1">Your order is placed</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="text-reset notification-item">
                                <div class="media d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-warning rounded-circle font-size-16">
                                            <i class="mdi mdi-message-text-outline"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <h6 class="mt-0 font-size-15 mb-1">New Message received</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">You have 87 unread messages</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="text-reset notification-item">
                                <div class="media d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-info rounded-circle font-size-16">
                                            <i class="mdi mdi-glass-cocktail"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <h6 class="mt-0 font-size-15 mb-1">Your item is shipped</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">It is a long established fact that a reader will</p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>
                        <div class="p-2 border-top text-center">
                            <a class="btn btn-sm btn-link font-size-14 w-100" href="javascript:void(0)">
                                View all
                            </a>
                        </div>
                    </div>
                </div> 

                <div class="dropdown d-inline-block ms-2">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/images.png') }}"
                            alt="Header Avatar">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item
                        <a class="dropdown-item" href="#"><i class="dripicons-user font-size-16 align-middle me-2"></i>
                            Profile</a>
                        <a class="dropdown-item" href="#"><i class="dripicons-wallet font-size-16 align-middle me-2"></i> My
                            Wallet</a>
                        <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">5</span><i
                                class="dripicons-gear font-size-16 align-middle me-2"></i> Settings</a>
                        <a class="dropdown-item" href="#"><i class="dripicons-lock font-size-16 align-middle me-2"></i> Lock
                            screen</a>-->
                        <div class="dropdown-divider"></div>
                         <a class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="dripicons-power text-danger font-size-16 align-middle me-2"></i>   {{ __('Salir') }}
                        </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                    </div>
                </div>

                <div class="dropdown d-inline-block">
                   {{--  <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                        <i class="mdi mdi-spin mdi-cog"></i>
                    </button> --}}
                </div>

            </div>
        </div>
    </header>

    <!-- Modal alerts -->
<div class="modal fade" id="NotificacionesStock" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Notificaciones</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close">
            </button>
               
            </div>

            <div class="list-group">
                @if(session('notificaciones'))
                    <div class="list-group">
                    @foreach(session('notificaciones') as $notificacion)
                        <div class="list-group-item list-group-item-action">
                            <div class="row">                               
                                <div class="col-md-8 col-md-offset-1">
                                    <h5>{{$notificacion->fecha}}</h5>
                                    <h4>
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                        <a class="btn-link" href="{{$notificacion->link}}">
                                            <small>{{$notificacion->titulo}}</small></h4>
                                        </a>
                                    </h4>
                                    <p class="mb-1">{{$notificacion->texto}}</p>
                                </div>
                                <div class="col-md-1 col-md-offset-1">
                                    <h4 align="">
                                        {!! Form::open(['route' => ['borrarNotificacion', $notificacion->id], 'method' => 'DELETE', 'class' => 'form-borrar' ]) !!}
                                            <a class="btn btn-link btn-borrar-mensaje" type="submit" value=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        {!! Form::close() !!}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        <div id="sin-mensajes" class="list-group-item list-group-item-action">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 nuevas text-center">
                                    <h4>No hay notificaciones que mostrar</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal"
                aria-label="Close">
                Cerrar
            </button>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script type="text/javascript">
    $(document).ready(function(){
        if($(".form-borrar").length > 0){
            $("#sin-mensajes").hide();
        }
        $('.form-borrar').on('click', function(e) {
            e.preventDefault();
            var form = this;
            var data = $(this).serialize();
            var url = $(this).attr('action');

            $.ajax({
                url: url,
                data: data,
                type: 'DELETE',
                success: function(result) {
                    var row = $(form).parents('.list-group-item');
                    //row.fadeOut().remove();
                    row.fadeOut().remove();
                    $("#total_notificaciones").html(result.total);
                   
                    if(result.total == 0){
                        $("#sin-mensajes").fadeIn();
                    }
                },
                error: function(result) {

                }
            });
        });
    });
</script>
@endpush
