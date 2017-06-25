@extends('layouts.app')
@section('content')
    @include('notifications')
    
    <div class="row">
    	<div class="col-md-7">
            <form action="/user/settings/edit" method="post">
                {{ csrf_field() }}
        		<div class="card">
			        <div class="card-header card-header-icon" data-background-color="rose">
			            <i class="material-icons">settings</i>
			        </div>
        			<div class="card-content">
	            		<h4 class="card-title">Your personal settings</h4>
	        			<div class="row">
		                    <div class="col-md-6">
		                        <div class="form-group label-floating">
		                            <select id="country" class="form-control" name="timezone" data-style="btn btn-primary" title="Your Timezone">
			                            @if ($settings && $settings->timezone)
			                                <option disabled selected> Your timezone</option>
			                                <option value="{{ $settings->timezone }}" selected> {{ $settings->timezone }}</option>
			                                @include('user.timezoneOptions')
			                            @else
			                                <option disabled selected> Your timezone</option>
			                                @include('user.timezoneOptions')
			                            @endif
			                        </select>
		                        </div>
		                        <div class="form-group label-floating">
		                            <select id="country" class="selectpicker" name="unit" data-style="btn btn-primary" title="Prefered Unit">
		                                <option disabled selected> Prefered units</option>
			                            @if ($settings && $settings->unit)
			                                @if ($settings->unit == 'Imperial')
			                                	<option value="Imperial" selected> Imperial (pounds)</option>
		                            			<option value="Metric"> Metric (kilograms)</option>
			                                @else
				                            	<option value="Metric" selected> Metric (kilograms)</option>
				                            	<option value="Imperial"> Imperial (pounds)</option>
			                            	@endif
			                           	@else
			                           		<option value="Imperial" selected> Imperial (pounds)</option>
		                        			<option value="Metric"> Metric (kilograms)</option>
			                            @endif
			                        </select>
		                        </div>
		                    </div>
		                    <div class="col-md-6">
		                        <div class="form-group label-floating">
		                            <div class="togglebutton">
										<label>
											@if ($settings)
												@if ($settings->recap === 1)
									    			<input name="recap" type="checkbox" checked="">
												@else
									    			<input name="recap" type="checkbox">
												@endif
											@else
												{{-- Becayse the std value is 1 --}}
												<input name="recap" type="checkbox" checked="">
											@endif
											Show recap after workout
										</label>
									</div>
		                        </div>

		                        <div class="form-group label-floating">
		                            <div class="togglebutton">
										<label>
											@if ($settings)
												@if ($settings->share_workouts === 1)
									    			<input name="share_workouts" type="checkbox" checked="">
												@else
									    			<input name="share_workouts" type="checkbox">
												@endif
											@else
												<input name="share_workouts" type="checkbox">
											@endif
											Let friends see your workout activity
										</label>
									</div>
		                        </div>

		                        <div class="form-group label-floating">
		                            <div class="togglebutton">
										<label>
											@if ($settings)
												@if ($settings->accept_friends === 1)
									    			<input name="accept_friends" type="checkbox" checked="">
												@else
									    			<input name="accept_friends" type="checkbox">
												@endif
											@else
												<input name="accept_friends" type="checkbox">
											@endif
											Let others send you friend requests
										</label>
									</div>
		                        </div>
		                    </div>
		            	</div>
		                <button type="submit" class="btn btn-rose pull-right">Update Settings</button>
		                <div class="clearfix"></div>
		            </div>
            	</form>
        	</div>
    	</div>

    	<div class="col-md-5">
    		<form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                {{ csrf_field() }}

                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="rose">
			            <i class="material-icons">lock</i>
			        </div>
                    <div class="card-content">
                    	<h4 class="card-title">Change Password <small>Not yet implemented</small></h4>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>

                            <div class="form-group label-floating {{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control" name="password" required autofocus placeholder="New Password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock_outline</i>
                            </span>
                            <div class="form-group label-floating{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
	                    <button type="submit" class="btn btn-rose pull-right disabled">Change Password</button>
		                <div class="clearfix"></div>
                    </div>
                </div>
            </form>
    	</div>
    </div>

@endsection
@section('script')

@endsection