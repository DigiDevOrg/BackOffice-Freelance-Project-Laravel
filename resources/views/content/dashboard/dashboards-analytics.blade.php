@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')

<div class="row">
  <div class="col-lg-8 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          
          <div class="card-body">
            <h5 class="card-title text-primary">Congratulations {{ $name }}! 🎉</h5>
            <p class="mb-4">You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in your profile.</p>
            <form action="{{ route('logout') }}" method="POST">
              @csrf

              <button type="submit" class="btn btn-sm btn-outline-primary">Logout</button>
          </form>
           
          </div>
          
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img src="{{asset('assets/img/illustrations/man-with-laptop-light.png')}}" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2 ">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between pb-0">
        <div class="card-title mb-0">
          <h5 class="m-0 me-2">Order Statistics</h5>
          <small class="text-muted">42.82k Total Sales</small>
        </div>
        <div class="dropdown">
          <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column align-items-center gap-1">
                <h2 class="mb-2">8,258</h2>
                <span>Your Services</span>
            </div>
            <div id="orderStatisticsChart"></div>
        </div>
        <ul class="p-0 m-0">
          @foreach ($services as $service)
          <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"><i class='bx bx-mobile-alt'></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                      <h6 class="mb-0">{{ $service->title }}</h6>
                      <small class="text-muted">{{ $service->description }}</small>
                  </div>
                  <div class="user-progress">
                      <small class="fw-semibold">{{ $service->average_rating }}</small>
                      <div class="btn-group">
                        <a href="{{ route('edit-service', ['id' => $service->id]) }}" class="btn btn-sm btn-info">Edit</a>
                          <form action="{{ route('service.destroy', $service->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                      </form>

                    </div>                
                  </div>
                  @endforeach
                  @foreach ($services as $service)

                  <div class="modal fade" id="editModal-{{ $service->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true"> 
                    <div class="card mb-4">
                          
                           <div class="card-body">
                              <form method="POST" action="{{ route('services.store') }}">
                                  @csrf
                  
                                  <div class="mb-3">
                                      <label class="form-label" for="title">Title</label>
                                      <input type="text" class="form-control" id="title" name="title" placeholder="Service Title" required />
                                  </div>
                  
                                  <div class="mb-3">
                                      <label class="form-label" for="description">Description</label>
                                      <textarea class="form-control" id="description" name="description" placeholder="Service Description" required></textarea>
                                  </div>
                  
                                  <div class="mb-3">
                                      <label class="form-label" for="price">Price</label>
                                      <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Service Price" required />
                                  </div>
                  
                                  <div class="mb-3">
                                      <label class="form-label" for="delivery_time">Delivery Time (in days)</label>
                                      <input type="number" class="form-control" id="delivery_time" name="delivery_time" placeholder="Delivery Time" required />
                                  </div>
                  
                                  <div class="mb-3">
                                      <label class="form-label" for="category_id">Category</label>
                                      <select class="form-select" id="category_id" name="category_id" required>
                                          <option value="">Select a category</option>
                                          @foreach ($categories as $category)
                                              <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <input type="hidden" name="user_id" value="15" />
                  
                                  <button type="submit" class="btn btn-primary">Create Service</button>
                              </form>
                          </div> 
                      </div>
                </div>
                @endforeach

                @foreach ($services as $service)
<div class="modal fade" id="deleteModal-{{ $service->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  
              </div>
          </li>
          @endforeach
      </ul>
      
    </div>
    
    </div>
  </div>
  <!--/ Total Revenue -->
  <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
    <div class="row">
      <div class="col-6 mb-4">
       <!-- We can add somthing here in the top right section of the landing page -->
      </div>
      <div class="col-6 mb-4">
       <!-- We can add somthing here in the top right section of the landing page -->
      </div>
      <!-- </div>
    <div class="row"> -->
    </div>
  </div>
  
  <div class="col-md-6 col-lg-4 col-xl-8 order-0 mb-4">
    <div class="card mb-4">
       
        <div class="card-body">
            <form method="POST" action="{{ route('services.store') }} " enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Service Title" required />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Service Description" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="price">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Service Price" required />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="delivery_time">Delivery Time (in days)</label>
                    <input type="number" class="form-control" id="delivery_time" name="delivery_time" placeholder="Delivery Time" required />
                </div>

                <div class="mb-3">
    <label class="form-label" for="category_id">Category</label>
    <select class="form-select" id="category_id" name="category_id" required>
        <option value="">Select a category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>
                <div class="mb-3">
                  <label class="input-group-text " for="inputGroupFile01">Image</label>
                  <input type="file" class="form-control" id="inputGroupFile01"  name="image">
                </div>
                
                
                <div class="mb-3">
                  <label class="input-group-text" for="attachments">Attachments</label>
                  <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
              </div>
              <br>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />

                <button type="submit" class="btn btn-primary">Create Service</button>
            </form>
        </div>
    </div>
</div>


</div>
<div class="row">
  
  <!--/ Transactions -->
</div>

<div class="modal" id="infos">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Plus d'informations</h4>
      </div>
      <div class="modal-body">
        Le Tigre (Panthera tigris) est un mammifère carnivore de la famille des félidés...
      </div>
      <div class="modal-footer">
        <em>Informations sous réserve</em>
      </div>
    </div>
  </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#category_id').on('change', function () {
        var categoryId = $(this).val();
        if (categoryId) {
            $.ajax({
                type: 'GET',
                url: '/get-skills/' + categoryId, 
                success: function (data) {
                    console.log(data.key) ;
                    var skillsDropdown = $('#skills');
                    skillsDropdown.empty();
                    $.each(data, function (key, value) {
                        skillsDropdown.append($('<option>', {
                            value: key,
                            text: value
                        }));
                    });
                },
                error: function () {
                    alert('Failed to fetch skills.');
                }
            });
        } else {
            $('#skills').empty();
        }
    });
});
</script> -->

@endsection
