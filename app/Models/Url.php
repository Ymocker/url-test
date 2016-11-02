<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Url extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'url_link';

    /**
     * Parces provided URL
     *
     * @param string $inUrl (URL for analysing)
     * @return array for record to the DB
     */
    public function parceString($inUrl) {
        $siteContent = @file_get_contents($inUrl);
        if ($siteContent === FALSE) {
            return $siteContent;
        }

        $workArr = explode('<a href="', $siteContent);
        array_shift($workArr);
        $scanTime = Carbon::now();

        $recordArr = Array();
        $allRecordArr = Array();

        foreach ($workArr as $value) {
            $recordArr['page_url'] = $inUrl;

            $linkHref = strstr($value, '"', TRUE);
            if ($linkHref=='') { $linkHref = 'Empty';}
            $recordArr['link_url'] = $linkHref;

            $linkText = strstr($value, '>');
            $linkText = substr($linkText, 1);
            $linkText = strstr($linkText, '</a>', TRUE);
            $recordArr['link_name'] = $linkText;

            $recordArr['created_at'] = $scanTime;
            $allRecordArr[] = $recordArr;
            unset($recordArr);
        }
        return $allRecordArr;
    }
}
