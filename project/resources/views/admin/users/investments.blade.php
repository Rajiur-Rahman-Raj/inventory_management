@extends('admin.layouts.app')
@section('title',trans('Investments').': '.$user->username )
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <table class="categories-show-table table table-hover table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>@lang('SL')</th>
                    <th>@lang('User')</th>
                    <th>@lang('Property')</th>
                    <th>@lang('Investment Amount')</th>
                    <th>@lang('Profit')</th>
                    <th>@lang('Upcoming Payment')</th>
                    <th>@lang('Profit Status')</th>
                    <th>@lang('Payment Status')</th>
                    <th>@lang('Investment Status')</th>
                    <th scope="col">@lang('Action')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($investments as $key => $invest)
                    <tr>

                        <td data-label="@lang('SL')">
                            {{loopIndex($investments) + $key}}
                        </td>

                        <td data-label="@lang('User')">
                            <a href="{{route('admin.user-edit',$invest->user_id)}}" target="_blank">
                                <div class="d-flex no-block align-items-center">
                                    <div class="mr-3"><img src="{{getFile(config('location.user.path').optional($invest->user)->image) }}" alt="user" class="rounded-circle" width="45" height="45">
                                    </div>
                                    <div class="">
                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">
                                            @lang(optional($invest->user)->firstname) @lang(optional($invest->user)->lastname)
                                        </h5>
                                        <span class="text-muted font-14"><span>@</span>@lang(optional($invest->user)->username)</span>
                                    </div>
                                </div>
                            </a>
                        </td>

                        <td data-label="@lang('Property')">
                            <a href="{{ route('propertyDetails',[@slug(optional($invest->property->details)->property_title), optional($invest->property)->id]) }}" target="_blank">
                                <div class="d-flex no-block align-items-center">
                                    <div class="mr-3"><img src="{{getFile(config('location.propertyThumbnail.path').optional($invest->property)->thumbnail) }}" alt="@lang('property_thumbnail')" class="rounded-circle" width="45" height="45">
                                    </div>
                                    <div class="">
                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">
                                            @lang(\Illuminate\Support\Str::limit(optional($invest->property->details)->property_title, 30))
                                        </h5>
                                        <span class="text-primary font-weight-medium font-14">@lang('Invested: ')<span>{{ config('basic.currency_symbol') }}</span>{{ (int)$invest->amount }}</span>
                                    </div>
                                </div>
                            </a>
                        </td>

                        <td data-label="@lang('Invest Amount')">
                            {{ optional($invest->property)->investmentAmount }}
                        </td>

                        <td data-label="@lang('Profit')">
                            @if($invest->invest_status == 1)
                                {{ config('basic.currency_symbol') }}{{ $invest->net_profit }}
                            @else
                                <span class="custom-badge badge-pill bg-danger">@lang('N/A')</span>
                            @endif

                        </td>

                        <td data-label="@lang('Upcoming Payment')">
                            @if($invest->invest_status == 0)
                                <span class="custom-badge badge-pill bg-danger">@lang('after installments complete')</span>
                            @else
                                {{ customDate($invest->return_date) }}
                            @endif
                        </td>

                        <td data-label="@lang('Profit Status')">
                            <span class="custom-badge badge-pill
                            @if($invest->status == 1 && $invest->invest_status == 1)
                                bg-success
                            @elseif($invest->status == 0 && $invest->invest_status == 0)
                                bg-warning
                            @elseif($invest->status == 0 && $invest->invest_status == 1)
                                bg-primary
                            @endif
                            ">
                                @if($invest->status == 1 && $invest->invest_status == 1)
                                    @lang('Completed')
                                @elseif($invest->status == 0 && $invest->invest_status == 0)
                                    @lang('Upcoming')
                                @elseif($invest->status == 0 && $invest->invest_status == 1)
                                    @lang('Running')
                                @endif
                            </span>
                        </td>

                        <td data-label="@lang('Payment Status')">
                            <span class="custom-badge badge-pill {{ $invest->invest_status == 1 ? 'bg-success' : 'bg-warning' }}">{{ $invest->invest_status == 1 ? trans('clear') : trans('Due') }}</span>
                        </td>


                        <td data-label="@lang('Status')">
                            <span class="custom-badge badge-pill {{ $invest->is_active == 1 ? 'bg-success' : 'bg-warning' }}">{{ $invest->is_active == 1 ? trans('Active') : trans('Deactive') }}</span>
                            @if($invest->is_active == 0)
                                <sup>
                                    <a href="javascript:void(0)"
                                       title="@lang('Deactive Reason')"
                                       data-investor="@lang(optional($invest->user)->firstname) @lang(optional($invest->user)->lastname)"
                                       data-title="{{ optional($invest->property->details)->property_title }}"
                                       data-deactivereason="{{ $invest->deactive_reason }}"
                                       class="info-listing-btn investDeactiveInfo" aria-labelledby="dropdownMenuLink">  <i class="fas fa-info"></i>
                                    </a>
                                </sup>
                            @endif
                        </td>

                        <td data-label="@lang('Action')">
                            <div class="dropdown show">
                                <a class="dropdown-toggle p-3" href="#" id="dropdownMenuLink" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('admin.investmentDetails', $invest->id) }}">
                                        <i class="far fa-eye text-primary pr-2"
                                           aria-hidden="true"></i> @lang('Details')
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center text-danger" colspan="100%">@lang('No Investment Data')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $investments->links('partials.pagination') }}
        </div>

    </div>
@endsection
