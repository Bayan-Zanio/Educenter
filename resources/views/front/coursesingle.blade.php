<x-front-layout>

  <section class="section-sm">
    <div class="container">
      <div class="row">
        <div class="col-12 mb-4">
          <!-- course thumb -->
          <img src="images/courses/course-single.jpg" class="img-fluid w-100">
        </div>
      </div>
      <!-- course info -->
      
      <div class="row align-items-center mb-5">
      
        <div class="col-xl-3 order-1 col-sm-6 mb-4 mb-xl-0">
          <h2>{{ $course->name }}</h2>
        </div>
        <div class="col-xl-6 order-sm-3 order-xl-2 col-12 order-2">
          <ul class="list-inline text-xl-center">
            <li class="list-inline-item mr-4 mb-3 mb-sm-0">
              <div class="d-flex align-items-center">
                <i class="ti-book text-primary icon-md mr-2"></i>
              </div>
            </li>
            <li class="list-inline-item mr-4 mb-3 mb-sm-0">
              <div class="d-flex align-items-center">
                <i class="ti-alarm-clock text-primary icon-md mr-2"></i>
                <div class="text-left">
                  <h6 class="mb-0">DURATION</h6>
                  <p class="mb-0">{{ $course->duration }}</p>
                </div>
              </div>
            </li>
            <li class="list-inline-item mr-4 mb-3 mb-sm-0">
              <div class="d-flex align-items-center">
                <i class="ti-wallet text-primary icon-md mr-2"></i>
              </div>
            </li>
          </ul>
        </div>
        <div class="col-xl-3 text-sm-right text-left order-sm-2 order-3 order-xl-3 col-sm-6 mb-4 mb-xl-0">
          <a href="#" class="btn btn-primary">Apply now</a>
        </div>
        <!-- border -->
        <div class="col-12 mt-4 order-4">
          <div class="border-bottom border-primary"></div>
        </div>
        
      </div>
      
    </div>
  </section>

  </x-front-layout>