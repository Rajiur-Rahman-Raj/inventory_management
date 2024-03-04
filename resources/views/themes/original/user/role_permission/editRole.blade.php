@extends($theme.'layouts.user')
@section('title',trans('Edit Role'))

@section('content')
    <!-- profile setting -->
    <div class="container-fluid">
        <div class="main row">
            <div class="row mt-2 d-flex justify-content-between">
                <div class="col">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="header-text-full">
                            <h3 class="dashboard_breadcurmb_heading mb-1">@lang('Edit Role')</h3>
                            <nav aria-label="breadcrumb" class="ms-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    </li>

                                    <li class="breadcrumb-item"><a
                                            href="{{ route('user.role') }}">@lang('Role List')</a>
                                    </li>

                                    <li class="breadcrumb-item active"
                                        aria-current="page">@lang('Edit Role')</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="{{route('user.role')}}"
                               class="btn btn-custom text-white create__ticket">
                                <i class="fas fa-backward"></i> @lang('Back')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <!-- profile setting -->
                <section class="profile-setting">
                    <div class="row g-4 g-lg-5">
                        <div class="col-lg-12 m-0">
                            <form method="post" action="{{ route('user.roleUpdate', $singleRole->id) }}"
                                  class="mt-4" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 mb-3">
                                        <div class="input-box">
                                            <h6 for="name" class="font-weight-bold text-dark"> @lang('Role Name') <span
                                                    class="text-danger">*</span></h6>
                                            <input type="text" name="name"
                                                   placeholder="Enter role name" class="form-control @error('name') @enderror"
                                                   value="{{ old('name', $singleRole->name) }}">
                                            <div class="invalid-feedback">
                                                @error('name') @lang($message) @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold text-dark">@lang('Status')</label>
                                        <div class="selectgroup">
                                            <select class="form-control js-example-basic-single" name="status"
                                                    aria-label="Default select example">
                                                <option
                                                    value="1" {{ old('status', $singleRole->status) == 1 ? 'selected' : '' }}>@lang('Active')</option>
                                                <option
                                                    value="0" {{ old('status', $singleRole->status) == 0 ? 'selected' : '' }}>@lang('Deactive')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card mb-4 card-primary ">
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <div class="title">
                                                    <h5 class="accessibility">@lang('Accessibility')</h5>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <table width="100%" class="select-all-access">
                                                    <thead class="permission-group">
                                                    <tr>
                                                        <th class="p-2">@lang('Permissions Group')</th>
                                                        <th class="p-2"><input type="checkbox" class="selectAll"
                                                                               name="accessAll" id="allowAll"> <label
                                                                class="mb-0" for="allowAll">Allow All Permissions</label>
                                                        </th>

                                                        <th class="p-2">Permission</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(config('permissionList'))
                                                        @php
                                                            $i = 0;
                                                            $j = 500;
                                                        @endphp

                                                        @foreach(collect(config('permissionList')) as $key1 => $permission)
                                                            @php
                                                                $i++;
                                                            @endphp
                                                            <tr class="partiallyCheckAll{{ $i }}">
                                                                <td class="ps-2">
                                                                    <strong>
                                                                        <input type="checkbox"
                                                                               class="partiallySelectAll{{$i}}"
                                                                               name="partiallyAccessAll"
                                                                               id="partiallySelectAll{{$i}}"
                                                                               onclick="partiallySelectAll({{$i}})">
                                                                        <label
                                                                            for="partiallySelectAll{{$i}}">@lang(str_replace('_', ' ', $key1))</label>
                                                                    </strong>
                                                                </td>
                                                                @if(1 == count($permission))
                                                                    <td class="border-left ps-2">
                                                                        <input type="checkbox"
                                                                               class="cursor-pointer singlePermissionSelectAll{{$i}}"
                                                                               id="singlePermissionSelect{{$i}}"
                                                                               value="{{join(",",collect($permission)->collapse()['permission']['view'])}}"
                                                                               onclick="singlePermissionSelectAll({{$i}})"
                                                                               name="permissions[]"/>
                                                                        <label
                                                                            for="singlePermissionSelect{{$i}}">{{ str_replace('_', ' ', collect($permission)->keys()[0]) }}</label>
                                                                    </td>
                                                                    <td class="ps-2 border-left" style="width: 178px;">
                                                                        <ul class="list-unstyled">
                                                                            @if(!empty(collect($permission)->collapse()['permission']['view']))
                                                                                <li>
                                                                                    @if(!empty(collect($permission)->collapse()['permission']['view']))
                                                                                        <input
                                                                                            type="checkbox"
                                                                                            value="{{join(",",collect($permission)->collapse()['permission']['view'])}}"
                                                                                            @if(in_array_any(collect($permission)->collapse()['permission']['view'], $singleRole->permission??[] ))
                                                                                                checked
                                                                                            @endif
                                                                                            class="cursor-pointer"
                                                                                            name="permissions[]"/> @lang('View')
                                                                                    @endif
                                                                                </li>
                                                                            @endif

                                                                            @if(!empty(collect($permission)->collapse()['permission']['add']))
                                                                                <li>
                                                                                    <input type="checkbox"
                                                                                           value="{{join(",",collect($permission)->collapse()['permission']['add'])}}"
                                                                                           @if(in_array_any(collect($permission)->collapse()['permission']['add'], $singleRole->permission??[] ))
                                                                                               checked
                                                                                           @endif
                                                                                           class="cursor-pointer"
                                                                                           name="permissions[]"/> @lang('Add')
                                                                                </li>
                                                                            @endif

                                                                            @if(!empty(collect($permission)->collapse()['permission']['edit']))
                                                                                <li>
                                                                                    <input type="checkbox"
                                                                                           value="{{join(",",collect($permission)->collapse()['permission']['edit'])}}"
                                                                                           @if(in_array_any(collect($permission)->collapse()['permission']['edit'], $singleRole->permission??[] ))
                                                                                               checked
                                                                                           @endif
                                                                                           class="cursor-pointer"
                                                                                           name="permissions[]"/>
                                                                                    @lang('Edit')
                                                                                </li>
                                                                            @endif

                                                                            @if(!empty(collect($permission)->collapse()['permission']['delete']))
                                                                                <li>
                                                                                    <input type="checkbox"
                                                                                           value="{{join(",",collect($permission)->collapse()['permission']['delete'])}}"
                                                                                           @if(in_array_any(collect($permission)->collapse()['permission']['delete'], $singleRole->permission??[] ))
                                                                                               checked
                                                                                           @endif
                                                                                           class="cursor-pointer"
                                                                                           name="permissions[]"/>
                                                                                    @lang('Delete')
                                                                                </li>
                                                                            @endif

                                                                            @if(collect($permission)->keys()[0] == 'Companies')
                                                                                @if(!empty(collect($permission)->collapse()['permission']['switch']))
                                                                                    <li>
                                                                                        <input
                                                                                            type="checkbox"
                                                                                            value="{{join(",",collect($permission)->collapse()['permission']['switch'])}}"
                                                                                            @if(in_array_any(collect($permission)->collapse()['permission']['switch'], $singleRole->permission??[] ))
                                                                                                checked
                                                                                            @endif
                                                                                            class="cursor-pointer"
                                                                                            name="permissions[]"/>
                                                                                        @lang('Switch')
                                                                                    </li>
                                                                                @endif
                                                                            @endif

                                                                            @if(collect($permission)->keys()[0] == 'Sales_List')
                                                                                @if(!empty(collect($permission)->collapse()['permission']['return']))
                                                                                    <li>
                                                                                        <input
                                                                                            type="checkbox"
                                                                                            value="{{join(",",collect($permission)->collapse()['permission']['return'])}}"
                                                                                            @if(in_array_any(collect($permission)->collapse()['permission']['return'], $singleRole->permission??[] ))
                                                                                                checked
                                                                                            @endif
                                                                                            class="cursor-pointer"
                                                                                            name="permissions[]"/>
                                                                                        @lang('Sales Return')
                                                                                    </li>
                                                                                @endif
                                                                            @endif

                                                                            @if(collect($permission)->keys()[0] == 'Purchase_Report')
                                                                                @if(!empty(collect($permission)->collapse()['permission']['export']))
                                                                                    <li>
                                                                                        <input
                                                                                            type="checkbox"
                                                                                            value="{{join(",",collect($permission)->collapse()['permission']['export'])}}"
                                                                                            @if(in_array_any(collect($permission)->collapse()['permission']['export'], $singleRole->permission??[] ))
                                                                                                checked
                                                                                            @endif
                                                                                            class="cursor-pointer"
                                                                                            name="permissions[]"/>
                                                                                        @lang('Export')
                                                                                    </li>
                                                                                @endif
                                                                            @endif

                                                                        </ul>
                                                                    </td>
                                                                @else
                                                                    <td colspan="2">
                                                                        <!-- Nested table for the second column -->
                                                                        <table class="child-table">
                                                                            <tbody>
                                                                            @foreach($permission as $key2 => $subMenu)
                                                                                @php
                                                                                    $j++;
                                                                                @endphp
                                                                                <tr class="partiallyCheckAll{{ $j }}">
                                                                                    <td class="p-2">
                                                                                        <input type="checkbox"
                                                                                               class="cursor-pointer multiplePermissionSelectAll{{$j}}"
                                                                                               id="multiplePermissionSelectAll{{$j}}"
{{--                                                                                               value="{{join(",",$subMenu['permission']['view'])}}"--}}
                                                                                               onclick="multiplePermissionSelectAll({{$j}})"
                                                                                               name="permissions[]">
                                                                                        <label class="mb-0"
                                                                                               for="multiplePermissionSelectAll{{$j}}">@lang(str_replace('_', ' ', $key2))</label>
                                                                                    </td>

                                                                                    <td class="ps-2 border-left  multiplePermissionCheck{{$j}}"
                                                                                        style="width: 178px;">
                                                                                        <ul class="list-unstyled py-2 mb-0">
                                                                                            @if(!empty($subMenu['permission']['view']))
                                                                                                <li>
                                                                                                    <input
                                                                                                        type="checkbox"
                                                                                                        value="{{join(",",$subMenu['permission']['view'])}}"
                                                                                                        @if(in_array_any($subMenu['permission']['view'], $singleRole->permission??[] ))
                                                                                                            checked
                                                                                                        @endif
                                                                                                        class="cursor-pointer"
                                                                                                        name="permissions[]">
                                                                                                    View
                                                                                                </li>
                                                                                            @endif

                                                                                            @if(!empty($subMenu['permission']['add']))
                                                                                                <li>
                                                                                                    <input
                                                                                                        type="checkbox"
                                                                                                        value="{{join(",",$subMenu['permission']['add'])}}"
                                                                                                        @if(in_array_any($subMenu['permission']['add'], $singleRole->permission??[] ))
                                                                                                            checked
                                                                                                        @endif
                                                                                                        class="cursor-pointer"
                                                                                                        name="permissions[]"/> @lang('Add')
                                                                                                </li>
                                                                                            @endif

                                                                                            @if(!empty($subMenu['permission']['edit']))
                                                                                                <li>
                                                                                                    <input
                                                                                                        type="checkbox"
                                                                                                        value="{{join(",",$subMenu['permission']['edit'])}}"
                                                                                                        @if(in_array_any($subMenu['permission']['edit'], $singleRole->permission??[] ))
                                                                                                            checked
                                                                                                        @endif
                                                                                                        class="cursor-pointer"
                                                                                                        name="permissions[]"/> @lang('Edit')
                                                                                                </li>
                                                                                            @endif

                                                                                            @if(!empty($subMenu['permission']['delete']))
                                                                                                <li>
                                                                                                    <input
                                                                                                        type="checkbox"
                                                                                                        value="{{join(",",$subMenu['permission']['delete'])}}"
                                                                                                        @if(in_array_any($subMenu['permission']['delete'], $singleRole->permission??[] ))
                                                                                                            checked
                                                                                                        @endif
                                                                                                        class="cursor-pointer"
                                                                                                        name="permissions[]"/> @lang('Delete')
                                                                                                </li>
                                                                                            @endif

                                                                                            @if($key1 == 'Manage_Companies')
                                                                                                @if(!empty($subMenu['permission']['switch']))
                                                                                                    <li>
                                                                                                        <input
                                                                                                            type="checkbox"
                                                                                                            value="{{join(",",$subMenu['permission']['switch'])}}"
                                                                                                            @if(in_array_any($subMenu['permission']['switch'], $singleRole->permission??[] ))
                                                                                                                checked
                                                                                                            @endif
                                                                                                            class="cursor-pointer"
                                                                                                            name="permissions[]"/>
                                                                                                        @lang('Switch')
                                                                                                    </li>
                                                                                                @endif
                                                                                            @endif

                                                                                            @if($key1 == 'Manage_Sales')
                                                                                                @if(!empty($subMenu['permission']['return']))
                                                                                                    <li>
                                                                                                        <input
                                                                                                            type="checkbox"
                                                                                                            value="{{join(",",$subMenu['permission']['return'])}}"
                                                                                                            @if(in_array_any($subMenu['permission']['return'], $singleRole->permission??[] ))
                                                                                                                checked
                                                                                                            @endif
                                                                                                            class="cursor-pointer"
                                                                                                            name="permissions[]"/>
                                                                                                        @lang('Return')
                                                                                                    </li>
                                                                                                @endif
                                                                                            @endif

                                                                                            @if($key1 == 'Manage_Reports')
                                                                                                @if(!empty($subMenu['permission']['export']))
                                                                                                    <li>
                                                                                                        <input
                                                                                                            type="checkbox"
                                                                                                            value="{{join(",",$subMenu['permission']['export'])}}"
                                                                                                            @if(in_array_any($subMenu['permission']['export'], $singleRole->permission??[] ))
                                                                                                                checked
                                                                                                            @endif
                                                                                                            class="cursor-pointer"
                                                                                                            name="permissions[]"/>
                                                                                                        @lang('Export')
                                                                                                    </li>
                                                                                                @endif
                                                                                            @endif

                                                                                        </ul>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="invalid-feedback d-block">
                                                @error('permissions') @lang($message) @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit"
                                        class="btn waves-effect btn-custom waves-light btn-rounded  btn-block mt-3 w-100">
                                    @lang('Update Role')
                                </button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script>
        'use strict'
        function partiallySelectAll($key1) {
            if ($(`.partiallySelectAll${$key1}`).prop('checked') == true) {
                $(`.partiallyCheckAll${$key1}`).find('input[type="checkbox"]').attr('checked', 'checked');
            } else {
                $(`.partiallyCheckAll${$key1}`).find('input[type="checkbox"]').removeAttr('checked');
            }
        }

        function singlePermissionSelectAll($key) {
            if ($(`.singlePermissionSelectAll${$key}`).prop('checked') == true) {
                $(`.partiallyCheckAll${$key}`).find('input[type="checkbox"]').attr('checked', 'checked');
            } else {
                $(`.partiallyCheckAll${$key}`).find('input[type="checkbox"]').removeAttr('checked');
            }
        }

        function multiplePermissionSelectAll($key) {
            if ($(`.multiplePermissionSelectAll${$key}`).prop('checked') == true) {
                $(`.multiplePermissionCheck${$key}`).find('input[type="checkbox"]').attr('checked', 'checked');
            } else {
                $(`.multiplePermissionCheck${$key}`).find('input[type="checkbox"]').removeAttr('checked');
            }
        }

        $(document).ready(function () {
            $('.selectAll').on('click', function () {
                if ($(this).is(':checked')) {
                    $(this).parents('.select-all-access').find('input[type="checkbox"]').attr('checked', 'checked')
                } else {
                    $(this).parents('.select-all-access').find('input[type="checkbox"]').removeAttr('checked')
                    $('.allAccordianShowHide').removeClass('show');
                }
            })
        })
    </script>

@endpush
