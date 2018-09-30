@extends('layouts.app')
@section('content')
    <section class="row-section">
    <div class="container">
        <div class="row">
           <h2>Related Job</h2>
        </div>
        <div class="col-md-10 offset-md-1 row-block">
            <ul id="sortable" style="list-style-type:none;padding:10px;">
                @foreach($job as $key)
                <li style="padding: 10px;"><div class="media">
                        <div class="media-left align-self-center">
                            <i class=""></i>
                        </div>
                        <div class="media-body" style="padding: 10px;">
                            <h4>{{$key->job_title}}</h4>
                            <p><strong>Description : </strong>{{$key->job_description}}</p>
                            <span>
                                <h6><strong>Company Name : </strong>{{$key->company_name}} </h6>
                                <h6><strong>Location :</strong> {{$key->location}} </h6>
                            </span>
                        </div>
                        <div class="media-right align-self-center">
                            <a href="#" class="btn btn-primary">Apply Now</a>
                        </div>
                    </div></li>
                    @endforeach
            </ul>
        </div>
    </div>
    </section>

@endsection

