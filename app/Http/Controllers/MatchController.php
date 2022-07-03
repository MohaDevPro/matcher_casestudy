<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\SearchProfile;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class MatchController extends ApiController
{
    public function list_search_profiles()
    {
        return SearchProfile::first();
    }

    public function list_properties()
    {
        return Property::all();
    }

    public function searchSuitedProfiles($id)
    {

        //get requested property first
        $property = Property::find($id);
        if (!is_null($property)) {
            // get searchprofile based on property type id;
            $result_searchprofiles = SearchProfile::searchProfileBypropertyType($property->property_type_id)->get();
            //decalre result array
            $list_result = [];
            // loop over searchProfiles to check
            foreach ($result_searchprofiles as $item) {
                $count_matching_keys = 0; // count how many keys matched through the following comparison conditions if this value equal to search profile fields
                $strict_match_count = 0;  // count number of strict match
                $loose_match_count = 0;  // count number of loose match
                // check if all searchfields keys exist in propertyfields and no miss match
                
                $differences_keys = array_diff_key($item->getSearchProfileFields(), $property->getPropertyFields());
                if (count($differences_keys) == 0) {
                    foreach ($item->searchFields as $key => $value) {
                        //check if the current value is range ( array for sure )
                        if (is_array($value)) {
                            // we need to check if it's digit because it may contain null value
                            $min = ctype_digit($value[0]) ? intval($value[0]) : $value[0];
                            $max = ctype_digit($value[1]) ? intval($value[1]) : $value[1];
                            /***
                             * if nor minimum and maximum values are null then we have two options :
                             *  - check if the property key value in the range then it's strict , so we will increment strict count variable by 1 and matching count by 1
                             *  - if the property value isn't in the range, so we want to calculate 25% diviation for min and max values ( then subtract values from minimum and add to maximum )
                             *  then we will check if the propert value is in the range , so it's loose value and we will increment loose count variable by 1 and matching count by 1
                            */
                            if (!is_null($min) && !is_null($max)) {
                                if ($property->getPropertyFields()[$key] >= $min && $property->getPropertyFields()[$key] <= $max) {
                                    $count_matching_keys++;
                                    $strict_match_count++;
                                } else {
                                    //if value is not in the range here will see the strict and loose
                                    // $diviation25 = 0.25;
                                    $min -= ($min * 0.25);
                                    $max += ($max * 0.25);
                                    if ($property->getPropertyFields()[$key] >= $min && $property->getPropertyFields()[$key] <= $max) {
                                        $count_matching_keys++;
                                        $loose_match_count++;
                                    }
                                }
                            }
                             /***
                             * if it's range but this time minimum or maximum value are null then :
                             *  - check if the minimum is null so it's mean that we can include any value up to $max value
                             *  - else it's mean that we can take any value start from $min value
                            */
                            else {
                                if (is_null($min)) {
                                    if ($property->getPropertyFields()[$key] <= $max) {
                                        $count_matching_keys++;
                                        $strict_match_count++;
                                    }else{
                                        $max += ($max * 0.25);
                                        if ($property->getPropertyFields()[$key] <= $max) {
                                            $count_matching_keys++;
                                            $loose_match_count++;
                                        }

                                    }
                                } else {
                                    if ($property->getPropertyFields()[$key] >= $min) {
                                        $count_matching_keys++;
                                        $strict_match_count++;
                                    }else{
                                    $min -= ($min * 0.25);
                                    if ($property->getPropertyFields()[$key] >= $min) {
                                        $count_matching_keys++;
                                        $loose_match_count++;
                                    }

                                    }
                                }
                            }
                        }
                        //means the value of current search field is not in range so we will just check if the value is equal so we will included other than that it's excluded/skipped
                        else {
                            if ($property->getPropertyFields()[$key] == $value)
                                $count_matching_keys++;
                                $strict_match_count++;
                        }
                    }
                    // at final we will check if count of search fields is equal with our counter so we will add it to our result array
                    if ($count_matching_keys == count($item->searchFields)) {
                        // $search_field_type[] = [$key => gettype($value)]; //try
                        if($count_matching_keys==0){
                            $count_matching_keys=1;
                        }
                        $list_result[] = [
                            "searchProfileId" => $item->id,
                            // "searchFields" => $item->searchFields, // added for check only
                            "score" => ($count_matching_keys - $loose_match_count) / $count_matching_keys *100, // ( sum matching counts )
                            "strictMatchesCount" => $strict_match_count,
                            "looseMatchesCount" => $loose_match_count
                            //  "search_field_type" => $search_field_type  // added for check only
                        ];
                    }
                }
            }
            // print_r($list_result);
            // order the result by score in decending order ( higher score )
            return $this->successResponse(collect($list_result)->sortByDesc('score')->values());
        } else {
            return $this->errorResponse(404,'Property value not found');
        }
    }
}
