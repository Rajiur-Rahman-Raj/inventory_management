@extends($theme.'layouts.user')
@section('title',trans('Profile Settings'))

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrapicons-iconpicker.css') }}">
@endpush

@section('content')
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2">
                <div class="col">
                    <div class="header-text-full">
                        <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Profile Settings')</h3>
                        <nav aria-label="breadcrumb" class="ms-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@lang('Profile')</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col">
                <!-- profile setting -->
                <section class="profile-setting">
                    <div class="row g-4 g-lg-5">
                        <div class="col-lg-4">
                            <div class="sidebar-wrapper">
                                <div class="profile">
                                    <div class="img">
                                        <img id="profile" src="{{getFile(config('location.user.path'). $user->image)}}"
                                             alt="@lang('not found')" class="img-fluid profile-image-preview"/>
                                        <button class="upload-img">
                                            <i class="fal fa-camera"></i>
                                            <input
                                                class="form-control" id="userPorfileImage" name="image"
                                                accept="image/*" type="file"/>
                                        </button>
                                    </div>
                                    <div class="text">
                                        <h5 class="name">@lang($user->name)</h5>
                                        <span>@lang($user->email)</span>
                                    </div>
                                </div>
                                <div class="profile-navigator">
                                    <button tab-id="tab1"
                                            class="tab {{ $errors->has('profile') ? 'active' : (($errors->has('password') || $errors->has('identity') || $errors->has('addressVerification')) ? '' : ' active') }}">
                                        <i class="fal fa-user"></i> @lang('Profile information')
                                    </button>
                                    <button tab-id="tab2" class="tab {{ $errors->has('password') ? 'active' : '' }}">
                                        <i class="fal fa-key"></i> @lang('Password setting')
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div id="tab1"
                                 class="content {{ $errors->has('profile') ? ' active' : (($errors->has('password') || $errors->has('identity') || $errors->has('addressVerification')) ? '' :  ' active') }}">
                                <form action="{{ route('user.updateInformation')}}" method="post">
                                    @method('put')
                                    @csrf
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="name">@lang('Name')</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="name"
                                                   placeholder="@lang('Full Name')"
                                                   value="{{old('name', $user->name) }}"/>
                                            @if($errors->has('name'))
                                                <div class="error text-danger">@lang($errors->first('name'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="username">@lang('Username')</label>
                                            <input type="text"
                                                   id="username"
                                                   name="username"
                                                   placeholder="@lang('username')"
                                                   value="{{old('username', $user->username) }}"
                                                   class="form-control"/>
                                            @if($errors->has('username'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('username'))
                                                </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="email">@lang('Email')</label>
                                            <input type="email"
                                                   id="email"
                                                   name="email"
                                                   placeholder="@lang('email')"
                                                   value="{{  old('email', $user->email) }}"
                                                   class="form-control"/>
                                            @if($errors->has('email'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('email'))
                                                </div>
                                            @endif
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="phone">@lang('Phone Number')</label>
                                            <input type="text"
                                                   id="phone"
                                                   name="phone"
                                                   placeholder="@lang('phone')"
                                                   class="form-control"
                                                   value="{{ old('phone', $user->phone) }}"/>
                                            @if($errors->has('phone'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('phone'))
                                                </div>
                                            @endif
                                        </div>


                                        <div class="input-box col-12">
                                            <label for="">@lang('Address')</label>
                                            <textarea
                                                class="form-control @error('Bio') is-invalid @enderror"
                                                cols="30"
                                                rows="3"
                                                placeholder="@lang('Address')"
                                                name="address">{{ old('address', $user->address) }}</textarea>
                                            @if($errors->has('address'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('address'))
                                                </div>
                                            @endif
                                        </div>

                                        <div class="input-box col-12">
                                            <button class="btn-custom" type="submit">@lang('Update User')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div id="tab2" class="content {{ $errors->has('password') ? 'active' : '' }}">
                                <form method="post" action="{{ route('user.updatePassword') }}">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="input-box col-md-6">
                                            <label for="">@lang('Current Password')</label>
                                            <input type="password"
                                                   id="current_password"
                                                   name="current_password"
                                                   autocomplete="off"
                                                   class="form-control"
                                                   placeholder="@lang('Enter Current Password')"/>
                                            @if($errors->has('current_password'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('current_password'))</div>
                                            @endif
                                        </div>
                                        <div class="input-box col-md-6">
                                            <label for="">@lang('New Password')</label>
                                            <input type="password"
                                                   id="password"
                                                   name="password"
                                                   autocomplete="off"
                                                   class="form-control"
                                                   placeholder="@lang('Enter New Password')"/>
                                            @if($errors->has('password'))
                                                <div class="error text-danger">@lang($errors->first('password'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-md-6">
                                            <label for="password_confirmation">@lang('Confirm Password')</label>
                                            <input type="password"
                                                   id="password_confirmation"
                                                   name="password_confirmation"
                                                   autocomplete="off"
                                                   class="form-control"
                                                   placeholder="@lang('Confirm Password')"/>
                                            @if($errors->has('password_confirmation'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('password_confirmation'))</div>
                                            @endif
                                        </div>

                                        <div class="input-box col-12">
                                            <button class="btn-custom" type="submit">@lang('Update Password')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @push('loadModal')
        <!-- Modal -->
        <div class="modal fade" id="profileImage" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="planModalLabel">@lang('Confirmation')</h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <h6 id="imageChangeText"></h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom btn2" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="button" class="btn-custom profile-image-save">@lang('Save changes')</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush
@endsection


@push('css-lib')
    <link rel="stylesheet" href="{{asset($themeTrue.'css/bootstrap-fileinput.css')}}">
@endpush

@push('extra-js')
    <script src="{{asset($themeTrue.'js/bootstrap-fileinput.js')}}"></script>
    <script src="{{ asset('assets/global/js/bootstrapicon-iconpicker.js') }}"></script>
@endpush

@push('script')

    <script>
        'use strict'
        $(document).ready(function () {
            let curIconFirst = $($(`#iconpicker1`)).data('icon');
            setIconpicker('.iconpicker1');
            function setIconpicker(selector = '.iconpicker1') {
                $(selector).iconpicker({
                    title: 'Search Social Icons',
                    selected: false,
                    defaultValue: false,
                    placement: "top",
                    collision: "none",
                    animation: true,
                    hideOnSelect: true,
                    showFooter: false,
                    searchInFooter: false,
                    mustAccept: false,
                    icons: [{
                        title: "bi bi-facebook",
                        searchTerms: ["facebook", "text"]
                    }, {
                        title: "bi bi-twitter",
                        searchTerms: ["twitter", "text"]
                    }, {
                        title: "bi bi-linkedin",
                        searchTerms: ["linkedin", "text"]
                    }, {
                        title: "bi bi-youtube",
                        searchTerms: ["youtube", "text"]
                    }, {
                        title: "bi bi-instagram",
                        searchTerms: ["instagram", "text"]
                    }, {
                        title: "bi bi-whatsapp",
                        searchTerms: ["whatsapp", "text"]
                    }, {
                        title: "bi bi-discord",
                        searchTerms: ["discord", "text"]
                    }, {
                        title: "bi bi-globe",
                        searchTerms: ["website", "text"]
                    }, {
                        title: "bi bi-google",
                        searchTerms: ["google", "text"]
                    }, {
                        title: "bi bi-camera-video",
                        searchTerms: ["vimeo", "text"]
                    }, {
                        title: "bi bi-skype",
                        searchTerms: ["skype", "text"]
                    }, {
                        title: "bi bi-camera-video-fill",
                        searchTerms: ["tiktalk", "text"]
                    }, {
                        title: "bi bi-badge-tm-fill",
                        searchTerms: ["tumbler", "text"]
                    }, {
                        title: "bi bi-blockquote-left",
                        searchTerms: ["blogger", "text"]
                    }, {
                        title: "bi bi-file-word-fill",
                        searchTerms: ["wordpress", "text"]
                    }, {
                        title: "bi bi-badge-wc",
                        searchTerms: ["weixin", "text"]
                    }, {
                        title: "bi bi-telegram",
                        searchTerms: ["telegram", "text"]
                    }, {
                        title: "bi bi-bell-fill",
                        searchTerms: ["snapchat", "text"]
                    }, {
                        title: "bi bi-three-dots",
                        searchTerms: ["flickr", "text"]
                    }, {
                        title: "bi bi-file-ppt",
                        searchTerms: ["pinterest", "text"]
                    }],
                    selectedCustomClass: "bg-primary",
                    fullClassFormatter: function (e) {
                        return e;
                    },
                    input: "input,.iconpicker-input",
                    inputSearch: false,
                    container: false,
                    component: ".input-group-addon,.iconpicker-component",
                })
            }

            let newSocialForm = $('.append_new_social_form').length + 1;
            for (let i = 2; i <= newSocialForm; i++) {
                setIconpicker(`#iconpicker${i}`);
            }

            $("#add_social_links").on('click', function () {
                let newSocialForm = $('.append_new_social_form').length + 2;
                var form = `<div class="d-flex justify-content-between append_new_social_form removeSocialLinksInput">
                                <div class="input-group mt-1">
                                    <input type="text" name="social_icon[]" class="form-control demo__icon__picker iconpicker${newSocialForm}" placeholder="Pick a icon" aria-label="Pick a icon"
                                   aria-describedby="basic-addon1" readonly>
                                </div>

                                <div class="input-box w-100 my-1 me-1">
                                    <input type="url" name="social_url[]" class="form-control" placeholder="@lang('URL')"/>
                                </div>
                                <div class="my-1 me-1">
                                    <button class="btn-custom add-new btn-custom-danger remove_social_link_input_field" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>`;

                $('.new_social_links_form').append(form)
                setIconpicker(`.iconpicker${newSocialForm}`);
            });

            $(document).on('click', '.remove_social_link_input_field', function () {
                $(this).parents('.removeSocialLinksInput').remove();
            });

            // User profile image change
            $('#userPorfileImage').on('change', function () {
                $('#imageChangeText').text(`@lang('Do you want to change your profile image?')`)
                $('#profileImage').modal('show');
            });

            $(document).on('click', '.profile-image-save', function () {
                $('#profileImage').modal('hide');
                let formData = new FormData();
                console.log(formData);
                formData.append('profile_image', document.getElementById('userPorfileImage').files[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('user.profileImageUpdate') }}",
                    type: "post",
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.src) {
                            $('.profile-image-preview').attr('src', data.src);
                        }
                    }
                });
            })

            $(document).on('click', '#image-label', function () {
                $('#image').trigger('click');
            });
            $(document).on('change', '#image', function () {
                var _this = $(this);
                var newimage = new FileReader();
                newimage.readAsDataURL(this.files[0]);
                newimage.onload = function (e) {
                    $('#image_preview_container').attr('src', e.target.result);
                }
            });
            $(document).on('change', "#identity_type", function () {
                let value = $(this).find('option:selected').val();
                window.location.href = "{{route('user.profile')}}/?identity_type=" + value
            });

        });
    </script>

@endpush
