<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\LawyerComment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class LawyerCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getComment($id)
    {
        return $this->jsonResponse(LawyerComment::select(
            'lc1.lawyer_comment_id',
            'lc1.lawyer_comment',
            'lc1.lawyer_comment_date',
            'lc1.lawyer_id',
            'lawyers.name',
            'lawyers.url',
            'lawyers.img',
        )
            ->from('lawyer_comments as lc1')
            ->where('lc1.slander_id', $id)
            ->leftJoin('lawyers', 'lc1.lawyer_id', '=', 'lawyers.lawyer_id')
            ->orderBy('lawyer_comment_date', 'asc')
            ->get());
    }
    public function getLawyerComment($id)
    {
        return $this->jsonResponse(LawyerComment::select(
            'lawyer_comment_id',
            'lawyer_comment',
            'lawyer_comment_date',
            'lawyer_id',
        )
            ->where('lawyer_id', $id)
            ->orderBy('lawyer_comment_date', 'desc')
            ->get());
    }
    public function searchLawyerComment($id, $search)
    {
        if ($search == "all")
            return $this->jsonResponse(LawyerComment::select(
                'lawyer_comment_id',
                'lawyer_comment',
                'lawyer_comment_date',
                'lawyer_id',
            )
                ->where('lawyer_id', $id)
                ->orderBy('lawyer_comment_date', 'desc')
                ->get());
        else
            return $this->jsonResponse(LawyerComment::select(
                'lawyer_comment_id',
                'lawyer_comment',
                'lawyer_comment_date',
                'lawyer_id',
            )
                ->orWhere('slander_id', $search)
                ->orWhere('lawyer_comment', 'like', "%$search%")
                ->where('lawyer_id', $id)
                ->orderBy('lawyer_comment_date', 'desc')
                ->get());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        LawyerComment::insert([
            'slander_id' => $request->slander_id,
            'lawyer_id' => $request->lawyer_id,
            'lawyer_comment' => $request->lawyer_comment,
            'lawyer_comment_date' => $request->lawyer_comment_date,
        ]);
        return $this->jsonResponse(LawyerComment::select(
            'lc1.lawyer_comment',
            'lc1.lawyer_comment_date',
            'lc1.lawyer_id',
            'lawyers.name',
            'lawyers.url',
            'lawyers.img',
        )
            ->from('lawyer_comments as lc1')
            ->where('lc1.slander_id', $request->slander_id)
            ->leftJoin('lawyers', 'lc1.lawyer_id', '=', 'lawyers.lawyer_id')
            ->orderBy('lawyer_comment_date', 'asc')
            ->get());
    }

    /**
     * Display the specified resource.
     */
    public function show(LawyerComment $lawyerComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LawyerComment $lawyerComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request)
    {
        LawyerComment::where('lawyer_comment_id', $request->lawyer_comment_id)
            ->delete();
    }
}