<?php

namespace App\Http\Controllers;

use App\Models\Slander;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class SlanderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function all()
    {   return $this->jsonResponse(Slander::select(
        '*',
        DB::raw('(SELECT COUNT(*) FROM comments AS c1 WHERE s1.slander_id = c1.slander_id) as comment_count'),
        DB::raw('(SELECT COUNT(*) FROM slanders AS s2 WHERE s1.slander_id = s2.connection AND s2.view = 1) as connection_count'),
        DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0) as good_count'),
        DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 1) as bad_count')
    )
        ->from('slanders as s1')
        ->get());
    }

    public function slander($id)
    {
        return $this->jsonResponse(Slander::select(
            '*',
            DB::raw('(SELECT COUNT(*) FROM comments AS c1 WHERE s1.slander_id = c1.slander_id) as comment_count'),
            DB::raw('(SELECT COUNT(*) FROM slanders AS s2 WHERE s1.slander_id = s2.connection AND s2.view = 1) as connection_count'),
            DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0) as good_count'),
            DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 1) as bad_count')
        )
            ->from('slanders as s1')
            ->where('slander_id', $id)
            ->where('view', 1)
            ->get());
    }


    public function getNewSlander()
    {
        return $this->JsonResponse(Slander::select('slander_id', 'img', 'platform', 'title', 'perpetrator', 'victim')
            ->where('view', 1)
            ->groupBy('slander_id', 'img', 'platform', 'title', 'perpetrator', 'victim')
            ->orderBy('slander_date', 'desc')
            ->limit(5)
            ->get());
    }


    public function getConnection($id)
    {
        return $this->JsonResponse(Slander::inRandomOrder()
            ->select('slander_id', 'img', 'platform', 'title', 'perpetrator', 'victim')
            ->where('connection', $id)
            ->where('view', 1)
            ->groupBy('slander_id', 'img', 'platform', 'title', 'perpetrator', 'victim')
            ->orderBy('slander_date', 'asc')
            ->limit(5)
            ->get());
    }
    public function getConnection_all($id)
    {
        return $this->JsonResponse(Slander::inRandomOrder()
            ->select('slander_id', 'img', 'platform', 'title', 'perpetrator', 'victim')
            ->where('connection', $id)
            ->where('view', 1)
            ->groupBy('slander_id', 'img', 'platform', 'title', 'perpetrator', 'victim')
            ->orderBy('slander_date', 'asc')
            ->get());
    }


    public function create(Request $request)
    {
        $path = null;
        if ($request['img'] != null) {
            $main_file = $request->file('img');
            $path = isset($main_file) ? $main_file->store('img', 'public') : null;
        }

        Slander::insert([
            'img' => $path,
            'platform' => $request->platform,
            'title' => $request->title,
            'url' => $request->url,
            'victim' => $request->victim,
            'perpetrator' => $request->perpetrator,
            'comment' => $request->comment,
            'view' => 1,
            'connection' => $request->connection,
            'slander_date' => $request->slander_date,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Slander $slander)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slander $slander)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slander $slander)
    {
        //
    }
}