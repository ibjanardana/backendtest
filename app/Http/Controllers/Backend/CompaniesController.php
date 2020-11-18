<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Base\Prefecture as BasePrefecture;
use App\Models\Company;
use App\Models\Prefecture;

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

    public function search(Request $request)
    {
        if ($request->input('postcode') == '') {
            $company = new Company();
            $company->form_action = $this->getRoute() . '.store';
            $company->page_title = 'Company Add Page';
            $company->page_type = 'create';
            return view('backend.companies.form', ['company' => $company]);
        } else {
            $keyword = $request->input('postcode');
            $postcode = DB::table('postcodes')->select('postcode', 'prefecture', 'city', 'local')->where('postcode', 'LIKE', '%' . $keyword . '%')->get();
            foreach ($postcode as $key => $value) {
                $prefecture = DB::table('prefectures')->select('id')->where('display_name', 'LIKE', '%' . $value->prefecture . '%')->get();
                foreach ($prefecture as $key => $value) {
                    $prefecture_id = $value->id;
                }
            }
            $company = new Company();
            $company->form_action = $this->getRoute() . '.store';
            $company->page_title = 'Company Add Page';
            $company->page_type = 'store';
            return view('backend.companies.form', [
                'company' => $company,
                'postcode' => $postcode,
                'prefecture_id' => $prefecture_id
            ]);
        }
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
        $companies_id = DB::table('companies')->count();
        $companies_id = $companies_id + 1;

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'prefecture_id' => 'required',
            'postcode' => 'required',
            'city' => 'required|string',
            'local' => 'required|string',
            'image' => 'required|file|image|mimes:jpeg,png,gif,webp|max:5000'
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'image_' . $companies_id . '.' . $extension;
            $file->move('uploads/files/', $filename);
        }
        $postdata = [
            'name' => $request->name,
            'email' => $request->email,
            'prefecture_id' => $request->prefecture_id,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'local' => $request->city,
            'street_address' => $request->input('street_address'),
            'business_hour' => $request->input('business_hour'),
            'regular_holiday' => $request->input('regular_holiday'),
            'image' => $filename,
            'fax' => $request->fax,
            'url' => $request->url,
            'license_number' => $request->license_number,
        ];
        DB::table('companies')->insert($postdata);
        return redirect()->route('admin.companies')->with('success', 'Company Created Successfully');
        // $datas = $request->all();
        // dd($datas);
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
