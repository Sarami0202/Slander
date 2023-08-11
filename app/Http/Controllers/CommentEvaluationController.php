<?php

namespace App\Http\Controllers;

use App\Models\CommentEvaluation;
use Illuminate\Http\Request;
use App\Models\Comment;

use Illuminate\Support\Facades\DB;

class CommentEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function all()
    {
        return $this->jsonResponse(CommentEvaluation::all());
    }

    /**
     * Store a newly created resource in storage.
     */public function create(Request $request)
    {
        $ip = $request->ip();
        $timestamp = $request->ua;
        $secret = "ojsdalifhjowahpsdj";
        $id_hash = hash_hmac("sha1", $timestamp . $ip, $secret);
        $id_base64 = base64_encode($id_hash);
        $user_id = substr($id_base64, 0, 8);

        $check = CommentEvaluation::select('*')
            ->where('comment_id', $request->comment_id)
            ->where('user_id', $user_id)
            ->get();

        if (!empty($check))
            CommentEvaluation::where('comment_id', $request->comment_id)
                ->where('user_id', $user_id)
                ->delete();

        CommentEvaluation::insert([
            'slander_id' => $request->slander_id,
            'comment_id' => $request->comment_id,
            'user_id' => $user_id,
            'type' => $request->type,
            'comment_evaluation_date' => $request->comment_evaluation_date,
        ]);
        $sort = [['order' => 'good_count', 'sort' => 'desc'], ['order' => 'c1.comment_date', 'sort' => 'desc']];

        if ($request->select == 0)
            return $this->jsonResponse(Comment::select(
                'c1.comment_id',
                'c1.name',
                'c1.comment',
                'c1.user_id',
                'c1.comment_date',
                DB::raw('(SELECT COUNT(*) FROM comments AS c2 WHERE c1.comment_id = c2.connection) as connect_count'),
                DB::raw('(SELECT COUNT(*) FROM comment_evaluations AS ce1 WHERE c1.comment_id = ce1.comment_id AND ce1.type = 0) as good_count'),
                DB::raw('(SELECT COUNT(*) FROM comment_evaluations AS ce1 WHERE c1.comment_id = ce1.comment_id AND ce1.type = 1) as bad_count')
            )
                ->from('comments as c1')
                ->where('c1.slander_id', $request->slander_id)
                ->where('c1.connection', 0)
                ->orderBy($sort[$request->order]['order'], $sort[$request->order]['sort'])
                ->limit(20)
                ->get());
        else
            return $this->jsonResponse(Comment::select(
                'c1.comment_id',
                'c1.name',
                'c1.comment',
                'c1.user_id',
                'c1.comment_date',
                DB::raw('(SELECT COUNT(*) FROM comment_evaluations AS ce1 WHERE c1.comment_id = ce1.comment_id AND ce1.type = 0) as good_count'),
                DB::raw('(SELECT COUNT(*) FROM comment_evaluations AS ce1 WHERE c1.comment_id = ce1.comment_id AND ce1.type = 1) as bad_count')
            )
                ->from('comments as c1')
                ->where('c1.connection', $request->select_id)
                ->orderBy('c1.comment_date', 'asc')
                ->get());
    }


    /**
     * Display the specified resource.
     */
    public function show(CommentEvaluation $commentEvaluation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommentEvaluation $commentEvaluation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request)
    {
        $ip = $request->ip();
        $timestamp = $request->ua;
        $secret = "ojsdalifhjowahpsdj";
        $id_hash = hash_hmac("sha1", $timestamp . $ip, $secret);
        $id_base64 = base64_encode($id_hash);
        $user_id = substr($id_base64, 0, 8);

        CommentEvaluation::where('comment_id', $request->comment_id)
            ->where('type', $request->type)
            ->where('user_id', $user_id)
            ->delete();

        $sort = [['order' => 'good_count', 'sort' => 'desc'], ['order' => 'c1.comment_date', 'sort' => 'desc']];

        if ($request->select == 0)
            return $this->jsonResponse(Comment::select(
                'c1.comment_id',
                'c1.name',
                'c1.comment',
                'c1.user_id',
                'c1.comment_date',
                DB::raw('(SELECT COUNT(*) FROM comments AS c2 WHERE c1.comment_id = c2.connection) as connect_count'),
                DB::raw('(SELECT COUNT(*) FROM comment_evaluations AS ce1 WHERE c1.comment_id = ce1.comment_id AND ce1.type = 0) as good_count'),
                DB::raw('(SELECT COUNT(*) FROM comment_evaluations AS ce1 WHERE c1.comment_id = ce1.comment_id AND ce1.type = 1) as bad_count')
            )
                ->from('comments as c1')
                ->where('c1.slander_id', $request->slander_id)
                ->where('c1.connection', 0)
                ->orderBy($sort[$request->order]['order'], $sort[$request->order]['sort'])
                ->limit(20)
                ->get());
        else
            return $this->jsonResponse(Comment::select(
                'c1.comment_id',
                'c1.name',
                'c1.comment',
                'c1.user_id',
                'c1.comment_date',
                DB::raw('(SELECT COUNT(*) FROM comment_evaluations AS ce1 WHERE c1.comment_id = ce1.comment_id AND ce1.type = 0) as good_count'),
                DB::raw('(SELECT COUNT(*) FROM comment_evaluations AS ce1 WHERE c1.comment_id = ce1.comment_id AND ce1.type = 1) as bad_count')
            )
                ->from('comments as c1')
                ->where('c1.connection', $request->select_id)
                ->orderBy('c1.comment_date', 'asc')
                ->get());
    }
}