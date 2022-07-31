<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
      <div class="row justify-content-center align-items-center" >
        <div class="col-2 p-0 m-0"><img src="/images/logo.png" class=" d-inline-block align-top" width="30" height="30"></div> 
        <div class="col-10 px-2 m-0 text-start">The Crazy Chef</div>
      </div>  
    </a>
    <div class="offcanvas offcanvas-start bg-dark text-white fs-3" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">The Crazy Chef</h5>
        <i type="button" class="bi bi-x-circle text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></i>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/dashboard"><i class="bi bi-bar-chart-line-fill me-4"></i>Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href=""><i class="bi bi-calendar-event me-4"></i>Reservations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href=""><i class="bi bi-bag-check me-4"></i>Orders</a>
          </li>
            <li class="nav-item">
              <a class="nav-link" href="">
                <i class="bi bi-box-arrow-left me-4"></i>
              </a>
            </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
