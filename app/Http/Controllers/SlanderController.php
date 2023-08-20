<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentEvaluation;
use App\Models\Preview;
use App\Models\Report;
use App\Models\Slander;
use App\Models\SlanderEvaluation;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class SlanderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        return $this->jsonResponse(Slander::select(
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
        $data = Slander::select(
            '*',
            DB::raw('(SELECT COUNT(*) FROM comments AS c1 WHERE s1.slander_id = c1.slander_id) as comment_count'),
            DB::raw('(SELECT COUNT(*) FROM slanders AS s2 WHERE s1.slander_id = s2.connection AND s2.view = 1) as connection_count'),
            DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0) as good_count'),
            DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 1) as bad_count')
        )
            ->from('slanders as s1')
            ->where('slander_id', $id)
            ->where('view', 1)
            ->first();
        if ($data != null)
            Preview::insert([
                'slander_id' => $id,
                'preview_date' => date('Y-m-d H:i:s')
            ]);

        return $this->jsonResponse([$data]);
    }

    public function preview_all()
    {
        return $this->jsonResponse(Preview::all());
    }
    public function search($id)
    {
        return $this->jsonResponse(Slander::select('*')
            ->orWhere('slander_id', $id)
            ->orWhere('title', $id)
            ->orWhere('victim', $id)
            ->orWhere('perpetrator', $id)
            ->get());
    }

    public function getNewSlander($num)
    {
        return $this->JsonResponse(Slander::select(
            'slander_id',
            'img',
            'platform',
            'title',
            'perpetrator',
            'victim',
            DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id) as preview_count'),
            DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0 ) as good_count'),
        )
            ->from('slanders as s1')
            ->where('view', 1)
            ->groupBy('slander_id', 'img', 'platform', 'title', 'perpetrator', 'victim', 'preview_count', 'good_count')
            ->orderBy('slander_date', 'desc')
            ->limit($num)
            ->get());
    }

    public function getNewAllSlander($num, $page)
    {
        $date = date('Y-m-d', strtotime("-1 year"));
        $count = Slander::select(
            'slander_id'
        )
            ->where('slander_date', '>', $date)
            ->where('view', 1)
            ->count();
        return [
            'count' => $count,
            'data' => $this->JsonResponse(Slander::select(
                'slander_id',
                'img',
                'platform',
                'title',
                'perpetrator',
                'victim',
                DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id) as preview_count'),
                DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0 ) as good_count'),
            )
                ->from('slanders as s1')
                ->where('view', 1)
                ->groupBy('slander_id', 'img', 'platform', 'title', 'perpetrator', 'victim', 'preview_count', 'good_count')
                ->orderBy('slander_date', 'desc')
                ->offset($num * ($page - 1))
                ->limit($num)
                ->get())
        ];
    }

    public function getMonthSlander($num)
    {
        $date = date('Y-m-d', strtotime("-1 month"));

        return $this->JsonResponse(Slander::select(
            'slander_id',
            'img',
            'platform',
            'title',
            'perpetrator',
            'victim',
            DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id) as preview_count'),
            DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0 ) as good_count'),
            DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0 AND se1.slander_evaluation_date>="' . $date . '") as month_good_count'),
        )
            ->from('slanders as s1')
            ->where('s1.view', 1)
            ->groupBy('s1.slander_id', 's1.img', 's1.platform', 's1.title', 's1.perpetrator', 's1.victim', 'good_count', 'month_good_count')
            ->orderBy('month_good_count', 'desc')
            ->limit($num)
            ->get());
    }

    public function getMonthAllSlander($num, $page)
    {
        $date = date('Y-m-d', strtotime("-1 month"));
        $count = Slander::select(
            'slander_id'
        )
            ->where('slander_date', '>', $date)
            ->where('view', 1)
            ->count();
        return [
            'count' => $count,
            'data' => $this->JsonResponse(Slander::select(
                'slander_id',
                'img',
                'platform',
                'title',
                'perpetrator',
                'victim',
                DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id) as preview_count'),
                DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0 ) as good_count'),
                DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0 AND se1.slander_evaluation_date>="' . $date . '") as month_good_count'),
            )
                ->from('slanders as s1')
                ->where('s1.view', 1)
                ->groupBy('s1.slander_id', 's1.img', 's1.platform', 's1.title', 's1.perpetrator', 's1.victim', 'good_count', 'month_good_count')
                ->orderBy('month_good_count', 'desc')
                ->offset($num * ($page - 1))
                ->limit($num)
                ->get())
        ];
    }

    public function getPreviewSlander($num)
    {
        $date = date('Y-m-d h:i:s', strtotime("-1 day"));
        return $this->JsonResponse(Slander::select(
            'slander_id',
            'img',
            'platform',
            'title',
            'perpetrator',
            'victim',
            DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id) as preview_count'),
            DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0 ) as good_count'),
            DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id AND p1.preview_date>="' . $date . '") as date_preview_count'),
        )
            ->from('slanders as s1')
            ->where('s1.view', 1)
            ->groupBy('s1.slander_id', 's1.img', 's1.platform', 's1.title', 's1.perpetrator', 's1.victim', 'good_count', 'date_preview_count')
            ->orderBy('date_preview_count', 'desc')
            ->limit($num)
            ->get());
    }

    public function getPreviewAllSlander($num, $page)
    {
        $date = date('Y-m-d h:i:s', strtotime("-1 day"));
        $count = Slander::select(
            'slander_id'
        )
            ->where('slander_date', '>', $date)
            ->where('view', 1)
            ->count();
        return [
            'count' => $count,
            'data' => $this->JsonResponse(Slander::select(
                'slander_id',
                'img',
                'platform',
                'title',
                'perpetrator',
                'victim',
                DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id) as preview_count'),
                DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0 ) as good_count'),
                DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id AND p1.preview_date>="' . $date . '") as date_preview_count'),
            )
                ->from('slanders as s1')
                ->where('s1.view', 1)
                ->groupBy('s1.slander_id', 's1.img', 's1.platform', 's1.title', 's1.perpetrator', 's1.victim', 'good_count', 'date_preview_count')
                ->orderBy('date_preview_count', 'desc')
                ->offset($num * ($page - 1))
                ->limit($num)
                ->get())
        ];
    }

    public function getPreviewMonthSlander($num, $page)
    {
        $date = date('Y-m-d', strtotime("-1 month"));
        $count = Slander::select(
            'slander_id'
        )
            ->where('slander_date', '>', $date)
            ->where('view', 1)
            ->count();
        return [
            'count' => $count,
            'data' => $this->JsonResponse(Slander::select(
                'slander_id',
                'img',
                'platform',
                'title',
                'perpetrator',
                'victim',
                DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id) as preview_count'),
                DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0 ) as good_count'),
                DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id AND p1.preview_date>="' . $date . '") as date_preview_count'),
            )
                ->from('slanders as s1')
                ->where('s1.view', 1)
                ->groupBy('s1.slander_id', 's1.img', 's1.platform', 's1.title', 's1.perpetrator', 's1.victim', 'good_count', 'date_preview_count')
                ->orderBy('date_preview_count', 'desc')
                ->offset($num * ($page - 1))
                ->limit($num)
                ->get())
        ];
    }
    public function getConnection($id)
    {
        return $this->JsonResponse(Slander::inRandomOrder()->select(
            'slander_id',
            'img',
            'platform',
            'title',
            'perpetrator',
            'victim',
            DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id) as preview_count'),
            DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0 ) as good_count'),
        )
            ->from('slanders as s1')
            ->where('connection', $id)
            ->where('view', 1)
            ->groupBy('slander_id', 'img', 'platform', 'title', 'perpetrator', 'victim', 'preview_count', 'good_count')
            ->orderBy('slander_date', 'asc')
            ->limit(5)
            ->get());
    }
    public function getConnection_all($id)
    {
        return $this->JsonResponse(Slander::inRandomOrder()
            ->select(
                'slander_id',
                'img',
                'platform',
                'title',
                'perpetrator',
                'victim',
                DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id) as preview_count'),
                DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0 ) as good_count'),
            )
            ->from('slanders as s1')
            ->where('connection', $id)
            ->where('view', 1)
            ->groupBy('slander_id', 'img', 'platform', 'title', 'perpetrator', 'victim', 'preview_count', 'good_count')
            ->orderBy('slander_date', 'asc')
            ->get());
    }


    public function getConnectionTop($id)
    {
        return $this->JsonResponse(Slander::select(
            'slander_id',
            'img',
            'platform',
            'title',
            'perpetrator',
            'victim',
            DB::raw('(SELECT COUNT(*) FROM previews AS p1 WHERE s1.slander_id = p1.slander_id) as preview_count'),
            DB::raw('(SELECT COUNT(*) FROM slander_evaluations AS se1 WHERE s1.slander_id = se1.slander_id AND se1.type = 0 ) as good_count'),
        )
            ->from('slanders as s1')
            ->where('slander_id', $id)
            ->where('view', 1)
            ->get());
    }
    public function create(Request $request)
    {
        $path = null;
        if ($request['img'] != null) {
            $main_file = $request->file('img');
            $path = isset($main_file) ? $main_file->store('img', 'public') : null;
        }

        $id = Slander::insertGetId([
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

        return $id;
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
    public function viewUpdate(Request $request)
    {
        Slander::where('slander_id', $request->slander_id)->update([
            'view' => $request->view
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Slander::where('slander_id', $request->slander_id)
            ->delete();
        Preview::where('slander_id', $request->slander_id)
            ->delete();
        Comment::where('slander_id', $request->slander_id)
            ->delete();
        CommentEvaluation::where('slander_id', $request->slander_id)
            ->delete();
        SlanderEvaluation::where('slander_id', $request->slander_id)
            ->delete();
        Report::where('slander_id', $request->slander_id)
            ->delete();
    }
}