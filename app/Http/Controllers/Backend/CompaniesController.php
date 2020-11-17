<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Postcode;

class CompaniesController extends Controller
{
    private function getRoute()
    {
        return 'admin.companies';
    }

    /**
     * Validator for user
     *
     * @return \Illuminate\Http\Response
     */
    protected function validator(array $data, $type)
    {
        // Determine if password validation is required depending on the calling
        return Validator::make($data, [
            // 'username' => 'required|string|max:255|unique:users,username,' . $data['id'],
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'postcode' => 'required',
            'prefecture' => 'required',
            'city' => 'required',
            'local' => 'required',
            'image' => 'required'
            // (update: not required, create: required)
            // 'password' => 'string|min:6|max:255',
        ]);
    }

    public function add()
    {
    }

    public function search(Request $request)
    {
        $keyword = $request->input('postcode');
        $postcode = DB::table('postcodes')->where('postcode', 'LIKE', '%' . $keyword . '%')->get();
        // dd($postcode);
        // return view('backend.companies.form')->withPosts($postcode);
        $company = new Company();
        $company->form_action = $this->getRoute() . '.store';
        $company->page_title = 'Company Add Page';
        $company->page_type = 'store';
        return view('backend.companies.form', ['company' => $company, 'postcode' => $postcode]);
    }

    public function index()
    {
        return view('backend.companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $company = new Company();
        $company->form_action = $this->getRoute() . '.create';
        $company->page_title = 'Company Add Page';
        $company->page_type = 'create';
        return view('backend.companies.form', [
            'company' => $company
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = $request->all();
        dd($datas);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
