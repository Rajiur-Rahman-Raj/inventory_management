@extends('admin.layouts.app')
@section('title')
    @lang($title)
@endsection

@section('content')
    @php
        $base_currency = config('basic.currency_symbol');
    @endphp

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="font-13">@lang('Property')</th>
                        <th scope="col" class="font-13">@lang('Investment Expire Date')</th>
                        <th scope="col" class="font-13">@lang('Invested User')</th>
                        <th scope="col" class="font-13">@lang('Total Invested Amount')</th>
                        <th scope="col" class="font-13">@lang('Profit Return Date')</th>
                        <th scope="col" class="font-13">@lang('Return Times')</th>
                        <th scope="col" class="font-13">@lang('Return Disbursement Type')</th>
                        <th scope="col" class="font-13">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($investments as $invest)
                        <tr>
                            <td data-label="@lang('Property')">
                                <a href="{{ route('propertyDetails',[@slug(optional($invest->property->details)->property_title), optional($invest->property)->id]) }}" target="_blank">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="mr-3"><img src="{{getFile(config('location.propertyThumbnail.path').optional($invest->property)->thumbnail) }}" alt="@lang('property_thumbnail')" class="rounded-circle" width="45" height="45">
                                        </div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">
                                                @lang(\Str::limit(optional($invest->property->details)->property_title, 30))
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            </td>

                            <td data-label="@lang('Expire Date')">
                                @if(optional($invest->property)->expire_date)
                                    {{ dateTime(optional($invest->property)->expire_date) }}
                                @endif
                            </td>

                            <td data-label="@lang('Invested User')">
                                <a href="{{ route('admin.seeInvestedUser', ['property_id' => optional($invest->property)->id, 'type' => 'expired']) }}"><span class="custom-badge bg-success badge-pill">{{ optional($invest->property)->totalRunningInvestUserAndAmount()['totalInvestedUser'] }}</span></a>
                            </td>

                            <td data-label="@lang('Total Invested Amount')">
                                {{ config('basic.currency_symbol') }}{{ optional($invest->property)->totalRunningInvestUserAndAmount()['totalInvestedAmount'] }}
                            </td>


                            <td data-label="@lang('Return Date')">
                                {{ dateTime($invest->return_date) }}
                            </td>

                            <td data-label="@lang('Return Times')">
                                @if($invest->how_many_times == 0 && $invest->status == 1)
                                    <span class="custom-badge bg-success badge-pill">@lang('Completed')</span>
                                @elseif($invest->how_many_times == null && $invest->status == 0)
                                    <span class="custom-badge bg-success badge-pill">@lang('Life Time')</span>
                                @else
                                    <span class="custom-badge bg-success badge-pill">{{ $invest->how_many_times }}@lang(' times')</span>
                                @endif
                            </td>

                            <td data-label="@lang('Profit Return Disbursement Type')">
                                <input data-toggle="toggle" id="disbursement_type" class="disbursement_type" data-onstyle="success"
                                       data-offstyle="info" data-on="Manual Payment" data-off="Automatic Payment" data-width="100%"
                                       type="checkbox" {{ optional($invest->property)->is_payment == 0 ? 'checked' : '' }} name="disbursement_type" data-id="{{ optional($invest->property)->id }}">
                            </td>


                            <td data-label="@lang('Action')">
                                <a href="{{ route('admin.seeInvestedUser', ['property_id' => optional($invest->property)->id, 'type' => 'expired']) }}" class="btn btn-sm btn-outline-primary btn-rounded btn-rounded edit-button">
                                    <i class="far fa-eye"></i>
                                </a>

                                @if(($invest->how_many_times == null || $invest->how_many_times != 0) && $invest->status == 0 && optional($invest->property)->is_payment == 0)
                                    <button class="btn btn-sm btn-outline-primary btn-rounded btn-sm investPaymentAllUser"
                                    type="button"
                                            data-route="{{ route('admin.investPaymentAllUser', optional($invest->property)->id) }}"
                                            data-property="{{ $invest }}"
                                            data-toggle="modal"
                                            data-target="#investPaymentAllUserModal">
                                        <span>
                                            <i class="fa fa-credit-card"></i> @lang(' Pay manually all investor')
                                        </span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center text-na">@lang('No Data Found')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="investPaymentAllUserModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">@lang('Return profit to all investor')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                @if(!$investments->isEmpty())
                    <form action="" method="post" id="investPaymentAllUserForm">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                    <label>@lang('Return Profit') <span class="return__profit__type text-primary font-14"></span></label>
                                    <div class="input-group mb-3">
                                        <input type="hidden" name="profit_return_date" value="" class="profit_return_date">
                                        <input type="text" name="get_profit" id="actualGetProfit" class="form-control" value="" placeholder="@lang('0')">
                                        <div class="input-group-append">
                                            <select name="get_profit_type" id="actualGetProfitType" class="form-control actualGetProfitType">

                                            </select>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">
                                <span>@lang('Cancel')</span>
                            </button>
                            <button type="submit" class="btn btn-primary btn-rounded">
                                <span><i class="fas fa-save"></i> @lang('Submit')</span></button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>

@endsection

@push('js')


    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.Failure("{{trans($error)}}");
            @endforeach
        </script>
    @endif

    <script>
        "use strict";
        $(document).ready(function () {
            $(document).on('click', '.investPaymentAllUser', function () {
                let dataProperty = $(this).data('property');
                $('#actualGetProfit').val(dataProperty.profit);
                $('.profit_return_date').val(dataProperty.return_date)
                if (dataProperty.property.profit_type == 1){
                    $('#actualGetProfitType').append(`<option value="1" >%</option>`)
                    $('.return__profit__type').text(`(percentage)`);
                }else{
                    $('#actualGetProfitType').append(`<option value="0" >$</option>`)
                    $('.return__profit__type').text(`(fixed)`);
                }

                $('#investPaymentAllUserForm').attr('action', $(this).data('route'))
            })

            $(document).on('change','#disbursement_type', function () {

                var isCheck = $(this).prop('checked');
                let dataId = $(this).data('id');
                let isVal = null;
                if (isCheck == true) {
                    isVal = 'on'
                } else {
                    isVal = 'off';
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('admin.disbursementType') }}",
                    type: "POST",
                    data: {
                        dataid: dataId,
                        isval: isVal,
                    },
                    success: function (data) {
                        window.location.reload();
                    },
                });
            });
        });
    </script>

@endpush
