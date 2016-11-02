<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use DB;

/**
 * Class PolosaController
 * @package App\Http\Controllers
 */

class AnalyseController extends Controller
{
    public function index() {
        return view('main', ['data' => NULL]);
    }

    /**
     * Retrieve content of URL, parce and store data
     *
     * @param Request $request
     * @return view with json data for DataTable
     */
    public function analyse(Request $request) {
        $newUrl = new Url;
        $result = $newUrl->parceString($request->url);

        //invalid or unaccessable URL
        if ($result === FALSE) {
            return view('main', ['data' => json_encode('no')]);
        }

        //cannot write data in the DB (data contain non UTF-8)
        if(!$this->store($result)) {
            return view('main', ['data' => json_encode('no')]);
        }

        $jsonResult = $this->retrive();

        return view('main', ['data' => $jsonResult]);
    }

    /**
     * Stores data in the DB
     *
     * @param array $storeArr
     */
    public function store($storeArr) {
        Url::truncate();
        try
        {
            Url::insert($storeArr);
        } catch (\Illuminate\Database\QueryException $e) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Get all records from the DB
     *
     * @return json for DataTable
     */
    public function retrive() {
        $result = Url::all();

        $items = Array();
        $workArr = Array();

        foreach ($result as $row) {
            $workArr[] = $row['page_url'];
            $workArr[] = $row['link_url'];
            $workArr[] = $row['link_name'];
            $workArr[] = $row['created_at']->toDateTimeString();

            $items[] = $workArr;
            unset($workArr);
        }
        return json_encode($items);
    }
}
