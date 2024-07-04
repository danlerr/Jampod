{include file="Smarty/templates/header.tpl"}



<div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Account Settings
                </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card">
              <div class="row g-0">
                <div class="col-12 col-md-3 border-end">
                  <div class="card-body">
                    
                    <div class="list-group list-group-transparent">
                      <a href="./settings.html" class="list-group-item list-group-item-action d-flex align-items-center active">My Account</a>
                      <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">My Credit Cards</a>
                      
                    </div>
                    
                  </div>
                </div>
                <div class="col-12 col-md-9 d-flex flex-column">
                  <div class="card-body">
                    <h2 class="mb-4">My Account</h2>
                    <h3 class="card-title">Profile Details</h3>
                    <h3 class="card-title mt-4">Email</h3>
                    <div>
                      <div class="row g-2">
                        <div class="col-auto">
                          <input type="text" class="form-control w-auto" value="leonpastorelli@gmail.com">
                        </div>
                        <div class="col-auto"><a href="#" class="btn">
                            Change
                          </a></div>
                      </div>
                    </div>
                    <h3 class="card-title mt-4">Username</h3>
                    <div>
                      <div class="row g-2">
                        <div class="col-auto">
                          <input type="text" class="form-control w-auto" value="leonpastorelli">
                        </div>
                        <div class="col-auto"><a href="#" class="btn">
                            Change
                          </a></div>
                      </div>
                    </div>
                    <h3 class="card-title mt-4">Password</h3>
                    <div>
                      <a href="#" class="btn">
                        Set new password
                      </a>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>


{include file="Smarty/templates/footer.tpl"}