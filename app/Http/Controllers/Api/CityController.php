<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');
        $form = collect($request->input('form'))->pluck('value', 'name');

        $options = City::query();

        // if no category has been selected, show no options
        if (! isset($form['state_id']) || empty($form['state_id'])) {
            return [];
        }

        // if a category has been selected, only show articles in that category
        if ($form['state_id']) {
            $options = $options->where('state_id', $form['state_id']);
        }

        if ($search_term) {
            return $options->where('name', 'like', '%' . strtoupper($search_term) . '%')
                ->orderBy('name')
                ->paginate(10);
        }

        return $options->paginate(10);
    }
    public function show($id)
    {
        return City::find($id);
    }


}
