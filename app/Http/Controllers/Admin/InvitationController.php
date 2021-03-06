<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserInvited;
use App\Http\Requests\StoreUserRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvitationController extends Controller
{
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('backend.users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreUserRequest $request)
	{
		$user = User::create($request->all());

		// For now - all users are admins
		$user->assign('admin');

		event( new UserInvited($user));

		return redirect()->route('admin.user.index');
	}

	public function resend(User $user)
	{
		event( new UserInvited($user));

		session()->flash('success', 'Invitation has been resent to ' . $user->email );

		return redirect()->back();


	}
}
