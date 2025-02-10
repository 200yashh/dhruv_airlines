@extends('layouts.master')

@section('title')
  @lang('translation.add_resource', ['resource' => 'Book flight'])
@endsection

@section('plugin-css')
  <!-- Dropzone -->
  <link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      @lang('translation.airline.airline')
    @endslot
    @slot('li_2')
      {{ route('airlines.index') }}
    @endslot
    @slot('title')
       @lang('translation.add_resource', ['resource' => __('attributes.airline')])
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form class="needs-validation" novalidate action="{{ route('tickets.booking-save') }}" method="POST">
            <input type="hidden" name="flight_id" value="{{$flight->id}}">
            @csrf
            <div class="row">
              <div class="col-8">

                <div class="row mb-4">
                  <label for="code" class="col-sm-3 col-form-label">Airline</label>
                  <div class="col-sm-9">
                    <select class="form-control select2" id="airline" name="airline_id" disabled>
                      <option value="">@lang('translation.none')</option>
                      @foreach ($airlines as $key => $value)
                        <option value="{{ $key }}" @selected($key === $flight->airline_id)>{{ $value }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row mb-4">
                  <label for="code" class="col-sm-3 col-form-label">Plane</label>
                  <div class="col-sm-9">
                    <select class="form-control select2" id="plane" name="plane_id" disabled>
                      <option value="">@lang('translation.none')</option>
                      @foreach ($planes as $key => $value)
                        <option value="{{ $key }}" @selected($key === $flight->plane_id)>{{ $value }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row mb-4">
                  <label for="loan_limit" class="col-sm-3 col-form-label">@lang('translation.flight.time')</label>
                  <div class="col-sm-9">
                    <div class="input-daterange input-group" id="datepicker" data-date-format="yyyy-m-d" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker'>
                      <input type="date" class="form-control filter-input" id="departure" name="departure" placeholder="@lang('translation.flight.departure')" disabled/>
                      <input type="date" class="form-control filter-input" id="arrival" name="arrival" placeholder="@lang('translation.flight.arrival')" disabled/>

                      <div class="valid-feedback">
                        @lang('validation.good')
                      </div>
                      <div class="invalid-feedback">
                        @lang('validation.required', ['attribute' => __('translation.flight.time')])
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mb-4">
                  <label for="price" class="col-sm-3 col-form-label">@lang('translation.flight.price')</label>
                  <div class="col-sm-9">
                    <div class="input-group">
                      <div class="input-group-text">$</div>
                      <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $flight->price) }}" disabled>
                      <div class="valid-feedback">
                        @lang('validation.good')
                      </div>
                      <div class="invalid-feedback">
                        @lang('validation.required', ['attribute' => __('translation.flight.price')])
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mb-4">
                  <label for="price" class="col-sm-3 col-form-label">Remain Seats</label>
                  <div class="col-sm-9">
                    <div class="input-group">
                      <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $flight->remain_seats) }}" disabled>
                      <div class="valid-feedback">
                        @lang('validation.good')
                      </div>
                      <div class="invalid-feedback">
                        @lang('validation.required', ['attribute' => __('translation.flight.price')])
                      </div>
                    </div>
                  </div>
                </div>
                {{-- route (origin, destination) --}}
                <div class="row mb-4">
                  <label for="loan_limit" class="col-sm-3 col-form-label">@lang('translation.flight.route')</label>
                  <div class="col-sm-9">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="origin" class="col-sm-3 col-form-label">@lang('translation.flight.origin')</label>
                          <select class="form-control select2" id="origin" name="origin_id" disabled>
                            <option value="">@lang('translation.none')</option>
                            @foreach ($airlines as $key => $value)
                              <option value="{{ $key }}" @selected($key === $flight->origin_id)>{{ $value }}</option>
                            @endforeach
                          </select>
                          <div class="valid-feedback">
                            @lang('validation.good')
                          </div>
                          <div class="invalid-feedback">
                            @lang('validation.required', ['attribute' => __('translation.flight.origin')])
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="destination" class="col-sm-3 col-form-label">@lang('translation.flight.destination')</label>
                          <select class="form-control select2" id="destination" name="destination_id" disabled>
                            <option value="">@lang('translation.none')</option>
                            @foreach ($airlines as $key => $value)
                              <option value="{{ $key }}" @selected($key === $flight->destination_id)>{{ $value }}</option>
                            @endforeach
                          </select>
                          <div class="valid-feedback">
                            @lang('validation.good')
                          </div>
                          <div class="invalid-feedback">
                            @lang('validation.required', ['attribute' => __('translation.flight.destination')])
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <label for="code" class="col-sm-3 col-form-label">Number of Tickets</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="number_of_tickets" name="number_of_tickets" value="{{ old('number_of_tickets') }}" required>
                  </div>
                </div>


                <div class="row justify-content-end">
                  <div class="col-sm-9">
                    <div>
                      <button class="btn btn-primary" type="submit">Book</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>


        </div>
      </div>
      <!-- end card -->
    </div> <!-- end col -->
  </div>
@endsection

@section('script')
  <!-- Dropzone js -->
  <script src="{{ URL::asset('/assets/libs/dropzone/dropzone.min.js') }}"></script>
  {{-- Dropzone Config --}}
  <script src="{{ URL::asset('assets/js/dropzone-config.js') }}"></script>
@endsection
