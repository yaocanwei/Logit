<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about/privacy_policy', function() {
	return view('about.privacyPolicy');
});
Route::get('/about/tos', function() {
	return view('about.tos');
});

Auth::routes();

// OAuth Routes
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

Route::get('/register/success', 'Auth\RegisterController@checkEmail');
Route::post('/register/resend', 'Auth\RegisterController@resend');
Route::get('/email-verification/error', 'Auth\RegisterController@getVerificationError')->name('email-verification.error');
Route::get('/email-verification/check/{token}', 'Auth\RegisterController@getVerification')->name('email-verification.check');

Route::group(['middleware' => ['isVerified']], function () {
	/* Dashboard */
	Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');
	Route::get('/api/getSessions/{type}/{year}/{month}', 'DashboardController@getTotalWorkouts');
	Route::get('/api/getAvgGymTime/{type}/{year}/{month}', 'DashboardController@getAvgGymTime');
	Route::get('/api/getMusclegroups/{type}/{year}/{month}', 'DashboardController@getMusclegroups');
	Route::get('/api/getTopExercises/{type}/{year}/{month}', 'DashboardController@getTopExercises');
	Route::get('/api/getExerciseProgress/{type}/{year}/{month}/{exercise}', 'DashboardController@getExerciseProgress');
	Route::get('/api/getCompletionRatio/{type}/{year}/{month}', 'DashboardController@getCompletionRatio');

	/* User/Settings */
	Route::get('/user', 'UserController@myProfile')->name('user');
	Route::post('/user/edit', 'UserController@editProfile');
	Route::get('/user/settings', 'SettingsController@settings')->name('settings');
	Route::post('/user/settings/edit', 'SettingsController@editSettings');
	Route::post('/user/settings/edit/timer', 'SettingsController@timerSettings');
	Route::post('/user/settings/renameExercise', 'SettingsController@renameExercise');
	Route::get('/user/settings/get', 'SettingsController@getSettings');

	/* Friends */
	Route::get('/dashboard/friends', 'FriendsController@viewFriends')->name('friends');
	Route::get('/dashboard/friends/findFriends', 'FriendsController@findFriends');
	Route::get('/dashboard/friends/sendRequest', 'FriendsController@sendRequest');
	Route::get('/dashboard/friends/respondRequest', 'FriendsController@respondRequest');

	/* Friend */
	Route::get('/api/friends/friend/remove', 'FriendController@removeFriend');
	Route::get('/api/friends/friend/populateExercises', 'FriendController@getExercises');
	Route::get('/api/friends/friend/getExerciseData', 'FriendController@getExerciseData');
	Route::get('/api/friends/friend/getSessionData', 'FriendController@getSessionData');
	Route::get('/api/friends/friends/shareRoutine', 'FriendController@shareRoutine');
	Route::get('/dashboard/friends/friend/{friendId}', 'FriendController@viewFriend');


	/* Routines */
	Route::get('/dashboard/my_routines', 'RoutineController@routines')->name('myRoutines');
	Route::get('/dashboard/my_routines/add_routine', 'RoutineController@addRoutine');
	Route::get('/dashboard/my_routines/accept_routine/{routine}', 'RoutineController@acceptRoutine');
	Route::get('/api/routines/preview', 'RoutineController@previewRoutine');

	// Create
	Route::put('/dashboard/my_routines', 'RoutineController@insertRoutine');
	// Read
	Route::get('/dashboard/my_routines/view/{routine}', 'RoutineController@viewRoutine');
	// Update
	Route::post('/dashboard/my_routines/edit/{routine}', 'RoutineController@updateRoutine');
	// Delete
	Route::get('/dashboard/my_routines/delete/{routine}', 'RoutineController@deleteRoutine');
	// Status
	Route::post('/dashboard/my_routines/edit/status/{routine}', 'RoutineController@changeStatus');

	/* Settings */
	Route::get('/dashboard/settings', 'SettingsController@viewSettings');

	/* Measurements */
	Route::get('/dashboard/measurements', 'MeasurementController@measurements')->name('measurements');
	Route::post('/dashboard/measurements/save', 'MeasurementController@saveMeasurements');
	Route::post('/dashboard/measurements/delete', 'MeasurementController@deleteMeasurement');
	Route::get('/dashboard/measurements/get_measurements', 'MeasurementController@getMeasurements');

	/* Workouts */
	Route::get('/dashboard/workouts', 'WorkoutController@viewWorkouts')->name('workouts');
	Route::get('/api/get_workout/view/{workoutId}', 'WorkoutController@getWorkout');
	Route::get('/api/delete_workout/{workout}', 'WorkoutController@deleteWorkout');
	Route::get('/api/update_workout/{workout}', 'WorkoutController@updateWorkout');
	Route::get('/dashboard/start', 'WorkoutController@selectWorkout')->name('startWorkout');
	Route::get('/dashboard/start/{routine}', 'WorkoutController@startWorkout');
	Route::get('/dashboard/workout/finish/{routine_id}', 'WorkoutController@finishWorkout');
	Route::get('/dashboard/workout/recap/{workout}', 'WorkoutController@recap');

	/* Exercises */
	Route::get('/api/exercise/{exerciseId}', 'ExerciseController@getExercise');
	Route::put('/api/exercise/{routineId}/{exerciseId}', 'ExerciseController@addExercise');

	/* API routes */
	Route::get('/clear', 'ApiController@flushSessions');
	Route::post('/api/notifications/check', 'ApiController@checkNotifications');
	Route::post('/api/notifications/clear', 'ApiController@clearNotification');
	Route::get('/api/message/clear', 'ApiController@clearMessage');

	/* Dev/Admin paths */
	Route::get('/admin/showSession', 'DevController@showSession');
	Route::get('/admin', 'DevController@adminPanel');
	Route::post('/admin/newMessage', 'DevController@newMessage');
});
