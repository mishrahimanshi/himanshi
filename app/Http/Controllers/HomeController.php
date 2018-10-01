<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use App\UserSkill;
use App\JobSkill;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){

            $userid = Auth::user()->id;
            // Authentication passed...



          //  $user_info = DB::select(DB::raw("SELECT `s`.`id` FROM `users` AS u JOIN `userskills` AS us ON `u`.`id` = `us`.`user_id` JOIN `skills` AS s ON (`us`.`skills_id` = `s`.`parent_id` OR `us`.`skills_id` = `s`.`id`) WHERE `u`.`id` =$userid "));

            //  $related_skills = DB::table('skills')->whereIn('parent_id',$user_info)->get();
            $user_info = User::query()
                    ->join('userskills', 'users.id', 'userskills.user_id')
                    ->join('skills', function ($query){
                        $query->on("userskills.skills_id","=", "skills.parent_id");
                        $query->orOn("userskills.skills_id","=", "skills.id");
                    })
                ->where('users.id', "=", $userid)->get(["skills.id"]);
            ;
            #dd($new_user_info);


            $skills= array();
            foreach ($user_info as $key){
                $skills[] = $key->id;
            }



            //$jobs = DB::select(DB::raw("SELECT DISTINCT `jobs_skills`.`job_id`,`jobs`.`id`,`jobs`.`job_title`,`jobs`.`job_description`,`jobs`.`company_name`,`jobs`.`location` FROM `jobs_skills` INNER JOIN `jobs` ON `jobs_skills`.`job_id` = `jobs`.`id` WHERE `jobs_skills`.`skills_id` IN ('".$skills."')"));

          /*  $new_jobs = Job::query()
                        ->join('jobs_skills', 'jobs_skills.job_id', 'jobs.id')
                ->whereIn('jobs_skills.skills_id', $skills)->distinct()->get(
                    [
                        'jobs_skills.job_id',
                        'jobs.id',
                        'jobs.job_title',
                        'jobs.job_description',
                        'jobs.company_name',
                        'jobs.location'
                    ]
                )
            ;*/

            $new_jobs = Job::query()
                    ->whereHas("jobskills", function($query) use ($skills){
                        $query->whereIn('skills_id', $skills);
                    })
                ->distinct()->get(
                    [
                        'jobs.id',
                        'jobs.job_title',
                        'jobs.job_description',
                        'jobs.company_name',
                        'jobs.location'
                    ]
                );

            return view('home')->with('job',$new_jobs);
        }else{
            return back();
        }

    }
}
