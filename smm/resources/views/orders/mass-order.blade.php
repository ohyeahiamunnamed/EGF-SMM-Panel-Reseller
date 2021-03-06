@extends('layouts.app')
@section('title', getOption('app_name') . ' - Mass Order')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="login-form">
                <form
                        role="form"
                        method="POST"
                        action="{{ url('/order/mass-order') }}">
                    {{ csrf_field() }}
                    <fieldset class="scheduler-border">
                        <div class="form-group">
                            <h6 style="margin: 0">@lang('forms.mass_order')</h6>
                            <p class="label label-default">@lang('forms.each_order_on_new_line')</p>
                        </div>
                        <div class="form-group">
                            <span class="label label-success">@lang('forms.mass_order_format')</span>
                            <textarea
                                    name="content"
                                    id="content"
                                    data-validation="required"
                                    style="height: 350px; resize: vertical;"
                                    class="form-control">{{ old('content') }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">@lang('buttons.place_order')</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div style="height: 10px;">&nbsp;</div>
            <div class="panel panel-default">
                <div class="panel-body p0">
                    <div class="table-responsive">
                        <table class="table table-bordered services-table">
                            <tbody>
                            @if( ! empty($packages) )
                                @php
                                    $serviceId=null;
                                @endphp
                                @foreach($packages as $package)

                                    @if(is_null($serviceId))
                                        <tr>
                                            <td colspan="7" class="theme-bg" style="color:white">{{ $package->service->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('general.package_id')</th>
                                            <th>@lang('general.name')</th>
                                            <th>@lang('general.description')</th>
                                            <th>@lang('general.price_per_item') {{ getOption('display_price_per') }}</th>
                                            <th>@lang('general.minimum_quantity')</th>
                                            <th>@lang('general.maximum_quantity')</th>
                                        </tr>
                                        @php
                                            $serviceId=$package->service->id
                                        @endphp
                                    @endif

                                    @if($serviceId != $package->service_id)
                                        <tr>
                                            <td colspan="7" class="theme-bg" style="color:white">{{ $package->service->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('general.package_id')</th>
                                            <th>@lang('general.name')</th>
                                            <th>@lang('general.description')</th>
                                            <th>@lang('general.price_per_item') {{ getOption('display_price_per') }}</th>
                                            <th>@lang('general.minimum_quantity')</th>
                                            <th>@lang('general.maximum_quantity')</th>
                                        </tr>
                                        @php
                                            $serviceId = $package->service_id
                                        @endphp
                                    @endif
                                    <tr>
                                        <td>{{ $package->id }}</td>
                                        <td>{{ $package->name }}</td>
                                        <td>{{ $package->description }}</td>
                                        <td>
                                            @php
                                                $price = isset($userPackagePrices[$package->id]) ? $userPackagePrices[$package->id] : $package->price_per_item;
                                            @endphp
                                            {{ getOption('currency_symbol') . number_format(($price * getOption('display_price_per')),2, getOption('currency_separator'), '') }}
                                        </td>
                                        <td>{{ $package->minimum_quantity }}</td>
                                        <td>{{ $package->maximum_quantity }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">No Record Found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="text-center">
                {!!  getPageContent('mass-order') !!}
            </div>
        </div>
    </div>
@endsection