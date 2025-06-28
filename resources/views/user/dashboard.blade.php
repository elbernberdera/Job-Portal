@extends('user.base.base')


@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <!-- Breadcrumb or other header content can go here -->
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Open Jobs -->
            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $openJobs ?? 0 }}</h3>
                        <p>Open Job Vacancies</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Jobs Applied -->
            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $appliedJobs ?? 0 }}</h3>
                        <p>Jobs You've Applied For</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Jobs Failed -->
            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $failedJobs ?? 0 }}</h3>
                        <p>Applications Failed</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>


      


            <!-- <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User</h3>
                    </div>
                    <div class="card-body">
                        second box
                    </div>
                </div>
            </div> -->


        </div>

        
    </div>
</div>
@endsection
