<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserServicesInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var \App\Services\BaseCrudServicesInterface
     */
    protected $userServices;

    /**
     * Create a new controller instance.
     *
     * @param UserServicesInterface $userServices
     */
    public function __construct(UserServicesInterface $userServices)
    {
        $this->userServices = $userServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listData = $this->userServices->getPaginateWithFilter($request->all());

        return view('admin.users.index', compact('listData', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $this->userServices->create($request->validated());

        return redirect()->route('admin.users.index')
            ->withSuccess(trans('messages.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userServices->read($id);

        if (empty($user)) {
            abort(404);
        }

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userServices->read($id);

        if (empty($user)) {
            abort(404);
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest|Request $request
     * @param int                       $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $this->userServices->update($request->validated(), $id);

        return redirect()->route('admin.users.index')
            ->withSuccess(trans('messages.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userServices->delete($id);

        return redirect()->route('admin.users.index')
            ->withSuccess(trans('messages.delete_success'));
    }
}
